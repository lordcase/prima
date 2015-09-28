<?php require_once('inc/boot.php') ?>
<?php $CBA_SECTION = 'orarend'; ?>
<?php require_once('inc/bwSchedule.php') ?>
<?php require_once('inc/bwArticle.php') ?>
<?php require_once('views/header.php') ?>
<!-- Content Starts Here -->

<h2 style="float: right; margin-top: 14px;"><a href="<?php echo $schedule->GetPrintURL(); ?>">Let�lthet� PDF �rarend</a></h2>

<h1>�rarend</h1>


<h2>�rv�nyes: <?php echo $schedule->GetWeekName(); ?>-ig</h2>

<p>Csoportos �r�k 100 n�gyzetm�teren<br />
Taraflex sportpadl� - az olimpiai j�t�kok hivatalos besz�ll�t�ja</p>
<p>Oldalunkon lehet�s�g van <a href="/felhasznalo.php" target="_self">online foglal�sra</a>!<br />
<strong>�rv�nyes b�rlettel, valamint e-mail c�mmel rendelkez� regisztr�lt tagjaink</strong> online is foglalhatnak helyet kedvenc aerobic �r�ikra, valamint a fallabdap�ly�kra honlapunkon kereszt�l.<br />
K�rj�k, hogy -ha m�g nem tette meg- adja meg e-mail c�m�t a Sportk�zpontunkban, hogy a j�v�ben min�l k�nyebben haszn�lhassa �n is ezt a szolg�ltat�st.<br />
<strong>Figyelem! Foglal�s csak a b�rlet �rv�nyess�gi hat�ridej�n bel�l, valamint az �rv�nyes alkalmak sz�m�ig lehets�ges!</strong></p>

<p style="color: #FF0033; font-weight: bold">�lt�z�szekr�nyeink RIASZT�RENDSZERREL vannak felszerelve!</p>


<?php if ($article->IsVisible('orarend')) echo "<hr />" . $article->GetBody('orarend') . "<hr />\n"; ?>

<!--
<span style="color: #FF0000; font-size: 14"></span>
<p style="color: #FF0000; font-size: 14"><strong>Express Way!<br />
Gyorsan �s k�nnyen, sorban �ll�s �s v�rakoz�s n�lk�l!</strong></p>
<p>Ha nem szeretsz sorban �llni, v�rakozni, lek�sni az �r�idat, ha szeretn�l a leggyorsabban bejutni v�rakoz�s n�lk�l az aerobic �r�dra vagy a fitness terembe, akkor ezt neked tal�ltuk ki!<br />
Ezt a lehetos�get az <strong>"Express Way"</strong> extra szolg�ltat�sunk ny�jtja sz�modra: <span style="font-style: italic">egyszeri</span> 550 Ft-os akci�s �r ellen�ben, ami�rt egy darab club�r�t kapsz cser�be, melyet t�voz�s ut�n elvihetsz magaddal.<br />
Amennyiben m�r nincs lehetos�ged clubunkba j�rni, ezt a p�nzt visszakapod a club�ra ellen�ben!</p> 
<p style="font-style: italic">Az �rarend �s az �ratart� oktat� v�ltoztat�s�nak jog�t fenntartjuk! Az emiatt elofordul� esetleges kellemetlens�gek�rt eln�z�s�ket k�rj�k!</p> -->

<?php if(($schedule->week == 1) || ($schedule->GetStatus() == '1')) { ?>

<?php if($schedule->week == 2) { ?>

<p><a href="<?php echo $_SERVER['PHP_SELF'] ?>">Vissza az eheti �rarendhez</a></p>

<?php } elseif($schedule->GetStatus() == '1') { ?>

<p>A j�v�heti �rarend m�r megtekinthet�, kattints ide: <a href="<?php echo $_SERVER['PHP_SELF'] . '?jovohet' ?>">J�v�heti �rarend</a></p>

<?php } ?>

<a name="terem1"></a>
<table id="bweTable1">
<tr>
<th rowspan="3" class="nobg">&nbsp;</th>
<th colspan="4" class="title">Rexona aerobic terem</th>
<th colspan="3" class="nobg"></th>
</tr>
<tr>
<th colspan="7">Az edz�sek eg�sz �rakor kezd�dnek</th>
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

<?php for($hour=6; $hour<=20; $hour++) { ?>

<tr>
  <td><?php echo $hour ?>:00</td>
  <?php for($day=1; $day<=7; $day++) { ?>
  <?php $cellId = 'bwec1_' . $day . '_' . $hour ?>
  <td id="<?php echo $cellId ?>" class="<?php echo $schedule->GetClassSpecialLabel(1, $day, $hour) ?>"><?php echo $schedule->GetActiveClassLabel(1, $day, $hour) ?></td>
  <?php } ?>
</tr>

<?php } ?>
</table>


<p>A Kangoo Jumps �r�kra - az aerobic bel�p� mellett - 500.-Ft b�rleti d�jat sziveskedjenek el�k�sz�teni :-))<br />
Felh�vjuk kedves Vend�geink figyelm�t, hogy a Kangoo Jumps, kick-boksz, �s a spinningen vezetett �r�kra lehet, �s �rdemes el�re bejelentkezni, a nagy
�rdekl�d�sre, �s a sporteszk�z�k korl�tozott sz�m�ra tekintettel!</p>

<a name="terem2"></a>
<table id="bweTable2">
<tr>
<th rowspan="3" class="nobg">&nbsp;</th>
<th colspan="4" class="title">Vitalade aerobic - spinning terem</th>
<th colspan="3" class="nobg"></th>
</tr>
<tr>
<th colspan="7">Az edz�sek �ra 30-kor kezd�dnek</th>
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

<?php $min = '15'; ?>

<?php for($hour=6; $hour<=20; $hour++) { ?>

<tr>
  <td><?php echo $hour . ':' . $min ?></td>
  <?php for($day=1; $day<=7; $day++) { ?>
  <?php $cellId = 'bwec2_' . $day . '_' . $hour ?>
  <td id="<?php echo $cellId ?>" class="<?php echo $schedule->GetClassSpecialLabel(2, $day, $hour) ?>"><?php echo $schedule->GetActiveClassLabel(2, $day, $hour) ?></td>

  <?php $min = '30'; ?>

  <?php } ?>
</tr>


<?php } ?>
</table>

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
<p>Felh�vjuk kedves Vend�geink figyelm�t, hogy a spinningen vezetett �r�kra lehet, �s �rdemes el�re bejelentkezni, a nagy �rdekl�d�sre
tekintettel!<br /></p>
<p style="font-style: italic"><strong>Az �rarend �s az �ratart� oktat� v�ltoztat�s�nak jog�t fenntartjuk! Az emiatt el�fordul� esetleges kellemetlens�gek�rt eln�z�s�ket k�rj�k!</strong></p>

<h2 style="float: right; margin-top: 14px;"><a href="<?php echo $schedule->GetPrintURL(); ?>">Let�lthet� PDF �rarend</a></h2>
<div style="clear: both"></div>

<?php } else { ?>

<p>A j�v� heti �rarend m�g nincs publik�lva. Tekintsd meg az <a href="<?php echo $_SERVER['PHP_SELF'] ?>">eheti �rarendet</a>.</p>

<?php } ?>

<script type="text/javascript" src="js/popup.js"></script>

<?php include("popup_orarend.php") ?>

<?php require_once('views/footer.php') ?>
