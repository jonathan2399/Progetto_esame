<?php
include("../classi/Sql.php");
if(isset($_REQUEST['barre'])){
	$sql = new Sql("localhost","root","","progetto_esame");
	$result=$sql->ritorna_ricerche();

	if($result->num_rows>0){
		$rows = array();
		$table=array();


		$table['cols']=array(

			array(
				'label' => 'Mese', //imposta le colonne
				'type' => 'string'
			),

			array(
				'label' => 'Ricerche',
				'type' => 'number'
			)

		);


		while($row = mysqli_fetch_array($result)){
			$temp=array();

			$temp[]=array(
					"v"=> (string) $row['data']//concatena alla riga il mese
			);

			$temp[]=array(
					"v"=> (int) $row['ricerche']//concatena alla riga il numero ricerche
			);

			$rows[]=array(
				"c"=>$temp//imposta la riga
			);
		}

		$table['rows']=$rows;//metti le righe nella tabella
		$json=json_encode($table);
		echo $json;
	}
}else if(isset($_REQUEST['regioni'])){
	$sql = new Sql("localhost","root","","progetto_esame");
	$result=$sql->torna_ric_place();

	if($result->num_rows>0){
		$rows = array();
		$table=array();
		
		$table['cols']=array(

			array(
				'label' => 'Citta', //imposta le colonne
				'type' => 'string'
			),

			array(
				'label' => 'Ricerche',
				'type' => 'number'
			)

		);

		while($row = mysqli_fetch_array($result)){
			$temp=array();

			$temp[]=array(
					"v"=> (string) $row['place']//concatena alla riga il mese
			);

			$temp[]=array(
					"v"=> (int) $row['ricerche']//concatena alla riga il numero ricerche
			);

			$rows[]=array(
				"c"=>$temp//imposta la riga
			);
		}

		$table['rows']=$rows;//metti le righe nella tabella
		$json=json_encode($table);
		echo $json;
	}
}else if(isset($_REQUEST['blocca'])){
	$sql = new Sql("localhost","root","","progetto_esame");
	$t=$sql->inserisci_bloccato($_REQUEST['id']);
	if($t==true){
		$t=$sql->disabilita_constraints();
		$t=$sql->elimina_sbloccato($_REQUEST['id']);
		$t=$sql->abilita_constraints();
		if($t==true){
			$row=$sql->ritorna_bloccato($_REQUEST['id']);
			if($row!=false){
				//$sql->chiudi();
				exit("<tr id='".$row['Username']."' ><td>".$row['Nome']." ".$row['Cognome']."</td><td>".$row['Email']."</td><td>".$row['Username']."</td><td><a onclick='sblocca()' id='".$row['Username']."' class='sblocca btn btn-default '>Sblocca</a></td></tr>");
			}else
				exit("NON restituito");
		}
		else
			exit("Non eliminato");
	}
	exit("Non inserito");
}else if(isset($_REQUEST['sblocca'])){
	$sql = new Sql("localhost","root","","progetto_esame");
	$t=$sql->inserisci_sbloccato($_REQUEST['id']);
	if($t==true){
		$t=$sql->elimina_bloccato($_REQUEST['id']);
		if($t==true){
			$result=$sql->ritorna_sbloccato($_REQUEST['id']);
			if($result->num_rows>0){
				$row=$result->fetch_assoc();
				$sql->chiudi();
				exit("<tr id='".$row['Username']."' ><td>".$row['Nome']." ".$row['Cognome']."</td><td>".$row['Email']."</td><td>".$row['Username']."</td><td><a onclick='blocca()' id='".$row['Username']."' class='blocca btn btn-danger'>Blocca</a></td></tr>");
			}else
				exit("NON restituito");
		}else
			exit("Non eliminato");
	}
	exit("Non inserito");
}
?>