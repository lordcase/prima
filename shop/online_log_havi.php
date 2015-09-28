<?php require_once('inc/boot.php') ?>
<?php require_once('inc/bwRemoteServices2.php') ?>
<?php require_once('inc/bwTranzakcio.php') ?>
<?php $CBA_SECTION = 'aerobic'; ?>
<?php define('BW_NOSTAT', true); ?>
<?php require_once('views/admHeader.php') ?>
<?php require_once('inc/bwDateTime.php') ?>
<!-- Content Starts Here -->
<h1>Online v�s�rl�s jelent�sek</h1>

<?php if ($session->GetUserLevel() >= bwSession::EDITOR) { ?>

<?php
	if (bwDateTime::isPostedYearMonthValid('havibontas'))
	{
		$havibontas_year = bwDateTime::getYearFromPostedYearMonth('havibontas');
		$havibontas_month = bwDateTime::getMonthFromPostedYearMonth('havibontas');
	}
	else
	{
		$havibontas_year = date('Y');
		$havibontas_month = date('m');
	}

	//if (($tId = intval($_GET['tid'])) && ($vasarlasok = $tranzakcio->GetTranzakciokForTermek($tId)))
	$vasarlasok = $tranzakcio->GetHaviLista($havibontas_year, $havibontas_month);
	if(true)
	{
?>
<h2>Havi bont�s: <?php echo $havibontas_year ?>. <?php echo bwDateTime::getMonthLabel($havibontas_month) ?></h2>
<form method="post" action="online_log_havi.php" >
<?php echo bwDateTime::getYearMonthController('havibontas', '2008-12', bwDateTime::NOW, $havibontas_year . '-' . $havibontas_month); ?>

<input type="submit" value="Mehet" />
</form>
<?php

		if (is_array($vasarlasok) && count($vasarlasok))
		{
?>
<table style="width: 750px;">
<tr>
	<th colspan="2" class="title">Havi v�s�rl�s-t�rt�net</th>
	<th colspan="3" class="nobg"> </th>
</tr>
<tr>
	<th>N�v</th>
	<th>�rv�nyess�g kezdete</th>
	<th>V�s�rl�s ideje</th>
	<th>V�s�rl�</th>
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
	<td><?php echo $vasarlas['user_name'] ?></td>
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
<p><a href="online_log.php">Vissza</a></p>

<?php
	}
?>
<?php } // if ($session ... ) ?>

<br /><br />

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>