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
	redirect(FUSION_SELF.$aidlink."&error=".$error);
}

$result = dbquery("SELECT * FROM ".DB_ADMINOPTIONS." WHERE option_name='admin_style'");
if (dbrows($result)) {
	$data = dbarray($result);
	$stylelist = "";	
	$stylelist .= "<option value='modern'".($data['option_value'] == "modern" ? " selected='selected'" : "").">".$locale['pro_1060']."</option>\n";
	$stylelist .= "<option value='classic'".($data['option_value'] == "classic" ? " selected='selected'" : "").">".$locale['pro_1061']."</option>\n";
}

opentable($locale['pro_1058']);
echo "<form name='options' method='post' action='".FUSION_SELF.$aidlink."'>\n";
echo "<table cellpadding='0' cellspacing='0' width='500' class='center'>\n<tr>\n";
echo "<td width='50%' class='tbl'>".$locale['pro_1059'].":</td>\n";
echo "<td width='50%' class='tbl'><select name='admin_style' class='textbox'>".$stylelist."</select></td>\n";
echo "</tr>\n<tr>\n";
echo "<td align='center' colspan='2' class='tbl'><br />\n";
echo "<input type='submit' name='saveoptions' value='".$locale['pro_1062']."' class='button' /></td>\n";
echo "</tr>\n</table>\n</form>\n";
closetable();
require_once THEMES."templates/footer.php";
?>