<?php require_once('inc/boot.php') ?>
<?php require_once('inc/bwRemoteServices2.php') ?>
<?php require_once('inc/bwTranzakcio.php') ?>
<?php $CBA_SECTION = 'aerobic'; ?>
<?php define('BW_NOSTAT', true); ?>
<?php require_once('views/header.php') ?>
<!-- Content Starts Here -->
<h1>Online vásárlás</h1>


<?php //if ($session->user['id'] == 1) { ?>
<?php if ($session->logged_in) { ?>
<?php if ($remote->UserCanPayOnline()) { ?>

<?php
	$vasarlasok = $tranzakcio->GetTranzakciokForVevo($session->user['id']);
	
	if (is_array($vasarlasok) && count($vasarlasok))
	{
?>

<br />
<p><a href="online_vasarlas.php">Vissza</a> a vásárlás menüponthoz.</p>

<p>Ezen a táblázaton követheti nyomon az eddigi vásárlásait.</p>

<table style="width: 750px;">
<tr>
	<th colspan="2" class="title">Vásárlás-történet</th>
	<th colspan="3" class="nobg"> </th>
</tr>
<tr>
	<th>Név</th>
	<th>Érvényesség kezdete</th>
	<th>Vásárlás ideje</th>
	<th>Fizetett összeg</th>
	<th>Státusz</th>
</tr>
<?php
		foreach ($vasarlasok as $vasarlas)
		{
?>
<tr>
	<td><?php echo $vasarlas['product_name'] ?></td>
	<td><?php echo $vasarlas['start_date'] ?></td>
	<td><?php echo $vasarlas['created'] ?></td>
	<td><?php echo $vasarlas['price'] ?> Ft</td>
	<td><?php echo $vasarlas['processed'] == 1 ? 'feldolgozás alatt' : 'megvásárolva' ?></td>
</tr>
<?php
		}
?>
</table>
<?php
	}
	else
	{
?>
<p>Nincs vásárlás.</p>
<?php
	}
?>

<br />
<p><a href="online_vasarlas.php">Vissza</a> a vásárlás menüponthoz.</p>
<?php } else { ?>

<br /><br />
<p>Az online vásárláshoz szüksége van egy érvényes egyedi titkos azonosító kódra.<br />
Kérjük igényeljen kódot emailben a <a href="http://cbafitness.hu/kodigenyles.php">kódigénylés</a> oldalon!</p>
<br />

<?php } // if ($remote->UserCanPayOnline()) ?>

<?php } else { ?>

<br /><br />
<p>Ennek az oldalnak az eléréséhez elõbb be kell jelentkeznie.<br />
Kérjük használja a <a href="http://cbafitness.hu/felhasznalo.php">Bejelenkezés</a> funkciót!</p>
<br />

<?php } // if ($session ... ) ?>

<br /><br />

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>