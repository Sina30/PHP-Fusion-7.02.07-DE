<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) PHP-Fusion Inc
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion.php
| Author: Nick Jones,  Fangree Productions
| Developers: Fangree_Craig
| Support: http://www.fangree.com
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

if (file_exists(INFUSIONS."enhanced_online_users_panel/locale/".$settings['locale'].".php")) {
	include INFUSIONS."enhanced_online_users_panel/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."enhanced_online_users_panel/locale/English.php";
}

include INFUSIONS."enhanced_online_users_panel/infusion_db.php";

// Infusion general information
$inf_title = $locale['eou_title'];
$inf_description = $locale['eou_desc'];
$inf_version = "1.08";
$inf_developer = "PHP-Fusion Mods UK";
$inf_email = "admin@phpfusionmods.co.uk";
$inf_weburl = "http://www.phpfusionmods.co.uk";

$inf_folder = "enhanced_online_users_panel";

$inf_newtable[1] = DB_MAXUSERS." (
online_maxcount MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
online_maxtime int(10) UNSIGNED NOT NULL default '0',
PRIMARY KEY (online_maxcount)
) ENGINE=MyISAM;";


$inf_insertdbrow[1] = DB_MAXUSERS." (online_maxcount, online_maxtime) VALUES ('0','".time()."')";

$inf_droptable[1] = DB_MAXUSERS;



?>