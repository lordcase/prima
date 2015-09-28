<?php require_once('inc/boot.php') ?>
<?php if (!defined('ONLINE_VASARLAS_SZUNETEL')) { ?>
<?php require_once('inc/bwRemoteServices2.php') ?>
<?php require_once('inc/bwTranzakcio.php') ?>
<?php } ?>
<?php $CBA_SECTION = 'online'; ?>
<?php define('BW_NOSTAT', true); ?>
<?php require_once('views/header.php') ?>
<!-- Content Starts Here -->
<h1>Online v�s�rl�s</h1>
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

<h2>V�s�rl�s ind�t�sa</h2>


<p>A "v�s�rl�s ind�t�sa" gomb seg�ts�g�vel tudja elind�tani a fizet�si folyamatot. A gombra kattintva �tker�l az OTP Bank titkos�tott oldal�ra, ahol meg kell adnia a bankk�rty�ja adatait, valamint az el�rhet�s�g�t. <strong>A Pr�ma Wellness nem t�rolja az �n k�rty�j�nak adatait, ezeket csak a bank rendszere fogja l�tni.</strong> A v�s�rl�s b�rmilyen bank �ltal kiadott internetes v�s�rl�sra alkalmas k�rty�val megt�rt�nhet, nem csak az OTP Bank k�rty�ival. Amennyiben nem rendelkezik ilyen bankk�rty�val, k�rj�k k�rje sz�mlavezet� bankja seg�ts�g�t!<br />
K�rj�k, hogy minden esetben ellen�rizze a megv�s�rolni k�v�nt t�telt a v�s�rl�s megkezd�se el�tt, valamint k�sz�tse el� az adatait, mert a banki oldalon limit�lt id� �ll rendelkez�s�re az adatok megad�s�ra a vissza�l�sek eler�l�se �rdek�ben! Amennyiben a banki oldalon d�nt �gy, hogy m�gsem k�v�nja megv�s�rolni az adott szolg�ltat�st, ott is megszak�thatja majd a v�s�rl�st a "m�gsem" gomb seg�ts�g�vel.</p>
<p style="font-size: 12px; color: #FF0000"><strong>A v�s�rl�s menete: a banki oldalon ki kell t�lteni az adatmez�ket (bankk�rtya adatai, n�v, c�m, stb.), majd az "Elk�ld" gomb seg�ts�g�vel el lehet ind�tani a fizet�st. Ezut�n egy adatellen�rz� oldalra jut, ahonnan az �jabb "Elk�ld" gomb seg�ts�g�vel tov�bb lehet l�pni a v�s�rl�s v�gleges�t�s�hez. Ezut�n a "Vissza a bolti oldalra" gombbal fejezheti be a v�s�rl�st.</p>


<p><strong>Cikk megnevez�se</strong>: <?php echo $cikk['nev'] ?><br />
<strong>Fizetend� �sszeg</strong>: <?php echo $cikk['bruttoar'] ?> Forint</p>

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
    <input type="hidden" name="shopMegjegyzes" value="Pr�ma Wellness v�s�rl�s: <?php echo $cikk['nev'] ?>" size="40"  class="text"/>
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

    <input type="submit" name="ok" value="V�s�rl�s ind�t�sa"/>

</form>
<br />
<?php } else { ?>
<p><strong><?php echo $cikk['nev'] ?></strong> v�s�rl�sa jelenleg nem lehets�ges.</p>

<p><?php echo $jegyErvenyessegErrorMessage; ?></p>

<?php }  ?>

<p><a href="online_vasarlas.php">Vissza a v�s�rl�s f�oldalra.*</a><br />
*A fentebb felt�ntetett szolg�ltat�s nem ker�l kifizet�sre, nem von�dik le a p�nz a sz�ml�j�r�l!</p>

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

<h2>Az �n jelenlegi �rv�nyes, megv�s�rolt jegyei</h2>

<table>
<tr>
	<th>Jegy neve</th>
	<th>�rv�nyess�g kezdete</th>
	<th>�rv�nyess�g v�ge</th>
	<th>Alkalmak</th>
	<th>Felhaszn�lhat� alkalmak</th>
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

<p><a href="online_vasarlasaim.php">V�s�rl�st�rt�net</a></p>

<h2>V�s�rl�s</h2>

