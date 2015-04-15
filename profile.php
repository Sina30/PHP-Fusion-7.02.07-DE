<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Profile (ESL-Style) for PHP-Fusion v7
| Filename: profile.php
| Author: Enrico Gehrwin (bLack)
| Copyright (C) 2010 Enrico Gehrwin
| mail: enrico.gehrwin@googlemail.com
+--------------------------------------------------------*/
require_once "maincore.php";
require_once THEMES."templates/header.php";
include LOCALE.LOCALESET."view_profile.php";
include LOCALE.LOCALESET."view_profile_esl.php";
include LOCALE.LOCALESET."user_fields.php";

if (!isset($_GET['group_id']) || !isnum($_GET['group_id'])) {

	if (!isset($_GET['lookup']) || !isnum($_GET['lookup'])) { redirect("index.php"); }
	$result = dbquery("SELECT * FROM ".DB_USERS." WHERE user_id='".$_GET['lookup']."'");
	if (dbrows($result)) { $user_data = dbarray($result); } else { redirect("index.php"); }
	if ($user_data['user_status'] > "0") { redirect("index.php"); }

	if (iADMIN && checkrights("UG") && $user_data['user_id'] != $userdata['user_id']) {
		if ((isset($_POST['add_to_group'])) && (isset($_POST['user_group']) && isnum($_POST['user_group']))) {
		 	if (!preg_match("(^\.{$_POST['user_group']}$|\.{$_POST['user_group']}\.|\.{$_POST['user_group']}$)", $user_data['user_groups'])) {
				$result = dbquery("UPDATE ".DB_USERS." SET user_groups='".$user_data['user_groups'].".".$_POST['user_group']."' WHERE user_id='".$user_data['user_id']."'");
			}
			redirect(FUSION_SELF."?lookup=".$user_data['user_id']);
		}
	}
	
	add_to_head("<link rel='stylesheet' href='".IMAGES."profile/profile-esl.css' type='text/css' media='screen' />");
	add_to_title($locale['global_200'].$locale['400'].$locale['global_201'].$user_data['user_name']);

	$i = 0;
	//USER-INFO-ARRAY
	$user_info = array();
	$user_info['user_name'] = array($locale['ESL_01'], $user_data['user_name']);
	$user_info['user_level'] = array($locale['ESL_02'] , getuserlevel($user_data['user_level']));
	if((isset($user_data['user_vorname']) && !empty($user_data['user_vorname'])) || (isset($user_data['user_nachname']) && !empty($user_data['user_nachname']))) {
		$user_info['user_realname'] = array($locale['ESL_19'], (isset($user_data['user_vorname']) ? $user_data['user_vorname']."&nbsp;" : "").(isset($user_data['user_nachname']) ? $user_data['user_nachname'] : ""));
	}
	$user_info['user_joined'] = array($locale['ESL_03'], showdate("longdate", $user_data['user_joined']));
	$user_info['user_lastvisit'] = array($locale['ESL_04'], ($user_data['user_lastvisit'] ? showdate("longdate", $user_data['user_lastvisit']) : $locale['u042']));	
	if(isset($user_data['user_birthdate']) && !empty($user_data['user_birthdate']) && $user_data['user_birthdate'] != "0000-00-00") {
		$months = explode("|", $locale['months']);
		$user_birthdate = explode("-", $user_data['user_birthdate']);
		$user_info['user_birthdate'] = array($locale['ESL_05'], $months[number_format($user_birthdate['1'])]." ".number_format($user_birthdate['2'])." ".$user_birthdate['0']);
	}	
	if (isset($user_data['user_location']) && !empty($user_data['user_location'])) {
		$user_info['user_location'] = array($locale['ESL_06'], $user_data['user_location']);
	}

	//PROFILFELDER LADEN
	$profile_method = "display"; $i = 0; $user_fields_output = array("", "", "", ""); $ob_active = false;
	$result2 = dbquery("SELECT * FROM ".DB_USER_FIELDS." ORDER BY field_cat, field_order");
	if (dbrows($result2)) {
		while($data2 = dbarray($result2)) {
			if ($i != $data2['field_cat']) {
				if ($ob_active) {
					$user_fields_output[$i] = ob_get_contents();
					ob_end_clean();
					$ob_active = false;
				}
				$i = $data2['field_cat'];
			}
			if (!$ob_active) {
				ob_start();
				$ob_active = true;
			}
			if (file_exists(LOCALE.LOCALESET."user_fields/".$data2['field_name'].".php")) {
				include LOCALE.LOCALESET."user_fields/".$data2['field_name'].".php";
			}
			if (file_exists(INCLUDES."user_fields/".$data2['field_name']."_include.php")) {
				include INCLUDES."user_fields/".$data2['field_name']."_include.php";
			}
		}
	}

	if ($ob_active) {
		$user_fields_output[$i] = ob_get_contents();
		ob_end_clean();
	}
	
	//FUNKTIONEN
	function user_gender() {
		global $user_data, $locale;
		
		if(isset($user_data['user_gender'])) {
			switch($user_data['user_gender']) {
				default: return;
				case 1: return "<img src='".IMAGES."female.png' alt='".$locale['ESL_07']."' title='".$locale['ESL_07']."' />";
				case 2: return "<img src='".IMAGES."male.png' alt='".$locale['ESL_08']."' title='".$locale['ESL_08']."' />";
			}
		}
	}
	
	function user_flag() {
		global $user_data, $locale;
		
		if(isset($user_data['user_country']) && !empty($user_data['user_country'])) {
			return "<img src='".IMAGES."user_flags/".strtolower($user_data['user_country']).".png' alt='".$user_data['user_country']."' title='".$user_data['user_country']."' style='vertical-align: middle;' />&nbsp;\n";
		} else {
			return "<img src='".IMAGES."user_flags/zz.png' alt='".$locale['ESL_09']."' title='".$locale['ESL_09']."' style='vertical-align: middle;' />&nbsp;\n";
		}
	}	
	
	function display_name() {
		global $user_data;
		
		if((isset($user_data['user_vorname']) && !empty($user_data['user_vorname'])) && (isset($user_data['user_nachname']) && !empty($user_data['user_nachname']))) {
			return $user_data['user_vorname']."&nbsp;'<span style='font-weight: bold;'>".$user_data['user_name']."</span>'&nbsp;".$user_data['user_nachname'];
		} else {
			return "<span style='font-weight: bold;'>".$user_data['user_name']."</span>";
		}
	}
	
	function user_lastseen() {
		global $user_data, $locale;
		
		if((time() - $user_data['user_lastvisit']) < 60) {
			return "<img src='".IMAGES."profile/icon_online.png' alt='on' title='".$locale['ESL_10']."'>";
		} else {
			return "<img src='".IMAGES."profile/icon_offline.png' alt='off' title='".$locale['ESL_11']."'>";
		}
	}
	
	function user_aboutme() {
		global $user_data, $locale;
		
		if(isset($user_data['user_presentation']) && !empty($user_data['user_presentation'])) {
			return nl2br(parseubb(parsesmileys($user_data['user_presentation'])));
		} else {
			return $locale['ESL_16'];
		}
	}
	
	function user_lastvisitors($count = 5, $shown = 3) {
		global $user_data, $userdata, $locale;
		
		$change = false;
		$user_data['zw_lastvisitors'] = isset($user_data['zw_lastvisitors']) ? $user_data['zw_lastvisitors'] : ""; 
		$zw_lastvis_array = explode(".", $user_data['zw_lastvisitors']);
		if(is_array($zw_lastvis_array) && count($zw_lastvis_array)) {
			foreach($zw_lastvis_array as $zwskey => $zwsvals) {
				$zwsvals_array = explode("|", $zwsvals);
				if ((!isset($zwsvals_array[1]) || $zwsvals_array[1] < (time() - $shown * 3600 * 24)) || (iMEMBER && $userdata['user_id'] == $zwsvals_array[0])) {
					unset($zw_lastvis_array[$zwskey]);
					$change = true;
				}
			}
		}
		if(iMEMBER && $userdata['user_id'] != $user_data['user_id']) {
			array_unshift($zw_lastvis_array, $userdata['user_id']."|".time());
			$change = true;
		}
		array_splice($zw_lastvis_array, $count);
		if ($change) {
			if($user_data['zw_lastvisitors']) {
				$zw_lastivsquery = dbquery("UPDATE ".DB_USERS." SET zw_lastvisitors='".implode(".", $zw_lastvis_array)."' WHERE user_id='".$user_data['user_id']."'");
			}
		}
		$zw_lastvis_show = "";
		if(is_array($zw_lastvis_array) && count($zw_lastvis_array)) {
			foreach($zw_lastvis_array as $zw_lastvis_data) {
				$zw_lvinfo = explode("|", $zw_lastvis_data);
				$zw_lastvis_uname = false;
				if(isnum($zw_lvinfo[0]) && $zw_lvinfo[0]) {
					$visitor = dbarray(dbquery("SELECT user_name".(isset($user_data['user_country']) ? ", user_country" : "")." FROM ".DB_USERS." WHERE user_id='".$zw_lvinfo[0]."'"));
					$zw_lastvis_show .= "<div><a href='".BASEDIR."profile.php?lookup=".$zw_lvinfo[0]."'>".(isset($visitor['user_country']) ? "<img src='".IMAGES."user_flags/".strtolower($visitor['user_country']).".png' alt='".$visitor['user_country']."' title='".$visitor['user_country']."' style='vertical-align: middle;' />&nbsp;" : "").$visitor['user_name']."</a></div>";
				}
			}
		}
		
		return $zw_lastvis_show == "" ? $locale['ESL_26'] : $zw_lastvis_show;
	}		
	
	opentable($locale['400']);
		echo "<div class='esl-profile'>\n";

		//INFO OBEN
		echo "<div class='top-info'>\n";
		echo "<div class='flag'>".user_flag()."</div>\n";
		echo "<div class='status'>".user_lastseen()."</div>\n";
		echo "<div class='gender'>".user_gender()."</div>\n";
		echo "<div class='name'>".display_name()."</div>\n";
		echo "<div class='user-id'>".$locale['ESL_12']."&nbsp;".$user_data['user_id']."</div>\n";
		echo "</div>\n";		
		echo "<div class='clear'></div>\n";
		echo "<hr>\n";
		
		//KONTAKT-BUTTONS
		echo "<div class='clear options'>";		
		if ($user_data['user_hide_email'] != "1" || iADMIN) {
			echo "<a href='mailto:".$user_data['user_email']."' title='".$locale['ESL_21']."'><img src='".IMAGES."profile/icon_email.png' alt='email' /></a>";	
		} 		
		if (iMEMBER && $userdata['user_id'] != $user_data['user_id']) {
			echo "<a href='messages.php?msg_send=".$user_data['user_id']."' title='".$locale['ESL_20']."'><img src='".IMAGES."profile/icon_pm.png' alt='pm' /></a>";
		}		
		echo "</div>\n";

		//ALLG INFO
		echo "<div class='middle-info'>\n";
		echo "<div class='avatar'>";
		echo "<div class='tbl-border'>";
		echo "<div class='tbl1'>";
		if ($user_data['user_avatar'] && file_exists(IMAGES."avatars/".$user_data['user_avatar'])) {
			echo "<!--profile_user_avatar--><img src='".IMAGES."avatars/".$user_data['user_avatar']."' alt='' />";
		} else {
			echo "<!--profile_user_avatar--><img src='".IMAGES."profile/no_avatar.gif' alt='no_avatar' title='".$locale['ESL_13']."' />";
		}
		echo "</div>\n";
		echo "</div>\n";
		
		//ADMIN OPTIONEN
		if (iADMIN && checkrights("M") && $user_data['user_id'] != $userdata['user_id'] && $user_data['user_level'] < 102) {
			$user_groups_opts = "";
			echo "<form name='admin_form' method='post' action='".FUSION_SELF."?lookup=".$user_data['user_id']."'>\n";
			echo "<div class='options-admin tbl-border'>";
			echo "<div class='tbl2 title' onclick='$(\"#admin-edit\").slideToggle(); $(\"#admin-group\").slideToggle();'>".$locale['ESL_25']."</div>\n";
			echo "<div class='tbl1' id='admin-edit' style='display: none;'><!--profile_admin_options-->\n";
			echo "<a href='".ADMIN."members.php".$aidlink."&amp;step=edit&amp;user_id=".$user_data['user_id']."'>".$locale['410']."</a> :\n";
			echo "<a href='".ADMIN."members.php".$aidlink."&amp;step=ban&amp;act=on&amp;user_id=".$user_data['user_id']."&amp;status=1' onclick=\"return confirm('".$locale['413']."');\">".$locale['411']."</a> :\n";
			echo "<a href='".ADMIN."members.php".$aidlink."&amp;step=delete&amp;status=0&amp;user_id=".$user_data['user_id']."' onclick=\"return confirm('".$locale['414']."');\">".$locale['412']."</a>\n";
			echo "</div>\n";
			$result = dbquery("SELECT * FROM ".DB_USER_GROUPS." ORDER BY group_id ASC");
			if (dbrows($result)) {
				while ($data2 = dbarray($result)) {
					if (!preg_match("(^\.{$data2['group_id']}|\.{$data2['group_id']}\.|\.{$data2['group_id']}$)", $user_data['user_groups'])) {
						$user_groups_opts .= "<option value='".$data2['group_id']."'>".$data2['group_name']."</option>\n";
					}
				}
				if (iADMIN && checkrights("UG") && $user_groups_opts) {
					echo "<div class='tbl1' id='admin-group' style='display: none;'>";
					echo "<select name='user_group' class='textbox' style='width:50px'>\n".$user_groups_opts."</select>\n";
					echo "<input type='submit' name='add_to_group' value='".$locale['416']."' class='button'  onclick=\"return confirm('".$locale['417']."');\" />\n";
					echo "</div>\n";
				}
			}
			echo "</div>\n</form>\n";
		}		
		echo "</div>\n";
			
		echo "<div class='user-info'>\n";		
		foreach($user_info as $field_id => $field_data) {		
			echo "<div class='field".($i % 2 == 0 ? " clear" : "")."'>\n";
			echo "<div><!--profile_".$field_id."-->".$field_data[1]."</div>\n";
			echo "<div>".$field_data[0]."</div>\n";
			echo "</div>\n";
			$i++;
		}
		echo "</div>\n";
		echo "<div class='clear'></div>\n";
		
		//BESCHREIBUNG & LETZTE BESUCHER
		echo "<div class='extra-info'>\n";
		if(isset($user_data['user_presentation'])) {
			echo "<div class='description'>\n";
			echo "<div class='title'>".$locale['ESL_14']."</div>\n";
			echo "<div class='content'><div class='tbl-border'><div class='tbl2'>".user_aboutme()."</div></div></div>\n";
			echo "</div>\n";	
		}
		if(isset($user_data['zw_lastvisitors'])) {
			echo "<div class='visitors'>\n";
			echo "<div class='title'>".$locale['ESL_15']."</div>\n";
			echo "<div class='content'><div class='tbl-border'><div class='tbl2'>".user_lastvisitors()."</div></div></div>\n";
			echo "</div>\n";
		}
		echo "</div>\n";
		echo "<div class='clear'></div>\n";

		//STATS INFO
		if (array_key_exists(4, $user_fields_output) && $user_fields_output[4]) {
			echo "<div class='statistics-info'>\n";
			echo "<div class='title'>".$locale['ESL_17']."</div>\n";
			echo "<table cellpadding='0' cellspacing='0' class='tbl-border field-table'>\n";
			echo $user_fields_output[4];
			echo "</table>\n";
			echo "</div>\n";
		}

		//KONTAKT INFO
		if (array_key_exists(1, $user_fields_output) && $user_fields_output[1]) {
			echo "<div class='contact-info'>\n";
			echo "<div class='title'>".$locale['ESL_18']."</div>\n";
			echo "<table cellpadding='0' cellspacing='0' class='tbl-border field-table'>\n";
			echo $user_fields_output[1];
			echo "</table>\n";
			echo "</div>\n";
		}

		//GRUPPEN INFO
		if ($user_data['user_groups']) {
			echo "<div class='group-info'>\n";
			echo "<div class='title'>".$locale['ESL_24']."</div>\n";
			echo "<table cellpadding='0' cellspacing='0' class='tbl-border field-table'>\n";
			echo "<tr>\n";
			echo "<td class='tbl1'>\n";
			$user_groups = (strpos($user_data['user_groups'], ".") == 0 ? explode(".", substr($user_data['user_groups'], 1)) : explode(".", $user_data['user_groups']));
			for ($i = 0; $i < count($user_groups); $i++) {
				echo "<div style='float:left'><a href='".FUSION_SELF."?group_id=".$user_groups[$i]."'>".getgroupname($user_groups[$i])."</a></div><div style='float:right'>".getgroupname($user_groups[$i], true)."</div><div style='float:none;clear:both'></div>\n";
			}
			echo "</td>\n</tr>\n";
			echo "</table>\n";
			echo "</div>\n";
		}
	closetable();
} else {
	$result = dbquery("SELECT * FROM ".DB_USER_GROUPS." WHERE group_id='".$_GET['group_id']."'");
	if (dbrows($result)) {
		$data = dbarray($result);
		$result = dbquery("SELECT * FROM ".DB_USERS." WHERE user_groups REGEXP('^\\\.{$_GET['group_id']}$|\\\.{$_GET['group_id']}\\\.|\\\.{$_GET['group_id']}$') ORDER BY user_level DESC, user_name");
		opentable($locale['420']);
		echo "<table cellpadding='0' cellspacing='0' width='100%'>\n<tr>\n";
		echo "<td align='center' colspan='2' class='tbl1'><strong>".$data['group_name']."</strong> (".sprintf((dbrows($result) == 1 ? $locale['421'] : $locale['422']), dbrows($result)).")</td>\n";
		echo "</tr>\n<tr>\n";
		echo "<td class='tbl2'><strong>".$locale['423']."</strong></td>\n";
		echo "<td align='center' width='1%' class='tbl2' style='white-space:nowrap'><strong>".$locale['424']."</strong></td>\n";
		echo "</tr>\n";
		while ($data = dbarray($result)) {
			$cell_color = ($i % 2 == 0 ? "tbl1" : "tbl2"); $i++;
			echo "<tr>\n<td class='$cell_color'>\n<a href='profile.php?lookup=".$data['user_id']."'>".$data['user_name']."</a></td>\n";
			echo "<td align='center' width='1%' class='$cell_color' style='white-space:nowrap'>".getuserlevel($data['user_level'])."</td>\n</tr>";
		}
		echo "</table>\n";
	} else {
		redirect("index.php");
	}
	closetable();
}

require_once THEMES."templates/footer.php";
?>
