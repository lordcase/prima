<?php

//define('STAT_DEFAULT_MONTH', '2007-05');
$ym = "";
$where = "";


class bwStat {

  var $ym;
  var $where;

  function bwStat()
  {
    global $POST;

    $this->ym = $POST->Item('stat_month', date('Y-m'));
    $this->where = $this->ym2where($this->ym);
  }


  function GetVisitsRow()
  {
    /****************************************************************************/
    /* Lek�rdezi a $where felt�telnek megfelel� id�szakra vonatkoz�             */
    /* �sszes oldallet�lt�st �s egyedi l�togat�kat.                             */
    /* row[0] = �sszes oldallet�lt�s; [1] = egyedi l�togat�k                    */
    /* v1.3: added trace code                                                   */
    /****************************************************************************/
  
    global $database;
  
    $sql = "SELECT COUNT(*), COUNT(DISTINCT remote_addr) "
         . " FROM " . TBL_VISIT 
         . " WHERE " . $this->where . " ";
  
    if($database->Query($sql))
    {
      $row = $database->FetchRow();
    }
    else
    {
      $row = false;
    }
  
    return $row;
  
  } 


  function GetDailyVisits()
  {
    /****************************************************************************/
    /* Lek�rdezi a $where felt�telnek megfelel� id�szakra vonatkoz�             */
    /* �sszes oldallet�lt�st �s egyedi l�togat�kat,napi bont�sban               */
    /* Adatb�zis-er�forr�st ad vissza, a k�vetkez� sorokkal:                    */
    /* row[0] = d�tum; row[1] = �sszes oldallet�lt�s; [2] = egyedi l�togat�k    */
    /****************************************************************************/
  
    global $database;  
  
    $sql = "SELECT date, COUNT(*) c, COUNT(DISTINCT remote_addr) cd"
         . " FROM " . TBL_VISIT 
         . " WHERE " . $this->where 
         . " GROUP BY date "
         . " ORDER BY date ASC ";
  
    $database->Query($sql);
  
    return $database->GetResource();
  
  }

 

  function GetPageVisits($orderBy = "c DESC", $limit = "10")
  {
    /****************************************************************************/
    /* Lek�rdezi a $where felt�telnek megfelel� id�szakra vonatkoz�             */
    /* �sszes oldallet�lt�st �s egyedi l�togat�kat,napi bont�sban               */
    /* Adatb�zis-er�forr�st ad vissza, a k�vetkez� sorokkal:                    */
    /* row[0] = d�tum; row[1] = �sszes oldallet�lt�s; [2] = egyedi l�togat�k    */
    /****************************************************************************/
  
    global $database;  
  
    $sql = "SELECT page, COUNT(*) c, COUNT(DISTINCT remote_addr) cd "
         . " FROM " . TBL_VISIT 
         . " WHERE " . $this->where 
         . " GROUP BY page"
         . " ORDER BY $orderBy LIMIT $limit ";
  
    $database->Query($sql);
  
    return $database->GetResource();
  }



  function GetVisitors($orderBy = "c DESC", $limit = "10")
  {
    /****************************************************************************/
    /* Lek�rdezi a $where felt�telnek megfelel� id�szakra vonatkoz�             */
    /* �sszes oldallet�lt�st �s egyedi l�togat�kat,napi bont�sban               */
    /* Adatb�zis-er�forr�st ad vissza, a k�vetkez� sorokkal:                    */
    /* row[0] = IP c�m; row[1] = �sszes oldallet�lt�s                           */
    /****************************************************************************/
  
    global $database;  
  
    $sql = "SELECT DISTINCT remote_addr, COUNT(*) c "
         . " FROM " . TBL_VISIT 
         . " WHERE " . $this->where 
         . " GROUP BY remote_addr "
         . " ORDER BY $orderBy LIMIT $limit ";
  
    $database->Query($sql);
  
    return $database->GetResource();
  
  }



  function FormatVisitors_0($remote_addr)
  {
    return gethostbyaddr($remote_addr);
  }



  function GetReferers($orderBy = "c DESC", $limit = "10")
  {
    /****************************************************************************/
    /* Lek�rdezi a $where felt�telnek megfelel� id�szakra vonatkoz�             */
    /* �sszes egyedi HTTP Referer-t (k�ls� oldalr�l mutat� linket)              */
    /* Adatb�zis-er�forr�st ad vissza, a k�vetkez� sorokkal:                    */
    /* row[0] = HTTP Referer c�me; row[1] = �sszes kattint�s; row[2] = egyedi   */
    /****************************************************************************/
  
    global $database;  

    $sql = "SELECT http_referer, COUNT(*) c, COUNT(DISTINCT remote_addr) cd "
         . " FROM " . TBL_VISIT
         . " WHERE " . $this->where
         . " GROUP BY http_referer "
         . " HAVING http_referer NOT IN ('local', '')"
         . " ORDER BY $orderBy LIMIT $limit ";
  
    $database->Query($sql);
  
    return $database->GetResource();
  }



  function ym2where($ym)
  {
    /****************************************************************************/
    /* ����-HH form�tum� d�tumot konvert�l SQL WHERE-defin�ci� form�tumra       */
    /****************************************************************************/
  
    $where = "date BETWEEN '" . $ym . "-01' AND '" . $ym . "-31'";
    return $where;
  
  }


  function GetMonthOptions($firstYear, $firstMonth)
  {
    /****************************************************************************/
    /* Az �sszes h�napot tartalmaz� <option>...</option> sort adja vissza.      */
    /****************************************************************************/
  
    if(!is_integer($firstYear) || ($firstYear < 2006)) $firstYear = 2006;
    if(!is_integer($firstMonth) || ($firstMonth < 1) || ($firstMonth > 12)) $firstMonth = 1;
  
    $lastYear = date("Y");
    $lastMonth = date("m");
  
    $html = "";
  
    for($year = $firstYear; $year<=$lastYear; $year++)
    {
      $monthMax = ($year == $lastYear) ? intval($lastMonth) : 12;
      for($month = ($year == $firstYear) ? $firstMonth : 1; $month <= $monthMax; $month++)
      {
        $value = ($month <= 9) ? ($year . "-0" . $month) : ($year . "-" . $month);
        $selectedHtml = ($this->ym == $value) ? " selected=\"selected\"" : "";
  
        $html .= "<option value=\"" . $value .  "\"" . $selectedHtml . ">" . strftime("%Y. %B", strtotime($year . "-" . $month . "-01")) . "</option>\n";
      }
    }
  
    return $html;
  }

}

$stat = new bwStat();

?>
