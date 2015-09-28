<?php define('BW_NOSTAT', 1); ?>
<?php require_once('inc/boot.php') ?>
<?php $CBA_SECTION = 'admin'; ?>
<?php require_once('inc/bwUser.php') ?>
<?php require_once('views/admHeader.php') ?>
<!-- Content Starts Here -->

<?php if($session->GetUserLevel() >= bwSession::EDITOR) { ?>

<h1>Regisztrált felhasználók</h1>


<p>Oldalak: <?php for($i = 1; $i <= $user->lastPage; $i++) echo "<a href=\"" . $user->GetFormURL($i) . "\">$i</a>" ?></p>

<table>
<tr>
  <th><a href="<?php echo $user->GetFormURL(false, 'nick') ?>">Felhasználói név</a></th>
  <?php if($session->GetUserLevel() >= bwSession::SUPER_MODERATOR) { ?>
  <th><a href="<?php echo $user->GetFormURL(false, 'email') ?>">Email</a></th>
  <?php } ?>
  <th><a href="<?php echo $user->GetFormURL(false, 'subscription') ?>">Hírlevet kér</a></th>
  <th><a href="<?php echo $user->GetFormURL(false, 'level') ?>">Szint</a></th>
  <?php if($session->GetUserLevel() >= bwSession::ADMIN) { ?>
  <th>Titkos kód</th>
  <?php } ?>
  <th><a href="<?php echo $user->GetFormURL(false, 'created') ?>">Regisztrált</a></th>
  <th><a href="<?php echo $user->GetFormURL(false, 'last_login') ?>">Legutóbb belépett</a></th>
</tr>
<?php foreach($user->item as $item) { ?>

<tr>
  <td><?php echo $item['nick'] ?></td>
  <?php if($session->GetUserLevel() >= bwSession::SUPER_MODERATOR) { ?>
  <td><a href="mailto:<?php echo $item['email'] ?>"><?php echo $item['email'] ?></a></td>
  <?php } ?>
  <td><?php echo $item['subscription'] ? '<strong>igen</strong>' : 'nem' ?></td>
  <td><?php echo $item['level_text'] ?></td>
  <?php if($session->GetUserLevel() >= bwSession::ADMIN) { ?>
  <td><?php echo $item['secret_code'] ?> (<a href="naplo_user.php?felhasznalo=<?php echo $item['id'] ?>">log</a>)</td>
  <?php } ?>
  <td><?php echo $item['created'] ?></td>
  <td><?php echo $item['last_login'] ?></td>
</tr>

<?php } ?>
</table>

<?php } ?>

<br /><br />

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>
