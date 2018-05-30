<?php
session_start();
include("../classi/Sql.php");
?>
<!DOCTYPE html>
<html lang="en">
  <?php require("./Templates/head.php");?>
  <body>
	<script>
		$(document).ready(function(){
			$('#logout').click(function(){
				$.post("page.php",
				{
				  logout: 1
				},
				function(response){
					window.location.href = './index.php';
				});
			})
		});
		
		function blocca(){
			var id = $('.blocca').attr('id');
			$.ajax({
				method: 'POST',
				url: './return_data.php',
				dataType: 'html',
				data:{
					blocca: 1,
					id: id
				},
				success: function(risposta){
					$('tr#'+id).remove();
					$('.tbl-bloccati').append(risposta);


				},
				error: function(){
					alert("Chiamata fallita, si prega di riprovare...");
				}

			});
		}
		function sblocca(){
			var id = $('.sblocca').attr('id');
			$.ajax({
				method: 'POST',
				url: './return_data.php',
				dataType: 'html',
				data:{
					sblocca: 1,
					id: id
				},
				success: function(risposta){
					$('tr#'+id).remove();
					$('.tbl-sbloccati').append(risposta);


				},
				error: function(){
					alert("Chiamata fallita, si prega di riprovare...");
				}

			});
		}
	</script>
    <?php require("./Templates/header.php");?>
    <section id="main">
      <div class="container">
        <div class="row">
          <?php require("./Templates/barra_sinistra.php");?>
          <div class="col-md-9">
            <!-- Website Overview -->
            <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Utenti abilitati</h3>
              </div>
              <div class="panel-body">
                <div class="row">
                      <div class="col-md-12">
                          <input class="form-control" type="text" placeholder="Filter Users...">
                      </div>
                </div>
                <br>
				<table class="tbl-sbloccati table table-striped table-hover">
					<tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>User</th>
                        <th></th>
                    </tr>
					<?php
						$sql = new Sql("localhost","root","","progetto_esame");
						$result=$sql->ritorna_utenti();
						if($result->num_rows>0){
							while($row = mysqli_fetch_array($result)){
								echo "
								<tr id='".$row['Username']."'>
									<td>".$row['Nome']." ".$row['Cognome']."</td>
									<td>".$row['Email']."</td>
									<td>".$row['Username']."</td>
									<td><a onclick='blocca()' id='".$row['Username']."' class='btn btn-danger blocca'>Blocca</a></td>
								</tr>";
							}
						}
					?>
				</table>
              </div>
              </div>
			  </br>
			  <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Utenti bloccati</h3>
              </div>
              <div class="panel-body">
                <div class="row">
                      <div class="col-md-12">
                          <input class="form-control" type="text" placeholder="Filter Users...">
                      </div>
                </div>
                <br>
				<table class="tbl-bloccati table table-striped table-hover">
					<tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>User</th>
                        <th></th>
                    </tr>
					<?php
						$result=$sql->ritorna_bloccati();
						if($result->num_rows>0){
							while($row = mysqli_fetch_array($result)){
								echo "
								<tr id='".$row['Username']."'>
									<td>".$row['Nome']." ".$row['Cognome']."</td>
									<td>".$row['Email']."</td>
									<td>".$row['Username']."</td>
									<td><a onclick='sblocca()' id='".$row['Username']."' class='btn btn-default sblocca'>Sblocca</a></td>
								</tr>";
							}
						}
						$sql->chiudi();
					?>
				</table>
              </div>
              </div>
          </div>
        </div>
      </div>
    </section>

    <?php require("./Templates/footer.php");?>
  </body>
</html>
