<?php require_once('inc/boot.php') ?>
<?php require_once('inc/bwRemoteServices2.php') ?>
<?php require_once('inc/bwTranzakcio.php') ?>
<?php $CBA_SECTION = 'aerobic'; ?>
<?php define('BW_NOSTAT', true); ?>
<?php require_once('views/header.php') ?>
<!-- Content Starts Here -->
<h1>Online vásárlás</h1>

<?php //if ($session->GetUserLevel() > 1) { ?>
<?php if ($session->user['id'] == 1) { ?>

<?php $remote->Process(); ?>

<?php if (isset($_GET['cikk']) && ($cikkId = intval($_GET['cikk'])) && ($cikk = $remote->GetCikk($cikkId))) { ?>

<?php $jegyErvenyessegErrorMessage = $remote->GetJegyErrorMessage($cikkId); ?>

<?php if ($jegyErvenyessegErrorMessage == '') { ?>

<?php //$szolgaltatasok = $remote->GetJegytipusSzolgaltatasai($cikkId); ?>

<?php //if (count($szolgaltatasok) > 0) { ?>
<?php if (false) { ?>

<table style="width: 750px;">
<tr>
	<th colspan="1" class="title">Szolgálatások</th>
	<th colspan="2" class="nobg"> </th>
</tr>
<tr>
	<th colspan="2">A választott jegytípus az alábbi szolgáltatásokra vehetõ igénybe.</th>
</tr>

<?php $zzz = 1; ?>

<?php foreach ($szolgaltatasok as $szolgaltatas) { ?>
<?php if ($zzz == 1) { ?><tr><?php } ?>
	<td style="width: 33%;"><?php echo $szolgaltatas['cikk'] ?></td>
<?php if ($zzz == 3) { ?></tr><?php } ?>
<?php $zzz = ($zzz == 3) ? 1 : ($zzz + 1); ?>
<?php } ?>

<?php
	if ($zzz > 1)
	{
		while($zzz <= 3)
		{
			echo "<td style=\"width: 33%;\">&nbsp;</td>";
			$zzz++;
		}
		echo "</tr>";
	}
?>

</table>

<?php } ?>

<h2>Vásárlás indítása</h2>


<p>A "vásárlás indítása" gomb segítségével tudja elindítani a fizetési folyamatot. A gombra kattintva átkerül az OTP Bank titkosított oldalára, ahol meg kell adnia a bankkártyája adatait, valamint az elérhetõségét. <strong>A CBA Fitness nem tárolja az Ön kártyájának adatait, ezeket csak a bank rendszere fogja látni.</strong> A vásárlás bármilyen bank által kiadott internetes vásárlásra alkalmas kártyával megtörténhet, nem csak az OTP Bank kártyáival. Amennyiben nem rendelkezik ilyen bankkártyával, kérjük kérje számlavezetõ bankja segítségét!<br />
Kérjük, hogy minden esetben ellenõrizze a megvásárolni kívánt tételt a vásárlás megkezdése elõtt, valamint készítse elõ az adatait, mert a banki oldalon limitált idõ áll rendelkezésére az adatok megadására a visszaélések elerülése érdekében! Amennyiben a banki oldalon dönt úgy, hogy mégsem kívánja megvásárolni az adott szolgáltatást, ott is megszakíthatja majd a vásárlást a "mégsem" gomb segítségével.</p>


<p><strong>Cikk megnevezése</strong>: <?php echo $cikk['nev'] ?><br />
<strong>Fizetendõ összeg</strong>: <?php echo $cikk['bruttoar'] ?> Forint</p>

<?php
	
	//$tranzakcio->Start($cikk['id'], date('Y-m-d'), $cikk['bruttoar'], mysql_real_escape_string($cikk['nev']));
	$tranzakcio->Start($cikk['id'], 0, $cikk['bruttoar'], mysql_real_escape_string($cikk['nev']));
	$tranzId = $database->GetInsertId();
	$log->LogVasarlasStart($cikk['id'], $cikk['bruttoar']);
	$posId = '#02299991';
	$tranzId = 'cbaf' . $tranzId;
?>

<form method="post" action="fiz3.php">
    <input type="hidden" name="tranzakcioAzonosito" value="<?php echo $tranzId ?>" size="40" maxlength="32" class="text"/>
    <input type="hidden" name="posId" value="<?php echo $posId ?>" size="40" maxlength="15" class="text"/>
    <input type="hidden" name="osszeg" value="<?php echo $cikk['bruttoar'] ?>" size="15" maxlength="10" class="text"/>
    <input type="hidden" name="shopMegjegyzes" value="CBA Fitness tesztvásárlás: <?php echo $cikk['nev'] ?>" size="40"  class="text"/>
    <input type="hidden" name="backURL" value="<?php echo 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) ?>fiz3.php?func=fiz3?fizetesValasz=true&amp;posId=<?php echo $posId ?>&amp;tranzId=<?php echo $tranzId ?>" size="40"  class="text"/>
     
    <input type="hidden" name="devizanem" value="HUF" size="5" maxlength="3" class="text"/>
    <input type="hidden" name="nyelvkod" value="hu" size="5" maxlength="2" class="text"/>
    <input type="hidden" name="nevKell" value="true" checked="checked" class="check"/>
    <input type="hidden" name="orszagKell" value="true" class="check"/>
    <input type="hidden" name="megyeKell" value="true" class="check"/>
    <input type="hidden" name="telepulesKell" value="true" class="check"/>
    <input type="hidden" name="iranyitoszamKell" value="true" class="check"/>
    <input type="hidden" name="utcaHazszamKell" value="true" class="check"/>
    <input type="hidden" name="mailCimKell" value="true" class="check"/>
    <input type="hidden" name="kozlemenyKell" value="true" class="check"/>
    <input type="hidden" name="vevoVisszaigazolasKell" value="true" checked="checked" class="check"/>
    <input type="hidden" name="func" value="fiz3"/>

    <input type="submit" name="ok" value="Vásárlás indítása"/>

</form>
<br />
<?php } else { ?>
<p><strong><?php echo $cikk['nev'] ?></strong> vásárlása jelenleg nem lehetséges.</p>

<p><?php echo $jegyErvenyessegErrorMessage; ?></p>

<?php }  ?>

<p><a href="dbteszt0811.php">Vissza a vásárlás fõoldalra.</a> A fentebb feltüntetett szolgáltatás nem kerül kifizetésre, nem vonódik le a pénz a számlájáról!</p>

<?php } else { ?>

<?php if ($jegyek = $remote->GetFelhasznaloJegyei()) { ?>

<h2>Az ön jelenlegi érvényes, megvásárolt jegyei</h2>

<table>
<tr>
	<th>Jegy neve</th>
	<th>Érvényesség kezdete</th>
	<th>Érvényesség vége</th>
	<th>Alkalmak</th>
	<th>Felhasználható alkalmak</th>
</tr>
<?php foreach ($jegyek as $jegy) { ?>
<tr>
	<td><?php echo $jegy['jegynev']  ?></td>
	<td><?php echo $jegy['ervenyessegkezdete']  ?></td>
	<td><?php echo $jegy['ervenyessegvege']  ?></td>
	<td><?php echo ($jegy['alkalmak'] >= 0) ? $jegy['alkalmak'] : '-'  ?></td>
	<td><?php echo ($jegy['felhasznalhatoalkalmak'] >= 0) ? $jegy['felhasznalhatoalkalmak'] : '-'  ?></td>
</tr>
<?php } ?>
</table>

<?php } ?>

<p><a href="online_vasarlasaim.php">Vásárlástörténet</a></p>

<h2>Vásárlás</h2>

<p>Bankkártyája segítségével lehetõsége van online bérletvásárlásra is! Kérjük válassza ki a kívánt tételt, majd a kis <img alt="" src="img/vasarlas_gomb.jpg" /> ikonokra kattintva indíthatja a vásárlást.</p>

<table>
<tr>
<th class="nobg">&nbsp;</th>
<th colspan="8" class="title">Sportszolgáltatások</th>
<th colspan="3" class="nobg"></th>
</tr>
<tr>
<th rowspan="2" class="nobg">&nbsp;</th>
<th colspan="2"><strong>Fitness</strong></th>
<th colspan="2"><strong>Aerobic / Relax</strong><br />
1 óra / 1 alkalom</th>
<th colspan="2"><strong>SPA - Wellness</strong><br />
medence, szaunák, jacussi</th>
<th colspan="2"><strong>SPA kiegészítõ jegy</strong></th>
</tr>
<tr>
<td class="bg">nyitástól 14 óráig</td>
<td class="bg">egész nap</td>
<td class="bg">nyitástól 14 óráig</td>
<td class="bg">egész nap</td>
<td class="bg">hétköznap</td>
<td class="bg">hétvégén</td>
<td class="bg">bármely belépõhöz</td>
</tr>
<tr>
<td><strong>1 alkalmas</strong></td>
<td colspan="2" class="center"><a href="dbteszt0811.php?cikk=24"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a> 1550 Ft</td>
<td colspan="2" class="center"><a href="dbteszt0811.php?cikk=28"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a> 1400 Ft</td>
<td><a href="dbteszt0811.php?cikk=31"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a> 1950 Ft</td>
<td><a href="dbteszt0811.php?cikk=981"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a> 2300 Ft</td>
<td><a href="dbteszt0811.php?cikk=574"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a> 1100 Ft</td>
</tr>
<tr>
<td rowspan="2"><strong>8 alkalmas</strong></td>
<td><a href="dbteszt0811.php?cikk=971"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a> 8450 Ft</td>
<td><a href="dbteszt0811.php?cikk=25"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a> 9450 Ft</td>
<td><a href="dbteszt0811.php?cikk=1847"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a> 7250 Ft</td>
<td><a href="dbteszt0811.php?cikk=1848"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a> 8150 Ft</td>
<td rowspan="2"></td>
<td rowspan="2"></td>
<td rowspan="2"></td>
</tr>
<tr>
<td colspan="2"><span class="akcios">+2 alkalom spa</span></td>
<td colspan="2"><span class="akcios">+2 alkalom spa</span></td>
</tr>
<tr>
<td rowspan="2"><strong>12 alkalmas</strong></td>
<td><a href="dbteszt0811.php?cikk=972"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>9850 Ft</td>
<td><a href="dbteszt0811.php?cikk=26"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>11150 Ft</td>
<td><a href="dbteszt0811.php?cikk=1849"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a> 8650 Ft</td>
<td><a href="dbteszt0811.php?cikk=1850"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a> 9750 Ft</td>
<td rowspan="2">&nbsp;</td>
<td rowspan="2"></td>
<td rowspan="2"></td>
</tr>
<tr>
<td colspan="2"><span class="akcios">+4 alkalom spa</span></td>
<td colspan="2"><span class="akcios">+4 alkalom spa</span></td>
</tr>
<tr>
<td rowspan="2"><strong>20 alkalmas</strong></td>
<td><a href="dbteszt0811.php?cikk=973"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>12250 Ft</td>
<td><a href="dbteszt0811.php?cikk=27"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>13500 Ft</td>
<td><a href="dbteszt0811.php?cikk=1851"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a> 9800 Ft</td>
<td><a href="dbteszt0811.php?cikk=1852"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a> 10950 Ft</td>
<td rowspan="2"></td>
<td rowspan="2"></td>
<td rowspan="2"></td>
</tr>
<tr>
<td colspan="2"><span class="akcios">+6 alkalom spa</span></td>
<td colspan="2"><span class="akcios">+6 alkalom spa</span></td>
</tr>
</table>

<p>A bérlet-opciók 30 napig érvényesek!<br />
Lepedõ bérlése: 100.-Ft/alkalom, frottier-köntös bérlése 250.-Ft/alkalom</p>

<br />
<br />

<table>
<tr>
<th class="nobg">&nbsp;</th>
<th colspan="6" class="title">Kombinált sportszolgáltatások</th>
<th colspan="2" class="nobg"></th>
</tr>
<tr>
<th rowspan="2" class="nobg">&nbsp;</th>
<th colspan="2"><strong>Fitness - Aerobic / Spinning</strong></th>
<th colspan="2"><strong>Fitness - SPA</strong></th>
<th><strong>Aerobic/<br /> Spinning - SPA</strong></th>
<th><strong>Teljes körû belépõ</strong></th>
</tr>
<tr>
<td class="bg">nyitástól 14 óráig</td>
<td class="bg">egész nap</td>
<td class="bg">nyitástól 14 óráig</td>
<td class="bg">egész nap</td>
<td class="bg">egész nap</td>
<td class="bg">egész nap</td>
</tr>
<tr>
<td><strong>1 alkalmas</strong></td>
<td colspan="2" class="center"><a href="dbteszt0811.php?cikk=37"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>1600 Ft</td>
<td colspan="2" class="center"><a href="dbteszt0811.php?cikk=41"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>2100 Ft</td>
<td><a href="dbteszt0811.php?cikk=414"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>1850 Ft</td>
<td><a href="dbteszt0811.php?cikk=430"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>2300 Ft</td>
</tr>
<tr>
<td><strong>8 alkalmas</strong></td>
<td><a href="dbteszt0811.php?cikk=975"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>9250 Ft</td>
<td><a href="dbteszt0811.php?cikk=38"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>10900 Ft</td>
<td><a href="dbteszt0811.php?cikk=978"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>13000 Ft</td>
<td><a href="dbteszt0811.php?cikk=42"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>15000 Ft</td>
<td><a href="dbteszt0811.php?cikk=417"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>9900 Ft</td>
<td></td>
</tr>
<tr>
<td><strong>12 alkalmas</strong></td>
<td><a href="dbteszt0811.php?cikk=976"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>11550 Ft</td>
<td><a href="dbteszt0811.php?cikk=39"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>13500 Ft</td>
<td><a href="dbteszt0811.php?cikk=979"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>15000 Ft</td>
<td><a href="dbteszt0811.php?cikk=43"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>17250 Ft</td>
<td><a href="dbteszt0811.php?cikk=420"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>12100 Ft</td>
<td></td>
</tr>
<tr>
<td><strong>20 alkalmas</strong></td>
<td><a href="dbteszt0811.php?cikk=977"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>13800 Ft</td>
<td><a href="dbteszt0811.php?cikk=40"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>16000 Ft</td>
<td><a href="dbteszt0811.php?cikk=980"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>17850 Ft</td>
<td><a href="dbteszt0811.php?cikk=44"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>19950 Ft</td>
<td><a href="dbteszt0811.php?cikk=424"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>14900 Ft</td>
<td></td>
</tr>
</table>
<p>A bérlet-opciók 30 napig érvényesek!</p>


<table>
<tr>
<th rowspan="4" class="nobg">&nbsp;</th>
<th class="title">Gyermekek részére (14 éves korig)</th>
<th>alkalmak száma</th>
<th style="width: 100px;">ár</th>
</tr>
<tr>
<td>Gyermekjegy - csak Aerobik-Spa használatra</td>
<td>1 alkalom</td>
<td><a href="dbteszt0811.php?cikk=1267"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>950 Ft</td>
</tr>
<tr>
<td>Gyermek karate bérlet</td>
<td>8 alkalom</td>
<td><a href="dbteszt0811.php?cikk=1418"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>5800 Ft</td>
</tr>
<!--tr>
<td>Gyermekmegorzés</td>
<td>&nbsp;</td>
<td>ingyenes!</td>
</tr-->
</table>

<table>
<tr>
<th rowspan="2" class="nobg">&nbsp;</th>
<th class="title">Exkluzív tagság</th>
<th class="nobg">&nbsp;</th>
</tr>
<tr>
<th><strong>Az exkluzív tagság a vásárlástól számított érvényességi idõszak végéig lehetõvé<br /> teszi az összes fenti szolgáltatás - nyitvatartási idõn belüli - korlátlan használatát</strong><br />
(Kivéve: infra szauna, squash, szolárium, masszázs)</th>
</tr>
<tr>
<td><strong>30 nap</strong></td>
<td><a href="dbteszt0811.php?cikk=23"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>21000 Ft</td>
</tr>
<tr>
<td><strong>3 hónap</strong></td>
<td><a href="dbteszt0811.php?cikk=982"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>51000 Ft (17000 Ft/hó)</td>
</tr>
<tr>
<td><strong>6 hónap</strong></td>
<td><a href="dbteszt0811.php?cikk=983"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>90000 Ft (15000 Ft/hó)</td>
</tr>
<tr>
<td><strong>12 hónap</strong></td>
<td><a href="dbteszt0811.php?cikk=984"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>156000 Ft (13000 Ft/hó)</td>
</tr>
</table>
<table>
<tr>
<th rowspan="3" class="nobg">&nbsp;</th>
<th class="title" colspan="3">Squash</th>
<th class="nobg">&nbsp;</th>
</tr>
<tr>
<th colspan="3">csak bérlettel vehetõ igénybe</th>
</tr>
<tr>
<td class="bg">I. zóna 10-16 óra között   </td>
<td class="bg">II. zóna 06-10 óra között   </td>
<td class="bg">III. zóna 16-21.30 óra között   </td>
</tr>
<tr>
<td><strong>5 alkalom</strong></td>
<td><a href="dbteszt0811.php?cikk=985"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>9520 Ft <br />(1850 Ft/alkalom)</td>
<td><a href="dbteszt0811.php?cikk=986"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>12000 Ft <br />(2400 Ft/alkalom)</td>
<td><a href="dbteszt0811.php?cikk=987"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>13250 Ft <br />(2650 Ft/alkalom)</td>
</tr>
<tr>
<td><strong>Alkalmi jegy</strong></td>
<td colspan="3" class="center"><a href="dbteszt0811.php?cikk=991"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>2950 Ft</td>
</tr>
</table>
<p>Hétvégén, egész nap, bármilyen bérlet használható.<br />
Pályafoglalás - kizárólag érvényes bérlettel - 30 napra elõre lehetséges.<br />
Az elõzetes pályafoglalást legkésõbb 24 órával az aktuális idõpont elõtt lehet díjmentesen lemondani,
ellenkezõ esetben az alkalom a bérletbõl levonásra kerül!<br />
<strong>A squash bérlet-opciók 60 napig érvényesek!</strong></p>

<!--table>
<tr>
<th class="nobg">&nbsp;</th>
<th colspan="6" class="title">Egyéb szolgáltatások</th>
<th class="nobg"></th>
</tr>
<tr>
<th rowspan="2" class="nobg">&nbsp;</th>
<th colspan="2"><strong>Szolárium</strong></th>
<th colspan="2"><strong>Masszázs</strong></th>
<th colspan="2"><strong>Infraszauna</strong></th>
</tr>
<tr>
<td class="bg">Erõs (1 egység=5 perc)</td>
<td class="bg">Normál (1 egység=8 perc)</td>
<td class="bg"> 25 perc </td>
<td class="bg"> 50 perc </td>
<td class="bg"> 35 perc (zsetonos)</td>
</tr>
<tr>
<td><strong>1 alkalom</strong></td>
<td class="center">350 Ft</td>
<td class="center">350 Ft</td>
<td>2500 Ft</td>
<td>4000 Ft</td>
<td class="center">600 Ft</td>
</tr>
</table-->


<?php if (0) { ?>
<table>
<tr>
<th rowspan="2" class="nobg">&nbsp;</th>
<th colspan="2" style="width: 475px;" class="title">Egyenleg feltöltése</th>
</tr>
<tr>
<td>TESZT Feltöltés</td>
<td><a href="dbteszt0811.php?cikk=77777"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>3 Ft</td>
</tr>
</table>
<?php } ?>

<?php } ?>

<?php } // if ($session ... ) ?>

<br /><br />

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>