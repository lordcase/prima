<?php 
    /**
    * @desc P�lda olyan eredm�ny oldalra, melyre a k�tszereplos
    * fizet�s sikeres v�grehajt�sa ut�n t�rt�nik a vez�rl�s�tad�s
    * PHP k�dbeli include / require utas�t�ssal.
    * 
    * Az �llom�nyt a p�ld�nkban a fiz2_control.php include-olja,
    * a ketszereplosshop.conf f�jl megfelelo konfigur�l�sa eset�n.
    * Ilyenkor k�t global l�that�s�g� PHP objektum v�ltoz� �ll
    * rendelkez�sre, mely tartalmazza a fizet�s �sszes v�laszadat�t:
    * - tranzAdatok: WebShopFizetesValasz t�pus� objektum, a 
    *   v�s�rl�shoz tartoz� v�laszobjektum (value object)
    * 
    * Megjegyz�s: a fizet�si tranzakci� eredm�nye (tranzAdatok) a 
    * Tranzakci�  lek�rdez�s funkci� megh�v�s�val ker�l lek�rdez�sre.
    * A v�lasz feldolgoz�s�t eszerint kell elv�gezni: a v�s�sl�s
    * akkor sikeres, ha a POS v�laszk�d 000-010 k�zti �rt�k,
    * �s az authoriz�ci�s k�d nem �res.
    */

    if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../lib');
    require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/ErrorMessages.php');

// ********* BEGIN CBA CODE *************

require_once('inc/boot.php');
require_once('inc/bwRemoteServices2.php');
require_once('inc/bwTranzakcio.php');
$CBA_SECTION = 'aerobic';
require_once('views/header.php');

global $tranzAdatok;
	
if (is_null($tranzAdatok))
{
	//A tranzakci� nem hajt�dott v�gre, a banki v�lasz v�lasz nem �rheto el vagy nem �rtelmezheto.
	$bankStatus = 'ERROR';
}
else if ($tranzAdatok->isSuccessful())
{
	if ($tranzAdatok->isCsakRegisztracio()) {
		// sikeres regisztr�l�s
		$bankStatus = 'REGISTERED';
	} else {
		// sikeres v�s�rl�s
		$bankStatus = 'SUCCESS';
	}
}
else
{
	$bankStatus = 'FAILURE';
}

if (($bankStatus == 'SUCCESS') || ($bankStatus == 'REGISTERED'))
{
	$tranz = array(
		'azonosito' =>				substr($tranzAdatok->getAzonosito(), 6),
		'shop_id' =>				$tranzAdatok->getPosId(),
		'statuskod' =>				$tranzAdatok->getStatuszKod(),
		'valaszkod' =>				$tranzAdatok->getPosValaszkod(),
		'valaszszoveg' =>			is_null(getMessageText($tranzAdatok->getPosValaszkod())) ? '' : getMessageText($tranzAdatok->getPosValaszkod()),
		'teljesites_idopontja' =>	$tranzAdatok->getTeljesites()
	);
}

if ($bankStatus == 'SUCCESS')
{
	$tranz['autorizacios_kod'] = $tranzAdatok->getAuthorizaciosKod();
}
else
{
	$tranz['autorizacios_kod'] = '';
}

if (($bankStatus == 'SUCCESS') || ($bankStatus == 'FAILURE'))
{
	$tranz['nev'] 			= ($tranzAdatok->isNevKell() 			&& ($tranzAdatok->getNev() != null)) 			? $tranzAdatok->getNev() : '';
	$tranz['orszag'] 		= ($tranzAdatok->isOrszagKell() 		&& ($tranzAdatok->getOrszag() != null)) 		? $tranzAdatok->getOrszag() : '';
	$tranz['megye'] 		= ($tranzAdatok->isMegyeKell() 			&& ($tranzAdatok->getMegye() != null)) 			? $tranzAdatok->getMegye() : '';
	$tranz['telepules'] 	= ($tranzAdatok->isTelepulesKell()		&& ($tranzAdatok->getVaros() != null)) 			? $tranzAdatok->getVaros() : '';
	$tranz['utca_hazszam'] 	= ($tranzAdatok->isUtcaHazszamKell()	&& ($tranzAdatok->getUtcaHazszam() != null))	? $tranzAdatok->getUtcaHazszam() : '';
	$tranz['iranyitoszam'] 	= ($tranzAdatok->isIranyitoszamKell()	&& ($tranzAdatok->getIranyitoszam() != null)) 	? $tranzAdatok->getIranyitoszam() : '';
	$tranz['kozlemeny'] 	= ($tranzAdatok->isKozlemenyKell()		&& ($tranzAdatok->getKozlemeny() != null)) 		? $tranzAdatok->getKozlemeny() : '';
}

