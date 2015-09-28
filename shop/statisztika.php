<?php define('BW_NOSTAT', 1); ?>
<?php require_once('inc/boot.php') ?>
<?php $CBA_SECTION = 'admin'; ?>
<?php require_once('inc/bwStat.php') ?>
<?php require_once('views/admHeader.php') ?>
<!-- Content Starts Here -->
<?php if($session->GetUserLevel() >= bwSession::EDITOR) { ?>

<h1>Látogatottsági statisztika</h1>

<div style="text-align: center; ">
<table style="width: 70%; margin-left: auto; margin-right: auto; ">
 <?php $stat_row_Visits = $stat->GetVisitsRow(); ?>

  <tr>
    <th>
      <form name="stat_form" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
      <select name="stat_month" onchange="javascript:document.stat_form.submit()">
        <?php echo $stat->GetMonthOptions(2007, 05); ?>
      </select>
      </form>
    </th>
    <th>Összes letöltés</th><th>Egyedi látogató</th>
  </tr>

  <tr><td>&nbsp;</td><td><?php echo $stat_row_Visits[0] ?></td><td><?php echo $stat_row_Visits[1] ?></td></tr>
</table>

  <?php $stat_resource_DailyVisits = $stat->GetDailyVisits(); ?>

<table style="width: 70%; margin-left: auto; margin-right: auto; ">

  <?php $page_counter = 0; ?>
  <?php $visitor_counter = 0; ?>
  <?php $day_counter = 0; ?>

  <tr><td class="bg" colspan="3">Napi bontás</td></tr>
  <tr><th>Nap</th><th>Összes letöltés</th><th>Egyedi látogató</th></tr>

  <?php while($stat_row_DailyVisits = mysql_fetch_row($stat_resource_DailyVisits)) { ?>
  <tr><td><?php echo $stat_row_DailyVisits[0] ?></td><td align="center"><?php echo $stat_row_DailyVisits[1] ?></td><td align="center"><?php echo $stat_row_DailyVisits[2] ?></td></tr>
  <?php $page_counter += $stat_row_DailyVisits[1]; ?>
  <?php $visitor_counter += $stat_row_DailyVisits[2]; ?>
  <?php $day_counter ++; ?>
  <?php } //while ?>
  <?php if($day_counter >= 1) {?>
  <tr><td colspan="3">&nbsp;</td></td>
  <tr><td>Összeadva</td><td align="center"><?php echo $page_counter ?></td><td align="center"><?php echo $visitor_counter ?></td></tr>
  <tr><td>Napi átlag</td><td align="center"><?php echo intval($page_counter/$day_counter) ?></td><td align="center"><?php echo intval($visitor_counter/$day_counter) ?></td></tr>
  <?php } //if ?>
</table>

  <?php $stat_resource_PageVisits = $stat->GetPageVisits(); ?>

<table style="width: 70%; margin-left: auto; margin-right: auto; ">

  <tr><td class="bg" colspan="3">Az egyes oldalak látogatottsága (top 10)</td></tr>
  <tr><th>Oldal</th><th>Összes letöltés</th><th>Egyedi látogató</th></tr>

  <?php while($stat_row_PageVisits = mysql_fetch_row($stat_resource_PageVisits)) { ?>
  <tr><td><?php echo $stat_row_PageVisits[0] ?></td><td align="center"><?php echo $stat_row_PageVisits[1] ?></td><td align="center"><?php echo $stat_row_PageVisits[2] ?></td></tr>
  <?php } //while ?>
</table>

  <?php $stat_resource_Visitors = $stat->GetVisitors(); ?>

<table style="width: 70%; margin-left: auto; margin-right: auto; ">

  <tr><td class="bg" colspan="3">Látogatók (top 10)</td></tr>
  <tr><th colspan="2">Látogató</th><th>Oldalak</th></tr>

  <?php while($stat_row_Visitors = mysql_fetch_row($stat_resource_Visitors)) { ?>
  <tr><td colspan="2"><?php echo $stat->FormatVisitors_0($stat_row_Visitors[0]) ?></td><td align="center"><?php echo $stat_row_Visitors[1] ?></td></tr>
  <?php } //while ?>
</table>
  <?php $stat_resource_Referers = $stat->GetReferers(); ?>

<table style="width: 70%; margin-left: auto; margin-right: auto; ">

  <tr><td class="bg" colspan="3">Belépések külsõ linkekrõl (top 10)</td></tr>
  <tr><th>Linkelõ ldal</th><th>Összes letöltés</th><th>Egyedi látogató</th></tr>

  <?php while($stat_row_Referers = mysql_fetch_row($stat_resource_Referers)) { ?>
  <tr><td><a href="<?php echo $stat_row_Referers[0] ?>" target="_blank"><?php echo substr($stat_row_Referers[0], 0, 64) ?></a></td><td align="center"><?php echo $stat_row_Referers[1] ?></td><td align="center"><?php echo $stat_row_Referers[2] ?></td></tr>
  <?php } //while ?>

</table>
</div>

<p>Az adatok tájékoztató jellegûek.</p>


<?php } else { define('UNAUTHORIZED', 1); } ?>

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>
