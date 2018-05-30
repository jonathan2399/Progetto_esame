<?php
if(isset($_REQUEST['invia'])){
	//APERTURA DEL FILE CSV CHE CONTIENE LA PASSWORD DELL'ADMIN
	$filepath='./SECRET.csv';
	 if (($handle = fopen($filepath, "r")) !== FALSE) {
	  $nn = 0;
	  $handle=fopen($filepath, "r");
		 
	  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	  	$temp=explode(';',$data[0]);
		$nome=$temp[1];
		$cognome=$temp[2];
		$password=$temp[4];
	  }
	  fclose($handle);
	 } else {
	  echo "File non trovato";
	 }
	
	//CONFRONTO SE LA PASSWORD INSERITA CORRISPONDE CON QUELLA NEL FILE
	$pass=$_REQUEST['pass'];
	if(password_verify($pass, $password)){
		session_start();
		$_SESSION['nome']=$nome;
		$_SESSION['cognome']=$cognome;
		header("Location: page.php");
	}
}else if(isset($_REQUEST['logout'])){
	session_destroy();
}
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Area | Account Login</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="./Templates/js/bootstrap.min.js"></script>
    <link href="./Templates/css/bootstrap.min.css" rel="stylesheet">
    <link href="./Templates/css/style.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">AdminStrap</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">

        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-center"> Admin Area <small>Account Login</small></h1>
          </div>
        </div>
      </div>
    </header>
	  
    <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-md-offset-4">
            <form id="login" method='POST' action='' class="well">
                  <div class="form-group">
                    <label>Amministratore</label>
                    <input type="text" value='admin' readonly="true" class="form-control" placeholder="Enter Email">
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" id='pass' name='pass' class="form-control" placeholder="Password" required>
                  </div>
                  <button type="submit" id="invia" name='invia' class="btn btn-default btn-block">Login</button>
             </form>
			 <div id="risposta"></div>
          </div>
        </div>
      </div>
    </section>
    <footer id="footer">
      <p>Copyright AdminStrap, &copy; 2017</p>
    </footer>
  </body>
</html>
