<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion_db.php
| Author: matze
| Lizenz: CCL v1.0
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

if (!defined("DB_FUSION_TUTORIAL")) {          
define("DB_FUSION_TUTORIAL", DB_PREFIX."fusion_tutorial"); 
}
if (!defined("DB_FUSION_TUTORIAL_LOGSYS")) {
	define("DB_FUSION_TUTORIAL_LOGSYS", DB_PREFIX."fusion_tutorial_logsys");
}
if (!defined("DB_FUSION_TUTORIAL_SETTINGS")) {  
define("DB_FUSION_TUTORIAL_SETTINGS", DB_PREFIX."fusion_tutorial_settings"); 
}
if (!defined("DB_FUSION_TUTORIAL_CATS")) {      
define("DB_FUSION_TUTORIAL_CATS", DB_PREFIX."fusion_tutorial_cats"); 
}
if (!defined("DB_FUSION_conf")) {
	define("DB_FUSION_conf", DB_PREFIX."fusion_config");
}
?>