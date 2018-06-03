<?php
include("../classi/Sql.php");
session_start();
if(isset($_REQUEST['Elimina'])){
	$sql = new Sql("localhost","root","","progetto_esame");
	if($sql->elimina_commento($_REQUEST['Id'])!=false)
		exit("cancellato");
	$sql->chiudi();

}else if(isset($_REQUEST['Guarda'])){
	$sql = new Sql("localhost","root","","progetto_esame");
	if($sql->ritorna_commento($_REQUEST['Id'])!=false){
			exit("<div class='modal fade' id='addPage' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
		  <div class='modal-dialog' role='document'>
			<div class='modal-content'>
			  <form>
			  <div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title' id='myModalLabel'>Commento di </h4>
			  </div>
			  <div class='modal-body'>
				<div class='form-group'>
				  <label>Nome luogo</label>
				  <input type='text' class='form-control' placeholder='Page Title'>
				</div>
				<div class='form-group'>
				  <label>Testo</label>
				  <textarea  readonly='readonly' class='form-control' >bellissimo</textarea>
				</div>
			  </div>
			  <div class='modal-footer'>
				<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
			  </div>
			</form>
			</div>
		  </div>
		</div>");
	}
	$sql->chiudi();
}
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

		 function elimina(){
			var id = $('.btn-danger').attr("id");
			$.ajax({
			  method: 'POST',
			  url: "posts.php",
			  data: "Elimina=1" + "&Id=" + id,
			  dataType: "text",
			  success: function(risposta){
				  $('tr#'+ id).remove();
			  },
			  error: function(){
				alert("Chiamata fallita, si prega di riprovare...");
			  }
			});
		 }
	  </script>

	<?php
	if(isset($_SESSION['Loggato'])){
		require("./Templates/header.php");
		echo "
    <section id='main'>
      <div class='container'>
        <div class='row'>";
		  require("./Templates/barra_sinistra.php");
					echo "
          <div class='col-md-9'>
            <!-- Website Overview -->
            <div class='panel panel-default'>
              <div class='panel-heading main-color-bg'>
                <h3 class='panel-title'>Vedi commenti</h3>
				<span class='pull-right clickable'><i id='c' class='glyphicon glyphicon-chevron-down'></i></span>
              </div>
              <div class='panel-body'>
                <div class='row'>
                      <div class='col-md-12'>
                          <input class='form-control' type='text' placeholder='Filter Posts...'>
                      </div>
                </div>
                <br>
				<br>
				<table id='mytbl' class='table table-striped table-hover'>
					<tr>
                <th>Autore</th>
                <th>Data</th>
                <th>Ora</th>
						<th></th>
          		</tr>";
						$sql = new Sql("localhost","root","","progetto_esame");
						$result=$sql->ritorna_commenti();
						if($result->num_rows>0){
							while($row = mysqli_fetch_array($result)){
								$id=$row['Id_commento'];
								echo "
								<tr class='riga' id='$id' >
									<td>".$row['Username'] ."</td>
									<td>".$row['Data']."</td>
									<td>".$row['Ora']."</td>
									<td><a class='btn btn-default guarda' data-toggle='modal' id='$id' data-target='#$id'>Guarda</a> <a id='$id' onclick='elimina()' class='btn btn-danger' >Elimina</a></td>
								</tr>

								<div class='modal fade' id='$id' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
								  <div class='modal-dialog' role='document'>
									<div class='modal-content'>
									  <form>
									  <div class='modal-header'>
										<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
										<h4 class='modal-title' id='myModalLabel'>Commento di ".$row['Username']." </h4>
									  </div>
									  <div class='modal-body'>
										<div class='form-group'>
										  <label>Nome luogo</label>
										  <input type='text' readonly='readonly' value='".$row['Nome']."' class='form-control' placeholder='Page Title'>
										</div>
										<div class='form-group'>
										  <label>Testo</label>
										  <textarea  readonly='readonly' class='form-control' >".$row['Testo']."</textarea>
										</div>
									  </div>
									  <div class='modal-footer'>
										<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
									  </div>
									</form>
									</div>
								  </div>
								</div>

								";
							}
						}
				echo "
				</table>
              </div>
              </div>
          </div>
        </div>
      </div>
    </section>";
    require("./Templates/footer.php");
	}else{
		echo "<center><h1>Error pagina non disponibile</h1></center>";
	}

		?>
  </body>
</html>
