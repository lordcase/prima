<?php define('BW_NOSTAT', 1); ?>
<?php require_once('inc/boot.php') ?>
<?php $CBA_SECTION = 'admin'; ?>
<?php require_once('inc/bwGuestbook.php') ?>
<?php require_once('views/admHeader.php') ?>
<!-- Content Starts Here -->
<?php if($session->GetUserLevel() >= bwSession::MODERATOR) { ?>

<?php $guestbook->LoadPosts(1); ?>

<?php if($guestbook->id == 0) { ?>

<h1>Vendégkönyv adminisztráció</h1>

<?php if($session->GetUserLevel() >= bwSession::SUPER_MODERATOR) { ?>

<p><strong>Új, tiltott, és publikált bejegyzések</strong> | <a href="vendegkonyv3.php">Törölt vendégkönyvbejegyzések</a></p>

<?php } ?>

<p>A következõ táblázat a vendégkönyv bejegyzéseket tartalmazza, a táblázat elején a még megválaszolatlan (<strong>új</strong>) bejegyzésekkel.</p>

<?php $status = array(0 => '<strong>új</strong>', 'tiltott', 'publikált') ?>

<div style="text-align: center; ">
<table style="width: 70%; margin-left: auto; margin-right: auto; ">
  <tr>
    <th>Cím</th>
    <th>Feladó</th>
    <th>Dátum</th>
    <th>Státusz</th>
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

<h1>Vendégkönyv bejegyzés</h1>

<p><a href="<?php echo $_SERVER['PHP_SELF'] ?>">Vissza a szerkesztõ fõoldalára</a></p>

<?php if($guestbook->feedback != '') { ?>


<p style="border: 1px solid red; padding: 10px;"><strong><?php echo $guestbook->feedback; ?></strong></p>

<?php } ?>

<?php if(!$guestbook->saved) { ?>

<div style="width: 100%; background-color: #eaeaea; margin-top: 20px;">
  <h2 style="width: 100%; background-color: #fa4802; color: #ffffff; margin-top: 0px;"><?php echo $guestbook->item[0]['title'] ?></h2>
  <p style="padding-left:10px"><strong><?php echo $guestbook->item[0]['author_nick'] ?></strong> <?php echo $guestbook->item[0]['author_logged_in'] ? '(regisztrált tag)' : '(vendég)' ?> írta, <?php echo $guestbook->item[0]['created'] ?>-kor:</p>
  <div style="padding-left: 20px; padding-right: 20px;">
    <?php echo nl2br($guestbook->item[0]['body']) ?>
  </div>
  <br /><br />
</div>

<?php $status = array(0 => 'új', 'tiltott', 'publikált') ?>

<form name="guestbookForm" method="post" action="<?php echo $guestbook->GetFormURL() ?>">

<input id="formId" name="formId" type="hidden" value="GUESTBOOK:UPDATE" />

<div style="text-align: center; ">
<table style="width: 70%; margin-left: auto; margin-right: auto; ">
<tr>
  <th class="title" colspan="2">Válasz</th>
</tr>
<tr>
  <th>Hozzászólás státusta:</th>
  <td>
    <input name="gb_status" type="radio" value="0" <?php echo ($guestbook->item[0]['status'] == 0) ? "checked=\"checked\"" : "" ?> /> Új (nem látható)
    <input name="gb_status" type="radio" value="1" <?php echo ($guestbook->item[0]['status'] == 1) ? "checked=\"checked\"" : "" ?> /> Tiltott (nem látható)
    <input name="gb_status" type="radio" value="2" <?php echo ($guestbook->item[0]['status'] == 2) ? "checked=\"checked\"" : "" ?> /> Publikus (látható)
  </td>
</tr>
<tr>
  <th>Válasz szövege:</th>
  <td>
    <textarea style="width:360px; height: 215px;" name="gb_answer_body"><?php echo $guestbook->item[0]['answer_body'] ?></textarea>
  </td>
</tr>
</table>

<br /><br />

<input type="submit" value="Változtatások mentése" />

</form>

<?php //if($session->GetUserLevel() >= bwSession::SUPER_MODERATOR) { ?>
<?php if (true) { ?>

<form name="guestbookForm" method="post" action="<?php echo $guestbook->GetFormURL() ?>">

<input id="formId" name="formId" type="hidden" value="GUESTBOOK:SENDEMAIL" />


<table style="width: 70%; margin-left: auto; margin-right: auto; ">
<tr>
  <th class="title">Válasz emailben</th>
</tr>
<tr>
  <td>
  <?php if($guestbook->item[0]['author_email'] != '') { ?>
  	<p>Az alábbi ûrlap kitöltésével emailben küldhet választ a bejegyzés írójának. A levelet a rendszer a(z)  <strong><?php echo $guestbook->GetEmailSenderName(); ?> &lt;<?php echo $guestbook->GetEmailSenderAddress(); ?>&gt;</strong> emailcímrõl fogja küldeni. A bejegyzés írójának esetleges további válasza erre az emailcímre fog érkezni, kérem ellenõrizze majd a postafiókot.</p>
    <p>Az üzenet címe <strong><?php echo $guestbook->GetEmailSubject(); ?></strong> lesz.</p>
    <textarea style="width:510px; height: 215px;" name="gb_email_body"><?php echo $guestbook->GetEmailBody(); ?></textarea>
  <?php } else { ?>
    A felhasználó nem adott meg emailcímet.
  <?php } ?>
  </td>
</tr>
</table>

<?php if($guestbook->item[0]['author_email'] != '') { ?>
<input type="submit" value="Email elküdése" />
<?php } ?>

</form>

<?php } else { ?>

<table style="width: 70%; margin-left: auto; margin-right: auto; ">
<tr>
  <th class="title">Válasz emailben</th>
</tr>
<tr>
  <td>
  <?php if($guestbook->item[0]['author_email'] != '') { ?>
  	Az email-küldõ funkció használatára jelenleg technikai okokból nincs lehetõség. A funkció néhány órán belül várhatóan helyreáll. Megértését köszönjük.
  <?php } else { ?>
    A felhasználó nem adott meg emailcímet.
  <?php } ?>
  </td>
</tr>
</table>

<?php } ?>

</div>


<br /><br />

<h2>Hozzászólás törlése</h2>

<form name="guestbookForm" method="post" action="<?php echo $guestbook->GetFormURL() ?>">

<p>Ha a fenti hozzászólást véglegesen törölni szeretnéd, kattints az alábbi gombra.</p>

<input id="formId" name="formId" type="hidden" value="GUESTBOOK:DELETE" />

<div style="text-align: center; ">
<input type="submit" value="Törlés" />
</div>

</form>

<?php if($session->GetUserLevel() >= bwSession::SUPER_MODERATOR) { ?>

<?php $modEvents = $guestbook->GetEventLogForItem($guestbook->id); ?>

<br /><br />

<h2>A bejegyzés moderációjának története</h2>

<?php if ($_GET['reszletes']) { ?>
<?php $reszletes = true; ?>
<p><a href="vendegkonyv2.php?bejegyzes=<?php echo $guestbook->id ?>">Kompakt lista</a> | <strong>Részletes lista</strong></p>
<?php } else { ?>
<?php $reszletes = false; ?>
<p><strong>Kompakt lista</strong> | <a href="vendegkonyv2.php?bejegyzes=<?php echo $guestbook->id ?>&amp;reszletes=1">Részletes lista</a></p>
<?php } ?>

<?php $status = array(0 => 'új', 'tiltott', 'publikált'); ?>

<table>
  <tr>
  	<th>Moderátor</th>
  	<th>Mûvelet</th>
  	<th>Moderáció idõpontja</th>
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
        <em>Státusz: <?php echo $status[$item['status']]; ?></em><br />
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
