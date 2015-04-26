<?php

/**
 * @package		XG Project
 * @copyright	Copyright (c) 2008 - 2015
 * @license		http://opensource.org/licenses/gpl-3.0.html	GPL-3.0
 * @since		Version 2.10.0
 */

if(!defined('INSIDE')){ die(header ( 'location:../../' ));}

class debug
{
	protected $log;
	protected $numqueries;
	protected $php_log;

	function __construct()
	{
		$this->vars = $this->log = '';
		$this->numqueries = 0;
		$this->php_log = array();
	}

	function add($mes)
	{
		$this->log .= $mes;
		$this->numqueries++;
	}

	function echo_log()
	{
		return  "<br><table><tr><td class=k colspan=4><a href=".XGP_ROOT."adm/settings.php>Debug Log</a>:</td></tr>".$this->log."</table>";
		die();
	}

	function error($message,$title)
	{
		global $link, $lang, $user;

		if ( read_config ( 'debug' ) == 1 )
		{
			echo "<h2>$title</h2><br><font color=red>$message</font><br><hr>";
			echo  "<table>".$this->log."</table>";
		}

		include(XGP_ROOT . 'config.php');

		if(!$link)
			die($lang['cdg_mysql_not_available']);

		$query = "INSERT INTO {{table}} SET
		`error_sender` = '".(isset($user['id'])?$user['id']:0)."' ,
		`error_time` = '".time()."' ,
		`error_type` = '".mysql_escape_value($title)."' ,
		`error_text` = '".mysql_escape_value($message)."';";

		$sqlquery = mysql_query(str_replace("{{table}}", $dbsettings["prefix"].'errors',$query)) or die($lang['cdg_fatal_error']);

		$query = "explain select * from {{table}}";

		$q = mysql_fetch_array(mysql_query(str_replace("{{table}}", $dbsettings["prefix"].'errors', $query))) or die($lang['cdg_fatal_error'].': ');

		if (!function_exists('message'))
			echo $lang['cdg_error_message']." <b>".$q['rows']."</b>";
		else
			message($lang['cdg_error_message']." <b>".$q['rows']."</b>", '', '', FALSE, FALSE);

		die();
	}

	public function php_error($sender, $errno, $errstr, $errfile, $errline)
	{
		$this->php_log[] = array(	'hash'		=> md5($errno.$errstr.$errfile.$errline),
									'sender'	=> $sender,
									'time'		=> time(),
									'type'		=> 'PHP',
									'level'		=> $errno,
									'line'		=> $errline,
									'file'		=> mysql_escape_value($errfile),
									'text'		=> mysql_escape_value($errstr));
	}

	public function log_php()
	{
		if ( ! empty($this->php_log))
		{
			$query	= 'INSERT IGNORE INTO {{table}}';
			$query	.= '(`error_hash`, `error_sender`, `error_time`, `error_type`,
						`error_level`, `error_line`, `error_file`, `error_text`) VALUES';
			foreach ($this->php_log as $error)
			{
				$query	.= "('".$error['hash']."', '".$error['sender']."', ".$error['time'].",
							'".$error['type']."', ".$error['level'].", ".$error['line'].",
							'".$error['file']."', '".$error['text']."'),";
			}
			if ($link) doquery(substr($query, 0, -1), 'errors');
		}
	}
}
