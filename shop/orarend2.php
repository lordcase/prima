<?php define('BW_NOSTAT', 1); ?>
<?php require_once('inc/boot.php') ?>
<?php $CBA_SECTION = 'admin'; ?>
<?php require_once('inc/bwSchedule.php') ?>
<?php require_once('views/admHeader.php') ?>
<!-- Content Starts Here -->
<?php if($session->GetUserLevel() >= bwSession::EDITOR) { ?>

<?php if($schedule->room == 0) { ?>

<h1>Órarend szerkesztõ</h1>

<!--p><a href="cikkadmin.php">Órarendhez tartozó szöveg szerkesztése</a></p-->

<h2>Szerkesztés</h2>

<p>Válaszd ki, melyik órarendet szeretnéd szerkeszteni.</p>


<div style="text-align: center; ">
<table style="width: 70%; margin-left: auto; margin-right: auto; ">
  <tr>
    <th>Órarend</th>
    <th>Órák száma</th>
    <th>Publikálva</th>
  </tr>
  <tr>
    <td><a href="<?php echo $schedule->GetFormURL(2, 1); ?>"><strong>Rexona aerobic terem jövõ heti</strong></a></td>
    <td><?php echo $schedule->CountClasses(2,1); ?></td>
    <td><?php echo $schedule->GetStatusLabel(); ?></td>
  </tr>
  <tr>
    <td><a href="<?php echo $schedule->GetFormURL(2, 2); ?>"><strong>Vitalade aerobic - spinning terem jövõ heti</strong></a></td>
    <td><?php echo $schedule->CountClasses(2,2); ?></td>
    <td><?php echo $schedule->GetStatusLabel(); ?></td>
  </tr>
  <tr>
    <td><a style="font-weight: normal;" href="<?php echo $schedule->GetFormURL(1, 1); ?>">Rexona aerobic terem eheti</a></td>
    <td><?php echo $schedule->CountClasses(1,1); ?></td>
    <td>publikálva</td>
  </tr>
  <tr>
    <td><a style="font-weight: normal;" href="<?php echo $schedule->GetFormURL(1, 2); ?>">Vitalade aerobic - spinning terem eheti</a></td>
    <td><?php echo $schedule->CountClasses(1,2); ?></td>
    <td>publikálva</td>
  </tr>
</table>
</div>

&nbsp; &nbsp;

<?php if(($schedule->CountClasses(2,1) == 0) && ($schedule->CountClasses(2,2) == 0)) { ?>

<h2>Órarendek másolása</h2>

A jövõheti órarendek üresek. Ha szeretnéd az eheti órarendek tartalmát átmásolni a jövõheti órarendekbe, kattints az alábbi gombra.

<form name="ScheduleFormCopy1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
  <input type="hidden" name="formId" value="SCHEDULE:COPY" />
  <div style="text-align: center; margin-top:20px;"><input type="submit" value="Órarendek másolása" /></div>
</form>
      
<?php } elseif($schedule->GetStatus() != '1') { ?>

<h2>Publikálás</h2>

<p>A jövõheti órarendek nincsenek publikálva, vagyis nem láthatók a honlapon. Az alábbi gombra kattintva publikálhatod õket.</p>

<form name="ScheduleFormCopy1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
  <input type="hidden" name="formId" value="SCHEDULE:PUBLICATE" />
  <div style="text-align: center; margin-top:20px;"><input type="submit" value="Publikálás" /></div>
</form>
      
<?php } else { ?>

<h2>Elrejtés</h2>

<p>A jövõheti órarendek publikálva vannak, vagyis láthatók a honlapon. Az alábbi gombra kattintva elrejtheted õket. Az eheti órarend mindenképpen publikus, az nem rejthetõ el.</p>

<form name="ScheduleFormCopy1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
  <input type="hidden" name="formId" value="SCHEDULE:HIDE" />
  <div style="text-align: center; margin-top:20px;"><input type="submit" value="Elrejtés" /></div>
</form>

<?php } ?>

<?php } else { ?>

<script type="text/javascript" src="js/editor.js"></script>
<script type="text/javascript">
var instrList = new Array;
var classList = new Array;

<?php foreach($schedule->instructor as $instructorId => $instructorName) { ?>
instrList[<?php echo $instructorId ?>] = '<?php echo $instructorName ?>';
<?php } ?>

<?php foreach($schedule->classtype as $classtypeId => $classtypeName) { ?>
classList[<?php echo $classtypeId ?>] = '<?php echo $classtypeName ?>';
<?php } ?>


</script>
<div id="editbox" style="position: absolute; left: 170px; top: 540px; display: none;">
<div style="background-color: #d40238; border: 2px solid #d40238; padding: 2px; color: #ffffff;">
  Szerkesztés
</div>
<div style="background-color: #ffffff; border: 2px solid #d40238; padding: 20px;">
  <form action="">
    <table style="width: 450px; margin-top: 0px;">
      <tr>
        <th id="bweRoom" class="title"><?php echo ($schedule->room == 1) ? 'Rexona aerobic terem' : 'Vitalade aerobic - spinning terem' ?></th>
        <td id="bweHour" style="width: 60px; text-align: center;">7:00</th>
        <td id="bweDay" class="bg" style="width: 90px; text-align: center;">Hétfõ</th>
      </tr>
    </table>
    <table style="width: 450px; margin-top: 0px;">
      <?php if($schedule->week == 1) { ?>
      <tr>
        <td colspan="2"><strong>FIGYELMEZTETÉS! Az eheti órarendet szerkeszted!</strong></td>
      </tr>
      <?php } ?>
      <tr>
        <td><label for="">Edzõ</label></td>
        <td>
          <select id="bweInstructor" style="width:360px;" name="">
            <?php foreach($schedule->instructor as $instructorId => $instructorName) { ?>
            <option value="<?php echo $instructorId ?>"><?php echo $instructorName ?></option>
            <?php } ?>
          </select>
        </td>
      </tr>
      <tr>
        <td><label for="">Óra</label></td>
        <td>
          <select id="bweClassType" style="width:360px;" name="">
            <?php foreach($schedule->classtype as $classtypeId => $classtypeName) { ?>
            <option value="<?php echo $classtypeId ?>"><?php echo $classtypeName ?></option>
            <?php } ?>
          </select>
        </td>
      </tr>
    </table>
    <table style="width: 450px; margin-top: 0px;">
      <tr>
        <td style="width: 20%; text-align: right;"><label for="">Normál</label> <input id="bweT0" name="t" type="radio" /></th>
        <td style="width: 20%; text-align: right;" class="uj"><label for="">Új</label> <input id="bweT1" name="t" type="radio" /></th>
        <td style="width: 20%; text-align: right;" class="special"><label for="">Különleges</label> <input id="bweT2" name="t" type="radio" /></th>
        <td style="width: 20%; text-align: right;" class="pot"><label for="">Helyettes</label> <input id="bweT3" name="t" type="radio" /></th>
        <td style="width: 20%; text-align: right;" class="special2"><label for="">Ünnepi</label> <input id="bweT4" name="t" type="radio" /></th>
      </tr>
    </table>
    <ul style="text-align: right; width: 450px; text-align: right; list-style-type: none; margin-left: 0px; margin-top: 15px;">
      <li style="display: inline; float: left;"><a href="javascript:bweCopy()">másol</a></li>
      <li style="display: inline; float: left;"><a href="javascript:bweCut()">kivág</a></li>
      <li style="display: inline; float: left;"><a href="javascript:bwePaste()">beilleszt</a></li>
      <li style="display: inline; float: left;"><a href="javascript:bweErase()">töröl</a></li>
      <li style="display: inline;"><a href="javascript:bweOK()">oké</a></li>
      <li style="display: inline;"><a href="javascript:bweCancel()">mégsem</a></li>
    </ul>
  </form>
</div>
</div>

<h1>Órarend szerkesztõ</h1>
<p><em>Érvényes: <?php echo $schedule->GetWeekName(); ?></em></p>

<p><a href="<?php echo $_SERVER['PHP_SELF'] ?>">Vissza a szerkesztõ fõoldalára</a></p>

<?php if($schedule->saved) { ?>

<p style="border: 1px solid red; padding: 10px;"><strong>Változtatások elmentve.</strong></p>

<?php } ?>

<p>A táblázat mezõire kattintva szerkesztheted az órarendet. <strong>Ne felejtsd el</strong> elmenteni a változtatásokat az odal alján található <strong>Változtatások mentése</strong> gombbal!</p>

<table id="bweTable<?php echo $schedule->room ?>">
<tr>
<th rowspan="3" class="nobg">&nbsp;</th>
<th colspan="4" class="title"><?php echo ($schedule->room == 1) ? 'Rexona aerobic terem' : 'Vitalade aerobic - spinning terem' ?></th>
<th colspan="3" class="nobg"></th>
</tr>
<tr>
<th colspan="7"><?php echo ($schedule->room == 1) ? 'Az edzések egész órakor kezdõdnek' : 'Az edzések óra 30-kor kezdõdnek' ?></th>
</tr>
<tr>
<td class="bg" style="width: 13%;">Hétfõ</td>
<td class="bg" style="width: 13%;">Kedd</td>
<td class="bg" style="width: 13%;">Szerda</td>
<td class="bg" style="width: 13%;">Csütörtök</td>
<td class="bg" style="width: 13%;">Péntek</td>
<td class="bg" style="width: 13%;">Szombat</td>
<td class="bg" style="width: 13%;">Vasárnap</td>
</tr>

<?php $min = ($schedule->room == 1) ? '00' : '15'; ?>

<?php for($hour=6; $hour<=20; $hour++) { ?>

<tr>
  <td><?php echo $hour . ':' . $min ?></td>
  <?php for($day=1; $day<=7; $day++) { ?>
  <?php $cellId = 'bwec' . $schedule->room . '_' . $day . '_' . $hour ?>
  <td id="<?php echo $cellId ?>" class="<?php echo $schedule->GetClassSpecialLabel($schedule->room, $day, $hour) ?>" onclick="bweOpen(<?php echo $schedule->room . ', ' . $day . ', ' . $hour  ?>)"><?php echo $schedule->GetClassLabel($schedule->room, $day, $hour) ?></td>
  <?php } ?>
</tr>

<?php $min = ($schedule->room == 1) ? '00' : '30'; ?>

<?php } ?>

</table>


<form name="scheduleForm" method="post" action="<?php echo $schedule->GetFormURL() ?>">

<input id="formId" name="formId" type="hidden" value="SCHEDULE:UPDATE" />

<?php for($hour=6; $hour<=20; $hour++) { ?>

  <?php for($day=1; $day<=7; $day++) { ?>
  <?php $inputId = 'bwei' . $schedule->room . '_' . $day . '_' . $hour ?>
  <input id="<?php echo $inputId . 'instr' ?>" name="<?php echo $inputId . 'instr' ?>" type="hidden" value="<?php echo $schedule->GetClassInstructorId($schedule->room, $day, $hour) ?>" />
  <input id="<?php echo $inputId . 'class' ?>" name="<?php echo $inputId . 'class' ?>" type="hidden" value="<?php echo $schedule->GetClassClassTypeId($schedule->room, $day, $hour) ?>" />
  <input id="<?php echo $inputId . 'special' ?>" name="<?php echo $inputId . 'special' ?>" type="hidden" value="<?php echo $schedule->GetClassSpecialId($schedule->room, $day, $hour) ?>" />
  <input id="<?php echo $inputId . 'changed' ?>" name="<?php echo $inputId . 'changed' ?>" type="hidden" value="0" />
  <?php } ?>

<?php } ?>

<div style="text-align: center; margin-top:20px;"><input type="submit" value="Változtatások mentése" /></div>

</form>

<table>
<tr>
<td class="special">&nbsp;</td>
<td class="nobg">Különleges óraajánlat</td>
</tr>
<tr>
<td class="uj">&nbsp;</td>
<td class="nobg">Új óra, vagy új óratípus</td>
</tr>
<tr>
<td class="pot">&nbsp;</td>
<td class="nobg">Helyettesítés</td>
</tr>
<tr>
<td class="special2">&nbsp;</td>
<td class="nobg">Ünnepnap</td>
</tr>
</table>
<?php } ?>

<?php } else { define('UNAUTHORIZED', 1); } ?>

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>
