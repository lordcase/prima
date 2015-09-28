<?php 

//
// CBA Fitness Online Foglalási interfész
// Tesztfájl a Prokontrol Kft. részére
// ---------------------------------------
// (c) Anaiz Stúdió, 2007. 12. 12.
// web   : http://www.anaiz.hu
// email : info@anaiz.hu
//


//
// Kapcsolódás az adatbázishoz
//

//$server   = "cbagyomroi.dnsalias.net";
$server   = "81.183.210.139";
$user     = "webuser";
$password = "honlapszerk";
$db       = "wellness";

$tesztConnection = mssql_connect($server, $user, $password)
      or die("Cannot connect to Remote Database.");

mssql_select_db($db, $tesztConnection);


//
// Lekérdezendõ nap megadása
//

$tesztDate = date('Y.m.d');


//
// Foglalható órák lekérdezése
//

$tesztSql = "EXECUTE WSP_ORAK_LEKERDEZESE '" . $tesztDate . "' ";
$tesztOk = ($tesztResource = mssql_query($tesztSql));


//
// Eredmény megjelenítése
//

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<style>
	body { font-family: Verdana, Arial, Helvetica, sans-serif; }
	td   { padding: 1em; text-align: center; }
</style>
<title>Adatbázis teszt</title>
</head>
<body>

<h1>Adatbázis teszt</h1>

<h2>Lekérdezés</h2>
<p><strong><?php echo $tesztSql ?></strong></p>

<h2>Eredmény</h2>
<?php if ($tesztOk) { ?>

<table>

<tr>
	<th>cikk</th>
	<th>kezdes</th>
	<th>vege</th>
	<th>hely</th>
	<th>ferohely</th>
	<th>jelentkezok</th>
</tr>

<?php while ($tesztItem = mssql_fetch_assoc($tesztResource)) { ?>
<tr>
	<td><?php echo $tesztItem['cikk'] ?></td>
	<td><?php echo $tesztItem['kezdes'] ?></td>
	<td><?php echo $tesztItem['vege'] ?></td>
	<td><?php echo $tesztItem['hely'] ?></td>
	<td><?php echo $tesztItem['ferohely'] ?></td>
	<td><?php echo $tesztItem['jelentkezok'] ?></td>
</tr>

<?php } // while ?>

</table>

<?php } else { ?>

<p>Adatbázis lekérdezési hiba.</p>

<?php } // else ?>

</body>
</html>