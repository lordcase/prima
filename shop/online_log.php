<?php require_once('inc/boot.php') ?>
<?php require_once('inc/bwRemoteServices2.php') ?>
<?php require_once('inc/bwTranzakcio.php') ?>
<?php $CBA_SECTION = 'aerobic'; ?>
<?php define('BW_NOSTAT', true); ?>
<?php require_once('views/admHeader.php') ?>
<!-- Content Starts Here -->
<h1>Online v�s�rl�s jelent�sek</h1>

<?php if ($session->GetUserLevel() >= bwSession::EDITOR) { ?>

<ul>
	<li><a href="online_log_havi.php">Havi bont�s</a></li>
	<li><a href="online_log_vasarlo.php">V�s�rl�k szerinti bont�s</a></li>
	<li><a href="online_log_termek.php">Term�kek szerinti bont�s</a></li>
</ul>

<?php } // if ($session ... ) ?>

<br /><br />

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>