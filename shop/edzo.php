<?php define('BW_NOSTAT', 1); ?>
<?php require_once('inc/boot.php') ?>
<?php $CBA_SECTION = 'aerobic'; ?>
<?php require_once('inc/bwInstructor.php') ?>
<?php require_once('views/header.php') ?>
<!-- Content Starts Here -->
<?php if(($instructor->id == 0) && (!isset($_GET['uj']))) { ?>

<?php if($instructor->type == 1) { ?>
<h1>Aerobic edzõink</h1>
<?php } elseif($instructor->type == 2) { ?>
<h1>Személyi edzõink</h1>
<?php } else { ?>
<h1>Edzõink</h1>
<?php } ?>

<div style="text-align: center; ">
<table style="width: 70%; margin-left: auto; margin-right: auto; ">
  <tr>
    <th colspan="2">Edzõink</th>
  </tr>
  <?php foreach($instructor->item as $instr) { ?>
  <?php if($instr['active']) { ?>
  <tr>
    <td style="width: 75px;"><img alt="<?php echo $instr['nick'] ?>" src="<?php echo $instructor->GetThumbnailURL($instr['id']) ?>" /></td>
    <td><a href="<?php echo $instructor->GetFormURL($instr['id']); ?>"><?php echo $instr['nick'] ?></a><br /><?php echo $instr['slogan'] ?></td>
  </tr>
  <?php } ?>
  <?php } ?>
</table>
</div>

&nbsp; &nbsp;

<?php } elseif($instructor->item[0]['active']) { ?>

<h1><?php echo ($instructor->id) ? $instructor->item[0]['nick'] : 'Nincs ilyen edzõ' ?></h1>

<p>
<?php if($instructor->item[0]['is_fitness']) { ?><a href="<?php echo $_SERVER['PHP_SELF'] ?>?fitness=1">Személyi edzõk</a><?php } ?>
<?php if($instructor->item[0]['is_fitness'] && $instructor->item[0]['is_aerobic']) { ?> | <?php } ?>
<?php if($instructor->item[0]['is_aerobic']) { ?><a href="<?php echo $_SERVER['PHP_SELF'] ?>?aerobic=1">Aerobic edzõk</a> | <a href="orarend.php">Órarend</a><?php } ?>
</p>

<?php if(($instructor->item[0]['name'] != '') && ($instructor->item[0]['name'] != $instructor->item[0]['nick'])) { ?>

<p>Teljes név: <strong><?php echo $instructor->item[0]['name'] ?></strong></p>

<?php } ?>

<?php if($instructor->IsImageUploaded($instructor->id)) { ?>

<img style="float:left; margin-right: 10px;" alt="<?php echo $instructor->item[0]['nick'] ?>" src="<?php echo $instructor->GetImageUrl($instructor->id) ?>" />

<?php } ?>

<p><em><?php echo $instructor->item[0]['slogan'] ?></em></p>

<p><?php echo nl2br($instructor->item[0]['body']) ?></p>

<br style="clear: both;" /><br />

<?php if($instructor->item[0]['is_aerobic']) { ?>

<h2><?php echo $instructor->item[0]['nick'] ?> órái</h2>

<?php $dayname = array(1 => 'hétfõ', 'kedd', 'szerda', 'csütörtök', 'péntek', 'szombat', 'vasárnap'); ?>

<?php for($week = 1; $week <= (($status->Get("SCHEDULE_PUBLIC") == '1') ? 2 : 1 ); $week++ ) { ?>

<div style="text-align: center; ">
<table style="width: 70%; margin-left: auto; margin-right: auto; ">
  <tr>
    <th class="title" colspan="3"><?php echo $instructor->item[0]['nick'] ?> órái <?php echo ($week == 1) ? 'a héten' : 'jövõhéten' ?></th>
    <td class="nobg">&nbsp;</td>
  </tr>
  <tr>
    <th colspan="2">idõpont</th>
    <th>terem</th>
    <th>óra</th>
  </tr>
<?php foreach($instructor->item[0]['classes'][$week] as $class) { ?>
  <tr>
    <td><?php echo $dayname[$class['day']] ?></td>
    <td><?php echo $class['hour'] . (($class['room'] == '1') ? ':00' : ( ($class['hour'] == 6) ? ':15' : ':30')) ?></td>
    <td><a href="orarend.php#terem<?php echo $class['room'] ?>"><?php echo ($class['room'] == '1') ? 'Rexona aerobic terem' : 'Vitalade aerobic-spinning terem' ?></a></td>
    <td><?php echo $class['title'] ?></td>
  </tr>

<?php } ?>
</table>
</div>

<?php } ?>

<?php } ?>

<?php } else { ?>

<h1>Nincs ilyen adatlap</h1>

<?php } ?>

<br /><br />

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>
