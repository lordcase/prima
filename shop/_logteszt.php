<?php require_once('inc/boot.php') ?>

<?php

  require_once('inc/bwComponent.php');
  require_once('inc/bwDataset.php');
  require_once('inc/bwLog.php');

  $log->Log('teszt', 'Ez itt a meszidzs.', BW_LOG_LOW);
  
?>

<?php $CBA_SECTION = 'szauna'; ?>
<?php require_once('views/header.php') ?>
<!-- Content Starts Here -->
<h1>bwLog component test</h1>

<p>Hö!</p>

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>
