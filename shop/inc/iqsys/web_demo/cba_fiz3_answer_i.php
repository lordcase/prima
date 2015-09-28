<?php 
    /**
    * @desc Példa olyan eredmény oldalra, melyre a kétszereplos
    * fizetés sikeres végrehajtása után történik a vezérlásátadás
    * PHP kódbeli include / require utasítással.
    * 
    * Az állományt a példánkban a fiz2_control.php include-olja,
    * a ketszereplosshop.conf fájl megfelelo konfigurálása esetén.
    * Ilyenkor két global láthatóságú PHP objektum változó áll
    * rendelkezésre, mely tartalmazza a fizetés összes válaszadatát:
    * - tranzAdatok: WebShopFizetesValasz típusú objektum, a 
    *   vásárláshoz tartozó válaszobjektum (value object)
    * 
    * Megjegyzés: a fizetési tranzakció eredménye (tranzAdatok) a 
    * Tranzakció  lekérdezés funkció meghívásával kerül lekérdezésre.
    * A válasz feldolgozását eszerint kell elvégezni: a vásáslás
    * akkor sikeres, ha a POS válaszkód 000-010 közti érték,
    * és az authorizációs kód nem üres.
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
	//A tranzakció nem hajtódott végre, a banki válasz válasz nem érheto el vagy nem értelmezheto.
	$bankStatus = 'ERROR';
}
else if ($tranzAdatok->isSuccessful())
{
	if ($tranzAdatok->isCsakRegisztracio()) {
		// sikeres regisztrálás
		$bankStatus = 'REGISTERED';
	} else {
		// sikeres vásárlás
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
	'azonosito' 			=> 'Tranzakció azonosítója',
	'shop_id' 				=> 'Bolt azonosítója',
	'statuskod' 			=> 'Státuszkód',
	'valaszkod' 			=> 'Válaszkód',
	'valaszszoveg' 			=> 'Válaszkód magyarázata',
	'teljesites_idopontja'	=> 'Teljesítés idõpontja',
	'nev' 					=> 'Név',
	'orszag' 				=> 'Ország',
	'megye' 				=> 'Megye',
	'telepules' 			=> 'Település',
	'utca_hazszam' 			=> 'Utca, házszám',
	'iranyitoszam' 			=> 'Irányítószám',
	'kozlemeny' 			=> 'Közlemény'
);



if ($shopStatus == 'SUCCESS')
{
?>
<h1>Vásárlás sikeres!</h1>

<p>Köszönjük a vásárlást!</p>

<?php
}
elseif ($shopStatus == 'FAILURE')
{
?>
<h1>Vásárlás sikertelen</h1>

<p>A vásárlás során nem várt hiba lépett fel.</p>

<?php
}
else
{
?>
<h1>Vásárlás megszakítva</h1>

<p>A banki válasz alapján a tranzakció sikertelen, vagy meg lett szakítva. A vásárlás nem történt meg.</p>

<?php
}

?>

<p><a href="online_vasarlas.php">Vásárlás fõoldal</a> | <a href="online_vasarlasaim.php">Vásárlástörténtet</a></p>


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
