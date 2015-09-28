<?php require_once('inc/boot.php') ?>
<?php $CBA_SECTION = 'felhasznalo'; ?>
<?php require_once('inc/bwUser.php') ?>
<?php require_once('views/header.php') ?>
<!-- Content Starts Here -->

<?php if($session->logged_in) { ?>

<h1>Felhaszn�l�i adatlap m�dos�t�sa</h1>

<p><a href="felhasznalo.php">Vissza az adatlaphoz</a></p>

<?php if($user->feedback != '') { ?>

<p style="border: 1px solid red; padding: 10px;"><strong><?php echo $user->feedback; ?></strong></p>

<?php } ?>

<?php if(!$user->saved) { ?>

<form name="userdata" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">

<input type="hidden" name="formId" value="USER:UPDATE" />
<input type="hidden" name="user_id" value="<?php echo $session->user['id'] ?>" />

<div style="text-align: center; ">
<table style="width: 80%; margin-left: auto; margin-right: auto; ">
<tr>
  <th class="title" colspan="3">Adatm�dos�t�s</th>
</tr>
<tr>
  <th>Email c�mem*:</th>
  <td><input name="user_email" style="width:170px;" type="text" value="<?php echo $POST->Item('user_email', $session->user['email']) ?>" /></td>
  <td>Ezzel az email c�mmel jelentkezik be. Javasoljuk, hogy ugyanaz a c�m szerepeljen itt, mint amit a CBA Fitnessben t�rt�nt regisztr�ci� sor�n megadott, k�l�nben nem fogja tudni haszn�lni az online foglal�si rendszer�nket.</td>
</tr>
<tr>
  <th>Felhaszn�l�i nevem*:</th>
  <td><input name="user_name" style="width:170px;" type="text" value="<?php echo $POST->Item('user_name', $session->user['nick']) ?>" /></td>
  <td>Ezen a n�ven sz�l�tjuk, �s ez a n�v jelenik meg a vend�gk�nyvben a hozz�sz�l�sain�l.</td>
</tr>
<tr>
  <th>Foglal�si k�dom:</th>
  <td><input name="user_secretcode" style="width:170px;" type="text" value="<?php echo $POST->Item('user_secretcode', $session->user['secret_code']) ?>" /></td>
  <td>Ez egy speci�lis k�d, amely az online foglal�si rendszer haszn�lat�hoz sz�ks�ges. Minden, a CBA Fitnessben b�rlettel rendelkez� vend�g�nknek van egy egyedi k�dja. <strong>A k�d nem megv�ltoztathat�</strong>. Amennyiben van b�rlete, de m�g nem rendelkezik ezzel a k�ddal, vagy v�letlen�l kit�r�lte, akkor a k�d ig�nyl�s�hez <a href="kodigenyles.php">kattintson ide</a>. <strong>Ezt a k�dot lehet�leg soha ne �rulja el senkinek</strong>, az esetelges vissza�l�sek elker�l�se �rdek�ben. Az emiatt keletkez� k�rok�rt/kellemetlens�gek�rt nem tudunk felel�ss�get v�llalni!</td>
</tr>
<tr>
  <th>Jelszavam:</th>
  <td><input name="user_password1" style="width:170px;" type="password" /></td>
  <td rowspan="2">A jelsz� legal�bb 5, legfeljebb 20 karakter lehet. Ha nem akarja megv�ltoztatni a jelsz�t, ezeket a mez�ket hagyja �resen. Ez a jelsz� a honlapra t�rt�n� bel�p�shez sz�ks�ges, nem egyezik meg a foglal�si k�ddal! Javasoljuk hogy <strong>a jelszav�t soha ne �rulja el senkinek az esetleges vissza�l�sek elker�l�se �rdek�ben</strong>. Az emiatt t�rt�n� kellemetlens�gek�rt/k�rok�rt nem tudunk felel�ss�get v�llalni!</td>
</tr>
<tr>
  <th>Jelsz� m�gegyszer:</th>
  <td><input name="user_password2" style="width:170px;" type="password" /></td>
</tr>
<tr>
  <th>Szeretn�k h�rlevelet kapni:</th>
  <td><input name="user_subscription" type="checkbox" <?php if($session->user['subscription'] == '1') echo "checked=\"checked\"" ?> /></td>
  <td>Jel�lje be ezt a n�gyzetet, ha k�r h�rlevelet. Vegye ki a pip�t a n�gyzetb�l, ha szeretn� lemondani a h�rlevelet.</td>
</tr>
</table>

<br />

<input type="submit" value="V�ltoztat�sok ment�se" />

</div>

</form>

<br /><br />

<?php } ?>

<?php } else { ?>

<p>Nem vagy bejelentkezve.</p>

<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />

<?php } ?>


<br /><br />

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>
