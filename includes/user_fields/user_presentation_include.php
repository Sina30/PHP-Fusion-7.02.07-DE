<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: user_presentation_include.php
| Author: Marwelln
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
	echo "<td class='tbl' valign='top'>".$locale['uf_press'].":</td>\n";
	echo "<td class='tbl'><textarea rows='7' cols='15' name='user_presentation' class='textbox' style='width:295px;' >".(isset($user_data['user_presentation']) ? $user_data['user_presentation'] : "")."</textarea></td>\n";
	echo "</tr>\n";
} elseif ($profile_method == "display") {
	if ($user_data['user_presentation']) {
		echo "</table>";
		echo "<div style='height:5px; font-size:0;'></div>";
		echo "<table class='tbl-border center' style='width:400px;' cellspacing='1'>";
		echo "<tr>\n";
		echo "<td width='1%' colspan='2' class='tbl2' style='white-space:nowrap'><strong>".$locale['uf_press']."</strong></td>\n";
		echo "</tr><tr>";
		echo "<td colspan='2' class='tbl1'>".$user_data['user_presentation']."</td>\n";
		echo "</tr>\n";
	}
} elseif ($profile_method == "validate_insert") {
	$db_fields .= ", user_presentation";
	$db_values .= ", '".(isset($_POST['user_presentation']) ? $_POST['user_presentation'] : "")."'";
} elseif ($profile_method == "validate_update") {
	$db_values .= ", user_presentation='".(isset($_POST['user_presentation']) ? $_POST['user_presentation'] : "")."'";
}
?>
