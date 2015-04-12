<?php

/*-------------------------------------------------------+

| PHP-Fusion Content Management System

| Copyright (C) 2002 - 2011 Nick Jones

| http://www.php-fusion.co.uk/

+--------------------------------------------------------+

| Filename: prooptions.php

| Author: Hessan Adnani (ProZillaZ)

+--------------------------------------------------------+

| This program is released as free software under the

| Affero GPL license. You can redistribute it and/or

| modify it under the terms of this license which you

| can read by viewing the included agpl.txt or online

| at www.gnu.org/licenses/agpl.html. Removal of this

| copyright header is strictly prohibited without

| written permission from the original author(s).

+--------------------------------------------------------*/

require_once "../../maincore.php";

if (!defined("iAUTH") || !isset($_GET['aid']) || $_GET['aid'] != iAUTH) { redirect("../index.php"); }

require_once THEMES."templates/admin_header.php";
include LOCALE.LOCALESET."admin/adminpro.php";

if (isset($_GET['error']) && isnum($_GET['error']) && !isset($message)) {
	if ($_GET['error'] == 0) {
		$message = $locale['pro_1064'];
	} elseif ($_GET['error'] == 1) {
		$message = $locale['pro_1063'];
	}
	if (isset($message)) {
		echo "<div id='close-message'><div class='admin-message'>".$message."</div></div>\n";
	}
}

if (isset($_POST['saveoptions'])) {

	$error = 0;

	$admin_style = $_POST['admin_style'];

	$show_comments = $_POST['show_comments'];

	$show_members = $_POST['show_members'];

	$show_forum = $_POST['show_forum'];

	$show_messages = $_POST['show_messages'];

	$show_submission = $_POST['show_submission'];

	$show_visit = $_POST['show_visit'];

	$show_profile = $_POST['show_profile'];

	$show_navigation = $_POST['show_navigation'];

	$show_info = $_POST['show_info'];

	$result = dbquery("UPDATE ".DB_ADMINOPTIONS." SET option_value='".$admin_style."' WHERE option_name='admin_style'");

	if (!$result) { $error = 1; }

	$result = dbquery("UPDATE ".DB_ADMINPANELS." SET panel_display='".$show_comments."' WHERE panel_name='Admin Comments'");

	if (!$result) { $error = 1; }

	$result = dbquery("UPDATE ".DB_ADMINPANELS." SET panel_display='".$show_members."' WHERE panel_name='Admin Members'");

	if (!$result) { $error = 1; }

	$result = dbquery("UPDATE ".DB_ADMINPANELS." SET panel_display='".$show_forum."' WHERE panel_name='Admin Forums'");

	if (!$result) { $error = 1; }

	$result = dbquery("UPDATE ".DB_ADMINPANELS." SET panel_display='".$show_messages."' WHERE panel_name='Admin Messages'");

	if (!$result) { $error = 1; }

	$result = dbquery("UPDATE ".DB_ADMINPANELS." SET panel_display='".$show_submission."' WHERE panel_name='Admin Submissions'");

	if (!$result) { $error = 1; }

	$result = dbquery("UPDATE ".DB_ADMINPANELS." SET panel_display='".$show_visit."' WHERE panel_name='Last Visit'");

	if (!$result) { $error = 1; }

	$result = dbquery("UPDATE ".DB_ADMINPANELS." SET panel_display='".$show_profile."' WHERE panel_name='Side Profile'");

	if (!$result) { $error = 1; }

	$result = dbquery("UPDATE ".DB_ADMINPANELS." SET panel_display='".$show_navigation."' WHERE panel_name='Navigation'");

	if (!$result) { $error = 1; }

	$result = dbquery("UPDATE ".DB_ADMINPANELS." SET panel_display='".$show_info."' WHERE panel_name='Admin Information'");

	if (!$result) { $error = 1; }

	redirect(FUSION_SELF.$aidlink."&error=".$error);
}

$result = dbquery("SELECT * FROM ".DB_ADMINOPTIONS." WHERE option_name='admin_style'");

