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
}
?>