<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Area | Dashboard</title>
	 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="./Templates/css/bootstrap.min.css" rel="stylesheet">
    <link href="./Templates/css/style.css" rel="stylesheet">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<style>
		.panel-heading span {
			margin-top: -18px;
			font-size: 15px;
		}
		.panel{
			font-size: 13px;
		}
		
		.panel-title{
			font-size: 14px;
		}
	</style>
	<script>
		$(document).ready(function(){
			var count=$(".com").attr("id");
			var count2 = $(".users").attr("id");
			var count3 = $(".visitors").attr("id");
			
			$('.panel-heading span.clickable').click(function(){
				var $this = $(this);
				if(!$this.hasClass('panel-collapsed')) {
					$this.parents('.panel').find('.panel-body').slideUp();
					$this.addClass('panel-collapsed');
					$this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');

				} else {
					$this.parents('.panel').find('.panel-body').slideDown();
					$this.removeClass('panel-collapsed');
					$this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');

				}
			});
			//VERIFICA NUMERO COMMENTI
			$('#co').click(function(){
				$.ajax({
				  method: 'post',
				  url: "./return_data.php",
				  dataType: 'text',
				  data:{
					Agg_com: 1,
					count: count
				  },
				  success:function(response){
						if(response!==false){
							$('.com').replaceWith("<span id='"+response+"' class='badge com'>"+response+"</span>");
							
							//AGGIORNA COMMENTI
							$.ajax({
							  method: 'post',
							  url: "./return_data.php",
							  dataType: 'html',
							  data:{
								com: 1,
								count: count
							  },
							  success:function(response){
								if(response!=="false")
									$('#mytbl').replaceWith(response);
							  },
							  error:function(){
								alert("Chiamata fallita....");
							  }
							});
						}
				  },
				  error:function(){
					alert("Chiamata fallita....");
				  }
				});
			});
			
			//VERIFICA NUMERO UTENTI
			$('#us').click(function(){
				$.ajax({
				  method: 'post',
				  url: "./return_data.php",
				  dataType: 'text',
				  data:{
					Agg_user: 1,
					count: count2
				  },
				  success:function(response){
					if(response!=="false"){
						$('.users').replaceWith("<span id='"+response+"' class='badge users'>"+response+"</span>");
						//AGGIORNA UTENTI
						$.ajax({
						  method: 'post',
						  url: "./return_data.php",
						  dataType: 'html',
						  data:{
							us: 1,
							count: count2
						  },
						  success:function(response){
							if(response!=="false")
								$('#tbl_users').replaceWith(response);
						  },
						  error:function(){
							alert("Chiamata fallita....");
						  }
						});
					}
					
				  },
				  error:function(){
					alert("Chiamata fallita....");
				  }
				});
				
			});
			
			//VERIFICA NUMERO VISITATORI
			$('#vis').click(function(){
				$.ajax({
				  method: 'post',
				  url: "./return_data.php",
				  dataType: 'text',
				  data:{
					n_vis: 1,
					count: count3
				  },
				  success:function(response){
					if(response!=="false"){
						$('.visitors').replaceWith("<span id='"+response+"' class='badge visitors'>"+response+"</span>");
						
						//AGGIORNA VISITATORI
						
						$.ajax({
						  method: 'post',
						  url: "./return_data.php",
						  dataType: 'html',
						  data:{
							vis: 1,
							count: count3
						  },
						  success:function(response){
							if(response!=="false")
								$('#tbl_visitors').replaceWith(response);
						  },
						  error:function(){
							alert("Chiamata fallita....");
						  }
						});
					}
					
				  },
				  error:function(){
					alert("Chiamata fallita....");
				  }
				});
				
			});
		
			//AGGIORNA COMMENTI
			$('#c').click(function(){
				$.ajax({
				  method: 'post',
				  url: "./return_data.php",
				  dataType: 'html',
				  data:{
					com: 1,
					count: count
				  },
				  success:function(response){
					if(response!=="false"){
						$('#mytbl').replaceWith(response);
						
						$.ajax({
						  method: 'post',
						  url: "./return_data.php",
						  dataType: 'text',
						  data:{
							Agg_com: 1,
							count: count
						  },
						  success:function(response){
								if(response!==false){
									$('.com').replaceWith("<span id='"+response+"' class='badge com'>"+response+"</span>");
								}
						  },
						  error:function(){
							alert("Chiamata fallita....");
						  }
						});
					}
				  },
				  error:function(){
					alert("Chiamata fallita....");
				  }
				});
			});
			
			//AGGIORNA UTENTI
			$('#u').click(function(){
				$.ajax({
				  method: 'post',
				  url: "./return_data.php",
				  dataType: 'html',
				  data:{
					us: 1,
					count: count2
				  },
				  success:function(response){
					if(response!=="false"){
						$('#tbl_users').replaceWith(response);
						
						$.ajax({
						  method: 'post',
						  url: "./return_data.php",
						  dataType: 'text',
						  data:{
							Agg_user: 1,
							count: count2
						  },
						  success:function(response){
							if(response!=="false"){
								$('.users').replaceWith("<span id='"+response+"' class='badge users'>"+response+"</span>");
								
							}
						  },
						  error:function(){
							alert("Chiamata fallita....");
						  }
						});
					}
				  },
				  error:function(){
					alert("Chiamata fallita....");
				  }
				});
			});
			
			//AGGIORNA VISITATORI
			$('#vi').click(function(){
				$.ajax({
				  method: 'post',
				  url: "./return_data.php",
				  dataType: 'html',
				  data:{
					vis: 1,
					count: count3
				  },
				  success:function(response){
					if(response!=="false"){
						$('#tbl_visitors').replaceWith(response);
						
						$.ajax({
						  method: 'post',
						  url: "./return_data.php",
						  dataType: 'text',
						  data:{
							n_vis: 1,
							count: count3
						  },
						  success:function(response){
							if(response!=="false"){
								$('.visitors').replaceWith("<span id='"+response+"' class='badge visitors'>"+response+"</span>");
								
							}
						  },
						  error:function(){
							alert("Chiamata fallita....");
						  }
						});
					}
				  },
				  error:function(){
					alert("Chiamata fallita....");
				  }
				});
			});
		});
	</script>
</head>