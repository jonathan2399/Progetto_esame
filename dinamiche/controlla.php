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
      if($accesso==true){
		$accesso=explode(';',$accesso);
		$_SESSION['Loggato']=$accesso[0];//SETTA LA SESSIONE
		$_SESSION['User']=$accesso[1];//SETTA USERNAME
		//generazione token cookie
		  /*
		if(isset($_REQUEST['ricordami'])){
			$var=true;
			//generazione session id
			while($var==true){
				$sid = rand(5000000000000000000,10000000000000000000);
				$var=$sql->preleva_cookie($sid);
			}
			$token = rand(5000000000000000000,10000000000000000000);
			//scrittura numero cookie nel database
			$t=$sql->inserisci_cookie($sid,$token,$_SESSION['User']);
			if($t==true){
				setcookie("SID",$sid,time() + (86400 * 30), "/");
				setcookie("TOKEN",$token,time() + (86400 * 30), "/");
			}
		}*/
		$sql->chiudi();
		exit("Login riuscito");
      }
      else if($accesso==false){
		$row=$sql->ritorna_bloccato($_REQUEST['userPHP']);
		$sql->chiudi();
		if($row!=false)
			exit("bloccato");
		else
			exit("Login non riuscito");
	  }
  }

  if(isset($_REQUEST['Salva'])){
	  $sql = new Sql("localhost","root","","progetto_esame");
	  $sql->inserisci_preferito($_SESSION['id'],$_SESSION['User']);
	  exit("<h4>Luogo salvato correttamente nei preferiti!</h4><br><hr>");
	  $sql->chiudi();
  }

  if(isset($_REQUEST['update'])){
	  $t=false;
	  $sql = new Sql("localhost","root","","progetto_esame");
	  $t=$sql->aggiorna_pass($_REQUEST['pass'],$_SESSION['User']);
	  if($t==true)
		  echo "Aggiornato";
	  else
		  echo "Non aggiornato";
	  $sql->chiudi();
  }
?>