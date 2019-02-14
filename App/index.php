<?php
	session_start();
	require_once 'config/config.php';
	include_once 'include/header.php';
	include_once 'include/nav.php';

	//Provjera da li sesija postoji i da li je jednaka USERNAME iz config.php fajla i ako jeste prikazujemo korisniku
	//pozdravnu poruku
	if (isset($_SESSION['user']) && $_SESSION['user'] === USERNAME) :
?>
	
<div class="row">
	<div class="col col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-body">
			<div class="alert alert-info" role="alert">
				<p class="lead text-center">Hello <?php echo USERNAME; ?></p>
			</div>
		</div>
	</div>
</div>

<?php else : ?> <!--Ako sessija nije setovana tj. ako ne postoji i ako nije jednaka USERNAME iz config.php fajla onda korisniku prikazujemo default login informacije-->

<div class="row">
	<div class="col col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-body">
				<h2 class="text-center">Default username:</h2>
				<div class="alert alert-info" role="alert">
					<p class="lead text-center">Admin</p>
				</div>

				<h2 class="text-center">Default password:</h2>

				<div class="alert alert-info" role="alert">
					<p class="lead text-center">pass123</p>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	endif;
	include_once 'include/footer.php';
?>