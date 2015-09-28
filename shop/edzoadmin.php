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

<h1>Edzõk adminisztrációja</h1>

<div style="text-align: center; ">
<table style="width: 70%; margin-left: auto; margin-right: auto; ">
  <tr>
    <th>Becenév</th>
    <th>Teljes név</th>
		<th colspan="2">Milyen edzõ</th>
    <th>Órái a héten</th>
    <th>Órái jövõhéten</th>
    <th>Adatlap</th>
  </tr>
  <?php foreach($instructor->item as $instr) { ?>
  <tr>
    <td><a href="<?php echo $instructor->GetFormURL($instr['id']); ?>"><?php echo $instr['nick'] ?></a></td>
    <td><?php echo $instr['name'] ?></td>
		<td><?php echo $instr['is_aerobic'] ? "aerobic" : "&nbsp;" ?></td>
		<td><?php echo $instr['is_fitness'] ? "személyi" : "&nbsp;" ?></td>
    <td><?php echo $instructor->CountClasses($instr['id']); ?></td>
    <td><?php echo $instructor->CountClasses($instr['id'], 2); ?></td>
    <td><?php echo $instr['active'] ? 'publikálva' : 'rejtve' ?></td>
  </tr>
  <?php } ?>
</table>
</div>

&nbsp; &nbsp;

<h2>Új edzõ létrehozása</h2>

<p>Új edzõ létrehozásához kattints az alábbi gombra.</p>

<form name="instructorNewForm" method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?uj' ?>"
<div style="text-align: center"><input type="submit" value="Új edzõ" /></div>
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

<h1><?php echo ($instructor->id) ? $instructor->item[0]['nick'] : 'Új edzõ' ?></h1>

<p><a href="<?php echo $_SERVER['PHP_SELF'] ?>">Vissza a szerkesztõ fõoldalára</a></p>

<h2>Adatlap</h2>

<?php if($instructor->feedback != '') { ?>

<p style="border: 1px solid red; padding: 10px;"><strong><?php echo $instructor->feedback; ?></strong></p>

<?php } ?>

<?php if(!$instructor->saved) { ?>

<p>A <strong>csillaggal jelölt (*)</strong> mezõk megadása kötelezõ.</p>

<form enctype="multipart/form-data" name="instructorForm" method="post" action="<?php echo $instructor->GetFormURL() ?>">

<input id="formId" name="formId" type="hidden" value="INSTRUCTOR:UPDATE" />

<div style="text-align: center; ">
<table style="width: 70%; margin-left: auto; margin-right: auto; ">
<tr>
  <td><strong>Becenév*:</strong></td>
  <td colspan="2"><input style="width:360px;" name="instr_nick" type="text" value="<?php if(isset($instructor->item[0]['nick'])) echo $instructor->item[0]['nick'] ?>" /></td>
</tr>
<tr>
  <td>Teljes név:</td>
  <td colspan="2"><input style="width:360px;" name="instr_name" type="text" value="<?php if(isset($instructor->item[0]['name'])) echo $instructor->item[0]['name'] ?>" /></td>
</tr>
<tr>
  <td>Rövid leírás:</td>
  <td colspan="2"><input style="width:360px;" name="instr_slogan" type="text" value="<?php if(isset($instructor->item[0]['slogan'])) echo $instructor->item[0]['slogan'] ?>" /></td>
</tr>
<tr>
  <td>Bemutatkozás:</td>
  <td colspan="2">
    <textarea style="width:360px; height: 215px;"  name="instr_body"><?php if(isset($instructor->item[0]['body'])) echo $instructor->item[0]['body'] ?></textarea>
  </td>
</tr>
<tr>
  <td>Kép:</td>
  <?php if($instructor->id) { ?>
  <td colspan="2">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $imgUploader->GetMaxFileSize() ?>" />
    <?php if($instructor->IsImageUploaded($instructor->id)) { ?>
    <img style="float:left; margin-right: 10px;" alt="<?php echo $instructor->item[0]['nick'] ?>" src="<?php echo $instructor->GetThumbnailURL($instructor->id) ?>" />
    <div><input type="checkbox" name="instr_noimage"> ne legyen kép</div>
    <?php } ?>
    <div>Feltöltés: <input style="width:360px;" name="<?php echo $imgUploader->GetFileId() ?>" type="file" /></div>
  </td>
  <?php } else { ?>
  <td colspan="2">Képfeltöltéshez elõbb hozd létre az edzõt.</td>
  <?php } ?>
</tr>
<tr>
  <td>Edzõ kategóriája:</td>
  <td>
    <input name="instr_is_aerobic" type="checkbox" value="1" <?php if(isset($instructor->item[0]['is_aerobic']) && ($instructor->item[0]['is_aerobic'])) echo 'checked="checked"' ?> /> aerobic edzõ
  </td>
  <td>
    <input name="instr_is_fitness" type="checkbox" value="1" <?php if(isset($instructor->item[0]['is_fitness']) && ($instructor->item[0]['is_fitness'])) echo 'checked="checked"' ?> /> személyi edzõ
  </td>
</tr>
<tr>
  <td>Adatlap:</td>
  <td>
    <input name="instr_active" type="radio" value="1" <?php if(isset($instructor->item[0]['active']) && ($instructor->item[0]['active'])) echo 'checked="checked"' ?> /> publikálva
  </td>
  <td>  
    <input name="instr_active" type="radio" value="0" <?php if(!isset($instructor->item[0]['active']) || (!$instructor->item[0]['active'])) echo 'checked="checked"' ?> /> rejtett
  </td>
</tr>
</table>

<br /><br />

<input type="submit" value="Változtatások mentése" />

</div>

</form>

<?php if($instructor->id) { ?>

<h2>Edzõ törlése</h2>

<?php $instrThisWeek = $instructor->CountClasses($instructor->id, 1); ?>
<?php $instrNextWeek = $instructor->CountClasses($instructor->id, 1); ?>

<?php if($instrThisWeek + $instrNextWeek == 0) { ?>

<p>Az alábbi gombra kattintva törölheted <strong><?php echo $instructor->item[0]['nick'] ?></strong> becenevû edzõt. A törlés nem visszavonható.</p>

<form name="instructorDeleteForm" method="post" action="<?php echo $instructor->GetFormURL() ?>">

<input id="formId" name="formId" type="hidden" value="INSTRUCTOR:DELETE" />
<input name="id" type="hidden" value="<?php echo $instructor->item[0]['id'] ?>" />

<div style="text-align: center"><input type="submit" value="Edzõ törlése" /></div>

</form>

<?php } else { ?>

<p><strong><?php echo $instructor->item[0]['nick'] ?></strong> becenevû edzõnek ezen a héten <?php echo $instrThisWeek ?>, jövõhéten <?php echo $instrNextWeek ?> órája van. Az edzõ törléséhez elõbb az összes óráját törölnöd kell az órarendbõl.</p>


<?php } ?>

<?php } ?>

<?php } ?>

<?php } ?>

<br /><br />


<?php } else { define('UNAUTHORIZED', 1); } ?>

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>
