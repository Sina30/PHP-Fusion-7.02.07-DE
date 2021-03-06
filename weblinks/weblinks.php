<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: weblinks.php
| Author: Nick Jones (Digitanium)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "../maincore.php";
require_once THEMES."templates/header.php";
include LOCALE.LOCALESET."weblinks.php";

if (isset($_GET['weblink_id']) && isnum($_GET['weblink_id'])) {
	$res = 0;
	if ($data = dbarray(dbquery("SELECT weblink_url,weblink_cat FROM ".DB_WEBLINKS." WHERE weblink_id='".$_GET['weblink_id']."'"))) {
		$cdata = dbarray(dbquery("SELECT * FROM ".DB_WEBLINK_CATS." WHERE weblink_cat_id='".$data['weblink_cat']."'"));
		if (checkgroup($cdata['weblink_cat_access'])) {
			$res = 1;
			$result = dbquery("UPDATE ".DB_WEBLINKS." SET weblink_count=weblink_count+1 WHERE weblink_id='".$_GET['weblink_id']."'");
			redirect($data['weblink_url']);
		}
	}
	if ($res == 0) { redirect(FUSION_SELF); }
}

add_to_title($locale['global_200'].$locale['400']);

if (!isset($_GET['cat_id']) || !isnum($_GET['cat_id'])) {
	opentable($locale['400']);
	$result = dbquery("SELECT * FROM ".DB_WEBLINK_CATS." WHERE ".groupaccess('weblink_cat_access')." ORDER BY weblink_cat_name");
	$rows = dbrows($result);
	if ($rows != 0) {
		$counter = 0; $columns = 2; 
		echo "<table cellpadding='0' cellspacing='0' width='100%'>\n<tr>\n";
		while ($data = dbarray($result)) {
			if ($counter != 0 && ($counter % $columns == 0)) { echo "</tr>\n<tr>\n"; }
			$num = dbcount("(weblink_cat)", DB_WEBLINKS, "weblink_cat='".$data['weblink_cat_id']."'");
			echo "<td valign='top' width='50%' class='tbl'><a href='".FUSION_SELF."?cat_id=".$data['weblink_cat_id']."'>".$data['weblink_cat_name']."</a> <span class='small2'>($num)</span>";
			if ($data['weblink_cat_description'] != "") { echo "<br />\n<span class='small'>".$data['weblink_cat_description']."</span>"; }
			echo "</td>\n";
			$counter++;
		}
		echo "</tr>\n</table>\n";
	} else {
		echo "<div style='text-align:center'><br />\n".$locale['430']."<br /><br />\n</div>\n";
	}
	closetable();
} else {
	$res = 0;
	$result = dbquery("SELECT * FROM ".DB_WEBLINK_CATS." WHERE weblink_cat_id='".$_GET['cat_id']."'");
	if (dbrows($result) != 0) {
		$cdata = dbarray($result);
		if (checkgroup($cdata['weblink_cat_access'])) {
			$res = 1;
			add_to_title($locale['global_201'].$cdata['weblink_cat_name']);
			opentable($locale['400'].": ".$cdata['weblink_cat_name']);
			$rows = dbcount("(weblink_id)", DB_WEBLINKS, "weblink_cat='".$_GET['cat_id']."'");
			if (!isset($_GET['rowstart']) || !isnum($_GET['rowstart'])) { $_GET['rowstart'] = 0; }
			if ($rows != 0) {
				$result = dbquery("SELECT * FROM ".DB_WEBLINKS." WHERE weblink_cat='".$_GET['cat_id']."' ORDER BY ".$cdata['weblink_cat_sorting']." LIMIT ".$_GET['rowstart'].",15");
				$numrows = dbrows($result); $i = 1;
				while ($data = dbarray($result)) {
					if ($data['weblink_datestamp']+604800 > time()+($settings['timeoffset']*3600)) {
						$new = " <span class='small'> &nbsp;<img src='".THEME."images/icons/new_dl_icon.png' alt='Neu' title='Neu' style='border:0px; vertical-align:middle;' /></span>";
					} else {
						$new = "";
					}
					echo "<table width='100%' cellpadding='0' cellspacing='1' class='tbl-border'>\n";
					echo "<tr>\n<td colspan='2' class='tbl2'><a href='".FUSION_SELF."?cat_id=".$_GET['cat_id']."&amp;weblink_id=".$data['weblink_id']."' target='_blank'>".$data['weblink_name']."</a>$new</td>\n</tr>\n";
					echo "<br />\n";
					echo "</td>\n";
					echo "<td align='center' class='tbl1' style='white-space:nowrap'><a href='".FUSION_SELF."?cat_id=".$_GET['cat_id']."&amp;weblink_id=".$data['weblink_id']."' target='_blank'><div style='border: 0px solid'><img src='http://fadeout.de/thumbshot-pro/?scale=4&url=".$data['weblink_url']."' style='border: 0,2px solid ;''/></div></a></td>\n";
					echo "<tr>\n<td align='center' width='16%' class='tbl2'><strong>Vorschau</strong></td>\n";
					echo "<td width='84%' class='tbl2'><strong>".$locale['411']."</strong> ".showdate("shortdate", $data['weblink_datestamp'])." - <strong>".$locale['412']."</strong> ".$data['weblink_count']."</td>\n</tr>\n</table>\n";
					echo "<td align='left' class='tbl1'>".nl2br(stripslashes($data['weblink_description']))."</td>\n";
					if ($i != $numrows) { echo "<div align='center'><img src='".get_image("blank")."' alt='' height='15' width='1' /></div>\n"; $i++; }
				}
				closetable();
				if ($rows > 15) { echo "<div align='center' style='margin-top:5px;'>\n".makepagenav($_GET['rowstart'], 15, $rows, 3, FUSION_SELF."?cat_id=".$_GET['cat_id']."&amp;")."\n</div>\n"; }
			} else {
				echo $locale['431']."\n";
				closetable();
			}
		}
	}
	if ($res == 0) { redirect(FUSION_SELF); }
}

require_once THEMES."templates/footer.php";
?>