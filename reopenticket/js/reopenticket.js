(function () {
    function addButton() {
        const path = window.location.pathname;
        const ticketId = new URLSearchParams(window.location.search).get("id");
    	const target = document.querySelector('.timeline-buttons');
    	
    	if(path !== "/front/ticket.form.php"){return;}
    	if(!ticketId){return;}
    	if(document.getElementById("reopenticket_btn_box")){return;}
    
    	const pageText = document.body ? document.body.innerText.toLowerCase() : "";	
    
    	if(!pageText.includes("chiusa") && !pageText.includes("closed")){return;}
    
        let csrf = "";

        const csrfInput = document.querySelector('input[name="_glpi_csrf_token"]');
        if (csrfInput) {
            csrf = csrfInput.value;
        }

        const form = document.createElement("form");
        form.id = "reopenticket_btn_box";
        form.method = "post";
        form.action = "/plugins/reopenticket/front/reopen.php";

        form.style.position = "fixed";
        form.style.right = "25px";
        form.style.bottom = "25px";
        form.style.zIndex = "999999";
        form.style.background = "white";
        form.style.border = "2px solid #ffc107";
        form.style.borderRadius = "8px";
        form.style.padding = "12px";
        form.style.boxShadow = "0 4px 12px rgba(0,0,0,0.35)";

        form.innerHTML =
            '<input type="hidden" name="tickets_id" value="' + ticketId + '">' +
            '<input type="hidden" name="_glpi_csrf_token" value="' + csrf + '">' +
            '<button type="submit" name="reopen_ticket" class="btn" style="background:#fec95c;color:#232e3c;font-size:16px;padding:10px 25px;font-weight:bold;">Riapri</button>';

        if (target) {
    		form.style.position = "static";
    		form.style.right = "";
    		form.style.bottom = "";
    		form.style.zIndex = "";
    		form.style.background = "";
    		form.style.border = "";
    		form.style.borderRadius = "";
    		form.style.padding = "";
    		form.style.boxShadow = "";

    		target.appendChild(form);
		}

    }

    addButton();
    setTimeout(addButton, 500);
    setTimeout(addButton, 1500);
})();