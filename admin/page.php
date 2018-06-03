<?php session_start(); include("../classi/Sql.php");?>
<html lang="en">
  <?php require("./Templates/head.php");?>
  <?php
	if(isset($_REQUEST['logout'])){
		session_destroy();
	}
   ?>
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
  </script>
  <script type="text/javascript">
  	google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

	  var data=null;
      function drawChart(){

		var jsondata = $.ajax({
        url: "return_data.php",
        dataType: "json",
		data: {
			barre: 1
		},
		method: 'POST',
        async: false
        }).responseText;

		data = new google.visualization.DataTable(jsondata);

		var options = {
		  chart: {
			title: 'Numero di ricerche effettuate da tutti gli utenti registrati',
			subtitle: 'Grafico che esprime il numero di ricerche effettuate da tutti gli utenti in un certo mese di un anno'
		  },
		  bars: 'vertical' // Required for Material Bar Charts.
		};

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
      }


	  google.charts.load('current', {
       'packages': ['geochart'],
       'mapsApiKey': 'AIzaSyAW121HZee767g3JOEQ1MGMEGvUUjc04Xw'
      });


      google.charts.setOnLoadCallback(drawMarkersMap);


	  function drawMarkersMap() {

		  var jsondata = $.ajax({
		  url: "return_data.php",
		  dataType: "json",
		  data: {
				regioni: 1
		   },
		  method: 'POST',
		  async: false
		  }).responseText;

		  data = new google.visualization.DataTable(jsondata);

		  var options = {
			chart: {
			title: 'Places in the city',
			subtitle: 'Grafico che esprime il numero di posti presenti in una citta tra quelli cercati'
		  	},
			displayMode: 'markers',
			colorAxis: {colors: ['red', 'blue']}
		  };

		  var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
		  chart.draw(data, options);
	  }


	  $(window).resize(function(){
		  drawChart();
		  drawMarkersMap();
	  });
  </script>
  <body>
    <?php
    if(isset($_SESSION['Loggato'])){
    require("./Templates/header.php");
    echo "<section id='main'>
      <div class='container'>";
          require('./Templates/barra_sinistra.php');
          echo "
          <div class='col-md-9'>

            <div class='panel panel-default'>
              <div class='panel-heading main-color-bg'>
                <h3 class='panel-title'>Website Overview</h3>
              </div>
              <div class='panel-body'>
                <div class='col-md-3'>
                  <div class='well dash-box'>
                    <h2><span class='glyphicon glyphicon-user' aria-hidden='true'></span>$n_users</h2>
                    <h4>Utenti iscritti</h4>
                  </div>
                </div>
                <div class='col-md-3'>
                  <div class='well dash-box'>
                    <h2><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>$n_com</h2>
                    <h4>Commenti</h4>
                  </div>
                </div>
                <div class='col-md-3'>
                  <div class='well dash-box'>
                    <h2><span class='glyphicon glyphicon-stats' aria-hidden='true'></span> $visite</h2>
                    <h4>Visite</h4>
                  </div>
                </div>
				<div class='col-md-3'>
                  <div class='well dash-box'>
                    <h2><span class='glyphicon glyphicon-envelope' aria-hidden='true'></span> $news</h2>
                    <h4>Notifiche</h4>
                  </div>
                </div>
              </div>
              </div>

			  <div id='barchart_material' style='min-height: 450px; min-width: 200px;'></div><br>
			  <div id='chart_div' style='min-height: 450px; min-width: 200px;'></div>
          </div>
      </div>
    </section>";
    require('./Templates/footer.php');
  }else
    echo "<center><h1>Error pagina non disponibile</h1></center>";
    ?>
  </body>
</html>
