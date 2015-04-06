<?php

/**
 * @package		XG Project
 * @copyright	Copyright (c) 2008 - 2014
 * @license		http://opensource.org/licenses/gpl-3.0.html	GPL-3.0
 * @since		Version 2.10.0
 */

if(!defined('INSIDE')){ die(header("location:../../"));}

	function SendSimpleMessage($Owner, $Sender, $Time, $Type, $From, $Subject, $Message)
	{

		if ($Time == '')
		{
			$Time = time();
		}

		$Message = (strpos($Message, "/adm/") === FALSE ) ? $Message : "";

		$Message = mysql_escape_value($inp);


		$QryInsertMessage  = "INSERT INTO {{table}} SET ";
		$QryInsertMessage .= "`message_owner` 	= '". $Owner	."', ";
		$QryInsertMessage .= "`message_sender` 	= '". $Sender	."', ";
		$QryInsertMessage .= "`message_time` 	= '". $Time 	."', ";
		$QryInsertMessage .= "`message_type` 	= '". $Type 	."', ";
		$QryInsertMessage .= "`message_from` 	= '". $From 	."', ";
		$QryInsertMessage .= "`message_subject` = '". mysql_escape_value($Subject)  ."', ";
		$QryInsertMessage .= "`message_text` 	= '". mysql_escape_value($Message) 	."';";

		doquery( $QryInsertMessage, 'messages');

		$QryUpdateUser  = "UPDATE `{{table}}` SET ";
		$QryUpdateUser .= "`new_message` = `new_message` + 1 ";
		$QryUpdateUser .= "WHERE ";
		$QryUpdateUser .= "`id` = '". $Owner ."';";
		doquery($QryUpdateUser, "users");
	}

?>
