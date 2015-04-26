<?php

/**
 * @package		XG Project
 * @copyright	Copyright (c) 2008 - 2015
 * @license		http://opensource.org/licenses/gpl-3.0.html	GPL-3.0
 * @since		Version 2.10.0
 */

define('INSIDE', TRUE);
define('INSTALL', FALSE);
define('IN_ADMIN', TRUE);
define('XGP_ROOT', './../');

include(XGP_ROOT.'global.php');

if ($ConfigGame != 1) die(message($lang['404_page']));

$parse = $lang;
$errors	= isset($_GET['errors']) ? $_GET['errors'] : NULL;
switch ($errors)
{
	case 'sql':
		if (isset($_GET['delete']) && is_numeric($_GET['delete']))
		{
			doquery("DELETE FROM `{{table}}` WHERE `error_id`='".$_GET['delete']."'", 'errors');
			$Log	=	"\n".$lang['log_errors_title']."\n";
			$Log	.=	$lang['log_the_user'].$user['username']." ".$lang['log_delete_errors']."\n";
			LogFunction($Log, "general", $LogCanWork);
		}
		elseif (isset($_GET['deleteall']) && $_GET['deleteall'] === 'yes')
		{
			doquery("DELETE FROM `{{table}}` WHERE `error_type` != 'PHP'", 'errors');
			$Log	=	"\n".$lang['log_errors_title']."\n";
			$Log	.=	$lang['log_the_user'].$user['username']." ".$lang['log_delete_all_sql_errors']."\n";
			LogFunction($Log, "general", $LogCanWork);
		}
		$query = doquery("SELECT * FROM `{{table}}` WHERE `error_type` != 'PHP' ORDER BY `error_time`", 'errors');
		$i = 0;
		$parse['errors_list'] = '';
		while ($u = mysql_fetch_assoc($query))
		{
			$i++;
			$parse['errors_list']	.= '<tr>';
			$parse['errors_list']	.= '<td class="b">'.$u['error_id'].'</td>';
			$parse['errors_list']	.= '<td class="b">'.(( ! $u['error_sender']) ? $lang['er_public'] : $u['error_sender']).'</td>';
			$parse['errors_list']	.= '<ts class="b">'.date('d/m/Y h:i:s', $u['error_time']).'</td>';
			$parse['errors_list']	.= '<td class="b">'.nl2br($u['error_text']).'</td>';
			$parse['errors_list']	.= '<td class="b"><a href="admin.php?page=errors&amp;errors=sql&amp;delete='.$u['error_id'].'" title="'.$lang['button_delete'].'"><img src="../styles/images/false.png" alt="'.$lang['button_delete'].'"></a></td>';
			$parse['errors_list']	.= '</tr>';
		}
		$parse['total_errors'] = $i;
		display(parsetemplate(gettemplate('adm/SQLerrorMessagesBody'), $parse), FALSE, '', TRUE, FALSE);
	break;
	case 'php':
		if (isset($_GET['delete']) && is_numeric($_GET['delete']))
		{
			doquery("DELETE FROM `{{table}}` WHERE `error_id`='".$_GET['delete']."'", 'errors');
			$Log	=	"\n".$lang['log_errors_title']."\n";
			$Log	.=	$lang['log_the_user'].$user['username']." ".$lang['log_delete_errors']."\n";
			LogFunction($Log, "general", $LogCanWork);
		}
		elseif (isset($_GET['deleteall']) && $_GET['deleteall'] === 'yes')
		{
			doquery("DELETE FROM `{{table}}` WHERE `error_type` = 'PHP'", 'errors');
			$Log	=	"\n".$lang['log_errors_title']."\n";
			$Log	.=	$lang['log_the_user'].$user['username']." ".$lang['log_delete_all_php_errors']."\n";
			LogFunction($Log, "general", $LogCanWork);
		}
		$error_level	= array('32767', '8192', '4096', '2048', '8', '2');
		$show			= array();
		foreach ($error_level as $error)
		{
			$parse['checked_'.$error] = '';
			if ( ! isset($_POST['submit']) OR (isset($_POST['show_'.$error]) && $_POST['show_'.$error]))
			{
				$show[$error] = TRUE;
				$parse['checked_'.$error] = ' checked';
			}
		}
		if ( ! empty($show))
		{
			$filter	= ' && (';
			$i		= 0;
			$total	= count($show);
			foreach ($show as $key => $value)
			{
				$i++;
				$filter .= "`error_level` = '".$key."'";
				if ($i != $total) $filter .= ' OR ';
			}
			$filter .= ')';
		}
		$query					= doquery("SELECT * FROM `{{table}}` WHERE `error_type` = 'PHP'".$filter." ORDER BY `error_file` ASC, `error_line` ASC", 'errors');
		$i						= 0;
		$error_text				= array('E_ALL', 'E_DEPRECATED', 'E_RECOVERABLE_ERROR', 'E_STRICT', 'E_NOTICE', 'E_WARNING');
		$parse['errors_list']	= '';

		while ($u = mysql_fetch_assoc($query))
		{
			$i++;
			$parse['errors_list']	.= '<tr>';
			$parse['errors_list']	.= '<td class="b">'.$u['error_id'].'</div>';
			$parse['errors_list']	.= '<td class="b">'.date('d/m/Y H:i:s', $u['error_time']).'</div>';
			$parse['errors_list']	.= '<td class="b">'.(( ! $u['error_sender']) ? $lang['er_public'] : $u['error_sender']).'</div>';
			$parse['errors_list']	.= '<td class="b">'.str_replace($error_level, $error_text, $u['error_level']).'</div>';
			$parse['errors_list']	.= '<td class="b">'.$u['error_file'].'</div>';
			$parse['errors_list']	.= '<td class="b">'.$u['error_line'].'</div>';
			$parse['errors_list']	.= '<td class="b">'.str_replace('%lang%', $lang['lang_key'], $u['error_text']).'</div>';
			$parse['errors_list']	.= '<td class="b"><a href="?errors=php&amp;delete='.$u['error_id'].'" title="'.$lang['button_delete'].'"><img src="../styles/images/false.png" alt="'.$lang['button_delete'].'"></a></div>';
			$parse['errors_list']	.= '</tr>';
		}
		$parse['total_errors']		= $i;
		display(parsetemplate(gettemplate('adm/PHPerrorMessagesBody'), $parse), FALSE, '', TRUE, FALSE);
	break;
	default:
		display(parsetemplate(gettemplate('adm/ErrorMenu'), $lang), FALSE, '', TRUE, FALSE);
}
