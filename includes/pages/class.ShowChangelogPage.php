<?php

/**
 * @package		XG Project
 * @copyright	Copyright (c) 2008 - 2015
 * @license		http://opensource.org/licenses/gpl-3.0.html	GPL-3.0
 * @since		Version 2.10.0
 */

if(!defined('INSIDE')){ die(header("location:../../"));}

class ShowChangelogPage
{
	public function __construct()
	{
		global $lang;

		includeLang ( 'CHANGELOG' );
		$template	=	gettemplate ( 'changelog/changelog_table' );
		$body		= '';

		foreach ( $lang['changelog'] as $version => $description )
		{
			$parse['version_number']	= $version;
			$parse['description'] 		= nl2br ( $description );

			$body .= parsetemplate ( $template , $parse );
		}

		$parse 			= $lang;
		$parse['body'] 	= $body;

		display ( parsetemplate ( gettemplate ( 'changelog/changelog_body' ) , $parse ) );
	}
}
?>
