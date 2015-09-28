<?php require_once('inc/boot.php') ?>
<?php $CBA_SECTION = 'orarend'; ?>
<?php require_once('inc/bwUser.php') ?>
<?php require_once('views/header.php') ?>
<!-- Content Starts Here -->

<h1>Regisztráció</h1>

<?php if($session->logged_in) { ?>

<p>Kedves <strong><?php echo $session->user['nick'] ?></strong>!</p>

<p>Örülünk, hogy már regisztrált felhasználónk vagy! Ha az adataidat szeretnéd módosítani, ezt megteheted a <a href="felhasznalo.php">felhasználói adatlapon</a>.</p>

<?php } else { ?>


<?php if($user->feedback != '') { ?>

<p style="border: 1px solid red; padding: 10px;"><strong><?php echo $user->feedback; ?></strong></p>

<?php } ?>

<?php if(!$user->saved) { ?>

<?php if($user->feedback == '') { ?>

<h2>Miért érdemes regisztrálni?</h2>

<p><strong>E-mail címmel rendelkezõ regisztrált tagjaink</strong> a honlapon keresztül is foglalhatnak helyet kedvenc aerobic óráikra, valamint érvényes squash bérlettel a fallabdapályákra.<br />
Ennek a szolgáltatásnak az igénybe vételéhez <strong>elõször meg kell adnia az e-mail címét a Sportközpontunkban</strong>, majd regisztrálnia kell az oldalunkon. A regisztráció után elég itt bejelentkezni és az online órarend segítségével szabadon válogathat az óráink között.<br />
Kérjük, hogy -ha még nem tette meg- adja meg e-mail címét a Sportközpontunkban, mert amíg ezt nem tette meg, addig ezt a szolgáltatást nem tudja igénybe venni!<br />
<strong>Figyelem! Foglalás csak a bérlet érvényességi határidején belül, valamint az érvényes alkalmak számáig lehetséges!</strong></p>

<?php } ?>

<h2>Reigsztrációs ûrlap</h2>

<p>A <strong>csillaggal jelölt (*)</strong> mezõk kitöltése kötelezõ.</p>

<form name="login" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">

<input type="hidden" name="formId" value="USER:REGISTER" />
<input type="hidden" name="referrer" value="<?php echo $_SERVER['HTTP_REFERER'] ?>" />

<div style="text-align: center; ">
<table style="width: 80%; margin-left: auto; margin-right: auto; ">
<tr>
  <th class="title" colspan="3">Regisztráció</th>
</tr>
<tr>
  <th>Email címem*:</th>
  <td><input name="user_email" style="width:170px;" type="text" value="<?php echo $POST->Item('user_email') ?>" /></td>
  <td>Ezzel az e-mail címmel fogsz tudni bejelentkezni. Kérjük, hogy ugyanazt az e-mail címet add meg itt is, mint amit a recepciónkon, különben nem fogod tudni használni az online foglalási rendszerünket!</td>
</tr>
<tr>
  <th>Felhasználói nevem*:</th>
  <td><input name="user_name" style="width:170px;" type="text" value="<?php echo $POST->Item('user_name') ?>" /></td>
  <td>Ezen a néven fogunk szólítani, és ez a név jelenik meg a vendégkönyvben a hozzászólásaidnál.</td>
</tr>
<tr>
  <th>Jelszavam*:</th>
  <td><input name="user_password1" style="width:170px;" type="password" /></td>
  <td>A jelszó legalább 5, legfeljebb 20 karakter lehet. Ezzel a jelszóval fogsz tudni belépni a rendszerünkbe. <strong>Figyelem! A jelszavad lehetõleg soha ne áruld el senkinek</strong>, nehogy visszaéljenek vele. Az ilyen esetek miatt keletkezõ kellemetlenségekért/visszaélésekért nem tudunk felelõsséget vállalni!</td>
</tr>
<tr>
  <th>Jelszó mégegyszer*:</th>
  <td><input name="user_password2" style="width:170px;" type="password" /></td>
  <td>&nbsp;</td>
</tr>
<tr>
  <th>Szeretnék hírlevelet kapni:</th>
  <td><input name="user_subscription" type="checkbox" checked="checked" /></td>
  <td>Jelöld be ezt a négyzetet, ha kérsz hírlevelet. Ezt bármikor lemondhatod.</td>
</tr>
</table>

<br />

<input type="submit" value="Regisztráció" />

</div>

</form>

<br /><br />

<?php } else { ?>

<p>A megadott email cím és jelszó segítségével bármikor <a href="felhasznalo.php">bejelentkezhetsz</a>.</p>

<?php } ?>

<?php } ?>

<br /><br />

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>
