<?php

/**
 * @package		XG Project
 * @copyright	Copyright (c) 2008 - 2015
 * @license		http://opensource.org/licenses/gpl-3.0.html	GPL-3.0
 * @since		Version 2.10.0
 */

define('INSIDE'  , TRUE);
define('INSTALL' , FALSE);
define('IN_ADMIN', TRUE);
define('XGP_ROOT', './../');

include(XGP_ROOT . 'global.php');
include('AdminFunctions/Autorization.php');

if ($EditUsers != 1) die();

	$parse = $lang;

	if ($_POST['md5q'] != "")
	{
		doquery ("UPDATE {{table}} SET `password` = '" . md5 ($_POST['md5q']) . "' WHERE `username` = '".$_POST['user']."';", 'users');
	}

	display( parsetemplate( gettemplate("adm/ChangePassBody"), $parse), FALSE, '', TRUE, FALSE);

?>
