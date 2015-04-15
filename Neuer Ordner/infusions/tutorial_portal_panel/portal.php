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
#if(!iMEMBER){redirect("".INFUSIONS."restricted/index.php"); exit;}
require_once THEMES."templates/header.php";
require_once INCLUDES."comments_include.php";
require_once INCLUDES."ratings_include.php";
require_once INCLUDES."bbcode_include.php";
include INFUSIONS."tutorial_portal_panel/infusion_db.php";
require_once INFUSIONS."tutorial_portal_panel/includes/add.functions.php";
require_once INFUSIONS."tutorial_portal_panel/includes/add.inc.php";
add_to_head("<link rel='stylesheet' href='".INFUSIONS."tutorial_portal_panel/includes/css/add.css' type='text/css' media='screen' />");

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."tutorial_portal_panel/locale/".$settings['locale'].".php")) {
// Load the locale file matching the current site locale setting.
    include INFUSIONS."tutorial_portal_panel/locale/".$settings['locale'].".php";
} 
	else {
// Load the infusion's default locale file.
    include INFUSIONS."tutorial_portal_panel/locale/German.php";
}
if(iMEMBER){
include INFUSIONS."tutorial_portal_panel/includes/add.nav.php";
}


	
if ((isset($_GET['id']) && isnum($_GET['id'])) && (isset($_GET['file_id']) && isnum($_GET['file_id']))) {
$tut_fid = stripinput($_GET['file_id']);
$res = 0;
if ($data = dbarray(dbquery("SELECT tut_id, tut_file, tut_name, tut_kosten, tut_dlaccess, tut_cat FROM ".DB_FUSION_TUTORIAL." WHERE tut_id='".$tut_fid."'"))) {
//*********************************************************************************
//LIzensystem
//*********************************************************************************
$cdata = dbarray(dbquery("SELECT tut_cat_access FROM ".DB_FUSION_TUTORIAL_CATS." WHERE tut_cat_id='".$data['tut_cat']."'"));
if(checkgroup($data['tut_dlaccess']) && (isset($_GET['id']) && isnum($_GET['id'])) && (isset($_GET['file_id']) && isnum($_GET['file_id']))){
$result = dbquery("UPDATE ".DB_FUSION_TUTORIAL." SET tut_fcount=tut_fcount+1 WHERE tut_id='".$tut_fid."'");
include_once INFUSIONS."tutorial_portal_panel/admin/function.php";
DC_LOGSYS(iMEMBER ? $userdata['user_id'] : 0, $data['tut_id']);
$tut_settings = dbarray(dbquery("SELECT * FROM ".DB_FUSION_TUTORIAL_SETTINGS));
if (!empty($data['tut_file']) && file_exists(INFUSIONS."tutorial_portal_panel/files/".$data['tut_file'])) {
$res = 1;
score_free("Download", "TUTOR", "".$data['tut_kosten']."", 9999999, "N", 0, 0);
require_once INCLUDES."class.httpdownload.php";
	ob_end_clean();
	$object = new httpdownload;
	$object->set_byfile(INFUSIONS."tutorial_portal_panel/files/".$data['tut_file']);
	$object->use_resume = true;
	$object->download();
	exit;
	    }
}else{ 
redirect(TUT."restricted.php?re=ndla&amp;pro=".$_GET['id']);	
    }   
}
}

