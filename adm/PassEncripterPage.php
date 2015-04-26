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

if ($ToolsCanUse != 1) die(message ($lang['404_page']));

	$parse = $lang;
	if ($_POST['md5q'] != "")
	{
		$parse['md5_md5'] = $_POST['md5q'];
		$parse['md5_enc'] = md5 ($_POST['md5q']);
	}
	else
	{
		$parse['md5_md5'] = "";
		$parse['md5_enc'] = md5 ("");
	}
	display(parsetemplate(gettemplate('adm/PassEncripterBody'), $parse), FALSE, '', TRUE, FALSE);

?>
