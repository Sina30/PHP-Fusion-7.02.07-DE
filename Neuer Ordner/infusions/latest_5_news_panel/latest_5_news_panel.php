<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2014 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: latest_5_news_panel.php
| Version: 1.00
| Author: PHP-Fusion Mods UK
| Developers: Craig
| Sites: http://www.phpfusionmods.co.uk
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

if (file_exists(INFUSIONS."latest_5_news_panel/locale/".$settings['locale'].".php")) {
		include INFUSIONS."latest_5_news_panel/locale/".$settings['locale'].".php";
	} else {
		include INFUSIONS."latest_5_news_panel/locale/English.php";
	}
	
	
add_to_head("<style type='text/css'>
.latest-news {
font-family: Lato, sans-serif;
font-size: 21px;
font-weight: bold;
padding-left: 20px;
}
</style>");


openside($locale['lfnp_001']);
$resultln = dbquery("SELECT tn.*, tc.*, tu.user_id, tu.user_name, tu.user_status
	FROM ".DB_NEWS." tn
	LEFT JOIN ".DB_USERS." tu ON tn.news_name=tu.user_id
	LEFT JOIN ".DB_NEWS_CATS." tc ON tn.news_cat=tc.news_cat_id
	WHERE ".groupaccess('news_visibility')." AND (news_start='0'||news_start<=".time().")
	AND (news_end='0'||news_end>=".time().") AND news_draft='0'
	GROUP BY news_id
	ORDER BY news_sticky DESC, news_datestamp DESC LIMIT 0,5"
);


if (dbrows($resultln)) {

		echo"<dl class='latest-news'>";	

			$i = 0;
			while ($dataln= dbarray($resultln)) {
			$row_color = ($i % 2 == 0 ? "tbl1" : "tbl2");
			$subject = trimlink(strip_tags(parseubb($dataln['news_subject'])), 30);

			echo"<dt  class='".$row_color."'>
				<div style='padding-top: 1px;'><span style='font-size: 12px; font-weight:bold;'><a href='".BASEDIR."news.php?readmore=".$dataln['news_id']."'>".$subject."</a></span> 
				<span class='small'><div style='padding:1px;'>".$locale['lfnp_002'].": ".profile_link($dataln['user_id'], $dataln['user_name'], $dataln['user_status'])." - ".showdate("shortdate", $dataln['news_datestamp'])." </div></div></span>
				</dt>";

			$i++;
		}
		echo"</dl>";
	
}

closeside();
?>