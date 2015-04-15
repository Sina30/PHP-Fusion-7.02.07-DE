<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: user_gender_include.php
| Author: gh0st2k
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
	echo "<td class='tbl'>".$locale['uf_gender_name']."</td>\n";
	echo "<td class='tbl'>";
	echo "<input type='radio' name='user_gender' value='0' ".(isset($user_data['user_gender']) && $user_data['user_gender'] == 0 ? "checked='checked'" : "")." /> ".$locale['uf_gender_no_data'];
	echo " <input type='radio' name='user_gender' value='1' ".(isset($user_data['user_gender']) && $user_data['user_gender'] == 1 ? "checked='checked'" : "")." /> ".$locale['uf_gender_female'];
	echo " <input type='radio' name='user_gender' value='2' ".(isset($user_data['user_gender']) && $user_data['user_gender'] == 2 ? "checked='checked'" : "")." /> ".$locale['uf_gender_male'];
	echo "</td>\n";
	echo "</tr>\n";
} elseif ($profile_method == "display") {
	if ($user_data['user_gender']) {
		echo "<tr>\n";
		echo "<td width='1%' class='tbl1' style='white-space:nowrap'>".$locale['uf_gender_name']."</td>\n";
		echo "<td align='right' class='tbl1'>";
		if (isset($user_data['user_gender'])) {
			if ($user_data['user_gender'] == 1) { echo "<img src='".IMAGES."female.png' alt='' />"; }
			elseif ($user_data['user_gender'] == 2) { echo "<img src='".IMAGES."male.png' alt='' />"; }
			else { echo $locale['no_data']; }
		}
		echo "</td>\n";
		echo "</tr>\n";
	}
} elseif ($profile_method == "validate_insert") {
	$db_fields .= ", user_gender";
	$db_values .= ", '".(isset($_POST['user_gender']) && isnum($_POST['user_gender']) ? $_POST['user_gender'] : "0")."'";
} elseif ($profile_method == "validate_update") {
	$db_values .= ", user_gender='".(isset($_POST['user_gender']) && isnum($_POST['user_gender']) ? $_POST['user_gender'] : "0")."'";
}
?>