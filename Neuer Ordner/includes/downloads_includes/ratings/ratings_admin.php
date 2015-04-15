<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Type:  Ratings Infusion
| Name: Dynamic Star Ratings
| Version: 1.00
| File Name: ratings_admin.php
| Author: Fangree Productions
| Site: http://www.fangree.co.uk
| Contact: admin@fangree.co.uk
| Developers: Fangree_Craig, Keddy & SiteMaster
+--------------------------------------------------------+
| Dynamic Star Rating Redux
| Developed by Jordan Boesch
| www.boedesign.com
| Licensed under Creative Commons - http://creativecommons.org/licenses/by-nc-nd/2.5/ca/
| Used CSS from komodomedia.com.
--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "../../maincore.php";
require_once THEMES."templates/admin_header.php";
include LOCALE.LOCALESET."admin/settings.php";


if (file_exists(INFUSIONS."ratings/locale/".$settings['locale'].".php")) {
	include INFUSIONS."ratings/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."ratings/locale/English.php";
}

if (!checkrights("RAT") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect("../../index.php"); }
add_to_title($locale['global_200'].$locale['r683']);
if (isset($_GET['error']) && isnum($_GET['error']) && !isset($message)) {
	if ($_GET['error'] == 0) {
		$message = $locale['900'];
	} elseif ($_GET['error'] == 1) {
		$message = $locale['901'];
	}
	if (isset($message)) {
			echo "<div id='close-message'><div class='admin-message'>".$message."</div></div>\n"; 
	}
}

if (isset($_POST['savesettings'])) {
	$error = 0;
	
	//Ratings begin
	$result = dbquery("UPDATE ".DB_SETTINGS." SET settings_value='".(isnum($_POST['ratings_style']) ? $_POST['ratings_style'] : "0")."' WHERE settings_name='ratings_style'");
	if (!$result) { $error = 1; }
	//Ratings end
	

	redirect(FUSION_SELF.$aidlink."&error=".$error);
}

opentable($locale['r683']);
echo "<form name='settingsform' method='post' action='".FUSION_SELF.$aidlink."'>\n";
echo "<table cellpadding='0' cellspacing='0' width='400' class='center'>\n";
echo "	<tr>\n";

//Ratings begin
echo "		<td width='50%' class='tbl'>".$locale['r680']."</td>\n";
echo "		<td width='50%' class='tbl'>\n";
echo "			<select name='ratings_style' class='textbox'>\n";
echo "				<option value='1'".($settings['ratings_style'] == "1" ? " selected='selected'" : "").">".$locale['r681']."</option>\n";
echo "				<option value='0'".($settings['ratings_style'] == "0" ? " selected='selected'" : "").">".$locale['r682']."</option>\n";
echo "			</select>\n";
echo "		</td>\n";
echo "	</tr>\n";
//Ratings end

echo "	<tr>\n";
echo "		<td align='center' colspan='2' class='tbl'><br />\n";
echo "			<input type='submit' name='savesettings' value='".$locale['r684']."' class='button' />\n";
echo "		</td>\n";
echo "	</tr>\n";
echo "	<tr>\n";
echo "		<td align='center' colspan='2' class='tbl'><br />\n";

if ($settings['ratings_style'] == "1") {
	echo "			".$locale['r681']." ".$locale['r685']."\n";
} else {
	echo "			".$locale['r682']." ".$locale['r685']."\n";
}

echo "		</td>\n";
echo "	</tr>\n";
echo "</table>\n";
echo "</form>\n";

// Please do not remove copyright info
include INFUSIONS."ratings/rating_functions.php";
echo "".showFPRcopyright()."";
// End copyright info

closetable();

require_once THEMES."templates/footer.php";
?>
