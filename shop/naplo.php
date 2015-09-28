<?php define('BW_NOSTAT', 1); ?>
<?php require_once('inc/boot.php') ?>
<?php $CBA_SECTION = 'admin'; ?>

<?php
	error_reporting(1);

  require_once('inc/bwComponent.php');
  require_once('inc/bwDataset.php');
  require_once('inc/bwLog.php');
  

	/****************************************************************************/
	/* Az összes hónapot tartalmazó <option>...</option> sort adja vissza.      */
	/****************************************************************************/

	//if(!is_integer($firstYear) || ($firstYear < 2006)) $firstYear = 2006;
	//if(!is_integer($firstMonth) || ($firstMonth < 1) || ($firstMonth > 12)) $firstMonth = 1;
	
	$firstYear = 2007;
	$firstMonth = 12;
	
	$lastYear = date("Y");
	$lastMonth = date("m");

	if (isset($_POST["selectYearMonth"]))
	{
		$selectedYearMonth = htmlspecialchars($_POST["selectYearMonth"]);
	}
	else
	{
		$selectedYearMonth = $lastYear . '-' . $lastMonth;
	}

	$selectHtml = "";

	for($year = $firstYear; $year<=$lastYear; $year++)
	{
		$monthMax = ($year == $lastYear) ? intval($lastMonth) : 12;
		for($month = ($year == $firstYear) ? $firstMonth : 1; $month <= $monthMax; $month++)
		{
			$value = ($month <= 9) ? ($year . "-0" . $month) : ($year . "-" . $month);
			$selectedHtml = ($selectedYearMonth == $value) ? " selected=\"selected\"" : "";

			$selectHtml .= "<option value=\"" . $value .  "\"" . $selectedHtml . ">" . strftime("%Y. %B", strtotime($year . "-" . $month . "-01")) . "</option>\n";
		}
	}
	
	
  $log->SetSort('created', true);
	$log->SelectFoglalasByMonth($selectedYearMonth);

?>

<?php require_once('views/admHeader.php') ?>
<!-- Content Starts Here -->
<?php if($session->GetUserLevel() >= bwSession::EDITOR) { ?>

<h1>Eseménynapló</h1>

<p><a href="online_log.php">Online vásárlási napló</a><?php if($session->GetUserLevel() >= bwSession::ADMIN) { ?> | <a href="teljesnaplo.php">Teljes biztonsági napló</a><?php } ?></p>

<div style="text-align: center; ">
<table style="width: 90%; margin-left: auto; margin-right: auto; ">
	<tr>
		<td class="bg" colspan="6">
		<form action="naplo.php" method="post">
			<label>Online feliratkozással kapcsolatos események ebben a hónapban:</label>
			<select name="selectYearMonth">
				<?php echo $selectHtml ?>
			</select>
			<input type="submit" value="OK" />
		</form>
		</td>
	</tr>
  <tr>
    <th rowspan="2">#</th>
    <th>Dátum</th>
    <th>Felhasználó</th>
    <th>IP-cím</th>
    <th>Kérés innen</th>
	</tr>
    <th colspan="4">Esemény</th>
  </tr>
	<tr>
		<td colspan=5 class="nobg" style="height: 8px;"></td>
	</tr>
  <?php foreach($log->item as $item) { ?>
  <tr>
    <td rowspan="2"><?php echo $item['id'] ?></td>
    <td><?php echo $item['created'] ?></td>
    <td><a href="mailto:<?php echo $item['user_email'] ?>"><?php echo $item['user_nick'] ?></a></td>
    <td><?php echo $item['ip'] ?></td>
    <td><?php echo $item['referer'] ?></td>
	</tr>
	<tr>
    <td colspan="4"><?php echo $item['body'] ?></td>
  </tr>
	<tr>
		<td colspan=5 class="nobg" style="height: 8px;"></td>
	</tr>
  <?php } ?>
</table>
</div>

&nbsp; &nbsp;

<?php } else { define('UNAUTHORIZED', 1); } ?>

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>
