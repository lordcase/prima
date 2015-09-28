<?php define('BW_NOSTAT', 1); ?>
<?php require_once('inc/boot.php') ?>
<?php $CBA_SECTION = 'admin'; ?>
<?php require_once('inc/bwInstructor.php') ?>
<?php require_once('inc/common/bwUploader.php') ?>
<?php require_once('inc/common/bwImageUploader.php') ?>
<?php require_once('views/admHeader.php') ?>
<!-- Content Starts Here -->
<?php if($session->GetUserLevel() >= bwSession::EDITOR) { ?>

<?php if(($instructor->id == 0) && (!isset($_GET['uj']))) { ?>

<h1>Edz�k adminisztr�ci�ja</h1>

<div style="text-align: center; ">
<table style="width: 70%; margin-left: auto; margin-right: auto; ">
  <tr>
    <th>Becen�v</th>
    <th>Teljes n�v</th>
		<th colspan="2">Milyen edz�</th>
    <th>�r�i a h�ten</th>
    <th>�r�i j�v�h�ten</th>
    <th>Adatlap</th>
  </tr>
  <?php foreach($instructor->item as $instr) { ?>
  <tr>
    <td><a href="<?php echo $instructor->GetFormURL($instr['id']); ?>"><?php echo $instr['nick'] ?></a></td>
    <td><?php echo $instr['name'] ?></td>
		<td><?php echo $instr['is_aerobic'] ? "aerobic" : "&nbsp;" ?></td>
		<td><?php echo $instr['is_fitness'] ? "szem�lyi" : "&nbsp;" ?></td>
    <td><?php echo $instructor->CountClasses($instr['id']); ?></td>
    <td><?php echo $instructor->CountClasses($instr['id'], 2); ?></td>
    <td><?php echo $instr['active'] ? 'publik�lva' : 'rejtve' ?></td>
  </tr>
  <?php } ?>
</table>
</div>

&nbsp; &nbsp;

<h2>�j edz� l�trehoz�sa</h2>

<p>�j edz� l�trehoz�s�hoz kattints az al�bbi gombra.</p>

<form name="instructorNewForm" method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?uj' ?>"
<div style="text-align: center"><input type="submit" value="�j edz�" /></div>
</form>

<?php } else { ?>

<?php

  $imgUploader = new bwImageUploader();
  $imgUploader->SetMaxFileSize(2000000);
  $imgUploader->SetAutomaticNaming(false);
  $imgUploader->SetUploadDir('img/content/edzok');
  $imgUploader->SetDestFileName('edzo' . $instructor->id . '.jpg');
  $imgUploader->SetThumbnailName('edzo' . $instructor->id .  '_tn.jpg');
  $imgUploader->SetThumbnailSize(75);
  $imgUploader->SetAutomaticResize(true);
  $imgUploader->SetMaxImageSize(300);
  
  if($imgUploader->IsUpload())
  {
    $imgUploader->Upload();
  }

  
?>

<h1><?php echo ($instructor->id) ? $instructor->item[0]['nick'] : '�j edz�' ?></h1>

<p><a href="<?php echo $_SERVER['PHP_SELF'] ?>">Vissza a szerkeszt� f�oldal�ra</a></p>

<h2>Adatlap</h2>

<?php if($instructor->feedback != '') { ?>

<p style="border: 1px solid red; padding: 10px;"><strong><?php echo $instructor->feedback; ?></strong></p>

<?php } ?>

<?php if(!$instructor->saved) { ?>

<p>A <strong>csillaggal jel�lt (*)</strong> mez�k megad�sa k�telez�.</p>

<form enctype="multipart/form-data" name="instructorForm" method="post" action="<?php echo $instructor->GetFormURL() ?>">

<input id="formId" name="formId" type="hidden" value="INSTRUCTOR:UPDATE" />

<div style="text-align: center; ">
<table style="width: 70%; margin-left: auto; margin-right: auto; ">
<tr>
  <td><strong>Becen�v*:</strong></td>
  <td colspan="2"><input style="width:360px;" name="instr_nick" type="text" value="<?php if(isset($instructor->item[0]['nick'])) echo $instructor->item[0]['nick'] ?>" /></td>
</tr>
<tr>
  <td>Teljes n�v:</td>
  <td colspan="2"><input style="width:360px;" name="instr_name" type="text" value="<?php if(isset($instructor->item[0]['name'])) echo $instructor->item[0]['name'] ?>" /></td>
</tr>
<tr>
  <td>R�vid le�r�s:</td>
  <td colspan="2"><input style="width:360px;" name="instr_slogan" type="text" value="<?php if(isset($instructor->item[0]['slogan'])) echo $instructor->item[0]['slogan'] ?>" /></td>
</tr>
<tr>
  <td>Bemutatkoz�s:</td>
  <td colspan="2">
    <textarea style="width:360px; height: 215px;"  name="instr_body"><?php if(isset($instructor->item[0]['body'])) echo $instructor->item[0]['body'] ?></textarea>
  </td>
</tr>
<tr>
  <td>K�p:</td>
  <?php if($instructor->id) { ?>
  <td colspan="2">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $imgUploader->GetMaxFileSize() ?>" />
    <?php if($instructor->IsImageUploaded($instructor->id)) { ?>
    <img style="float:left; margin-right: 10px;" alt="<?php echo $instructor->item[0]['nick'] ?>" src="<?php echo $instructor->GetThumbnailURL($instructor->id) ?>" />
    <div><input type="checkbox" name="instr_noimage"> ne legyen k�p</div>
    <?php } ?>
    <div>Felt�lt�s: <input style="width:360px;" name="<?php echo $imgUploader->GetFileId() ?>" type="file" /></div>
  </td>
  <?php } else { ?>
  <td colspan="2">K�pfelt�lt�shez el�bb hozd l�tre az edz�t.</td>
  <?php } ?>
</tr>
<tr>
  <td>Edz� kateg�ri�ja:</td>
  <td>
    <input name="instr_is_aerobic" type="checkbox" value="1" <?php if(isset($instructor->item[0]['is_aerobic']) && ($instructor->item[0]['is_aerobic'])) echo 'checked="checked"' ?> /> aerobic edz�
  </td>
  <td>
    <input name="instr_is_fitness" type="checkbox" value="1" <?php if(isset($instructor->item[0]['is_fitness']) && ($instructor->item[0]['is_fitness'])) echo 'checked="checked"' ?> /> szem�lyi edz�
  </td>
</tr>
<tr>
  <td>Adatlap:</td>
  <td>
    <input name="instr_active" type="radio" value="1" <?php if(isset($instructor->item[0]['active']) && ($instructor->item[0]['active'])) echo 'checked="checked"' ?> /> publik�lva
  </td>
  <td>  
    <input name="instr_active" type="radio" value="0" <?php if(!isset($instructor->item[0]['active']) || (!$instructor->item[0]['active'])) echo 'checked="checked"' ?> /> rejtett
  </td>
</tr>
</table>

<br /><br />

<input type="submit" value="V�ltoztat�sok ment�se" />

</div>

</form>

<?php if($instructor->id) { ?>

<h2>Edz� t�rl�se</h2>

<?php $instrThisWeek = $instructor->CountClasses($instructor->id, 1); ?>
<?php $instrNextWeek = $instructor->CountClasses($instructor->id, 1); ?>

<?php if($instrThisWeek + $instrNextWeek == 0) { ?>

<p>Az al�bbi gombra kattintva t�r�lheted <strong><?php echo $instructor->item[0]['nick'] ?></strong> becenev� edz�t. A t�rl�s nem visszavonhat�.</p>

<form name="instructorDeleteForm" method="post" action="<?php echo $instructor->GetFormURL() ?>">

<input id="formId" name="formId" type="hidden" value="INSTRUCTOR:DELETE" />
<input name="id" type="hidden" value="<?php echo $instructor->item[0]['id'] ?>" />

<div style="text-align: center"><input type="submit" value="Edz� t�rl�se" /></div>

</form>

<?php } else { ?>

<p><strong><?php echo $instructor->item[0]['nick'] ?></strong> becenev� edz�nek ezen a h�ten <?php echo $instrThisWeek ?>, j�v�h�ten <?php echo $instrNextWeek ?> �r�ja van. Az edz� t�rl�s�hez el�bb az �sszes �r�j�t t�r�ln�d kell az �rarendb�l.</p>


<?php } ?>

<?php } ?>

<?php } ?>

<?php } ?>

<br /><br />


<?php } else { define('UNAUTHORIZED', 1); } ?>

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>