if (dbrows($result)) {

	$data = dbarray($result);

	$stylelist = "";	

	$stylelist .= "<option value='modern'".($data['option_value'] == "modern" ? " selected='selected'" : "").">".$locale['pro_1060']."</option>\n";

	$stylelist .= "<option value='classic'".($data['option_value'] == "classic" ? " selected='selected'" : "").">".$locale['pro_1061']."</option>\n";

}

$result2 = dbquery("SELECT * FROM ".DB_ADMINPANELS." WHERE panel_name='Admin Comments'");

if (dbrows($result2)) {

	$data2 = dbarray($result2);

	$comments_radio = "";

	$comments_radio .= '<input type="radio" name="show_comments" value="1"'.($data2['panel_display'] == "1" ? " checked" : "").'> '.$locale['pro_1071'];

	$comments_radio .= '<input type="radio" name="show_comments" value="0"'.($data2['panel_display'] == "0" ? " checked" : "").'> '.$locale['pro_1072'].'</td>';

}

$result3 = dbquery("SELECT * FROM ".DB_ADMINPANELS." WHERE panel_name='Admin Forums'");

if (dbrows($result3)) {

	$data3 = dbarray($result3);

	$forums_radio = "";

	$forums_radio .= '<input type="radio" name="show_forum" value="1"'.($data3['panel_display'] == "1" ? " checked" : "").'> '.$locale['pro_1071'];

	$forums_radio .= '<input type="radio" name="show_forum" value="0"'.($data3['panel_display'] == "0" ? " checked" : "").'> '.$locale['pro_1072'].'</td>';

}

$result4 = dbquery("SELECT * FROM ".DB_ADMINPANELS." WHERE panel_name='Admin Messages'");

if (dbrows($result4)) {

	$data4 = dbarray($result4);

	$messages_radio = "";

	$messages_radio .= '<input type="radio" name="show_messages" value="1"'.($data4['panel_display'] == "1" ? " checked" : "").'> '.$locale['pro_1071'];

	$messages_radio .= '<input type="radio" name="show_messages" value="0"'.($data4['panel_display'] == "0" ? " checked" : "").'> '.$locale['pro_1072'].'</td>';

}

$result5 = dbquery("SELECT * FROM ".DB_ADMINPANELS." WHERE panel_name='Admin Submissions'");

if (dbrows($result5)) {

	$data5 = dbarray($result5);

	$submission_radio = "";

	$submission_radio .= '<input type="radio" name="show_submission" value="1"'.($data5['panel_display'] == "1" ? " checked" : "").'> '.$locale['pro_1071'];

	$submission_radio .= '<input type="radio" name="show_submission" value="0"'.($data5['panel_display'] == "0" ? " checked" : "").'> '.$locale['pro_1072'].'</td>';

}

$result6 = dbquery("SELECT * FROM ".DB_ADMINPANELS." WHERE panel_name='Admin Members'");

if (dbrows($result6)) {

	$data6 = dbarray($result6);

	$members_radio = "";

	$members_radio .= '<input type="radio" name="show_members" value="1"'.($data6['panel_display'] == "1" ? " checked" : "").'> '.$locale['pro_1071'];

	$members_radio .= '<input type="radio" name="show_members" value="0"'.($data6['panel_display'] == "0" ? " checked" : "").'> '.$locale['pro_1072'].'</td>';

}

$result7 = dbquery("SELECT * FROM ".DB_ADMINPANELS." WHERE panel_name='Last Visit'");

if (dbrows($result7)) {

	$data7 = dbarray($result7);

	$visit_radio = "";

	$visit_radio .= '<input type="radio" name="show_visit" value="1"'.($data7['panel_display'] == "1" ? " checked" : "").'> '.$locale['pro_1071'];

	$visit_radio .= '<input type="radio" name="show_visit" value="0"'.($data7['panel_display'] == "0" ? " checked" : "").'> '.$locale['pro_1072'].'</td>';

}

$result8 = dbquery("SELECT * FROM ".DB_ADMINPANELS." WHERE panel_name='Side Profile'");

