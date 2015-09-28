<?php

class bwDateTime {

	const START 	= 'START';
	const END 		= 'END';
	const NOW 		= 'NOW';

	function getDateController($id, $defaultYear, $defaultMonth, $defaultDay)
	{
		$html = self::getYearController($id, 0, 0, $defaultYear)
			  . ' '
			  . self::getMonthController($id, 0, 0, $defaultMonth)
			  . ' '
			  . self::getDayController($id, 0, 0, $defaultDay);
		
		return $html;
	}

	function getYearController($id, $start = 0, $end = 0, $default = 0)
	{
		$id = $id . "_year";
	
		if ($start == 0)
		{
			$start = date('Y');
		}
		
		if ($end == 0)
		{
			$start = date('Y') + 1;
		}

		if ($default == 0)
		{
			$default = start;
		}
		
		return self::getGenericController($id, $start, $end, $default, false);
	}

	function getMonthController($id, $start = 1, $end = 12, $default = 0)
	{
		$id = $id . "_month";
	
		if ($default == 0)
		{
			$default = date('n');
		}
		
		return self::getGenericController($id, $start, $end, $default, true);
	}


	function getDayController($id, $start = 1, $end = 31, $default = 0)
	{
		$id = $id . "_day";
	
		if ($default == 0)
		{
			$default = date('j');
		}
		
		return self::getGenericController($id, $start, $end, $default, false);
	}


	function getGenericController($id, $start, $end, $default = 1, $useMonthLabels = false)
	{
		$html = "<select name=\"" . $id . "\">\n";
		
		for ($i = $start; $i <= $end; $i++)
		{
			$html .= "<option value=\"" . $i . "\"" . (($i == $default) ? " selected=\"selected\"" : "") . ">" . ($useMonthLabels ? self::getMonthLabel($i) : $i) . "</option>\n";
		}
			  
		$html .= "</select>\n";
		
		return $html;
	}

	function getYearMonthController($id, $start = '', $end = '', $default = bwDateTime::START, $useMonthLabels = true)
	{
		$startYear = substr($start, 0, 4);
		$startMonth = substr($start, 5, 2);
		
		if (!checkdate(1, $startMonth, $startYear))
		{
			$startYear = date('Y');
			$startMonth = date('m');
		}

		$endYear = substr($end, 0, 4);
		$endMonth = substr($end, 5, 2);

		if( $endYear === '' ) {
			$endYear = date('Y');
		};
		if( $endMonth === '' ) {
			$endMonth = date('m');
		};
		
		if (!checkdate(1, $endMonth, $endYear))
		{
			$endYear = date('Y');
			$endMonth = date('m');
		}
		
		if ($startYear > $endYear)
		{
			$endYear = $startYear;
		}
		
		if (($startYear == $endYear) && ($startMonth > $endMonth))
		{
			$endMonth = $startMonth;
		}

		switch ($default)
		{
			case bwDateTime::START :
				$default = $startYear . '-' . $startMonth;
				break;
			case bwDateTime::END :
				$default = $endYear . '-' . $endMonth;
				break;
			case bwDateTime::NOW :
				$default = date('Y-m');
				break;
		}
		
		$id .= '_yearmonth';
	
		$html = "<select name=\"" . $id . "\">\n";
		
		for ($i = $startYear; $i <= $endYear; $i++)
		{
			for ($j = (($i == $startYear) ? $startMonth : 1); $j <= (($i == $endYear) ? $endMonth : 12); $j++)
			{
				$jj = ($j < 10) ? ('0' . $j) : $j;
				$html .= "<option value=\"" . $i . '-' . $jj . "\"" . ((($i . '-' . $jj) == $default) ? " selected=\"selected\"" : "") . ">" . $i . ' ' .  ($useMonthLabels ? self::getMonthLabel($j) : $jj) . "</option>\n";
			}
		}
			  
		$html .= "</select>\n";
		
		return $html;
	}

	
	function getPostedYear($id)
	{
		return self::getPostedGenericValue($id . '_year');
	}

	function getPostedMonth($id)
	{
		return self::getPostedGenericValue($id . '_month');
	}

	function getPostedDay($id)
	{
		return self::getPostedGenericValue($id . '_day');
	}

	function getPostedGenericValue($id)
	{
		return isset($_POST[$id]) ? intval($_POST[$id]) : 0;
	}
	
	function getPostedDate($id)
	{
		return self::getPostedYear($id) . '-' . self::getPostedMonth($id) . '-' . self::getPostedDay($id);
	}
	
	function getPostedYearMonth($id)
	{
		$id .= '_yearmonth';
		return isset($_POST[$id]) ? $_POST[$id] : '';
	}
	
	function getYearFromPostedYearMonth($id)
	{
		return substr(self::getPostedYearMonth($id), 0, 4);
	}
	
	function getMonthFromPostedYearMonth($id)
	{
		return substr(self::getPostedYearMonth($id), 5, 2);
	}
	
	function isPostedDateValid($id)
	{
		return checkdate(self::getPostedDay($id), self::getPostedMonth($id), self::getPostedYear($id));
	}

	function isPostedYearMonthValid($id)
	{
		return checkdate(1, self::getMonthFromPostedYearMonth($id), self::getYearFromPostedYearMonth($id));
	}
	
	function getMonthLabel($month)
	{
		$labels = array('', 'január', 'február', 'március', 'április', 'május', 'június', 'július', 'augusztus', 'szeptember', 'október', 'november', 'december');

		return isset($labels[intval($month)]) ? $labels[intval($month)] : $month;
	
	}


}

?>