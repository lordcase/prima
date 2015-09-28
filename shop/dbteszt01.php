<?php 

//
// CBA Fitness Online Foglal�si interf�sz
// Tesztf�jl a Prokontrol Kft. r�sz�re
// ---------------------------------------
// (c) Anaiz St�di�, 2007. 12. 12.
// web   : http://www.anaiz.hu
// email : info@anaiz.hu
//


//
// Kapcsol�d�s az adatb�zishoz
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
// Lek�rdezend� nap megad�sa
//

$tesztDate = date('Y.m.d');


//
// Foglalhat� �r�k lek�rdez�se
//

$tesztSql = "EXECUTE WSP_ORAK_LEKERDEZESE '" . $tesztDate . "' ";
$tesztOk = ($tesztResource = mssql_query($tesztSql));


//
// Eredm�ny megjelen�t�se
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
<title>Adatb�zis teszt</title>
</head>
<body>

<h1>Adatb�zis teszt</h1>

<h2>Lek�rdez�s</h2>
<p><strong><?php echo $tesztSql ?></strong></p>

<h2>Eredm�ny</h2>
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

<p>Adatb�zis lek�rdez�si hiba.</p>

<?php } // else ?>

</body>
</html>