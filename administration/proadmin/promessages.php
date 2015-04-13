<?php

/*-------------------------------------------------------+

| PHP-Fusion Content Management System

| Copyright  2002 - 2009 Nick Jones

| http://www.php-fusion.co.uk/

+--------------------------------------------------------+

| Filename: promessages.php

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

opentidetable($locale['pro_1033']);
		
$result = dbquery("SELECT m.message_id, m.message_subject, m.message_read, m.message_datestamp, m.message_from, u.user_id, u.user_name, u.user_avatar FROM ".DB_MESSAGES." m INNER JOIN ".DB_USERS." u ON m.message_from=u.user_id WHERE m.message_to='".$userdata['user_id']."' AND m.message_folder='0' ORDER BY m.message_datestamp DESC LIMIT 0,5");

if (dbrows($result)) {

	$i = 0;

	echo "<table cellpadding='0' cellspacing='0' width='100%'>\n<tr>\n";

	echo "<td width='1%' class='tbl2' height='27' style='border-bottom: 1px solid #d5d5d5;width:50px' align='center'></td>\n";

	echo "<td width='20%' class='tbl2' height='27' style='border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5'><strong>".$locale['pro_1034']."</strong></td>\n";

	echo "<td width='50%' class='tbl2' style='text-align:left;white-space:nowrap;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5' height='27'><strong>".$locale['pro_1035']."</strong></td>\n";

	echo "<td width='1%' class='tbl2' style='text-align:center;white-space:nowrap;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5' height='27'><strong>".$locale['pro_1036']."</strong></td>\n";

	echo "<td width='80' class='tbl2' style='text-align:center;white-space:nowrap;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5' height='27'><strong>".$locale['pro_1023']."</strong></td>\n";

	echo "</tr>\n";

	while ($data = dbarray($result)) {

		$row_color = ($i % 2 == 0 ? "tbl1" : "tbl2");

		echo "<tr>\n<td class='".$row_color."' style='border-bottom: 1px solid #d5d5d5;border-top: 1px solid #fff;' height='58' width='1%' align='center'>";

		if ($data['message_read'] == "0") { 
	
			echo '<img src="'.THEMES.'templates/images/admin/message-on.gif" width="32" height="32" title="New" /></a>'; 
	
		} else {
	
			echo '<img src="'.THEMES.'templates/images/admin/message-off.gif" width="32" height="32" title="Read" /></a>';
	
		}

		echo "</td>\n";

		echo "<td width='20%' class='".$row_color."' style='border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5;border-top: 1px solid #fff;' height='58'><a href='".FORUM."profile.php?lookup=".$data['user_id']."'>";

		if (!$data['user_avatar']) { 
	
			echo '<img src="'.THEMES.'templates/images/admin/no-avatar.jpg" class="avatar-effect" width="35" height="35" style="vertical-align:middle" />'; 
	
		} else {
	
			echo '<img src="'.IMAGES.'avatars/'.$data['user_avatar'].'" width="35" height="35" class="avatar-effect" style="vertical-align:middle" />';
	
		}

		echo "<b>&nbsp;&nbsp;".trimlink($data['user_name'], 30)."</b></a></td>\n";

		echo "<td width='50%' class='".$row_color."' style='text-align:left;white-space:nowrap;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5;border-top: 1px solid #fff' height='58'>".trimlink($data['message_subject'], 30)."</td>\n";

		echo "<td width='1%' class='".$row_color."' style='text-align:center;white-space:nowrap;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5;border-top: 1px solid #fff' height='58'>".showdate("longdate", $data['message_datestamp'])."</td>\n";

		echo "<td width='80' class='".$row_color."' align='center' style='text-align:center;white-space:nowrap;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5;border-top: 1px solid #fff' height='58'>";

		echo '<div style="width:76px;" align="center">';

		echo '<div class="square-button" style="float:left;margin-right:5px;"><a href="'.BASEDIR.'messages.php?folder=inbox&msg_read='.$data['message_id'].'" title="'.$locale['pro_1037'].'"><img src="'.THEMES.'templates/images/admin/view.png" /></a></div>';

		echo '<div class="square-button" style="float:left;margin-right:5px"><a href="'.ADMIN.'members.php'.$aidlink.'&step=delete&status=0&user_id='.$data['user_id'].'" title="'.$locale['pro_1019'].'"onclick="return confirm(\''.$locale['pro_1026'].'\');"><img src="'.THEMES.'templates/images/admin/delete.png" /></a></div>';

		echo '<div class="square-button" style="float:left;"><a href="'.BASEDIR.'profile.php?lookup='.$data['user_id'].'" title="'.$locale['pro_1025'].'"><img src="'.THEMES.'templates/images/admin/unread.png" /></a></div>';
	
		echo '</div>';

		echo "</td>\n";

		echo "</tr>\n";

		$i++;

	}

	echo "</table>\n";

	echo "<div class='tbl1' style='text-align:center;height:30px;line-height:30px;background-image:url(".THEME."images/admin/table-shade.png);background-position: left bottom;background-repeat: repeat-x;'>\n";

	$members_registered = dbcount("(user_id)", DB_USERS, "user_status<='1' OR user_status='3' OR user_status='5'");

	$members_banned = dbcount("(user_id)", DB_USERS, "user_status='1'");

	$members_unactive = dbcount("(user_id)", DB_USERS, "user_status='2'");

	$members_suspended = dbcount("(user_id)", DB_USERS, "user_status='3'");

	echo "<a href='".BASEDIR."messages.php?folder=inbox'>".$locale['pro_1038']."</a> - ";

	echo "<a href='".BASEDIR."messages.php?folder=outbox'>".$locale['pro_1039']."</a> - ";

	echo "<a href='".BASEDIR."messages.php?folder=archive'>".$locale['pro_1040']."</a> - ";

	echo "<a href='".BASEDIR."messages.php?folder=options''>".$locale['pro_1041']."</a>";


	echo "</div>\n";

} else { echo '<br /><div align="center">'.$locale['pro_1054'].'</div><br />'; }

closetidetable();

?>