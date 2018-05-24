<?php
	try{
		//$sql = new Sql("jpinna.it.mysql","jpinna_it","MDA9Kt7Z","jpinna_it");
		$sql = new Sql("localhost","root","","progetto_esame");
		$sql->crea_tbl_utenti();
		$sql->crea_tbl_categoria();
		$sql->crea_tbl_dati();
		$sql->crea_tbl_luoghi();
		$sql->crea_tbl_luoghidati();
		$sql->crea_tbl_ricerca();
		$sql->crea_tbl_commenti();
		$sql->crea_tbl_preferiti();
		$sql->crea_tbl_utenti_admin();
		$sql->crea_tbl_bloccati();
		$sql->chiudi();
	}catch(SQLException $e){
		
	}
?>