<?php require_once('inc/boot.php') ?>
<?php require_once('inc/bwRemoteServices.php') ?>
<?php $CBA_SECTION = 'aerobic'; ?>
<?php define('BW_NOSTAT', true); ?>
<?php require_once('views/header.php') ?>
<!-- Content Starts Here -->
<h1>Online foglal�s</h1>

<?php $remote->Process(); ?>

<?php if ($remote->SECTIONS['NODBCONNECTION']) { ?>

<p>Karbantart�s miatt ez a szolg�ltat�s jelenleg sajnos nem el�rhet�. K�rj�k l�togasson vissza k�s�bb!</p>

<?php } ?>

<?php if ($remote->SECTIONS['FORM']) { ?>

<?php $clientsServices = $remote->GetServicesForClient(); ?>

<?php $services = $remote->GetGroupedServicesForDay($remote->dayId); ?>

<?php $days = $remote->GetDays(); ?>

<?php $navBar = "<a href=\"#foglalasaim\">Foglal�saim</a> (" . count($clientsServices) . ")" ; ?>

<?php if ($services) { foreach ($services as $serviceGroupId => $dummy) $navBar .= " | <a href=\"#" . $serviceGroupId . "\">" . $remote->GetServiceGroupName($serviceGroupId) . "</a> (" . count($dummy) . ")"; } ?>

<p>A &#8222;Foglal�saim&#8221; mellett tal�lhat� sz�m a jelenleg akt�v
	foglal�sai sz�m�t jelzi. Az &#8222;Aerobic&#8221; �s a &#8222;Squash&#8221;
	mellett tal�lhat� sz�m az adott napon szabad (foglalhat�) alkalmak/p�ly�k
	sz�m�t jelzi. Amennyiben a b�rlet�n nincs el�g keret az adott foglal�shoz,
	akkor a foglal�s sikertelen lesz.</p>
<p><strong>A squash foglal�sokat 24 �r�val az adott id�pont el�tt lehet
	lemondani, az aerobic foglal�sokat pedig 4 �r�val a kezd�s el�tt.</strong>
	Ezen id�hat�ron bel�l a foglal�s �ra mindenk�pp levon�sra ker�l a b�rletr�l,
	a foglal�sok pedig nem visszavonhat�ak m�r, hogy az esetleges vissza�l�seket
	elker�lj�k. Meg�rt�s�ket k�sz�nj�k!</p>


<p><?php echo $navBar ?></p>

<div><strong>
<?php echo $remote->GetFeedback(); ?>
</strong></div>

<a name="foglalasaim"></a>

<?php if (count($clientsServices) > 0) { ?>

<table>
<tr>
	<th colspan="3" class="title">Aktu�lis foglal�saim: <?php echo $remote->client['NEV'] ?></th>
	<th colspan="2" class="nobg"> </th>
</tr>
<tr>
	<th>�rat�pus</th>
	<th>Kezd�s</th>
	<th>Befejez�s</th>
	<th>Helysz�n</th>
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
			<input type="submit" value="T�rl�s<?php /*echo $service['cikk'] . " " . date("H:i", strtotime($service['kezdes']))*/ ?>" />
		</form>
		<?php } else {?>
		M�r nem t�r�lhet�.
		<?php } ?>
	</td>
</tr>
<?php } ?>

</table>

<?php } else { ?>
<p>Jelenleg nincs foglal�sod egyetlen �r�ra sem.</p>
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
			D�tum v�lt�sa: 
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
	<th>�rat�pus</th>
	<th style="text-align: center;">Kezd�s</th>
	<th style="text-align: center;">Befejez�s</th>
	<th>Helysz�n</th>
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
			<input type="submit" value="Foglal�s<?php /*echo $service['cikk'] . " " . date("H:i", strtotime($service['kezdes']))*/ ?>" />
		</form>
	</td>
</tr>
<?php } ?>
<tr>
	<td colspan="6" class="nobg"> </td>
</tr>
<?php } else {?>
<tr>
	<td colspan="6">Erre a napra nincs ilyen foglal�si lehet�s�g.</td>
</tr>
<?php } ?>
<?php } ?>
<?php } else { ?>
<tr>
	<th colspan="4" class="title">Nincs tal�lat</th>
	<th colspan="2" class="nobg"> </th>
</tr>
<tr>
	<td class="bg"><strong><?php echo $remote->dayId ?></strong></td>
	<td colspan="3" class="bg">
		<form action="<?php echo $remote->GetAction() ?>" method="post">
			<input type="hidden" name="formId" value="FOGLALAS:DATUMVALTAS" />
			D�tum v�lt�sa: 
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
	<td colspan="6">Erre a napra nincs foglal�si lehet�s�g.</td>
</tr>
<?php } ?>
</table>


<?php } ?>

<?php if ($remote->SECTIONS['UNAUTHORIZED']) { ?>

<p>A foglal�si rendszer haszn�lat�hoz be kell jelentkeznie, �s �rv�nyes <strong>foglal�si k�ddal</strong> kell rendelkeznie. Ha m�r be van jelentkezve, a fogal�si k�dot az adatlap m�dos�t�s�n�l tudja megadni <strong>a fejl�cben tal�lhat� "adatlapom" linkre kattintva</strong>.</p>

<?php } ?>


<br /><br />

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>