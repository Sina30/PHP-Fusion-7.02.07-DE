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
require_once INFUSIONS."tutorial_portal_panel/includes/page.func.php";
define("TUT_ADMIN", INFUSIONS."tutorial_portal_panel/admin/");
define("TUT_CATS", INFUSIONS."tutorial_portal_panel/images/categorys/");
define("TUT_IMG", INFUSIONS."tutorial_portal_panel/images/");
define("TUT_FILE", INFUSIONS."tutorial_portal_panel/files/");
define("TUT", INFUSIONS."tutorial_portal_panel/");
//Count
define("C_PRODLS", dbcount("(tut_id)", DB_FUSION_TUTORIAL, "tut_file!=''") != 0 ? 1 : 0);
define("C_PRORAT", dbcount("(rating_item_id)", DB_RATINGS, "rating_type='J' AND rating_vote > '0'") != 0 ? 1 : 0);

function _CheckaddAccess_($cat, $dev, $sett){
if(!checkgroup($sett)){
     return false;
} elseif(!checkgroup($cat)){
     return false;
} elseif(!checkgroup($dev)){
     return false;
} else {
     return true;
    }
}

function _addAccessMsg_($cat, $dev, $sett){
       global $locale, $data;
if(!checkgroup($sett)){
     return "<div class='access-denied'>".$locale['translation_e002']."</div>";
} elseif(!checkgroup($cat)){
     return "<div class='access-denied'>".$locale['translation_e001']." <strong>".$data['tut_cat_name']."</strong></div>";
} elseif(!checkgroup($dev)){
     return "<div class='access-denied'>".$locale['translation_e000']."</div>"; 
    }
}


define("PRO_BULLET", "<img style='vertical-align: middle; border: 0px' src='".INFUSIONS."tutorial_portal_panel/images/bullet.png' class='bullet' alt='&raquo;' border='0' />");
    $settings_result = dbquery("SELECT 
	        tut_perpage AS 'perpage', 
			tut_cats_perpage AS 'cats_perpage',
			tut_cats_colum AS 'catcolum',
			tut_colum AS 'devcolum',
			tut_comments AS 'devcomments',
			tut_access AS 'addaccess',
			tut_ftypes AS 'file_types',
			tut_fmaxsize AS 'file_maxsize'
			FROM ".DB_FUSION_TUTORIAL_SETTINGS);
			if(dbrows($settings_result)){ 
			$sett = dbarray($settings_result);					  
			}
			
function add_image($image, $folder){
         if($folder == "small"){
         $src = INFUSIONS."tutorial_portal_panel/images/small_icons/$image";
		 } else if($folder == "cats"){
		 $src = INFUSIONS."tutorial_portal_panel/images/categorys/$image";
		 }
		 return $src;
}

function ADDHidden($author_hidden) {
	global $locale, $settings;
	if ($author_hidden == 1 && !checkrights('TUTP')) {
		return true;
} else {
		return false;
     }
}

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
//NEW
function add_author($user_id, $user_name, $user_status, $user_avatar){
if ($user_avatar && file_exists(IMAGES."avatars/".$user_avatar) && $user_status!=6 && $user_status!=5) {
$developer = "<a href='".BASEDIR."profile.php?lookup=".$user_id."' title='".$user_name."'>
<img class='member-avatar-online' src='".IMAGES."avatars/".$user_avatar."' alt='".$user_name."' /></a>";
} else {
$developer = "<a href='".BASEDIR."profile.php?lookup=".$user_id."' title='".$user_name."'>
<img class='member-avatar-five opacity' src='".IMAGES."avatars/noavatar100.png' alt='".$user_name."' /></a>";
}
return $developer;
}
//***
function author_alter($birthdate){
   if ($birthdate != "0000-00-00"){
		$tut_author['alder'] = explode("-", $birthdate);
		$tut_author['fodelsear'] = $tut_author['alder'][0];
		$alder['nuvarande_ar'] = date("Y", time());
		$tut_author['alder_resultat'] = $alder['nuvarande_ar']-$tut_author['fodelsear'];

		if (mktime(0,0,0,$tut_author['alder'][1], $tut_author['alder'][2], $alder['nuvarande_ar']) > time())     
         {
		$tut_author['alder_resultat']--;
         }
		$tut_author['alder_resultat'] = $tut_author['alder_resultat'];
		} else {
		$tut_author['alder_resultat'] = "Unklar";
		}
		return $tut_author['alder_resultat'];
		}
function DeleteAdd($author){
		global $userdata;
		if($userdata['user_id'] == $author || $userdata['user_id'] == 1){
        return true;
        } else {
		return false;
		}
}
function EditAdd($author){
		global $userdata;
		if($userdata['user_id'] == $author || $userdata['user_id'] == 1){
        return true;
        } else {
		return false;
		}
}
function prev_nex_add($id, $ddata){
$pres = dbquery("SELECT tut_id, tut_name, tut_created FROM ".DB_FUSION_TUTORIAL." WHERE tut_id < ".$id." AND tut_cat='".$ddata['tut_cat']."' ORDER BY tut_id DESC");
$pdata = dbarray($pres);
if(dbrows($pres)){
$prne_dev = "<div style='padding:6px; font-size: 13px;' class='tbl1'>
<a href='".INFUSIONS."tutorial_portal_panel/portal.php?id=".$pdata['tut_id']."' title='".$pdata['tut_name']."'>Zur&uuml;ck</a></div>";
return $prne_dev;
}
$nres = dbquery("SELECT tut_id, tut_name, tut_created FROM ".DB_FUSION_TUTORIAL." WHERE tut_id > ".$id." AND tut_cat='".$ddata['tut_cat']."' ORDER BY tut_id ASC");
$ndata = dbarray($nres);
if(dbrows($nres)){
$prne_dev = "<div  align='right' style='padding:6px; font-size: 13px;' class='tbl1'>
<a href='".INFUSIONS."tutorial_portal_panel/portal.php?id=".$ndata['tut_id']."' title='".$ndata['tut_name']."'>N&auml;chstes</a></div>";
return $prne_dev;
}
}    	
//******   	
?>
