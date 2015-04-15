<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) PHP-Fusion Inc
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Name: Enhanced Onliine Users Panel 
| Version: 1.08
| Filename:  enhanced_online_users_panel.php
| Author: PHP-Fusion Mods UK
| Deelopers: Craig
| Site: http://www.phpfusionmods.co.uk
+--------------------------------------------------------+
| PHP-Fusion Online Users Panel 
| Author: Nick Jones (Digitanium)
+--------------------------------------------------------+
| Birthdays  Code from Pimped Fusion Forum Stats 
| Modified by PHP-Fusion Mods UK
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

if (file_exists(INFUSIONS."enhanced_online_users_panel/locale/".$settings['locale'].".php")) {
	include INFUSIONS."enhanced_online_users_panel/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."enhanced_online_users_panel/locale/English.php";
}
include INFUSIONS."enhanced_online_users_panel/infusion_db.php";
//SETTINGS//////////////////////////
$total_new ="1";       // Total New Users Today, Last 7 Days, Last  30 Days   | 1 = ON | 0= OFF |
$username_colour ="1"; // Username Colour | 1 = ON | 0 = OFF |
$birthdays ="1";       // Birthdays  | 1 = ON | 0= OFF |
/// Total New Users Time Settings
$timea = time() - 86400; //24 Hours
$timeb = time() - 604800; //7 Days
$timec = time() - 2592000 ; //30 Days

