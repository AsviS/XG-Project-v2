<?php

/**
 * @package		XG Project
 * @copyright	Copyright (c) 2008 - 2015
 * @license		http://opensource.org/licenses/gpl-3.0.html	GPL-3.0
 * @since		Version 2.10.0
 */

if(!defined('INSIDE')){ die(header("location:../../"));}

	function IsElementBuyable ($CurrentUser, $CurrentPlanet, $Element, $Incremental = TRUE, $ForDestroy = FALSE)
	{
		global $pricelist, $resource;

		include_once(XGP_ROOT . 'includes/functions/IsVacationMode.php');

	    if (IsVacationMode($CurrentUser))
	       return FALSE;

		if ($Incremental)
			$level  = (isset($CurrentPlanet[$resource[$Element]])) ? $CurrentPlanet[$resource[$Element]] : $CurrentUser[$resource[$Element]];

		$RetValue = TRUE;
		$array    = array('metal', 'crystal', 'deuterium', 'energy_max');

		foreach ($array as $ResType)
		{
			if (isset($pricelist[$Element][$ResType]) && $pricelist[$Element][$ResType] != 0)
			{
				if ($Incremental)
					$cost[$ResType]  = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
				else
					$cost[$ResType]  = floor($pricelist[$Element][$ResType]);

				if ($ForDestroy)
					$cost[$ResType]  = floor($cost[$ResType] / 4);

				if ($cost[$ResType] > $CurrentPlanet[$ResType])
					$RetValue = FALSE;
			}
		}
		return $RetValue;
	}

?>
