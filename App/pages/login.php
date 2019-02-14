<?php

//Pokretanje sessije
session_start();

require '../config/config.php';

$errors = array(); //Prazan niz za skupljanje gresaka
$confirmMessages = array(); //Prazan niz za skupljanje potvrdnih poruka

/************************************************** POCETAK CODA ZA LOGIN FORMU *************************************************************/

//Provjera da li postoji nesto u POST var. tj. da li je korisnik popunio login formu
if (isset($_POST["username"], $_POST["password"])) 
{
	//Smijestanje vrijednosti forme u var.
	$username = $_POST["username"];
	$password = $_POST["password"];
	 
	//Provjera da li su polja forme prazna tj. da li se sta nalazi u var. koje smo pokupili iz POSTA
	if (empty($username) and empty($password)) 
	{
		$errors[] = 'Unesi username i password';
	}

	//Provjera da li se korisnikovi podatci koje unijeo u formu slazu sa onima iz konfig fajla
	if ($username === USERNAME and $password === PASSWORD)
	{
		//Ako se podatci slazu onda dodajemo sesiju korisniku u ulogujemoga sa potvrdnom porukom
		$_SESSION['user'] = USERNAME; //Dajemo sessiji ime i smijestamo vrijednost username u nju
		$confirmMessages[] = 'Uspješno ste se ulogovali!';
	}
	else 
	{
		$errors[] = 'Neuspješan login.';
	}
}

/******************************************** KRAJ CODA ZA LOGIN FORMU **********************************************************************/

/*******************************************************************************************************************************************/

/******************************************** POCETAK CODA ZA MESSAGE BOARD FORMU **********************************************************/

mb_internal_encoding ('UTF-8'); //Funkcija koja odredjuje nacin kodiranja citave skripte,potrebno nam je da bi mogli korisiti 'UTF-8'

//Provjera da li postoji superglobalna serverska var. POST
if ($_POST)
{	
	//Provjera da li postoji nesto u superglobalna serverska var. POST tj. poruka koju je korisnik upisao u input polje
	if (isset($_POST['message']))
	{	
		/*
			Navedene ugradjene PHP funkcije sluze da ocistimo ulazni teskt iz input polja koji unese krisnik da bi de zastitili od
			nezeljenog ubacivanja stetnog coda-a u nasu aplikaciju ili bazu podatak
			
			- 'UTF-8' je nacin kodiranja ovog ulaznog stringa tj. podatka
			- ENT_QOUTES je PHP konstanta za izbjegavanje dulpih i obicnih navodnika "" ''
			- trim je PHP funk. za odsjecanje praznog prostora sa lijeve i desne strane stringa
			- htmlenteties je PHP funk. za izbjegavanje HTML specijalnih entiteta npr. &gt; > ili &lt; <, &nbsp; i slicnih
			- nl2br je PHP funk. koja prebacuje teskt u novu liniju tj. dodaje break line kao npr <br> kad naidje na '/n' u tesktu
		*/

		$message = nl2br(htmlentities(trim($_POST['message']), ENT_QUOTES, 'UTF-8')); //Poruka iz forme
		$time = date('d.m.Y @ H:i:s'); //Var. koja ce cuvati trenutno vrijeme slanja poruka sa data() PHP funk. dohvatmo ternutno vrijeme
		$fileName = '../messages/Comments.txt'; //Putanja i naziv tekstualnog fajla u koji cemo upisivati poruke. Ovaj fajl ce biti kreiran od strane PHP-a
		$writeInFile = $time . "\r\n" . $message . "\r\n"; //U ovu var. smijestamo poruku i vrijeme poruke i formatiramo sve u novi red

		//Provjera da li je polje za unos poruke prazno
		if (!empty($message))
		{
			//Provjera da li poruka nije veca od 160 karaktera posto smo ogranicili na input polju i textarea maxllength na 160 karaktera
			//Da nam korisnici nebi pisali ljubavne romane :)

			if (mb_strlen($message) > 160)
			{
				$errors[] = 'Ahear to max or min lenght of the fields.';
			}
			else
			{	
				$handle = fopen($fileName, 'a+'); //Funkcija za otvaranje fajla, FLAG 'a+' oznacava da je dozvoljeno citanje,pisanje i stvaranje fajla ako ne postoji na specificnoj lokaciji
				fwrite($handle, $writeInFile); //Upisi vremena i poruke u fizicki fajl na sistemu
				fclose($handle); //Zvrsavamo sa pisanjem u fajl i zatvaramo fajl

				$confirmMessages[] = 'Good job! ;)';
			}
		}
		else
		{
			$errors[] = 'Please enter some message.';
		}
	}
}

/******************************************** KRAJ CODA ZA MESSAGE BOARD FORMU *************************************************************/

/******************************************************************************************************************************************/

/************************************************ POCETAK PRETVARANJA SADRZAJA FAJLA U NIZ (array) I .JSON FORMAT **********************************/

$fileName = '../messages/Comments.txt'; //Putanja do Comments.txt fajla

