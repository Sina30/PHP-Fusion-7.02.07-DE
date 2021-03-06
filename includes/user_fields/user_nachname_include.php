<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright � 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: user_nachname_include.php
| Author: starsplash
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

if ($profile_method == "input") {
	echo "<tr>\n";
	echo "<td class='tbl'>".$locale['uf_nachname'].":</td>\n";
	echo "<td class='tbl'><input type='text' name='user_nachname' value='".(isset($user_data['user_nachname']) ? $user_data['user_nachname'] : "")."' maxlength='50' class='textbox' style='width:200px;' /></td>\n";
	echo "</tr>\n";
} elseif ($profile_method == "display") {
	if ($user_data['user_nachname']) {
		echo "<tr>\n";
		echo "<td width='1%' class='tbl1' style='white-space:nowrap'>".$locale['uf_nachname']."</td>\n";
		echo "<td align='right' class='tbl1'>".$user_data['user_nachname']."</td>\n";
		echo "</tr>\n";
	}
} elseif ($profile_method == "validate_insert") {
	$db_fields .= ", user_nachname";
	$db_values .= ", '".(isset($_POST['user_nachname']) ? stripinput(trim($_POST['user_nachname'])) : "")."'";
} elseif ($profile_method == "validate_update") {
	$db_values .= ", user_nachname='".(isset($_POST['user_nachname']) ? stripinput(trim($_POST['user_nachname'])) : "")."'";
}
?>