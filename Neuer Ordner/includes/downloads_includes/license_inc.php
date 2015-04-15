<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2014 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Addon Name: PFMUK Downloads Mod
| Filename: license_inc.php
| Version: 1.01
| Author: PHP-Fusion Mods UK
| Developer: Craig
| Site: http://www.phpfusionmods.co.uk
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
if(iMEMBER) {

	if ($data['download_license'] !="") {
			$license = $data['download_license'];
				$agpl = stripos($license, "AGPL");
				$gnu = stripos($license, "GNU");
				if ($agpl === false && $gnu === false) { 
				echo "<div class='license-message' style='margin-top: 20px; margin-bottom: 5px;'> ".$locale['429c'].$data['download_license']."<div style='float: right; margin-top: 2px;'></div></div></a>"; } 
				else {echo "<a class='tozoomb' href='".BASEDIR."includes/downloads_includes/agpl.html'><div class='license-message' style='margin-top: 20px; margin-bottom: 5px;'><strong>".$locale['429b']."</strong><div style='float: right; margin-top: 2px;'></div></div></a>"; }
	}
	}
?>