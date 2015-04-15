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
			ORDER BY RAND() LIMIT 1");
if (dbrows($result)!=0) {
	openside($locale['fwl001']);
	$data = dbarray($result);
	echo "<div style='text-align:center;'>\n";
	echo "<a href='".BASEDIR."weblinks.php?cat_id=".$data['weblink_id']."&amp;weblink_id=".$data['weblink_id']."' target='_blank'>";
	echo "<img src='http://open.thumbshots.org/image.aspx?url=".$data['weblink_url']."' style='border:0px;margin:0 auto;display:block;' ";
	echo "alt='".stripinput($data['weblink_name'])."' title='".stripinput($data['weblink_name'])."' />";
	echo "</a><br />\n";
	echo "<a href='".BASEDIR."weblinks.php?cat_id=".$data['weblink_id']."&amp;weblink_id=".$data['weblink_id']."' class='side' target='_blank'>";
	echo trimlink($data['weblink_name'], 22)."</a><br />\n";
	echo "<span class='small'><strong>".$locale['fwl002']."</strong> ".$data['weblink_count']."</span>\n";
	echo "</div>\n";
	closeside();
	unset($data);
}
unset($result);
?>