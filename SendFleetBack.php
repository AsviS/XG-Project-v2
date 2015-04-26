<?php

/**
 * @package		XG Project
 * @copyright	Copyright (c) 2008 - 2015
 * @license		http://opensource.org/licenses/gpl-3.0.html	GPL-3.0
 * @since		Version 2.10.0
 */

define('INSIDE'  , TRUE);
define('INSTALL' , FALSE);
define('XGP_ROOT',	'./');

include(XGP_ROOT . 'global.php');

if ( is_numeric($_POST['fleetid']) )
{
	$fleetid  = intval($_POST['fleetid']);
	$FleetRow = doquery("SELECT * FROM {{table}} WHERE `fleet_id` = '". $fleetid ."';", 'fleets', TRUE);
	$i = 0;

	if ($FleetRow['fleet_owner'] == $user['id'])
	{
		//now we can call back the ships in maintaing position (2).
		if ($FleetRow['fleet_mess'] == 0 || $FleetRow['fleet_mess'] == 2)
		{
			if ($FleetRow['fleet_group'] > 0)
			{
				$Aks = doquery("SELECT teilnehmer FROM {{table}} WHERE id = '". $FleetRow['fleet_group'] ."';", 'aks', TRUE);
				if ($Aks['teilnehmer'] == $FleetRow['fleet_owner'] AND $FleetRow['fleet_mission'] == 1)
				{
					doquery ("DELETE FROM {{table}} WHERE id ='". $FleetRow['fleet_group'] ."';", 'aks');
					doquery ("UPDATE {{table}} SET `fleet_group` = '0' WHERE `fleet_group` = '". $FleetRow['fleet_group'] ."';", 'fleets');
				}
				if ($FleetRow['fleet_mission'] == 2)
				{
					doquery ("UPDATE {{table}} SET `fleet_group` = '0' WHERE `fleet_id` = '".  $fleetid ."';", 'fleets');
				}
			}

			$CurrentFlyingTime = time() - $FleetRow['start_time'];

			/*** start fix by jstar ***/
			//the fleet time duration between 2 planet, it is equal for go and return when maintaining time=0
			$fleetLeght	=	$FleetRow['fleet_start_time'] - $FleetRow['start_time'];
			//the return time when you press "call back ships"
			$ReturnFlyingTime  =
			//if the ships mission is maintaining position and they are already in target pianet
			( $FleetRow['fleet_end_stay'] != 0 && $CurrentFlyingTime > $fleetLeght )
			//then the return time is the $fleetLeght + the current time in maintaining position
			  ? $fleetLeght + time()
			// else normal mission
			  : $CurrentFlyingTime + time();
			/***end fix by jstar***/

			$QryUpdateFleet  = "UPDATE {{table}} SET ";
			$QryUpdateFleet .= "`fleet_start_time` = '". (time() - 1) ."', ";
			$QryUpdateFleet .= "`fleet_end_stay` = '0', ";
			$QryUpdateFleet .= "`fleet_end_time` = '". ($ReturnFlyingTime + 1) ."', ";
			$QryUpdateFleet .= "`fleet_target_owner` = '". $user['id'] ."', ";
			$QryUpdateFleet .= "`fleet_mess` = '1' ";
			$QryUpdateFleet .= "WHERE ";
			$QryUpdateFleet .= "`fleet_id` = '" . $fleetid . "';";
			doquery( $QryUpdateFleet, 'fleets');
		}
	}
}
header("location:game.php?page=fleet");
?>
