<?php

require_once('inc/bwMSSQLDatabase.php');
require_once('inc/class.phpmailer.php');
require_once('inc/bwLog.php');

define('BW_CLIENT_STATUS_UNKNOWN', 0);
define('BW_CLIENT_STATUS_OK', 1);
//define('BW_CLIENT_STATUS_NO_DEPOSIT', -1);
define('BW_CLIENT_STATUS_NO_ACCOUNT', -1);
define('BW_CLIENT_STATUS_ERROR', -2);
define('BW_CLIENT_STATUS_NOT_LOGGED_IN', -3);


// Aerobic jegyek

define('FITNESS_14_ORAIG_8', 	971);
define('FITNESS_14_ORAIG_12', 	972);
define('FITNESS_14_ORAIG_20', 	973);

define('FITNESS_8', 			25);
define('FITNESS_12', 			26);
define('FITNESS_20', 			27);

define('AEROBIC_14_ORAIG_8',	968);
define('AEROBIC_14_ORAIG_12', 	969);
define('AEROBIC_14_ORAIG_20', 	970);

define('AEROBIC_8', 			21);
define('AEROBIC_12', 			29);
define('AEROBIC_20', 			30);

/*define('AEROBIC_14_ORAIG_8',	1847);
define('AEROBIC_14_ORAIG_12', 	1849);
define('AEROBIC_14_ORAIG_20', 	1851);

define('AEROBIC_8', 			1848);
define('AEROBIC_12', 			1850);
define('AEROBIC_20', 			1852);*/

define('FITNESS_AEROBIC_14_ORAIG_8', 	975);
define('FITNESS_AEROBIC_14_ORAIG_12', 	976);
define('FITNESS_AEROBIC_14_ORAIG_20', 	977);

define('FITNESS_AEROBIC_8', 	38);
define('FITNESS_AEROBIC_12', 	39);
define('FITNESS_AEROBIC_20', 	40);

define('FITNESS_SPA_14_ORAIG_8', 	978);
define('FITNESS_SPA_14_ORAIG_12', 	979);
define('FITNESS_SPA_14_ORAIG_20', 	980);

define('FITNESS_SPA_8', 		42);
define('FITNESS_SPA_12', 		43);
define('FITNESS_SPA_20', 		44);

define('AEROBIC_SPA_8', 		417);
define('AEROBIC_SPA_12', 		420);
define('AEROBIC_SPA_20', 		424);

// Karate jegy

define('GYERMEK_KARATE_8', 		1418);

// Squash jegyek

// define('SQUASH_1_5', 			1656);
// define('SQUASH_2_5', 			1654);
// define('SQUASH_3_5', 			1655);

// define('SQUASH_1_10', 			1659);
// define('SQUASH_2_10', 			1658);
// define('SQUASH_3_10', 			1657);


define('SQUASH_1_5', 			985);
define('SQUASH_2_5', 			986);
define('SQUASH_3_5', 			987);

define('SQUASH_1_10', 			1317);
define('SQUASH_2_10', 			1316);
define('SQUASH_3_10', 			1315);

define('SQUASH_1_20', 			1996);
define('SQUASH_1_25', 			2430);


// Exkluzív jegyek

define('EXKLUZIV_30_NAP', 		23);
define('EXKLUZIV_3_HONAP', 		982);
define('EXKLUZIV_6_HONAP', 		983);
define('EXKLUZIV_12_HONAP', 	984);



function bwRemoteSortCompare($row1, $row2)
{
	$timestamp1 = strtotime($row1['kezdes']);
	$timestamp2 = strtotime($row2['kezdes']);
	if($timestamp1 == $timestamp2)
	{
		return 0;
	}
	else
	{
		return ($timestamp1 < $timestamp2) ? -1 : 1;
	}
}

function bwRemoteSortCompareCikkLista($row1, $row2)
{
	$ar1 = $row1['nev'];
	$ar2 = $row2['nev'];
	if($ar1 == $ar2)
	{
		return 0;
	}
	else
	{
		return ($ar1 < $ar2) ? -1 : 1;
	}
}



class bwRemoteServices {

	var $db;
	var $dbConnected;
	var $dayId;
	var $client;
	var $status;
	var $feedback;
	var $SECTIONS;
	
