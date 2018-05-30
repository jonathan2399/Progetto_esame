<div class="col-md-3">
<div class="list-group">
  <a href="page.php" class="list-group-item active main-color-bg">
	<span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Dashboard
  </a>
  <?php
	$sql = new Sql("localhost","root","","progetto_esame");
	$result=$sql->return_n_comments();
	$row=$result->fetch_assoc();
	$n_com=$row['total'];
	$result=$sql->return_n_users();
	$row=$result->fetch_assoc();
	$n_users=$row['total'];
  ?>
  <a href="posts.php" class="list-group-item"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Commenti <span class="badge"><?php echo $n_com ?></span></a>
  <a href="users.php" class="list-group-item"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Utenti <span class="badge"><?php echo $n_users ?></span></a>
</div>

<div class="well">
	  <h4>Disk Space Used</h4>
	  <div class="progress">
		  <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
			  60%
	  	  </div>
	  </div>
	<h4>Bandwidth Used </h4>
	<div class="progress">
		<div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">
			40%
		</div>
	</div>
</div>
</div>