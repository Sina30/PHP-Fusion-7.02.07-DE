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

if (!checkrights("TUTP") || !defined("iAUTH") || !isset($_GET['aid']) || $_GET['aid'] != iAUTH) redirect("../index.php");

include INFUSIONS."tutorial_portal_panel/admin/admin_navigation.php";

if (isset($_GET['status']) && !isset($message)) {
if ($_GET['status'] == "sn") {
$message = $locale['translation_ac000'];
} elseif ($_GET['status'] == "su") {
$message = $locale['translation_ac001'];
} elseif ($_GET['status'] == "deln") {
$message = $locale['translation_ac002']."<br />\n<span class='small'>".$locale['translation_ac003']."</span>";
} elseif ($_GET['status'] == "dely") {
$message = $locale['translation_ac004'];
}
if ($message) {	echo "<div id='close-message'><div class='admin-message'>".$message."</div></div>\n"; }
}

if ((isset($_GET['action']) && $_GET['action'] == "delete") && (isset($_GET['cat_id']) && isnum($_GET['cat_id']))) {
$result = dbcount("(tut_id)", DB_FUSION_TUTORIAL, "tut_cat='".$_GET['cat_id']."'");
if (!empty($result)) {
redirect(FUSION_SELF.$aidlink."&status=deln");
} else {
$result = dbquery("DELETE FROM ".DB_FUSION_TUTORIAL_CATS." WHERE tut_cat_id='".$_GET['cat_id']."'");
redirect(FUSION_SELF.$aidlink."&status=dely");
}
} else {
if (isset($_POST['save_cat'])) {
$tut_cat_name = stripinput($_POST['tut_cat_name']);
$addon_name = stripinput($_POST['addon_name']);
$tut_cat_description = stripinput($_POST['tut_cat_description']);
$tut_cat_image = stripinput($_POST['tut_cat_image']);
$tut_cat_access = isnum($_POST['tut_cat_access']) ? $_POST['tut_cat_access'] : "0";
if (isnum($_POST['cat_sort_by']) && $_POST['cat_sort_by'] == "1") {
$tut_cat_sorting = "tut_id ".($_POST['cat_sort_order'] == "ASC" ? "ASC" : "DESC");
} else if (isnum($_POST['cat_sort_by']) && $_POST['cat_sort_by'] == "2") {
$tut_cat_sorting = "tut_name ".($_POST['cat_sort_order'] == "ASC" ? "ASC" : "DESC");
} else if (isnum($_POST['cat_sort_by']) && $_POST['cat_sort_by'] == "3") {
$tut_cat_sorting = "tut_created ".($_POST['cat_sort_order'] == "ASC" ? "ASC" : "DESC");
} else {
$tut_cat_sorting = "tut_created ASC";
}
if ($tut_cat_name) {
if ((isset($_GET['action']) && $_GET['action'] == "edit") && (isset($_GET['cat_id']) && isnum($_GET['cat_id']))) {
$result = dbquery("UPDATE ".DB_FUSION_TUTORIAL_CATS." SET tut_cat_name='$tut_cat_name', addon_name='$addon_name', tut_cat_description='$tut_cat_description',
tut_cat_image='$tut_cat_image', tut_cat_sorting='$tut_cat_sorting', tut_cat_access='$tut_cat_access' WHERE tut_cat_id='".$_GET['cat_id']."'");
redirect(FUSION_SELF.$aidlink."&status=su");
} else {
$checkCat = dbcount("(tut_cat_id)", DB_FUSION_TUTORIAL_CATS, "tut_cat_name='".$tut_cat_name."'");
if ($checkCat == 0) {
$result = dbquery("INSERT INTO ".DB_FUSION_TUTORIAL_CATS." (tut_cat_name, addon_name, tut_cat_description, tut_cat_image,
tut_cat_sorting, tut_cat_access) VALUES ('$tut_cat_name','$addon_name', '$tut_cat_description', '$tut_cat_image', '$tut_cat_sorting', '$tut_cat_access')");
redirect(FUSION_SELF.$aidlink."&status=sn");
} else {
$error = 2;
}
}
} else {
$error = 1;
}
}
if ((isset($_GET['action']) && $_GET['action'] == "edit") && (isset($_GET['cat_id']) && isnum($_GET['cat_id']))) {
$result = dbquery("SELECT tut_cat_name, addon_name, tut_cat_description, tut_cat_image, tut_cat_sorting, tut_cat_access FROM ".DB_FUSION_TUTORIAL_CATS." WHERE tut_cat_id='".$_GET['cat_id']."'");
if (dbrows($result)) {
$data = dbarray($result);
$tut_cat_name = $data['tut_cat_name'];
$addon_name = $data['addon_name'];
$tut_cat_description = $data['tut_cat_description'];
$tut_cat_image = $data['tut_cat_image'];
$tut_cat_sorting = explode(" ", $data['tut_cat_sorting']);
if ($tut_cat_sorting[0] == "tut_id") { $cat_sort_by = "1"; }
elseif ($tut_cat_sorting[0] == "tut_name") { $cat_sort_by = "2"; }
else { $cat_sort_by = "3"; }
$cat_sort_order = $tut_cat_sorting[1];
$tut_cat_access = $data['tut_cat_access'];
$formaction = FUSION_SELF.$aidlink."&amp;action=edit&amp;cat_id=".$_GET['cat_id'];
$openTable = $locale['translation_ac005']."<span style='color:#ff0000;'>".$tut_cat_name."</span>";
} else {
redirect(FUSION_SELF.$aidlink);
}
} else {
$tut_cat_name = "";
$addon_name = "";
$tut_cat_description = "";
$tut_cat_image = "";
$cat_sort_by = "tut_name";
$cat_sort_order = "ASC";
$tut_cat_access = "";
$formaction = FUSION_SELF.$aidlink;
$openTable = $locale['translation_ac006'];
}
$user_groups = getusergroups(); $access_opts = ""; $sel = "";
while(list($key, $user_group) = each($user_groups)){
$sel = ($tut_cat_access == $user_group['0'] ? " selected='selected'" : "");
$access_opts .= "<option value='".$user_group['0']."'$sel>".$user_group['1']."</option>\n";
}
$image_list = makefileopts(makefilelist(INFUSIONS."tutorial_portal_panel/images/categorys/", ".|..|index.php|Thumbs.db"), $tut_cat_image);
if (isset($error) && isnum($error)) {
if ($error == 1) {
$errorMessage = "Bitte gib einen Kategorienamen ein.";
} elseif ($error == 2) {
$errorMessage = "Diese Kategorie existiert bereits.";
}
if ($errorMessage) { echo "<div id='close-message'><div class='admin-message'>".$errorMessage."</div></div>\n"; }
}
opentable($openTable);
echo "<form name='addcat' method='post' action='".$formaction."'>\n";
echo "<table cellpadding='0' cellspacing='0' width='400' class='center'>\n<tr>\n";
echo "<td width='1%' class='tbl' style='white-space:nowrap'>".$locale['translation_ac007']."</td>\n";
echo "<td class='tbl'><input type='text' name='tut_cat_name' value='".$tut_cat_name."' class='textbox' style='width:200px;' /></td>\n";
echo "</tr>\n<tr>\n";
echo "<td width='1%' class='tbl' style='white-space:nowrap'>Addon-Typ</td>\n";
echo "<td class='tbl'><input type='text' name='addon_name' value='".$addon_name."' class='textbox' style='width:100px;' /></td>\n";
echo "</tr>\n<tr>\n";
echo "<td width='1%' class='tbl' style='white-space:nowrap'>".$locale['translation_ac009']."</td>\n";
echo "<td class='tbl'><select name='cat_sort_by' class='textbox'>\n";
echo "<option value='1'".($cat_sort_by == "1" ? " selected='selected'" : "").">".$locale['translation_ac010']."</option>\n";
echo "<option value='2'".($cat_sort_by == "2" ? " selected='selected'" : "").">".$locale['translation_ac011']."</option>\n";
echo "<option value='3'".($cat_sort_by == "3" ? " selected='selected'" : "").">".$locale['translation_ac012']."</option>\n";
echo "</select> - <select name='cat_sort_order' class='textbox'>\n";
echo "<option value='ASC'".($cat_sort_order == "ASC" ? " selected='selected'" : "").">".$locale['translation_ac013']."</option>\n";
echo "<option value='DESC'".($cat_sort_order == "DESC" ? " selected='selected'" : "").">".$locale['translation_ac014']."</option>\n";
echo "</select></td>\n";
echo "</tr>\n<tr>\n";
echo "<td width='1%' class='tbl' style='white-space:nowrap'>".$locale['translation_ac015']."</td>\n";
echo "<td class='tbl'><select name='tut_cat_access' class='textbox' style='width:150px;'>\n".$access_opts."</select></td>\n";
echo "</tr>\n<tr>\n";
echo "<td width='1%' class='tbl' style='white-space:nowrap'>".$locale['translation_ac016']."</td>\n";
echo "<td class='tbl'><select name='tut_cat_image' class='textbox' style='width:150px;'>\n".$image_list."</select></td>\n";
echo "</tr>\n<tr>\n";
echo "<td align='center' colspan='2' class='tbl'>\n";
echo "<input type='submit' name='save_cat' value='".$locale['translation_ac017']."' class='button' /></td>\n";
echo "</tr>\n</table>\n</form>\n";
echo "<div style='text-align: right;'><a href='http://fusion-mods.de' target='_blank' title='".$locale['translation_desc']." ".showdate("%Y",time())."'><span class='small'>&copy;</span></a></div>";
closetable();
opentable($locale['cat_open']);
echo "<table cellpadding='0' cellspacing='1' width='100%' class='tbl-border center'>\n";
$result = dbquery("SELECT tut_cat_id, tut_cat_name, addon_name, tut_cat_description, tut_cat_image, tut_cat_access FROM ".DB_FUSION_TUTORIAL_CATS." ORDER BY tut_cat_name");
if (dbrows($result) != 0) {
$i = 0;
echo "<tr>\n";
echo "<td align='center' valign='top'><span style='color:green;font-size:12px;'>Grafik</span></td>\n";
echo "<td align='center' valign='top'><span style='color:green;font-size:12px;'>".$locale['cat_name']."</span></td>\n";
echo "<td align='center' valign='top'><span style='color:green;font-size:12px;'>Addon-Typ</span></td>\n";
echo "<td align='center' valign='top'><span style='color:green;font-size:12px;'>".$locale['cat_zu']."</span></td>\n";
echo "<td align='center' valign='top'><span style='color:green;font-size:12px;'>".$locale['translation_g003']."</span></td>\n";
echo "</tr>\n";
while ($data = dbarray($result)) {
$cell_color = ($i % 2 == 0 ? "tbl1" : "tbl2");
echo "<tr>\n";
echo "<td align='center' width='3%' class='$cell_color' style='white-space:nowrap'>
<img src='".INFUSIONS."tutorial_portal_panel/images/categorys/".$data['tut_cat_image']."' style='border:0px' width='28' height='28' /></td>\n";
echo "<td align='center' width='1%' class='$cell_color' style='white-space:nowrap'>".$data['tut_cat_name']."\n";
echo "<td align='center' width='1%' class='$cell_color' style='white-space:nowrap'>".$data['addon_name']."</td>\n";
echo ($data['translation_cat_description'] ? "<br />\n<span class='small'>".trimlink($data['tut_cat_description'], 45)."</span>" : "")."</td>\n";
echo "<td align='center' width='1%' class='$cell_color' style='white-space:nowrap'>".getgroupname($data['tut_cat_access'])."</td>\n";
echo "<td align='center' width='1%' class='$cell_color' style='white-space:nowrap'><a href='".FUSION_SELF.$aidlink."&amp;action=edit&amp;cat_id=".$data['tut_cat_id']."'>".$locale['translation_g004']."</a> -\n";
echo "<a href='".FUSION_SELF.$aidlink."&amp;action=delete&amp;cat_id=".$data['tut_cat_id']."' onclick=\"return confirm('".$locale['translation_ac021']."');\">".$locale['translation_g005']."</a></td>\n";
echo "</tr>\n";
$i++;
}
echo "</table>\n";
} else {
echo "<tr><td align='center' class='tbl1'>".$locale['no_cat']."</td></tr>\n</table>\n";
}
echo "<div style='text-align: right;'><a href='http://fusion-mods.de' target='_blank' title='".$locale['translation_desc']." ".showdate("%Y",time())."'><span class='small'>&copy;</span></a></div>";
closetable();
}
require_once THEMES."templates/footer.php";
?>