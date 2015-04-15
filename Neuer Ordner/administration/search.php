<?php
/*-------------------------------------------------------+

| PHP-Fusion Content Management System

| Copyright (C) 2002 - 2011 Nick Jones

| http://www.php-fusion.co.uk/

+--------------------------------------------------------+

| Filename: dashboard.php

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

require_once "../maincore.php";

if (!isset($_POST['keyword'])) { redirect("dashboard.php".$aidlink); }

$navi_name = $locale['global_1052'];

require_once THEMES."templates/admin_header.php";

opentable($locale['global_1050']);

$result = dbquery("SELECT admin_id, admin_title, admin_page, admin_rights, admin_link FROM ".DB_ADMIN." WHERE admin_title LIKE '%".$_POST['keyword']."%' ORDER BY admin_title ASC");

if (dbrows($result)) {

	echo '<table cellspacing="0" cellpadding="0" class="center tbl-border"><tr>';

	echo '<td width="1%" class="tbl2" height="27" style="border-bottom: 1px solid #d5d5d5;width:40px"></td>';

	echo '<td width="100%" class="tbl2" style="text-align:left;white-space:nowrap;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5" height="27"><strong>'.$locale['global_1051'].'</strong></td>';

	$i = 0;

	$j = 1;

	while ($data = dbarray($result)) {

		$row_color = ($i % 2 == 0 ? "tbl1" : "tbl2");

		echo '</tr><tr>';

		echo '<td class="'.$row_color.'" style="border-bottom: 1px solid #d5d5d5;border-top: 1px solid #fff;width:40px" height="58"><b><img src="'.get_image("ac_".$data['admin_title']).'" alt="'.$data['admin_title'].'" style="border:0px;" /></b></td>';

		echo '<td width="1%" class="'.$row_color.'" style="text-align:left;white-space:nowrap;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5;border-top: 1px solid #fff" height="58" onclick="window.open (\''.ADMIN.''.$data['admin_link'].''.$aidlink.'\',\'_self\',false);">';

		echo '<a href="'.ADMIN.$data['admin_link'].$aidlink.'"><b>'.$data['admin_title'].'</b></a></td>';

		$i++; $j++;

	}

	echo '</tr></table>';

}

closetable();

require_once THEMES."templates/footer.php";

?>