<?php require_once('inc/boot.php') ?>
<?php require_once('inc/bwRemoteServices2.php') ?>
<?php require_once('inc/bwTranzakcio.php') ?>
<?php $CBA_SECTION = 'aerobic'; ?>
<?php define('BW_NOSTAT', true); ?>
<?php require_once('views/admHeader.php') ?>
<!-- Content Starts Here -->
<h1>Online vásárlás jelentések</h1>

<?php if ($session->GetUserLevel() >= bwSession::EDITOR) { ?>

<?php
	if (($vId = intval($_GET['vid'])) && ($vasarlasok = $tranzakcio->GetTranzakciokForVevo($vId)))
	{
?>
<h2>Vásárló</h2>
<?php

		if (is_array($vasarlasok) && count($vasarlasok))
		{
?>
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
<p><a href="online_log_vasarlo.php">Vissza</a></p>
<?php
	}
	else
	{
		$vasarlok = $tranzakcio->getVevoLista();
		if (is_array($vasarlok) && count($vasarlok))
		{
?>
<h2>Vásárlók listája</h2>
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
<p>Nincsenek vásárlók.</p>
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