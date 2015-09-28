<?php require_once('inc/boot.php') ?>
<?php if (!defined('ONLINE_VASARLAS_SZUNETEL')) { ?>
<?php require_once('inc/bwRemoteServices2.php') ?>
<?php require_once('inc/bwTranzakcio.php') ?>
<?php } ?>
<?php $CBA_SECTION = 'online'; ?>
<?php define('BW_NOSTAT', true); ?>
<?php require_once('views/header.php') ?>
<!-- Content Starts Here -->
<h1>Online vásárlás</h1>
<?php if (!defined('ONLINE_VASARLAS_SZUNETEL')) { ?>

<?php //if ($session->user['id'] == 1) { ?>
<?php if ($session->logged_in) { ?>
<?php if ($remote->UserCanPayOnline()) { ?>

<?php $remote->Process(); ?>
<?php if (isset($_GET['cikk']) && ($cikkId = intval($_GET['cikk'])) && ($cikk = $remote->GetCikk($cikkId))) { ?>

<?php $jegyErvenyessegErrorMessage = $remote->GetJegyErrorMessage($cikkId); ?>

<?php if ($jegyErvenyessegErrorMessage == '') { ?>

<?php //$szolgaltatasok = $remote->GetJegytipusSzolgaltatasai($cikkId); ?>

<?php //if (count($szolgaltatasok) > 0) { ?>

<h2>Vásárlás indítása</h2>


<p>A "vásárlás indítása" gomb segítségével tudja elindítani a fizetési folyamatot. A gombra kattintva átkerül az OTP Bank titkosított oldalára, ahol meg kell adnia a bankkártyája adatait, valamint az elérhetõségét. <strong>A Príma Wellness nem tárolja az Ön kártyájának adatait, ezeket csak a bank rendszere fogja látni.</strong> A vásárlás bármilyen bank által kiadott internetes vásárlásra alkalmas kártyával megtörténhet, nem csak az OTP Bank kártyáival. Amennyiben nem rendelkezik ilyen bankkártyával, kérjük kérje számlavezetõ bankja segítségét!<br />
Kérjük, hogy minden esetben ellenõrizze a megvásárolni kívánt tételt a vásárlás megkezdése elõtt, valamint készítse elõ az adatait, mert a banki oldalon limitált idõ áll rendelkezésére az adatok megadására a visszaélések elerülése érdekében! Amennyiben a banki oldalon dönt úgy, hogy mégsem kívánja megvásárolni az adott szolgáltatást, ott is megszakíthatja majd a vásárlást a "mégsem" gomb segítségével.</p>
<p style="font-size: 12px; color: #FF0000"><strong>A vásárlás menete: a banki oldalon ki kell tölteni az adatmezõket (bankkártya adatai, név, cím, stb.), majd az "Elküld" gomb segítségével el lehet indítani a fizetést. Ezután egy adatellenõrzõ oldalra jut, ahonnan az újabb "Elküld" gomb segítségével tovább lehet lépni a vásárlás véglegesítéséhez. Ezután a "Vissza a bolti oldalra" gombbal fejezheti be a vásárlást.</p>


<p><strong>Cikk megnevezése</strong>: <?php echo $cikk['nev'] ?><br />
<strong>Fizetendõ összeg</strong>: <?php echo $cikk['bruttoar'] ?> Forint</p>

<?php
	
	//$tranzakcio->Start($cikk['id'], date('Y-m-d'), $cikk['bruttoar'], mysql_real_escape_string($cikk['nev']));
	$tranzakcio->Start($cikk['id'], 0, $cikk['bruttoar'], mysql_real_escape_string($cikk['nev']));
	$tranzId = $database->GetInsertId();
	$log->LogVasarlasStart($cikk['id'], $cikk['bruttoar']);
//	$posId = '#02299991';
	$posId = '02200814';
	$tranzId = 'primaw' . $tranzId;
?>

<form method="post" action="/shop/fiz3.php" target="_blank">
    <input type="hidden" name="tranzakcioAzonosito" value="<?php echo $tranzId ?>" size="40" maxlength="32" class="text"/>
    <input type="hidden" name="posId" value="<?php echo $posId ?>" size="40" maxlength="15" class="text"/>
    <input type="hidden" name="osszeg" value="<?php echo $cikk['bruttoar'] ?>" size="15" maxlength="10" class="text"/>
    <input type="hidden" name="shopMegjegyzes" value="Príma Wellness vásárlás: <?php echo $cikk['nev'] ?>" size="40"  class="text"/>
    <input type="hidden" name="backURL" value="<?php echo 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) ?>/fiz3.php?func=fiz3&fizetesValasz=true&posId=<?php echo $posId ?>&tranzId=<?php echo $tranzId ?>" size="40"  class="text"/>
     
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
    <input type="hidden" name="vevoVisszaigazolasKell" value="false" />
    <input type="hidden" name="func" value="fiz3"/>

    <input type="submit" name="ok" value="Vásárlás indítása"/>

</form>
<br />
<?php } else { ?>
<p><strong><?php echo $cikk['nev'] ?></strong> vásárlása jelenleg nem lehetséges.</p>

<p><?php echo $jegyErvenyessegErrorMessage; ?></p>

<?php }  ?>

<p><a href="online_vasarlas.php">Vissza a vásárlás fõoldalra.*</a><br />
*A fentebb feltüntetett szolgáltatás nem kerül kifizetésre, nem vonódik le a pénz a számlájáról!</p>

<?php } else { ?>

<?php
$cikklista=$remote->GetCikkLista();

function trc($id)
{
	global $remote;
	global $cikklista;

	foreach($cikklista as $cikk)
		if($cikk['id']==$id)
		{
			$c=$cikk;
			$c['bruttoar']=round($c['bruttoar']*0.95);
			break;
		}

	return isset($c['id'])? ("<a href=\"online_vasarlas.php?cikk=" . $id . "\"><img alt=\"Megveszem\" src=\"img/vasarlas_gomb.jpg\" style=\"float: right;\" /></a> " . $c['bruttoar'] . "Ft ") : "&nbsp;";
}

?>

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

<p>Bankkártyája segítségével lehetõsége van online bérletvásárlásra is! Kérjük válassza ki a kívánt tételt, majd a kis <img alt="" src="img/vasarlas_gomb.jpg" /> ikonokra kattintva indíthatja a vásárlást.<br />
Kérjük, a vásárlás megkezdése elõtt olvassa el az ott leírt tájékoztató szöveget! Amennyiben ezt elmulasztja, az emiatt fellépõ esetleges károk miatt felelõsséget nem tudunk vállalni!</p>





<h2>Fitness - Aerobic/Spinning - SPA</h2>
<table class="pricelist full">
<tbody>
<tr>
<th/>
<th colspan="2">Fitness</th>
<th colspan="2">Aerobik</th>
<th colspan="2">Fitness - SPA</th>
<th colspan="2">Aerobik - SPA</th>
</tr>
<tr>
<th/>
<th>14 óráig</th>
<th>egésznap</th>
<th>14 óráig</th>
<th>egésznap</th>
<th>14 óráig</th>
<th>egésznap</th>
<th>14 óráig</th>
<th>egésznap</th>
</tr>
<tr>
<th>1 alkalmas
</th><td class="price" colspan="2"><? print(trc(24))?></td>
<td class="price" colspan="2"><? print(trc(28))?></td>
<td class="price" colspan="2"><? print(trc(41))?></td>
<td class="price" colspan="2"><? print(trc(414))?></td>

</tr>
<tr>
<th colspan="10"/>
</tr>
<tr>
<th>Havi bérlet<br/>
<small>(max. 4 alkalom)</small></th>
<td class="price"><? print(trc(3143))?></td>
<td class="price"><? print(trc(3144))?></td>
<td class="price"><? print(trc(3593))?></td>
<td class="price"><? print(trc(3597))?></td>
<td class="price"><? print(trc(3149))?></td>
<td class="price"><? print(trc(3150))?></td>
<td class="price"><? print(trc(3495))?></td>
<td class="price"><? print(trc(3151))?></td>
</tr>
<tr>
<th colspan="9"/>

</tr>
<tr>
<th>Havi bérlet<br/>
<small>(max. 8 alkalom)</small></th>
<td class="price"><? print(trc(971))?></td>
<td class="price"><? print(trc(25))?></td>
<td class="price"><? print(trc(3594))?></td>
<td class="price"><? print(trc(3598))?></td>
<td class="price"><? print(trc(978))?></td>
<td class="price"><? print(trc(42))?></td>
<td class="price"><? print(trc(3496))?></td>
<td class="price"><? print(trc(417))?></td>
</tr>
<tr>

<th>Kedvezményes*</th>
<td class="price"><? print(trc(3485))?></td>
<td class="price"><? print(trc(3486))?></td>
<td class="price"><? print(trc(3601))?></td>
<td class="price"><? print(trc(3602))?></td>
<td class="price"><? print(trc(3504))?></td>
<td class="price"><? print(trc(3505))?></td>
<td class="price"><? print(trc(3498))?></td>
<td class="price"><? print(trc(3499))?></td>

</tr>
<tr>
<th colspan="9"/>
</tr>
<tr>
<th>Havi bérlet<br/>
<small>(max. 12 alkalom)</small></th>
<td class="price"><? print(trc(972))?></td>
<td class="price"><? print(trc(26))?></td>
<td class="price"><? print(trc(3595))?></td>
<td class="price"><? print(trc(3599))?></td>
<td class="price"><? print(trc(979))?></td>
<td class="price"><? print(trc(43))?></td>
<td class="price"><? print(trc(3497))?></td>
<td class="price"><? print(trc(420))?></td>
</tr>
<tr>
<th>Kedvezményes*</th>
<td class="price"><? print(trc(2168))?></td>
<td class="price"><? print(trc(2169))?></td>
<td class="price"><? print(trc(3603))?></td>
<td class="price"><? print(trc(3604))?></td>
<td class="price"><? print(trc(3506))?></td>
<td class="price"><? print(trc(3519))?></td>
<td class="price"><? print(trc(3500))?></td>
<td class="price"><? print(trc(3501))?></td>
</tr>
<tr>
<th colspan="9"/>
</tr>

<tr>
<th>PRÍMA bérlet<br/>
<small>(Havi korlátlan)</small></th>
<td class="price"><? print(trc(3487))?></td>
<td class="price"><? print(trc(3493))?></td>
<td class="price"><? print(trc(3596))?></td>
<td class="price"><? print(trc(3600))?></td>
<td class="price"><? print(trc(3513))?></td>
<td class="price"><? print(trc(3512))?></td>
<td class="price"><? print(trc(3502))?></td>
<td class="price"><? print(trc(3503))?></td>
</tr>
<tr>
<th>Kedvezményes*</th>
<td class="price"><? print(trc(3488))?></td>
<td class="price"><? print(trc(3516))?></td>
<td class="price"><? print(trc(3605))?></td>
<td class="price"><? print(trc(3494))?></td>
<td class="price"><? print(trc(3508))?></td>
<td class="price"><? print(trc(3509))?></td>
<td class="price"><? print(trc(3510))?></td>
<td class="price"><? print(trc(3511))?></td>
</tr>
<tr>
<th colspan="9"/>
</tr>
</tbody>
</table>
<p>* Diák és nyugdíjas (60 év fölött) kedvezmény</p>
<p>A bérlet-opciók 30 napig érvényesek!</p>
<p>Az újonc jegy csak az elsõ belépéskor érvényes, mellyel mind a három szolgáltatást ki lehet próbálni<br/>
(1 aerobik óra, fitness terem, Spa-Wellness használat).<br/>
Kangoo cipõ bérlése: 500,- Ft</p>
<table class="pricelist">
<tbody>
<tr>
<th>Újonc jegy</th>
<th colspan="2">SPA - Wellness</th>
</tr>
<tr>
<th>Fitness - Aerobik - SPA</th>
<th>Napijegy</th>
<th>Kiegészítõ jegy</th>
</tr>
<tr>
<td class="price">990 Ft</td>
<td class="price"><? print(trc(31))?></td>
<td class="price">1 190 Ft</td>
</tr>
<tr>
<th colspan="4"></th>
</tr>
</tbody>
</table>
<hr/>
<h2>Masszázsok, Testkezelések</h2>
<table class="pricelist full">
<tbody>
<tr>
<th colspan="2"/>
<th colspan="2">30 perc</th>

<th colspan="2">60 perc</th>
<th colspan="2">90 perc</th>
</tr>
<tr>
<th/>
<th>Masszõr</th>
<th>Alkalmi jegy</th>
<th>Bérlet <small>(6 alkalom)</small></th>
<th>Alkalmi jegy</th>
<th>Bérlet <small>(6 alkalom)</small></th>

<th>Alkalmi jegy</th>
<th>Bérlet <small>(6 alkalom)</small></th>
</tr>
<tr>
<th>Svéd masszázs</th>
<th>Rita, Viktor</th>
<td class="price">3 000 Ft</td>
<td class="price"><? print(trc(2959))?></td>
<td class="price">4 500 Ft</td>

<td class="price"><? print(trc(2960))?></td>
<td class="price">6 600 Ft</td>
<td class="price"><? print(trc(2961))?></td>
</tr>
<tr>
<th>Relax masszázs</th>
<th>Rita, Viktor</th>
<td class="price">3 000 Ft</td>
<td class="price"><? print(trc(2959))?></td>
<td class="price">4 500 Ft</td>

<td class="price"><? print(trc(2960))?></td>
<td class="price">6 600 Ft</td>
<td class="price"><? print(trc(2961))?></td>
</tr>
<tr>
<th>Frissítõ masszázs</th>
<th>Rita, Viktor</th>
<td class="price">3 000 Ft</td>
<td class="price"><? print(trc(2959))?></td>
<td class="price">4 500 Ft</td>

<td class="price"><? print(trc(2960))?></td>
<td class="price">6 600 Ft</td>
<td class="price"><? print(trc(2961))?></td>
</tr>
<tr>
<th>Sport masszázs</th>
<th>Rita, Viktor</th>
<td class="price">3 000 Ft</td>
<td class="price"><? print(trc(2959))?></td>
<td class="price">4 500 Ft</td>

<td class="price"><? print(trc(2960))?></td>
<td class="price">6 600 Ft</td>
<td class="price"><? print(trc(2961))?></td>
</tr>
<tr>
<th>Talpmasszázs</th>
<th>Rita, Viktor</th>
<td class="price">3 000 Ft</td>
<td class="price"><? print(trc(2959))?></td>
<td class="price">4 500 Ft</td>

<td class="price"><? print(trc(2960))?></td>
<td>-</td>
<td>-</td>
</tr>
<tr>
<th>Csokimasszázs</th>
<th>Rita, Viktor</th>
<td class="price">3 000 Ft</td>
<td class="price"><? print(trc(2959))?></td>
<td class="price">4 500 Ft</td>

<td class="price"><? print(trc(2960))?></td>
<td class="price">6 600 Ft</td>
<td class="price"><? print(trc(2961))?></td>
</tr>
<tr>
<th>Gyógymasszázs</th>
<th>Viktor</th>
<td class="price">3 000 Ft</td>
<td class="price"><? print(trc(2959))?></td>
<td class="price">4 500 Ft</td>

<td class="price"><? print(trc(2960))?></td>
<td class="price">6 600 Ft</td>
<td class="price"><? print(trc(2961))?></td>
</tr>
<tr>
<th>Cellulit**</th>
<th>Rita</th>
<td>-</td>
<td>-</td>
<td>-</td>

<td>-</td>
<td class="price">7 990 Ft</td>
<td class="price">63 990 Ft</td>
</tr>
<tr>
<th>Ma-Uri</th>
<th>Orsi, Ági</th>
<td>-</td>
<td>-</td>
<td class="price">6 990 Ft</td>

<td class="price"><? print(trc(2998))?></td>
<td class="price">8 990 Ft</td>
<td class="price"><? print(trc(2999))?></td>
</tr>
		<tr>
			<th>Facelift - Arcmasszázs<br/>(csak 60 perc!)<br/><span style='color:red;'>!!!AKCIÓ!!!</span></th>
			<th>Rita</th>
			<td colspan='2'><b>Alkalmi jegy</b><br/>4 500 Ft helyett<br/><span style='color:red'><? print(trc(3640));?></td>
			<td colspan='2'><b>Bérlet (6 alkalom)</b><br/>22 500 Ft   helyett<br/><span style='color:red'><?print(trc(3641));?></span></td>
			<td colspan='2'><b>Bérlet (10 alkalom)</b><br/>36 900 Ft   helyett<br/><span style='color:red'><? print(trc(3642));?></span></td>
		</tr>
<tr>
<th colspan="8"/>
</tr>
</tbody>
</table>
<p>A masszázs bérletek 60 napig érvényesek!</p>
<p>** A cellulit masszázs bérlet 10 alkalmas.</p>
<p>Masszõreink órarend szerint fix idõpontokban állnak vendégeink rendelkezésére.</p>
<p>Kérem, érdeklõdjön a recepción!</p>

<hr/>
<h2>Squash</h2>
<table class="pricelist full">
<tbody>
<tr>
<th colspan="2"></th>
<th>Squash</th>
<th>Squash+SPA</th>
</tr>
<tr>
<th>I. zóna 06-10 óra között</th>
<th rowspan="3">Alkalmi jegy</th>
<td class="price"><? print(trc(3112))?></td>
<td class="price"><? print(trc(4085))?></td>
</tr>
<tr>
<th>II. zóna 10-16 óra között</th>
<td class="price"><? print(trc(3113))?></td>
<td class="price"><? print(trc(4086))?></td>
</tr>
<tr>
<th>III. zóna 16-20 óra között</th>
<td class="price"><? print(trc(3114))?></td>
<td class="price"><? print(trc(4087))?></td>
</tr>
<tr>
<th>I. zóna 06-10 óra között</th>
<th rowspan="3">5 alkalom</th>
<td class="price"><? print(trc(986))?></td>
<td class="price"><? print(trc(4089))?></td>
</tr>
<tr>
<th>II. zóna 10-16 óra között</th>
<td class="price"><? print(trc(985))?></td>
<td class="price"><? print(trc(4090))?></td>
</tr>
<tr>
<th>Egész nap</th>
<td class="price"><? print(trc(987))?></td>
<td class="price"><? print(trc(4091))?></td>
</tr>
<tr>
<th>I. zóna 06-10 óra között</th>
<th rowspan="3">10 alkalom</th>
<td class="price"><? print(trc(1316))?></td>
<td class="price"><? print(trc(4092))?></td>
</tr>
<tr>
<th>II. zóna 10-16 óra között</th>
<td class="price"><? print(trc(1317))?></td>
<td class="price"><? print(trc(4093))?></td>
</tr>
<tr>
<th>Egész nap</th>
<td class="price"><? print(trc(1315))?></td>
<td class="price"><? print(trc(4094))?></td>
</tr>
<tr>
<th>Diák (10-16; hétvége)</th>
<th>Alkalmi jegy</th>
<td class="price"><? print(trc(3115))?></td>
<td class="price"><? print(trc(4088))?></td>
</tr>
<tr>
<th colspan="4"></th>
</tr>
</tbody>
</table>
<p>Hétvégén, egész nap, bármilyen bérlet használható. Pályafoglalás - kizárólag érvényes jeggyel, bérlettel - 30 napra elõre lehetséges.</p>
<p>Az elõzetes pályafoglalást legkésõbb 24 órával az aktuális idõpont elõtt lehet díjmentesen lemondani, ellenkezõ esetben az alkalom a bérletbõl levonásra kerül! A squash bérlet-opciók 60 napig érvényesek! Ütõbérlés: 500,- Ft/ütõ; Labda: 650,- Ft (csak értékesítésre)</p>
<hr/>

<table>
<tr>
<th colspan="2" class="title">Exkluzív tagság</th>
<th class="nobg">&nbsp;</th>
</tr>
<tr>
<th colspan="2"><strong>Az exkluzív tagság a vásárlástól számított érvényességi idõszak végéig lehetõvé<br /> teszi az összes fenti szolgáltatás - nyitvatartási idõn belüli - korlátlan használatát</strong><br />
(Kivéve: infra szauna, squash, szolárium, masszázs)</th>
</tr>
<tr>
<td><strong>3 hónap</strong></td>
<td><?php echo trc(EXKLUZIV_3_HONAP) ?></td>
</tr>
<tr>
<td><strong>6 hónap</strong></td>
<td><?php echo trc(EXKLUZIV_6_HONAP) ?></td>
</tr>
<tr>
<td><strong>12 hónap</strong></td>
<td><?php echo trc(EXKLUZIV_12_HONAP) ?></td>
</tr>
</table>
<h2>Egyebek</h2>
<table class="pricelist full">
<tbody>
<tr>
<th>Szolárium (3 perces)</th>
<th>Gyermekjegy 14 éves korig</th>
<th>Gyerek-karate bérlet (8 alk)</th>
</tr>
<tr>
<td class="price">210 Ft</td>
<td class="price"><? print(trc(1267))?></td>
<td class="price"><? print(trc(1418))?></td>
</tr>
<tr>
<th>Gyermek-megõrzés</th>
<th>Mazsola aerobik bérlet</th>
<th>Internet-használat</th>
</tr>
<tr>
<td class="price">INGYENES</td>
<td class="price"><? print(trc(2712))?></td>
<td class="price">INGYENES</td>
</tr>
<tr>
<th>Lepedõ bérlése </th>

<th>Frottier-köntös bérlése</th>
<th>Elsõ törölközõ INGYENES!</th>
</tr>
<tr>
<td class="price">100 Ft/alk</td>
<td class="price">250 Ft/alk</td>
<td class="price">Második törölközõ bérlése 300 Ft/db</td>
</tr>
<tr>
<th colspan="3"/>
</tr>
</tbody>

</table>
<p>Jó edzést, kellemes idõtöltést kívánunk!</p>














<p>Hétvégén, egész nap, bármilyen bérlet használható.<br />
Pályafoglalás - kizárólag érvényes bérlettel - 30 napra elõre lehetséges.<br />
Az elõzetes pályafoglalást legkésõbb 24 órával az aktuális idõpont elõtt lehet díjmentesen lemondani,
ellenkezõ esetben az alkalom a bérletbõl levonásra kerül!<br />
<strong>A squash bérlet-opciók 60 napig érvényesek!</strong></p>

<?php if (0) { ?>
<table>
<tr>
<th rowspan="2" class="nobg">&nbsp;</th>
<th colspan="2" style="width: 475px;" class="title">Egyenleg feltöltése</th>
</tr>
<tr>
<td>TESZT Feltöltés</td>
<td><a href="online_vasarlas.php?cikk=77777"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>3 Ft</td>
</tr>
</table>
<?php } // if 0 ?>

<?php } ?>

<?php } else { ?>

<br /><br />
<p>Az online vásárláshoz szüksége van egy érvényes egyedi titkos azonosító kódra.<br />
Kérjük igényeljen kódot emailben a <a href="kodigenyles.php">kódigénylés</a> oldalon!</p>
<br />

<?php } // if ($remote->UserCanPayOnline()) ?>

<?php } else { ?>

<br /><br />
<p>Ennek az oldalnak az eléréséhez elõbb be kell jelentkeznie.<br />
Kérjük használja a <a href="felhasznalo.php">Bejelenkezés</a> funkciót!</p>
<br />

<?php } // if ($session ... ) ?>

<?php } else { ?>

<p><strong>Az online vásárlás jelenleg karbantartás miatt nem elérhetõ.</strong></p>
<p>Kérjük, látogasson vissza néhány nap múlva, vagy vásárolja meg bérletét sportközpontunkban személyesen.</p>

<?php } // if (!defined(ONLINE_VASARLAS_SZUNETEL)) ?>


<br /><br />

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>
