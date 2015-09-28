<?php require_once('inc/boot.php') ?>
<?php require_once('inc/bwRemoteServices2.php') ?>
<?php require_once('inc/bwTranzakcio.php') ?>
<?php $CBA_SECTION = 'aerobic'; ?>
<?php define('BW_NOSTAT', true); ?>
<?php require_once('views/header.php') ?>
<!-- Content Starts Here -->
<h1>Online v�s�rl�s</h1>


<?php //if ($session->user['id'] == 1) { ?>
<?php if ($session->logged_in) { ?>
<?php if ($remote->UserCanPayOnline()) { ?>

<?php
	$vasarlasok = $tranzakcio->GetTranzakciokForVevo($session->user['id']);
	
	if (is_array($vasarlasok) && count($vasarlasok))
	{
?>

<br />
<p><a href="online_vasarlas.php">Vissza</a> a v�s�rl�s men�ponthoz.</p>

<p>Ezen a t�bl�zaton k�vetheti nyomon az eddigi v�s�rl�sait.</p>

<table style="width: 750px;">
<tr>
	<th colspan="2" class="title">V�s�rl�s-t�rt�net</th>
	<th colspan="3" class="nobg"> </th>
</tr>
<tr>
	<th>N�v</th>
	<th>�rv�nyess�g kezdete</th>
	<th>V�s�rl�s ideje</th>
	<th>Fizetett �sszeg</th>
	<th>St�tusz</th>
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
	<td><?php echo $vasarlas['processed'] == 1 ? 'feldolgoz�s alatt' : 'megv�s�rolva' ?></td>
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
<p>Nincs v�s�rl�s.</p>
<?php
	}
?>

<br />
<p><a href="online_vasarlas.php">Vissza</a> a v�s�rl�s men�ponthoz.</p>
<?php } else { ?>

<br /><br />
<p>Az online v�s�rl�shoz sz�ks�ge van egy �rv�nyes egyedi titkos azonos�t� k�dra.<br />
K�rj�k ig�nyeljen k�dot emailben a <a href="http://cbafitness.hu/kodigenyles.php">k�dig�nyl�s</a> oldalon!</p>
<br />

<?php } // if ($remote->UserCanPayOnline()) ?>

<?php } else { ?>

<br /><br />
<p>Ennek az oldalnak az el�r�s�hez el�bb be kell jelentkeznie.<br />
K�rj�k haszn�lja a <a href="http://cbafitness.hu/felhasznalo.php">Bejelenkez�s</a> funkci�t!</p>
<br />

<?php } // if ($session ... ) ?>

<br /><br />

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>