<?php
/*-----------------------------------------------------------
|   Last-Profile-Visitors User-Field						|
|															|
|	Copyright (C) 2006-2008 Christoph Schreck				|
|	zezoar@gmx.net											|
|	http://www.zoffclan.de/zoffdev/							|
|															|
|   This program is free software; 							|
|	you can redistribute it and/or modify it under 			|
|	the terms of the GNU General Public License 			|
|	as published by the Free Software Foundation; 			|
|	either version 3 of the License, 						|
|	or (at your option) any later version.					|
|															|
|   This program is distributed in the hope that 			|
|	it will be useful, but WITHOUT ANY WARRANTY; 			|
|	without even the implied warranty of MERCHANTABILITY 	|
|	or FITNESS FOR A PARTICULAR PURPOSE. 					|
|	See the GNU General Public License for more details.	|
|															|
|   You should have received a copy of the 					|
|	GNU General Public License along with this program; 	|
|	if not, see <http://www.gnu.org/licenses/>.				|
-----------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }
///////////////CONFIG////////////////////////////////////
$zw_lastvis_showcount = 5; ////number of visitors to show !!!!(max 14)!!!!
$daysshown = 3; /// number of Days, the users are shown 
/////////////////////////////////////////////////////////
if ($profile_method == "display") {
	$change=false;
	$zw_lastvis_array = explode(".",$user_data['zw_lastvisitors']);
	if(is_array($zw_lastvis_array) && count($zw_lastvis_array)) {
		foreach($zw_lastvis_array as $zwskey => $zwsvals) {
			$zwsvals_array = explode("|",$zwsvals);
			if ((!isset($zwsvals_array[1]) || $zwsvals_array[1]<(time()-$daysshown*3600*24)) || (iMEMBER && $userdata['user_id'] == $zwsvals_array[0])) { unset($zw_lastvis_array[$zwskey]); $change=true; }
		}
	}
	if (iMEMBER && $userdata['user_id']!=$user_data['user_id']) {
		array_unshift($zw_lastvis_array, $userdata['user_id']."|".time());
		$change=true;
	}
	array_splice($zw_lastvis_array,5);
	if ($change) { $zw_lastivsquery = dbquery("UPDATE ".DB_USERS." SET zw_lastvisitors='".implode(".",$zw_lastvis_array)."' WHERE user_id='".$user_data['user_id']."'"); }
	$zw_lastvis_show="";
	if (is_array($zw_lastvis_array) && count($zw_lastvis_array)) {
		foreach($zw_lastvis_array as $zw_lastvis_data) {
			$zw_lvinfo = explode("|",$zw_lastvis_data);
			$zw_lastvis_uname=false;
			if(isnum($zw_lvinfo[0]) && $zw_lvinfo[0] && $zw_lastvis_uname=dbresult(dbquery("SELECT user_name FROM ".DB_USERS." WHERE user_id='".$zw_lvinfo[0]."'"),0)) {
				$zw_lastvis_show.=($zw_lastvis_show!="" ? ", " : "")."<a href='".BASEDIR."profile.php?lookup=".$zw_lvinfo[0]."'>".$zw_lastvis_uname."</a>";
			}
		}
	}
	if ($zw_lastvis_show=="") {
		$zw_lastvis_show="----";
	}
	echo "<tr>\n";
	echo "<td width='1%' class='tbl1' style='white-space:nowrap' valign='top'>".$locale['uf_zw_lastvis_03']."</td>\n";
	echo "<td align='right' class='tbl1'>".$zw_lastvis_show."</td>\n";
	echo "</tr>\n";
}
?>