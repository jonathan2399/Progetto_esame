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
else if(isset($_REQUEST['Agg_com'])){
	$sql = new Sql("localhost","root","","progetto_esame");
	$result=$sql->return_n_comments();
	if($result->num_rows>0){
		$row=$result->fetch_assoc();
		$total=$row['total'];
		$sql->chiudi();
		if($total==$_REQUEST['count'])
			echo "false";
		else{
			exit($total);
		}
	}
}else if(isset($_REQUEST['Agg_user'])){
	$sql = new Sql("localhost","root","","progetto_esame");
	$result=$sql->return_n_users();
	$sql->chiudi();
	if($result->num_rows>0){
		$row=$result->fetch_assoc();
		if($row['total']==$_REQUEST['count'])
			echo "false";
		else{
			exit($row['total']);
		}
	}
}else if (isset($_REQUEST['com'])){
	$sql = new Sql("localhost","root","","progetto_esame");
	$result=$sql->return_n_comments();
	if($result->num_rows>0){
		$row=$result->fetch_assoc();
		$total=$row['total'];
		if($total==$_REQUEST['count'])
			echo "false";
		else{
			$result=$sql->ritorna_commenti();
			if($result->num_rows>0){
				echo "
					<table id='mytbl' class='table table-striped table-hover'>
						<tr>
					<th>Autore</th>
					<th>Data</th>
					<th>Ora</th>
							<th></th>
					</tr>
				";
				$sql->chiudi();
				while($row=$result->fetch_assoc()){
					$id=$row['Id_commento'];
					echo "
					<tr class='riga' id='$id' >
								<td>".$row['Username'] ."</td>
								<td>".$row['Data']."</td>
								<td>".$row['Ora']."</td>
								<td><a class='btn btn-default guarda' data-toggle='modal' id='$id' data-target='#$id'>Guarda</a> <a id='$id' onclick='elimina()' class='btn btn-danger' >Elimina</a></td>
							</tr>

							<div class='modal fade' id='$id' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
							  <div class='modal-dialog' role='document'>
								<div class='modal-content'>
								  <form>
								  <div class='modal-header'>
									<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
									<h4 class='modal-title' id='myModalLabel'>Commento di ".$row['Username']." </h4>
								  </div>
								  <div class='modal-body'>
									<div class='form-group'>
									  <label>Nome luogo</label>
									  <input type='text' readonly='readonly' value='".$row['Nome']."' class='form-control' placeholder='Page Title'>
									</div>
									<div class='form-group'>
									  <label>Testo</label>
									  <textarea  readonly='readonly' class='form-control' >".$row['Testo']."</textarea>
									</div>
								  </div>
								  <div class='modal-footer'>
									<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
								  </div>
								</form>
								</div>
							  </div>
							</div>";
				}
			}else
				exit("false");
		}
	}else 
		exit("false");
}else if(isset($_REQUEST['us'])){
	$sql = new Sql("localhost","root","","progetto_esame");
	$result=$sql->return_n_users();
	if($result->num_rows>0){
		$row=$result->fetch_assoc();
		$total=$row['total'];
		if($total==$_REQUEST['count'])
			echo "false";
		else{
			$result=$sql->ritorna_utenti();
			if($result->num_rows>0){
				echo "
					<table id='tbl_users' class='table table-striped table-hover'>
						<tr>
						<th>Nome</th>
						<th>Email</th>
						<th>Users</th>
						<th></th>
					</tr>
				";
				$sql->chiudi();
				while($row=$result->fetch_assoc()){
					echo "
					<tr id='".$row['Username']."'>
						<td>".$row['Nome']." ".$row['Cognome']."</td>
						<td>".$row['Email']."</td>
						<td>".$row['Username']."</td>
					</tr>";
				}
				echo "</table>";
			}else
				exit("false");
		}
	}else 
		exit("false");
}else if(isset($_REQUEST['n_vis'])){
	$sql = new Sql("localhost","root","","progetto_esame");
	$result=$sql->return_n_visitors();
	if($result->num_rows>0){
		$row=$result->fetch_assoc();
		$total=$row['total'];
		$sql->chiudi();
		if($total==$_REQUEST['count'])
			echo "false";
		else{
			exit($total);
		}
	}	
}else if(isset($_REQUEST['vis'])){
	$sql = new Sql("localhost","root","","progetto_esame");
	$result=$sql->return_n_visitors();
	if($result->num_rows>0){
		$row=$result->fetch_assoc();
		$total=$row['total'];
		if($total==$_REQUEST['count'])
			echo "false";
		else{
			$result=$sql->ritorna_visitatori();
			if($result->num_rows>0){
				echo "
					<table id='tbl_visitors' class='table table-striped table-hover'>
						<tr>
						<th>Id_visitatore</th>
						<th>Indirizzo_ip</th>
						<th>Porta</th>
						<th>Host</th>
						<th>Info</th>
						<th>Data</th>
						<th>Ora</th>
					</tr>
				";
				$sql->chiudi();
				while($row=$result->fetch_assoc()){
					echo "
					<tr id='".$row['Id_visitatore']."'>
						<td>".$row['Indirizzo_ip']."</td>
						<td>".$row['Porta']."</td>
						<td>".$row['Host']."</td>
						<td>".$row['Info']."</td>
						<td>".$row['Data']."</td>
						<td>".$row['Ora']."</td>
					</tr>";
				}
				echo "</table>";
			}else
				exit("false");
		}
	}else 
		exit("false");
}
?>