<p>Bankk�rty�ja seg�ts�g�vel lehet�s�ge van online b�rletv�s�rl�sra is! K�rj�k v�lassza ki a k�v�nt t�telt, majd a kis <img alt="" src="img/vasarlas_gomb.jpg" /> ikonokra kattintva ind�thatja a v�s�rl�st.<br />
K�rj�k, a v�s�rl�s megkezd�se el�tt olvassa el az ott le�rt t�j�koztat� sz�veget! Amennyiben ezt elmulasztja, az emiatt fell�p� esetleges k�rok miatt felel�ss�get nem tudunk v�llalni!</p>





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
<th>14 �r�ig</th>
<th>eg�sznap</th>
<th>14 �r�ig</th>
<th>eg�sznap</th>
<th>14 �r�ig</th>
<th>eg�sznap</th>
<th>14 �r�ig</th>
<th>eg�sznap</th>
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
<th>Havi b�rlet<br/>
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
<th>Havi b�rlet<br/>
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

<th>Kedvezm�nyes*</th>
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
<th>Havi b�rlet<br/>
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
<th>Kedvezm�nyes*</th>
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
<th>PR�MA b�rlet<br/>
<small>(Havi korl�tlan)</small></th>
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
<th>Kedvezm�nyes*</th>
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
<p>* Di�k �s nyugd�jas (60 �v f�l�tt) kedvezm�ny</p>
<p>A b�rlet-opci�k 30 napig �rv�nyesek!</p>
<p>Az �jonc jegy csak az els� bel�p�skor �rv�nyes, mellyel mind a h�rom szolg�ltat�st ki lehet pr�b�lni<br/>
(1 aerobik �ra, fitness terem, Spa-Wellness haszn�lat).<br/>
Kangoo cip� b�rl�se: 500,- Ft</p>
<table class="pricelist">
<tbody>
<tr>
<th>�jonc jegy</th>
<th colspan="2">SPA - Wellness</th>
</tr>
<tr>
<th>Fitness - Aerobik - SPA</th>
<th>Napijegy</th>
<th>Kieg�sz�t� jegy</th>
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
<h2>Massz�zsok, Testkezel�sek</h2>
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
<th>Massz�r</th>
<th>Alkalmi jegy</th>
<th>B�rlet <small>(6 alkalom)</small></th>
<th>Alkalmi jegy</th>
<th>B�rlet <small>(6 alkalom)</small></th>

<th>Alkalmi jegy</th>
<th>B�rlet <small>(6 alkalom)</small></th>
</tr>
<tr>
<th>Sv�d massz�zs</th>
<th>Rita, Viktor</th>
<td class="price">3 000 Ft</td>
<td class="price"><? print(trc(2959))?></td>
<td class="price">4 500 Ft</td>

<td class="price"><? print(trc(2960))?></td>
<td class="price">6 600 Ft</td>
<td class="price"><? print(trc(2961))?></td>
</tr>
<tr>
<th>Relax massz�zs</th>
<th>Rita, Viktor</th>
<td class="price">3 000 Ft</td>
<td class="price"><? print(trc(2959))?></td>
<td class="price">4 500 Ft</td>

<td class="price"><? print(trc(2960))?></td>
<td class="price">6 600 Ft</td>
<td class="price"><? print(trc(2961))?></td>
</tr>
<tr>
<th>Friss�t� massz�zs</th>
<th>Rita, Viktor</th>
<td class="price">3 000 Ft</td>
<td class="price"><? print(trc(2959))?></td>
<td class="price">4 500 Ft</td>

<td class="price"><? print(trc(2960))?></td>
<td class="price">6 600 Ft</td>
<td class="price"><? print(trc(2961))?></td>
</tr>
<tr>
<th>Sport massz�zs</th>
<th>Rita, Viktor</th>
<td class="price">3 000 Ft</td>
<td class="price"><? print(trc(2959))?></td>
<td class="price">4 500 Ft</td>

<td class="price"><? print(trc(2960))?></td>
<td class="price">6 600 Ft</td>
<td class="price"><? print(trc(2961))?></td>
</tr>
<tr>
<th>Talpmassz�zs</th>
<th>Rita, Viktor</th>
<td class="price">3 000 Ft</td>
<td class="price"><? print(trc(2959))?></td>
<td class="price">4 500 Ft</td>

<td class="price"><? print(trc(2960))?></td>
<td>-</td>
<td>-</td>
</tr>
<tr>
<th>Csokimassz�zs</th>
<th>Rita, Viktor</th>
<td class="price">3 000 Ft</td>
<td class="price"><? print(trc(2959))?></td>
<td class="price">4 500 Ft</td>

