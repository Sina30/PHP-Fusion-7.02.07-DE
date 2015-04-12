<?php

/*-------------------------------------------------------+

| PHP-Fusion Content Management System

| Copyright  2002 - 2009 Nick Jones

| http://www.php-fusion.co.uk/

+--------------------------------------------------------+

| Filename: procomment.php

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

opentable($locale['global_025']);
		
		$result = dbquery(
		
			"SELECT c.comment_id, c.comment_name, c.comment_message, c.comment_datestamp, c.comment_ip, c.comment_type, c.comment_item_id, u.user_id, u.user_name, u.user_status, u.user_level, u.user_avatar FROM ".DB_COMMENTS." c
		
			LEFT JOIN ".DB_USERS." u ON c.comment_name=u.user_id ORDER BY c.comment_datestamp DESC LIMIT 0,5");

			if (dbrows($result)) {

				$counter = 0; $type = ""; $type_id = "";

echo '			<div style="width:100%;height:auto">';

				while ($data = dbarray($result)) {

					$counter++;

					if (($type != $data['comment_type'] || $type_id !=  $data['comment_item_id']) && $counter >= '2') { echo "<hr />"; }

					if ($type != $data['comment_type'] || $type_id !=  $data['comment_item_id']) { 

						echo '<div style="font-size:13px;font-weight:bold;margin-bottom:7px" align="center">'.$locale['pro_1016'];

							if ($data['comment_type'] == "N") { $db_name = DB_NEWS; $db_id = 'news_id'; $db_field = 'news_subject'; $db_link = 'news.php?readmore='; $db_org = "News"; }

							if ($data['comment_type'] == "A") { $db_name = DB_ARTICLES; $db_id = 'article_id'; $db_field = 'article_subject'; $db_link = 'articles.php?article_id='; $db_org = "Articles"; }

							if ($data['comment_type'] == "D") { $db_name = DB_DOWNLOADS; $db_id = 'download_id'; $db_field = 'download_title'; $db_link = 'downloads.php?download_id='; $db_org = "Downloads"; }

							if ($data['comment_type'] == "P") { $db_name = DB_PHOTOS; $db_id = 'photo_id'; $db_field = 'photo_title'; $db_link = 'photogallery.php?photo_id='; $db_org = "Photos"; }

							$result_org = dbquery("SELECT ".$db_id.", ".$db_field." FROM ".$db_name." WHERE ".$db_id."='".$data['comment_item_id']."'");

							if (dbrows($result_org)) {

								$org = dbarray($result_org);

								echo '<a href="'.BASEDIR.$db_link.$org[$db_id].'" target="_blank"> '.$org[$db_field].'</a>';

								echo ' '.$locale['pro_1017'].' '.$db_org.' '.$locale['pro_1018'];

							}

						echo' </div>';

					}

					if ($data['user_level'] == "102" || $data['user_level'] == "103") {

echo '					<div style="width:100%;height:auto;clear:both;margin-bottom:15px">

							<div style="float:right;width:50px">

							<a href="'.BASEDIR.'profile.php?lookup='.$data['user_id'].'" target="_blank" title="'.$data['user_name'].'">';

								if (!$data['user_avatar']) { 
	
									echo '<img src="'.THEMES.'templates/images/admin/no-avatar.jpg" class="avatar-effect" width="35" height="35" /></a>'; 
	
								} else {
	
									echo '<img src="'.IMAGES.'avatars/'.$data['user_avatar'].'" width="35" height="35" class="avatar-effect" /></a>';
	
								}

echo '						</div>

							<div style="float:right;width:20px;padding-top:10px;"><img src="'.THEMES.'templates/images/admin/comment-arrow-right.png" /></div>

							<div class="dashboard-comment-box">

								<div style="float:left;font-size:11px"><b>'.$data['user_name'].'</b> '.$locale['pro_1015'].':</div>

								<div style="float:right;font-size:10px"><i>'.showdate("longdate", $data['comment_datestamp']).'</i></div>

								<div style="clear:both;color:#8f8181"><br />'.nl2br(parseubb(parsesmileys($data['comment_message']))).'</div>

								<div style="float:right">

								<span class="small"><a href="'.ADMIN.'comments.php'.$aidlink.'&amp;action=edit&amp;comment_id='.$data['comment_id'].'&amp;ctype='.$data['comment_type'].'&amp;cid='.$data['comment_item_id'].'">'.$locale['global_076'].'</a> -

								<a href="'.ADMIN.'comments.php'.$aidlink.'&amp;action=delete&amp;comment_id='.$data['comment_id'].'&amp;ctype='.$data['comment_type'].'&amp;cid='.$data['comment_item_id'].'" onclick="return confirm(\''.$locale['pro_1020'].'\');\">'.$locale['pro_1019'].'</a>

								</div>
							
							</div>

						</div>
';

					} else {

echo '					<div style="width:100%;height:auto;clear:both;margin-bottom:15px">

							<div style="float:left;width:50px" align="right">

								<a href="'.BASEDIR.'profile.php?lookup='.$data['user_id'].'" target="_blank" title="'.$data['user_name'].'">';

								if (!$data['user_avatar']) { 
	
									echo '<img src="'.THEMES.'templates/images/admin/no-avatar.jpg" class="avatar-effect" width="35" height="35" /></a>'; 
	
								} else {
	
									echo '<img src="'.IMAGES.'avatars/'.$data['user_avatar'].'" width="35" height="35" class="avatar-effect" /></a>';
	
								}

echo '						</div>

							<div style="float:left;width:20px;padding-top:10px;" align="right"><img src="'.THEMES.'templates/images/admin/comment-arrow-left.png" /></div>

							<div class="dashboard-comment-box-user">

								<div style="float:left;font-size:11px"><b>'.$data['user_name'].'</b> '.$locale['pro_1015'].':</div>

								<div style="float:right;font-size:10px"><i>'.showdate("longdate", $data['comment_datestamp']).'</i></div>

								<div style="clear:both;color:#8f8181"><br />'.nl2br(parseubb(parsesmileys($data['comment_message']))).'</div>

								<div style="float:right">

								<span class="small"><a href="'.ADMIN.'comments.php'.$aidlink.'&amp;action=edit&amp;comment_id='.$data['comment_id'].'&amp;ctype='.$data['comment_type'].'&amp;cid='.$data['comment_item_id'].'">'.$locale['global_076'].'</a> -

								<a href="'.ADMIN.'comments.php'.$aidlink.'&amp;action=delete&amp;comment_id='.$data['comment_id'].'&amp;ctype='.$data['comment_type'].'&amp;cid='.$data['comment_item_id'].'" onclick="return confirm(\''.$locale['pro_1020'].'\');\">'.$locale['pro_1019'].'</a>

								</div>
							
							</div>

						</div>
';

					}

					$type = $data['comment_type'];

					$type_id = $data['comment_item_id'];

				}

echo '			</div>';

			} else {

				echo '<br /><div align="center">'.$locale['global_026'].'</div><br />';

			}

closetable();

?>