	var $akciosAr = array(
		FITNESS_14_ORAIG_8 						=> 8450,
		//FITNESS_14_ORAIG_12                     => 9850,
		//FITNESS_14_ORAIG_20                     => 12250,
		FITNESS_14_ORAIG_12                     => 9400,
		FITNESS_14_ORAIG_20                     => 11300,		
		FITNESS_8 				=> 9450,
		FITNESS_12 				=> 11150,
		FITNESS_20 				=> 13500,		
		AEROBIC_14_ORAIG_8 			=> 7250,
		//AEROBIC_14_ORAIG_12                     => 8650,
		//AEROBIC_14_ORAIG_20                     => 9800,
		AEROBIC_14_ORAIG_12                     => 7500,
		AEROBIC_14_ORAIG_20                     => 8450,		
		AEROBIC_8 				=> 8150,
		AEROBIC_12 				=> 9750,
		AEROBIC_20 				=> 10950,
		FITNESS_AEROBIC_14_ORAIG_8              => 9250,
		FITNESS_AEROBIC_14_ORAIG_12             => 11550,
		FITNESS_AEROBIC_14_ORAIG_20             => 13800,
		FITNESS_AEROBIC_8 			=> 10900,
		FITNESS_AEROBIC_12 			=> 13500,
		FITNESS_AEROBIC_20 			=> 16000,
		FITNESS_SPA_14_ORAIG_8                  => 13000,
		//FITNESS_SPA_14_ORAIG_12                 => 15000,
		//FITNESS_SPA_14_ORAIG_20                 => 17850,
		FITNESS_SPA_14_ORAIG_12                 => 13200,
		FITNESS_SPA_14_ORAIG_20                 => 16050,		
		FITNESS_SPA_8 				=> 15000,
		FITNESS_SPA_12 				=> 17250,
		FITNESS_SPA_20 				=> 19950,
		//AEROBIC_SPA_8 				=> 9400,
		//AEROBIC_SPA_12 				=> 11400,
		//AEROBIC_SPA_20 				=> 13300,
		AEROBIC_SPA_8 				=> 10830,
		AEROBIC_SPA_12 				=> 13000,
		AEROBIC_SPA_20 				=> 15820,		
		//GYERMEK_KARATE_8 			=> 5800,
		SQUASH_1_5 				=> 9490,
		SQUASH_2_5 				=> 10915,
		SQUASH_3_5 				=> 11865,
		SQUASH_1_10 				=> 17090,
		SQUASH_2_10 				=> 18990,
		SQUASH_3_10 				=> 20890,
		SQUASH_1_20 				=> 52870,
		SQUASH_1_25 				=> 59375,
		EXKLUZIV_30_NAP 			=> 21000,
		EXKLUZIV_3_HONAP 			=> 51000,
		EXKLUZIV_6_HONAP 			=> 90000,
		EXKLUZIV_12_HONAP 			=> 156000
	);
  
  function bwRemoteServices()
  {
		$server   = "81.183.210.139";
		//$server   = "cbagyomroi.dnsalias.net:1433";
		//$server   = "cbaw.dnsalias.net";
		$user     = "webuser";
		$password = "honlapszerk";
		$db       = "wellness";

		$this->db = new bwMSSQLDatabase($server, $user, $password, $db);
		$this->dbConnected = $this->db->connected;
		$this->dayId = date('Y.m.d');

		$this->client = array();
		$this->status = BW_CLIENT_STATUS_UNKNOWN;
		$this->feedback = array();
		
		if($this->dbConnected)
		{
			$this->SECTIONS = array('FORM' => false, 'ERROR' => false, 'EMAILFORM' => false, 'EMAILERROR' => false, 'THANKYOU' => false, 'UNAUTHORIZED' => true, 'NODBCONNECTION' => false);
		}
		else
		{
			$this->SECTIONS = array('FORM' => false, 'ERROR' => false, 'EMAILFORM' => false, 'EMAILERROR' => false, 'THANKYOU' => false, 'UNAUTHORIZED' => false, 'NODBCONNECTION' => true);
		}
	}
	
