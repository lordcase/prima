<?php define('BW_NOSTAT', 1); ?>
<?php require_once('inc/boot.php') ?>
<?php $CBA_SECTION = 'aerobic'; ?>
<?php require_once('inc/bwClasstype.php') ?>
<?php require_once('views/header.php') ?>
<!-- Content Starts Here -->
<?php if(($classtype->id == 0) && (!isset($_GET['uj']))) { ?>

<h1>Óratípusaink</h1>

<div style="text-align: center; ">
<table style="width: 70%; margin-left: auto; margin-right: auto; ">
  <tr>
    <th>Óráink</th>
  </tr>
  <?php foreach($classtype->item as $ctype) { ?>
  <?php if($ctype['active']) { ?>
  <tr>
    <td><a href="<?php echo $classtype->GetFormURL($ctype['id']); ?>"><?php echo $ctype['title'] ?></a></td>
  </tr>
  <?php } ?>
  <?php } ?>
</table>
</div>

&nbsp; &nbsp;

<?php } elseif($classtype->item[0]['active']) { ?>

<h1><?php echo ($classtype->id) ? $classtype->item[0]['title'] : 'Nincs ilyen óra' ?></h1>

<p><a href="<?php echo $_SERVER['PHP_SELF'] ?>">Óratípusok</a> | <a href="orarend.php">Órarend</a></p>

<?php if(($classtype->item[0]['name'] != '') && ($classtype->item[0]['name'] != $classtype->item[0]['title'])) { ?>

<p>Teljes név: <strong><?php echo $classtype->item[0]['name'] ?></strong></p>

<?php } ?>

<?php if($classtype->IsImageUploaded($classtype->id)) { ?>

<img style="float:left; margin-right: 10px;" alt="<?php echo $classtype->item[0]['title'] ?>" src="<?php echo $classtype->GetImageUrl($classtype->id) ?>" />

<?php } ?>

<p><em><?php echo $classtype->item[0]['slogan'] ?></em></p>

<p><?php echo nl2br($classtype->item[0]['body']) ?></p>

<br style="clear: both;" /><br />

<h2><?php echo $classtype->item[0]['title'] ?> óráink</h2>

<?php $dayname = array(1 => 'hétfõ', 'kedd', 'szerda', 'csütörtök', 'péntek', 'szombat', 'vasárnap'); ?>

<?php for($week = 1; $week <= (($status->Get("SCHEDULE_PUBLIC") == '1') ? 2 : 1 ); $week++ ) { ?>

<div style="text-align: center; ">
<table style="width: 70%; margin-left: auto; margin-right: auto; ">
  <tr>
    <th class="title" colspan="3"><?php echo $classtype->item[0]['title'] ?> óráink <?php echo ($week == 1) ? 'a héten' : 'jövõhéten' ?></th>
    <td class="nobg">&nbsp;</td>
  </tr>
  <tr>
    <th colspan="2">idõpont</th>
    <th>terem</th>
    <th>edzõ</th>
  </tr>
<?php foreach($classtype->item[0]['classes'][$week] as $class) { ?>
  <tr>
    <td><?php echo $dayname[$class['day']] ?></td>
    <td><?php echo $class['hour'] . (($class['room'] == '1') ? ':00' : ( ($class['hour'] == 6) ? ':15' : ':30')) ?></td>
    <td><a href="orarend.php#terem<?php echo $class['room'] ?>"><?php echo ($class['room'] == '1') ? 'Rexona aerobic terem' : 'Vitalade aerobic-spinning terem' ?></a></td>
    <td><?php echo $class['nick'] ?></td>
  </tr>

<?php } ?>
</table>
</div>

<?php } ?>

<?php } else { ?>

<h1>Nincs ilyen adatlap</h1>

<?php } ?>

<br /><br />

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>
