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
    /* Lekérdezi a $where feltételnek megfelelõ idõszakra vonatkozó             */
    /* összes oldalletöltést és egyedi látogatókat.                             */
    /* row[0] = összes oldalletöltés; [1] = egyedi látogatók                    */
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
    /* Lekérdezi a $where feltételnek megfelelõ idõszakra vonatkozó             */
    /* összes oldalletöltést és egyedi látogatókat,napi bontásban               */
    /* Adatbázis-erõforrást ad vissza, a következõ sorokkal:                    */
    /* row[0] = dátum; row[1] = összes oldalletöltés; [2] = egyedi látogatók    */
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
    /* Lekérdezi a $where feltételnek megfelelõ idõszakra vonatkozó             */
    /* összes oldalletöltést és egyedi látogatókat,napi bontásban               */
    /* Adatbázis-erõforrást ad vissza, a következõ sorokkal:                    */
    /* row[0] = dátum; row[1] = összes oldalletöltés; [2] = egyedi látogatók    */
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
    /* Lekérdezi a $where feltételnek megfelelõ idõszakra vonatkozó             */
    /* összes oldalletöltést és egyedi látogatókat,napi bontásban               */
    /* Adatbázis-erõforrást ad vissza, a következõ sorokkal:                    */
    /* row[0] = IP cím; row[1] = összes oldalletöltés                           */
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
    /* Lekérdezi a $where feltételnek megfelelõ idõszakra vonatkozó             */
    /* összes egyedi HTTP Referer-t (külsõ oldalról mutató linket)              */
    /* Adatbázis-erõforrást ad vissza, a következõ sorokkal:                    */
    /* row[0] = HTTP Referer címe; row[1] = összes kattintás; row[2] = egyedi   */
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
    /* ÉÉÉÉ-HH formátumú dátumot konvertál SQL WHERE-definíció formátumra       */
    /****************************************************************************/
  
    $where = "date BETWEEN '" . $ym . "-01' AND '" . $ym . "-31'";
    return $where;
  
  }


  function GetMonthOptions($firstYear, $firstMonth)
  {
    /****************************************************************************/
    /* Az összes hónapot tartalmazó <option>...</option> sort adja vissza.      */
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
