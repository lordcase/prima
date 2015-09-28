<?php require_once('inc/boot.php') ?>

<?php

  require_once('inc/bwComponent.php');
  require_once('inc/bwDataset.php');
  
  $lolDS = new bwDataset();
  
  $lolDS->SetTable('cba_instructor');
  $lolDS->SetFields('id, nick, name, picture, body, active');
  $lolDS->SetPrimaryKey('id');
  $lolDS->SetSort('nick');
  
  $lolDS->SelectAll();
   
?>

<?php $CBA_SECTION = 'szauna'; ?>
<?php require_once('views/header.php') ?>
<!-- Content Starts Here -->
<h1>bwDataset component test</h1>

<ul>
<?php foreach($lolDS->item as $item) { ?>
  <li><?php echo $item['nick'] ?></li>
<?php } ?>
</ul>

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>
