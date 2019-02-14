<?php

//Unsetuejmo ili unistavamo sesiju

session_start();

require_once '../config/config.php';

//Ako je sesija postoji i ako je jednaka vrijednosti konstante USERNAME iz konfiga tj. ako je korisnik ulogovan
//Onda unistavamo tj. unsetujemo korisnicku sessiju i redirektujemo korisnika na home page

if (isset($_SESSION['user']) && $_SESSION['user'] === USERNAME)
{
	unset($_SESSION['user']);
	header('Location: ../index.php');
}
else
{
	header('Location: ../index.php');
}

?>