<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion.php
| Author: matze
| Lizenz: CCL v1.0
+--------------------------------------------------------*/
require_once "../../../maincore.php";
require_once THEMES."templates/admin_header.php";
include INFUSIONS."tutorial_portal_panel/infusion_db.php";
require_once INFUSIONS."tutorial_portal_panel/includes/add.functions.php";
require_once INFUSIONS."tutorial_portal_panel/includes/add.inc.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."tutorial_portal_panel/locale/".$settings['locale'].".php")) {
// Load the locale file matching the current site locale setting.
include INFUSIONS."tutorial_portal_panel/locale/".$settings['locale'].".php";
} else {
// Load the infusion's default locale file.
include INFUSIONS."tutorial_portal_panel/locale/German.php";
}
if (!checkrights("TUTP") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { die("Zugang nur f&uuml;r Administratoren!"); }
include INFUSIONS."tutorial_portal_panel/admin/admin_navigation.php";
$tut_settings = dbarray(dbquery("SELECT * FROM ".DB_FUSION_TUTORIAL_SETTINGS));

if (isset($_POST['save_settings'])) {
$tut_perpage = stripinput($_POST['tut_perpage']);
$tut_cats_perpage = stripinput($_POST['tut_cats_perpage']);
$tut_cats_colum = (isset($_POST['tut_cats_colum']) && isnum($_POST['tut_cats_colum'])) ? $_POST['tut_cats_colum'] : "3";
$tut_colum = (isset($_POST['tut_colum']) && isnum($_POST['tut_colum'])) ? $_POST['tut_colum'] : "2";
$tut_comments = (isset($_POST['tut_comments']) && isnum($_POST['tut_comments'])) ? $_POST['tut_comments'] : "0";
$tut_access = (isset($_POST['tut_access']) && isnum($_POST['translation_access'])) ? $_POST['tut_access'] : "0";
$tut_log_on = (isset($_POST['tut_log_on']) && isnum($_POST['tut_log_on'])) ? $_POST['tut_log_on'] : "0";
$tut_lizenz = (isset($_POST['tut_lizenz']) && isnum($_POST['tut_lizenz'])) ? $_POST['tut_lizenz'] : "0";
$tut_kosten_cur = (isset($_POST['tut_kosten_cur']) && isnum($_POST['tut_kosten_cur'])) ? $_POST['tut_kosten_cur'] : "0";
$file_types = stripinput($_POST['file_types']);
$file_maxsize = stripinput($_POST['file_maxsize']);
$result = dbquery("UPDATE ".DB_FUSION_TUTORIAL_SETTINGS." SET 
	tut_perpage='".$tut_perpage."', 
	tut_cats_perpage='".$tut_cats_perpage."',
	tut_cats_colum='".$tut_cats_colum."',
	tut_colum='".$tut_colum."',
	tut_comments='".$tut_comments."', 
	tut_access='".$tut_access."', 
	tut_log_on='".$tut_log_on."',
	tut_lizenz='".$tut_lizenz."',
	tut_kosten_cur='".$tut_kosten_cur."',
	tut_ftypes='".$file_types."',
	tut_fmaxsize='".$file_maxsize."'");
redirect(FUSION_SELF.$aidlink);
}
$data = dbarray(dbquery("SELECT * FROM ".DB_FUSION_TUTORIAL_SETTINGS));
$tut_cats_colum = (isset($data['tut_cats_colum']) && isnum($data['tut_cats_colum'])) ? $data['tut_cats_colum'] : "3";
$tut_colum = (isset($data['tut_colum']) && isnum($data['tut_colum'])) ? $data['tut_colum'] : "2";
$tut_comments = (isset($data['tut_comments']) && isnum($data['tut_comments'])) ? $data['tut_comments'] : "0";
$tut_access = (isset($data['tut_access']) && isnum($data['tut_access'])) ? $data['tut_access'] : "0";
$tut_log_on = (isset($data['tut_log_on']) && isnum($data['tut_log_on'])) ? $data['tut_log_on'] : "0";
$tut_lizenz = (isset($data['tut_lizenz']) && isnum($data['tut_lizenz'])) ? $data['tut_lizenz'] : "0";
$tut_kosten_cur = (isset($data['tut_kosten_cur']) && isnum($data['tut_kosten_cur'])) ? $data['tut_kosten_cur'] : "0";

$sel = ""; $user_groups = getusergroups(); $access_opts = "";
while(list($key, $user_group) = each($user_groups)){
$sel = (isset($tut_access) && $tut_access == $user_group['0'] ? " selected='selected'" : "");
$access_opts .= "<option value='".$user_group['0']."'".$sel.">".$user_group['1']."</option>\n";
	}
	
$fsel = ""; $fuser_groups = getusergroups(); $faccess_opts = "";
while(list($key, $fuser_group) = each($fuser_groups)){
$fsel = (isset($tut_fileaccess) && $tut_fileaccess == $fuser_group['0'] ? " selected='selected'" : "");
$faccess_opts .= "<option value='".$fuser_group['0']."'".$fsel.">".$fuser_group['1']."</option>\n";
}
opentable($locale['translation_as000']);
	echo "<form name='inputform' method='post' action='".FUSION_SELF.$aidlink."'>\n";
	echo "<table class='tbl-border center' width='600' cellspacing='1' cellpadding='0'>\n<tr>\n";
	echo "<td colspan='2' class='tbl2' width='400'><strong>".$locale['translation_as001']."</strong></td></tr><tr>";
	echo "<td class='tbl1' style='white-space:nowrap'>".$locale['translation_as002']."</td>\n";
	echo "<td class='tbl1'><input type='text' name='tut_perpage' value='".$tut_settings['tut_perpage']."' maxlength='5' class='textbox' style='width:40px;' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' style='white-space:nowrap'>".$locale['translation_as003']."</td>\n";
	echo "<td class='tbl1'><input type='text' name='tut_cats_perpage' value='".$tut_settings['tut_cats_perpage']."' maxlength='5' class='textbox' style='width:40px;' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' style='white-space:nowrap'>Willst du mit mitloggen?</td>\n";
	echo "<td class='tbl1'><select name='tut_log_on' class='textbox' style='width:40px;' />\n";
	echo "<option style='color:".$locale['yes-color'].";' value='0'".($tut_log_on == "0" ? " selected='selected'" : "").">Aktiviert</option>\n";
	echo "<option style='color:".$locale['no-color'].";' value='1'".($tut_log_on == "1" ? " selected='selected'" : "").">Nicht aktiviert</option>\n";
	echo "</select>";
	echo ($tut_settings['tut_log_on'] == 0 ? "
	<img src='".INFUSIONS."tutorial_portal_panel/images/on.png' alt='Eingeschalten'/>" : "
	<img src='".INFUSIONS."tutorial_portal_panel/images/off.png' alt='Ausgeschalten'/>");
	echo "</td></tr><tr>\n";
	//***
	echo "<td class='tbl1' style='white-space:nowrap'>Lizenz aktivieren?</td>\n";
	echo "<td class='tbl1'><select name='tut_lizenz' class='textbox' style='width:40px;' />\n";
	echo "<option style='color:".$locale['yes-color'].";' value='0'".($tut_lizenz == "0" ? " selected='selected'" : "").">Aktiviert</option>\n";
	echo "<option style='color:".$locale['no-color'].";' value='1'".($tut_lizenz == "1" ? " selected='selected'" : "").">Nicht aktiviert</option>\n";
	echo "</select>";
	echo ($tut_settings['tut_lizenz'] == 0 ? "
	<img src='".INFUSIONS."tutorial_portal_panel/images/on.png' alt='Eingeschalten'/>" : "
	<img src='".INFUSIONS."tutorial_portal_panel/images/off.png' alt='Ausgeschalten'/>");
	echo "</td></tr><tr>\n";
	//***
	//***
	echo "<td class='tbl1' style='white-space:nowrap'>Scores oder Premium?</td>\n";
	echo "<td class='tbl1'><select name='tut_kosten_cur' class='textbox' style='width:40px;' />\n";
	echo "<option style='color:".$locale['yes-color'].";' value='0'".($tut_kosten_cur == "0" ? " selected='selected'" : "").">Scores</option>\n";
	echo "<option style='color:".$locale['no-color'].";' value='1'".($tut_kosten_cur == "1" ? " selected='selected'" : "").">MF-Premium</option>\n";
	echo "</select>";
	echo ($tut_settings['tut_kosten_cur'] == 0 ? "
	Scoresystem" : "
	MF-Premium");
	echo "</td></tr><tr>\n";
	//***
	echo "<td colspan='2' class='tbl2' width='400'><strong>".$locale['translation_as004']."</strong></td></tr><tr>";
	echo "<td class='tbl1' style='white-space:nowrap'>".$locale['translation_as005']."</td>\n";
	echo "<td class='tbl1'><select name='tut_cats_colum' class='textbox'>\n";
	echo "<option value='1'".($tut_cats_colum == "1" ? " selected='selected'" : "").">".$locale['translation_as006']."</option>\n";
	echo "<option value='2'".($tut_cats_colum == "2" ? " selected='selected'" : "").">".$locale['translation_as007']."</option>\n";
	echo "<option value='3'".($tut_cats_colum == "3" ? " selected='selected'" : "").">".$locale['translation_as008']."</option>\n";
	echo "</select></td>\n</tr>\n<tr>\n";
	echo "<td class='tbl1' style='white-space:nowrap'>".$locale['translation_as009']."</td>\n";
	echo "<td class='tbl1'><select name='tut_colum' class='textbox'>\n";
	echo "<option value='1'".($tut_colum == "1" ? " selected='selected'" : "").">".$locale['translation_as006']."</option>\n";
	echo "<option value='2'".($tut_colum == "2" ? " selected='selected'" : "").">".$locale['translation_as007']."</option>\n";
	echo "</select></td>\n</tr>\n<tr>\n";
	echo "<td colspan='2' class='tbl2' width='400'><strong>".$locale['translation_as010']."</strong></td></tr><tr>";
	echo "<td class='tbl1' style='white-space:nowrap'>".$locale['translation_as011']."</td>\n";
	echo "<td class='tbl1'><select name='tut_comments' class='textbox'>\n";
	echo "<option style='color:".$locale['no-color'].";' value='0'".($tut_comments == "0" ? " selected='selected'" : "").">".$locale['translation_g000']."</option>\n";
	echo "<option style='color:".$locale['yes-color'].";' value='1'".($tut_comments == "1" ? " selected='selected'" : "").">".$locale['translation_g001']."</option>\n";
	echo "</select>";
	echo ($tut_settings['tut_comments'] == 0 ? "
	<img src='".INFUSIONS."tutorial_portal_panel/images/off.png' alt='Eingeschalten'/>" : "
	<img src='".INFUSIONS."tutorial_portal_panel/images/on.png' alt='Ausgeschalten'/>");
	echo "</td></tr><tr>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' style='white-space:nowrap'>".$locale['translation_as014']."</td>\n";
	echo "<td colspan='2' class='tbl1'><select name='tut_access' class='textbox' style='width:150px;'>\n".$access_opts."</select></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td colspan='2' class='tbl2' width='400'><strong>Datei Einstellungen</strong></td></tr><tr>";
	echo "<td class='tbl1' style='white-space:nowrap'>Dateitypen</td>\n";
	echo "<td class='tbl1'><input type='text' name='file_types' value='".$sett['file_types']."' maxlength='200' class='textbox' style='width:200px;' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' style='white-space:nowrap'>Datei max. Dateigr&ouml;sse</td>\n";
	echo "<td class='tbl1'><input type='text' name='file_maxsize' value='".$sett['file_maxsize']."' maxlength='12' class='textbox' style='width:120px;' /> ".parsebytesize($sett['file_maxsize'])."</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td align='center' colspan='2' class='tbl1'>";
	echo "<input type='submit' name='save_settings' value='".$locale['translation_as015']."' class='button' style='align:center;' />\n";
	echo "</td></tr>\n</table>\n</form>\n";
	echo "<div style='text-align: right;'><a href='http://fusion-mods.de' target='_blank' title='".$locale['translation_desc']." ".showdate("%Y",time())."'><span class='small'>&copy;</span></a></div>";
closetable();

require_once THEMES."templates/footer.php";
?>