<?php define('BW_NOSTAT', 1); ?>
<?php require_once('inc/boot.php') ?>
<?php $CBA_SECTION = 'admin'; ?>
<?php require_once('inc/bwGuestbook.php') ?>
<?php require_once('views/admHeader.php') ?>
<!-- Content Starts Here -->
<?php if($session->GetUserLevel() >= bwSession::SUPER_MODERATOR) { ?>

<?php $guestbook->LoadPosts(1, 3); ?>

<?php if($guestbook->id == 0) { ?>

<h1>Vend�gk�nyv adminisztr�ci�</h1>

<p><a href="vendegkonyv2.php">�j, tiltott �s publik�lt bejegyz�sek</a> | <strong>T�r�lt vend�gk�nyvbejegyz�sek</strong></p>

<p>A k�vetkez� t�bl�zat a vend�gk�nyvb�l t�r�lt bejegyz�seket tartalmazza.</p>

<div style="text-align: center; ">
<table style="width: 70%; margin-left: auto; margin-right: auto; ">
  <tr>
    <th>C�m</th>
    <th>Felad�</th>
    <th>D�tum</th>
  </tr>
  <?php foreach($guestbook->item as $entry) { ?>
  <tr>
    <td><a href="<?php echo $guestbook->GetFormURL($entry['id']); ?>"><?php echo $entry['title'] ?></a></td>
    <td><?php echo $entry['author_nick'] ?></td>
    <td><?php echo $entry['created'] ?></td>
  </tr>
  <?php } ?>
</table>
</div>

&nbsp; &nbsp;

&nbsp; &nbsp;

<?php } else { ?>

<h1>T�r�lt vend�gk�nyv bejegyz�s</h1>

<p><a href="<?php echo $_SERVER['PHP_SELF'] ?>">Vissza a t�r�lt bejegyz�sek list�j�hoz</a></p>

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
  <p style="padding-left:10px"><strong>Utolj�ra mentett</strong> moder�tori v�lasz:</p>
  <div style="padding-left: 20px; padding-right: 20px;">
    <?php echo nl2br($guestbook->item[0]['answer_body']) ?>
  </div>
  <br /><br />
</div>

<br /><br />

<h2>T�r�lt hozz�sz�l�s vissza�ll�t�sa</h2>

<form name="guestbookForm" method="post" action="<?php echo $guestbook->GetFormURL() ?>">

<p>Ha a fenti hozz�sz�l�st szeretn�d vissza�ll�tani ("tiltott" st�tuszba fog ker�lni), nyomd meg az al�bbi gombot.</p>

<input id="formId" name="formId" type="hidden" value="GUESTBOOK:UNDELETE" />

<div style="text-align: center; ">
<input type="submit" value="Vissza�ll�t�s" />
</div>

</form>

<?php $modEvents = $guestbook->GetEventLogForItem($guestbook->id); ?>

<br /><br />

<h2>A bejegyz�s moder�ci�j�nak t�rt�nete</h2>

<?php if ($_GET['reszletes']) { ?>
<?php $reszletes = true; ?>
<p><a href="vendegkonyv3.php?bejegyzes=<?php echo $guestbook->id ?>">Kompakt lista</a> | <strong>R�szletes lista</strong></p>
<?php } else { ?>
<?php $reszletes = false; ?>
<p><strong>Kompakt lista</strong> | <a href="vendegkonyv3.php?bejegyzes=<?php echo $guestbook->id ?>&amp;reszletes=1">R�szletes lista</a></p>
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


<?php } else { define('UNAUTHORIZED', 1); } ?>

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>
