<?php define('BW_NOSTAT', 1); ?>
<?php require_once('inc/boot.php') ?>
<?php $CBA_SECTION = 'admin'; ?>
<?php require_once('inc/bwControlcenter.php') ?>
<?php require_once('views/admHeader.php') ?>
<!-- Content Starts Here -->
<?php if($session->GetUserLevel() >= bwSession::EDITOR) { ?>
<h1>Irányítóközpont</h1>

<h2>Kritikus feladatok</h1>

<ul>
  <?php foreach($controlcenter->criticalTask as $item) { ?>
  <li><?php echo $item ?></li>
  <?php } ?>
</ul>

<h2>Másodlagos fontosságú feladatok</h1>

<ul>
  <?php foreach($controlcenter->secondaryTask as $item) { ?>
  <li><?php echo $item ?></li>
  <?php } ?>
</ul>

<br /><br /><br /><br /><br />

<?php } else { define('UNAUTHORIZED', 1); } ?>

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>
