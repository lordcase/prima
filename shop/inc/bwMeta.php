<?php

// bwMeta
// ------

// $meta object is used for manipulating HTML META data.

// Copyright 2007 anaiz
// http://www.anaiz.hu
// info@anaiz.hu
// all rights reserved


class bwMeta {

  var $sectionId;
  var $title;
  var $keywords;
  var $description;
  
  function bwMeta()
  {
    $this->sectionId = '';
    $this->title = 'CBA Fitness és Wellness line';
    $this->keywords = 'fitness, wellness, terem, edzõterem, konditerem';
    $this->description = '';
  }

  function SetMeta($section, $lang = "hu")
  {
    $this->sectionId = $section;
		
		switch ($lang)
		{
			case 'en':
				$this->setEnglishMeta($section);
				break;
			case 'hu':
			default:
				$this->setDefaultMeta($section);
				break;
		}
  }
	
	function setDefaultMeta($section)
	{
    switch($section)
    {
      case 'aerobic':
        $this->SetTitle('Aerobic, Spinning');
        $this->AddKeywords(array('Kangoo Jumps', 'Pilates', 'táncterápia', 'kick box', 'spinning', 'alakformáló', 'zsírégetõ', 'step', 'aerobic'));
      break;
      case 'akciok':
        $this->SetTitle('Akciók');
        $this->AddKeywords(array('akció', 'nyeremény', 'kedvezmény'));
      break;
      case 'arak':
        $this->SetTitle('Árak');
        $this->AddKeywords(array('ingyenes szolgáltatások', 'bérlet', 'tagság', 'árlista'));
      break;
      case 'felhasznalo':
        $this->SetTitle('Felhasználó');
      break;
      case 'fitness':
        $this->SetTitle('Fitness');
        $this->AddKeywords(array('Kangoo Jumps', 'Pilates', 'táncterápia', 'kick box', 'spinning', 'alakformáló', 'zsírégetõ', 'step', 'aerobic'));
      break;
      case 'fittbar':
        $this->SetTitle('Fitt Bár');
        $this->AddKeywords(array('egészséges táplálkozás', 'étrendkiegészítõk', 'fogyókúra', 'étrend', 'bár'));
      break;
      case 'galeria':
        $this->SetTitle('Képgaléria');
        $this->AddKeywords(array('kép', 'fotó', 'masszázs', 'pezsgõfürdõ', 'squash'));
      break;
      case 'gyerekmegorzo':
        $this->SetTitle('Gyerekmegõrzõ');
        $this->AddKeywords(array('gyermekmegõrzõ', 'gyerekfelügyelet', 'gyerekgondozó', 'kisgyerek'));
      break;
      case 'kapcsolat':
        $this->SetTitle('Kapcsolat');
        $this->AddKeywords(array('nyitva tartás', '10. kerület', 'Gyömrõi út', 'telefon'));
      break;
      case 'klubkartya':
        $this->SetTitle('Klubkártya');
        $this->AddKeywords(array('ajándék', 'exkluzív', 'VIP', 'kártya'));
      break;
      case 'masszazs':
        $this->SetTitle('Masszázs');
        $this->AddKeywords(array('relax', 'gyógymasszázs', 'talpmasszázs', 'egészség'));
      break;
      case 'orarend':
        $this->SetTitle('Órarend');
        $this->AddKeywords(array('órarend', 'step', 'spinning', 'aerobic'));
      break;
      case 'programok':
        $this->SetTitle('Programok');
        $this->AddKeywords(array('aktuális', 'program', 'hétvége', 'családi'));
      break;
      case 'squash':
        $this->SetTitle('Squash');
        $this->AddKeywords(array('szabály', 'pálya', 'leírás', 'fallabda'));
      break;
      case 'szauna':
        $this->SetTitle('Szauna');
        $this->AddKeywords(array('infrakabin', 'infraszauna', 'gõz', 'egészség'));
      break;
      case 'szepsegapolas':
        $this->SetTitle('Szépségápolás');
        $this->AddKeywords(array('fodrász', 'kozmetikus', 'mûköröm'));
      break;
      case 'szolarium':
        $this->SetTitle('Szolárium');
        $this->AddKeywords(array('szoli', 'solarium', 'gyorsbarnító'));
      break;
      case 'tanacsadas':
        $this->SetTitle('Tanácsadás');
        $this->AddKeywords(array('állapotfelmérés', 'felmérés', 'tanácsok'));
      break;
      case 'vendegkonyv':
        $this->SetTitle('Vendégkönyv');
        $this->AddKeywords(array('tanácsadás', 'kapcsolat', 'kérdés', 'FAQ'));
      break;
      case 'wellness':
        $this->SetTitle('Wellness');
        $this->AddKeywords(array('welness', 'welnes', 'wellnes'));
      break;
    }
  }

	function setEnglishMeta($section)
	{
    switch($section)
    {
      case 'index':
        $this->SetEnglishTitle('Welcome');
      break;
      case 'arak':
        $this->SetEnglishTitle('Prices');
        $this->AddKeywords(array('free services', 'ticket', 'membership', 'price list'));
      break;
      case 'fitness':
        $this->SetEnglishTitle('Fitness Room');
        $this->AddKeywords(array('Kangoo Jumps', 'Pilates', 'dance therapy', 'kick box', 'spinning', 'step', 'aerobic'));
      break;
      case 'galeria':
        $this->SetEnglishTitle('Gallery');
        $this->AddKeywords(array('picture', 'photo', 'massage', 'video', 'squash'));
      break;
      case 'kapcsolat':
        $this->SetEnglishTitle('Contact');
        $this->AddKeywords(array('opening hours', 'Budapest', 'Gyömrõi street', 'phone number'));
      break;
      case 'squash':
        $this->SetEnglishTitle('Squash');
        $this->AddKeywords(array('rules', 'court', 'description', 'squash'));
      break;
      case 'wellness':
        $this->SetEnglishTitle('Wellness');
        $this->AddKeywords(array('welness', 'welnes', 'wellnes'));
      break;
    }
  }

  function SetTitle($title)
  {
    $this->title = 'CBA Fitness és Wellness line - ' . $title;
  }

  function SetEnglishTitle($title)
  {
    $this->title = 'CBA Fitness and Wellness line - ' . $title;
  }


  function SetKeywords($keywords)
  {
    $this->keywords = $keywords;
  }
  
  function AddKeywords($keywords)
  {
    if(is_array($keywords))
    {
      foreach($keywords as $keyword)
      {
        $this->AddKeywords($keyword);
      }
    }
    else
    {
      if($this->keywords != '')
      {
        $this->keywords .= ', ';
      }
      $this->keywords .= $keywords;
    }
  }
  
  function SetDescription($description)
  {
    $this->description = $description;
  }

}

$meta = new bwMeta;

?>
