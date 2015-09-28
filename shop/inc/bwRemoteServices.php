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
			$log->Log('bwRemoteServices', 'Adatb�zis kapcsol�d�si hiba: Nem siker�lt kapcsol�dni a t�voli adatb�zishoz.' , BW_LOG_HIGH);
			$this->sendErrorEmail('Adatb�zis kapcsol�d�si hiba: Nem siker�lt kapcsol�dni a t�voli adatb�zishoz.');
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
					$log->Log('bwRemoteServices', 'Feliratkoz�s. kezdes=' . $start . ', hely=' . $roomName . ' (' . $roomId . '), idcikk=' . $serviceName . ' (' . $serviceId . ')' , BW_LOG_LOW);
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
					$log->Log('bwRemoteServices', 'T�rl�s. kezdes=' . $start . ', hely=' . $roomName . ' (' . $roomId . '), idcikk=' . $serviceName . ' (' . $serviceId . ')' , BW_LOG_LOW);
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
					$log->Log('bwRemoteServices', 'Azonos�t� k�d kik�ldve (nev=' . $session->user['nick'] . ', email=' . $session->user['email'] . ', kod=' . $id . ')' , BW_LOG_LOW);
					$this->SECTIONS['EMAILFORM'] = false;
					$this->SECTIONS['THANKYOU'] = true;
				}
				else
				{
					$log->Log('bwRemoteServices', 'Azonos�t� k�d k�ld�se sikertelen (nev=' . $session->user['nick'] . ', email=' . $session->user['email'] . ', kod=' . $id . ')' , BW_LOG_MEDIUM);
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

	// az adott naphoz tartoz� foglal�si lehet�s�ggel t�r vissza	
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
		
		// fapados magyar d�tum :P
		$badDays = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
		$goodDays = array("h�tf�", "kedd", "szerda", "cs�t�rt�k", "p�ntek", "szombat", "vas�rnap");
		
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
		
		$subject = BW_CLIENT . " online foglal�si k�d";
		
		$body = "<p>Kedves <strong>$name</strong>!</p>\n"
					. "<p>Ezt a levelet a rendszer�nk automatikusan k�ldte Neked, mert weboldalunkon kereszt�l ig�nyelted az online foglal�shoz sz�ks�ges k�dot.</p>\n"
					. "<p>A(z) $email emailc�mhez tartoz� foglal�si k�d: <strong>$id</strong></p>"
					. "<p>Ha a <a href=\"" . BW_WEBPAGE . "\">"  . BW_WEBPAGE .  "</a> weboldalon bejelentkezel, az Adatlapon az 'adatok m�dos�t�sa' linkre kattintva el�j�v� �rlapon ezt a sz�mot kell be�rnod a Foglal�si k�d mez�be.</p>\n"
					. "<p>Miut�n ezzel a k�ddal �les�tetted a felhaszn�l�i adatlapod, haszn�lhatod az online foglal�si rendszert.</p>\n"
					. "<p>�dv�zlettel,</p>\n"
					. "<p><a href=\"" . BW_WEBPAGE . "\">" . BW_CLIENT . "</a></p>\n";
		
		return $this->SendMail($from, $to, $subject, $body);
	}

	function SendErrorEmail($message)
	{
		$from = array('name' => BW_CLIENT, 'email' => BW_EMAIL);
		$toto = array(
							array('name' => "kgyt", 'email' => 'cbafitness@kgyt.hu'),
						);
		
		$subject = BW_CLIENT . " hiba az online foglal�si rendszerben";
		
		$body = "<p>Kedves <strong>$name</strong>!</p>\n"
					. "<p>Ezt a levelet a rendszer�nk automatikusan k�ldte Neked, hogy figyelmeztessen az online foglal�si rendszer haszn�lata sor�n fell�pett hib�ra.</p>\n"
					. "<p>A hiba a k�vetkez�: </p>"
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
				return '(Nincs defini�lva)';
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
						$text = "Felhaszn�l� adatai �rv�nyesek";
					break;
					case 1:
						$text = "Nincsen ilyen felhaszn�l�.";
					break;
					case 2:
						$text = "A felhaszn�l�nak nincsen �rv�nyes foly�sz�ml�ja.";
					break;
				}
			break;
			case 'WSP_FEDEZET_ELLENORZES':
				switch ($return)
				{
					case 0:
						$text = "A felhaszn�l� foglalhat az �r�ra.";
					break;
					case 1:
						$text = "Hib�s k�d vagy felhaszn�l�n�v.";
					break;
					case 2:
						$text = "A felhaszn�l�nak nincsen nyitott foly�sz�ml�ja, nem foglalhat.";
					break;
					case 3:
						$text = "�rv�nytelen id�pont.";
					break;
					case 4:
						$text = "�rv�nytelen hely.";
					break;
					case 5:
						$text = "�rv�nytelen cikk.";
					break;
					case 6:
						$text = "�rv�nytelen kombin�ci�ja a param�tereknek (kezdes + hely + cikk).";
					break;
					case 7:
						$text = "Minden �rv�nyes, de a felhaszn�l� nem foglalhat fedezethi�ny miatt erre az �r�ra.";
					break;
					case 8:
						$text = "Minden �rv�nyes, de az adott id�pontban m�r nincs szabad hely.";
					break;
				}
			break;*/
			case 'WSP_FOGLALAST_HOZZAAD':
				switch ($return)
				{
					case 0:
						$text = "Sikeres foglal�s.";
					break;
					case 1:
						$text = "Foglal�s sikertelen, bels� hiba l�pett fel. Hibak�d: 1 (Hib�s k�d vagy felhaszn�l�n�v)";
					break;
					case 2:
						$text = "Foglal�s sikertelen, nincsen nyitott foly�sz�ml�d.";
					break;
					case 3:
						$text = "Foglal�s sikertelen, bels� hiba l�pett fel. Hibak�d: 3 (�rv�nytelen id�pont)";
					break;
					case 4:
						$text = "Foglal�s sikertelen, bels� hiba l�pett fel. Hibak�d: 4 (�rv�nytelen hely)";
					break;
					case 5:
						$text = "Foglal�s sikertelen, bels� hiba l�pett fel. Hibak�d: 5 (�rv�nytelen cikk)";
					break;
					case 6:
						$text = "Foglal�s sikertelen, bels� hiba l�pett fel. Hibak�d: 6 (�rv�nytelen kombin�ci�ja a param�tereknek)";
					break;
					case 7:
						$text = "Foglal�s sikertelen, fedezethi�ny miatt nem foglalhatsz erre az �r�ra.";
					break;
					case 8:
						$text = "Foglal�s sikertelen, nincsen szabad hely az �r�n.";
					break;
					case 9:
						$text = "Sikeres foglal�s, de csak el�jegyz�s st�tusszal.";
					break;
					case 10:
						$text = "Erre az �r�ra m�r van foglal�sod.";
					break;
				}
			break;
			case 'WSP_FOGLALAST_TOROL':
				switch ($return)
				{
					case 0:
						$text = "Siker�lt t�r�lni a foglal�st.";
					break;
					case 1:
						$text = "T�rl�s sikertelen, bels� hiba l�pett fel. Hibak�d: 1 (�rv�nytelen felhaszn�l�)";
					break;
					case 2:
						$text = "T�rl�s sikertelen, bels� hiba l�pett fel. Hibak�d: 2 (�rv�nytelen id�pont)";
					break;
					case 3:
						$text = "T�rl�s sikertelen, bels� hiba l�pett fel. Hibak�d: 3 (�rv�nytelen hely)";
					break;
					case 4:
						$text = "T�rl�s sikertelen, bels� hiba l�pett fel. Hibak�d: 4 (�rv�nytelen cikk)";
					break;
					case 5:
						$text = "T�rl�s sikertelen, bels� hiba l�pett fel. Hibak�d: 5 (�rv�nytelen param�terek)";
					break;
					case 6:
						$text = "T�rl�s sikertelen, nincs nyitott foly�sz�ml�d.";
					break;
				}
			break;
		}

		//$text = $time . " <strong>" . $procedure . "</strong> (k�d " . $return . ") " . $text;
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