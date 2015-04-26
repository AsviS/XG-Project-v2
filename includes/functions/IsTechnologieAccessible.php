<?php

/**
 * @package		XG Project
 * @copyright	Copyright (c) 2008 - 2015
 * @license		http://opensource.org/licenses/gpl-3.0.html	GPL-3.0
 * @since		Version 2.10.0
 */

if(!defined('INSIDE')){ die(header("location:../../"));}

	function IsTechnologieAccessible($user, $planet, $Element)
	{
		global $requeriments, $resource;

		if (isset($requeriments[$Element]))
		{
			$enabled = TRUE;

			foreach($requeriments[$Element] as $ReqElement => $EleLevel)
			{
				if (@$user[$resource[$ReqElement]] && $user[$resource[$ReqElement]] >= $EleLevel)
				{
					//BREAK
				}
				elseif (isset($planet[$resource[$ReqElement]]) && $planet[$resource[$ReqElement]] >= $EleLevel)
				{
					$enabled = TRUE;
				}
				else
				{
					return FALSE;
				}
			}
			return $enabled;
		}
		else
		{
			return TRUE;
		}
	}
?>
