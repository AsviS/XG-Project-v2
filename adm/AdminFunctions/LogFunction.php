<?php

/**
 * @package		XG Project
 * @copyright	Copyright (c) 2008 - 2014
 * @license		http://opensource.org/licenses/gpl-3.0.html	GPL-3.0
 * @since		Version 2.10.0
 */

if(!defined('INSIDE')){ die(header("location:../../"));}

if ( $user['authlevel'] < 1 )
{
	die();
}

function LogFunction ( $Text , $Estado , $LogCanWork )
{
	global $lang;

	$Archive	=	"../adm/Log/" . $Estado . ".php";

	if ( $LogCanWork == 1 )
	{
		if ( !file_exists ( $Archive ) )
		{
			fopen ( $Archive , "w+" );
			fclose ( fopen ( $Archive , "w+" ) );
		}

		$FP		 =	fopen ( $Archive , "r+" );
		$Date	 =	$Text;
		$Date	.=	$lang['log_operation_succes'];
		$Date	.=	date ( "d-m-Y H:i:s" , time() ) . "\n";

		fputs ( $FP , $Date );
		fclose ( $FP );
	}
}

?>
