<?php require_once('inc/boot.php') ?>
<?php require_once('inc/bwRemoteServices2.php') ?>
<?php require_once('inc/bwTranzakcio.php') ?>
<?php $CBA_SECTION = 'aerobic'; ?>
<?php define('BW_NOSTAT', true); ?>
<?php require_once('views/admHeader.php') ?>
<!-- Content Starts Here -->
<h1>Online v�s�rl�s jelent�sek</h1>

<?php if ($session->GetUserLevel() >= bwSession::EDITOR) { ?>

<?php
	if (($vId = intval($_GET['vid'])) && ($vasarlasok = $tranzakcio->GetTranzakciokForVevo($vId)))
	{
?>
<h2>V�s�rl�</h2>
<?php

		if (is_array($vasarlasok) && count($vasarlasok))
		{
?>
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
<p><a href="online_log_vasarlo.php">Vissza</a></p>
<?php
	}
	else
	{
		$vasarlok = $tranzakcio->getVevoLista();
		if (is_array($vasarlok) && count($vasarlok))
		{
?>
<h2>V�s�rl�k list�ja</h2>
<ul>
<?php
			foreach ($vasarlok as $vasarlo)
			{
?>
	<li><a href="online_log_vasarlo.php?vid=<?php echo $vasarlo['id'] ?>"><?php echo $vasarlo['nick'] ?></a></li>
<?php
			}
?>
</ul>
<?php
		}
		else
		{
?>
<p>Nincsenek v�s�rl�k.</p>
<?php
		}
?>
<p><a href="online_log.php">Vissza</a></p>
<?php
	}

?>
<?php } // if ($session ... ) ?>

<br /><br />

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>