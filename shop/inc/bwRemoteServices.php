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



class bwRemoteServices {

	var $db;
	var $dbConnected;
	var $dayId;
	var $client;
  var $status;
	var $feedback;
	var $SECTIONS;
  
  function bwRemoteServices()
  {
		$server   = "81.183.210.139:1434";
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

	// az adott naphoz tartozó foglalási lehetõséggel tér vissza	
	function GetServicesForDay($date)
	{
		$sql = "EXECUTE WSP_ORAK_LEKERDEZESE '" . $date . "' ";

		if($this->db->Query($sql))
		{
			$services = array();
			
			$now = time();
			while ($row = $this->db->FetchRow())
			{
//print_r($row);
				$row['szabad_hely'] = $row['ferohely'] - $row['jelentkezok'];
				$row['kezdes_formatted'] = $this->ConvertFromMSSQLDate($row['kezdes']);
				$row['kezdes_formatted_short'] = $this->ConvertFromMSSQLDate($row['kezdes'], true);
				$row['vege_formatted'] = $this->ConvertFromMSSQLDate($row['vege']);
				$row['vege_formatted_short'] = $this->ConvertFromMSSQLDate($row['vege'], true);
/*				var_dump($row['szabad_hely']);
				var_dump($row['kezdes']);
				var_dump(strtotime(substr($row['kezdes'], 0, -4)));
				var_dump ($now + 30 * 60);
				echo "<br>\n"; */
				if($row['szabad_hely'] && (strtotime(substr($row['kezdes'], 0, -4)) >= ($now + 30 * 60) ))
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
		$goodDays = array("hétfõ", "kedd", "szerda", "csütörtök", "péntek", "szombat", "vasárnap");
		
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
							array('name' => "kgyt", 'email' => 'cbafitness@kgyt.hu'),
						);
		
		$subject = BW_CLIENT . " hiba az online foglalási rendszerben";
		
		$body = "<p>Kedves <strong>$name</strong>!</p>\n"
					. "<p>Ezt a levelet a rendszerünk automatikusan küldte Neked, hogy figyelmeztessen az online foglalási rendszer használata során fellépett hibára.</p>\n"
					. "<p>A hiba a következõ: </p>"
					. "<pre>" . $message . "</pre>";
		
		foreach($toto as $to)
		{
			$this->SendMail($from, $to, $subject, $body);
		}
		
		return true;
	}

	// generic mail method
	function SendMail($from, $to, $subject, $body)
	{
		$mailer = new PHPMailer();
	
		$mailer->IsSMTP();
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
						$text = "Érvénytelen idõpont.";
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
						$text = "Minden érvényes, de az adott idõpontban már nincs szabad hely.";
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