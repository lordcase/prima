<?php if (!isset($CBA_LANG)) $CBA_LANG = "hu" ?>
<?php $meta->SetMeta($CBA_SECTION, $CBA_LANG) ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
<meta name="generator" content="PSPad editor, www.pspad.com">
<meta name="keywords" content="<?php echo $meta->keywords; ?>">
<title><?php echo $meta->title; ?></title>
<link rel="stylesheet" type="text/css" href="css/cbafitness.css">
<script type="text/javascript" src="js/IEhover.js"></script>
<script type="text/javascript" src="js/imagepopup.js"></script>
</head>
<body>

<?php if ($CBA_LANG == "hu") { ?>
<div id="userContainer">
<div id="user" class="<?php echo $session->logged_in ? 'loggedIn' : 'loggedOut' ?>">
  <?php if($session->logged_in)  { ?>
  <form id="logout" name="logout" method="post" action="index.php">
  Szia, <strong><?php echo $session->user['nick'] ?></strong>! &nbsp;
    <input type="hidden" name="formId" value="USER:LOGOUT" />
    <?php if($session->GetUserLevel() >= bwSession::EDITOR)  { ?>
      <a href="adminisztracio.php">Irányítóközpont</a> &nbsp;
    <?php } ?>
  <a href="felhasznalo.php">Adatlapom</a> &nbsp;
  <a href="online_vasarlas.php"><strong>Online vásárlás (új!)</strong></a> &nbsp;
  <a href="foglalas.php">Online foglalás!</a> &nbsp;
  <a href="#" onClick="document.logout.submit()">Kijelentkezés</a>
  <?php } else { ?>
  <a href="felhasznalo.php">Bejelentkezés/regisztráció</a>
  <?php } ?>
  </form>
</div>
</div>
<?php } ?>

<?php if(!$session->logged_in)  { ?>
<div id="language">
	<a href="<?php echo ($CBA_LANG == "hu") ? "index_en.php" : "index.php" ?>"><?php echo ($CBA_LANG == "hu") ? "English" : "Magyar" ?></a>
</div>
<?php } ?>

<div id="fejlec">
  <?php if($CBA_SECTION=="index") { ?>
    <img alt="CBA Fitness" src="img/flash.jpg" />
  <?php } else { ?>
    <img alt="CBA Fitness" src="img/fejlec-<?php echo $meta->sectionId; ?>.jpg" />
  <?php } ?>
</div>

<?php include($CBA_LANG == "en" ? "views/menu_en.php" : "views/menu_hu.php"); ?>

<?php if(($CBA_SECTION=="index") && ($CBA_LANG=="hu") ) { ?>
<div class="main" id="kezdolap">
<?php } else { ?>
<div class="main">
<?php } ?>

<div id="content">