add_to_head("
<style type='text/css'> 
.eoup_superadmin_style 
{ 
color: #CF3333; 
font-weight: bold;
} 
.eoup_superadmin_style:hover 
{ 
color: #CF3333; 
font-weight: bold;
} 
.eoup_admin_style 
{ 
color: #008000; 
font-weight: bold;
} 
.eoup_admin_style:hover
{ 
color: #008000; 
font-weight: bold;
} 
.eoup_member_style 
{ 
color: #2D6CCA; 
}
.eoup_member_style:hover 
{ 
color: #2D6CCA; 
}
</style>
 "); // Username Colour Styles
 
//SETTINGS END DO NOT EDIT BELOW HERE//////////////////////////	

$result = dbquery("SELECT * FROM ".DB_ONLINE." WHERE online_user=".($userdata['user_level'] != 0 ? "'".$userdata['user_id']."'" : "'0' AND online_ip='".USER_IP."'"));
if (dbrows($result)) {
	$result = dbquery("UPDATE ".DB_ONLINE." SET online_lastactive='".time()."' WHERE online_user=".($userdata['user_level'] != 0 ? "'".$userdata['user_id']."'" : "'0' AND online_ip='".USER_IP."'")."");
} else {
	$result = dbquery("INSERT INTO ".DB_ONLINE." (online_user, online_ip, online_lastactive) VALUES ('".($userdata['user_level'] != 0 ? $userdata['user_id'] : "0")."', '".USER_IP."', '".time()."')");
}
$result = dbquery("DELETE FROM ".DB_ONLINE." WHERE online_lastactive<".(time()-60)."");

opentable($locale['global_010']);

$result = dbquery(
	"SELECT ton.*, tu.user_id,
	tu.user_name,
	tu.user_status, tu.user_level FROM ".DB_ONLINE." ton
	LEFT JOIN ".DB_USERS." tu ON ton.online_user=tu.user_id"
);

$guests = 0; $members = array();
while ($data = dbarray($result)) {
	if ($data['online_user'] == "0") {
		$guests++;
	} else {
		array_push($members, array($data['user_id'], $data['user_name'], $data['user_status'], $data['user_level']));
	}
}
$count_total = dbcount("(online_user)", DB_ONLINE, (iMEMBER ? "online_user='".$userdata['user_id']."'" : "online_user='0' AND online_ip='".USER_IP."'") == 1);

echo "<table cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>\n";
echo "	<tr>\n";
echo "		<td class='tbl2' width='1%' style='white-space: nowrap;' rowspan='4'><center><img src='".INFUSIONS."enhanced_online_users_panel/images/stats.png' alt='".$locale['eou_001']."' title='".$locale['eou_001']."' border='0'/></center></td>\n";
echo "	</tr>\n";

//Total New Members
echo "	<tr>\n";
if ($total_new =='1') {
echo "		<td class='tbl2'>\n";
echo THEME_BULLET." <strong>".$locale['eou_002'].":</strong>";
echo"  <br /><strong>".$locale['eou_003'].":</strong> ".number_format(dbcount("(user_id)", DB_USERS, "user_status<='1' AND user_joined > ".$timea));
echo"  &raquo;  <strong>".$locale['eou_004'].":</strong> ".number_format(dbcount("(user_id)", DB_USERS, "user_status<='1' AND user_joined > ".$timeb));
echo"  &raquo;  <strong>".$locale['eou_005'].":</strong> ".number_format(dbcount("(user_id)", DB_USERS, "user_status<='1' AND user_joined > ".$timec));
echo "		</td>\n";
}
echo "	</tr>\n";

//Guests and Members online

echo "	<tr>\n";
echo "		<td class='tbl1'>\n";
echo "			".THEME_BULLET.$locale['eou_006']."<strong>".$count_total."</strong> ".$locale['eou_007']." :: <strong>".count($members)."</strong> ";
if (count($members) >1) { echo $locale['eou_008']; }else{ echo $locale['eou_009'];}

echo $locale['eou_010']." <strong>".$guests."</strong> ";

if ($guests >1 || $guests ==0) { echo $locale['eou_011']; }elseif ($guests ==1) { echo $locale['eou_012']; }

echo"<br /> \n";

$resulta = dbquery("SELECT * FROM ".DB_MAXUSERS." WHERE online_maxcount !=''");
while ($data = dbarray($resulta)) {
$count = dbcount("(online_user)", DB_ONLINE, (iMEMBER ? "online_user='".$userdata['user_id']."'" : "online_user='0' AND online_ip='".USER_IP."'") == 1);
if ($data['online_maxcount'] < $count) {

	$result = dbquery("UPDATE ".DB_MAXUSERS." SET online_maxtime='".time()."', online_maxcount='".$count."'");
		}
		echo THEME_BULLET.$locale['eou_013']." <strong>".$data['online_maxcount']."</strong> ".$locale['eou_014']." <strong>".showdate("forumdate", $data['online_maxtime'])."</strong>";

}
if (count($members)) {
	$i = 1;
echo"<br />".THEME_BULLET.$locale['eou_015'].":";
	while (list($key, $member) = each($members)) {
if ($username_colour =='1') {
	if ($member['3'] == 103) {
	echo "			<span class='side'>".profile_link($member[0], $member[1], $member[2], 'eoup_superadmin_style')."</span>\n";
		}elseif ($member['3'] == 102) {
		echo "			<span class='side'>".profile_link($member[0], $member[1], $member[2], 'eoup_admin_style')."</span>\n";
		}else{
		echo "			<span class='side'>".profile_link($member[0], $member[1], $member[2], 'eoup_member_style')."</span>\n";
		}
		}else{
		echo "			<span class='side'>".profile_link($member[0], $member[1], $member[2])."</span>\n";
		}
		
		if ($i != count($members)) { echo",\n"; } else { echo "\n"; }
		$i++;
	}
}

$count_new = dbcount("(user_id)", DB_USERS, "user_status='2'");

if (iADMIN && checkrights("M") && $settings['admin_activation'] == "1" && $count_new > 0) {
	echo "			<br />\n".THEME_BULLET." <strong><a href='".ADMIN."members.php".$aidlink."&amp;status=2' class='side'>".$locale['global_015']."</a>\n";
	echo "			:</strong> ".dbcount("(user_id)", DB_USERS, "user_status='2'")."\n";
}

//Newest Member
$data = dbarray(dbquery("SELECT user_id, user_name, user_status FROM ".DB_USERS." WHERE user_status='0' ORDER BY user_joined DESC LIMIT 0,1"));
if ($username_colour =='1') {
echo "			<br />\n".THEME_BULLET.$locale['eou_016']." <strong><span class='side'>".profile_link($data['user_id'], $data['user_name'], $data['user_status'], 'eoup_member_style')."</span></strong>\n";
}else{
echo "			<br />\n".THEME_BULLET.$locale['eou_016']." <strong><span class='side'>".profile_link($data['user_id'], $data['user_name'], $data['user_status'])."</span></strong>\n";
}
echo" :: ".$locale['eou_017'].": <strong>".dbcount("(user_id)", DB_USERS)."</strong>";
echo "		</td>\n";
echo "	</tr>\n";

//Members who have visited today
echo "	<tr>\n";
echo "		<td class='tbl2'>\n";
echo "			".THEME_BULLET.$locale['eou_018'].":<strong> ".number_format(dbcount("(user_id)", DB_USERS, "user_status<='1' AND user_lastvisit > UNIX_TIMESTAMP(CURDATE())"))."</strong><br />\n";

$result2 = dbquery("SELECT user_id, user_name, 
user_level, user_status, user_lastvisit 
FROM ".DB_USERS." 
WHERE user_lastvisit > UNIX_TIMESTAMP(CURDATE()) AND user_status = '0' 
ORDER BY user_lastvisit DESC");
$i = 0;

if (dbrows($result2) != 0) {
	while ($data = dbarray($result2)) {
		if ($i>0)echo "			<span class='side'>,</span> \n";
		if ($username_colour =='1') {
		if ($data['user_level'] == 103) {
		echo "			<span class='side'>".profile_link($data['user_id'], $data['user_name'], $data['user_status'], 'eoup_superadmin_style')."</span>\n";
		}elseif ($data['user_level'] == 102) {
		echo "			<span class='side'>".profile_link($data['user_id'], $data['user_name'], $data['user_status'], 'eoup_admin_style')."</span>\n";
		}else{
		echo "			<span class='side'>".profile_link($data['user_id'], $data['user_name'], $data['user_status'], 'eoup_member_style')."</span>\n";
		}
		}else{
		echo "			<span class='side'>".profile_link($data['user_id'], $data['user_name'], $data['user_status'])."</span>\n";
		}
		$i++;
	}
}
echo "		</td>\n";
echo "	</tr>\n";
$birthdays_check = dbquery("SHOW COLUMNS FROM ".DB_USERS. " LIKE 'user_birthdate'");
if (dbrows($birthdays_check)) {
	
if ($birthdays =='1') {

// Birthdays  Code from Pimped Fusion Forum Stats - Modified by Fangree Productions
$result3 = dbquery("SELECT user_id, user_name, 
user_level, user_status, user_birthdate 
FROM ".DB_USERS." 
WHERE user_birthdate LIKE '____-".date("m")."-".date("d")."' AND user_status = '0'");

$birthday_rows = dbrows($result3);
$today_birthday = "";

if ($birthday_rows) {
	while ($data = dbarray($result3)) {
		$birthdate = explode("-", $data['user_birthdate']);
		$year = date("Y") - $birthdate[0];
		
		if($today_birthday == "") {
			if($birthday_rows == 1) {
				$today_birthday .= "<strong>".$locale['eou_019']."</strong> 1 <strong>".$locale['eou_020'].":</strong> ";
			} else {
				$today_birthday .= sprintf("<strong>".$locale['eou_019']."</strong> %s <strong>".$locale['eou_021'].":</strong>", $birthday_rows);
			}
		} else {
			$today_birthday .= ", \n";
		}

			if ($username_colour =='1') {
		if ($data['user_level'] == 103) {
			$today_birthday .= "			<span class='side'>".profile_link($data['user_id'], $data['user_name'], $data['user_status'], 'eoup_superadmin_style')." (".$year.")</span>\n";
		}elseif ($data['user_level'] == 102) {
			$today_birthday .="			<span class='side'>".profile_link($data['user_id'], $data['user_name'], $data['user_status'], 'eoup_admin_style')." (".$year.")</span>\n";
		}else{
			$today_birthday .="			<span class='side'>".profile_link($data['user_id'], $data['user_name'], $data['user_status'], 'eoup_member_style')." (".$year.")</span>\n";
		}
		}else{
			$today_birthday .="			<span class='side'>".profile_link($data['user_id'], $data['user_name'], $data['user_status'])." (".$year.")</span>\n";
		}
}
}

echo "	<tr>\n";
echo "		<td class='tbl2'>\n";
echo "		<img src='".INFUSIONS."enhanced_online_users_panel/images/birthday.gif' alt='".$locale['eou_022']."' title='".$locale['eou_022']."' border='0'/>";
echo "		</td>\n";
echo "		<td class='tbl1'>\n";
if($today_birthday != "") {
	echo "			".$today_birthday;
}else{
	echo 			$locale['eou_023'];
}
echo "		</td>\n";
echo "	</tr>\n";
}
}
echo "</table>\n";

closetable();
?>