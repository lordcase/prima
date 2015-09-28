<?php require_once('inc/boot.php') ?>
<?php $CBA_SECTION = 'orarend'; ?>
<?php require_once('inc/bwSchedule.php') ?>
<?php require_once('inc/bwArticle.php') ?>
<?php require_once('views/header.php') ?>
<!-- Content Starts Here -->

<h2 style="float: right; margin-top: 14px;"><a href="<?php echo $schedule->GetPrintURL(); ?>">Letölthetõ PDF órarend</a></h2>

<h1>Órarend</h1>


<h2>Érvényes: <?php echo $schedule->GetWeekName(); ?>-ig</h2>

<p>Csoportos órák 100 négyzetméteren<br />
Taraflex sportpadló - az olimpiai játékok hivatalos beszállítója</p>
<p>Oldalunkon lehetõség van <a href="/felhasznalo.php" target="_self">online foglalásra</a>!<br />
<strong>Érvényes bérlettel, valamint e-mail címmel rendelkezõ regisztrált tagjaink</strong> online is foglalhatnak helyet kedvenc aerobic óráikra, valamint a fallabdapályákra honlapunkon keresztül.<br />
Kérjük, hogy -ha még nem tette meg- adja meg e-mail címét a Sportközpontunkban, hogy a jövõben minél könyebben használhassa Ön is ezt a szolgáltatást.<br />
<strong>Figyelem! Foglalás csak a bérlet érvényességi határidején belül, valamint az érvényes alkalmak számáig lehetséges!</strong></p>

<p style="color: #FF0033; font-weight: bold">Öltözõszekrényeink RIASZTÓRENDSZERREL vannak felszerelve!</p>


<?php if ($article->IsVisible('orarend')) echo "<hr />" . $article->GetBody('orarend') . "<hr />\n"; ?>

<!--
<span style="color: #FF0000; font-size: 14"></span>
<p style="color: #FF0000; font-size: 14"><strong>Express Way!<br />
Gyorsan és könnyen, sorban állás és várakozás nélkül!</strong></p>
<p>Ha nem szeretsz sorban állni, várakozni, lekésni az óráidat, ha szeretnél a leggyorsabban bejutni várakozás nélkül az aerobic órádra vagy a fitness terembe, akkor ezt neked találtuk ki!<br />
Ezt a lehetoséget az <strong>"Express Way"</strong> extra szolgáltatásunk nyújtja számodra: <span style="font-style: italic">egyszeri</span> 550 Ft-os akciós ár ellenében, amiért egy darab clubórát kapsz cserébe, melyet távozás után elvihetsz magaddal.<br />
Amennyiben már nincs lehetoséged clubunkba járni, ezt a pénzt visszakapod a clubóra ellenében!</p> 
<p style="font-style: italic">Az órarend és az óratartó oktató változtatásának jogát fenntartjuk! Az emiatt eloforduló esetleges kellemetlenségekért elnézésüket kérjük!</p> -->

<?php if(($schedule->week == 1) || ($schedule->GetStatus() == '1')) { ?>

<?php if($schedule->week == 2) { ?>

<p><a href="<?php echo $_SERVER['PHP_SELF'] ?>">Vissza az eheti órarendhez</a></p>

<?php } elseif($schedule->GetStatus() == '1') { ?>

<p>A jövõheti órarend már megtekinthetõ, kattints ide: <a href="<?php echo $_SERVER['PHP_SELF'] . '?jovohet' ?>">Jövõheti órarend</a></p>

<?php } ?>

<a name="terem1"></a>
<table id="bweTable1">
<tr>
<th rowspan="3" class="nobg">&nbsp;</th>
<th colspan="4" class="title">Rexona aerobic terem</th>
<th colspan="3" class="nobg"></th>
</tr>
<tr>
<th colspan="7">Az edzések egész órakor kezdõdnek</th>
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


<p>A Kangoo Jumps órákra - az aerobic belépõ mellett - 500.-Ft bérleti díjat sziveskedjenek elõkészíteni :-))<br />
Felhívjuk kedves Vendégeink figyelmét, hogy a Kangoo Jumps, kick-boksz, és a spinningen vezetett órákra lehet, és érdemes elõre bejelentkezni, a nagy
érdeklõdésre, és a sporteszközök korlátozott számára tekintettel!</p>

<a name="terem2"></a>
<table id="bweTable2">
<tr>
<th rowspan="3" class="nobg">&nbsp;</th>
<th colspan="4" class="title">Vitalade aerobic - spinning terem</th>
<th colspan="3" class="nobg"></th>
</tr>
<tr>
<th colspan="7">Az edzések óra 30-kor kezdõdnek</th>
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
<p>Felhívjuk kedves Vendégeink figyelmét, hogy a spinningen vezetett órákra lehet, és érdemes elõre bejelentkezni, a nagy érdeklõdésre
tekintettel!<br /></p>
<p style="font-style: italic"><strong>Az órarend és az óratartó oktató változtatásának jogát fenntartjuk! Az emiatt elõforduló esetleges kellemetlenségekért elnézésüket kérjük!</strong></p>

<h2 style="float: right; margin-top: 14px;"><a href="<?php echo $schedule->GetPrintURL(); ?>">Letölthetõ PDF órarend</a></h2>
<div style="clear: both"></div>

<?php } else { ?>

<p>A jövõ heti órarend még nincs publikálva. Tekintsd meg az <a href="<?php echo $_SERVER['PHP_SELF'] ?>">eheti órarendet</a>.</p>

<?php } ?>

<script type="text/javascript" src="js/popup.js"></script>

<?php include("popup_orarend.php") ?>

<?php require_once('views/footer.php') ?>
