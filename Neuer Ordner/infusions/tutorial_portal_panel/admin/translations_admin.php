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

if (!checkrights("TUTP") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { die("Zugang nur f&uuml;r Administartoren!"); }
 
$tut_id = (isset($_GET['tut_id']) AND isnum($_GET['tut_id'])) ? $_GET['tut_id'] : "";
	add_to_head("<script src='".INFUSIONS."tutorial_portal_panel/includes/js/jquery.tagsinput.js' type='text/javascript'></script>");
	include INFUSIONS."tutorial_portal_panel/admin/admin_navigation.php";
	
    $bdata = dbarray(dbquery("SELECT * FROM ".DB_FUSION_TUTORIAL." WHERE tut_id = '".$tut_id."'"));
	$tut_name = "";
	//Mod
	$tut_kosten = "";
	//Ende
	$tut_file = "";
	$tut_allow_comments = 1;
	$tut_allow_ratings = 1;
	$tut_access = 0;
	$tut_dlaccess = 101;
	$tut_author_notice = "";
	$tut_cat = "";
    $tut_action = FUSION_SELF.$aidlink;
	$message = "";

     	
if (isset($_GET['action']) && $_GET['action'] == "delete") {
    $result = dbquery("SELECT * FROM ".DB_FUSION_TUTORIAL." WHERE tut_id='".$_GET['tut_id']."'");
	if (dbrows($result)) {
	$data = dbarray($result);
	if(DeleteAdd($data['tut_author'])){ 
	if (!empty($data['tut_file']) && file_exists(INFUSIONS."tutorial_portal_panel/files/".$data['tut_file'])) {
	@unlink(INFUSIONS."tutorial_portal_panel/files/".$data['tut_file']);
	}
    $result = dbquery("DELETE FROM ".DB_FUSION_TUTORIAL." WHERE tut_id='".$tut_id."'"); 
	} else {
	redirect(FUSION_SELF.$aidlink); 
	}
		
	}
	redirect(FUSION_SELF.$aidlink."&tut_cat_id=".intval($_GET['tut_cat_id'])."&status=del");
}

if (isset($_POST['save_dev'])) {
        global $settings;
		$error = 0;
		$tut_name = stripinput($_POST['tut_name']);
		//Mod
		$tut_kosten = stripinput($_POST['tut_kosten']);
		//Ende
		if(!$tut_name) { $error = 5; }
		if (isset($_POST['del_upload']) && isset($_GET['tut_id']) && isnum($_GET['tut_id'])) {
		$result = dbquery("SELECT tut_file FROM ".DB_FUSION_TUTORIAL." WHERE tut_id='".$_GET['tut_id']."'");
		if (dbrows($result)) {
		$data = dbarray($result);
		if (!empty($data['tut_file']) && file_exists(INFUSIONS."tutorial_portal_panel/files/".$data['tut_file'])) {
		$result = dbquery("UPDATE ".DB_FUSION_TUTORIAL." SET tut_fcount='0' WHERE tut_id='".$_GET['tut_id']."'");
		@unlink(INFUSIONS."tutorial_portal_panel/files/".$data['tut_file']);
		}
		}
		$tut_file = "";
			
		} elseif (!empty($_FILES['tut_file']['name']) && is_uploaded_file($_FILES['tut_file']['tmp_name'])) {
			require_once INCLUDES."infusions_include.php";
			$source_file = "tut_file";
			$target_file = $_FILES['tut_file']['name'];
			$target_folder = INFUSIONS."tutorial_portal_panel/files/";
			$upload = upload_file($source_file, $target_file, $target_folder, $sett['file_types'], $sett['file_maxsize']);
			if ($upload['error'] == 1) {
				$error = 2;
			} elseif ($upload['error'] == 2) {
				$error = 3;
			} elseif ($upload['error'] == 3) {
				$error = 7;
			} elseif ($upload['error'] == 4) {
				$error = 8;
			} else {
				$tut_file = $upload['target_file'];
			}
		} elseif (isset($_POST['tut_file']) && $_POST['tut_file'] != "") {
			$tut_file = $_POST['tut_file'];
		}
	$tut_allow_comments = (isset($_POST['tut_allow_comments']) && isnum($_POST['tut_allow_comments'])) ? $_POST['tut_allow_comments'] : "0";
	$tut_allow_ratings = (isset($_POST['tut_allow_ratings']) && isnum($_POST['tut_allow_ratings'])) ? $_POST['tut_allow_ratings'] : "0";
	$tut_access = (isset($_POST['tut_access']) && isnum($_POST['tut_access'])) ? $_POST['tut_access'] : 0;
	$tut_dlaccess = (isset($_POST['tut_dlaccess']) && isnum($_POST['tut_dlaccess'])) ? $_POST['tut_dlaccess'] : 0;
	$tut_author_notice = stripinput($_POST['tut_author_notice']);
	$tut_cat = intval($_POST['tut_cat']);
	if ($tut_name && $error == 0) {
    if ((isset($_GET['action']) && $_GET['action'] == "edit") && (isset($_GET['tut_id']) && isnum($_GET['tut_id']))) {
	$tut_updated = isset($_POST['update_datestamp3']) ? ", tut_updated='".time()."'" : "";
    $result = dbquery("UPDATE ".DB_FUSION_TUTORIAL." SET 
       tut_allow_comments='".$tut_allow_comments."', 
	   tut_allow_ratings='".$tut_allow_ratings."',
	   tut_access='".$tut_access."',
	   tut_dlaccess='".$tut_dlaccess."',
       tut_file='".$tut_file."',	   
	   tut_name='".$tut_name."',
	   tut_kosten='".$tut_kosten."',
	   tut_author_notice='".$tut_author_notice."', 
	   tut_cat='".$tut_cat."'
	   ".$tut_updated." 
	   WHERE tut_id='".$tut_id."'");
       redirect(FUSION_SELF.$aidlink."&status=su");
    } else {
       $result = dbquery("INSERT INTO ".DB_FUSION_TUTORIAL." 
	   (tut_author, 
	   tut_allow_comments, 
	   tut_allow_ratings, 
	   tut_file, 
	   tut_access, 
	   tut_dlaccess, 
	   tut_name,
	   tut_kosten,
	   tut_author_notice, 	   
	   tut_cat, 
	   tut_created
	   ) VALUES (
	  '".$userdata['user_id']."', 
	  '".$tut_allow_comments."', 
	  '".$tut_allow_ratings."',	   
	  '".$tut_file."', 
	  '".$tut_access."', 
	  '".$tut_dlaccess."', 
	  '".$tut_name."',
	  '".$tut_kosten."',
	  '".$tut_author_notice."', 
	  '".$tut_cat."', 
	  '".time()."')");
       redirect(FUSION_SELF.$aidlink."&status=sn"); 
     }
  		} else {
			switch($error) {
				case 0: $message .= $locale['translation_ae000']."</span>"; break;
				case 1: $message .= $locale['translation_ae001']."</span>"; break;
				case 2: $message .= sprintf($locale['translation_ae002'], parsebytesize($addsett['file_maxsize']))."</span>"; break;
				case 3: $message .= sprintf($locale['translation_ae003'], str_replace(',', ' ', $addsett['file_types']))."</span>"; break;
				case 5: $message .= $locale['translation_ae000']."</span>"; break;
				case 6: $message .= $locale['translation_ae004']."</span>"; break;
				case 7: $message .= $locale['translation_ae005']."</span>"; break;
				
			}
		}
}

if ((isset($_GET['action']) && $_GET['action'] == "edit") && (isset($_GET['tut_id']) && isnum($_GET['tut_id']))) {
    $result = dbquery("SELECT * FROM ".DB_FUSION_TUTORIAL." WHERE tut_id='".$tut_id."'");
    $data = dbarray($result);
	$tut_allow_comments = (isset($data['tut_allow_comments']) && isnum($data['tut_allow_comments'])) ? $data['tut_allow_comments'] : 0;
	$tut_allow_ratings = (isset($data['tut_allow_ratings']) && isnum($data['tut_allow_ratings'])) ? $data['tut_allow_ratings'] : 0;
	$tut_access = (isset($data['tut_access']) && isnum($data['tut_access'])) ? $data['tut_access'] : "0";
	$tut_dlaccess = (isset($data['tut_dlaccess']) && isnum($data['tut_dlaccess'])) ? $data['tut_dlaccess'] : 0;
    $tut_name = stripinput($data['tut_name']);
	$tut_kosten= stripinput($data['tut_kosten']);
	$tut_file = $data['tut_file'];
	$tut_author_notice = stripinput(htmlspecialchars_decode($data['tut_author_notice']));
	$tut_cat = stripinput($data['tut_cat']);
    $tut_action = FUSION_SELF.$aidlink."&amp;action=edit&amp;tut_id=".$tut_id;
	if(!EditAdd($data['tut_author'])){ redirect(FUSION_SELF.$aidlink); }  
    opentable($locale['translation_a000'].$data['tut_name']);
} else {
    opentable($locale['translation_a001']);
}	


	if (isset($_GET['status']) && $message == "") {
		if ($_GET['status'] == "sn") {
			$message .= $locale['translation_am001'];
		} elseif ($_GET['status'] == "su") {
			$message .= $locale['translation_am002'];
		} elseif ($_GET['status'] == "del") {
			$message .= $locale['translation_am003'];
		}
	}
	if ($message != "") {  echo "<div id='close-message'><div class='admin-message'>".$message."</div></div>\n"; }

if (isset($_GET['rowstart']) && isnum($_GET['rowstart'])) {
	$rowstart = $_GET['rowstart'];
} else {
	$rowstart = 0;
} 


$tut_settings = dbarray(dbquery("SELECT * FROM ".DB_FUSION_TUTORIAL_SETTINGS));

 	
$user_groups = getusergroups(); $access_opts = "";
while(list($key, $user_group) = each($user_groups)){
$sel = (isset($tut_access) && $tut_access == $user_group['0'] ? " selected='selected'" : "");
$access_opts .= "<option value='".$user_group['0']."'".$sel.">".$user_group['1']."</option>\n";
} 
$user_groups2 = getusergroups(); $dl_access_opts = "";
while(list($key, $user_group2) = each($user_groups2)){
$dla_sel = (isset($tut_dlaccess) && $tut_dlaccess == $user_group2['0'] ? " selected='selected'" : "");
$dl_access_opts .= "<option value='".$user_group2['0']."'".$dla_sel.">".$user_group2['1']."</option>\n";
} 
	
	
	$catlist = ""; $sele = "";
	$result2 = dbquery("SELECT tut_cat_id, tut_cat_name, addon_name FROM ".DB_FUSION_TUTORIAL_CATS." ORDER BY tut_cat_name");
	if (dbrows($result2) != 0) {
		while ($data2 = dbarray($result2)) {
			if (isset($_GET['action']) && $_GET['action'] == "edit") { $sele = ($tut_cat == $data2['tut_cat_id'] ? " selected='selected'" : ""); }
			$catlist .= "<option value='".$data2['tut_cat_id']."'$sele>".$data2['tut_cat_name']."</option>\n";
		}
	}
	
require_once INCLUDES."bbcode_include.php";
    echo "<form name='inputform' method='post' action='".$tut_action."' enctype='multipart/form-data'>\n";
    echo "<table class='tbl-border center' width='70%' cellspacing='5' cellpadding='0'>\n<tr>\n";
    echo "<td class='tbl1' style='white-space:nowrap;'><strong>".$locale['translation_a002']."</strong></td>\n";
    echo "<td class='tbl1'><input type='text' name='tut_name' value='".$tut_name."' class='textbox devTxtbx' style='width:250px;' />\n";
	echo "</td>\n</tr>\n";
	echo "<td class='tbl1' style='white-space:nowrap;'><strong>Scoreabzug</strong></td>\n";
    echo "<td class='tbl1'><input type='text' name='tut_kosten' value='".$tut_kosten."' class='textbox ' style='width:80px;' />\n";
	echo "</td>\n</tr>\n";
    echo "<tr><td width='80' class='tbl1' style='white-space:nowrap;'><strong>".$locale['translation_a015']."</strong></td>\n";
	echo "<td class='tbl1'><select name='tut_cat' class='textbox '>\n".$catlist."</select></td>\n";
	echo "</tr>\n<tr>";
	echo "<td class='tbl1' style='white-space:nowrap;vertical-align:middle;'><strong>".$locale['translation_a018']."</strong></td>\n";
	echo "<td class='tbl1'>\n";
	if (!empty($tut_file)) {
	echo "<a href='".INFUSIONS."tutorial_portal_panel/files/".$tut_file."'>".INFUSIONS."tutorial_portal_panel/files/".$tut_file."</a><br />\n";
	echo "<label><input type='checkbox' name='del_upload' value='1' /> L&ouml;schen</label>\n";
	echo "<input type='hidden' name='tut_file' value='".$tut_file."' />";
	} else {
	echo "<input type='file' name='tut_file' class='textbox ' style='width:150px;' /><br />\n";
	echo "<div style='margin: 4px 0 4px 0;'>".sprintf($locale['translation_a019'], parsebytesize($addsett['file_maxsize']), str_replace(',', ' ', $sett['file_types']))."</div>";
	}
	echo "</td>\n</tr>\n";
	echo "<td valign='top' class='tbl1' style='white-space:nowrap;'><strong>".$locale['translation_a023']."</strong></td>\n";
    echo "<td class='tbl1'><textarea name='tut_author_notice' placeholder='".$locale['translation_a023a']."' cols='60' rows='3' class='textbox devTxtbx' style='width:400px;'>".$tut_author_notice."</textarea><br />\n";
    echo display_bbcodes("400px;", "tut_author_notice", "inputform")."\n";
    echo "</td>\n</tr>\n";
	#if($tut_settings['tut_comments'] == 0) { 
	echo "<tr>\n<td class='tbl1' style='white-space:nowrap;'><strong>".$locale['translation_a026']."</strong></td>\n";
	echo "<td class='tbl1'><select name='tut_allow_comments' class='textbox'>\n";
    echo "<option style='color:".$locale['translation_no-color'].";' value='0'".($tut_allow_comments == "0" ? " selected='selected'" : "").">".$locale['translation_g000']."</option>\n";
	echo "<option style='color:".$locale['translation_yes-color'].";' value='1'".($tut_allow_comments == "1" ? " selected='selected'" : "").">".$locale['translation_g001']."</option>\n";
    echo "</select></td>\n</tr>\n"; 
	#}
	echo "<tr>\n<td class='tbl1' style='white-space:nowrap;'><strong>".$locale['translation_a027']."</strong></td>\n";
	echo "<td class='tbl1'><select name='tut_allow_ratings' class='textbox '>\n";
    echo "<option style='color:".$locale['translation_no-color'].";' value='0'".($tut_allow_ratings == "0" ? " selected='selected'" : "").">".$locale['translation_g000']."</option>\n";
	echo "<option style='color:".$locale['translation_yes-color'].";' value='1'".($tut_allow_ratings == "1" ? " selected='selected'" : "").">".$locale['translation_g001']."</option>\n";
    echo "</select></td>\n</tr>\n";  
	if($tut_settings['tut_access'] == 0) {
	echo "<td class='tbl1' style='white-space:nowrap;'><strong>".$locale['translation_a028m']."</strong></td>\n";
    echo "<td colspan='2' class='tbl1'><select name='tut_access' class='textbox' style='width:150px;'>\n".$access_opts."</select></td>\n";
    echo "</tr>\n<tr>\n"; 
	}
	if($tut_settings['tut_dlaccess'] == 0) {
	echo "<td class='tbl1' style='white-space:nowrap;'><strong>".$locale['translation_a028m2']."</strong></td>\n";
    echo "<td colspan='2' class='tbl1'><select name='tut_dlaccess' class='textbox' style='width:150px;'>\n".$dl_access_opts."</select></td>\n";
    echo "</tr>\n<tr>\n";
	}
	if (isset($_GET['action']) && $_GET['action'] == "edit") {
	echo "<td class='tbl1 update-datestamp' style='white-space:nowrap;'>".$locale['translation_a028m3']."</td>\n";
	echo "<td class='tbl1 update-datestamp'><input type='checkbox' name='update_datestamp3' value='1' style='padding:5px;'></td>";
	echo "</tr>\n<tr>\n";
	}

    echo "<td align='center' colspan='2' class='tbl1'>";
if(isset($_GET['action']) && $_GET['action'] == "edit"){
	echo "<input type='submit' name='save_dev' value='".$locale['translation_a029']."' class='button' />\n"; } 
	else {
    echo "<input type='submit' name='save_dev' value='".$locale['translation_a030']."' class='button' />\n";
	}
    echo "</td></tr>\n</table>\n</form>\n";
echo "<div style='text-align: right;'><a href='http://fusion-mods.de' target='_blank' title='".$locale['tut_desc']." ".showdate("%Y",time())."'><span class='small'>&copy;</span></a></div>";
closetable();

opentable($locale['translation_a031']);
echo "<table cellspacing='0' cellpadding='0' width='100%' class='center'>\n";
    $result = dbquery("SELECT tut_cat_id, tut_cat_name, addon_name FROM ".DB_FUSION_TUTORIAL_CATS." ORDER BY tut_cat_name");
	if (dbrows($result)) {
		while ($data = dbarray($result)) {
			echo "<table cellspacing='0' cellpadding='0' width='100%' class='tbl-border center'>\n";
			$rows = dbcount("(tut_id)", DB_FUSION_TUTORIAL, "tut_cat='".$data['tut_cat_id']."'");
			echo "<td class='tbl' align='middle'><center>".$data['tut_cat_name']."</center></td></tr>";
			if ($rows !=0) {
			echo "<td class='tbl2' align='middle'><span style='color:green;font-size:12px;'><b>Addon</b></span></td>\n";
			echo "<td class='tbl2' align='middle'><span style='color:green;font-size:12px;'><b>Kostenabzug</b></span></td>\n";
		    echo "<td class='tbl2' align='middle'><span style='color:green;font-size:12px;'><b>Erstellt von</b></span></td>\n";
		    echo "<td class='tbl2' align='middle'><span style='color:green;font-size:12px;'><b>Erstellt am</b></span></td>\n";
			echo "<td class='tbl2' align='middle'><span style='color:green;font-size:12px;'><b>Addon-Typ</b></span></td>\n";
		    echo "<td class='tbl2' align='middle'><span style='color:green;font-size:12px;'><b>Optionen</b></span></td>\n";
		    echo "</tr>\n";
			if (!isset($_GET['tut_cat_id']) || !isnum($_GET['tut_cat_id']) && isset($_GET['cat_id']) && isNum($_GET['cat_id'])) { $_GET['tut_cat_id'] = 0; }
            $result2 = dbquery(
			      "SELECT p.*, u.user_id, u.user_name, u.user_status 
				   FROM ".DB_FUSION_TUTORIAL." p 
				   LEFT JOIN ".DB_USERS." u ON u.user_id=p.tut_author 
				   WHERE tut_cat='".$data['tut_cat_id']."' 
				   ORDER BY tut_created DESC 
				   LIMIT ".$rowstart.",".$tut_settings['tut_perpage']);
	while($data2 = dbarray($result2)) {
		echo "<td class='tbl2' align='middle'><a href='".INFUSIONS."tutorial_portal_panel/portal.php?id=".$data2['tut_id']."'>".$data2['tut_name']."</a></td>\n";
		echo "<td class='tbl2' align='middle'>".$data2['tut_kosten']."</td>\n";
		echo "<td class='tbl2' align='middle'>".profile_link($data2['user_id'], $data2['user_name'], $data2['user_status'])."</td>\n";
        echo "<td class='tbl2' align='middle'>".showdate("%d. %B %Y", $data2['tut_created'])."</td>\n";
		echo "<td class='tbl2' align='middle'>".$data['addon_name']."</td>\n";
		echo "<td class='tbl2' align='middle'>".(EditAdd($data2['user_id']) ? "<a href='".FUSION_SELF.$aidlink."&amp;action=edit&amp;tut_id=".$data2['tut_id']."' title='".$locale['translation_a036']."'>
		".$locale['translation_g004']."</a> -" : "<span style='text-decoration: line-through;'>".$locale['translation_g004']."</span> -").(DeleteAdd($data2['user_id']) ? " 
		<a href='".FUSION_SELF.$aidlink."&amp;action=delete&amp;tut_id=".$data2['tut_id']."' title='".$locale['translation_a037']."'>".$locale['translation_g005']."</a>" : " 
		<span style='text-decoration: line-through;'>".$locale['translation_g005']."</span>")."</td>\n</tr>";
    }
	    echo "</table>";
	} else {
				echo "<tr>\n<td class='tbl2' align='middle'>".$locale['translation_a038']."</td>\n</tr>\n</table>";
			}
		}
			}
if ($rows > $tut_settings['tut_perpage']) echo "<div align='center' style=';margin-top:5px;'>\n".makepagenav($rowstart,$tut_settings['tut_perpage'],$rows,3,FUSION_SELF.$aidlink."&amp;")."\n</div>\n";
echo "<div style='text-align: right;'><a href='http://fusion-mods.de' target='_blank' title='".$locale['tut_desc']." ".showdate("%Y",time())."'><span class='small'>&copy;</span></a></div>";
closetable();
add_to_footer("<script type='text/javascript'>
		
		function onAddTag(tag) {
			alert('Added a tag: ' + tag);
		}
		function onRemoveTag(tag) {
			alert('Removed a tag: ' + tag);
		}
		
		function onChangeTag(input,tag) {
			alert('Changed a tag: ' + tag);
		}
		
		$(function() {

			$('#tags_d').tagsInput({ minChars:'3', width:'400px'});
		
		});
	
	</script>"); 
	   
require_once THEMES."templates/footer.php";
?>