if ($bankStatus == 'ERROR')
{
	$tranz = array(
		'azonosito'	=> $_REQUEST['tranzakcioAzonosito'],
		'shop_id'	=> $_REQUEST['posId']
	);
}

switch ($bankStatus)
{
	case 'SUCCESS':
		$log->LogVasarlasBankiValasz($tranz['azonosito'], 0, 1);
	break;
	case 'FAILURE':
	case 'ERROR':
	default:
		$log->LogVasarlasBankiValasz($tranz['azonosito'], 0, 0);
	break;
}

if ($bankStatus == 'SUCCESS')
{
	$vasarlasAdatok = $tranzakcio->Folytat($tranz['azonosito']);
	
	if ($vasarlasAdatok)
	{
		$remote->Process();
		
		$nettoAr = $vasarlasAdatok['price'] / 1.27;
		$bruttoAr = $vasarlasAdatok['price'];
		
		$vevo = array(
			'nev'			=> $tranz['nev'],
			'cim'			=> $tranz['utca_hazszam'],
			'varos' 		=> $tranz['telepules'],
			'iranyitoszam'	=> $tranz['iranyitoszam']
		);
		
		if ($remote->DoVasarlas($vasarlasAdatok['product_id'], $vasarlasAdatok['id'], $vasarlasAdatok['start_date'], $nettoAr, $bruttoAr, $vevo))
		{
			$tranzakcio->Befejez($tranz['azonosito']);
			$remote->SendVasarlasEmail($vevo, $vasarlasAdatok);
			$shopStatus = 'SUCCESS';
		}
		else
		{
			$shopStatus = 'FAILURE';
		}
	}
	else
	{
		$shopStatus = 'FAILURE';
	}
}
else
{
	$shopStatus = 'CANCELLED';
}


$trLabels = array(
	'azonosito' 			=> 'Tranzakci� azonos�t�ja',
	'shop_id' 				=> 'Bolt azonos�t�ja',
	'statuskod' 			=> 'St�tuszk�d',
	'valaszkod' 			=> 'V�laszk�d',
	'valaszszoveg' 			=> 'V�laszk�d magyar�zata',
	'teljesites_idopontja'	=> 'Teljes�t�s id�pontja',
	'nev' 					=> 'N�v',
	'orszag' 				=> 'Orsz�g',
	'megye' 				=> 'Megye',
	'telepules' 			=> 'Telep�l�s',
	'utca_hazszam' 			=> 'Utca, h�zsz�m',
	'iranyitoszam' 			=> 'Ir�ny�t�sz�m',
	'kozlemeny' 			=> 'K�zlem�ny'
);



if ($shopStatus == 'SUCCESS')
{
?>
<h1>V�s�rl�s sikeres!</h1>

<p>K�sz�nj�k a v�s�rl�st!</p>

<?php
}
elseif ($shopStatus == 'FAILURE')
{
?>
<h1>V�s�rl�s sikertelen</h1>

<p>A v�s�rl�s sor�n nem v�rt hiba l�pett fel.</p>

<?php
}
else
{
?>
<h1>V�s�rl�s megszak�tva</h1>

<p>A banki v�lasz alapj�n a tranzakci� sikertelen, vagy meg lett szak�tva. A v�s�rl�s nem t�rt�nt meg.</p>

<?php
}

?>

<p><a href="online_vasarlas.php">V�s�rl�s f�oldal</a> | <a href="online_vasarlasaim.php">V�s�rl�st�rt�ntet</a></p>


<?php

if (false)
{

echo "<h1>$bankStatus</h1>";

//var_dump($tranz);

echo "<table>\n";
foreach ($tranz as $key => $value)
{
	echo "<tr><th>" . $trLabels[$key] . "</th><td>" . $value . "</td></tr>\n";
}
echo "</table>\n";

}

require_once('views/footer.php');


?>
