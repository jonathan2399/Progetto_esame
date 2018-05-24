<?php
  include("../classi/Sql.php");
  session_start();
	
  $accesso=false;
  if(isset($_REQUEST['esci']))
	  session_destroy();

  if(isset($_REQUEST['InviaPHP'])){
	 $sql = new Sql("localhost","root","","progetto_esame");
	 $sql->inserisci_commento($_SESSION['id'],$_SESSION['User'],$_REQUEST['testoPHP']);
	 require("./Commenti/preleva_commenti.php");
	 require("./Commenti/stampa_commenti.php"); 
	 $sql->chiudi();
  }

  if(isset($_REQUEST['Elimina'])){
	  $sql = new Sql("localhost","root","","progetto_esame");
	  $sql->elimina_commento($_REQUEST['Id']);
	  $sql->chiudi();
  }

  if(isset($_REQUEST['valida'])){
      //$sql = new Sql("jpinna.it.mysql","jpinna_it","MDA9Kt7Z","jpinna_it");
	  $sql = new Sql("localhost","root","","progetto_esame");
      $accesso= $sql->confronta($_REQUEST['userPHP'],$_REQUEST['passPHP']);
      if($accesso!=false){
		$accesso=explode(';',$accesso);
		$_SESSION['Loggato']=$accesso[0];//SETTA LA SESSIONE
		$_SESSION['User']=$accesso[1];//SETTA USERNAME
        exit("Login riuscito");
      }
      else
        exit("Login non riuscito");
	  $sql->chiudi();
  }

  if(isset($_REQUEST['Salva'])){
	  $sql = new Sql("localhost","root","","progetto_esame");
	  $sql->inserisci_preferito($_SESSION['id'],$_SESSION['User']);
	  exit("<h4>Luogo salvato correttamente nei preferiti!</h4><br><hr>");
	  $sql->chiudi();
  }
?>