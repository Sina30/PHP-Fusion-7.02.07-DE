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
require_once "../../maincore.php";
require_once THEMES."templates/header.php";
require_once INCLUDES."comments_include.php";
require_once INCLUDES."bbcode_include.php";
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
	include INFUSIONS."tutorial_portal_panel/includes/add.nav.php";

if(checkgroup($sett['addaccess'])) {
if(!isset($_GET['cat_id']) || !isnum($_GET['cat_id'])) {
    if(isset($_GET['page'])){ 
	tut_page($_GET['page']); 
	} else {
	opentable($locale['translation_d000']);
if (!isset($_GET['rowstart']) || !isnum($_GET['rowstart'])) { $_GET['rowstart'] = 0; }
	$rows = dbcount("(tut_cat_id)", DB_FUSION_TUTORIAL_CATS);
	if ($rows != 0) {
	$counter = 0; $columns = $sett['catcolum']; 
	if($columns == 1){
	$table_w_c = "width='20%' class='tbl-border center'";
	} else if($columns == 2){
	$table_w_c = "width='100%' class='tbl-border center'";
	$sett['cats_perpage'] = ($sett['cats_perpage']*2);
	} else if($columns == 3){
	$table_w_c = "width='100%' class='tbl-border center'";
	$sett['cats_perpage'] = ($sett['cats_perpage']*3);
	}
	echo "<table cellpadding='0' cellspacing='0' ".$table_w_c.">\n<tr>\n";
	$result = dbquery(
	"SELECT tut_cat_id, tut_cat_name, tut_cat_description, tut_cat_image 
	FROM ".DB_FUSION_TUTORIAL_CATS." 
	WHERE ".groupaccess('tut_cat_access')." 
	ORDER BY tut_cat_name ASC LIMIT ".$_GET['rowstart'].",".$sett['cats_perpage']);
	while ($data = dbarray($result)) {
	if ($counter != 0 && ($counter % $columns == 0)) { echo "</tr>\n<tr>\n"; }
	$num = dbcount("(tut_id)", DB_FUSION_TUTORIAL, "tut_cat='".$data['tut_cat_id']."'");
	echo "<td valign='top' width='40%' class='tbl'><div style='float:center;margin-right:4px;'>";
	if ($data['tut_cat_image'] && file_exists(TUT_CATS.$data['tut_cat_image'])) {
	echo "<center><a href='".FUSION_SELF."?cat_id=".$data['tut_cat_id']."'>
	<img src='".TUT_CATS.$data['tut_cat_image']."' alt='".$data['tut_cat_name']."' title='".$data['tut_cat_name']."' style='border:0px' width='35' height='35' /></a>";
	} else {
	echo "<img src='".TUT_CATS."default.png' alt='".$data['tut_cat_name']."' style='border:0px' />";
	}
	echo "</center></div>"; 
	$count_new = dbcount("(tut_id)", DB_FUSION_TUTORIAL, "tut_created+86999 > ".time()."+".$settings['timeoffset']."*3600 AND tut_cat='".$data['tut_cat_id']."'");
	echo "<div class='d-mt-10'><span class='dev-number".($num == 0 ? " red" : " normal")."'>$num</span>";
	if($num != 0){
	echo " <a href='".FUSION_SELF."?cat_id=".$data['tut_cat_id']."'>".$data['tut_cat_name']."</a> ";
	} else {
    echo " <span style='text-decoration: line-through;color:#db3a27;'>".$data['tut_cat_name']."</span> "; 
	}	
	echo "<span class='small2'>".($count_new > 0 ? "<span class='new-translation'><span>".$count_new.$locale['translation_d001']."</span></span>" : "")."</span>";
	if ($data['tut_cat_description'] != "") { 
	echo "<br />\n<div style='margin: 0 0 0 55px;padding: 2px 0px 2px 15px;' class='small'>".$data['tut_cat_description']."</div>"; 
	}
	echo "</div></td>\n";
	$counter++;
	}
	echo "</tr>\n</table>\n";
	} else {
	echo "<div style='text-align:center'><br />\n".$locale['translation_d002']."<br /><br />\n</div>\n";
	}
	echo "<table cellpadding='0' cellspacing='1' class='tbl-border' style='width:100%;'>\n";
    echo "<tr>\n<td class='tbl2' valign='middle'><img style='vertical-align: middle; border: 0px; width='48' height='48' margin-right: 2px' src='".TUT_IMG."statistik.png' alt='Statsistik' title='Statistik' /></td>\n";
    echo "<td width='100%' align='left' class='tbl1'>\n";
    echo "<span class='small'>".$locale['translation_ds009'].dbcount("(tut_id)", DB_FUSION_TUTORIAL)."</span><br />\n";
    $dd_result = dbquery(
	"SELECT p.tut_id, p.tut_author, u.user_id, u.user_name, u.user_status 
	FROM ".DB_FUSION_TUTORIAL." p 
    LEFT JOIN ".DB_USERS." u ON u.user_id=p.tut_author
    GROUP BY p.tut_author DESC LIMIT 0,1");
    if (dbrows($dd_result)) {
	$dd_data = dbarray($dd_result);
	echo "<span class='small'>".$locale['translation_ds010'].profile_link($dd_data['user_id'], $dd_data['user_name'], $dd_data['user_status'])."</span><br />\n";
	}
    $result = dbquery(
	"SELECT p.*, pc.tut_cat_access, pc.tut_cat_id, pc.tut_cat_name
    FROM ".DB_FUSION_TUTORIAL." p 
	LEFT JOIN ".DB_FUSION_TUTORIAL_CATS." pc ON p.tut_cat=pc.tut_cat_id
	WHERE ".groupaccess('p.tut_access')." OR ".groupaccess('pc.tut_cat_access')."
	ORDER BY p.tut_created DESC LIMIT 0,1");
    if (dbrows($result) != 0) {
	$data = dbarray($result);
	echo "<span class='small'>".$locale['translation_ds011']."<a href='".TUT."portal.php?id=".$data['tut_id']."' title='".$data['tut_name']."'>".trimlink($data['tut_name'], 100)."</a></span>";
	}
    echo "</td>\n</tr>\n</table>\n";
	echo "<div style='text-align: right;'><a href='http://fusion-mods.de' target='_blank' title='".$locale['translation_desc']." ".showdate("%Y",time())."'><span class='small'>&copy;</span></a></div>";
	closetable();
	if ($rows > $sett['cats_perpage']) { 
	echo "<div align='center' style='margin-top:5px;'>\n".makepagenav($_GET['rowstart'], $sett['cats_perpage'], $rows, 3, FUSION_SELF."?")."\n</div>\n"; 
	}
	}
	} else {
    global $settings;
	$res = 0;
	$result = dbquery("SELECT tut_cat_name, tut_cat_sorting, tut_cat_access FROM ".DB_FUSION_TUTORIAL_CATS." WHERE tut_cat_id='".$_GET['cat_id']."'");
    if (dbrows($result) != 0) {
	$cdata = dbarray($result);
	if (checkgroup($cdata['tut_cat_access'])) {
	$res = 1;
	opentable("Tutorial-Kategorie: ".$cdata['tut_cat_name']);
	$cat_list_result = dbquery(
	"SELECT tut_cat_id, tut_cat_name
	FROM ".DB_FUSION_TUTORIAL_CATS." 
	WHERE ".groupaccess('tut_cat_access')."
	ORDER BY tut_cat_name");
	$cats_list = ""; $filter = ""; $order_by = ""; $sort = ""; $getString = "";
	if (dbrows($cat_list_result)) {
	while ($cat_list_data = dbarray($cat_list_result)) {
	$sel = (isset($_GET['cat_id']) && $_GET['cat_id'] == $cat_list_data['tut_cat_id'] ? " selected='selected'" : "");
	$cats_list .= "<option value='".$cat_list_data['tut_cat_id']."'".$sel.">".$cat_list_data['tut_cat_name']."</option>";
	}
	if (!isset($_GET['rowstart']) || !isnum($_GET['rowstart']) || $_GET['rowstart'] > dbrows($cat_list_result)) { $_GET['rowstart'] = 0; }
	if (isset($_GET['cat_id']) && isnum($_GET['cat_id']) && $_GET['cat_id'] != "all") {
	$filter .= " AND tut_cat_id='".$_GET['cat_id']."'";
	$order_by_allowed = array("tut_id", "tut_name", "tut_author", "tut_fcount", "tut_created");
	if (isset($_GET['orderby']) && in_array($_GET['orderby'], $order_by_allowed)) {
	$order_by = $_GET['orderby'];
	$getString .= "&amp;orderby=".$order_by;
	} else {
	$order_by = "";
	}
	if (isset($_GET['sort']) && $_GET['sort'] == "DESC") {
	$sort = "DESC";
	$getString .= "&amp;sort=DESC";
	} else {
	$sort = "ASC";
	}
	} else {
	$filter = ""; $order_by = ""; $sort = ""; 
	}
	echo "<form name='filter_form' method='get' action='".FUSION_SELF."'>\n";
	echo "<table id='iseqchart'><tr>";
	echo "<tr>\n";
	echo "<td class='ftl-panel-top index-border1' style='width:80%; text-align:right;'>".$locale['translation_d003']."\n";
	echo "<select name='cat_id' class='textbox' onchange='this.form.submit();'>\n";
	echo "<option value='all'>".$locale['translation_d004']."</option>".$cats_list."</select>\n";
	echo "</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td class='ftl-panel-top index-border1' style='width:60%; text-align:right;'>";
	echo "<input id='filter_button' type='submit' class='button' value='Submit' />";
	echo "</td>\n";
	echo "</tr>\n";
	echo "</table>\n</form>\n";
	echo "<script language='JavaScript' type='text/javascript'>\n";
	echo "/* <![CDATA[ */\n";
	echo "jQuery(document).ready(function() {
		jQuery('#filter_button').hide();
		});";
	echo "/* ]]>*/\n";
	echo "</script>\n";
	}
	$rows = dbcount("(tut_id)", DB_FUSION_TUTORIAL, "tut_cat='".$_GET['cat_id']."'");
    if (!isset($_GET['rowstart']) || !isnum($_GET['rowstart'])) { $_GET['rowstart'] = 0; }
	if ($rows != 0) {
	$result = dbquery("SELECT p.*, u.user_id, u.user_name, u.user_status
	FROM ".DB_FUSION_TUTORIAL." p 
	LEFT JOIN ".DB_USERS." u ON u.user_id=p.tut_author 
	WHERE tut_cat='".$_GET['cat_id']."'
	ORDER BY ".($order_by =="" ? $cdata['tut_cat_sorting'] : $order_by." ".$sort)." LIMIT ".$_GET['rowstart'].",".$sett['perpage']);
	$numrows = dbrows($result); $i = 1;
	$counter = 0; 
	$columns = $sett['devcolum']; 
	echo "<table cellpadding='0' cellspacing='1' width='100%' class='tbl-border center'>\n";
	while ($data = dbarray($result)) {
	if ($counter != 0 && ($counter % $columns == 0)) { 
	echo "</tr>\n<tr>\n<tr>\n";
	echo "<td colspan='2' class='tbl1 forum_thread_post_space' style='height:10px'></td>\n</tr>\n"; }
	$tut['new'] = ($data['tut_created'] + 86999 > time() + ($settings['timeoffset'] * 3600));
    $tut['updated'] = ($data['tut_updated'] + 86999 > time() + ($settings['timeoffset'] * 3600));
	if($tut['new'] && !$tut['updated']){
	$tut['name'] = "<span title='".$locale['translation_g011']."' class='new'>
	<a style='font-weight: 600; font-size: 12px;' href='".TUT."portal.php?id=".$data['tut_id']."&cat_id=".$data['tut_cat']."'>".trimlink($data['tut_name'], 30)."</a></span>";
	} else if($tut['updated']){
    $tut['name'] = "<span title='".$locale['translation_g012']."' class='updated'>
	<a style='font-weight: 600; font-size: 12px;' href='".TUT."portal.php?id=".$data['tut_id']."&cat_id=".$data['tut_cat']."'>".trimlink($data['tut_name'], 10)."</a></span>";
    } else {
    $tut['name'] = "<a style='font-weight: 600; font-size: 12px;' href='".TUT."portal.php?id=".$data['tut_id']."&cat_id=".$data['tut_cat']."'>".trimlink($data['tut_name'], 10)."</a>";
    }
	echo "<td valign='center' width='50%' class='tbl2'>";
	echo "<div class='tbl2'>".$tut['name']."</div>";
	echo "<div class='tbl2' style='margin: 5px 0 0 0;text-align:center;font-weight: bold; font-size: 13px;'>."; 
	echo "</div></div><div class='d-mt-10'>";
	echo "<div class='development-info'>";
	echo "<div class='tbl2' style='float: left;'>".$locale['translation_d015'].(ADDHidden($data['tut_hideauthor']) ? " <span class='devel_hidden'>Versteckt</span>" : profile_link($data['user_id'], $data['user_name'], $data['user_status']));
	$tut['_st-text'] = ($data['tut_access'] == 0 ? $locale['translation_d016'] : ($data['tut_access'] == 101 ? $locale['translation_d017'] : ""));
	$comments_result = dbquery("SELECT dd.*, COUNT(comment_item_id) AS tut_comments 
	FROM ".DB_FUSION_TUTORIAL." dd 
	LEFT JOIN ".DB_COMMENTS." ON dd.tut_id=comment_item_id AND comment_type='DP'
    WHERE tut_id='".$data['tut_id']."' GROUP BY dd.tut_id");
	$comment_data = dbarray($comments_result);
	echo "<div style='margin: 2px 0 0 0;'>".$locale['translation_d021'].($data['tut_allow_comments'] == "1" ? "<span class='dev-info-text".($comment_data['tut_comments'] == 0 ? " red'>0
	</span>" : "'>".$comment_data['tut_comments']."</span>") : "<span class='dev-info-text red'>".$locale['translation_d022']."</span>")."</div>";
	echo "</div></div></div>\n";
	echo "</td>\n";
	$counter++; $i++;
	}
	echo "</tr>\n</table>\n";
	closetable();
	if ($rows > $sett['perpage']) { echo "<div align='center' style='margin-top:5px;'>\n".makepagenav($_GET['rowstart'], $sett['perpage'], $rows, 3, FUSION_SELF."?cat_id=".$_GET['cat_id']."&amp;")."\n</div>\n"; }
	} else {
	echo "".$locale['translation_d023']."\n";
	closetable();
	}
	}
	}
	if ($res == 0) { redirect(FUSION_SELF); }
	}
	}else { 
	opentable($locale['hinweis']);
	echo "<div class='access-denied'>".$locale['translation_e002']."</div>";
	closetable(); 
	}
	require_once THEMES . "templates/footer.php";
?>