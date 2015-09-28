<?php require_once('inc/boot.php') ?>
<?php $CBA_SECTION = 'vendegkonyv'; ?>
<?php require_once('inc/bwGuestbook.php') ?>
<?php require_once('views/header.php') ?>
<!-- Content Starts Here -->

<h1>Vend�gk�nyv</h1>

<?php $guestbook->LoadPosts(); ?>

<!-- total=<?php echo $guestbook->CountEntries(); ?>-->
<!-- pages=<?php echo $guestbook->lastPage; ?>-->

<?php if($guestbook->feedback == '')  { ?>

<p>Oldalak:
<?php for($i = $guestbook->lastPage; $i>=1; $i--) { ?>
<?php if ($i == $guestbook->page) { ?>
 <strong><?php echo $i ?></strong>
<?php }  else {?>
 <a href="vendegkonyv.php?oldal=<?php echo $i ?>"><?php echo $i ?></a>
<?php } ?>
<?php } ?>
</p>

<?php foreach($guestbook->item as $entry) { ?>

<div style="width: 100%; background-color: #eaeaea; margin-top: 20px;">
  <h2 style="width: 100%; background-color: #fa4802; color: #ffffff; margin-top: 0px;">#<?php echo $guestbook->postNumberToShow ?>: <?php echo $entry['title'] ?></h2>
  <p style="padding-left:10px"><strong><?php echo $entry['author_nick'] ?></strong> <?php echo $entry['author_logged_in'] ? '(regisztr�lt tag)' : '(vend�g)' ?> �rta, <?php echo $entry['created'] ?>-kor:</p>
  <div style="padding-left: 20px; padding-right: 20px;">
    <?php echo nl2br($entry['body']) ?>
  </div>
  <?php if($entry['answer_body'] != '')  { ?>
  <p style="padding-left:10px"><strong>CBA Fitness</strong> v�lasza:</p>
  <div style="padding-left: 20px; padding-right: 20px;">
    <?php echo nl2br($entry['answer_body']) ?>
  </div>
  <?php } ?>
  <br /><br />
</div>

<?php $guestbook->postNumberToShow-- ?>

<?php } ?>


<p>Oldalak:
<?php for($i = $guestbook->lastPage; $i>=1; $i--) { ?>
<?php if ($i == $guestbook->page) { ?>
 <strong><?php echo $i ?></strong>
<?php }  else {?>
 <a href="vendegkonyv.php?oldal=<?php echo $i ?>"><?php echo $i ?></a>
<?php } ?>
<?php } ?>
</p>


<?php } ?>



<h2>�rd meg te is a v�lem�nyed, k�rd�sed!</h2>

<?php if($guestbook->feedback != '') { ?>

<p style="border: 1px solid red; padding: 10px;"><strong><?php echo $guestbook->feedback; ?></strong></p>

<?php } ?>

<?php if(!$guestbook->saved) { ?>

<p>Az al�bbi adatlapot kit�ltve elk�ldheted v�lem�nyed, k�rd�sed a CBA Fitness munkat�rsaihoz. A spamek �s m�s k�retlen �zenetek kisz�r�se �rdek�ben <strong>�zeneted csak azut�n fog megjelenni a honlapon, hogy munkat�rsunk ellen�rizte �s megv�laszolta azt</strong>.</p>

<?php if(!$session->logged_in) { ?>
<p>Az <strong>email c�m</strong> megad�sa nem k�telez�. Azonban ha megadod, munkat�rsaink akkor is tudnak emailben v�laszolni a hozz�sz�l�sodra, ha az v�g�l a vend�gk�nyvbe nem ker�l ki. Az email c�m <strong>nem jelenik meg</strong> nyilv�nosan az oldalon!</p>
<?php } ?>

<form name="guestbookForm" method="post" action="<?php echo $guestbook->GetFormURL() ?>">

<input id="formId" name="formId" type="hidden" value="GUESTBOOK:POST" />

<div style="text-align: center; ">
<table style="width: 70%; margin-left: auto; margin-right: auto; ">
<tr>
  <th class="title" colspan="2">�j hozz�sz�l�s</th>
</tr>
<tr>
  <th>Ez legyen a c�me:</th>
  <td><input style="width:360px;" name="gb_title" type="text" value="<?php echo trim(htmlspecialchars($_POST['gb_title'])) ?>" /></td>
</tr>
<tr>
  <th>Ez az �n nevem:</th>
  <td>
    <?php if($session->logged_in) { ?>
    <strong><?php echo $session->user['nick']; ?></strong>
    <?php } else { ?>
    <input style="width:170px;" name="gb_author_nick" type="text" value="<?php echo trim(htmlspecialchars($_POST['gb_author_nick'])) ?>" /> <span style="font-size: 9px;">Ha regisztr�lt tag vagy, <a href="felhasznalo.php">jelentkezz be</a>!</span>
    <?php } ?>
  </td>
</tr>
<?php if(!$session->logged_in) { ?>
<tr>
  <th>Email c�mem:</th>
  <td><input style="width:360px;" name="gb_author_email" type="text" value="<?php echo trim(htmlspecialchars($_POST['gb_author_email'])) ?>" /></td>
</tr>
<?php } ?>
<tr>
  <th>Ezt szeretn�m mondani:</th>
  <td>
    <textarea style="width:360px; height: 215px;" name="gb_body"><?php echo trim(htmlspecialchars($_POST['gb_body'])) ?></textarea>
  </td>
</tr>
</table>

<br /><br />

<input type="submit" value="Hozz�sz�l�s elk�ld�se" />

</div>

</form>

<?php } else { ?>

<p>K�sz�nj�k a hozz�sz�l�st! Munkat�rsaink hamarosan ellen�rzik a hozz�sz�l�st, �s ha rendben tal�lj�k, v�lasszal egy�tt beker�l a vend�gk�nyvbe.</p>

<p><a href="<?php echo $_SERVER['PHP_SELF'] ?>">Vissza a vend�gk�nyvh�z</a></p>

<?php } ?>

<br /><br />

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>
