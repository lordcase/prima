<?php define('BW_NOSTAT', 1); ?>
<?php require_once('inc/boot.php') ?>
<?php $CBA_SECTION = 'admin'; ?>
<?php require_once('inc/bwArticle.php') ?>
<?php require_once('inc/fckeditor/fckeditor.php') ?>
<?php require_once('views/admHeader.php') ?>
<!-- Content Starts Here -->
<?php if($session->GetUserLevel() >= bwSession::EDITOR) { ?>

<?php

$validTitles = array('orarend', 'fitness');
$validTitleNames = array('orarend' => '�rarendhez tartoz� cikk', 'fitness' => 'Fitnesshez tartoz� cikk');

if(isset($_GET['cikk']) && (in_array($_GET['cikk'], $validTitles)))
{
	$cikkTitle = $_GET['cikk'];
}
else
{
	$cikkTitle = $validTitles[0];
}


if(isset($_GET['sz']) && ($_GET['sz'] == 'szerkeszt'))
{
	$cikkSection = 'SZERKESZT';
}
else
{
	$cikkSection = 'MEGJELENIT';
}

$cikkMessage = '';


if(isset($_POST['formId']))
{
  switch($_POST['formId'])
  {
	case 'ARTICLE:UPDATE':
	  if ($article->Set($cikkTitle, $_POST['article_body']))
	  {
		$cikkSection = 'MEGJELENIT';
		$cikkMessage = 'Cikk m�dos�t�sa sikeresen v�grehajtva.';
	  }
	  else
	  {
		$cikkSection = 'SZERKESZT';
		$cikkMessage = 'Cikk m�dos�t�sa sor�n nem v�rt hiba l�pett fel.';
	  }
	break;
	case 'ARTICLE:PUBLISH':
		$article->Show($cikkTitle);
	break;
	case 'ARTICLE:HIDE':
		$article->Hide($cikkTitle);
	break;
  }
  
}

if (!$article->Exists($cikkTitle))
{
	$article->Set($cikkTitle, '');
	$article->Hide($cikkTitle);
}

$item = $article->Get($cikkTitle);

?>

<h1>Cikkszerkeszt�s</h1>

<?php
if ($cikkMessage != '') echo "<p><strong>" . $cikkMessage . "</strong></p>\n";
?>


<?php

if ($cikkSection == 'SZERKESZT')
{
?>

<h2><?php echo $validTitleNames[$cikkTitle]; ?></h2>

<form action="cikkadmin.php?cikk=<?php echo $cikkTitle ?>&amp;sz=szerkeszt" method="post">
<input type="hidden" name="formId" value="ARTICLE:UPDATE" />

<?php
	$oFCKeditor = new FCKeditor('article_body') ;
	$oFCKeditor->BasePath = 'inc/fckeditor/' ;
	$oFCKeditor->ToolbarSet = 'CBA' ;
	$oFCKeditor->Value = isset($_POST['article_body']) ? $_POST['article_body'] : $item['body'] ;
	$oFCKeditor->Create();
?>
<p><input type="submit" value="Elk�ld"  /> <a href="cikkadmin.php?cikk=<?php echo $cikkTitle ?>">m�gsem</a></p>
<?php
} else {
?>

<p>
	<a href="orarend2.php">Vissza az �rarendhez</a>
<?php
 foreach ($validTitles as $titleId => $titleName)
 {
 	if($titleName != $cikkTitle)
	{
		echo " | <a href=\"cikkadmin.php?cikk=" . $titleName . "\">" . $validTitleNames[$titleName] . "</a>";
	}
	else
	{
		echo " | " . "<strong>" . $validTitleNames[$titleName] . "</strong>";
	}
	
 }
?>
</p>


<h2><?php echo $validTitleNames[$cikkTitle]; ?></h2>
<table style="width: 720px; ">
<tr>
<td><?php echo $item['body']; ?></td>
</tr>
</table>

<p><a href="cikkadmin.php?cikk=<?php echo $cikkTitle ?>&amp;sz=szerkeszt">Cikk szerkeszt�se</a></p>

<form action="cikkadmin.php?cikk=<?php echo $cikkTitle ?>" method="post">

<?php if (!$article->IsVisible($cikkTitle)) { ?>
<p>A cikk st�tusza jelenleg <strong>rejtett</strong>.</p>
<input type="hidden" name="formId" value="ARTICLE:PUBLISH" />
<input type="submit" value="Publik�l�s" />
<?php } else { ?>
<p>A cikk st�tusza jelenleg <strong>publik�lt</strong>.</p>
<input type="hidden" name="formId" value="ARTICLE:HIDE" />
<input type="submit" value="Elrejt�s" />
<?php } ?>

<?php
}
?>


<br /><br />


<?php } else { define('UNAUTHORIZED', 1); } ?>

<!-- Content Ends Here -->
<?php require_once('views/footer.php') ?>