//Provjera da li taj fajl postoji na specificnoj lokaciji
if (file_exists($fileName))
{
	$docArray = file($fileName); //Ugradjena funckija za pretvranje sadrzaja fajla u niz (cita fajl i prebacuje ga u niz)

	/*
		Alternativni nacin citanja fajla i prebacivanja u niz
		$document = file_get_contents($fileName);
		$lines = explode("\n", $document);

		//Prolaz kroz elemente niza

		foreach ($lines as $line)
		{
			echo $line , '<br/>';
		}
	*/

	//Pretvaranje niza ($docArray) koji smo dobili od sadrzaja tekstualnog fajla u JSON tip i format podatka

	$jsonFileName = '../messages/Comments.json'; //Putanja do Comments.json fajla koji ce biti napraviti na ovoj lokaciji i po ovim imenom

	//Prebacujemo encodiramo PHP $docArray sa podatcima iz comments.txt fajla u JSON tip podatka,a ove JSON_FORCE_OBJECT | JSON_PRETTY_PRINT 
	//konstante nam sluze da formaitramo JSON podatke prilikom upisa u novi Comments.json fajl tj. da nbude sve ispisano u jednom redu

	if (isset($docArray))
	{
		$jsonFormat = json_encode($docArray, JSON_FORCE_OBJECT | JSON_PRETTY_PRINT);

		$handle = fopen($jsonFileName, 'a+'); //Funkcija za otvaranje fajla, FLAG 'a+' oznacava da je dozvoljeno citanje,pisanje i stvaranje fajla ako ne postoji na specificnoj lokaciji
		ftruncate($handle, 0); //Brisemo stari sadrzaj JSON fajla zato sto kad upisujemo novi sadrzaj u PHP niz,dolazi kopiranja jednog te istog sadrzaja u Comments.json dokumentu
		fwrite($handle, $jsonFormat); //Upisi vremena i poruke u fizicki fajl na sistemu
		fclose($handle); //Zvrsavamo sa pisanjem u fajl i zatvaramo ga
	}
}
else
{
	$error[] = 'Specified file do not exist.';
}

/************************************************ KRAJ PRETVARANJA SADRZAJA FAJLA U NIZ I .JSON FORMAT ************************************/

	include_once "../include/header.php";
	include_once "../include/nav.php";

?>
	<div class="row">
		<div class="row">
			<div class="col col-md-6 col-md-offset-3">
				<!--Provjera da li postoji neka od resaka u nizu-->
				<?php if ($errors) : ?>
					<ul class="list-group">
						<!--Prolaz kroz niz od gresaka i vadjenje pojedinace greske radi ispisa-->
						<?php foreach ($errors as $error) : ?>
							<li class="list-group-item list-group-item-danger"><p class="lead text-center"><?php echo $error; //Ispis greske ?></p></li>
						<?php endforeach; ?>
					</ul>
				<?php elseif ($confirmMessages) : ?>
					<ul class="list-group">
						<!--Prolaz kroz niz od potvrdnih poruka i vadjenje pojedinace poruke radi ispisa-->
						<?php foreach ($confirmMessages as $confirmMessage) : ?>
							<li class="list-group-item list-group-item-success"><p class="lead text-center"><?php echo $confirmMessage; //Ispis poruke potvrdne ?></p></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>	
			</div>
		</div>

		<div class="col col-md-2"></div>
		<div class="col col-md-4">
			<h2>Message Board</h2>
			<form action="" method="POST" class="form-inline" autocomplete="off">
				<textarea readonly class="form-control" rows="3" cols="40" maxlength="160">
					<?php
						//Provjera da li $docArray niz sa podacima iz Comments.txt fajla postoji
						if (isset($docArray))
						{	
							//Prolaz koroz niz i dohvatanje pojedinace poruke
							foreach ($docArray as $messages)
							{
								echo '&NewLine;' , trim($messages); //Ispis pojedinace poruke u novoj liniji (HTML enteties za novu liniju '&NewLine;')
							}
						}
					?>
				</textarea><br><br>

				<input type="text" name="message" class="form-control" placeholder="Enter some text" size="27" maxlength="160">

				<button type="submit" class="btn btn-default">Submit</button>
			</form>
		</div>
	
		<div class="col col-md-4">
			<h2>Login Form</h2>
			<form action="" method="POST">
			  <div class="form-group">
			    <label for="exampleInputEmail1">Username</label>
			    <input type="text" class="form-control" name="username" id="exampleInputEmail1" placeholder="Enter Username">
			  </div>
			  <div class="form-group">
			    <label for="exampleInputPassword1">Password</label>
			    <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Enter Password">
			  </div>
			 
			  <button type="submit" class="btn btn-default">Login</button>
			</form>
		</div>
		<div class="col col-md-2"></div>
	</div>

	<hr/>

	<div class="row">
		<div class="col col-md-2"></div>
		<div class="col col-md-4">
			<h2>Message Board Array</h2>
			<?php
				//Ako postoji niz sa podacima ispisujemo ga sa print_r(),a ako ne postoji ispisujemo prazan string
				echo '<pre class="pre-scrollable">' , (isset($docArray)) ? print_r($docArray, true) : '' , '</pre>';
			?>
		</div>

		<div class="col col-md-4">
			<h2>Message Board JSON</h2>
			<?php
				//Ako postoji doument Comments.json sa podacima ispisujemo njegov sadrzaj,a ako ne postoji ispisujemo prazan string
				echo '<pre class="pre-scrollable">' , (file_exists('../messages/Comments.json')) ? file_get_contents('../messages/Comments.json') : '' , '</pre>';
			?>
		</div>
		<div class="col col-md-2"></div>
	</div>

<?php
	include_once "../include/footer.php";
?>