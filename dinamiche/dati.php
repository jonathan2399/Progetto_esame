<html>
<head>
	<meta charset="UTF-8">
	<title>Nome applicazione</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<link rel="stylesheet" href="../style.css">
</head>
<body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script>
		$(document).ready(function(){
			var id = getUrlVars()["page"];
			$("li#"+id).addClass("active");
			
			function getUrlVars() {
				var vars = {};
				var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
					vars[key] = value;
				});
				return vars;
			}
		});
	</script>
	<div class="text-white text-center" style="background: rgb(255, 163, 26); ">
		<div class="row">
			<div class="col-md-4">
				</br>
			    </br>
				<a href="../index.php"><button name="home" class="btn btn-primary">TORNA ALLA HOME</button></a>
			</div>
			<div class="col-md-4 container">
				<h1 class="display-1">Ecco i risultati</h1>
				<p class="lead">Clicca sull'immagine per vedere il posto</p>
			</div>
		</div>
	</div>
	<?php
		include("../classi/Sql.php");
		include("../classi/PhpGoogleMap.php");
		$latitudini = array();
		$longitudini = array();
		$nomi = array();
		$no_result=false;
		//$sql = new Sql("jpinna.it.mysql","jpinna_it","MDA9Kt7Z","jpinna_it");
		$sql = new Sql("localhost","root","","progetto_esame");
		$map = new PhpGoogleMap("AIzaSyAcAg8U21nYuM4bWn7PyiV_ZrTUHWEZUbA");
		$paese=$_GET['paese'];
		$query=$_GET['query'];
		
		//PRENDE IL NUMERO DELLA PAGINA CORRENTE
		$pageid=$_GET["page"];  
    	$total=6; //numero di record che voglio visualizzare per pagina 
    	$i=0;
    	$co=$_GET["page"];
    	$prima = false;
	
    	if($pageid==1){}
    	else{
    		$pageid=$pageid-1;  
    		$pageid=$pageid*$total+1;  
    	}
	
		//RESTITUISCE TUTTI I DATI DI QUEL LUOGO E DELLA QUERY INSERITA
		try{
			$i=0;
			$paese = str_replace('%20', ' ', $paese);
    		$r = $sql->restituisci_venues($paese,$query);
			//PRELEVA I RECORD TOTALI DAL DATABASE
			$total_records=mysqli_num_rows($r);
			//CALCOLA IL NUMERO DI PAGINE 
			$total_pages=ceil($total_records/$total);
			
			if($r->num_rows>0){
				while($row = $r->fetch_assoc()){
					$latitudini[$i]=$row["Latitudine"];
					$longitudini[$i]=$row["Longitudine"];
					$nomi[$i]=$row["Nome"];
					$i++;
				}
			}else{
				header("Location: errore.html");
			}
		}catch(SQLException $e){
			header("Location: errore.html");
		}

		//RESTITUISCE LA MAPPA CON I RELATIVI MARKER TRAMITE LE COORDINATE PRELEVATE DAL DATABASE
		if(isset($latitudini[0])&&isset($longitudini[0]))
			$map->set_coordinate($latitudini[0],$longitudini[0]);
		$map->set_arraycoordinate($latitudini,$longitudini);
		$map->set_text($nomi);
		$map->set_nmarkers(count($latitudini));
		$map->set_map1();
		$map->renderHTML();
		
	?>
	<div class="container">
		<?php
			$result = $sql->restituisci_risultati($paese,$query,$pageid,$total);
			if($result->num_rows>0){
				$c=3;
				while($row = $result->fetch_assoc()){
					if($c%3==0)
						echo("<div id=\"riga\" class=\"row\">");

						echo("<div class=\"col-lg-4 col-sm-6\">");
							echo("<div id=\"elemento\" class=\"card-h-100\">");
								echo "<div class=\"card img-fluid\">";
									echo("<a href=\"luogo.php?id=".$row["Id_dato"]. "\" class=\"val\"  id=".$row["Id_dato"]. " ><img src=" . $row["Immagine"] ." width=\"330px\" height=\"270px\" class=\"card-img-top\"><div class=\"overlay\"><p>CLICCAMI</p></div></a>");
								echo "</div>";

								echo("<div  class=\"card-body text-center\">");
									echo("<h5 class=\"card-title\">" . $row["Nome"] . "</h5>");
									echo("<p  class=\"card-text\">". $row["Indirizzo"] .  "</p>");
								echo("</div>");
							echo("</div>");
						echo("</div>");
						$c++;

					if($c%3==0)
						echo("</div>");
				 }
			 }
			 else{
				 header("Location: errore.html");
			 }
		?>
	</div>
	
	<!--Footer-->
	<footer class="page-footer font-small blue pt-4 mt-4">
		<!--Footer Links-->
		<div class="container-fluid text-center text-md-left" style="background-color: rgb(100,100,100); color: white; ">
			<div class="row">
				<div id="page-selection"></div>
				<?php
					//PAGINATION 
					echo("<nav class=\"centro\" aria-label=\"Page navigation example\">");
						echo("<ul class=\"pagination\">");
							echo("<li class=\"page-item\">");
								if($co>1){
									$co--;
									$prima=true;
								echo("<a class=\"page-link\" href='dati.php?page=$co&paese=$paese&query=$query' aria-label=\"Previous\">");
									echo("<span aria-hidden=\"true\">&laquo;</span>");
									echo("<span class=\"sr-only\">Previous</span>");
								echo("</a>");}
							echo("</li>");
							//NUMERI DI PAGINA
							for($i=1;$i<$total_pages+1;$i++){
								if($i==1)
									echo("<li id='$i' class=\"page-item\"><a class=\"page-link active\" href='dati.php?page=$i&paese=$paese&query=$query' >" . $i . "</a></li>");
								else
									echo("<li id='$i' class=\"page-item\"><a class=\"page-link \" href='dati.php?page=$i&paese=$paese&query=$query' >" . $i . "</a></li>");
							}
								
							echo("<li class=\"page-item\">");
							  if($co<$total_pages-1){
								if($prima==false)
									$co++;
								else
									$co=$co+2;
							  echo("<a class=\"page-link\" href='dati.php?page=$co&paese=$paese&query=$query' aria-label=\"Next\">");
								echo("<span aria-hidden=\"true\">&raquo;</span>");
								echo("<span class=\"sr-only\">Next</span>");
							  echo("</a>");}
							echo("</li>");
						echo("</ul>");
					echo("</nav>");
				?>
			</div>
		</div>
		<!--/.Footer Links-->
		<!--Copyright-->
		<div class="footer-copyright py-3 text-center" style="background-color: rgb(100,100,100); color: white; ">
			© 2018 Copyright:
			<a href="https://mdbootstrap.com/material-design-for-bootstrap/"> MDBootstrap.com </a>
		</div>
		<!--/.Copyright-->
	</footer>
	<!--/.Footer-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>