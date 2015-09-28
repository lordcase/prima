<?php
$image = htmlspecialchars($_GET['img']);
$lang = htmlspecialchars($_GET['lang']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" lang="hu" />
<title><?php echo ($lang == "en") ? "CBA Fitness Image Gallery" : "CBA Fitness képgaléria" ?></title>
<link rel="stylesheet" type="text/css" href="css/cbafitness.css" />

</head>
<body>
<div id="popup">
  <div><a href="javascript:window.close()"><img alt="<?php echo ($lang == "en") ? "CBA Fitness Image Gallery" : "CBA Fitness képgaléria" ?>" src="<?php echo "img/content/galeria/" . $image  ?>" /></a></div>
  <p><?php echo ($lang == "en") ? "Click on the image to close window" : "Kattintson a képre az ablak bezárásához" ?></p>
</div>
</body>
</html>
