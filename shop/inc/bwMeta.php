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
    $this->title = 'CBA Fitness �s Wellness line';
    $this->keywords = 'fitness, wellness, terem, edz�terem, konditerem';
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
        $this->AddKeywords(array('Kangoo Jumps', 'Pilates', 't�ncter�pia', 'kick box', 'spinning', 'alakform�l�', 'zs�r�get�', 'step', 'aerobic'));
      break;
      case 'akciok':
        $this->SetTitle('Akci�k');
        $this->AddKeywords(array('akci�', 'nyerem�ny', 'kedvezm�ny'));
      break;
      case 'arak':
        $this->SetTitle('�rak');
        $this->AddKeywords(array('ingyenes szolg�ltat�sok', 'b�rlet', 'tags�g', '�rlista'));
      break;
      case 'felhasznalo':
        $this->SetTitle('Felhaszn�l�');
      break;
      case 'fitness':
        $this->SetTitle('Fitness');
        $this->AddKeywords(array('Kangoo Jumps', 'Pilates', 't�ncter�pia', 'kick box', 'spinning', 'alakform�l�', 'zs�r�get�', 'step', 'aerobic'));
      break;
      case 'fittbar':
        $this->SetTitle('Fitt B�r');
        $this->AddKeywords(array('eg�szs�ges t�pl�lkoz�s', '�trendkieg�sz�t�k', 'fogy�k�ra', '�trend', 'b�r'));
      break;
      case 'galeria':
        $this->SetTitle('K�pgal�ria');
        $this->AddKeywords(array('k�p', 'fot�', 'massz�zs', 'pezsg�f�rd�', 'squash'));
      break;
      case 'gyerekmegorzo':
        $this->SetTitle('Gyerekmeg�rz�');
        $this->AddKeywords(array('gyermekmeg�rz�', 'gyerekfel�gyelet', 'gyerekgondoz�', 'kisgyerek'));
      break;
      case 'kapcsolat':
        $this->SetTitle('Kapcsolat');
        $this->AddKeywords(array('nyitva tart�s', '10. ker�let', 'Gy�mr�i �t', 'telefon'));
      break;
      case 'klubkartya':
        $this->SetTitle('Klubk�rtya');
        $this->AddKeywords(array('aj�nd�k', 'exkluz�v', 'VIP', 'k�rtya'));
      break;
      case 'masszazs':
        $this->SetTitle('Massz�zs');
        $this->AddKeywords(array('relax', 'gy�gymassz�zs', 'talpmassz�zs', 'eg�szs�g'));
      break;
      case 'orarend':
        $this->SetTitle('�rarend');
        $this->AddKeywords(array('�rarend', 'step', 'spinning', 'aerobic'));
      break;
      case 'programok':
        $this->SetTitle('Programok');
        $this->AddKeywords(array('aktu�lis', 'program', 'h�tv�ge', 'csal�di'));
      break;
      case 'squash':
        $this->SetTitle('Squash');
        $this->AddKeywords(array('szab�ly', 'p�lya', 'le�r�s', 'fallabda'));
      break;
      case 'szauna':
        $this->SetTitle('Szauna');
        $this->AddKeywords(array('infrakabin', 'infraszauna', 'g�z', 'eg�szs�g'));
      break;
      case 'szepsegapolas':
        $this->SetTitle('Sz�ps�g�pol�s');
        $this->AddKeywords(array('fodr�sz', 'kozmetikus', 'm�k�r�m'));
      break;
      case 'szolarium':
        $this->SetTitle('Szol�rium');
        $this->AddKeywords(array('szoli', 'solarium', 'gyorsbarn�t�'));
      break;
      case 'tanacsadas':
        $this->SetTitle('Tan�csad�s');
        $this->AddKeywords(array('�llapotfelm�r�s', 'felm�r�s', 'tan�csok'));
      break;
      case 'vendegkonyv':
        $this->SetTitle('Vend�gk�nyv');
        $this->AddKeywords(array('tan�csad�s', 'kapcsolat', 'k�rd�s', 'FAQ'));
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
        $this->AddKeywords(array('opening hours', 'Budapest', 'Gy�mr�i street', 'phone number'));
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
    $this->title = 'CBA Fitness �s Wellness line - ' . $title;
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