<td class="price"><? print(trc(2960))?></td>
<td class="price">6 600 Ft</td>
<td class="price"><? print(trc(2961))?></td>
</tr>
<tr>
<th>Gy�gymassz�zs</th>
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
<th>Orsi, �gi</th>
<td>-</td>
<td>-</td>
<td class="price">6 990 Ft</td>

<td class="price"><? print(trc(2998))?></td>
<td class="price">8 990 Ft</td>
<td class="price"><? print(trc(2999))?></td>
</tr>
		<tr>
			<th>Facelift - Arcmassz�zs<br/>(csak 60 perc!)<br/><span style='color:red;'>!!!AKCI�!!!</span></th>
			<th>Rita</th>
			<td colspan='2'><b>Alkalmi jegy</b><br/>4 500 Ft helyett<br/><span style='color:red'><? print(trc(3640));?></td>
			<td colspan='2'><b>B�rlet (6 alkalom)</b><br/>22 500 Ft   helyett<br/><span style='color:red'><?print(trc(3641));?></span></td>
			<td colspan='2'><b>B�rlet (10 alkalom)</b><br/>36 900 Ft   helyett<br/><span style='color:red'><? print(trc(3642));?></span></td>
		</tr>
<tr>
<th colspan="8"/>
</tr>
</tbody>
</table>
<p>A massz�zs b�rletek 60 napig �rv�nyesek!</p>
<p>** A cellulit massz�zs b�rlet 10 alkalmas.</p>
<p>Massz�reink �rarend szerint fix id�pontokban �llnak vend�geink rendelkez�s�re.</p>
<p>K�rem, �rdekl�dj�n a recepci�n!</p>

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
<th>I. z�na 06-10 �ra k�z�tt</th>
<th rowspan="3">Alkalmi jegy</th>
<td class="price"><? print(trc(3112))?></td>
<td class="price"><? print(trc(4085))?></td>
</tr>
<tr>
<th>II. z�na 10-16 �ra k�z�tt</th>
<td class="price"><? print(trc(3113))?></td>
<td class="price"><? print(trc(4086))?></td>
</tr>
<tr>
<th>III. z�na 16-20 �ra k�z�tt</th>
<td class="price"><? print(trc(3114))?></td>
<td class="price"><? print(trc(4087))?></td>
</tr>
<tr>
<th>I. z�na 06-10 �ra k�z�tt</th>
<th rowspan="3">5 alkalom</th>
<td class="price"><? print(trc(986))?></td>
<td class="price"><? print(trc(4089))?></td>
</tr>
<tr>
<th>II. z�na 10-16 �ra k�z�tt</th>
<td class="price"><? print(trc(985))?></td>
<td class="price"><? print(trc(4090))?></td>
</tr>
<tr>
<th>Eg�sz nap</th>
<td class="price"><? print(trc(987))?></td>
<td class="price"><? print(trc(4091))?></td>
</tr>
<tr>
<th>I. z�na 06-10 �ra k�z�tt</th>
<th rowspan="3">10 alkalom</th>
<td class="price"><? print(trc(1316))?></td>
<td class="price"><? print(trc(4092))?></td>
</tr>
<tr>
<th>II. z�na 10-16 �ra k�z�tt</th>
<td class="price"><? print(trc(1317))?></td>
<td class="price"><? print(trc(4093))?></td>
</tr>
<tr>
<th>Eg�sz nap</th>
<td class="price"><? print(trc(1315))?></td>
<td class="price"><? print(trc(4094))?></td>
</tr>
<tr>
<th>Di�k (10-16; h�tv�ge)</th>
<th>Alkalmi jegy</th>
<td class="price"><? print(trc(3115))?></td>
<td class="price"><? print(trc(4088))?></td>
</tr>
<tr>
<th colspan="4"></th>
</tr>
</tbody>
</table>
<p>H�tv�g�n, eg�sz nap, b�rmilyen b�rlet haszn�lhat�. P�lyafoglal�s - kiz�r�lag �rv�nyes jeggyel, b�rlettel - 30 napra el�re lehets�ges.</p>
<p>Az el�zetes p�lyafoglal�st legk�s�bb 24 �r�val az aktu�lis id�pont el�tt lehet d�jmentesen lemondani, ellenkez� esetben az alkalom a b�rletb�l levon�sra ker�l! A squash b�rlet-opci�k 60 napig �rv�nyesek! �t�b�rl�s: 500,- Ft/�t�; Labda: 650,- Ft (csak �rt�kes�t�sre)</p>
<hr/>

