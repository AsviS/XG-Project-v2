<?php

/**
 * @package		XG Project
 * @copyright	Copyright (c) 2008 - 2014
 * @license		http://opensource.org/licenses/gpl-3.0.html	GPL-3.0
 * @since		Version 2.10.0
 */

function migrate_to_xml ()
{
	$query = doquery("SELECT * FROM {{table}}",'config');

	$search		=	array	(
								'?',
								'?',
								'?',
								'?',
								'"',
								'#',
								'$',
								'%',
								'(',
								')',
								'?',
								'?',
								'|',
								'~'
							);
	$replace	=	array	(
								'&#161;',
								'&#191;',
								'&#176;',
								'&#170;',
								'&#34;',
								'&#35;',
								'&#36;',
								'&#37;',
								'&#40;',
								'&#41;',
								'&#172;',
								'&#8364;',
								'&#124;',
								'&#126;'
							);

	while ($row = mysql_fetch_assoc($query))
	{
		if ( $row['config_name'] != 'BuildLabWhileRun' )
		{
			update_config ( strtolower ( $row['config_name'] ) , str_replace ( $search , $replace , $row['config_value'] )  );
		}
	}
}

?>