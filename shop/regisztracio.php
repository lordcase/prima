<?php require_once('inc/boot.php') ?>
<?php $CBA_SECTION = 'orarend'; ?>
<?php require_once('inc/bwUser.php') ?>
<?php require_once('views/header.php') ?>
<!-- Content Starts Here -->

<h1>Regisztr�ci�</h1>

<?php if($session->logged_in) { ?>

<p>Kedves <strong><?php echo $session->user['nick'] ?></strong>!</p>

<p>�r�l�nk, hogy m�r regisztr�lt felhaszn�l�nk vagy! Ha az adataidat szeretn�d m�dos�tani, ezt megteheted a <a href="felhasznalo.php">felhaszn�l�i adatlapon</a>.</p>

<?php } else { ?>


<?php if($user->feedback != '') { ?>

<p style="border: 1px solid red; padding: 10px;"><strong><?php echo $user->feedback; ?></strong></p>

<?php } ?>

<?php if(!$user->saved) { ?>

<?php if($user->feedback == '') { ?>

<h2>Mi�rt �rdemes regisztr�lni?</h2>

<p><strong>E-mail c�mmel rendelkez� regisztr�lt tagjaink</strong> a honlapon kereszt�l is foglalhatnak helyet kedvenc aerobic �r�ikra, valamint �rv�nyes squash b�rlettel a fallabdap�ly�kra.<br />
Ennek a szolg�ltat�snak az ig�nybe v�tel�hez <strong>el�sz�r meg kell adnia az e-mail c�m�t a Sportk�zpontunkban</strong>, majd regisztr�lnia kell az oldalunkon. A regisztr�ci� ut�n el�g itt bejelentkezni �s az online �rarend seg�ts�g�vel szabadon v�logathat az �r�ink k�z�tt.<br />
K�rj�k, hogy -ha m�g nem tette meg- adja meg e-mail c�m�t a Sportk�zpontunkban, mert am�g ezt nem tette meg, addig ezt a szolg�ltat�st nem tudja ig�nybe venni!<br />
<strong>Figyelem! Foglal�s csak a b�rlet �rv�nyess�gi hat�ridej�n bel�l, valamint az �rv�nyes alkalmak sz�m�ig lehets�ges!</strong></p>

<?php } ?>

<h2>Reigsztr�ci�s �rlap</h2>

<p>A <strong>csillaggal jel�lt (*)</strong> mez�k kit�lt�se k�telez�.</p>

<form name="login" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">

<input type="hidden" name="formId" value="USER:REGISTER" />
<input type="hidden" name="referrer" value="<?php echo $_SERVER['HTTP_REFERER'] ?>" />

<div style="text-align: center; ">
<table style="width: 80%; margin-left: auto; margin-right: auto; ">
<tr>
  <th class="title" colspan="3">Regisztr�ci�</th>
</tr>
<tr>
  <th>Email c�mem*:</th>
  <td><input name="user_email" style="width:170px;" type="text" value="<?php echo $POST->Item('user_email') ?>" /></td>
  <td>Ezzel az e-mail c�mmel fogsz tudni bejelentkezni. K�rj�k, hogy ugyanazt az e-mail c�met add meg itt is, mint amit a recepci�nkon, k�l�nben nem fogod tudni haszn�lni az online foglal�si rendszer�nket!</td>
</tr>
<tr>
  <th>Felhaszn�l�i nevem*:</th>
  <td><input name="user_name" style="width:170px;" type="text" value="<?php echo $POST->Item('user_name') ?>" /></td>
  <td>Ezen a n�ven fogunk sz�l�tani, �s ez a n�v jelenik meg a vend�gk�nyvben a hozz�sz�l�saidn�l.</td>
</tr>
<tr>
  <th>Jelszavam*:</th>
  <td><input name="user_password1" style="width:170px;" type="password" /></td>
  <td>A jelsz� legal�bb 5, legfeljebb 20 karakter lehet. Ezzel a jelsz�val fogsz tudni bel�pni a rendszer�nkbe. <strong>Figyelem! A jelszavad lehet�leg soha ne �ruld el senkinek</strong>, nehogy vissza�ljenek vele. Az ilyen esetek miatt keletkez� kellemetlens�gek�rt/vissza�l�sek�rt nem tudunk felel�ss�get v�llalni!</td>
</tr>
<tr>
  <th>Jelsz� m�gegyszer*:</th>
  <td><input name="user_password2" style="width:170px;" type="password" /></td>
  <td>&nbsp;</td>
</tr>
<tr>
  <th>Szeretn�k h�rlevelet kapni:</th>
  <td><input name="user_subscription" type="checkbox" checked="checked" /></td>
  <td>Jel�ld be ezt a n�gyzetet, ha k�rsz h�rlevelet. Ezt b�rmikor lemondhatod.</td>
</tr>
</table>

<br />

<input type="submit" value="Regisztr�ci�" />

</div>

</form>

<br /><br />

<?php } else { ?>

<p>A megadott email c�m �s jelsz� seg�ts�g�vel b�rmikor <a href="felhasznalo.php">bejelentkezhetsz</a>.</p>

<?php } ?>

<?php } ?>

<br /><br />

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>
