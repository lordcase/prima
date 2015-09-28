<?php require_once('inc/boot.php') ?>
<?php require_once('inc/bwRemoteServices2.php') ?>
<?php require_once('inc/bwTranzakcio.php') ?>
<?php $CBA_SECTION = 'aerobic'; ?>
<?php define('BW_NOSTAT', true); ?>
<?php require_once('views/admHeader.php') ?>
<!-- Content Starts Here -->
<h1>Online vásárlás jelentések</h1>

<?php if ($session->GetUserLevel() >= bwSession::EDITOR) { ?>

<ul>
	<li><a href="online_log_havi.php">Havi bontás</a></li>
	<li><a href="online_log_vasarlo.php">Vásárlók szerinti bontás</a></li>
	<li><a href="online_log_termek.php">Termékek szerinti bontás</a></li>
</ul>

<?php } // if ($session ... ) ?>

<br /><br />

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>