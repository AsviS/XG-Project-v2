<?php

/**
 * @package		XG Project
 * @copyright	Copyright (c) 2008 - 2015
 * @license		http://opensource.org/licenses/gpl-3.0.html	GPL-3.0
 * @since		Version 2.10.0
 */

if(!defined('INSIDE')){ die(header("location:../../"));}

	function GetBuildingPrice ($CurrentUser, $CurrentPlanet, $Element, $Incremental = TRUE, $ForDestroy = FALSE)
	{
		global $pricelist, $resource;

		if ($Incremental)
			$level = (isset($CurrentPlanet[$resource[$Element]])) ? $CurrentPlanet[$resource[$Element]] : $CurrentUser[$resource[$Element]];

		$array = array('metal', 'crystal', 'deuterium', 'energy_max');
		foreach ($array as $ResType)
		{
			if ( isset ( $pricelist[$Element][$ResType] ) )
			{
				if ($Incremental)
					$cost[$ResType] = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
				else
					$cost[$ResType] = floor($pricelist[$Element][$ResType]);

				if ($ForDestroy == TRUE)
				{
					$cost[$ResType]  = floor($cost[$ResType]) / 2;
					$cost[$ResType] /= 2;
				}
			}
		}

		return $cost;
	}
?>
