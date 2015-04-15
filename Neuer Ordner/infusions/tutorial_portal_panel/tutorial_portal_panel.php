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
if (!defined("IN_FUSION")) {  die("Access Denied"); }
include INFUSIONS."tutorial_portal_panel/infusion_db.php";
require_once INCLUDES."bbcode_include.php";
require_once INFUSIONS."tutorial_portal_panel/includes/add.functions.php";
require_once INFUSIONS."tutorial_portal_panel/includes/add.inc.php";
add_to_head ('<link rel="stylesheet" href="'.INFUSIONS.'tutorial_portal_panel/includes/css/add1.css"/>');
if (file_exists(INFUSIONS."tutorial_portal_panel/locale/".$settings['locale'].".php")) {
    include INFUSIONS."tutorial_portal_panel/locale/".$settings['locale'].".php";
} else {
    include INFUSIONS."tutorial_portal_panel/locale/German.php";
}

  global $settings;
opentable("".$locale['translation_dip000']."-<font color='#ff0000'>Testlauf</font>");
  #echo "<table cellpadding='0' cellspacing='0' width='100%' class='tbl-border center'>\n<tr>\n";
  echo "<table id='iseqchart'><tr>";
  echo "<td class='ftl-panel-top index-border1' style='text-align:center;white-space:nowrap'><span style='color:green;font-size:12px;'><b>Name</b></span></td>\n";
  echo "<td class='ftl-panel-top index-border1' style='text-align:center;white-space:nowrap' align='center'><span style='color:green;font-size:12px;'><b>Kategorie</b></span></td>\n";
  echo "<td class='ftl-panel-top index-border1' style='text-align:center;white-space:nowrap' align='center'><span style='color:green;font-size:12px;'><b>Abzug</b></span></td>\n";
  echo "<td class='ftl-panel-top index-border1' style='text-align:center;white-space:nowrap' align='center'><span style='color:green;font-size:12px;'><b>".$locale['translation_dip004']."</b></span></td>\n";
  echo "<td class='ftl-panel-top index-border1' style='text-align:center;white-space:nowrap' align='center'><span style='color:green;font-size:12px;'><b>Erstellt von</b></span></td>\n";
  echo "</tr>\n";
  $result = dbquery("SELECT p.*, pc.*, u.user_id, u.user_name, u.user_status, u.user_avatar 
            FROM ".DB_FUSION_TUTORIAL." p 
			LEFT JOIN ".DB_USERS." u ON u.user_id=p.tut_author
			LEFT JOIN ".DB_FUSION_TUTORIAL_CATS." pc ON pc.tut_cat_id=p.tut_cat
			WHERE ".groupaccess('p.tut_access')." 
			ORDER BY p.tut_created DESC LIMIT 5");
  if (dbrows($result)) {
  $p = 0;
  while($data = dbarray($result)) {
   $tut['new'] = ($data['tut_created'] + 86999 > time() + ($settings['timeoffset'] * 3600));
   $tut['updated'] = ($data['tut_updated'] + 86999 > time() + ($settings['timeoffset'] * 3600));
if($tut['new'] && !$tut['updated']){
	$tut['name'] = "<span title='".$locale['translation_g011']."'><a href='".TUT."portal.php?id=".$data['tut_id']."&cat_id=".$data['tut_cat']."'>".trimlink($data['tut_name'], 10)."</a>
	</span>";
} else if($tut['updated']){
    $tut['name'] = "<span title='".$locale['translation_g012']."'><a href='".TUT."portal.php?id=".$data['tut_id']."'>".trimlink($data['tut_name'], 10)."</a></span>";
   } else {
    $tut['name'] = "<a href='".TUT."portal.php?id=".$data['tut_id']."&cat_id=".$data['tut_cat']."'>".trimlink($data['tut_name'], 10)."</a>";
}
     echo "<td class='tbl2' style='text-align:center;'>".$tut['name'];
	if(!empty($data['tut_file']) && file_exists(TUT_FILE.$data['tut_file'])){
	echo "<div title='".$locale['translation_dip010']."' style='float:right;margin-bottom: 5px; margin-right: 5px;'></div>";	
	}
	 echo "</td>\n";
     echo "<td class='tbl2' style='text-align:center;'><a href='".INFUSIONS."tutorial_portal_panel/translations.php?cat_id=".$data['tut_cat_id']."'>
	 <img src='".INFUSIONS."tutorial_portal_panel/images/categorys/".$data['tut_cat_image']."' style='border:0px' width='35' height='35' align='middle' /></a></td>\n"; 
	 echo "<td class='tbl2' style='text-align:center;'>".$data['tut_kosten']."<span class='addon-file'>&nbsp;</span></td>\n";
	 echo "<td class='tbl2' style='text-align:center;'>".showdate("%d. %B %Y, %H:%M", $data['tut_created'])."</td>\n";
     echo "<td class='tbl2' style='text-align:center;'>".(ADDHidden($data['tut_hideauthor']) ? "<span class='devel_hidden'>Versteckt</span>" : add_author($data['user_id'], $data['user_name'], $data['user_status'], $data['user_avatar']))."</td>\n"; 
     echo "</tr>";
	$p++;
   }
    echo "</table>\n";

if (checkrights("TUTP")) {
	echo "<table cellpadding='0' cellspacing='1' class='tbl2' style='width: 100%;text-align:center;'>\n<tr>\n";
	echo "<td class='tbl2'><a href='".TUT_ADMIN."translations_admin.php".$aidlink."' class='ad-message'>Administration</a></td>";
	echo "<td class='tbl2'><a href='".TUT_ADMIN."translations_settings.php".$aidlink."' class='st-message'>Einstellungen</a></td>";
	echo "<td class='tbl2'><a href='".TUT_ADMIN."translations_cats.php".$aidlink."' class='kat-message'>Zu den Kategorien</a></td>";
	echo "<td class='tbl2'><a href='".TUT_ADMIN."translations_logsys.php".$aidlink."' class='log-message'>Zum Logsystem</a></td>";
	echo "</tr></table>\n";
}

 } else {
     echo "<table cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>\n";
	 echo "<tr>\n<td class='tbl2' align='left'>".$locale['translation_dip018']."</td>\n</tr>\n";
	 echo "</table>\n";
}

echo "<div style='text-align: right;'><a href='http://fusion-mods.de' target='_blank' title='".$locale['translations_desc']." ".showdate("%Y",time())."'><span class='small'>&copy;</span></a></div>";
closetable();
?>