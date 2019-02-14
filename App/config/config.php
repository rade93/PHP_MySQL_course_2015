<?php
	
	//Glavna putanja za navigation linkove. Vrijednost ove konstanete je 'http://localhost/Ime root foldera/ime folder aplikacije APP'
	define ('MAIN_PATH', 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . substr(dirname(__DIR__), 15));

	define ("USERNAME", "Admin");
	define ("PASSWORD", "pass123");

?>