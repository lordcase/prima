<?php require_once('inc/boot.php') ?>
<?php //require_once('inc/bwRemoteServices.php') ?>
<?php $CBA_SECTION = 'aerobic'; ?>
<?php define('BW_NOSTAT', true); ?>
<?php require_once('views/header.php') ?>
<!-- Content Starts Here -->
<h1>Online v�s�rl�s</h1>

<p>Kedves <strong>Teszt Eszter!</strong> Ezen az oldalon a CBA Fitness szolg�ltat�sait, term�keit Interneten kereszt�l megv�s�rolhatod, bankk�rty�s fizet�ssel.</p>

<?php
$serviceGroup = array(
  array('id' => 1, 'nev' => 'Fitness b�rlet, 20 alkalmas', 'bruttoar' => '12250', 'afakulcs' => '20%', 'alkalmak' => '20 alkalom', 'leiras' => 'Nyit�st�l 14 �r�ig'),
  array('id' => 1, 'nev' => 'Fitness b�rlet, 20 alkalmas', 'bruttoar' => '13500', 'afakulcs' => '20%', 'alkalmak' => '20 alkalom', 'leiras' => ''),
  array('id' => 1, 'nev' => 'Fitness b�rlet, 12 alkalmas', 'bruttoar' => '9850', 'afakulcs' => '20%', 'alkalmak' => '12 alkalom', 'leiras' => 'Nyit�st�l 14 �r�ig'),
  array('id' => 1, 'nev' => 'Fitness b�rlet, 12 alkalmas', 'bruttoar' => '11150', 'afakulcs' => '20%', 'alkalmak' => '12 alkalom', 'leiras' => ''),
  array('id' => 1, 'nev' => 'Fitness b�rlet, 8 alkalmas', 'bruttoar' => '8450', 'afakulcs' => '20%', 'alkalmak' => '8 alkalom', 'leiras' => 'Nyit�st�l 14 �r�ig'),
  array('id' => 1, 'nev' => 'Fitness b�rlet, 8 alkalmas', 'bruttoar' => '9450', 'afakulcs' => '20%', 'alkalmak' => '8 alkalom', 'leiras' => ''),
  array('id' => 1, 'nev' => 'Aerobic/Spinning b�rlet, 20 alkalmas', 'bruttoar' => '9800', 'afakulcs' => '20%', 'alkalmak' => '20 alkalom', 'leiras' => 'Nyit�st�l 14 �r�ig'),
  array('id' => 1, 'nev' => 'Aerobic/Spinning b�rlet, 20 alkalmas', 'bruttoar' => '10950', 'afakulcs' => '20%', 'alkalmak' => '20 alkalom', 'leiras' => ''),
  array('id' => 1, 'nev' => 'Aerobic/Spinning b�rlet, 12 alkalmas', 'bruttoar' => '8650', 'afakulcs' => '20%', 'alkalmak' => '12 alkalom', 'leiras' => 'Nyit�st�l 14 �r�ig'),
  array('id' => 1, 'nev' => 'Aerobic/Spinning b�rlet, 12 alkalmas', 'bruttoar' => '9750', 'afakulcs' => '20%', 'alkalmak' => '12 alkalom', 'leiras' => ''),
  array('id' => 1, 'nev' => 'Aerobic/Spinning b�rlet, 8 alkalmas', 'bruttoar' => '7250', 'afakulcs' => '20%', 'alkalmak' => '8 alkalom', 'leiras' => 'Nyit�st�l 14 �r�ig'),
  array('id' => 1, 'nev' => 'Aerobic/Spinning b�rlet, 8 alkalmas', 'bruttoar' => '8150', 'afakulcs' => '20%', 'alkalmak' => '8 alkalom', 'leiras' => ''),
  array('id' => 1, 'nev' => 'Exkluz�v tags�g, 30 napos', 'bruttoar' => '21000', 'afakulcs' => '20%', 'alkalmak' => '30 nap', 'leiras' => '')
);

?>

<table style="width: 750px;">

<tr>
	<th colspan="4" class="title">V�s�rolhat� term�kek</th>
	<th colspan="2" class="nobg"> </th>
</tr>

<?php if (count($serviceGroup) > 0) { ?>

<tr>
	<th>N�v</th>
	<th style="text-align: center;">Brutt� �r</th>
	<th style="text-align: center;">�FA-kulcs</th>
	<th style="text-align: center;">�rv�nyess�g</th>
	<th>Le�r�s</th>
	<th> </th>
</tr>

<?php foreach ($serviceGroup as $service) { ?>
<tr>
	<td><strong><?php echo $service['nev'] ?></strong></td>
	<td class="center"><?php echo $service['bruttoar'] ?> Ft</td>
	<td class="center"><?php echo $service['afakulcs'] ?></td>
	<td class="center"><?php echo $service['alkalmak'] ?></td>
	<td><?php echo $service['leiras'] ?></td>
	<td>
		<form action="" method="post">
			<input type="hidden" name="formId" value="" />
			<input type="hidden" name="id" value="<?php echo $service['id'] ?>" />
			<input type="submit" value="Megveszem" />
		</form>
	</td>
</tr>
<?php } ?>
<tr>
	<td colspan="6" class="nobg"> </td>
</tr>
<?php } else {?>
<tr>
	<td colspan="6">Nincsenk t�telek</td>
</tr>
<?php } ?>

<tr>
	<td colspan="6" class="nobg"> </td>
</tr>
<tr>
	<th colspan="4" class="title">Megl�v� b�rlet egyenleg�nek felt�lt�se</th>
	<th colspan="2" class="nobg"> </th>
</tr>
<tr>
	<td colspan="3">Mekkora �sszeget k�v�nsz felt�lteni?</td>
	<td colspan="2" class="center">
    	<select style="width: 170px;">
        	<option></option>
        	<option>1000 Ft</option>
        	<option>5000 Ft</option>
        	<option>10000 Ft</option>
        	<option>15000 Ft</option>
        	<option>20000 Ft</option>
    	</select>
    </td>
	<td>
		<form action="" method="post">
			<input type="hidden" name="formId" value="" />
			<input type="submit" value="Felt�lt�m" />
		</form>
	</td>
</tr>

</table>

<p>Kor�bbi v�s�rl�saidat �ttekintheted itt: <a href="#">kor�bbi v�s�rl�sok</a></p>

<?php //if ($remote->SECTIONS['UNAUTHORIZED']) { ?>
<?php if (false) { ?>

<p>A foglal�si rendszer haszn�lat�hoz be kell jelentkeznie, �s �rv�nyes <strong>foglal�si k�ddal</strong> kell rendelkeznie. Ha m�r be van jelentkezve, a fogal�si k�dot az adatlap m�dos�t�s�n�l tudja megadni <strong>a fejl�cben tal�lhat� "adatlapom" linkre kattintva</strong>.</p>

<?php } ?>


<br /><br />

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>