<?php
require_once "../../../maincore.php";
require_once THEMES."templates/admin_header.php";
if (file_exists(INFUSIONS."tutorial_portal_panel/locale/".$settings['locale'].".php")) {
	include INFUSIONS."tutorial_portal_panel/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."tutorial_portal_panel/locale/German.php";
}
add_to_head ('<link rel="stylesheet" href="'.INFUSIONS.'tutorial_portal_panel/includes/css/core.css"/>');
if (!checkrights("TUTP") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect(BASEDIR."index.php"); }
 //NAVI
include INFUSIONS."tutorial_portal_panel/admin/admin_navigation.php";
include INFUSIONS."tutorial_portal_panel/infusion_db.php";

if (isset($_GET['del']) && isnum($_GET['del'])){
$del = stripinput($_GET['del']);
$result = dbquery("DELETE FROM ".DB_FUSION_TUTORIAL_LOGSYS." WHERE trans_id='".$del."' ");
}
if (isset($_GET['usr']) && isnum($_GET['usr'])) {$usr = stripinput($_GET['usr']);} else {$usr="";}
opentable("".$locale['dat_000']."");
echo "<div style='margin:10px'></div>\n";

$result = dbquery("SELECT td.*, tu.*, p.* FROM ".DB_FUSION_TUTORIAL_LOGSYS." td
LEFT JOIN ".DB_USERS." tu ON tu.user_id = td.tuserid
LEFT JOIN ".DB_FUSION_TUTORIAL." p ON p.tut_id = td.tdid
WHERE tuserid!='0' ".($usr ? "&& tuserid=".$usr."" :"")."
ORDER BY td.tdatum DESC");

$rows = dbrows($result); $db = 20; $si = 0;
if (!isset($_GET['rowstart']) || !isnum($_GET['rowstart'])) { $_GET['rowstart'] = 0; }

$result = dbquery("SELECT td.*, tu.*, p.* FROM ".DB_FUSION_TUTORIAL_LOGSYS." td
LEFT JOIN ".DB_USERS." tu ON tu.user_id = td.tuserid
LEFT JOIN ".DB_FUSION_TUTORIAL." p ON p.tut_id = td.tdid
WHERE tuserid!='0' ".($usr ? "&& tuserid=".$usr."" :"")."
ORDER BY td.tdatum DESC LIMIT ".$_GET['rowstart'].",".$db." ");

if (dbrows($result)){
//***CSS
add_to_head("<style type='text/css'> 
.mbr_superadmin_style 
{ 
color: #CF3333; 
font-weight: bold;
} 
.mbr_superadmin_style:hover 
{ 
color: #CF3333; 
font-weight: bold;
} 
.mbr_admin_style 
{ 
color: #008000; 
font-weight: bold;
} 
.mbr_admin_style:hover
{ 
color: #008000; 
font-weight: bold;
} 
.mbr_member_style 
{ 
color: #2D6CCA; 
}
.mbr_member_style:hover 
{ 
color: #2D6CCA; 
}

.opacity {
opacity:0.8; 
filter:alpha(opacity=80); /* For IE8 and earlier */ 
}

.opacity:hover { 
opacity:1.0; 
filter:alpha(opacity=100); /* For IE8 and earlier */
}

.member-avatar-online { 
border: 1px solid #82FF44; 
width: 30px;
height: 30px;
-moz-border-radius: 4px;
-webkit-border-radius: 4px;
border-radius: 4px;
}

.member-avatar-five { 
border: 1px solid #FFA70F; 
width: 30px;
height: 30px;
-moz-border-radius: 4px;
-webkit-border-radius: 4px;
border-radius: 4px;
}

.member-avatar-offline { 
border: 1px solid #FF3D3D;
width: 30px;
height: 30px;
-moz-border-radius: 4px;
-webkit-border-radius: 4px;
border-radius: 4px;
}

.members-small {
font-size: 10px;
}
</style>
 "); 
//******
	echo "<table id='iseqchart'><tr>";
	echo "<th id='index' class='ftl-panel-top index-border1' align='middle' valign='top'><span style='color:green;font-size:12px;'>".$locale['dat_001']."</span></th>\n";
	echo "<th id='index' class='ftl-panel-top index-border1' align='middle' valign='top'><span style='color:green;font-size:12px;'>".$locale['dat_002']."</span></th>\n";
	echo "<th id='index' class='ftl-panel-top index-border1' align='middle' valign='top'><span style='color:green;font-size:12px;'>".$locale['dat_003']."</span></th>\n";
	echo "<th id='index' class='ftl-panel-top index-border1' align='middle' valign='top'><span style='color:green;font-size:12px;'>".$locale['dat_004']."</span></th>\n";
	echo "<th id='index' class='ftl-panel-top index-border1' align='middle' valign='top'><span style='color:green;font-size:12px;'>".$locale['dat_005']."</span></th>\n";
	echo "<th id='index' class='ftl-panel-top index-border1' align='middle' valign='top'><span style='color:green;font-size:12px;'>".$locale['dat_006']."</span></th>\n";
	echo "<th id='index' class='ftl-panel-top index-border1' align='middle' valign='top'><span style='color:green;font-size:12px;'>".$locale['dat_007']."</span></th>\n";
	echo "<th id='index' class='ftl-panel-top index-border1' align='middle' valign='top'><span style='color:green;font-size:12px;'>".$locale['dat_008']."</span></th>\n</tr>\n";
	while($l = dbarray($result)){
		$cc = ($si % 2 == 0 ? "tbl1" : "tbl2"); $si++;
		$lk = dbcount("(tut_id)", DB_FUSION_TUTORIAL, "tut_id='".$l['tdid']."'");
		echo "<tr>";
		if ($l['user_avatar'] && file_exists(IMAGES."avatars/".$l['user_avatar']) && $l['user_status']!=6 && $l['user_status']!=5) { 
		echo "<td class='$cc' align='center'><a href='".BASEDIR."profile.php?lookup=".$l['user_id']."'>
		<img class='member-avatar-offline opacity' src='".IMAGES."avatars/".$l['user_avatar']."' title='".$l['user_name']."' alt='' /></a></td>";
		} else { 
		echo "<td class='$cc' align='center'><a href='".BASEDIR."profile.php?lookup=".$l['user_id']."'>
		<img class='member-avatar-offline opacity' src='".IMAGES."avatars/noavatar100.png' alt='' title=' ".$l['user_name']."' /></a></td>";
		}
		echo "<td class='$cc' align='center'><a href='http://www.utrace.de/?query=".$l['user_ip']."' target='_blank'>".$l['user_ip']."</a></td>\n";
		echo "<td class='$cc' align='center'>".$l['tut_kosten']."</td>\n";
		//PN
		echo "<td class='$cc' align='center'><a href='".BASEDIR."messages.php?msg_send=".$l['user_id']."' title='PN schicken'>PN</td>\n";
		echo "<td class='$cc' align='center'>".$l['tut_name']."<i><b>".$locale['dwh_016']."</b></i>"."</td>\n";
		echo "<td class='$cc' align='center'>".($l['tdb']!=0 ? $l['tdb'] : "")."</td>\n";
		echo "<td class='$cc' align='center'>".showdate("%d.%m.%Y %H:%M",$l['tdatum'])."</td>\n";
		echo "<td class='$cc' align='center'>".($lk > 1 ? "" : "<a href='".FUSION_SELF.$aidlink."&amp;del=".$l['trans_id']."'>".$locale['dat_009']."</a>")."</td>\n";
		echo "</tr>\n";
	}
	echo "</table>\n";
}
if ($rows >$db) { echo "<div align='center' style='margin-top:5px;'>".makepagenav($_GET['rowstart'], $db, $rows, 3, FUSION_SELF.$aidlink.($usr? "&amp;usr=".$usr : "")."&amp;")."</div><br>\n"; }
echo "<div style='text-align: right;'><a href='http://fusion-mods.de' target='_blank' title='".$locale['translation_desc']." ".showdate("%Y",time())."'><span class='small'>&copy;</span></a></div>";
closetable();
require_once THEMES."templates/footer.php";
?>