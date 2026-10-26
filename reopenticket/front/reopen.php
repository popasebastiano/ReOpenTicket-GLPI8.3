<?php

include('../../../inc/includes.php');

global $DB;

Session::checkLoginUser();

$ticket_id = isset($_POST['tickets_id']) ? (int) $_POST['tickets_id'] : 0;

if ($ticket_id <= 0) {
    Session::addMessageAfterRedirect(
        'ID ticket mancante.',
        false,
        ERROR
    );

    Html::back();
}

//Session::checkCSRF($_POST);

$current_user_id = (int) Session::getLoginUserID();

$ticket = new Ticket();

if (!$ticket->getFromDB($ticket_id)) {
    Session::addMessageAfterRedirect(
        'Ticket non trovato.',
        false,
        ERROR
    );

    Html::back();
}

if ((int) $ticket->fields['status'] !== Ticket::CLOSED) {
    Session::addMessageAfterRedirect(
        'Il ticket non è in stato chiuso.',
        false,
        WARNING
    );

    Html::redirect(Ticket::getFormURLWithID($ticket_id));
}

$is_requester = false;

$iterator = $DB->request([
    'FROM'  => 'glpi_tickets_users',
    'WHERE' => [
        'tickets_id' => $ticket_id,
        'users_id'   => $current_user_id,
        'type'       => CommonITILActor::REQUESTER
    ]
]);

foreach ($iterator as $row) {
    $is_requester = true;
    break;
}

if (!$is_requester && !Session::haveRight('ticket', UPDATE)) {
    Session::addMessageAfterRedirect(
        'Non hai i permessi per riaprire questo ticket.',
        false,
        ERROR
    );

    Html::redirect(Ticket::getFormURLWithID($ticket_id));
}

$update_ok = $ticket->update([
    'id'     => $ticket_id,
    'status' => Ticket::ASSIGNED
]);

if ($update_ok) {
    Session::addMessageAfterRedirect(
        'Ticket riaperto correttamente.',
        true,
        INFO
    );
} else {
    Session::addMessageAfterRedirect(
        'Errore durante la riapertura del ticket.',
        false,
        ERROR
    );
}

Html::redirect(Ticket::getFormURLWithID($ticket_id));