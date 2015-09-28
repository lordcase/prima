<?php require_once('inc/boot.php') ?>
<?php $CBA_SECTION = 'felhasznalo'; ?>
<?php require_once('inc/bwUser.php') ?>
<?php require_once('views/header.php') ?>
<!-- Content Starts Here -->

<?php if($session->logged_in) { ?>

<h1>Felhasználói adatlap módosítása</h1>

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
  <th class="title" colspan="3">Adatmódosítás</th>
</tr>
<tr>
  <th>Email címem*:</th>
  <td><input name="user_email" style="width:170px;" type="text" value="<?php echo $POST->Item('user_email', $session->user['email']) ?>" /></td>
  <td>Ezzel az email címmel jelentkezik be. Javasoljuk, hogy ugyanaz a cím szerepeljen itt, mint amit a CBA Fitnessben történt regisztráció során megadott, különben nem fogja tudni használni az online foglalási rendszerünket.</td>
</tr>
<tr>
  <th>Felhasználói nevem*:</th>
  <td><input name="user_name" style="width:170px;" type="text" value="<?php echo $POST->Item('user_name', $session->user['nick']) ?>" /></td>
  <td>Ezen a néven szólítjuk, és ez a név jelenik meg a vendégkönyvben a hozzászólásainál.</td>
</tr>
<tr>
  <th>Foglalási kódom:</th>
  <td><input name="user_secretcode" style="width:170px;" type="text" value="<?php echo $POST->Item('user_secretcode', $session->user['secret_code']) ?>" /></td>
  <td>Ez egy speciális kód, amely az online foglalási rendszer használatához szükséges. Minden, a CBA Fitnessben bérlettel rendelkezõ vendégünknek van egy egyedi kódja. <strong>A kód nem megváltoztatható</strong>. Amennyiben van bérlete, de még nem rendelkezik ezzel a kóddal, vagy véletlenül kitörölte, akkor a kód igényléséhez <a href="kodigenyles.php">kattintson ide</a>. <strong>Ezt a kódot lehetõleg soha ne árulja el senkinek</strong>, az esetelges visszaélések elkerülése érdekében. Az emiatt keletkezõ károkért/kellemetlenségekért nem tudunk felelõsséget vállalni!</td>
</tr>
<tr>
  <th>Jelszavam:</th>
  <td><input name="user_password1" style="width:170px;" type="password" /></td>
  <td rowspan="2">A jelszó legalább 5, legfeljebb 20 karakter lehet. Ha nem akarja megváltoztatni a jelszót, ezeket a mezõket hagyja üresen. Ez a jelszó a honlapra történõ belépéshez szükséges, nem egyezik meg a foglalási kóddal! Javasoljuk hogy <strong>a jelszavát soha ne árulja el senkinek az esetleges visszaélések elkerülése érdekében</strong>. Az emiatt történõ kellemetlenségekért/károkért nem tudunk felelõsséget vállalni!</td>
</tr>
<tr>
  <th>Jelszó mégegyszer:</th>
  <td><input name="user_password2" style="width:170px;" type="password" /></td>
</tr>
<tr>
  <th>Szeretnék hírlevelet kapni:</th>
  <td><input name="user_subscription" type="checkbox" <?php if($session->user['subscription'] == '1') echo "checked=\"checked\"" ?> /></td>
  <td>Jelölje be ezt a négyzetet, ha kér hírlevelet. Vegye ki a pipát a négyzetbõl, ha szeretné lemondani a hírlevelet.</td>
</tr>
</table>

<br />

<input type="submit" value="Változtatások mentése" />

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
