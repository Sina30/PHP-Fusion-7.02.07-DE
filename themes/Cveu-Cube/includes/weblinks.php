<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk
+--------------------------------------------------------+
| Filename: featured_weblink_panel.php
| Author: Fangree Productions
| Developers: Fangree_Craig
| Site: http://www.fangree.co.uk
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licen... Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

if (file_exists(INFUSIONS."featured_weblink_panel/locale/".$settings['locale'].".php")) {
	include INFUSIONS."featured_weblink_panel/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."featured_weblink_panel/locale/English.php";
}

$result = dbquery("SELECT * FROM ".DB_WEBLINKS." tl 
			LEFT JOIN ".DB_WEBLINK_CATS." tc 
			ON tl.weblink_cat=tc.weblink_cat_id
			WHERE ".groupaccess('tc.weblink_cat_access')." 
			ORDER BY RAND() LIMIT 2");
if (dbrows($result)!=0) {
		echo "<cellpadding='0' cellspacing='0' width='100%'>\n<tr>\n";
		while ($data = dbarray($result)) {
			if ($counter != 0 && ($counter % $columns == 0)) { echo "</tr>\n<tr>\n"; }
			$num = dbcount("(weblink_cat)", DB_WEBLINKS, "weblink_cat='".$data['weblink_cat_id']."'");
			echo "<td align='left'><img src='".BASEDIR."images/link.jpg' class='weblink'/>&nbsp;&nbsp;<b><a href='".FUSION_SELF."?cat_id=".$data['weblink_cat_id']."'>".$data['weblink_cat_name']."</a></b>&nbsp;($num)";			
			$counter++;
		}
		echo "</tr>\n\n";
	} else {
		echo "<div style='text-align:center'><br />\n".$locale['430']."<br /><br />\n</div>\n";
}
unset($result);
?>