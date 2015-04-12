<?php

/*-------------------------------------------------------+

| PHP-Fusion Content Management System

| Copyright  2002 - 2009 Nick Jones

| http://www.php-fusion.co.uk/

+--------------------------------------------------------+

| Filename: promembers.php

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

opentidetable($locale['pro_1042']);
		
$result = dbquery("SELECT s.*, u.user_id, u.user_name, u.user_avatar FROM ".DB_SUBMISSIONS." s INNER JOIN ".DB_USERS." u ON s.submit_user =u.user_id ORDER BY s.submit_datestamp DESC LIMIT 0,5");

if (dbrows($result)) {

	$i = 0;

	echo "<table cellpadding='0' cellspacing='0' width='100%'>\n<tr>\n";

	echo "<td width='40' class='tbl2' height='27' style='border-bottom: 1px solid #d5d5d5;' align='center'><strong>".$locale['user1']."</strong></td>\n";

	echo "<td width='1%' class='tbl2' height='27' style='border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5' align='center'><strong>".$locale['pro_1043']."</strong></td>\n";

	echo "<td width='60%' class='tbl2' style='text-align:center;white-space:nowrap;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5' height='27'><strong>".$locale['pro_1044']."</strong></td>\n";

	echo "<td width='1%' class='tbl2' style='text-align:center;white-space:nowrap;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5' height='27'><strong>".$locale['pro_1045']."</strong></td>\n";

	echo "<td width='50' class='tbl2' style='text-align:center;white-space:nowrap;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5' height='27'><strong>".$locale['pro_1023']."</strong></td>\n";

	echo "</tr>\n";

	while ($data = dbarray($result)) {

		$submit_criteria = unserialize($data['submit_criteria']);

		if ($data['submit_type'] == "n") { $submit_name = "news_subject"; $type = "News"; }

		if ($data['submit_type'] == "a") { $submit_name = "article_subject"; $type = "Article"; }

		if ($data['submit_type'] == "d") { $submit_name = "download_title"; $type = "Download"; }

		if ($data['submit_type'] == "p") { $submit_name = "photo_title"; $type = "Photo"; }

		if ($data['submit_type'] == "l") { $submit_name = "link_name"; $type = "Link"; }

		$row_color = ($i % 2 == 0 ? "tbl1" : "tbl2");

		echo "<tr>\n<td class='".$row_color."' style='border-bottom: 1px solid #d5d5d5;border-top: 1px solid #fff' height='58' width='40' align='center'>";

		if (!$data['user_avatar']) { 
	
			echo '<img src="'.THEMES.'templates/images/admin/no-avatar.jpg" class="avatar-effect" width="35" height="35" title="'.$data['user_name'].'" /></a>'; 
	
		} else {
	
			echo '<img src="'.IMAGES.'avatars/'.$data['user_avatar'].'" width="35" height="35" class="avatar-effect" title="'.$data['user_name'].'" /></a>';
	
		}

		echo "</td>\n";

		echo "<td width='1%' class='".$row_color."' style='text-align:center;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5;border-top: 1px solid #fff' height='58'>$type</td>\n";

		echo "<td width='60%' class='".$row_color."' style='white-space:nowrap;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5;border-top: 1px solid #fff' height='58'><a href='".ADMIN."submissions.php".$aidlink."&action=2&t=".$data['submit_type']."&submit_id=".$data['submit_id']."'><b>".$submit_criteria[$submit_name]."</b></a></td>\n";

		echo "<td width='1%' class='".$row_color."' style='text-align:center;white-space:nowrap;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5;border-top: 1px solid #fff' height='58'>".showdate("longdate", $data['submit_datestamp'])."</td>\n";

		echo "<td width='50' class='".$row_color."' align='center' style='text-align:center;white-space:nowrap;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5;border-top: 1px solid #fff' height='58'>";

		echo '<div style="width:49px;" align="center">';

		echo '<div class="square-button" style="float:left;margin-right:5px"><a href="'.ADMIN.'submissions.php'.$aidlink.'&action=2&t='.$data['submit_type'].'&submit_id='.$data['submit_id'].'" title="'.$locale['pro_1025'].'"><img src="'.THEMES.'templates/images/admin/view.png" /></a></div>';

		echo '<div class="square-button" style="float:left"><a href="'.ADMIN.'submissions.php'.$aidlink.'&delete='.$data['submit_id'].'" title="'.$locale['pro_1019'].'"onclick="return confirm(\''.$locale['pro_1046'].'\');"><img src="'.THEMES.'templates/images/admin/delete.png" /></a></div>';

		echo '</div>';

		echo "</td>\n";

		echo "</tr>\n";

		$i++;

	}

	echo "</table>\n";

} else { echo '<br /><div align="center">'.$locale['pro_1055'].'</div><br />'; }

closetidetable();

?>