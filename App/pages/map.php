<?php
	session_start();

	require_once '../config/config.php';

	//Provjera da li je korisnik ulogovan da bi mu mogli prikazati ovu stranicu

	if ($_SESSION['user'] !== USERNAME)
	{
		header('Location: login.php');
		die;
	}

	include_once '../include/header.php';
	include_once '../include/nav.php';

	$errors = array(); //Prazan niz sa smijestanje gresaka
	
	//Provjera da li postoji POST Serverska Super Globalna varijabla
	if (isset($_POST))
	{
		//Provjera da li su poslati podaci iz forme
		if (isset($_POST['address']))
		{
			$address = $_POST['address']; //Dohvatanje korisnickih podataka koje je unijeo u formu

			//Provjera da li je polje za uns adrese prazno
			if (!empty($address))
			{
				$address = urlencode($address); //enkodiranje adrese da bi je mogli poslati u URL

				$url = "http://maps.google.com/maps/api/geocode/json?address={$address}"; //Dodavanje adrese na URL od Google Maps API-a

				$respo_json = file_get_contents($url); //Dohvatamao sadrzaj JSON fajla tj. odgovora od Google Mpas Servera

				$resp = json_decode($respo_json, true); //Dekodiramo taj sadrzaj fajla
               
				//Provjeravamo da li je sadrzaj fajla tj. status OK
				if ($resp['status'] == 'OK')
				{	
					//Ako je status OK tj. ako smo dobile neke podatke od Google servera onda dohvatamo Geo. siriniu i duzinu i ime adrese
					$latitude = $resp['results'][0]['geometry']['location']['lat'];
					$longitude = $resp['results'][0]['geometry']['location']['lng'];
					$formatted_address = $resp['results'][0]['formatted_address'];

					//Provjeravamo da li ti podaci stvarno postoje
					if ($latitude && $longitude && $formatted_address)
					{
						$data = array(); //Prazan niz za smijestanje podataka

						array_push($data, $latitude, $longitude, $formatted_address); //Dodajemo elemente u $data niz
					}
					else
					{
						//return false; //Ako podaci ne postoje vracamo false vrijednost
						$errors[] = 'Please enter some valide city name address.';
					}
				}
				else
				{
					//return false; //Ako status nije OK vracamo false vrijednost
					$errors[] = 'Something went wrong,please try again.';
				}
			}
			else
			{
				$errors[] = 'Please enter some valide address.'; //Smjestamo gresku u niz
			}
		}
	}

 ?>
	<div class="row">
		<div class="row">
			<div class="col col-md-6 col-md-offset-3">
				<!--Provjera da li postoji neka od resaka u nizu-->
				<?php if ($errors) : ?>
					<ul class="list-group">
						<!--Prolaz kroz niz od gresaka i vadjenje pojedinace greske radi ispisa-->
						<?php foreach ($errors as $error) : ?>
							<li class="list-group-item list-group-item-danger"><?php echo $error; //Ispis greske ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>

		<div class="col col-md-6 col-md-offset-3">
			<h2 class="text-center">Map Search Form</h2>
			<div class="panel panel-default">
				<div class="panel-body">
					<form action="" method="post" autocomplete="off" class="form-inline">
						<!--Ako imamo neku gresku na ovome input polju dodajemo 'has-error' klasu da bi polje pocrvenilo-->
						<div class="form-group <?php if ($errors) {echo ' has-error';} else {echo '';} ?>">
							<input type="text" class="form-control" name="address" id="address" style="width: 230%;" placeholder="Enter Address">
						</div>
						<button type="submit" class="btn btn-default" style="float: right;">Search</button>
					</form>
				</div>
			</div>
		</div>
	</div><br>

	<div class="row">
		<div class="col col-md-6 col-md-offset-3">
			<!--Google Mapa-->
			<div class="google-map" id="googleMap" style="width:570px;height:380px;"></div>
		</div>
	</div>
<?php include_once '../include/footer.php' ?>