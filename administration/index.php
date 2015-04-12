<?php

/*-------------------------------------------------------+

| PHP-Fusion Content Management System

| Copyright (C) 2002 - 2011 Nick Jones

| http://www.php-fusion.co.uk/

+--------------------------------------------------------+

| Filename: index.php

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


$options = dbquery("SELECT * FROM ".DB_ADMINOPTIONS." WHERE option_name='admin_style'");

if (dbrows($options)) {

	$option = dbarray($options);

	if ($option['option_value'] == "modern") { redirect("dashboard.php".$aidlink); }

}

if (!iADMIN || $userdata['user_rights'] == "" || !defined("iAUTH") || !isset($_GET['aid']) || $_GET['aid'] != iAUTH) { redirect("../index.php"); }



require_once THEMES."templates/admin_header.php";



if (!isset($_GET['pagenum']) || !isnum($_GET['pagenum'])) $_GET['pagenum'] = 1;



$admin_images = true;



// Work out which tab is the active default (redirect if no tab available)

$default = false;

for ($i = 5; $i > 0; $i--) {

	if ($pages[$i]) { $default = $i; }

}

if (!$default) { redirect("../index.php"); }



// Ensure the admin is allowed to access the selected page

if (!$pages[$_GET['pagenum']]) { redirect("index.php".$aidlink."&pagenum=$default"); }



// Display admin panels & pages

opentable($locale['200']." - v".$settings['version']);

echo "<table cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>\n<tr>\n";

for ($i = 1; $i < 6; $i++) {

	$class = ($_GET['pagenum'] == $i ? "tbl1" : "tbl2");

	if ($pages[$i]) {

		echo "<td align='center' width='20%' class='$class'><span class='small'>\n";

		echo ($_GET['pagenum'] == $i ? "<strong>".$locale['ac0'.$i]."</strong>" : "<a href='index.php".$aidlink."&amp;pagenum=$i'>".$locale['ac0'.$i]."</a>")."</span></td>\n";

	} else {

		echo "<td align='center' width='20%' class='$class'><span class='small' style='text-decoration:line-through'>\n";

		echo $locale['ac0'.$i]."</span></td>\n";

	}

}

echo "</tr>\n<tr>\n<td colspan='5' class='tbl'>\n";

$result = dbquery("SELECT * FROM ".DB_ADMIN." WHERE admin_page='".$_GET['pagenum']."' ORDER BY admin_title");

$rows = dbrows($result);

if ($rows != 0) {

	$counter = 0; $columns = 4;

	$align = $admin_images ? "center" : "left";

	echo "<table cellpadding='0' cellspacing='0' width='100%'>\n<tr>\n";

	while ($data = dbarray($result)) {

		if (checkrights($data['admin_rights']) && $data['admin_link'] != "reserved") {

			if ($counter != 0 && ($counter % $columns == 0)) { echo "</tr>\n<tr>\n"; }

			echo "<td align='$align' width='20%' class='tbl'>";

			if ($admin_images) {

				echo "<span class='small'><a href='".$data['admin_link'].$aidlink."'><img src='".get_image("ac_".$data['admin_title'])."' alt='".$data['admin_title']."' style='border:0px;' /></a><br />\n".$data['admin_title']."</span>";

			} else {

				echo "<span class='small'>".THEME_BULLET." <a href='".$data['admin_link'].$aidlink."'>".$data['admin_title']."</a></span>";

			}

			echo "</td>\n";

			$counter++;

		}

	}

	echo "</tr>\n</table>\n";

}

echo "</td>\n</tr>\n</table>\n";

closetable();

require_once THEMES."templates/footer.php";

?>

