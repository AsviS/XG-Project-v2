<?php

/**
 * @package		XG Project
 * @copyright	Copyright (c) 2008 - 2015
 * @license		http://opensource.org/licenses/gpl-3.0.html	GPL-3.0
 * @since		Version 2.10.0
 */

if(!defined('INSIDE')){ die(header("location:../../"));}

class ShowBannedPage
{
	function ShowBannedPage()
	{
		global $lang;

		$parse	= $lang;
		$query	= doquery ( "SELECT * FROM {{table}} ORDER BY `id`;" , 'banned' );

		$i 				= 0;
		$subTemplate	= gettemplate ( 'banned/banned_row' );

		while ( $u = mysql_fetch_array ( $query ) )
		{
			$parse['player']	= $u[1];
			$parse['reason']	= $u[2];
			$parse['since']		= date ( "d/m/Y G:i:s" , $u[4] );
			$parse['until']		= date ( "d/m/Y G:i:s" , $u[5] );
			$parse['by']		= $u[6];

			$i++;

			$body .= parsetemplate ( $subTemplate , $parse );
		}

		if ( $i == 0 )
		{
			$parse['banned_msg']	.= $lang['bn_no_players_banned'];
		}
		else
		{
			$parse['banned_msg']	.= $lang['bn_exists'] . $i . $lang['bn_players_banned'];
		}

		$parse['banned_players']	= $body;

		display ( parsetemplate ( gettemplate ( 'banned/banned_body' ) , $parse ) );
	}
}
?>
