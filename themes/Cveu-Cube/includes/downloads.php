<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: fp_latest_downloads_panel.php
| Version: 1.00
| Author: Fangree Productions
| Developers: Fangree_Craig 
| Site: http://www.fangree.co.uk
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

	if (file_exists(INFUSIONS."locale/downloads/".$settings['locale'].".php")) {
		include INFUSIONS."locale/downloads/".$settings['locale'].".php";
	} else {
		include INFUSIONS."locale/downloads/German.php";
	}
	if (!defined("IN_FUSION")) { die("Access Denied"); }

	
	global $settings;
	
	$result = dbquery(
			"SELECT td.download_id, td.download_title, td.download_cat, td.download_image_thumb, 
					td.download_image, td.download_version, td.download_datestamp, td.download_count, 
					td.download_user, tu.user_id, tu.user_name, tu.user_status,
					tc.download_cat_id, tc.download_cat_access 
					FROM ".DB_DOWNLOADS." td
					LEFT JOIN ".DB_USERS." tu ON td.download_user=tu.user_id
					INNER JOIN ".DB_DOWNLOAD_CATS." tc ON td.download_cat=tc.download_cat_id
					".(iSUPERADMIN ? "" : " WHERE ".groupaccess('download_cat_access'))." 
					ORDER BY download_datestamp DESC LIMIT 0,1");

	if (dbrows($result)) {
		$i = 0;
		
		add_to_head("<link rel='stylesheet' href='".INCLUDES."jquery/colorbox/colorbox.css' type='text/css' media='screen' />");
		add_to_head("<script type='text/javascript' src='".INCLUDES."jquery/colorbox/jquery.colorbox.js'></script>");
		add_to_head("<script type='text/javascript'>\n
		/* <![CDATA[ */\n
		jQuery(document).ready(function(){
			jQuery('a.tozoom').colorbox();
		});\n
		/* ]]>*/\n
		</script>\n");
		
		echo "<table cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>\n<tr>\n";
		if ($settings['download_screenshot']) {
		}
		while ($data = dbarray($result)) {
			
		echo "<tr>\n<td>";
			
		if ($settings['download_screenshot'] && $data['download_image'] != "" && $data['download_image_thumb']) {
		$dl_img_thumb = DOWNLOADS."images/".$data['download_image_thumb'];
		} else {
		$dl_img_thumb = DOWNLOADS."images/no_image.jpg";
		}
		
		if ($settings['download_screenshot']) {
		echo "<a class='tozoom' href='".DOWNLOADS."images/".$data['download_image']."'><img src='".$dl_img_thumb."' style='float: left;margin:3px; height: 50px; width: 50px;' alt='".$data['download_title']."' /></a>\n";
		}
		echo "</td>\n";
		echo "<td width='100%'><a href='".BASEDIR."downloads.php?cat_id=".$data['download_cat_id']."&amp;download_id=".$data['download_id']."'>".trimlink($data['download_title'], 100)."</a></td>\n";
		echo "<td width='1%' style='text-align:center;white-space:nowrap'>".showdate("shortdate", $data['download_datestamp'])."&nbsp;</td>\n";
		echo "<td width='1%' style='text-align:center;white-space:nowrap'>".profile_link($data['user_id'], $data['user_name'], $data['user_status'])."</td>\n";
		echo "</tr>\n";
		
			$i++;
		}
		echo "</table>\n";
		
	   }else{
	   echo"<div style='text-align:center;'>".$locale['fpldp7'] ."</div>\n";
		
	}
	
?>