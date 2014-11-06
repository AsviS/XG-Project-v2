<?php

/**
 * @package		XG Project
 * @copyright	Copyright (c) 2008 - 2014
 * @license		http://opensource.org/licenses/gpl-3.0.html	GPL-3.0
 * @since		Version 2.10.0
 */

if(!defined('INSIDE')){ die(header("location:../../"));}

	function SetSelectedPlanet ( &$CurrentUser )
	{

		$SelectPlanet  = intval((isset($_GET['cp'])?$_GET['cp']:NULL));
		$RestorePlanet = intval((isset($_GET['re'])?$_GET['re']:NULL));

		// ADDED && $SelectPlanet != 0 THIS PREVENTS RUN A QUERY WHEN IT'S NOT NEEDED.
		if (isset($SelectPlanet) && is_numeric($SelectPlanet) && isset($RestorePlanet) && $RestorePlanet == 0 && $SelectPlanet != 0 )
		{
			$IsPlanetMine   = doquery("SELECT `id` FROM {{table}} WHERE `id` = '". $SelectPlanet ."' AND `id_owner` = '". intval($CurrentUser['id']) ."';", 'planets', TRUE);

			if ($IsPlanetMine)
			{
				$CurrentUser['current_planet'] = $SelectPlanet;
				doquery("UPDATE {{table}} SET `current_planet` = '". $SelectPlanet ."' WHERE `id` = '".intval($CurrentUser['id'])."';", 'users');
			}
		}
	}

?>