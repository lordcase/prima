<?php define('BW_NOSTAT', 1); ?>
<?php require_once('inc/boot.php') ?>
<?php $CBA_SECTION = 'admin'; ?>

<?php
	error_reporting(1);

  require_once('inc/bwComponent.php');
  require_once('inc/bwDataset.php');
  require_once('inc/bwLog.php');
  
  $log->SetSort('created', true);
  $log->SelectAll();

?>

<?php require_once('views/admHeader.php') ?>
<!-- Content Starts Here -->
<?php if($session->GetUserLevel() >= bwSession::ADMIN) { ?>

<h1>Eseménynapló</h1>

<div style="text-align: center; ">
<table style="width: 90%; margin-left: auto; margin-right: auto; ">
  <tr>
    <th>#</th>
    <th>Szint</th>
    <th>Modul</th>
    <th>PHP_SELF</th>
    <th>Referer</th>
    <th>IP</th>
    <th>user ID</th>
    <th>dátum</th>
    <th>Szöveg</th>
  </tr>
  <?php foreach($log->item as $item) { ?>
  <tr>
    <td><?php echo $item['id'] ?></td>
    <td><?php echo $item['level'] ?></td>
    <td><?php echo $item['module'] ?></td>
    <td><?php echo $item['php_self'] ?></td>
    <td><?php echo $item['referer'] ?></td>
    <td><?php echo $item['ip'] ?></td>
    <td><?php echo $item['user_id'] ?></td>
    <td><?php echo $item['created'] ?></td>
    <td><?php echo $item['body'] ?></td>
  </tr>
  <?php } ?>
</table>
</div>

&nbsp; &nbsp;

<?php } else { define('UNAUTHORIZED', 1); } ?>

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>