<table>
<tr>
<th colspan="2" class="title">Exkluz�v tags�g</th>
<th class="nobg">&nbsp;</th>
</tr>
<tr>
<th colspan="2"><strong>Az exkluz�v tags�g a v�s�rl�st�l sz�m�tott �rv�nyess�gi id�szak v�g�ig lehet�v�<br /> teszi az �sszes fenti szolg�ltat�s - nyitvatart�si id�n bel�li - korl�tlan haszn�lat�t</strong><br />
(Kiv�ve: infra szauna, squash, szol�rium, massz�zs)</th>
</tr>
<tr>
<td><strong>3 h�nap</strong></td>
<td><?php echo trc(EXKLUZIV_3_HONAP) ?></td>
</tr>
<tr>
<td><strong>6 h�nap</strong></td>
<td><?php echo trc(EXKLUZIV_6_HONAP) ?></td>
</tr>
<tr>
<td><strong>12 h�nap</strong></td>
<td><?php echo trc(EXKLUZIV_12_HONAP) ?></td>
</tr>
</table>
<h2>Egyebek</h2>
<table class="pricelist full">
<tbody>
<tr>
<th>Szol�rium (3 perces)</th>
<th>Gyermekjegy 14 �ves korig</th>
<th>Gyerek-karate b�rlet (8 alk)</th>
</tr>
<tr>
<td class="price">210 Ft</td>
<td class="price"><? print(trc(1267))?></td>
<td class="price"><? print(trc(1418))?></td>
</tr>
<tr>
<th>Gyermek-meg�rz�s</th>
<th>Mazsola aerobik b�rlet</th>
<th>Internet-haszn�lat</th>
</tr>
<tr>
<td class="price">INGYENES</td>
<td class="price"><? print(trc(2712))?></td>
<td class="price">INGYENES</td>
</tr>
<tr>
<th>Leped� b�rl�se </th>

<th>Frottier-k�nt�s b�rl�se</th>
<th>Els� t�r�lk�z� INGYENES!</th>
</tr>
<tr>
<td class="price">100 Ft/alk</td>
<td class="price">250 Ft/alk</td>
<td class="price">M�sodik t�r�lk�z� b�rl�se 300 Ft/db</td>
</tr>
<tr>
<th colspan="3"/>
</tr>
</tbody>

</table>
<p>J� edz�st, kellemes id�t�lt�st k�v�nunk!</p>














<p>H�tv�g�n, eg�sz nap, b�rmilyen b�rlet haszn�lhat�.<br />
P�lyafoglal�s - kiz�r�lag �rv�nyes b�rlettel - 30 napra el�re lehets�ges.<br />
Az el�zetes p�lyafoglal�st legk�s�bb 24 �r�val az aktu�lis id�pont el�tt lehet d�jmentesen lemondani,
ellenkez� esetben az alkalom a b�rletb�l levon�sra ker�l!<br />
<strong>A squash b�rlet-opci�k 60 napig �rv�nyesek!</strong></p>

<?php if (0) { ?>
<table>
<tr>
<th rowspan="2" class="nobg">&nbsp;</th>
<th colspan="2" style="width: 475px;" class="title">Egyenleg felt�lt�se</th>
</tr>
<tr>
<td>TESZT Felt�lt�s</td>
<td><a href="online_vasarlas.php?cikk=77777"><img alt="Megveszem" src="img/vasarlas_gomb.jpg" style="float: right;" /></a>3 Ft</td>
</tr>
</table>
<?php } // if 0 ?>

<?php } ?>

<?php } else { ?>

<br /><br />
<p>Az online v�s�rl�shoz sz�ks�ge van egy �rv�nyes egyedi titkos azonos�t� k�dra.<br />
K�rj�k ig�nyeljen k�dot emailben a <a href="kodigenyles.php">k�dig�nyl�s</a> oldalon!</p>
<br />

<?php } // if ($remote->UserCanPayOnline()) ?>

<?php } else { ?>

<br /><br />
<p>Ennek az oldalnak az el�r�s�hez el�bb be kell jelentkeznie.<br />
K�rj�k haszn�lja a <a href="felhasznalo.php">Bejelenkez�s</a> funkci�t!</p>
<br />

<?php } // if ($session ... ) ?>

<?php } else { ?>

<p><strong>Az online v�s�rl�s jelenleg karbantart�s miatt nem el�rhet�.</strong></p>
<p>K�rj�k, l�togasson vissza n�h�ny nap m�lva, vagy v�s�rolja meg b�rlet�t sportk�zpontunkban szem�lyesen.</p>

<?php } // if (!defined(ONLINE_VASARLAS_SZUNETEL)) ?>


<br /><br />

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>
