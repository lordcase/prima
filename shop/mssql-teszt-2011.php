<?php

//die('You no take candle.');

$server   = "81.183.210.139";
$user     = "webuser";
$password = "honlapszerk";
$dbname   = "wellness";

$id = 32942;
$name = 'Szilágyi Judit';

//$id = 16566;
//$name = 'Gordosné Pármai Krisztina';

$query = "DECLARE @eredmeny INT; "
		. "EXECUTE WSP_ERVENYES_FELHASZNALO " . $id . ", '" . $name . "', @eredmeny output; "
		. "SELECT @eredmeny; ";


$_query = "SELECT * "
		. "FROM dbo.UGYFELEK "
		. "WHERE (ID = 16566)";


$db = mssql_connect($server, $user, $password);
if ($db) {
	if (mssql_select_db($dbname, $db)) {
		$result = mssql_query($query, $db);
		echo "<pre>";
		echo $query . "\n\n";
		while ($row = mssql_fetch_assoc($result)) {
			print_r($row);
			echo "\n";
		}
		echo "</pre>\n";
	} else {
		die ('Cannot select DB.');
	}
} else {
	die ('Cannot connect do DB server.');
}
