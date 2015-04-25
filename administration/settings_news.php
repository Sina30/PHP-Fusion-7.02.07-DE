<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: settings_news.php
| Author: Starefossen
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

if (!checkRights("S8") || !defined("iAUTH") || !isset($_GET['aid']) || $_GET['aid'] != iAUTH) { redirect("../index.php"); }

require_once THEMES."templates/admin_header.php";
include LOCALE.LOCALESET."admin/settings.php";

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
	$result = dbquery("UPDATE ".DB_SETTINGS." SET settings_value='".(isnum($_POST['news_image_link']) ? $_POST['news_image_link'] : "0")."' WHERE settings_name='news_image_link'");
	if (!$result) { $error = 1; }
	$result = dbquery("UPDATE ".DB_SETTINGS." SET settings_value='".(isnum($_POST['news_image_frontpage']) ? $_POST['news_image_frontpage'] : "0")."' WHERE settings_name='news_image_frontpage'");
	if (!$result) { $error = 1; }
	$result = dbquery("UPDATE ".DB_SETTINGS." SET settings_value='".(isnum($_POST['news_image_readmore']) ? $_POST['news_image_readmore'] : "0")."' WHERE settings_name='news_image_readmore'");
	if (!$result) { $error = 1; }
	$result = dbquery("UPDATE ".DB_SETTINGS." SET settings_value='".(isnum($_POST['news_thumb_ratio']) ? $_POST['news_thumb_ratio'] : "0")."' WHERE settings_name='news_thumb_ratio'");
	if (!$result) { $error = 1; }
	$result = dbquery("UPDATE ".DB_SETTINGS." SET settings_value='".(isnum($_POST['news_thumb_w']) ? $_POST['news_thumb_w'] : "100")."' WHERE settings_name='news_thumb_w'");
	if (!$result) { $error = 1; }
	$result = dbquery("UPDATE ".DB_SETTINGS." SET settings_value='".(isnum($_POST['news_thumb_h']) ? $_POST['news_thumb_h'] : "100")."' WHERE settings_name='news_thumb_h'");
	if (!$result) { $error = 1; }
	$result = dbquery("UPDATE ".DB_SETTINGS." SET settings_value='".(isnum($_POST['news_photo_w']) ? $_POST['news_photo_w'] : "400")."' WHERE settings_name='news_photo_w'");
	if (!$result) { $error = 1; }
	$result = dbquery("UPDATE ".DB_SETTINGS." SET settings_value='".(isnum($_POST['news_photo_h']) ? $_POST['news_photo_h'] : "300")."' WHERE settings_name='news_photo_h'");
	if (!$result) { $error = 1; }
	$result = dbquery("UPDATE ".DB_SETTINGS." SET settings_value='".(isnum($_POST['news_photo_max_w']) ? $_POST['news_photo_max_w'] : "1800")."' WHERE settings_name='news_photo_max_w'");
	if (!$result) { $error = 1; }
	$result = dbquery("UPDATE ".DB_SETTINGS." SET settings_value='".(isnum($_POST['news_photo_max_h']) ? $_POST['news_photo_max_h'] : "1600")."' WHERE settings_name='news_photo_max_h'");
	if (!$result) { $error = 1; }
	$result = dbquery("UPDATE ".DB_SETTINGS." SET settings_value='".(isnum($_POST['news_photo_max_b']) ? $_POST['news_photo_max_b'] : "150000")."' WHERE settings_name='news_photo_max_b'");
	if (!$result) { $error = 1; }
	redirect(FUSION_SELF.$aidlink."&error=".$error);
}

$settings2 = array();
$result = dbquery("SELECT * FROM ".DB_SETTINGS);
while ($data = dbarray($result)) {
	$settings2[$data['settings_name']] = $data['settings_value'];
}

