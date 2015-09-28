<?php require_once('inc/boot.php') ?>
<?php $CBA_SECTION = 'felhasznalo'; ?>
<?php require_once('inc/bwUser.php') ?>
<?php require_once('views/header.php') ?>
<!-- Content Starts Here -->

<?php if($session->logged_in) { ?>

<h1>Felhaszn�l�i adatlap</h1>

<p>A rendszerben t�rolt adatai a k�vetkez�k:</p>

<ul>
  <li>N�v: <strong><?php echo $session->user['nick'] ?></strong></li>
  <li>Email: <?php echo $session->user['email'] ?></li>
  <li>Foglal�si k�d: <?php echo ($session->user['secret_code'] == "") ? '<strong>nincs megadva</strong>' : '*****' ?></li>
  <li>H�rlev�l el�fizet�s: <?php echo $session->user['subscription'] ? 'igen' : 'nem' ?></li>
  <li>Regisztr�ci� d�tuma: <?php echo $session->user['created'] ?></li>
  <li>Legut�bbi bejelentkez�s: <?php echo $session->user['last_login'] ?></li>
</ul>

<p><a href="adatmodositas.php">Adatok m�dos�t�sa</a></p>

<p>Ha szeretn� megv�ltoztatni felhaszn�l�nev�t, emailc�m�t, jelszav�t, h�rlev�l-el�fizet�i st�tusz�t, vagy m�g nincs foglal�si k�dja, kattintson a fenti linkre.</p>
<p>Amennyiben foglalni szeretne valamelyik �r�nkra vagy a squashra, <strong>kattintson a fejl�cben tal�lhat� "Online foglal�s" men�pontra</strong>!

<?php } else { ?>

<h1>Bejelentkez�s</h1>

<?php if($database->feedback != '') { ?>

<p style="border: 1px solid red; padding: 10px;"><strong><?php echo $database->feedback; ?></strong></p>

<?php } ?>
<br />
<p>Ha regisztr�lt tag, email c�me �s jelszava megad�s�v�l itt bejelentkezhet. M�g nem regisztr�lt tag? <a href="regisztracio.php">Regisztr�ljon</a>!</p>
<br /><br />
<p>�rv�nyes b�rlettel �s e-mail c�mmel rendelkez� regisztr�lt tagjaink a honlapon kereszt�l is foglalhatnak helyet kedvenc aerobic �r�ikra, valamint a fallabdap�ly�kra. Ennek a szolg�ltat�snak az ig�nybe v�tel�hez <strong>el�sz�r meg kell adnia az e-mail c�m�t Sportk�zpontunkban</strong>, majd regisztr�lnia kell az oldalon. A regisztr�ci� ut�n el�g itt bejelentkezni �s az online �rarend seg�ts�g�vel szabadon v�logathat az �r�ink k�z�tt.<br />
Am�g az e-mail c�m�t nem adta meg a recepci�nkon, addig ezt a szolg�ltat�st nem tudja ig�nybe venni!</p>


<form name="login" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">

<input type="hidden" name="formId" value="USER:LOGIN" />
<input type="hidden" name="referrer" value="<?php echo $_SERVER['HTTP_REFERER'] ?>" />

<div style="text-align: center; ">
<table style="width: 320px; margin-left: auto; margin-right: auto; ">
<tr>
  <th class="title" colspan="2">Bejelentkez�s</th>
</tr>
<tr>
  <th>Email c�mem:</th>
  <td><input name="email" style="width:170px;" type="text" value="<?php echo $POST->Item('email', '') ?>" /></td>
</tr>
<tr>
  <th>Jelszavam:</th>
  <td><input name="password" style="width:170px;" type="password" /></td>
</tr>
<!--tr>
  <td colspan="2"><input name="remember" type="checkbox" /> ez a sz�m�t�g�p eml�kezzen az email c�memre</td>
</tr-->
</table>

<br />

<input type="submit" value="Bejelentkez�s" />

</div>

</form>

<br /><br />


<?php } ?>

<br /><br />

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>
