<?php define('BW_NOSTAT', 1); ?>
<?php require_once('inc/boot.php') ?>
<?php $CBA_SECTION = 'admin'; ?>
<?php require_once('inc/bwGuestbook.php') ?>
<?php require_once('views/admHeader.php') ?>
<!-- Content Starts Here -->
<?php if($session->GetUserLevel() >= bwSession::MODERATOR) { ?>

<?php $guestbook->LoadPosts(1); ?>

<?php if($guestbook->id == 0) { ?>

<h1>Vend�gk�nyv adminisztr�ci�</h1>

<?php if($session->GetUserLevel() >= bwSession::SUPER_MODERATOR) { ?>

<p><strong>�j, tiltott, �s publik�lt bejegyz�sek</strong> | <a href="vendegkonyv3.php">T�r�lt vend�gk�nyvbejegyz�sek</a></p>

<?php } ?>

<p>A k�vetkez� t�bl�zat a vend�gk�nyv bejegyz�seket tartalmazza, a t�bl�zat elej�n a m�g megv�laszolatlan (<strong>�j</strong>) bejegyz�sekkel.</p>

<?php $status = array(0 => '<strong>�j</strong>', 'tiltott', 'publik�lt') ?>

<div style="text-align: center; ">
<table style="width: 70%; margin-left: auto; margin-right: auto; ">
  <tr>
    <th>C�m</th>
    <th>Felad�</th>
    <th>D�tum</th>
    <th>St�tusz</th>
  </tr>
  <?php foreach($guestbook->item as $entry) { ?>
  <tr>
    <td><a href="<?php echo $guestbook->GetFormURL($entry['id']); ?>"><?php echo $entry['title'] ?></a></td>
    <td><?php echo $entry['author_nick'] ?></td>
    <td><?php echo $entry['created'] ?></td>
    <td><?php echo $status[$entry['status']] ?></td>
  </tr>
  <?php } ?>
</table>
</div>

&nbsp; &nbsp;

<?php } else { ?>

<h1>Vend�gk�nyv bejegyz�s</h1>

<p><a href="<?php echo $_SERVER['PHP_SELF'] ?>">Vissza a szerkeszt� f�oldal�ra</a></p>

<?php if($guestbook->feedback != '') { ?>


<p style="border: 1px solid red; padding: 10px;"><strong><?php echo $guestbook->feedback; ?></strong></p>

<?php } ?>

<?php if(!$guestbook->saved) { ?>

<div style="width: 100%; background-color: #eaeaea; margin-top: 20px;">
  <h2 style="width: 100%; background-color: #fa4802; color: #ffffff; margin-top: 0px;"><?php echo $guestbook->item[0]['title'] ?></h2>
  <p style="padding-left:10px"><strong><?php echo $guestbook->item[0]['author_nick'] ?></strong> <?php echo $guestbook->item[0]['author_logged_in'] ? '(regisztr�lt tag)' : '(vend�g)' ?> �rta, <?php echo $guestbook->item[0]['created'] ?>-kor:</p>
  <div style="padding-left: 20px; padding-right: 20px;">
    <?php echo nl2br($guestbook->item[0]['body']) ?>
  </div>
  <br /><br />
</div>

<?php $status = array(0 => '�j', 'tiltott', 'publik�lt') ?>

<form name="guestbookForm" method="post" action="<?php echo $guestbook->GetFormURL() ?>">

<input id="formId" name="formId" type="hidden" value="GUESTBOOK:UPDATE" />

<div style="text-align: center; ">
<table style="width: 70%; margin-left: auto; margin-right: auto; ">
<tr>
  <th class="title" colspan="2">V�lasz</th>
</tr>
<tr>
  <th>Hozz�sz�l�s st�tusta:</th>
  <td>
    <input name="gb_status" type="radio" value="0" <?php echo ($guestbook->item[0]['status'] == 0) ? "checked=\"checked\"" : "" ?> /> �j (nem l�that�)
    <input name="gb_status" type="radio" value="1" <?php echo ($guestbook->item[0]['status'] == 1) ? "checked=\"checked\"" : "" ?> /> Tiltott (nem l�that�)
    <input name="gb_status" type="radio" value="2" <?php echo ($guestbook->item[0]['status'] == 2) ? "checked=\"checked\"" : "" ?> /> Publikus (l�that�)
  </td>
</tr>
<tr>
  <th>V�lasz sz�vege:</th>
  <td>
    <textarea style="width:360px; height: 215px;" name="gb_answer_body"><?php echo $guestbook->item[0]['answer_body'] ?></textarea>
  </td>
</tr>
</table>

<br /><br />

<input type="submit" value="V�ltoztat�sok ment�se" />

</form>

<?php //if($session->GetUserLevel() >= bwSession::SUPER_MODERATOR) { ?>
<?php if (true) { ?>

<form name="guestbookForm" method="post" action="<?php echo $guestbook->GetFormURL() ?>">

<input id="formId" name="formId" type="hidden" value="GUESTBOOK:SENDEMAIL" />


<table style="width: 70%; margin-left: auto; margin-right: auto; ">
<tr>
  <th class="title">V�lasz emailben</th>
</tr>
<tr>
  <td>
  <?php if($guestbook->item[0]['author_email'] != '') { ?>
  	<p>Az al�bbi �rlap kit�lt�s�vel emailben k�ldhet v�laszt a bejegyz�s �r�j�nak. A levelet a rendszer a(z)  <strong><?php echo $guestbook->GetEmailSenderName(); ?> &lt;<?php echo $guestbook->GetEmailSenderAddress(); ?>&gt;</strong> emailc�mr�l fogja k�ldeni. A bejegyz�s �r�j�nak esetleges tov�bbi v�lasza erre az emailc�mre fog �rkezni, k�rem ellen�rizze majd a postafi�kot.</p>
    <p>Az �zenet c�me <strong><?php echo $guestbook->GetEmailSubject(); ?></strong> lesz.</p>
    <textarea style="width:510px; height: 215px;" name="gb_email_body"><?php echo $guestbook->GetEmailBody(); ?></textarea>
  <?php } else { ?>
    A felhaszn�l� nem adott meg emailc�met.
  <?php } ?>
  </td>
</tr>
</table>

<?php if($guestbook->item[0]['author_email'] != '') { ?>
<input type="submit" value="Email elk�d�se" />
<?php } ?>

</form>

<?php } else { ?>

<table style="width: 70%; margin-left: auto; margin-right: auto; ">
<tr>
  <th class="title">V�lasz emailben</th>
</tr>
<tr>
  <td>
  <?php if($guestbook->item[0]['author_email'] != '') { ?>
  	Az email-k�ld� funkci� haszn�lat�ra jelenleg technikai okokb�l nincs lehet�s�g. A funkci� n�h�ny �r�n bel�l v�rhat�an helyre�ll. Meg�rt�s�t k�sz�nj�k.
  <?php } else { ?>
    A felhaszn�l� nem adott meg emailc�met.
  <?php } ?>
  </td>
</tr>
</table>

<?php } ?>

</div>


<br /><br />

<h2>Hozz�sz�l�s t�rl�se</h2>

<form name="guestbookForm" method="post" action="<?php echo $guestbook->GetFormURL() ?>">

<p>Ha a fenti hozz�sz�l�st v�glegesen t�r�lni szeretn�d, kattints az al�bbi gombra.</p>

<input id="formId" name="formId" type="hidden" value="GUESTBOOK:DELETE" />

<div style="text-align: center; ">
<input type="submit" value="T�rl�s" />
</div>

</form>

<?php if($session->GetUserLevel() >= bwSession::SUPER_MODERATOR) { ?>

<?php $modEvents = $guestbook->GetEventLogForItem($guestbook->id); ?>

<br /><br />

<h2>A bejegyz�s moder�ci�j�nak t�rt�nete</h2>

<?php if ($_GET['reszletes']) { ?>
<?php $reszletes = true; ?>
<p><a href="vendegkonyv2.php?bejegyzes=<?php echo $guestbook->id ?>">Kompakt lista</a> | <strong>R�szletes lista</strong></p>
<?php } else { ?>
<?php $reszletes = false; ?>
<p><strong>Kompakt lista</strong> | <a href="vendegkonyv2.php?bejegyzes=<?php echo $guestbook->id ?>&amp;reszletes=1">R�szletes lista</a></p>
<?php } ?>

<?php $status = array(0 => '�j', 'tiltott', 'publik�lt'); ?>

<table>
  <tr>
  	<th>Moder�tor</th>
  	<th>M�velet</th>
  	<th>Moder�ci� id�pontja</th>
  </tr>
  <?php foreach($modEvents as $item) { ?>
  <tr>
  	<td<?php if ($reszletes && (($item['type'] == 1) || ($item['type'] == 2))) echo " rowspan=\"2\"" ?>><?php echo $item['nick'] ?></td>
  	<td><?php echo $item['type_text'] ?></td>
 	<td><?php echo $item['created'] ?></td>
  </tr>
  <?php if ($reszletes && ($item['type'] == 1)) { ?>
  <tr>
  	<td style="background-color: #f7f7f7;" colspan="2">
        <em>St�tusz: <?php echo $status[$item['status']]; ?></em><br />
		<?php echo $item['body']; ?>
    </td>
  </tr>
  <?php } else if ($reszletes && ($item['type'] == 2)) { ?>
  <tr>
  	<td style="background-color: #f7f7f7;" colspan="2">
		<?php echo $item['body']; ?>
    </td>
  </tr>
  <?php } ?>
  <?php } ?>
</table>

<?php } ?>


<?php } ?>


<?php } ?>

<?php } else { define('UNAUTHORIZED', 1); } ?>

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>
