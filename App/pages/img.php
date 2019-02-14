<?php
	session_start();

	require_once '../config/config.php';

	//Provjera da li je korisnik ulogovan da bi mu mogli prikazati ovu stranicu
	
	if ($_SESSION['user'] !== USERNAME)
	{
		header('Location: login.php');
		die;
	}

	include_once "../include/header.php";
	include_once "../include/nav.php";

?>

<style type="text/css">
	
	.sepia {
		background: #704214;
	}

	.rotate {
		padding: 7px 40px;
	}
</style>
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<h1 class="text-center">Slika</h1>
					<img src="">
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-body">
					
					<form action="" method="post" class="form-group">
						 <div class="text-center">
							<button class="btn btn-default glyphicon glyphicon-repeat rotate"  type="submit"></button>
							<button  class="btn btn-default active" type="submit">Grayscale</button>
							<button class="btn btn-default sepia" type="submit">Sepia</button>
						 </div>
					 
						  <div class="form-group">
						    <br />
						    <input type="file" id="exampleInputFile">
						  </div>
					  
					  	<button type="submit" class="btn btn-default">Upload</button>
					</form>
				</div>
			</div>
		</div>
	</div>

<?php 
	include_once "../include/footer.php";
?>