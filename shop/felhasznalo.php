<?php require_once('inc/boot.php') ?>
<?php $CBA_SECTION = 'felhasznalo'; ?>
<?php require_once('inc/bwUser.php') ?>
<?php require_once('views/header.php') ?>
<!-- Content Starts Here -->

<?php if($session->logged_in) { ?>

<h1>Felhasználói adatlap</h1>

<p>A rendszerben tárolt adatai a következõk:</p>

<ul>
  <li>Név: <strong><?php echo $session->user['nick'] ?></strong></li>
  <li>Email: <?php echo $session->user['email'] ?></li>
  <li>Foglalási kód: <?php echo ($session->user['secret_code'] == "") ? '<strong>nincs megadva</strong>' : '*****' ?></li>
  <li>Hírlevél elõfizetés: <?php echo $session->user['subscription'] ? 'igen' : 'nem' ?></li>
  <li>Regisztráció dátuma: <?php echo $session->user['created'] ?></li>
  <li>Legutóbbi bejelentkezés: <?php echo $session->user['last_login'] ?></li>
</ul>

<p><a href="adatmodositas.php">Adatok módosítása</a></p>

<p>Ha szeretné megváltoztatni felhasználónevét, emailcímét, jelszavát, hírlevél-elõfizetõi státuszát, vagy még nincs foglalási kódja, kattintson a fenti linkre.</p>
<p>Amennyiben foglalni szeretne valamelyik óránkra vagy a squashra, <strong>kattintson a fejlécben található "Online foglalás" menüpontra</strong>!

<?php } else { ?>

<h1>Bejelentkezés</h1>

<?php if($database->feedback != '') { ?>

<p style="border: 1px solid red; padding: 10px;"><strong><?php echo $database->feedback; ?></strong></p>

<?php } ?>
<br />
<p>Ha regisztrált tag, email címe és jelszava megadásávál itt bejelentkezhet. Még nem regisztrált tag? <a href="regisztracio.php">Regisztráljon</a>!</p>
<br /><br />
<p>Érvényes bérlettel és e-mail címmel rendelkezõ regisztrált tagjaink a honlapon keresztül is foglalhatnak helyet kedvenc aerobic óráikra, valamint a fallabdapályákra. Ennek a szolgáltatásnak az igénybe vételéhez <strong>elõször meg kell adnia az e-mail címét Sportközpontunkban</strong>, majd regisztrálnia kell az oldalon. A regisztráció után elég itt bejelentkezni és az online órarend segítségével szabadon válogathat az óráink között.<br />
Amíg az e-mail címét nem adta meg a recepciónkon, addig ezt a szolgáltatást nem tudja igénybe venni!</p>


<form name="login" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">

<input type="hidden" name="formId" value="USER:LOGIN" />
<input type="hidden" name="referrer" value="<?php echo $_SERVER['HTTP_REFERER'] ?>" />

<div style="text-align: center; ">
<table style="width: 320px; margin-left: auto; margin-right: auto; ">
<tr>
  <th class="title" colspan="2">Bejelentkezés</th>
</tr>
<tr>
  <th>Email címem:</th>
  <td><input name="email" style="width:170px;" type="text" value="<?php echo $POST->Item('email', '') ?>" /></td>
</tr>
<tr>
  <th>Jelszavam:</th>
  <td><input name="password" style="width:170px;" type="password" /></td>
</tr>
<!--tr>
  <td colspan="2"><input name="remember" type="checkbox" /> ez a számítógép emlékezzen az email címemre</td>
</tr-->
</table>

<br />

<input type="submit" value="Bejelentkezés" />

</div>

</form>

<br /><br />


<?php } ?>

<br /><br />

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>