	function Process()
	{
		global $POST;
		global $session;
		global $log;
		
		if(!$this->dbConnected)
		{
			$this->SECTIONS['NODBCONNECTION'] = true;
			$log->Log('bwRemoteServices', 'Adatbázis kapcsolódási hiba: Nem sikerült kapcsolódni a távoli adatbázishoz.' , BW_LOG_HIGH);
			$this->sendErrorEmail('Adatbázis kapcsolódási hiba: Nem sikerült kapcsolódni a távoli adatbázishoz.');
			return 0;
		}
		
		if ($session->logged_in)
		{
			$this->SECTIONS['EMAILFORM'] = true;
			$this->ValidateClient($session->user['email'], $session->user['secret_code']);
		}
		else
		{
			$this->status = BW_CLIENT_NOT_LOGGED_IN;
		}
		
		if (($this->status == BW_CLIENT_STATUS_OK) && ($POST->toModule == 'FOGLALAS'))
		{
			$this->SECTIONS['UNAUTHORIZED'] = false;
			
			if ($POST->toFunction == 'DATUMVALTAS')
			{
				$this->dayId = htmlspecialchars($POST->Item('date'));
				$this->SECTIONS['FORM'] = true;
			}
			elseif ($POST->toFunction == 'HOZZAAD')
			{
				$start = htmlspecialchars($POST->Item('start'));
				$roomId = intval($POST->Item('roomId'));
				$roomName = htmlspecialchars($POST->Item('roomName'));
				$serviceId = intval($POST->Item('serviceId'));
				$serviceName = htmlspecialchars($POST->Item('serviceName'));
				if ($this->DoSignUp($start, $roomId, $serviceId))
				{
					$log->Log('bwRemoteServices', 'Feliratkozás. kezdes=' . $start . ', hely=' . $roomName . ' (' . $roomId . '), idcikk=' . $serviceName . ' (' . $serviceId . ')' , BW_LOG_LOW);
					$this->SECTIONS['FORM'] = true;
					$this->SECTIONS['THANKYOU'] = true;
				}
				else
				{
					$this->SECTIONS['FORM'] = true;
					$this->SECTIONS['ERROR'] = true;
				}
				$this->dayId = htmlspecialchars($POST->Item('keepDate'));	
			}
			elseif ($POST->toFunction == 'TOROL')
			{
				$start = htmlspecialchars($POST->Item('start'));
				$roomId = intval($POST->Item('roomId'));
				$roomName = htmlspecialchars($POST->Item('roomName'));
				$serviceId = intval($POST->Item('serviceId'));
				$serviceName = htmlspecialchars($POST->Item('serviceName'));
				if ($this->CancelSignUp($start, $roomId, $serviceId))
				{
					$log->Log('bwRemoteServices', 'Törlés. kezdes=' . $start . ', hely=' . $roomName . ' (' . $roomId . '), idcikk=' . $serviceName . ' (' . $serviceId . ')' , BW_LOG_LOW);
					$this->SECTIONS['FORM'] = true;
					$this->SECTIONS['THANKYOU'] = true;
				}
				else
				{
					$this->SECTIONS['FORM'] = true;
					$this->SECTIONS['ERROR'] = true;
				}
				$this->dayId = htmlspecialchars($POST->Item('keepDate'));	
			}
		}
		elseif (($POST->toModule == 'KODKULDES') && ($POST->toFunction == 'KODKULDES') && $session->logged_in)
		{
			$this->SECTIONS['UNAUTHORIZED'] = false;

			$id = $this->GetClientId($session->user['email']);
			if ($id)
			{
				if ($this->SendCodeEmail($session->user['nick'], $session->user['email'], $id))
				{
					$log->Log('bwRemoteServices', 'Azonosító kód kiküldve (nev=' . $session->user['nick'] . ', email=' . $session->user['email'] . ', kod=' . $id . ')' , BW_LOG_LOW);
					$this->SECTIONS['EMAILFORM'] = false;
					$this->SECTIONS['THANKYOU'] = true;
				}
				else
				{
					$log->Log('bwRemoteServices', 'Azonosító kód küldése sikertelen (nev=' . $session->user['nick'] . ', email=' . $session->user['email'] . ', kod=' . $id . ')' , BW_LOG_MEDIUM);
					$this->SECTIONS['EMAILFORM'] = false;
					$this->SECTIONS['ERROR'] = true;
				}
			}
			else
			{
				$this->SECTIONS['EMAILFORM'] = false;
				$this->SECTIONS['EMAILERROR'] = true;
			}
		}
		elseif ($this->status == BW_CLIENT_STATUS_OK)
		{
			$this->SECTIONS['UNAUTHORIZED'] = false;
			$this->SECTIONS['FORM'] = true;
		}
	}
	
	
	// private
	// returns client data row from remote DB
	function GetClientData($email)
	{
		$sql = "SELECT ID, NEV, CIM, VAROS, TELEFON1, EMAIL "
				 . "FROM dbo.UGYFELEK "
				 . "WHERE (EMAIL = '" . $email . "')";
				 
		if($this->db->Query($sql))
		{
			if($row = $this->db->FetchRow())
			{
				return $row;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	// private
	function IsClientValid($id, $name)
	{
		$sql = "DECLARE @eredmeny INT; "
		     . "EXECUTE WSP_ERVENYES_FELHASZNALO '" . intval($id) . "', '" . $name . "', @eredmeny output; "
				 . "SELECT @eredmeny; ";

		if($this->db->Query($sql))
		{
			if($row = $this->db->FetchRow())
			{
				$this->Trace("WSP_ERVENYES_FELHASZNALO", $row[0]);
				return ($row[0] == 0);
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	// returnc client ID corresponding to client email
	function GetClientId($email)
	{
		if($client = $this->GetClientData($email))
		{
			return $client['ID']; 
		}
		else
		{
			return 0;
		}
	}
	
	
	// validates client
	function ValidateClient($email, $code)
	{
	
		if($this->client = $this->GetClientData($email))
		{
			if($this->IsClientValid($code, $this->client['NEV']))
			{
				$this->status = BW_CLIENT_STATUS_OK;
			}
			else
			{
				$this->status = BW_CLIENT_STATUS_NO_ACCOUNT;
			}
		}
		else
		{
			$this->status = BW_CLIENT_STATUS_ERROR;
		}
	
		return $this->status;
	}

	function FedezetEllenorzes($id, $name, $start, $roomId, $serviceId)
	{
		$sql = "DECLARE @eredmeny INT; "
		     . "EXECUTE WSP_FEDEZET_ELLENORZES '" . intval($id) . "', '" . $name . "', '" . $start . "', '" . $roomId . "', '" . $serviceId . "', @eredmeny output; "
				 . "SELECT @eredmeny; ";

		if($this->db->Query($sql))
		{
			if($row = $this->db->FetchRow())
			{
				$this->Trace("WSP_FEDEZET_ELLENORZES", $row[0]);
				return ($row[0] == 0);
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	// az adott naphoz tartozó foglalási lehetoséggel tér vissza	
	function GetServicesForDay($date)
	{
		$sql = "EXECUTE WSP_ORAK_LEKERDEZESE '" . $date . "' ";

		if($this->db->Query($sql))
		{
			$services = array();
			
			$now = time();
			
			while ($row = $this->db->FetchRow())
			{
				$row['szabad_hely'] = $row['ferohely'] - $row['jelentkezok'];
				$row['kezdes_formatted'] = $this->ConvertFromMSSQLDate($row['kezdes']);
				$row['kezdes_formatted_short'] = $this->ConvertFromMSSQLDate($row['kezdes'], true);
				$row['vege_formatted'] = $this->ConvertFromMSSQLDate($row['vege']);
				$row['vege_formatted_short'] = $this->ConvertFromMSSQLDate($row['vege'], true);
				if($row['szabad_hely'] && (strtotime($row['kezdes']) >= ($now + 30 * 60) ))
				{
					$services[] = $row;
				}
			}
			
			usort($services, 'bwRemoteSortCompare');	

			return $services;
		}
		else
		{
			return false;
		}		
	}
	
	function GetGroupedServicesForDay($date)
	{
		if ($ungrouped = $this->GetServicesForDay($date))
		{
			/*$services = array('fitness' => array(),
												'squash' => array(),
												'wellness' => array()
											 );*/
											 
			$services = array('fitness' => array(),
												'squash' => array()
											 );
											 
			if (count($ungrouped) > 0)
			{
				foreach ($ungrouped as $service)
				{
					switch ($service['idhely'])
					{
						case 1:
						case 2:
							$services['squash'][] = $service;
						break;
						case 15:
							//$services['wellness'][] = $service;
						break;
						default:
							$services['fitness'][] = $service;
						break;
					}
				}
				
			}
			
			return $services;
			
		}
		else
		{
			return false;
		}
	}
	
	
	function GetServicesForClient()
	{
		$sql = "EXECUTE WSP_FELHASZNALO_ORAI '" . $this->client['ID'] . "', '" . $this->client['NEV'] . "' ";

		if($this->db->Query($sql))
		{
			$services = array();
			$now = time();
			
			while ($row = $this->db->FetchRow())
			{
				$row['kezdes_formatted'] = $this->ConvertFromMSSQLDate($row['kezdes']);
				$row['kezdes_formatted_short'] = $this->ConvertFromMSSQLDate($row['kezdes'], true);
				$row['vege_formatted'] = $this->ConvertFromMSSQLDate($row['vege']);
				$row['vege_formatted_short'] = $this->ConvertFromMSSQLDate($row['vege'], true);
				switch ($row['idhely'])
				{
					case 1:
					case 2:
						$cancelTimeLimit = 24 * 60 * 60; // squash
						break;
					default:
						$cancelTimeLimit = 4 * 60 * 60; // everything else
						break;
				}
			
				$row['can_cancel'] = (strtotime($row['kezdes']) - $now) >= $cancelTimeLimit;

				$services[] = $row;
			}

			usort($services, 'bwRemoteSortCompare');	

			return $services;
		}
		else
		{
			return false;
		}		
	}
	
	function DoSignUp($start, $roomId, $serviceId)
	{
		$sql = "DECLARE @eredmeny INT; "
		     . "EXECUTE WSP_FOGLALAST_HOZZAAD '" . $this->client['ID'] . "', '" . $this->client['NEV'] . "', '" . $start . "', '" . $roomId . "', '" . $serviceId . "', @eredmeny output; "
				 . "SELECT @eredmeny; ";

		if($this->db->Query($sql))
		{
			if($row = $this->db->FetchRow())
			{
				$this->Trace("WSP_FOGLALAST_HOZZAAD", $row[0]);
				return ($row[0] == 0);
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	function CancelSignUp($start, $roomId, $serviceId)
	{
		$sql = "DECLARE @eredmeny INT; "
		     . "EXECUTE WSP_FOGLALAST_TOROL '" . $this->client['ID'] . "', '" . $this->client['NEV'] . "', '" . $start . "', '" . $roomId . "', '" . $serviceId . "', @eredmeny output; "
				 . "SELECT @eredmeny; ";

		if($this->db->Query($sql))
		{
			if($row = $this->db->FetchRow())
			{
				$this->Trace("WSP_FOGLALAST_TOROL", $row[0]);
				return ($row[0] == 0);
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	

	// Verzió: 2.0
	function GetCikklista()
	{
		$sql = "EXECUTE WSP_CIKKLISTA ";

		if($this->db->Query($sql))
		{
			$cikkek = array();
			
			while ($row = $this->db->FetchRow())
			{
				if ($row['jegy'])
				{
					$cikkek[] = $row;
				}
			}
			
			usort($cikkek, 'bwRemoteSortCompareCikkLista');	

			return $cikkek;
		}
		else
		{
			return false;
		}		
	}


	// Verzió: 2.0
	function GetCikk($id)
	{
		if ($id == 77777)
		{
			$cikk = array(
				'id' => 77777,
				'nev' => 'Egyenleg feltöltése',
				'bruttoar' => 3
			);
			
			return $cikk;
		}
		else
		{
			if($lista = $this->GetCikkLista())
			{
				$cikk = false;
				
				foreach($lista as $row)
				{
					if ($row['id'] == $id)
					{
						$cikk = $row;
						break;
					}
				}
				
				if ($cikk)
				{
					$cikk['bruttoar'] = $this->akciosAr[$id];
				}
				
				return $cikk;
			}
			else
			{
				return false;
			}
		}
	}

	// Verzió: 2.0
	function GetCikkNev($id)
	{
		if($cikk = $this->GetCikk($id))
		{
			return $cikk['nev'];
		}
		else
		{
			return 'ismeretlen';
		}		
	}

	// Verzió: 2.0
	function GetJegytipusSzolgaltatasai($jegytipus)
	{
		$sql = "WSP_JEGYTIPUS_SZOLGALTATASAI '" . $jegytipus . "' ";

		if($this->db->Query($sql))
		{
			$szolgaltatasok = array();
			
			while ($row = $this->db->FetchRow())
			{
				$szolgaltatasok[] = $row;
			}
			
			//usort($szolgaltatasok, 'bwRemoteSortCompare');	

			return $szolgaltatasok;
		}
		else
		{
			return false;
		}		
	}

	// Verzió: 2.0
	function GetFelhasznaloJegyei()
	{
		$sql = "EXECUTE WSP_FELHASZNALO_JEGYEI '" . $this->client['ID'] . "', '" . $this->client['NEV'] . "' ";

		if($this->db->Query($sql))
		{
			$jegyek = array();
			$now = time();
			
			while ($row = $this->db->FetchRow())
			{
				$jegyek[] = $row;
			}
			
			//usort($jegyek, 'bwRemoteSortCompare');	

			return $jegyek;
		}
		else
		{
			return false;
		}		
	}
	
	// Verzió: 2.0
	// Visszaadja, hogy az adott azonosítószámú jegybol (vagy jegycsoportból, ha array) hány darab van a felhasználó jelenlegi jegyei között
	function GetNumberOfJegyek($idArray)
	{
		$count = 0;
		
		if (!is_array($idArray))
		{
			$idArray = array($idArray);
		}
		
	
		if ($jegyek = $this->GetFelhasznaloJegyei())
		{
			foreach ($jegyek as $jegy)
			{
				//echo "<pre>Comparing to : " . $jegy['jegytipus'] . "</pre>\n";
				if (in_array($jegy['jegytipus'], $idArray))
				{
					$count++;
				}
			}
		}
		
		return $count;
	}
	
	// Verzió: 2.0
	// Üres string-gel tér vissza, ha a jegyet meg lehet vásárolni, a hibaüzenetet tartalmazó stringgel, ha nem.
	function GetJegyErrorMessage($id)
	{
		$messsage = '';
	
		$aerobicJegyek 	= array(25, 26, 27, 38, 39, 40, 42, 43, 44, 417, 420, 424, 971, 972, 973, 975, 976, 977, 978, 979, 980, AEROBIC_14_ORAIG_8, AEROBIC_14_ORAIG_12, AEROBIC_14_ORAIG_20, AEROBIC_8, AEROBIC_12, AEROBIC_20);
		$karateJegyek	= array(1418);
		$squashJegyek	= array(985, 986, 987, 1315, 1316, 1317, 1654, 1655, 1656, 1657, 1658, 1659);
		$exkluzivJegyek	= array(23, 982, 983, 984);

		if (in_array($id, $aerobicJegyek))
		{
			if ($this->GetNumberOfJegyek($aerobicJegyek) >= 2)
			{
				$message = 'Fitness vagy aerobic típusú bérletbõl már két darabbal rendelkezel, ez az egyszerre vásárlható maximális mennyiség.';
			}
		}
		elseif (in_array($id, $karateJegyek))
		{
			if ($this->GetNumberOfJegyek($karateJegyek) >= 2)
			{
				$message = 'Gyermekkarate bérletbõl már két darabbal rendelkezel, ez az egyszerre vásárlható maximális mennyiség.';
			}
		}
		elseif (in_array($id, $squashJegyek))
		{
			if ($this->GetNumberOfJegyek($squashJegyek) >= 2)
			{
				$message = 'Squash bérletbõl már két darabbal rendelkezel, ez az egyszerre vásárlható maximális mennyiség.';
			}
		}
		elseif (in_array($id, $exkluzivJegyek))
		{
			if ($this->GetNumberOfJegyek($exkluzivJegyek) >= 1)
			{
				$message = 'Exkluzív tagsággal már rendelkezel eggyel, akkor tudsz újat vásárloni, ha ennek érvényessége lejárt.';
			}
		}
		
		
		return $message;
	}

	// Verzió: 2.0
	function UserCanPayOnline()
	{
		global $session;
	
		return ($session->logged_in) && ($this->ValidateClient($session->user['email'], $session->user['secret_code']) == BW_CLIENT_STATUS_OK);
	}
  
	// Verzió: 2.0
	function DoVasarlas($productId, $webBizonylat, $startDate, $nettoErtek, $bruttoErtek, $vevo)
	{
		if ($productId == 77777)
		{
			return $this->DoFeltoltes($webBizonylat, $bruttoErtek);
		}
	
		if ($startDate == NULL)
		{
			$stardate = 'NULL';
		}
		else
		{
			$startDate = "'" . $startDate . "'";
		}
	
	
		/*$sql = "DECLARE @eredmeny INT; "
		     . "EXECUTE WSP_ELAD '" . $this->client['ID'] . "', '" . $this->client['NEV'] . "', '" . $productId . "', '1', '" . $webBizonylat . "', '0', '0', '" . $startDate . "', @eredmeny output; "
				 . "SELECT @eredmeny; ";*/
				 
		$sql = "DECLARE @eredmeny INT; "
			 . "DECLARE @raktaribizonylat BIGINT; "
			 //. "DECLARE @penzugyibizonylat BIGINT; "
			 . "SET @raktaribizonylat = 0; "
			 //. "SET @penzugyibizonylat = 0; "
		     //. "EXECUTE WSP_ELAD '" . $this->client['ID'] . "', '" . $this->client['NEV'] . "', '" . $productId . "', '1', '" . $webBizonylat . "', @raktaribizonylat output, " . $startDate . ", @eredmeny output, '" . $nettoErtek . "', '" . $bruttoErtek . "'; "
		     . "EXECUTE WSP_ELAD '" . $this->client['ID'] . "', '" . $this->client['NEV'] . "', '" . $productId . "', '1', '" . $webBizonylat . "', @raktaribizonylat output, NULL, @eredmeny output, '" . $nettoErtek . "', '" . $bruttoErtek . "'; "
				 . "SELECT @raktaribizonylat, @eredmeny; ";
		     //. "EXECUTE WSP_ELAD '" . $this->client['ID'] . "', '" . $this->client['NEV'] . "', '" . $productId . "', '1', '" . $webBizonylat . "', 0, 0, '" . $startDate . "', @eredmeny output, '" . $nettoErtek . "', '" . $bruttoErtek . "'; "
				 //. "SELECT @eredmeny; ";
				 
		//echo "<pre>$sql</pre>";
		
		// TESZT ÜZEMMÓD!!!!
		// *******************
		//return true;
		// *******************

		if($this->db->Query($sql))
		{
			if($row = $this->db->FetchRow())
			{
				$this->Trace("WSP_ELAD", $row[1]);

				//echo "<pre>WSP_ELAD válaszkód: " . $row[0] . "</pre>";

				if ($row[1] == 0)
				{
					$sql = "DECLARE @eredmeny INT; "
						 . "DECLARE @penzugyibizonylat BIGINT; "
						 . "SET @penzugyibizonylat = 0; "
						 . "EXECUTE WSP_KIFIZET '" . $this->client['ID'] . "', '" . $this->client['NEV'] . "', '" . $webBizonylat . "', '"  . $row[0] . "', '" . $nettoErtek . "', '" . $bruttoErtek . "', '" . $vevo['nev'] . "', '" . $vevo['cim'] . "', '" . $vevo['varos'] . "', '" . $vevo['iranyitoszam'] ."', @penzugyibizonylat output, @eredmeny output; "
						 . "SELECT @eredmeny; ";

					//echo "<pre>$sql</pre>";

					if($this->db->Query($sql))
					{
						if($row = $this->db->FetchRow())
						{
							$this->Trace("WSP_KIFIZET", $row[2]);
							return 1;
						}
						else
						{
							return -3;
						}
					}
					else
					{
						return -2;
					}

				}
				else
				{
					return -1;
				}
			}
			else
			{
				var_dump($row);
				return 0;
			}
		}
		else
		{
			return 0;
		}
	}

	function DoFeltoltes($webBizonylat, $bruttoErtek)
	{
		$sql = "DECLARE @eredmeny INT; "
		     . "EXECUTE WSP_PENZFELTOLT '" . $this->client['ID'] . "', '" . $this->client['NEV'] . "', '" . $bruttoErtek . "', '" . $webBizonylat . "', 0, @eredmeny output; "
				 . "SELECT @eredmeny; ";
				 
		if($this->db->Query($sql))
		{
			if($row = $this->db->FetchRow())
			{
				$this->Trace("WSP_PENZFELTOLT", $row[0]);

				if ($row[0] == 99)
				{
					echo "<pre>Figyelem! Csak tesztvásárlás történt! 99-es kód</pre>";
				}
				
				return 1;

			}
			else
			{
				var_dump($row);
				return 0;
			}
		}
		else
		{
			return 0;
		}
	}
	
	function ConvertFromMSSQLDate($date, $short = false)
	{
		$format = $short ? "H:i" : "Y-m-d H:i";
		$timestamp = strtotime($date);
		return date($format, $timestamp);
	}
	
	
	function GetDays()
	{
		$days = array();
	
		$timeStamp = time();
		
		// fapados magyar dátum :P
		$badDays = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
		$goodDays = array("hétfo", "kedd", "szerda", "csütörtök", "péntek", "szombat", "vasárnap");
		
		$days[date('Y.m.d', $timeStamp)] = 'Ma';
		$timeStamp += (24 * 60 * 60);
		$days[date('Y.m.d', $timeStamp)] = 'Holnap';
		for ($i = 1; $i <= 5; $i++)
		{
			$timeStamp += (24 * 60 * 60);
			$days[date('Y.m.d', $timeStamp)] = str_replace($badDays, $goodDays, date('Y/m/d l', $timeStamp));
		}
		
		return $days;
	}


	function SendCodeEmail($name, $email, $id)
	{
		$from = array('name' => BW_CLIENT, 'email' => BW_EMAIL);
		$to = array('name' => $name, 'email' => $email);
		
		$subject = BW_CLIENT . " online foglalási kód";
		
		$body = "<p>Kedves <strong>$name</strong>!</p>\n"
					. "<p>Ezt a levelet a rendszerünk automatikusan küldte Neked, mert weboldalunkon keresztül igényelted az online foglaláshoz szükséges kódot.</p>\n"
					. "<p>A(z) $email emailcímhez tartozó foglalási kód: <strong>$id</strong></p>"
					. "<p>Ha a <a href=\"" . BW_WEBPAGE . "\">"  . BW_WEBPAGE .  "</a> weboldalon bejelentkezel, az Adatlapon az 'adatok módosítása' linkre kattintva elõjövõ ûrlapon ezt a számot kell beírnod a Foglalási kód mezõbe.</p>\n"
					. "<p>Miután ezzel a kóddal élesítetted a felhasználói adatlapod, használhatod az online foglalási rendszert.</p>\n"
					. "<p>Üdvözlettel,</p>\n"
					. "<p><a href=\"" . BW_WEBPAGE . "\">" . BW_CLIENT . "</a></p>\n";
		
		return $this->SendMail($from, $to, $subject, $body);
	}

	function SendErrorEmail($message)
	{
		$from = array('name' => BW_CLIENT, 'email' => BW_EMAIL);
		$toto = array(
							array('name' => "Nara András", 'email' => 'naraan@anaiz.hu')/*,
							array('name' => "Rodé Péter", 'email' => 'rodepetya@freemail.hu')*/
						);
		
		$subject = BW_CLIENT . " hiba az online foglalási rendszerben";
		
		$body = "<p>Kedves <strong>$name</strong>!</p>\n"
					. "<p>Ezt a levelet a rendszerünk automatikusan küldte Neked, hogy figyelmeztessen az online foglalási rendszer használata során fellépett hibára.</p>\n"
					. "<p>A hiba a következo: </p>"
					. "<pre>" . $message . "</pre>";
		
		foreach($toto as $to)
		{
			$this->SendMail($from, $to, $subject, $body);
		}
		
		return true;
	}
	
	function SendVasarlasEmail($vevo, $vasarlas)
	{
		global $session;
	
		$from = array('name' => BW_CLIENT, 'email' => BW_EMAIL);
		$to = array('name' => $session->user['nick'], 'email' => $session->user['email']);

		
		$subject = BW_CLIENT . " sikeres online vásárlás";
		
		$body = "<p>Kedves <strong>" . $to['name'] . "</strong>!</p>\n"
					. "<p>Ezt a levelet a rendszerünk automatikusan küldte Neked, mert weboldalunkon keresztül sikeresen megvásároltad a következõ terméket.</p>\n"
					. "<p><strong>" . $vasarlas['product_name'] . "</strong> (" . $vasarlas['price'] . " Ft)</p>"
					. "<p>Üdvözlettel,</p>\n"
					. "<p><a href=\"" . BW_WEBPAGE . "\">" . BW_CLIENT . "</a></p>\n";
		
		return $this->SendMail($from, $to, $subject, $body);
	}

	// generic mail method
	function SendMail($from, $to, $subject, $body)
	{
		$mailer = new PHPMailer();
	
		$mailer->IsSMTP();
		$mailer->CharSet = 'iso-8859-2';
		$mailer->IsHTML(true);
		$mailer->Host = "127.0.0.1";
		$mailer->Subject = $subject;
		$mailer->Body = $body;
		$mailer->From = $from['email'];
		$mailer->FromName = $from['name'];
		$mailer->AddAddress($to['email'], $to['name']);
		
		return $mailer->Send();
	}


	function GetServiceGroupName($id)
	{
		switch ($id)
		{
			case 'squash' :
				return 'Squash';
			break;
			case 'fitness' :
				return 'Aerobic';
			break;
			case 'wellness' :
				return 'Wellness';
			break;
			default:
				return '(Nincs definiálva)';
			break;
		}
	}

	function Trace($procedure, $return)
	{
		$time = date("Y-m-d H:i:s");
		$text = "";
	
		switch ($procedure)
		{
			/*case 'WSP_ERVENYES_FELHASZNALO':
				switch ($return)
				{
					case 0:
						$text = "Felhasználó adatai érvényesek";
					break;
					case 1:
						$text = "Nincsen ilyen felhasználó.";
					break;
					case 2:
						$text = "A felhasználónak nincsen érvényes folyószámlája.";
					break;
				}
			break;
			case 'WSP_FEDEZET_ELLENORZES':
				switch ($return)
				{
					case 0:
						$text = "A felhasználó foglalhat az órára.";
					break;
					case 1:
						$text = "Hibás kód vagy felhasználónév.";
					break;
					case 2:
						$text = "A felhasználónak nincsen nyitott folyószámlája, nem foglalhat.";
					break;
					case 3:
						$text = "Érvénytelen idopont.";
					break;
					case 4:
						$text = "Érvénytelen hely.";
					break;
					case 5:
						$text = "Érvénytelen cikk.";
					break;
					case 6:
						$text = "Érvénytelen kombinációja a paramétereknek (kezdes + hely + cikk).";
					break;
					case 7:
						$text = "Minden érvényes, de a felhasználó nem foglalhat fedezethiány miatt erre az órára.";
					break;
					case 8:
						$text = "Minden érvényes, de az adott idopontban már nincs szabad hely.";
					break;
				}
			break;*/
			case 'WSP_FOGLALAST_HOZZAAD':
				switch ($return)
				{
					case 0:
						$text = "Sikeres foglalás.";
					break;
					case 1:
						$text = "Foglalás sikertelen, belsõ hiba lépett fel. Hibakód: 1 (Hibás kód vagy felhasználónév)";
					break;
					case 2:
						$text = "Foglalás sikertelen, nincsen nyitott folyószámlád.";
					break;
					case 3:
						$text = "Foglalás sikertelen, belsõ hiba lépett fel. Hibakód: 3 (Érvénytelen idõpont)";
					break;
					case 4:
						$text = "Foglalás sikertelen, belsõ hiba lépett fel. Hibakód: 4 (Érvénytelen hely)";
					break;
					case 5:
						$text = "Foglalás sikertelen, belsõ hiba lépett fel. Hibakód: 5 (Érvénytelen cikk)";
					break;
					case 6:
						$text = "Foglalás sikertelen, belsõ hiba lépett fel. Hibakód: 6 (Érvénytelen kombinációja a paramétereknek)";
					break;
					case 7:
						$text = "Foglalás sikertelen, fedezethiány miatt nem foglalhatsz erre az órára.";
					break;
					case 8:
						$text = "Foglalás sikertelen, nincsen szabad hely az órán.";
					break;
					case 9:
						$text = "Sikeres foglalás, de csak elõjegyzés státusszal.";
					break;
					case 10:
						$text = "Erre az órára már van foglalásod.";
					break;
				}
			break;
			case 'WSP_FOGLALAST_TOROL':
				switch ($return)
				{
					case 0:
						$text = "Sikerült törölni a foglalást.";
					break;
					case 1:
						$text = "Törlés sikertelen, belsõ hiba lépett fel. Hibakód: 1 (Érvénytelen felhasználó)";
					break;
					case 2:
						$text = "Törlés sikertelen, belsõ hiba lépett fel. Hibakód: 2 (Érvénytelen idõpont)";
					break;
					case 3:
						$text = "Törlés sikertelen, belsõ hiba lépett fel. Hibakód: 3 (Érvénytelen hely)";
					break;
					case 4:
						$text = "Törlés sikertelen, belsõ hiba lépett fel. Hibakód: 4 (Érvénytelen cikk)";
					break;
					case 5:
						$text = "Törlés sikertelen, belsõ hiba lépett fel. Hibakód: 5 (Érvénytelen paraméterek)";
					break;
					case 6:
						$text = "Törlés sikertelen, nincs nyitott folyószámlád.";
					break;
				}
			break;
		}

		//$text = $time . " <strong>" . $procedure . "</strong> (kód " . $return . ") " . $text;
		//if ($return != 0) $text = "<span style=\"color:#ff0000;\">" . $text . "</span>";
		if ($text != '') $this->feedback[] = $text;
	}

	function GetFeedback()
	{
		$html = '';
		if (count($this->feedback) > 0)
		{
			foreach ($this->feedback as $item)
			{
				$html .= $item . "<br />\n";
			}
		}
		
		return $html;
	}
	
	function GetAction()
	{
		return $_SERVER['PHP_SELF'];
	}
	
}

$remote = new bwRemoteServices();
	
?>