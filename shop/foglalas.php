<?php require_once('inc/boot.php') ?>
<?php require_once('inc/bwRemoteServices.php') ?>
<?php $CBA_SECTION = 'aerobic'; ?>
<?php define('BW_NOSTAT', true); ?>
<?php require_once('views/header.php') ?>
<!-- Content Starts Here -->
<h1>Online foglalás</h1>

<?php $remote->Process(); ?>

<?php if ($remote->SECTIONS['NODBCONNECTION']) { ?>

<p>Karbantartás miatt ez a szolgáltatás jelenleg sajnos nem elérhetõ. Kérjük látogasson vissza késõbb!</p>

<?php } ?>

<?php if ($remote->SECTIONS['FORM']) { ?>

<?php $clientsServices = $remote->GetServicesForClient(); ?>

<?php $services = $remote->GetGroupedServicesForDay($remote->dayId); ?>

<?php $days = $remote->GetDays(); ?>

<?php $navBar = "<a href=\"#foglalasaim\">Foglalásaim</a> (" . count($clientsServices) . ")" ; ?>

<?php if ($services) { foreach ($services as $serviceGroupId => $dummy) $navBar .= " | <a href=\"#" . $serviceGroupId . "\">" . $remote->GetServiceGroupName($serviceGroupId) . "</a> (" . count($dummy) . ")"; } ?>

<p>A &#8222;Foglalásaim&#8221; mellett található szám a jelenleg aktív
	foglalásai számát jelzi. Az &#8222;Aerobic&#8221; és a &#8222;Squash&#8221;
	mellett található szám az adott napon szabad (foglalható) alkalmak/pályák
	számát jelzi. Amennyiben a bérletén nincs elég keret az adott foglaláshoz,
	akkor a foglalás sikertelen lesz.</p>
<p><strong>A squash foglalásokat 24 órával az adott idõpont elõtt lehet
	lemondani, az aerobic foglalásokat pedig 4 órával a kezdés elõtt.</strong>
	Ezen idõhatáron belül a foglalás ára mindenképp levonásra kerül a bérletrõl,
	a foglalások pedig nem visszavonhatóak már, hogy az esetleges visszaéléseket
	elkerüljük. Megértésüket köszönjük!</p>


<p><?php echo $navBar ?></p>

<div><strong>
<?php echo $remote->GetFeedback(); ?>
</strong></div>

<a name="foglalasaim"></a>

<?php if (count($clientsServices) > 0) { ?>

<table>
<tr>
	<th colspan="3" class="title">Aktuális foglalásaim: <?php echo $remote->client['NEV'] ?></th>
	<th colspan="2" class="nobg"> </th>
</tr>
<tr>
	<th>Óratípus</th>
	<th>Kezdés</th>
	<th>Befejezés</th>
	<th>Helyszín</th>
	<th></th>
</tr>

<?php foreach ($clientsServices as $service) { ?>
<tr>
	<td><?php echo $service['cikk'] ?></td>
	<td><?php echo $service['kezdes_formatted'] ?></td>
	<td><?php echo $service['vege_formatted_short'] ?></td>
	<td><?php echo $service['hely'] ?></td>
	<td>
		<?php if ($service['can_cancel']) { ?>
		<form action="<?php echo $remote->GetAction() ?>" method="post">
			<input type="hidden" name="formId" value="FOGLALAS:TOROL" />
			<input type="hidden" name="start" value="<?php echo $service['kezdes_formatted'] ?>" />
			<input type="hidden" name="roomId" value="<?php echo $service['idhely'] ?>" />
			<input type="hidden" name="serviceId" value="<?php echo $service['idcikk'] ?>" />
			<input type="hidden" name="roomName" value="<?php echo $service['hely'] ?>" />
			<input type="hidden" name="serviceName" value="<?php echo $service['cikk'] ?>" />
			<input type="hidden" name="keepDate" value="<?php echo $remote->dayId ?>" />
			<input type="submit" value="Törlés<?php /*echo $service['cikk'] . " " . date("H:i", strtotime($service['kezdes']))*/ ?>" />
		</form>
		<?php } else {?>
		Már nem törölhetõ.
		<?php } ?>
	</td>
</tr>
<?php } ?>

</table>

<?php } else { ?>
<p>Jelenleg nincs foglalásod egyetlen órára sem.</p>
<?php } ?>


<table width="100%">
<?php if ($services) {  ?>
<?php foreach ($services as $serviceGroupId => $serviceGroup) { ?>

<tr>
	<td colspan="6" class="nobg" ><a name="<?php echo $serviceGroupId ?>"></a> </td>
</tr>
<tr>
	<td colspan="6" class="nobg" style="width: auto;"><p><?php echo $navBar ?></p></td>
</tr>
<tr>
	<th colspan="4" class="title"><?php echo $remote->GetServiceGroupName($serviceGroupId); ?></th>
	<th colspan="2" class="nobg"> </th>
</tr>
<tr>
	<td class="bg"><strong><?php echo $remote->dayId ?></strong></td>
	<td colspan="3" class="bg">
		<form action="<?php echo $remote->GetAction() . "#" . $serviceGroupId ?>" method="post">
			<input type="hidden" name="formId" value="FOGLALAS:DATUMVALTAS" />
			Dátum váltása: 
			<select name="date">
			<?php foreach ($days as $dayId => $dayString) { ?>
				<option value="<?php echo $dayId ?>" <?php if ($dayId == $remote->dayId) echo "selected=\"selected\"" ?>><?php echo $dayString ?></option>
			<?php } ?>
			</select>
			<input type="submit" value="Mehet" />
		</form>
	</td>
	<th colspan="2" class="nobg"> </th>
</tr>

<?php if (count($serviceGroup) > 0) { ?>

<tr>
	<th>Óratípus</th>
	<th style="text-align: center;">Kezdés</th>
	<th style="text-align: center;">Befejezés</th>
	<th>Helyszín</th>
	<th style="text-align: center;">Szabad helyek</th>
	<th> </th>
</tr>

<?php foreach ($serviceGroup as $service) { ?>
<tr>
	<td><strong><?php echo $service['cikk'] ?></strong></td>
	<td class="center"><strong><?php echo $service['kezdes_formatted_short'] ?></strong></td>
	<td class="center"><?php echo $service['vege_formatted_short'] ?></td>
	<td><?php echo $service['hely'] ?></td>
	<td class="center"><?php echo $service['szabad_hely'] ?></td>
	<td>
		<form action="<?php echo $remote->GetAction() ?>" method="post">
			<input type="hidden" name="formId" value="FOGLALAS:HOZZAAD" />
			<input type="hidden" name="start" value="<?php echo $service['kezdes_formatted'] ?>" />
			<input type="hidden" name="roomId" value="<?php echo $service['idhely'] ?>" />
			<input type="hidden" name="serviceId" value="<?php echo $service['idcikk'] ?>" />
			<input type="hidden" name="roomName" value="<?php echo $service['hely'] ?>" />
			<input type="hidden" name="serviceName" value="<?php echo $service['cikk'] ?>" />
			<input type="hidden" name="keepDate" value="<?php echo $remote->dayId ?>" />
			<input type="submit" value="Foglalás<?php /*echo $service['cikk'] . " " . date("H:i", strtotime($service['kezdes']))*/ ?>" />
		</form>
	</td>
</tr>
<?php } ?>
<tr>
	<td colspan="6" class="nobg"> </td>
</tr>
<?php } else {?>
<tr>
	<td colspan="6">Erre a napra nincs ilyen foglalási lehetõség.</td>
</tr>
<?php } ?>
<?php } ?>
<?php } else { ?>
<tr>
	<th colspan="4" class="title">Nincs találat</th>
	<th colspan="2" class="nobg"> </th>
</tr>
<tr>
	<td class="bg"><strong><?php echo $remote->dayId ?></strong></td>
	<td colspan="3" class="bg">
		<form action="<?php echo $remote->GetAction() ?>" method="post">
			<input type="hidden" name="formId" value="FOGLALAS:DATUMVALTAS" />
			Dátum váltása: 
			<select name="date">
			<?php foreach ($days as $dayId => $dayString) { ?>
				<option value="<?php echo $dayId ?>" <?php if ($dayId == $remote->dayId) echo "selected=\"selected\"" ?>><?php echo $dayString ?></option>
			<?php } ?>
			</select>
			<input type="submit" value="Mehet" />
		</form>
	</td>
	<th colspan="2" class="nobg"> </th>
</tr>
<tr>
	<td colspan="6">Erre a napra nincs foglalási lehetõség.</td>
</tr>
<?php } ?>
</table>


<?php } ?>

<?php if ($remote->SECTIONS['UNAUTHORIZED']) { ?>

<p>A foglalási rendszer használatához be kell jelentkeznie, és érvényes <strong>foglalási kóddal</strong> kell rendelkeznie. Ha már be van jelentkezve, a fogalási kódot az adatlap módosításánál tudja megadni <strong>a fejlécben található "adatlapom" linkre kattintva</strong>.</p>

<?php } ?>


<br /><br />

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>