<?php require_once('inc/boot.php') ?>
<?php require_once('inc/bwRemoteServices.php') ?>
<?php $CBA_SECTION = 'aerobic'; ?>
<?php define('BW_NOSTAT', true); ?>
<?php require_once('views/header.php') ?>
<!-- Content Starts Here -->
<h1>Foglalási kód igénylés</h1>

<?php $remote->Process(); ?>

<?php if ($remote->SECTIONS['NODBCONNECTION']) { ?>

<p>Ez a szolgáltatás jelenleg sajnos nem elérhetõ. Kérünk próbálja meg késõbb.</p>

<?php } ?>

<?php if ($remote->SECTIONS['EMAILFORM']) { ?>

<p>Az online foglalási rendszer használatához szüksége van egy egyedi azonosító kódra. Ha az alábbi gombra kattint, a rendszer elküldi Önnek ezt a kódot az emailcímére. Miután a levél megérkezett, az adatlapján a "Foglalási kódom" rovatba kell az így megkapott számot beírni. A kódot bármikor újra kiküldetheti magának innen, viszont soha nem változtathatja meg! Javasoljuk hogy ezt a kódot soha ne árulja el senkinek.</p>

<p><strong>Figyelem!</strong> A kódküldés csak akkor lesz sikeres, ha a CBA Fitness és Wellnesközpont regisztrált tagja, és a regisztrációkor a Fitness teremben ugyanazt az emailcímet adta meg, amit itt a honlapon használ!</p>

<form action="<?php echo $remote->GetAction() ?>" method="post">
	<input type="hidden" name="formId" value="KODKULDES:KODKULDES" />
	<input type="submit" value="Email kérése" />
</form>

<?php } elseif ($remote->SECTIONS['THANKYOU']) { ?>

<p>Az emailt sikeresen elküldtük a(z) <strong><?php echo $session->user['email'] ?></strong> emailcímre. Nézze meg a postaládáját, és az <a href="adatmodositas.php">adatlap módosítása</a> ûrlapon töltse ki a <strong>Foglalási kód</strong> mezõt az emailben kapott kóddal.</p>

<?php } elseif ($remote->SECTIONS['EMAILERROR']) { ?>

<p>Kódküldés sikertelen!</p>

<p>Az Ön által megadott <strong><?php echo $session->user['email'] ?></strong> emailcím nem található. Az <a href="adatmodositas.php">adatlap módosítása</a> ûrlapon adjon meg egy másik emailcímet, amivel regisztrálva van a CBA Fitness és Wellness központba; vagy ha nincs ilyen, vagy nem emlékszik rá, akkor fáradjon be hozzánk személyesen, és adja meg nekünk az új emailcímét.</p>

<?php } elseif ($remote->SECTIONS['ERROR']) { ?>

<p>Kódküldés sikertelen!</p>

<p>Nem várt hiba lépett fel. Kérünk próbálkozzon meg a kódküldéssel késõbb. Megértését köszönjük.</p>

<?php } ?>


<br /><br />

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>