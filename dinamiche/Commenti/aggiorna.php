<?php
include("../../classi/Sql.php");
session_start();
$sql = new Sql("localhost","root","","progetto_esame");

if(isset($_REQUEST['aggiorna'])){
	$result=$sql->ritorna_num_comm($_SESSION['id']);
	if($result->num_rows>0){
		$row=$result->fetch_assoc();
		if($_REQUEST['count']==$row['num'])
			echo "false";
		else{
			require("./preleva_commenti.php");
	 		require("./stampa_commenti.php");
		}
	}
}
?>