<?php $meta->SetMeta($CBA_SECTION) ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
<meta name="generator" content="PSPad editor, www.pspad.com">
<title>Príma Wellness</title>
<link rel="stylesheet" type="text/css" href="css/cbafitness.css">
<script type="text/javascript" src="js/IEhover.js"></script>
<script type="text/javascript" src="js/imagepopup.js"></script>
</head>
<body>

<div id="userContainer">
<div id="user" class="<?php echo $session->logged_in ? 'loggedIn' : 'loggedOut' ?>" style="top:25px">
  <?php if($session->logged_in)  { ?>
  <form id="logout" name="logout" method="post" action="index.php">
  Szia, <strong><?php echo $session->user['nick'] ?></strong>! &nbsp;
    <input type="hidden" name="formId" value="USER:LOGOUT" />
  <a href="felhasznalo.php">Adatlapom</a> &nbsp;
<!--  <a href="#" onClick="document.logout.submit()">Kijelentkezés</a>-->
  <?php } else { ?>
  <a href="felhasznalo.php">Bejelentkezés/regisztráció</a>
  <?php } ?>
  </form>
</div>
</div>

<h1>Adminisztráció</h1>

<div id="menu">
  <ul id="mainmenu">
  <?php if($session->GetUserLevel() >= bwSession::EDITOR) { ?>
    <li><a href="adminisztracio.php">Irányítóközpont</a>
    <li><a href="orarend2.php">Órarend</a></li>
    <li><a href="edzoadmin.php">Edzők</a></li>
    <li><a href="oratipusadmin.php">Óratípusok</a></li>
	<?php if($session->GetUserLevel() >= bwSession::MODERATOR) { ?>
    <!--li><a href="vendegkonyv2.php">Vendégkönyv</a></li-->
	<?php } ?>
    <li><a href="felhasznalok.php">Felhasználók</a></li>
    <li><a href="statisztika.php">Statisztika</a></li>
    <li><a href="naplo.php">Log</a></li>
  <?php } ?>
    <li><a href="index.php">Vissza</a></li>
  </ul>
</div>

<div class="main">
<div id="content">