opentable($locale['400']);
echo "<form name='settingsform' method='post' action='".FUSION_SELF.$aidlink."'>\n";
		echo "<table class='tbl-border table table-responsive' border='0' width='100%' align='center'>";
		echo "<tr><td class='tbl'>".$locale['951']."</br><select name='news_image_link' class='textbox'>
		<option value='0'".($settings2['news_image_link'] == 0 ? " selected='selected'" : "").">".$locale['952']."</option>
		<option value='1'".($settings2['news_image_link'] == 1 ? " selected='selected'" : "").">".$locale['953']."</option></select></td>";
		
		echo "<td class='tbl'>".$locale['957']."</br><select name='news_image_frontpage' class='textbox'>
		<option value='0'".($settings2['news_image_frontpage'] == 0 ? " selected='selected'" : "").">".$locale['959']."</option>
		<option value='1'".($settings2['news_image_frontpage'] == 1 ? " selected='selected'" : "").">".$locale['960']."</option></br></select></td></tr>";
		
		echo "<tr><td class='tbl'>".$locale['958']."</br><select name='news_image_readmore' class='textbox'>
		<option value='0'".($settings2['news_image_readmore'] == 0 ? " selected='selected'" : "").">".$locale['959']."</option>
		<option value='1'".($settings2['news_image_readmore'] == 1 ? " selected='selected'" : "").">".$locale['960']."</option></select></td></tr>";
		echo "<td class='tbl' align='center' colspan='2'><strong>".$locale['950']."</strong></tr>";
		echo "<td class='tbl'>".$locale['954']."</br><select name='news_thumb_ratio' class='textbox'>
		<option value='0'".($settings2['news_thumb_ratio'] == 0 ? " selected='selected'" : "").">".$locale['955']."</option>
		<option value='1'".($settings2['news_thumb_ratio'] == 1 ? " selected='selected'" : "").">".$locale['956']."</option></select></td>";
		
		echo "<td class='tbl'>".$locale['954']."</br><select name='news_thumb_ratio' class='textbox'>
		<option value='0'".($settings2['news_thumb_ratio'] == 0 ? " selected='selected'" : "").">".$locale['955']."</option>
		<option value='1'".($settings2['news_thumb_ratio'] == 1 ? " selected='selected'" : "").">".$locale['956']."</option></select></td></tr>";
		
		echo "<tr><td class='tbl'>".$locale['601']."<br /><span class='small2'>".$locale['604']."</span></br>
		<input type='text' name='news_thumb_w' value='".$settings2['news_thumb_w']."' maxlength='3' class='textbox' style='width:40px;' /> x
		<input type='text' name='news_thumb_h' value='".$settings2['news_thumb_h']."' maxlength='3' class='textbox' style='width:40px;' /></td></tr>";
		
		echo "<td class='tbl'>".$locale['602']."<br /><span class='small2'>".$locale['604']."</span></br>
		<input type='text' name='news_photo_w' value='".$settings2['news_photo_w']."' maxlength='3' class='textbox' style='width:40px;' /> x
		<input type='text' name='news_photo_h' value='".$settings2['news_photo_h']."' maxlength='3' class='textbox' style='width:40px;' /></td>";
		
		
		
		echo "<td class='tbl'>".$locale['603']."<br /><span class='small2'>".$locale['604']."</span></br>
		<input type='text' name='news_photo_max_w' value='".$settings2['news_photo_max_w']."' maxlength='4' class='textbox' style='width:40px;' /> x
		<input type='text' name='news_photo_max_h' value='".$settings2['news_photo_max_h']."' maxlength='4' class='textbox' style='width:40px;' /></td></tr>";
		
		echo "<tr><td class='tbl'>".$locale['605']."</br>
		<input type='text' name='news_photo_max_b' value='".$settings2['news_photo_max_b']."' maxlength='10' class='textbox' style='width:100px;' /></td>";
		
		echo "</td></tr>";

		echo "</tr>\n<tr>\n";
		echo "<td align='center' colspan='2' class='tbl'><br />\n";
echo "<input type='submit' name='savesettings' value='".$locale['750']."' class='button' /></td>\n";
echo "</tr>\n</table>\n</form>\n";
closetable();

require_once THEMES."templates/footer.php";
?>
