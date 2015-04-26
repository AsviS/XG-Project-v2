<?php

/**
 * @package		XG Project
 * @copyright	Copyright (c) 2008 - 2015
 * @license		http://opensource.org/licenses/gpl-3.0.html	GPL-3.0
 * @since		Version 2.10.0
 */

if(!defined('INSIDE')){ die(header("location:../../"));}

function UpdatePlanetBatimentQueueList ( &$CurrentPlanet, &$CurrentUser ) {

	$RetValue = FALSE;
	if ( $CurrentPlanet['b_building_id'] != 0 )
	{
		while ( $CurrentPlanet['b_building_id'] != 0 )
		{
			if ( $CurrentPlanet['b_building'] <= time() )
			{
				PlanetResourceUpdate ( $CurrentUser, $CurrentPlanet, $CurrentPlanet['b_building'], FALSE );
				$IsDone = CheckPlanetBuildingQueue( $CurrentPlanet, $CurrentUser );
				if ( $IsDone == TRUE )
					SetNextQueueElementOnTop ( $CurrentPlanet, $CurrentUser );
			}
			else
			{
				$RetValue = TRUE;
				break;
			}
		}
	}
	return $RetValue;
}

?>