if (dbrows($result8)) {

	$data8 = dbarray($result8);

	$profile_radio = "";

	$profile_radio .= '<input type="radio" name="show_profile" value="1"'.($data8['panel_display'] == "1" ? " checked" : "").'> '.$locale['pro_1071'];

	$profile_radio .= '<input type="radio" name="show_profile" value="0"'.($data8['panel_display'] == "0" ? " checked" : "").'> '.$locale['pro_1072'].'</td>';

}

$result9 = dbquery("SELECT * FROM ".DB_ADMINPANELS." WHERE panel_name='Navigation'");

if (dbrows($result9)) {

	$data9 = dbarray($result9);

	$navigation_radio = "";

	$navigation_radio .= '<input type="radio" name="show_navigation" value="1"'.($data9['panel_display'] == "1" ? " checked" : "").'> '.$locale['pro_1071'];

	$navigation_radio .= '<input type="radio" name="show_navigation" value="0"'.($data9['panel_display'] == "0" ? " checked" : "").'> '.$locale['pro_1072'].'</td>';

}

$result10 = dbquery("SELECT * FROM ".DB_ADMINPANELS." WHERE panel_name='Admin Information'");

if (dbrows($result10)) {

	$data10 = dbarray($result10);

	$info_radio = "";

	$info_radio .= '<input type="radio" name="show_info" value="1"'.($data10['panel_display'] == "1" ? " checked" : "").'> '.$locale['pro_1071'];

	$info_radio .= '<input type="radio" name="show_info" value="0"'.($data10['panel_display'] == "0" ? " checked" : "").'> '.$locale['pro_1072'].'</td>';

}

opentable($locale['pro_1058']);

echo "<form name='options' method='post' action='".FUSION_SELF.$aidlink."'>\n";

echo "<table cellpadding='0' cellspacing='0' width='500' class='center'>\n<tr>\n";

echo "<td width='50%' class='tbl'>".$locale['pro_1059'].":</td>\n";

echo "<td width='50%' class='tbl'><select name='admin_style' class='textbox'>".$stylelist."</select></td>\n";

echo "</tr>\n<tr>\n";

echo "<td width='50%' class='tbl'>".$locale['pro_1070'].":</td>\n";

echo "<td width='50%' class='tbl'>".$comments_radio."</td>\n";

echo "</tr>\n<tr>\n";

echo "<td width='50%' class='tbl'>".$locale['pro_1073'].":</td>\n";

echo "<td width='50%' class='tbl'>".$members_radio."</td>\n";

echo "</tr>\n<tr>\n";

echo "<td width='50%' class='tbl'>".$locale['pro_1074'].":</td>\n";

echo "<td width='50%' class='tbl'>".$forums_radio."</td>\n";

echo "</tr>\n<tr>\n";

echo "<td width='50%' class='tbl'>".$locale['pro_1075'].":</td>\n";

echo "<td width='50%' class='tbl'>".$messages_radio."</td>\n";

echo "</tr>\n<tr>\n";

echo "<td width='50%' class='tbl'>".$locale['pro_1076'].":</td>\n";

echo "<td width='50%' class='tbl'>".$submission_radio."</td>\n";

echo "</tr>\n<tr>\n";

echo "<td width='50%' class='tbl'>".$locale['pro_1079'].":</td>\n";

echo "<td width='50%' class='tbl'>".$visit_radio."</td>\n";

echo "</tr>\n<tr>\n";

echo "<td width='50%' class='tbl'>".$locale['pro_1080'].":</td>\n";

echo "<td width='50%' class='tbl'>".$profile_radio."</td>\n";

echo "</tr>\n<tr>\n";

echo "<td width='50%' class='tbl'>".$locale['pro_1081'].":</td>\n";

echo "<td width='50%' class='tbl'>".$navigation_radio."</td>\n";

echo "</tr>\n<tr>\n";

echo "<td width='50%' class='tbl'>".$locale['pro_1082'].":</td>\n";

echo "<td width='50%' class='tbl'>".$info_radio."</td>\n";

echo "</tr>\n<tr>\n";

echo "<td align='center' colspan='2' class='tbl'><br />\n";

echo "<input type='submit' name='saveoptions' value='".$locale['pro_1062']."' class='button' /></td>\n";

echo "</tr>\n</table>\n</form>\n";

closetable();

require_once THEMES."templates/footer.php";

?>