<?php
$movie = htmlspecialchars($_GET['mov']);
$lang = htmlspecialchars($_GET['lang']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" lang="<?php echo $lang; ?>" />
<title><?php echo ($lang == "en") ? "CBA Fitness Center - Panorama Movie" : "CBA Fitness körpanoráma mozi" ?></title>
<link rel="stylesheet" type="text/css" href="css/cbafitness.css" />

</head>
<body>
<div id="popup">

  <object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab" height="316" width="700">
  <param name="src" value="<?php echo 'mov/CbaFitness-' . $movie . '.mov' ?>">
  <param name="controller" value="true">
  <embed type="video/quicktime" src="<?php echo 'mov/CbaFitness-' . $movie . '.mov' ?>" controller="true" pluginspace="http://www.apple.com/quicktime/download/" height="316" width="700">
  </object>

  <p><?php echo ($lang == "en") ? "Click on the image to move the camera with the left mouse button" : "A kamera irányításához kattintson a képre és a bal egérgombot lenyomva tartva mozgassa az egeret." ?></p>
  
  <div><a href="javascript:window.close()"><?php echo ($lang == "en") ? "close window" : "ablak bezárása" ?></a></div>
</div>
</body>
</html>
