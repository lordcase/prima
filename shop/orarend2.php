<?php define('BW_NOSTAT', 1); ?>
<?php require_once('inc/boot.php') ?>
<?php $CBA_SECTION = 'admin'; ?>
<?php require_once('inc/bwSchedule.php') ?>
<?php require_once('views/admHeader.php') ?>
<!-- Content Starts Here -->
<?php if($session->GetUserLevel() >= bwSession::EDITOR) { ?>

<?php if($schedule->room == 0) { ?>

<h1>�rarend szerkeszt�</h1>

<!--p><a href="cikkadmin.php">�rarendhez tartoz� sz�veg szerkeszt�se</a></p-->

<h2>Szerkeszt�s</h2>

<p>V�laszd ki, melyik �rarendet szeretn�d szerkeszteni.</p>


<div style="text-align: center; ">
<table style="width: 70%; margin-left: auto; margin-right: auto; ">
  <tr>
    <th>�rarend</th>
    <th>�r�k sz�ma</th>
    <th>Publik�lva</th>
  </tr>
  <tr>
    <td><a href="<?php echo $schedule->GetFormURL(2, 1); ?>"><strong>Rexona aerobic terem j�v� heti</strong></a></td>
    <td><?php echo $schedule->CountClasses(2,1); ?></td>
    <td><?php echo $schedule->GetStatusLabel(); ?></td>
  </tr>
  <tr>
    <td><a href="<?php echo $schedule->GetFormURL(2, 2); ?>"><strong>Vitalade aerobic - spinning terem j�v� heti</strong></a></td>
    <td><?php echo $schedule->CountClasses(2,2); ?></td>
    <td><?php echo $schedule->GetStatusLabel(); ?></td>
  </tr>
  <tr>
    <td><a style="font-weight: normal;" href="<?php echo $schedule->GetFormURL(1, 1); ?>">Rexona aerobic terem eheti</a></td>
    <td><?php echo $schedule->CountClasses(1,1); ?></td>
    <td>publik�lva</td>
  </tr>
  <tr>
    <td><a style="font-weight: normal;" href="<?php echo $schedule->GetFormURL(1, 2); ?>">Vitalade aerobic - spinning terem eheti</a></td>
    <td><?php echo $schedule->CountClasses(1,2); ?></td>
    <td>publik�lva</td>
  </tr>
</table>
</div>

&nbsp; &nbsp;

<?php if(($schedule->CountClasses(2,1) == 0) && ($schedule->CountClasses(2,2) == 0)) { ?>

<h2>�rarendek m�sol�sa</h2>

A j�v�heti �rarendek �resek. Ha szeretn�d az eheti �rarendek tartalm�t �tm�solni a j�v�heti �rarendekbe, kattints az al�bbi gombra.

<form name="ScheduleFormCopy1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
  <input type="hidden" name="formId" value="SCHEDULE:COPY" />
  <div style="text-align: center; margin-top:20px;"><input type="submit" value="�rarendek m�sol�sa" /></div>
</form>
      
<?php } elseif($schedule->GetStatus() != '1') { ?>

<h2>Publik�l�s</h2>

<p>A j�v�heti �rarendek nincsenek publik�lva, vagyis nem l�that�k a honlapon. Az al�bbi gombra kattintva publik�lhatod �ket.</p>

<form name="ScheduleFormCopy1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
  <input type="hidden" name="formId" value="SCHEDULE:PUBLICATE" />
  <div style="text-align: center; margin-top:20px;"><input type="submit" value="Publik�l�s" /></div>
</form>
      
<?php } else { ?>

<h2>Elrejt�s</h2>

<p>A j�v�heti �rarendek publik�lva vannak, vagyis l�that�k a honlapon. Az al�bbi gombra kattintva elrejtheted �ket. Az eheti �rarend mindenk�ppen publikus, az nem rejthet� el.</p>

<form name="ScheduleFormCopy1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
  <input type="hidden" name="formId" value="SCHEDULE:HIDE" />
  <div style="text-align: center; margin-top:20px;"><input type="submit" value="Elrejt�s" /></div>
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
  Szerkeszt�s
</div>
<div style="background-color: #ffffff; border: 2px solid #d40238; padding: 20px;">
  <form action="">
    <table style="width: 450px; margin-top: 0px;">
      <tr>
        <th id="bweRoom" class="title"><?php echo ($schedule->room == 1) ? 'Rexona aerobic terem' : 'Vitalade aerobic - spinning terem' ?></th>
        <td id="bweHour" style="width: 60px; text-align: center;">7:00</th>
        <td id="bweDay" class="bg" style="width: 90px; text-align: center;">H�tf�</th>
      </tr>
    </table>
    <table style="width: 450px; margin-top: 0px;">
      <?php if($schedule->week == 1) { ?>
      <tr>
        <td colspan="2"><strong>FIGYELMEZTET�S! Az eheti �rarendet szerkeszted!</strong></td>
      </tr>
      <?php } ?>
      <tr>
        <td><label for="">Edz�</label></td>
        <td>
          <select id="bweInstructor" style="width:360px;" name="">
            <?php foreach($schedule->instructor as $instructorId => $instructorName) { ?>
            <option value="<?php echo $instructorId ?>"><?php echo $instructorName ?></option>
            <?php } ?>
          </select>
        </td>
      </tr>
      <tr>
        <td><label for="">�ra</label></td>
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
        <td style="width: 20%; text-align: right;"><label for="">Norm�l</label> <input id="bweT0" name="t" type="radio" /></th>
        <td style="width: 20%; text-align: right;" class="uj"><label for="">�j</label> <input id="bweT1" name="t" type="radio" /></th>
        <td style="width: 20%; text-align: right;" class="special"><label for="">K�l�nleges</label> <input id="bweT2" name="t" type="radio" /></th>
        <td style="width: 20%; text-align: right;" class="pot"><label for="">Helyettes</label> <input id="bweT3" name="t" type="radio" /></th>
        <td style="width: 20%; text-align: right;" class="special2"><label for="">�nnepi</label> <input id="bweT4" name="t" type="radio" /></th>
      </tr>
    </table>
    <ul style="text-align: right; width: 450px; text-align: right; list-style-type: none; margin-left: 0px; margin-top: 15px;">
      <li style="display: inline; float: left;"><a href="javascript:bweCopy()">m�sol</a></li>
      <li style="display: inline; float: left;"><a href="javascript:bweCut()">kiv�g</a></li>
      <li style="display: inline; float: left;"><a href="javascript:bwePaste()">beilleszt</a></li>
      <li style="display: inline; float: left;"><a href="javascript:bweErase()">t�r�l</a></li>
      <li style="display: inline;"><a href="javascript:bweOK()">ok�</a></li>
      <li style="display: inline;"><a href="javascript:bweCancel()">m�gsem</a></li>
    </ul>
  </form>
</div>
</div>

<h1>�rarend szerkeszt�</h1>
<p><em>�rv�nyes: <?php echo $schedule->GetWeekName(); ?></em></p>

<p><a href="<?php echo $_SERVER['PHP_SELF'] ?>">Vissza a szerkeszt� f�oldal�ra</a></p>

<?php if($schedule->saved) { ?>

<p style="border: 1px solid red; padding: 10px;"><strong>V�ltoztat�sok elmentve.</strong></p>

<?php } ?>

<p>A t�bl�zat mez�ire kattintva szerkesztheted az �rarendet. <strong>Ne felejtsd el</strong> elmenteni a v�ltoztat�sokat az odal alj�n tal�lhat� <strong>V�ltoztat�sok ment�se</strong> gombbal!</p>

<table id="bweTable<?php echo $schedule->room ?>">
<tr>
<th rowspan="3" class="nobg">&nbsp;</th>
<th colspan="4" class="title"><?php echo ($schedule->room == 1) ? 'Rexona aerobic terem' : 'Vitalade aerobic - spinning terem' ?></th>
<th colspan="3" class="nobg"></th>
</tr>
<tr>
<th colspan="7"><?php echo ($schedule->room == 1) ? 'Az edz�sek eg�sz �rakor kezd�dnek' : 'Az edz�sek �ra 30-kor kezd�dnek' ?></th>
</tr>
<tr>
<td class="bg" style="width: 13%;">H�tf�</td>
<td class="bg" style="width: 13%;">Kedd</td>
<td class="bg" style="width: 13%;">Szerda</td>
<td class="bg" style="width: 13%;">Cs�t�rt�k</td>
<td class="bg" style="width: 13%;">P�ntek</td>
<td class="bg" style="width: 13%;">Szombat</td>
<td class="bg" style="width: 13%;">Vas�rnap</td>
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

<div style="text-align: center; margin-top:20px;"><input type="submit" value="V�ltoztat�sok ment�se" /></div>

</form>

<table>
<tr>
<td class="special">&nbsp;</td>
<td class="nobg">K�l�nleges �raaj�nlat</td>
</tr>
<tr>
<td class="uj">&nbsp;</td>
<td class="nobg">�j �ra, vagy �j �rat�pus</td>
</tr>
<tr>
<td class="pot">&nbsp;</td>
<td class="nobg">Helyettes�t�s</td>
</tr>
<tr>
<td class="special2">&nbsp;</td>
<td class="nobg">�nnepnap</td>
</tr>
</table>
<?php } ?>

<?php } else { define('UNAUTHORIZED', 1); } ?>

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>
