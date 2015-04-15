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
if (!defined("IN_FUSION")) { die("Access Denied"); }

function tut_page($get_page){
         global $locale, $sett;
		 $page_titleArray = array(
		       "adm" => "&Uuml;bersetzer",
			   "dls" => $locale['translation_dd000'],
			   "pop" => sprintf($locale['translation_pd000'], "15"),
			   "prp" => $locale['translation_dp000'],
			   "tor" => $locale['translation_tr000']
			);
opentable($page_titleArray[$get_page]);
 if($get_page == "adm"){ 
   	$adm = dbquery(
	    "SELECT user_id, user_name, user_status, user_rights, user_avatar, user_lastvisit, user_level, user_birthdate 
	     FROM ".DB_USERS."
	     WHERE user_rights REGEXP('TUTP')
	     GROUP BY user_id
	     ORDER BY user_level DESC LIMIT 10");
if(dbrows($adm) != 0) {
	echo "<table width='550' class='tbl-border center'>\n<tr>\n";
	echo "<td width='40' class='tbl2'>&nbsp;</td>\n";
	echo "<td width='130' class='tbl2' style='font-weight: bold;text-align:left;white-space:nowrap'>Mitglied</td>\n";
	echo "<td width='130' class='tbl2' style='font-weight: bold;text-align:center;white-space:nowrap'>User-Level</td>\n";
	echo "<td width='120' class='tbl2' style='font-weight: bold;text-align:center;white-space:nowrap'>Alter</td>\n";
	echo "<td width='90' class='tbl2' style='font-weight: bold;text-align:center;white-space:nowrap'>Zu letzt hier</td>\n</tr>\n";

	while($adata = dbarray($adm)) {
	echo "<tr>\n<td class='tbl1'>";
if ($adata['user_avatar'] && file_exists(IMAGES."avatars/".$adata['user_avatar']) && $adata['user_status']!=6 && $adata['user_status']!=5) {
	echo "<img style='padding: 2px; border: 1px solid #a5cae4; border-radius: 2px; -webkit-border-radius: 2px; -moz-border-radius: 2px; -khtml-border-radius: 2px; width: 35px; height: 35px;' 
	src='".IMAGES."avatars/".$adata['user_avatar']."' alt='".$adata['user_name']."' />";
  } else {
	echo "<img style='padding: 2px; border: 1px solid #a5cae4; border-radius: 4px; -webkit-border-radius: 2px; -moz-border-radius: 2px; -khtml-border-radius: 2px; width: 35px; height:35px;' 
	src='".IMAGES."avatars/noavatar100.png' alt='".$adata['user_name']."' />";
}
	echo "</td>\n";
	echo "<td class='tbl1' style='text-align:left;'>".profile_link($adata['user_id'], $adata['user_name'], $adata['user_status'])."</a></td>\n";
	echo "<td class='tbl1' style='text-align:center;'><span style='color:".($adata['user_level'] == 102 ? "green" : ($adata['user_level'] == 103 ? "red" : "")).";'>
	".($adata['user_id'] == 1 ? "&Uuml;bersetzer:" : getuserlevel($adata['user_level']))."</span></td>\n";
	echo "<td class='tbl1' style='text-align:center;'>".author_alter($adata['user_birthdate'])."</td>\n";
	echo "<td class='tbl1' style='text-align:center;'>".showdate("shortdate", $adata['user_lastvisit'])."</td></tr>\n";
	}
	echo "</table>\n";
}
} else if($get_page == "dls"){
    $dls = dbquery("SELECT p.*, pc.*, u.user_id, u.user_name, u.user_status, u.user_avatar							 
            FROM ".DB_FUSION_TUTORIAL." p
            LEFT JOIN ".DB_USERS." u ON p.tut_author=u.user_id
			LEFT JOIN ".DB_FUSION_TUTORIAL_CATS." pc ON p.tut_cat=pc.tut_cat_id
			WHERE p.tut_file !=''
            ORDER BY p.tut_fcount 
            DESC LIMIT 15");
if(dbrows($dls) != 0) {
	echo "<table width='100%' class='tbl-border center'>\n<tr>\n";
	echo "<td class='tbl2' align='center' style='font-weight: bold; width='15%'>".$locale['translation_dd001']."</td>\n";
	echo "<td class='tbl2' align='center' style='font-weight: bold; width='15%'>Addon-Typ</td>\n";
	echo "<td class='tbl2' align='center' style='font-weight: bold; width='15%'>Score-Kosten</td>\n";
	if(iADMIN){
	echo "<td class='tbl2' align='center' style='font-weight: bold; width='15%'>Logsystem</td>\n";
	}
	echo "<td class='tbl2' align='center' style='font-weight: bold; width='15%'>".$locale['translation_dd002']."</td>\n";
	echo "<td class='tbl2' align='center' style='font-weight: bold; width='15%'>".$locale['translation_dd003']."</td>\n";
	echo "<td class='tbl2' align='center' style='font-weight: bold; width='15%'>".$locale['translation_dd005']."</td>\n</tr>\n";

	while($ddata = dbarray($dls)) {
	echo "<td class='tbl1' style='text-align:center;'><a href='".TUT."portal.php?id=".$ddata['tut_id']."' title='".$ddata['tut_name']."'>".trimlink($ddata['tut_name'], 40)."</a></td>\n";
	echo "<td class='tbl1' style='text-align:center;'>".$ddata['addon_name']."</td>\n";
	echo "<td class='tbl1' style='text-align:center;'>".$ddata['tut_kosten']."</td>\n";
	$tut_settings = dbarray(dbquery("SELECT * FROM ".DB_FUSION_TUTORIAL_SETTINGS));
	if(iADMIN){
	if ($tut_settings['tut_set'] == 1) {
	echo "<td class='tbl1' style='text-align:center;'><img src='".INFUSIONS."tutorial_portal_panel/images/off.png' alt='Ausgeschalten'/></td>\n";
	}
	if ($tut_settings['tut_set'] == 0) {
	echo "<td class='tbl1' style='text-align:center;'><img src='".INFUSIONS."tutorial_portal_panel/images/on.png' alt='Eingeschalten'/></td>\n";
	}
	}
	echo "<td class='tbl1' style='text-align:center;'><a href='".TUT."translations.php?cat_id=".$ddata['tut_cat_id']."'>".$ddata['tut_cat_name']."</a></td>\n";
	echo "<td class='tbl1' style='text-align:center;'>".(ADDHidden($ddata['tut_hideauthor']) ? "<span class='devel_hidden'>Hidden</span>" : profile_link($ddata['user_id'], $ddata['user_name'], $ddata['user_status']))."</td>\n";
	echo "<td class='tbl1' style='text-align:center;'>".$ddata['tut_fcount']."</td></tr>\n";
	}
	echo "</table>\n";

} else {
   echo "<div align='center' class='small'>".$locale['translation_dd006']."</div>\n";
}

} else if($get_page == "pop"){
    $pop = dbquery("SELECT p.*, pc.*, u.user_id, u.user_name, u.user_status, u.user_avatar							 
                 FROM ".DB_FUSION_TUTORIAL." p
                 LEFT JOIN ".DB_USERS." u ON p.tut_author=u.user_id
				 LEFT JOIN ".DB_FUSION_TUTORIAL_CATS." pc ON p.tut_cat=pc.tut_cat_id
				 WHERE ".groupaccess('pc.tut_cat_access')." AND tut_file !='' AND tut_fcount !='0'
                 ORDER BY tut_fcount 
                 DESC LIMIT 15");
										 
    $rows = dbcount("(tut_id)", DB_FUSION_TUTORIAL, "tut_file!=''"); 
if(dbrows($pop) != 0) {
	echo "<table width='700' class='tbl-border center'>\n<tr>\n";
	echo "<td width='240' class='tbl2' style='font-weight: bold;text-align:left;white-space:nowrap'>".$locale['translation_pd001']."</td>\n";
	echo "<td width='120' class='tbl2' style='font-weight: bold;text-align:center;white-space:nowrap'>".$locale['translation_pd002']."</td>\n";
	echo "<td width='120' class='tbl2' style='font-weight: bold;text-align:center;white-space:nowrap'>".$locale['translation_pd003']."</td>\n";
	echo "<td width='120' class='tbl2' style='font-weight: bold;text-align:center;white-space:nowrap'>".$locale['translation_pd004']."</td>\n";
	echo "<td width='80' class='tbl2' style='font-weight: bold;text-align:center;white-space:nowrap'>".$locale['translation_pd005']."</td>\n</tr>\n";

	while($pdata = dbarray($pop)) {
	echo "<tr>\n<td class='tbl1' style='text-align:left;'><a href='".TUT."portal.php?id=".$pdata['tut_id']."' title='".$pdata['tut_name']."'>".trimlink($pdata['tut_name'], 40)."</a></td>\n";
	echo "<td class='tbl1' style='text-align:center;'><a href='".TUT."translation.php?cat_id=".$pdata['tut_cat_id']."'>".$pdata['tut_cat_name']."</a></td>\n";
	echo "<td class='tbl1' style='text-align:center;'>".(ADDHidden($pdata['tut_hideauthor']) ? "<span class='devel_hidden'>Hidden</span>" : profile_link($pdata['user_id'], $pdata['user_name'], $pdata['user_status']))."</td>\n";
	echo "<td class='tbl1' style='text-align:center;'>".$pdata['tut_fcount']."</td></tr>\n";
	}
	echo "</table>\n";

} else {
    echo "<div align='center' class='small'>".$locale['translation_pd006']."</div>\n";
}

} else if($get_page == "tor"){ 
    $tor = dbquery("SELECT p.*, pc.*, u.user_id, u.user_name, u.user_status, u.user_avatar, SUM(tr.rating_vote) AS sum_rating, COUNT(tr.rating_item_id) AS count_votes 
	    FROM ".DB_FUSION_TUTORIAL." p
        LEFT JOIN ".DB_FUSION_TUTORIAL_CATS." pc ON p.tut_cat=pc.tut_cat_id
        LEFT JOIN ".DB_USERS." u ON u.user_id=p.tut_author
        LEFT JOIN ".DB_RATINGS." tr ON tr.rating_item_id=p.tut_id AND tr.rating_type='J'
        WHERE ".groupaccess('pc.tut_cat_access')." AND tr.rating_vote > '0' 
		GROUP BY p.tut_id 
		ORDER BY sum_rating DESC LIMIT 15");
    $rows = dbrows($tor);
	$count = 0;
if ($rows) {
    $counter = 0; $count = 1;
    echo "<table width='700' class='tbl-border center'>\n<tr>\n";
	echo "<td width='200' class='tbl2' style='font-weight: bold;text-align:left;white-space:nowrap'>".$locale['translation_tr001']."</td>\n";
	echo "<td width='120' class='tbl2' style='font-weight: bold;text-align:center;white-space:nowrap'>".$locale['translation_tr002']."</td>\n";
	echo "<td width='120' class='tbl2' style='font-weight: bold;text-align:center;white-space:nowrap'>".$locale['translation_tr003']."</td>\n";
	echo "<td width='120' class='tbl2' style='font-weight: bold;text-align:center;white-space:nowrap'>".$locale['translation_tr004']."</td>\n";
    while ($tdata = dbarray($tor)) {
	echo "<tr>";
    echo "<td class='tbl1' style='text-align:left;'><a href='".TUT."portal.php?id=".$tdata['tut_id']."' title='".$tdata['tut_name']."'>".trimlink($tdata['tut_name'], 40)."</a></td>\n";
	echo "<td class='tbl1' style='text-align:center;'><a href='".TUT."translation.php?cat_id=".$tdata['tut_cat_id']."'>".$tdata['tut_cat_name']."</a></td>\n";
	echo "<td class='tbl1' style='text-align:center;'>".(ADDHidden($tdata['tut_hideauthor']) ? "<span class='devel_hidden'>Hidden</span>" : profile_link($tdata['user_id'], $tdata['user_name'], $tdata['user_status']))."</td>\n";
	echo "<td class='tbl1' style='text-align:center;'>".($tdata['tut_allow_ratings'] ? ($tdata['count_votes'] > 0 ? str_repeat("<img src='".get_image("star") . "' alt='*' style='vertical-align:middle; width: 13px; height: 13px;' />",ceil($tdata['sum_rating'] / $tdata['count_votes'])) : $locale['translation_tr005']) : $locale['translation_tr005'])."</td>\n</tr>\n";
    $counter++;$count++;
}
    echo "</table>\n";
    } else {
    echo "<table cellpadding='0' cellspacing='1' class='tbl-border center' width='100%'>\n<tr>\n";
    echo "<td class='tbl1' style='text-align:center; padding: 10px;'>".$locale['translation_tr006']."</td>";
    echo "</tr></table>";
    }
} else {
    echo "Seite nicht gefunden!";
	}
	echo "<div style='text-align: right;'><a href='http://fusion-mods.de' target='_blank' title='".$locale['translation_desc']." ".showdate("%Y",time())."'><span class='small'>&copy;</span></a></div>";
	closetable();
}	
  
?>