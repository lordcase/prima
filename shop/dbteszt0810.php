<?php require_once('inc/boot.php') ?>
<?php require_once('inc/bwRemoteServices2.php') ?>
<?php $CBA_SECTION = 'aerobic'; ?>
<?php define('BW_NOSTAT', true); ?>
<?php require_once('views/header.php') ?>
<!-- Content Starts Here -->
<h1>Online vásárlás</h1>

<?php //if ($session->GetUserLevel() > 1) { ?>
<?php if ($session->user['id'] == 1) { ?>

<?php if (isset($_GET['cikk']) && ($cikkId = intval($_GET['cikk'])) && ($cikk = $remote->GetCikk($cikkId))) { ?>

<h2><?php echo $cikk['nev'] ?></h2>

<?php $szolgaltatasok = $remote->GetJegytipusSzolgaltatasai($cikkId); ?>

<?php if (count($szolgaltatasok) > 0) { ?>

<table style="width: 750px;">
<tr>
	<th colspan="1" class="title">Szolgálatások</th>
	<th colspan="2" class="nobg"> </th>
</tr>
<tr>
	<th colspan="2">A választott jegytípus az alábbi szolgáltatásokra veheto igénybe.</th>
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



<?php } else { ?>
<p>Ehhez a jegytipushoz nem található szolgáltatáslista.</p>
<?php } ?>

<?php
	$tranzId = '';
	$posId = '#02299991';
?>

<h2>Tesztvásárlás</h2>

<p>Figyelem!!! Az alábbi urlap elküldésekor <strong>nem történik valódi vásárlás</strong>, csak tesztelésre szolgál. A megadott összeg a számláról <strong>levonásra kerülhet</strong>!</p>

<p>Az urlap mezoi csak tesztelési céllal szerepelnek itt, a végleges verzióban ezek a mezok nem lesznek szerkeszthetok (ár kivételével nem is jelennek majd meg).</p>

<form method="post" action="fiz3.php">

    <table class="input">
      <tr>
        <th>Tranzakció azonositó  *</th>
        <td><input type="text" name="tranzakcioAzonosito" value="<?php echo $tranzId ?>" size="40" maxlength="32" class="text"/></td>
      </tr>
      <tr>
        <th>Shop ID</th>
        <td><input type="text" name="posId" value="<?php echo $posId ?>" size="40" maxlength="15" class="text"/></td>
      </tr>
      <tr>
        <th>Összeg (HUF)</th>
        <td><input type="text" name="osszeg" value="<?php echo $cikk['bruttoar'] ?>" size="15" maxlength="10" class="text"/></td>
      </tr>
      <tr>
        <th>Shop megjegyzés</th>
        <td><input type="text" name="shopMegjegyzes" value="Teszt üzemu vásárlás - PHP" size="40"  class="text"/></td>
      </tr>
      <tr>
        <th>Vissza link</th>
        <td><input type="text" name="backURL" value="<?php echo 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) ?>fiz3.php?func=fiz3?fizetesValasz=true&amp;posId=<?php echo $posId ?>&amp;tranzId=<?php echo $tranzId ?>" size="40"  class="text"/><br/>
        </td>
      </tr>
      <tr>
        <td colspan="2" class="info">* = Opcionális</td>
      </tr>
     </table>
     
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

    <input type="submit" name="ok" value="Tesztvásárlás indul"/>

</form>

<p><a href="dbteszt0810.php">vissza</a></p>

<?php } else { ?>

<?php $cikkek = $remote->GetCikklista(); ?>

<?php if (count($cikkek) > 0) { ?>

<table style="width: 750px;">
<tr>
	<th colspan="3" class="title">Vásárolható cikkek</th>
	<th colspan="3" class="nobg"> </th>
</tr>
<tr>
	<th>Név</th>
	<th>Egység</th>
	<th>Bruttó ár</th>
	<th>ÁFA kulcs</th>
	<th>Jegy?</th>
	<th>Alkalmak</th>
</tr>

<?php foreach ($cikkek as $cikk) { ?>
<tr>
	<td><a href="dbteszt0810.php?cikk=<?php echo $cikk['id'] ?>"><?php echo $cikk['nev'] . ' (#' . $cikk['id'] . ')' ?></a></td>
	<td><?php echo $cikk['mennyisegiegyseg'] ?></td>
	<td><?php echo $cikk['bruttoar'] ?></td>
	<td><?php echo $cikk['afakulcs'] ?></td>
	<td><?php echo $cikk['jegy'] ?></td>
	<td><?php echo $cikk['alkalmak'] ?></td>
</tr>
<?php } ?>

</table>

<?php } else { ?>
<p>Jelenleg nincsenek elérheto cikkek.</p>
<?php } ?>

<?php } ?>

<?php } // if ($session ... ) ?>

<br /><br />

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>