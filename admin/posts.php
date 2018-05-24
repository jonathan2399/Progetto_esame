<?php
include("../classi/Sql.php");
if(isset($_REQUEST['Elimina'])){
	$sql = new Sql("localhost","root","","progetto_esame");
	if($sql->elimina_commento($_REQUEST['Id'])!=false)
		exit("cancellato");
	$sql->chiudi();
	
}else if(isset($_REQUEST['Guarda'])){
	$sql = new Sql("localhost","root","","progetto_esame");
	if($sql->ritorna_commento($_REQUEST['Id'])!=false){
			exit("<div class='modal fade' id='addPage' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
		  <div class='modal-dialog' role='document'>
			<div class='modal-content'>
			  <form>
			  <div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title' id='myModalLabel'>Commento di </h4>
			  </div>
			  <div class='modal-body'>
				<div class='form-group'>
				  <label>Nome luogo</label>
				  <input type='text' class='form-control' placeholder='Page Title'>
				</div>
				<div class='form-group'>
				  <label>Testo</label>
				  <textarea  readonly='readonly' class='form-control' >bellissimo</textarea>
				</div>
			  </div>
			  <div class='modal-footer'>
				<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
			  </div>
			</form>
			</div>
		  </div>
		</div>");
	}
	$sql->chiudi();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Area | Posts</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="http://cdn.ckeditor.com/4.6.1/standard/ckeditor.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  </head>
	
  <body>
	  <script>
		  $(document).ready(function(){
			 $('.btn-danger').click(function(){
				var id = $(this).attr("id");
				$.ajax({  
				  method: 'POST',
				  url: "posts.php",  
				  data: "Elimina=1" + "&Id=" + id,
				  dataType: "text",
				  success: function(risposta){
					  $('#'+ id).remove();
					  lungh = $('.table tr').length;
					  lungh=lungh-1;
					  if(lungh==0){
						  $('#risposta').replaceWith("");}
				  },
				  error: function(){
					alert("Chiamata fallita, si prega di riprovare...");
				  }
				});
				return false;
			 });
			  
			  /*
			 $('.guarda').click(function(){
				var id = $(this).attr("id");
				$.ajax({  
				  method: 'POST',
				  url: "posts.php",  
				  data: "Guarda=1" + "&Id=" + id,
				  dataType: "text",
				  success: function(risposta){
					  /*
					  $('#'+ id).remove();
					  lungh = $('.table tr').length;
					  lungh=lungh-1;
					  if(lungh==0){
						  $('#risposta').replaceWith("");}*/
					  /*
					  
				  },
				  error: function(){
					alert("Chiamata fallita, si prega di riprovare...");
				  }
				});
				return false;
			 });*/
		  });
	  </script>

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
          <ul class="nav navbar-nav">
            <li><a href="index.html">Dashboard</a></li>
            <li><a href="pages.html">Pages</a></li>
            <li class="active"><a href="posts.html">Posts</a></li>
            <li><a href="users.html">Users</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Welcome, Brad</a></li>
            <li><a href="login.html">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-10">
            <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Posts<small>Manage Blog Posts</small></h1>
          </div>
          <div class="col-md-2">
            <div class="dropdown create">
              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Create Content
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><a type="button" data-toggle="modal" data-target="#addPage">Add Page</a></li>
                <li><a href="#">Add Post</a></li>
                <li><a href="#">Add User</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </header>

    <section id="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li><a href="index.html">Dashboard</a></li>
          <li class="active">Posts</li>
        </ol>
      </div>
    </section>

    <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="list-group">
              <a href="index.html" class="list-group-item active main-color-bg">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Dashboard
              </a>
              <a href="pages.html" class="list-group-item"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Pages <span class="badge">12</span></a>
              <a href="posts.html" class="list-group-item"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Posts <span class="badge">33</span></a>
              <a href="users.html" class="list-group-item"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Users <span class="badge">203</span></a>
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
          <div class="col-md-9">
            <!-- Website Overview -->
            <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Posts</h3>
              </div>
              <div class="panel-body">
                <div class="row">
                      <div class="col-md-12">
                          <input class="form-control" type="text" placeholder="Filter Posts...">
                      </div>
                </div>
                <br>
				<br>
				<table class="table table-striped table-hover">
					<tr>
                        <th>Autore</th>
                        <th>Data</th>
                        <th>Ora</th>
						<th></th>
                    </tr>
					<?php
						$sql = new Sql("localhost","root","","progetto_esame");
						$result=$sql->ritorna_commenti();
						if($result->num_rows>0){
							while($row = mysqli_fetch_array($result)){
								$id=$row['Id_commento'];
								echo "
								<tr class='riga' id='$id' >
									<td>".$row['Username'] ."</td>
									<td>".$row['Data']."</td>
									<td>".$row['Ora']."</td>
									<td><a class='btn btn-default guarda' data-toggle='modal' id='$id' data-target='#$id'>Guarda</a> <a id='$id' class='btn btn-danger' href='#'>Elimina</a></td>
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
								</div>
								
								";
							}
						}
					?>
				</table>
              </div>
              </div>
          </div>
        </div>
      </div>
    </section>

    <footer id="footer">
      <p>Copyright AdminStrap, &copy; 2017</p>
    </footer>
	
	
    <!-- Modals -->

    <!-- Add Page -->
	<!--
    <div class="modal fade" id="addPage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <form>
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Commento di </h4>
		  </div>
		  <div class="modal-body">
			<div class="form-group">
			  <label>Nome luogo</label>
			  <input type="text" class="form-control" placeholder="Page Title">
			</div>
			<div class="form-group">
			  <label>Testo</label>
			  <textarea  readonly="readonly" class="form-control" >bellissimo</textarea>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</form>
		</div>
	  </div>
	</div>-->

  <script>
     CKEDITOR.replace( 'editor1' );
 </script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
