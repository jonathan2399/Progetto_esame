//SCRIPT PER LA GESTIONE DEGLI EVENTI NE MOMENTO IN CUI L'UTENTE SI LOGGA
$(document).ready(function(){
	var flag=false;
	//CLICCA SU ACCEDI
	$('#valida').click(function(){
			var button = $(this);
			if ( button.attr("data-dismiss") != "modal"){
				var inputs = $('form input');
				var title = $('.modal-title');
				var progress = $('.progress');
				var progressBar = $('.progress-bar');

				inputs.attr("disabled", "disabled");

				button.hide();

				progress.show();

				progressBar.animate({width : "100%"}, 100);

				progress.delay(1000)
						.fadeOut(600);
			}
			//PRENDE IL VALORE DEI CAMPI
			var username = $('#username').val();
			var password = $('#password').val();
			//CHIAMATA AJAX PER CONTROLLARE SE IL LOGIN E' AVVENUTO OPPURE NO
			$.ajax({
			  method: 'POST',
			  url: './dinamiche/controlla.php',
			  data: {
				valida: 1,
				userPHP: username,
				passPHP: password
			  },

			  success: function(response)
			  {
				//METTE IL VALORE RESTITUITO IN UN DIV HTML
				$("#myModalLabel").html(response);
				var accesso = $("#myModalLabel").text();
				if(accesso.includes("Login riuscito"))
					flag=true;
				if(flag==true){
					//LOGIN E' AVVENUTO CON SUCCESSO
					button.text("Close")
						.removeClass("btn-primary")
						.addClass("btn-success")
						.blur()
						.delay(1600)
						.fadeIn(function(){
							button.attr("data-dismiss", "modal");
						});
					//RICARICA LA PAGINA PERFARSI CHE SIA IL PHP HA CONTROLLARE SE L'UTENTE E' LOGGATO O NO
					window.location.reload();
				}
				else{
					//LOGIN NON AVVENUTO
					var progressBar = $('.progress-bar');
					progressBar.css({ "width" : "0%" });
					inputs.removeAttr("disabled");
					button.text("Riprova")
						.removeClass("btn-primary")
						.addClass("btn-success")
						.blur()
						.delay(1600)
						.fadeIn(function(){
							button.attr("valida", "modal");
						});
				}
			  },
			  error: function()
			  {
				alert("Chiamata fallita, si prega di riprovare...");
			  },
			  dataType: 'text'
			});
	});
	//RIPRISTINA IL MODAL
	$('#myModal').on('hidden.bs.modal', function (e) {
		var inputs = $('form input');
		var title = $('.modal-title');
		var progressBar = $('.progress-bar');
		var button = $('.modal-footer button');

		inputs.removeAttr("disabled");

		title.text("Log in");

		progressBar.css({ "width" : "0%" });

		button.removeClass("btn-success")
				.addClass("btn-primary")
				.text("Ok")
				.removeAttr("data-dismiss");
	});
	//USCITA E DISTRUGGI LA SESSIONE
	$("#esci").click(function(){
		$.ajax({  
		  type: "POST",
		  url: "./dinamiche/controlla.php",  
		  data: {
			esci: 1
		  },
		  success: function() { 
			  //RICARICA LA PAGINA PERFARSI CHE SIA IL PHP HA CONTROLLARE SE L'UTENTE E' LOGGATO O NO
			  window.location.reload();
		  },
		  error: function(){
			alert("Chiamata fallita, si prega di riprovare...");
		  },
		  dataType: "text"
		});
	  
	});
});