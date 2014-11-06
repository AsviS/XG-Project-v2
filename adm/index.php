<?php

/**
 * @package		XG Project
 * @copyright	Copyright (c) 2008 - 2014
 * @license		http://opensource.org/licenses/gpl-3.0.html	GPL-3.0
 * @since		Version 2.10.0
 */

define('INSIDE'  , TRUE);
define('INSTALL' , FALSE);
define('IN_ADMIN', TRUE);
define('XGP_ROOT', './../');

include(XGP_ROOT . 'global.php');

if ($user['authlevel'] < 1) die(message ($lang['404_page']));

	$page  = "<html>\n";
	$page .= "<head>\n";
	$page .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />\n";
	$page .= "<title>". read_config ( 'game_name' ) ." - Admin CP</title>\n";
	$page .= "<link rel=\"shortcut icon\" href=\"./../favicon.ico\">\n";
	$page .= "</head>\n";
	$page .= "<frameset cols=\"180,*\" frameborder=\"no\" border=\"0\" framespacing=\"0\">\n";
	$page .= "<frame src=\"menu.php\" name=\"rightFrame\" id=\"rightFrame\"/>\n";
	$page .= "<frameset rows=\"85,*\" frameborder=\"no\" border=\"0\" framespacing=\"0\">\n";
	$page .= "<frame src=\"topnav.php\" name=\"topFrame\" scrolling=\"No\" noresize=\"noresize\" id=\"topFrame\"/>\n";
	$page .= "<frame src=\"OverviewPage.php\" name=\"Hauptframe\" scrolling=\"yes\" noresize=\"noresize\" id=\"mainFrame\"/>\n";
	$page .= "</frameset>\n";
	$page .= "<noframes><body>\n";
	$page .= "</body>\n";
	$page .= "</noframes></html>\n";
	echo $page;
?>