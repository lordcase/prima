<?php define('BW_NOSTAT', 1); ?>
<?php require_once('inc/boot.php') ?>
<?php $CBA_SECTION = 'admin'; ?>
<?php require_once('inc/bwClasstype.php') ?>
<?php require_once('views/admHeader.php') ?>
<!-- Content Starts Here -->
<?php if($session->GetUserLevel() >= bwSession::EDITOR) { ?>

<?php if(($classtype->id == 0) && (!isset($_GET['uj']))) { ?>

<h1>Óratípusok adminisztrációja</h1>

<div style="text-align: center; ">
<table style="width: 70%; margin-left: auto; margin-right: auto; ">
  <tr>
    <th>Név</th>
    <th>A héten</th>
    <th>Jövõhéten</th>
    <th>Adatlap</th>
  </tr>
  <?php foreach($classtype->item as $class) { ?>
  <tr>
    <td><a href="<?php echo $classtype->GetFormURL($class['id']); ?>"><?php echo $class['title'] ?></a></td>
    <td><?php echo $classtype->CountClasses($class['id']); ?></td>
    <td><?php echo $classtype->CountClasses($class['id'], 2); ?></td>
    <td><?php echo $class['active'] ? 'publikálva' : 'rejtve' ?></td>
  </tr>
  <?php } ?>
</table>
</div>

&nbsp; &nbsp;

<h2>Új óratípus létrehozása</h2>

<p>Új óratípus létrehozásához kattints az alábbi gombra.</p>

<form name="classtypeNewForm" method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?uj' ?>"
<div style="text-align: center"><input type="submit" value="Új óratípus" /></div>
</form>

<?php } else { ?>

<h1><?php echo ($classtype->id) ? $classtype->item[0]['title'] : 'Új óratípus' ?></h1>

<p><a href="<?php echo $_SERVER['PHP_SELF'] ?>">Vissza a szerkesztõ fõoldalára</a></p>

<h2>Adatlap</h2>

<?php if($classtype->feedback != '') { ?>

<p style="border: 1px solid red; padding: 10px;"><strong><?php echo $classtype->feedback; ?></strong></p>

<?php } ?>

<?php if(!$classtype->saved) { ?>

<p>A <strong>csillaggal jelölt (*)</strong> mezõk megadása kötelezõ.</p>

<form name="classtypeForm" method="post" action="<?php echo $classtype->GetFormURL() ?>">

<input id="formId" name="formId" type="hidden" value="CLASSTYPE:UPDATE" />

<div style="text-align: center; ">
<table style="width: 70%; margin-left: auto; margin-right: auto; ">
<tr>
  <td><strong>Név*:</strong></td>
  <td colspan="2"><input style="width:360px;" name="class_title" type="text" value="<?php if(isset($classtype->item[0]['title'])) echo $classtype->item[0]['title'] ?>" /></td>
</tr>
<tr>
  <td>Leírás:</td>
  <td colspan="2">
    <textarea style="width:360px; height: 215px;"  name="class_body"><?php if(isset($classtype->item[0]['body'])) echo $classtype->item[0]['body'] ?></textarea>
  </td>
</tr>
<tr>
  <td>Adatlap:</td>
  <td>
    <input name="class_active" type="radio" value="1" <?php if(isset($classtype->item[0]['active']) && ($classtype->item[0]['active'])) echo 'checked="checked"' ?> /> publikálva
  </td>
  <td>  
    <input name="class_active" type="radio" value="0" <?php if(!isset($classtype->item[0]['active']) || (!$classtype->item[0]['active'])) echo 'checked="checked"' ?> /> rejtett
  </td>
</tr>
</table>

<br /><br />

<input type="submit" value="Változtatások mentése" />

</div>

</form>

<?php if($classtype->id) { ?>

<h2>Óratípus törlése</h2>

<?php $classThisWeek = $classtype->CountClasses($classtype->id, 1); ?>
<?php $classNextWeek = $classtype->CountClasses($classtype->id, 1); ?>

<?php if($classThisWeek + $classNextWeek == 0) { ?>

<p>Az alábbi gombra kattintva törölheted a(z) <strong><?php echo $classtype->item[0]['title'] ?></strong> elnevezésû óratípust. A törlés nem visszavonható.</p>

<form name="classtypeDeleteForm" method="post" action="<?php echo $classtype->GetFormURL() ?>">

<input id="formId" name="formId" type="hidden" value="CLASSTYPE:DELETE" />
<input name="id" type="hidden" value="<?php echo $classtype->item[0]['id'] ?>" />

<div style="text-align: center"><input type="submit" value="Óratípus törlése" /></div>

</form>

<?php } else { ?>

<p>A(z) <strong><?php echo $classtype->item[0]['title'] ?></strong> nevû óratípus ezen a héten <?php echo $classThisWeek ?>, jövõhéten <?php echo $classNextWeek ?> alkalommal szerepel az órarendben. Az óratípus törléséhez elõbb az összes elõfordulását törölnöd kell az órarendbõl.</p>


<?php } ?>

<?php } ?>

<?php } ?>

<?php } ?>

<br /><br />


<?php } else { define('UNAUTHORIZED', 1); } ?>

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>
