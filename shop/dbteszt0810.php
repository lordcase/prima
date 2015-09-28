<?php require_once('inc/boot.php') ?>
<?php require_once('inc/bwRemoteServices2.php') ?>
<?php $CBA_SECTION = 'aerobic'; ?>
<?php define('BW_NOSTAT', true); ?>
<?php require_once('views/header.php') ?>
<!-- Content Starts Here -->
<h1>Online v�s�rl�s</h1>

<?php //if ($session->GetUserLevel() > 1) { ?>
<?php if ($session->user['id'] == 1) { ?>

<?php if (isset($_GET['cikk']) && ($cikkId = intval($_GET['cikk'])) && ($cikk = $remote->GetCikk($cikkId))) { ?>

<h2><?php echo $cikk['nev'] ?></h2>

<?php $szolgaltatasok = $remote->GetJegytipusSzolgaltatasai($cikkId); ?>

<?php if (count($szolgaltatasok) > 0) { ?>

<table style="width: 750px;">
<tr>
	<th colspan="1" class="title">Szolg�lat�sok</th>
	<th colspan="2" class="nobg"> </th>
</tr>
<tr>
	<th colspan="2">A v�lasztott jegyt�pus az al�bbi szolg�ltat�sokra veheto ig�nybe.</th>
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
<p>Ehhez a jegytipushoz nem tal�lhat� szolg�ltat�slista.</p>
<?php } ?>

<?php
	$tranzId = '';
	$posId = '#02299991';
?>

<h2>Tesztv�s�rl�s</h2>

<p>Figyelem!!! Az al�bbi urlap elk�ld�sekor <strong>nem t�rt�nik val�di v�s�rl�s</strong>, csak tesztel�sre szolg�l. A megadott �sszeg a sz�ml�r�l <strong>levon�sra ker�lhet</strong>!</p>

<p>Az urlap mezoi csak tesztel�si c�llal szerepelnek itt, a v�gleges verzi�ban ezek a mezok nem lesznek szerkeszthetok (�r kiv�tel�vel nem is jelennek majd meg).</p>

<form method="post" action="fiz3.php">

    <table class="input">
      <tr>
        <th>Tranzakci� azonosit�  *</th>
        <td><input type="text" name="tranzakcioAzonosito" value="<?php echo $tranzId ?>" size="40" maxlength="32" class="text"/></td>
      </tr>
      <tr>
        <th>Shop ID</th>
        <td><input type="text" name="posId" value="<?php echo $posId ?>" size="40" maxlength="15" class="text"/></td>
      </tr>
      <tr>
        <th>�sszeg (HUF)</th>
        <td><input type="text" name="osszeg" value="<?php echo $cikk['bruttoar'] ?>" size="15" maxlength="10" class="text"/></td>
      </tr>
      <tr>
        <th>Shop megjegyz�s</th>
        <td><input type="text" name="shopMegjegyzes" value="Teszt �zemu v�s�rl�s - PHP" size="40"  class="text"/></td>
      </tr>
      <tr>
        <th>Vissza link</th>
        <td><input type="text" name="backURL" value="<?php echo 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) ?>fiz3.php?func=fiz3?fizetesValasz=true&amp;posId=<?php echo $posId ?>&amp;tranzId=<?php echo $tranzId ?>" size="40"  class="text"/><br/>
        </td>
      </tr>
      <tr>
        <td colspan="2" class="info">* = Opcion�lis</td>
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

    <input type="submit" name="ok" value="Tesztv�s�rl�s indul"/>

</form>

<p><a href="dbteszt0810.php">vissza</a></p>

<?php } else { ?>

<?php $cikkek = $remote->GetCikklista(); ?>

<?php if (count($cikkek) > 0) { ?>

<table style="width: 750px;">
<tr>
	<th colspan="3" class="title">V�s�rolhat� cikkek</th>
	<th colspan="3" class="nobg"> </th>
</tr>
<tr>
	<th>N�v</th>
	<th>Egys�g</th>
	<th>Brutt� �r</th>
	<th>�FA kulcs</th>
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
<p>Jelenleg nincsenek el�rheto cikkek.</p>
<?php } ?>

<?php } ?>

<?php } // if ($session ... ) ?>

<br /><br />

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>