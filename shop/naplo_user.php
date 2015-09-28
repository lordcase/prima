<?php define('BW_NOSTAT', 1); ?>
<?php require_once('inc/boot.php') ?>
<?php $CBA_SECTION = 'admin'; ?>

<?php
	error_reporting(1);

  require_once('inc/bwComponent.php');
  require_once('inc/bwDataset.php');
  require_once('inc/bwLog.php');
  

  $log->SetSort('created', true);
  $log->SelectFoglalasByUser(intval($_GET['felhasznalo']));

?>

<?php require_once('views/admHeader.php') ?>
<!-- Content Starts Here -->
<?php if($session->GetUserLevel() >= bwSession::ADMIN) { ?>

<h1>Esem�nynapl�: kiv�laszott felhaszn�l� foglal�sai</h1>

<p><a href="online_log.php">Online v�s�rl�si napl�</a><?php if($session->GetUserLevel() >= bwSession::ADMIN) { ?> | <a href="teljesnaplo.php">Teljes biztons�gi napl�</a><?php } ?></p>

<div style="text-align: center; ">
<table style="width: 90%; margin-left: auto; margin-right: auto; ">
  <tr>
    <th rowspan="2">#</th>
    <th>D�tum</th>
    <th>Felhaszn�l�</th>
    <th>IP-c�m</th>
    <th>K�r�s innen</th>
	</tr>
    <th colspan="4">Esem�ny</th>
  </tr>
	<tr>
		<td colspan=5 class="nobg" style="height: 8px;"></td>
	</tr>
  <?php foreach($log->item as $item) { ?>
  <tr>
    <td rowspan="2"><?php echo $item['id'] ?></td>
    <td><?php echo $item['created'] ?></td>
    <td><a href="mailto:<?php echo $item['user_email'] ?>"><?php echo $item['user_nick'] ?></a></td>
    <td><?php echo $item['ip'] ?></td>
    <td><?php echo $item['referer'] ?></td>
	</tr>
	<tr>
    <td colspan="4"><?php echo $item['body'] ?></td>
  </tr>
	<tr>
		<td colspan=5 class="nobg" style="height: 8px;"></td>
	</tr>
  <?php } ?>
</table>
</div>

&nbsp; &nbsp;

<?php } else { define('UNAUTHORIZED', 1); } ?>

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>
