<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2014 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Theme name: Cube
| Theme version: 1.0
| Author: Vlad Fagarasanu (Faga)
| Web: www.cvision.eu
| EMail: office@cvision.eu
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }
define("THEME_BULLET", "<img src='".THEME."images/bullet.gif' class='bullet' alt='&raquo;' border='0' />");

require_once THEME."functions.php";
require_once INCLUDES."theme_functions_include.php";

function get_head_tags(){
	echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
	echo "<!--[if lte IE 7]><style type='text/css'>.clearfix {display:inline-block;} * html .clearfix{height: 1px;}</style><![endif]-->";
}

function render_page($license = false) {

	add_handler("theme_output");
	global $settings, $main_style, $locale, $userdata, $aidlink, $mysql_queries_time;
	
	if (file_exists(THEME."locale/".$settings['locale'].".php")) {
		include THEME."locale/".$settings['locale'].".php";
	} else { include THEME."locale/English.php"; }
	
    include THEME.("header.php");
		
    include THEME.("page.php");
    
	include THEME.("footer.php");
    
}

require_once THEME."comments.php";
require_once THEME."news.php";
require_once THEME."articles.php";

?>