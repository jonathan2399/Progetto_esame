<?php
  include("../classi/Sql.php");
  session_start();
  $accesso=false;
  if(isset($_REQUEST['esci'])){
	  $sql = new Sql("localhost","root","","progetto_esame");
	  session_destroy();
	  unset($_SESSION['Loggato']);
	  unset($_SESSION['User']);
	  if(isset($_COOKIE['SID'])&&isset($_COOKIE['TOKEN'])){
		$t=$sql->elimina_cookie($_COOKIE['SID']);
		setcookie("SID", "", time() - 3600);
		setcookie("TOKEN", "", time() - 3600);
		$sql->chiudi();
		if($t==true)
			exit("Logout riuscito");
	   }
  }
	
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
		//generazione token cookie--------------------------------------
		if($_REQUEST['ricordami']==1){
			$var=true;
			//generazione session id
			while($var==true){
				$sid = substr(base64_encode(sha1(mt_rand())),0,16);
				$var=$sql->preleva_cookie($sid);
			}
			$token = substr(base64_encode(sha1(mt_rand())),0,16);
			//scrittura numero cookie nel database
			$t=$sql->inserisci_cookie($sid,$token,$_SESSION['User']);
			if($t==true){
				setcookie("SID",$sid,time() + (86400 * 30), "/");
				setcookie("TOKEN",$token,time() + (86400 * 30), "/");
			}
		}
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
		  echo "Password aggiornata";
	  else
		  echo "Password NON aggiornata";
	  $sql->chiudi();
  }
?>