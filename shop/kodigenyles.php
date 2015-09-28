<?php require_once('inc/boot.php') ?>
<?php require_once('inc/bwRemoteServices.php') ?>
<?php $CBA_SECTION = 'aerobic'; ?>
<?php define('BW_NOSTAT', true); ?>
<?php require_once('views/header.php') ?>
<!-- Content Starts Here -->
<h1>Foglal�si k�d ig�nyl�s</h1>

<?php $remote->Process(); ?>

<?php if ($remote->SECTIONS['NODBCONNECTION']) { ?>

<p>Ez a szolg�ltat�s jelenleg sajnos nem el�rhet�. K�r�nk pr�b�lja meg k�s�bb.</p>

<?php } ?>

<?php if ($remote->SECTIONS['EMAILFORM']) { ?>

<p>Az online foglal�si rendszer haszn�lat�hoz sz�ks�ge van egy egyedi azonos�t� k�dra. Ha az al�bbi gombra kattint, a rendszer elk�ldi �nnek ezt a k�dot az emailc�m�re. Miut�n a lev�l meg�rkezett, az adatlapj�n a "Foglal�si k�dom" rovatba kell az �gy megkapott sz�mot be�rni. A k�dot b�rmikor �jra kik�ldetheti mag�nak innen, viszont soha nem v�ltoztathatja meg! Javasoljuk hogy ezt a k�dot soha ne �rulja el senkinek.</p>

<p><strong>Figyelem!</strong> A k�dk�ld�s csak akkor lesz sikeres, ha a CBA Fitness �s Wellnesk�zpont regisztr�lt tagja, �s a regisztr�ci�kor a Fitness teremben ugyanazt az emailc�met adta meg, amit itt a honlapon haszn�l!</p>

<form action="<?php echo $remote->GetAction() ?>" method="post">
	<input type="hidden" name="formId" value="KODKULDES:KODKULDES" />
	<input type="submit" value="Email k�r�se" />
</form>

<?php } elseif ($remote->SECTIONS['THANKYOU']) { ?>

<p>Az emailt sikeresen elk�ldt�k a(z) <strong><?php echo $session->user['email'] ?></strong> emailc�mre. N�zze meg a postal�d�j�t, �s az <a href="adatmodositas.php">adatlap m�dos�t�sa</a> �rlapon t�ltse ki a <strong>Foglal�si k�d</strong> mez�t az emailben kapott k�ddal.</p>

<?php } elseif ($remote->SECTIONS['EMAILERROR']) { ?>

<p>K�dk�ld�s sikertelen!</p>

<p>Az �n �ltal megadott <strong><?php echo $session->user['email'] ?></strong> emailc�m nem tal�lhat�. Az <a href="adatmodositas.php">adatlap m�dos�t�sa</a> �rlapon adjon meg egy m�sik emailc�met, amivel regisztr�lva van a CBA Fitness �s Wellness k�zpontba; vagy ha nincs ilyen, vagy nem eml�kszik r�, akkor f�radjon be hozz�nk szem�lyesen, �s adja meg nek�nk az �j emailc�m�t.</p>

<?php } elseif ($remote->SECTIONS['ERROR']) { ?>

<p>K�dk�ld�s sikertelen!</p>

<p>Nem v�rt hiba l�pett fel. K�r�nk pr�b�lkozzon meg a k�dk�ld�ssel k�s�bb. Meg�rt�s�t k�sz�nj�k.</p>

<?php } ?>


<br /><br />

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>