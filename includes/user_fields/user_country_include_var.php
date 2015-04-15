<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright � 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: user_country_include_var.php
| Author: HobbyMan
| Web: http://www.hobbysites.net/
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

$user_field_name = $locale['uf_country'];
$user_field_desc = $locale['uf_country_desc'];
$user_field_dbname = "user_country";
$user_field_group = 2;
$user_field_dbinfo = "VARCHAR(4) NOT NULL DEFAULT ''";
?>