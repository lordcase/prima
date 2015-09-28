<?php require_once('inc/boot.php') ?>
<?php //require_once('inc/bwRemoteServices.php') ?>
<?php $CBA_SECTION = 'aerobic'; ?>
<?php define('BW_NOSTAT', true); ?>
<?php require_once('views/header.php') ?>
<!-- Content Starts Here -->
<h1>Online vásárlás</h1>

<p>Kedves <strong>Teszt Eszter!</strong> Ezen az oldalon a CBA Fitness szolgáltatásait, termékeit Interneten keresztül megvásárolhatod, bankkártyás fizetéssel.</p>

<?php
$serviceGroup = array(
  array('id' => 1, 'nev' => 'Fitness bérlet, 20 alkalmas', 'bruttoar' => '12250', 'afakulcs' => '20%', 'alkalmak' => '20 alkalom', 'leiras' => 'Nyitástól 14 óráig'),
  array('id' => 1, 'nev' => 'Fitness bérlet, 20 alkalmas', 'bruttoar' => '13500', 'afakulcs' => '20%', 'alkalmak' => '20 alkalom', 'leiras' => ''),
  array('id' => 1, 'nev' => 'Fitness bérlet, 12 alkalmas', 'bruttoar' => '9850', 'afakulcs' => '20%', 'alkalmak' => '12 alkalom', 'leiras' => 'Nyitástól 14 óráig'),
  array('id' => 1, 'nev' => 'Fitness bérlet, 12 alkalmas', 'bruttoar' => '11150', 'afakulcs' => '20%', 'alkalmak' => '12 alkalom', 'leiras' => ''),
  array('id' => 1, 'nev' => 'Fitness bérlet, 8 alkalmas', 'bruttoar' => '8450', 'afakulcs' => '20%', 'alkalmak' => '8 alkalom', 'leiras' => 'Nyitástól 14 óráig'),
  array('id' => 1, 'nev' => 'Fitness bérlet, 8 alkalmas', 'bruttoar' => '9450', 'afakulcs' => '20%', 'alkalmak' => '8 alkalom', 'leiras' => ''),
  array('id' => 1, 'nev' => 'Aerobic/Spinning bérlet, 20 alkalmas', 'bruttoar' => '9800', 'afakulcs' => '20%', 'alkalmak' => '20 alkalom', 'leiras' => 'Nyitástól 14 óráig'),
  array('id' => 1, 'nev' => 'Aerobic/Spinning bérlet, 20 alkalmas', 'bruttoar' => '10950', 'afakulcs' => '20%', 'alkalmak' => '20 alkalom', 'leiras' => ''),
  array('id' => 1, 'nev' => 'Aerobic/Spinning bérlet, 12 alkalmas', 'bruttoar' => '8650', 'afakulcs' => '20%', 'alkalmak' => '12 alkalom', 'leiras' => 'Nyitástól 14 óráig'),
  array('id' => 1, 'nev' => 'Aerobic/Spinning bérlet, 12 alkalmas', 'bruttoar' => '9750', 'afakulcs' => '20%', 'alkalmak' => '12 alkalom', 'leiras' => ''),
  array('id' => 1, 'nev' => 'Aerobic/Spinning bérlet, 8 alkalmas', 'bruttoar' => '7250', 'afakulcs' => '20%', 'alkalmak' => '8 alkalom', 'leiras' => 'Nyitástól 14 óráig'),
  array('id' => 1, 'nev' => 'Aerobic/Spinning bérlet, 8 alkalmas', 'bruttoar' => '8150', 'afakulcs' => '20%', 'alkalmak' => '8 alkalom', 'leiras' => ''),
  array('id' => 1, 'nev' => 'Exkluzív tagság, 30 napos', 'bruttoar' => '21000', 'afakulcs' => '20%', 'alkalmak' => '30 nap', 'leiras' => '')
);

?>

<table style="width: 750px;">

<tr>
	<th colspan="4" class="title">Vásárolható termékek</th>
	<th colspan="2" class="nobg"> </th>
</tr>

<?php if (count($serviceGroup) > 0) { ?>

<tr>
	<th>Név</th>
	<th style="text-align: center;">Bruttó ár</th>
	<th style="text-align: center;">ÁFA-kulcs</th>
	<th style="text-align: center;">Érvényesség</th>
	<th>Leírás</th>
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
	<td colspan="6">Nincsenk tételek</td>
</tr>
<?php } ?>

<tr>
	<td colspan="6" class="nobg"> </td>
</tr>
<tr>
	<th colspan="4" class="title">Meglévõ bérlet egyenlegének feltöltése</th>
	<th colspan="2" class="nobg"> </th>
</tr>
<tr>
	<td colspan="3">Mekkora összeget kívánsz feltölteni?</td>
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
			<input type="submit" value="Feltöltöm" />
		</form>
	</td>
</tr>

</table>

<p>Korábbi vásárlásaidat áttekintheted itt: <a href="#">korábbi vásárlások</a></p>

<?php //if ($remote->SECTIONS['UNAUTHORIZED']) { ?>
<?php if (false) { ?>

<p>A foglalási rendszer használatához be kell jelentkeznie, és érvényes <strong>foglalási kóddal</strong> kell rendelkeznie. Ha már be van jelentkezve, a fogalási kódot az adatlap módosításánál tudja megadni <strong>a fejlécben található "adatlapom" linkre kattintva</strong>.</p>

<?php } ?>


<br /><br />

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>