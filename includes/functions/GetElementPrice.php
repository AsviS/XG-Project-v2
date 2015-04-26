<?php

/**
 * @package		XG Project
 * @copyright	Copyright (c) 2008 - 2015
 * @license		http://opensource.org/licenses/gpl-3.0.html	GPL-3.0
 * @since		Version 2.10.0
 */

if(!defined('INSIDE')){ die(header("location:../../"));}

	function GetElementPrice ($user, $planet, $Element, $userfactor = TRUE, $level = FALSE)
	{
		global $pricelist, $resource, $lang;

		//if ($userfactor) // OLD CODE
		if ($userfactor && ($level === FALSE)) // FIX BY JSTAR
			$level = (isset($planet[$resource[$Element]])) ? $planet[$resource[$Element]] : $user[$resource[$Element]];

		$is_buyeable = TRUE;

		$array = array(
			'metal'      => $lang['Metal'],
			'crystal'    => $lang['Crystal'],
			'deuterium'  => $lang['Deuterium'],
			'energy_max' => $lang['Energy']
		);

		$text = $lang['fgp_require'];
		foreach ($array as $ResType => $ResTitle)
		{
			if (isset ( $pricelist[$Element][$ResType] ) && $pricelist[$Element][$ResType] != 0)
			{
				$text .= $ResTitle . ": ";
				if ($userfactor)
					$cost = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
				else
					$cost = floor($pricelist[$Element][$ResType]);

				if ($cost > $planet[$ResType])
				{
					$text .= "<b style=\"color:red;\"> <t title=\"-" . Format::pretty_number ($cost - $planet[$ResType]) . "\">";
					$text .= "<span class=\"noresources\">" . Format::pretty_number($cost) . "</span></t></b> ";
					$is_buyeable = FALSE;
				}
				else
					$text .= "<b style=\"color:lime;\">" . Format::pretty_number($cost) . "</b> ";
			}
		}
		return $text;
	}
?>
