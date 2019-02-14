<div class="row">
	<div class="col col-md-8 col-md-offset-2">
		<nav>
			<ul class="nav nav-tabs">
				<li role="presentation"><a href="<?php echo MAIN_PATH; ?>/index.php">Home</a></li>
				<li role="presentation"><a href="<?php echo MAIN_PATH; ?>/pages/login.php">Login</a></li>
				<!--Ako je korisnik ulogovan prikazujemo mu ove linkove u suprotnome prikazujemo mu ssamo index.php i login.php-->
				<?php if (isset($_SESSION['user']) && $_SESSION['user'] === USERNAME) : ?>
					<li role="presentation"><a href="<?php echo MAIN_PATH; ?>/pages/map.php">Google Maps</a></li>
					<li role="presentation"><a href="<?php echo MAIN_PATH; ?>/pages/img.php">Photos Editor</a></li>
					<li role="presentation"><a href="<?php echo MAIN_PATH; ?>/pages/logout.php">Logout</a></li>
				<?php endif; ?>
			</ul>
		</nav>
	</div>
</div><br>