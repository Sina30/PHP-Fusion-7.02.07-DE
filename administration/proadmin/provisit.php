<?php

/*-------------------------------------------------------+

| PHP-Fusion Content Management System

| Copyright  2002 - 2009 Nick Jones

| http://www.php-fusion.co.uk/

+--------------------------------------------------------+

| Filename: provisit.php

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

if (!defined("IN_FUSION")) { die("Access Denied"); }

include LOCALE.LOCALESET."admin/adminpro.php";

			$visit = dbquery("SELECT v.visit_link, v.visit_time, a.admin_link, a.admin_title, a.admin_image FROM ".DB_ADMINVISIT." v INNER JOIN ".DB_ADMIN." a ON v.visit_link=a.admin_link WHERE v.visit_admin='".$userdata['user_id']."' ORDER BY visit_time DESC LIMIT 0,5");

			if (dbrows($visit)) {

				openside($locale['pro_1056']);

					while ($data = dbarray($visit)) {	
	
						echo '<img src="'.get_image("ac_".$data['admin_title']).'" width="20" /> <a href="'.ADMIN.$data['admin_link'].$aidlink.'" class="grey" title="'.$locale['pro_1057'].' '.showdate("longdate", $data['visit_time']).'">'.$data['admin_title'].'</a><br />';
					}

				closeside();
			}

?>