if (isset($_GET['id']) && isnum($_GET['id'])) {
   global $settings;
   $result = dbquery("SELECT p.*, pc.*, u.user_id, u.user_name, u.user_status, u.user_avatar, u.user_birthdate, u.user_lastvisit, u.user_web 
	    FROM ".DB_FUSION_TUTORIAL." p
		LEFT JOIN ".DB_USERS." u ON u.user_id=p.tut_author 
		LEFT JOIN ".DB_FUSION_TUTORIAL_CATS." pc ON pc.tut_cat_id=p.tut_cat
		WHERE tut_id='".$_GET['id']."' LIMIT 0,1");
		$d_files = ""; 
		$err_msg = "";
		if(dbrows($result)) {  $data = dbarray($result); }
		add_to_title("Tutorial-: ".$data['tut_name']."");
		$check['access'] = _CheckaddAccess_($data['tut_cat_access'], $data['tut_access'], $sett['addaccess']);
	 
		if(!$check['access']) {
		opentable("Tutorial- ".$data['tut_name'].""); 
		echo _addAccessMsg_($data['tut_cat_access'], $data['tut_access'], $sett['addaccess']);
		} else { 
		opentable("Tutorial- ".$data['tut_name']."");
		$error = 0;
		if(dbrows($result) !=0) {
		//*****1.Tabelle
echo "<table width='100%' cellpadding='0' cellspacing='0' class='tbl-border center'><tr>";
echo "<td class='tbl2' align='center' style='width: 15%;'><span style='color:green;font-size:12px;'><b>Bezeichnung</b></span></td>";
echo "<td class='tbl2' align='center' style='width: 15%;'><span style='color:green;font-size:12px;'><b>Kategorie</b></span></td>";
echo "<td class='tbl2' align='center' width='15%'><span style='color:green;font-size:12px;'><b>Typ</b></span></td>";
echo "<td class='tbl2' align='center' width='15%'><span style='color:green;font-size:12px;'><b>Kosten</b></span></td>";
echo "<td class='tbl2' align='center' width='15%'><span style='color:green;font-size:12px;'><b>Author</b></span></td>";
echo "<td class='tbl2' align='center' width='15%'><span style='color:green;font-size:12px;'><b>Datum</b></span></td></tr><tr>";
//*****
//*****1.Tabelle
echo "<td class='tbl2' align='center' ><span style='font-weight:bold; font-size: 12px;'>".$data['tut_name']."</span></td>";
echo "<td class='tbl2'  align='center' width=''><img src='".INFUSIONS."tutorial_portal_panel/images/categorys/".$data['tut_cat_image']."' style='border:0px' width='32' height='32' align='middle' alt='".$data['tut_cat_name']."' title='".$data['tut_cat_name']."' /></td>";
//*****2.Tabelle
echo "<td class='tbl2' align='center'><a href='".INFUSIONS."tutorial_portal_panel/translations.php?cat_id=".$data['tut_cat_id']."'>".$data['addon_name']."</a></td>";
//*****3.Tabelle
if(!empty($data['tut_kosten'])) {
echo "<td class='tbl2' align='center'><span style='color:red'>Kosten: ".$data['tut_kosten']." &nbsp;".$score_settings['set_units']."</span></td>";
}else{
echo "<td class='tbl2' align='center'><span style='font-size: 10px;'>0 &nbsp;".$score_settings['set_units']."</span></td>";
}
echo "<td class='tbl2' align='center'>".(isset($data['user_name']) ? (ADDHidden($data['tut_hideauthor']) ? "<span class='devel_hidden'>Hidden</span>" : profile_link($data['user_id'], $data['user_name'], $data['user_status'])) : "<span class='unknown'>Keine Angabe</span>")."</td>";
echo "<td class='tbl2' align='center' >".showdate("%d. %B %Y, %H:%M", $data['tut_created'])."</td></tr>";
	echo prev_nex_add($_GET['id'], $data);
	echo "</div>";
	echo "</table>";
	if($data['tut_author_notice'] != ""){
	echo "<table width='900' border='0' style='margin: 15px auto 0px auto;border-spacing: 2px;border-collapse: separate;' class='tbl-border center'><tr>";
	echo "<td class='tbl2' style='opacity: 0.7;filter: Alpha(opacity=70);font-weight: bold; font-size: 12px;padding: 2px 4px 2px 4px;'>".$locale['translation_v013']."</td>";
	echo "</tr><tr>";
	echo "<td class='tbl2'><center>".nl2br(stripslashes(parseubb(nl2br(htmlspecialchars($data['tut_author_notice'])))))."</center></td>";
	#echo "<td class='tbl2'><center>".nl2br(parseubb(parsesmileys($data['tut_author_notice'])))."</center></td>";
	echo "</tr>";
	echo "</table>";
	}
	if(dbrows($vresult)) {
	$versions = 1;
	echo "<table width='900' style='margin: 15px auto 0px auto;border-spacing: 3px;border-collapse: separate;' border='0' style='margin: 0 auto;' class='tbl-border'><tr>";
	echo "<td colspan='3' class='tbl2' width='190' style='opacity: 0.7;filter: Alpha(opacity=70);font-weight: bold; font-size: 12px;padding: 2px 4px 2px 4px;'>".$locale['translation_v014']."</td></tr><tr>";
	echo "<td class='tbl2' width='190'>".$locale['translation_v016']."</td>";
	echo "<td class='tbl2' width='190'>".$locale['translation_v017']."</td></tr>";
	while($vdata = dbarray($vresult)){
	echo "<tr><td class='tbl1' width='120'><a href='".TUT."portal.php?id=".$vdata['tut_id']."'>".$vdata['tut_version']."</a></td>";
	echo "<td class='tbl1' width='120'>".showdate("%d. %B %Y, %H:%M", $vdata['tut_created'])."</td>";
	echo "<td class='tbl1' width='120'>".($vdata['tut_release'] ? showdate("%d. %B %Y, %H:%M", $vdata['tut_release']) : $locale['translation_g000'])."</td></tr>";
	}
	echo "</table>";
	}
	
	list($tut_name) = dbarraynum(dbquery("SELECT tut_name FROM ".DB_FUSION_TUTORIAL." WHERE tut_id=".$_GET['id'].""));
	$sresult = dbquery("SELECT p.*, pc.*,  u.user_id, u.user_name, u.user_status, u.user_avatar
			FROM ".DB_FUSION_TUTORIAL." p
			LEFT JOIN ".DB_USERS." u ON u.user_id=p.tut_author
			LEFT JOIN ".DB_FUSION_TUTORIAL_CATS." pc ON pc.tut_cat_id=p.tut_cat
			WHERE MATCH (p.tut_name) AGAINST ('".$tut_name."' IN BOOLEAN MODE) AND tut_id !='".$_GET['id']."' AND ".groupaccess('tut_access')." ORDER BY tut_created DESC LIMIT 10");
			
if(dbrows($sresult)){
	echo "<table width='900' style='margin: 15px auto 10px auto;border-spacing: 3px;border-collapse: separate;' border='0' style='margin: 0 auto;' class='tbl-border'><tr>";
	echo "<td colspan='4' class='tbl2' width='190' style='opacity: 0.7;filter: Alpha(opacity=70);font-weight: bold; font-size: 12px;padding: 2px 4px 2px 4px;'>".$locale['translation_v022']."</td></tr><tr>";
	echo "<td width='200' class='tbl1'>".$locale['translation_v023']."</td>";
	echo "<td width='135' class='tbl1'>".$locale['translation_v024']."</td>";
	echo "<td width='135' class='tbl1'>".$locale['translation_v025']."</td>";
	echo "<td width='135' class='tbl1'>".$locale['translation_v026']."</td>";
	echo "</tr>\n";
	$i = 0;
	while($similar = dbarray($sresult)){
    $new = ($similar['tut_created'] + 172800 > time() + ($settings['timeoffset'] * 3600) ? "<span title='".$locale['translation_g011']."' class='new'>
	<a href='".FUSION_SELF."?id=".$similar['tut_id']."'>".$similar['tut_name']."</a></span>" : "");
	$row = ($i % 2 == 0 ? "tbl1" : "tbl2");
	echo "<tr><td class='tbl1' width='200'>".($new != "" ? $new : "<a href='".TUT."portal.php?id=".$similar['tut_id']."'>".$similar['tut_name']."</a>")."</td>";
	echo "<td class='tbl1' width='135' ><a href='".TUT."translations.php?cat_id=".$similar['tut_cat_id']."'>".$similar['tut_cat_name']."</a></td>";
	echo "<td class='tbl1' width='135'>".(ADDHidden($similar['tut_hideauthor']) ? "<span class='devel_hidden'>Versteckt</span>" : profile_link($similar['user_id'], $similar['user_name'], $similar['user_status']))."</td>";
	echo "<td class='tbl1' width='135'>".showdate("forumdate", $similar['tut_created'])."</td></tr>";
	$i++;
}
	echo "</table>";
	}
	$kosten = $data['tut_kosten'];
	$d_file = "";
	#if ( score_account_stand() > $kosten ) {
	if(iGUEST){
	if (!empty($data['tut_file']) && file_exists(TUT_FILE.$data['tut_file'])) {	
	if (!checkgroup($data['tut_dlaccess'])) {
	$d_file .= "<div class='pro-dl-no'><center>Du hast keinen Zugang zu dem Download!<center>";
	#$d_file .= "<div class='pro-dl-no'><span style='text-decoration: line-through;'>Download</span> (".parsebytesize(filesize(INFUSIONS."tutorial_portal_panel/files/".$data['tut_file'])).")";
	$d_file .= "<span style='text-decoration: line-through;'><img src='".INFUSIONS."tutorial_portal_panel/images/down.png' width='48' height='48' style='border: 0px;' alt=''/></span>
	<br /><a href='".BASEDIR."login.php'> Logge</a> dich bitte ein oder <a href='".BASEDIR."register.php'>Registriere </a>dich.<center></div>";
	}
	}
	}
	if(iMEMBER){
	//if ( score_account_stand() > $kosten ) {
	if (!checkgroup($data['tut_dlaccess'])) {
	$d_file .= "<div style='margin: 1px auto 0 auto; text-align: center; color: red;font-weight: bold;'>".$locale['translation_e003']."</div>";
	} else {if (!file_exists(TUT_FILE.$data['tut_file'])) { break; }
	$d_file .= "<div class='pro-dl-yes'><div style=' text-align:center; font-weight: bold; font-size: 14px;'><span style='color:green;'><b>[Download &nbsp;".$data['tut_name']."]</b></span></div>
	<a href='".FUSION_SELF."?id=".$data['tut_id']."&amp;file_id=".$data['tut_id']."' target='_blank'><center>
	<img src='".INFUSIONS."tutorial_portal_panel/images/download.png' width='48' height='48' style='border: 0px;' alt=''/><br /></a> (".parsebytesize(filesize(INFUSIONS."tutorial_portal_panel/files/".$data['tut_file'])).")";
	$d_file .= "<br />Heruntergeladen ".$data['tut_fcount']." mal<br />Downloadkosten:".$data['tut_kosten']."</div></div></center><br />";
	//}
	}
	}
	//****5.Tabelle
	#if(iMEMBER){
	#$d_file .= "<div class='pro-dl-no'><center><span style='color:red;font-size:12px;'>Hinweis:";
	#$d_file .= "<br />Kostebzug: ".$data['tut_kosten']." ".$score_settings['set_units']."</span></center></div>";
	#}
	//*************
	if($d_file){
	echo $d_file;
	}
	}	
	}
	}
	echo "<div style='text-align: right;'><a href='http://fusion-mods.de' target='_blank' title='".$locale['translation_desc']." ".showdate("%Y",time())."'><span class='small'>&copy;</span></a></div>";
	closetable();
	
if ($data['tut_allow_ratings'] == 0 || !$check['access']) { 
		opentable($locale['translation_v032']);
		echo "<div class='ratings-disabled'>".$locale['translation_v033']."</div>";
		closetable();
		} else {
		showratings("J", $_GET['id'], FUSION_SELF."?id=".$_GET['id']); 
	}  
if ($data['tut_allow_comments'] == 0 || $sett['devcomments'] == 0 || !$check['access']) { 
		opentable($locale['translation_v034']);
		echo "<div class='comments-disabled'>".$locale['translation_v035']."</div>";
		closetable();
		} else {
		showcomments("DP", DB_FUSION_TUTORIAL, "tut_id", $_GET['id'], FUSION_SELF."?id=".$_GET['id']); 
		}
require_once THEMES . "templates/footer.php";
?>