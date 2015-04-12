<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2014 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: downloads.php
| Author: Nick Jones (Digitanium)
+--------------------------------------------------------+
| Addon Name: PFMUK Downloads Mod
| Version: 1.01
| Author: PHP-Fusion Mods UK
| Developer: Craig
| Site: http://www.phpfusionmods.co.uk
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "../maincore.php";
require_once THEMES."templates/header.php";
include LOCALE.LOCALESET."downloads.php";
include LOCALE.LOCALESET."ratings.php";
include INCLUDES."downloads_includes/downloads_functions.php";

// download the file Only Members Can Download Added by Craig - www.phpfusionmods.co.uk
if (isset($_GET['file_id']) && isnum($_GET['file_id'])) {
	$download_id = stripinput($_GET['file_id']);
	$res = 0;
	if ($data = dbarray(dbquery("SELECT download_url, download_file, download_cat FROM ".DB_DOWNLOADS." WHERE download_id='".$download_id."'"))) {
		$cdata = dbarray(dbquery("SELECT download_cat_access FROM ".DB_DOWNLOAD_CATS." WHERE download_cat_id='".$data['download_cat']."'"));
		if (checkgroup($cdata['download_cat_access'])) {
			$result = dbquery("UPDATE ".DB_DOWNLOADS." SET download_count=download_count+1 WHERE download_id='".$download_id."'");
			if (!empty($data['download_file']) && file_exists(DOWNLOADS.$data['download_file'])) {
				$res = 1;
				require_once INCLUDES."class.httpdownload.php";
				ob_end_clean();
				$object = new httpdownload;
				$object->set_byfile(DOWNLOADS.$data['download_file']);
				$object->use_resume = true;
				$object->download();
				exit;
			} elseif (!empty($data['download_url'])) {
				$res = 1;
				redirect($data['download_url']);
			}
		}
	}
	if ($res == 0) { redirect("downloads.php"); }
}



// Statistics
$dl_stats = "";
$i_alt = dbresult(dbquery("SELECT SUM(download_count) FROM ".DB_DOWNLOADS), 0);

$dl_stats .= "<table cellpadding='0' cellspacing='1' class='tbl-border' style='width:100%;'>\n";
$dl_stats .= "<tr>\n<td class='tbl2' valign='middle'><img src='".get_image("statistics")."' alt='".$locale['429']."' /></td>\n";
$dl_stats .= "<td width='100%' align='left' class='tbl1'>\n";
$dl_stats .= "<span class='small'>".$locale['415']." ".dbcount("(download_cat)", DB_DOWNLOADS)."</span><br />\n";
$dl_stats .= "<span class='small'>".$locale['440']." ".($i_alt ? $i_alt : "0")."</span><br />";

$result = dbquery(
		"SELECT td.download_id, td.download_title, td.download_count, td.download_cat,
		tc.download_cat_id, tc.download_cat_access
		FROM ".DB_DOWNLOADS." td
		LEFT JOIN ".DB_DOWNLOAD_CATS." tc ON td.download_cat=tc.download_cat_id
		WHERE ".groupaccess('download_cat_access')."
		ORDER BY download_count DESC LIMIT 0,1");

if (dbrows($result) != 0) {
	while ($data = dbarray($result)) {
		$download_title = $data['download_title'];
		$dl_stats .= "<span class='small'>".$locale['441'];
		$dl_stats .= " <a href='".FUSION_SELF."?download_id=".$data['download_id']."' title='".$download_title."' class='side'>".trimlink($data['download_title'], 100)."</a>";
		$dl_stats .= " [ ".$data['download_count']." ]</span><br />";
	}
}

$result = dbquery(
		"SELECT td.download_id, td.download_title, td.download_count, td.download_cat, td.download_datestamp,
		tc.download_cat_id, tc.download_cat_access
		FROM ".DB_DOWNLOADS." td
		LEFT JOIN ".DB_DOWNLOAD_CATS." tc ON td.download_cat=tc.download_cat_id
		WHERE ".groupaccess('download_cat_access')."
		ORDER BY download_datestamp DESC LIMIT 0,1");
if (dbrows($result) != 0) {
	while ($data = dbarray($result)) {
		$download_title = $data['download_title'];
		$dl_stats .= "<span class='small'>".$locale['442'];
		$dl_stats .= " <a href='".FUSION_SELF."?download_id=".$data['download_id']."' title='".$download_title."' class='side'>".trimlink($data['download_title'], 100)."</a>";
		$dl_stats .= " [ ".$data['download_count']." ]</span><br />";
	}
}
$dl_stats .= "</td>\n</tr>\n</table>\n";




	// Download Cats

	if (!isset($_GET['download_id']) || !isnum($_GET['download_id'])) {

	$settingsb['downloads_per_page'] = "21";

	add_to_title($locale['global_200'].$locale['400']);
	$title = $locale['400']; $error = ""; $select_cat = ""; $row_limit = $settingsb['downloads_per_page'];
	if(isset($_GET['download_cat']) && isnum($_GET['download_cat'])) {
	$select_cat = " AND download_cat='".stripinput($_GET['download_cat'])."'";
	$cname_result = dbquery("SELECT * FROM ".DB_DOWNLOAD_CATS." WHERE ".groupaccess('download_cat_access')." AND download_cat_id='".stripinput($_GET['download_cat'])."' ORDER BY download_cat_name");
	if(dbrows($cname_result)) {
	$cname_data = dbarray($cname_result);
	$title = $locale['462']." ".$cname_data['download_cat_name'];
	$titleb = $locale['400b'].$cname_data['download_cat_name'];
	add_to_title($titleb);
	$select_cat = " AND download_cat='".stripinput($_GET['download_cat'])."'";

	} else { redirect(FUSION_SELF); }
	}

	opentable($title);
	echo "<!--pre_download_idx-->\n";

	$cat_list_result = dbquery(
	"SELECT download_cat_id, download_cat_name
	FROM ".DB_DOWNLOAD_CATS." WHERE ".groupaccess('download_cat_access')."
	ORDER BY download_cat_name");
	$cats_list = "";
	if (dbrows($cat_list_result)) {
	while ($cat_list_data = dbarray($cat_list_result)) {
	$countincatb = dbcount("(download_cat_id)", DB_DOWNLOAD_CATS, "download_cat_id='".$cat_list_data['download_cat_id']."' AND ".groupaccess('download_cat_access')."");
	if ($countincatb > 0) {
	$sel = (isset($_GET['download_cat']) && $_GET['download_cat'] == $cat_list_data['download_cat_id'] ? " selected='selected'" : "");
	$cats_list .= "<option value='".$cat_list_data['download_cat_id']."'".$sel.">".$cat_list_data['download_cat_name']."</option>";
	}
	}

	echo "<div  class='tbl' style='text-align:center;  height: 40px; margin-bottom: 3px;'>\n";
	echo "<form name='download_cats_filter_form' method='get' action='".FUSION_SELF."'>\n";
	echo "<div  style='float:left; padding: 5px 0px 4px 4px;'>\n";
	echo "<select name='download_cat' class='textbox' onchange='this.form.submit();'>\n";
	echo "<option value='all'>".$locale['451']."</option>".$cats_list."</select>";
	echo"</form>\n";
	echo "</div>";
	echo "<div class='dlsearch' style='float:right; padding: 5px 4px 4px 0px;'>\n";
	echo "<form name='searchform' method='get' action='".BASEDIR."search.php'>\n";
	echo "<input type='text' name='stext' placeholder='".$locale['460b']."' class='textbox' style='width:150px' />\n";
	echo "<input type='hidden' name='stype' value='downloads' />\n";
	echo "</form>\n";
	echo "</div>";
	if (isset($_GET['download_cat']) && isnum($_GET['download_cat']) && $_GET['download_cat'] != "all") {
	$countincat = dbcount("(download_id)", DB_DOWNLOADS, "download_cat='".$_GET['download_cat']."'");
	echo"<div class='dlsearch' style='text-align: center; padding-top: 12px;'>".$locale['447']." <strong>".$countincat."</strong></div>";
	}else{
	$countincat = dbcount("(download_id)", DB_DOWNLOADS);
	echo"<div class='dlsearch' style='text-align: center; padding-top: 12px;'>".$locale['448'].": <strong>".$countincat."</strong></div>";
	}
	echo"</div>\n";
	}

	if (isset($_GET['download_cat']) && isnum($_GET['download_cat']) && $_GET['download_cat'] != "all") {
	$cat = dbquery("SELECT download_cat_id, download_cat_name FROM ".DB_DOWNLOAD_CATS." WHERE ".groupaccess('download_cat_access')." AND download_cat_id='".$_GET['download_cat']."' LIMIT 1");
	$cats_list = "";
	if (dbrows($cat)) {
	while ($cat_data = dbarray($cat)) {
	echo "<div class='tbl2' style='text-align:left; margin-top: 20px; margin-bottom: 5px;'><a href='".FUSION_SELF."'>".$locale['417']."</a> &gt; ".$cat_data['download_cat_name']."</div>";
	}
	}
	}else{
	echo "<div class='tbl2' style='text-align:left; margin-top: 20px; margin-bottom: 5px;'>".$locale['417']."</div>";
	}
	echo "<table cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>\n";

	$row_check = dbrows(dbquery("SELECT * FROM ".DB_DOWNLOADS." INNER JOIN ".DB_DOWNLOAD_CATS." ON download_cat_id = download_cat WHERE ".groupaccess('download_cat_access')." AND download_id!=''".$select_cat));
	if(!dbrows(dbquery("SELECT * FROM ".DB_DOWNLOAD_CATS." WHERE ".groupaccess('download_cat_access')))) {
	if (isset($error) ) {
	$error = "<div style='text-align: center; padding: 5px;'>".$locale['430']."</div>";
	} elseif($row_check == 0 && isset($_GET['download_id']) && isnum($_GET['download_id'])) {
	redirect(FUSION_SELF);
	} elseif($row_check == 0) {
	redirect(FUSION_SELF);
	}
	}

	// If download_cat is set but not numerical redirect to self
	if (isset($_GET['download_cat']) && (!isnum($_GET['download_cat']))) { redirect(FUSION_SELF); }

	// If download_cat is set but empty redirect to self
	if(isset($_GET['download_cat']) && ($_GET['download_cat'] =="")) { redirect(FUSION_SELF); }

	if (!isset($_GET['rowstart']) || !isnum($_GET['rowstart']) && isset($_GET['download_cat']) && ($_GET['download_cat'] =="")) $_GET['rowstart'] = 0;
	$cat_name = "";
	$result = dbquery(
	"SELECT tu.*, tn.*, tb.*, download_cat_id, download_cat_name FROM ".DB_DOWNLOAD_CATS." tn
	LEFT JOIN ".DB_DOWNLOADS." tu ON tn.download_cat_id=tu.download_cat
	LEFT JOIN ".DB_USERS." tb ON tu.download_user=tb.user_id
	WHERE ".groupaccess('download_cat_access')."
	AND download_id!=''".$select_cat." ORDER BY  download_datestamp DESC LIMIT ".$_GET['rowstart'].", ".$row_limit);
	if (dbrows($result) && $row_check > 0) {
	$counter = 0;
	$i0 = 0;
	$row_color = ($i0 % 2 == 0 ? "tbl1 tbl-dl" : "tbl2 tbl2-dl");
	while ($data = dbarray($result)) {

	if ($data['download_image_thumb']) {
	$img_thumbb = DOWNLOADS."images/".$data['download_image_thumb'];
	} else {
	$img_thumbb = DOWNLOADS."images/no_image.jpg";
	}
	if ($counter != 0 && ($counter % 3 == 0)) { echo "</tr>\n<tr>\n"; }
	echo "<td align='center' valign='top' class='$row_color'>\n";
	echo "<strong><a href='".BASEDIR."downloads/downloads.php?download_cat=".$data['download_cat']."&amp;download_id=".$data['download_id']."'>".$data['download_title']."</a></strong><br /><span style='font-size: 10px;'>by ".profile_link($data['user_id'], $data['user_name'], $data['user_status'])." - ".showdate("%d.%m.%Y", $data['download_datestamp'])."</span><div style='padding-bottom: 10px;'>\n";
	if ($settings['download_screenshot'] && $data['download_image'] !=="") {
	echo"<a href='".BASEDIR."downloads/downloads.php?download_cat=".$data['download_cat']."&amp;download_id=".$data['download_id']."'><img src='".$img_thumbb."' class='thumb-dl' alt='".$data['download_title']."' /></a>";
	}else{
	echo "<a href='".BASEDIR."downloads/downloads.php?download_cat=".$data['download_cat']."&amp;download_id=".$data['download_id']."'><img src='".$img_thumbb."' class='thumb-dl' alt='".$data['download_title']."' /></a>";
	}
	if ($data['download_allow_ratings']) {
	$rate = dbquery("SELECT SUM(rating_vote) FROM ".DB_RATINGS." WHERE rating_type='D' AND rating_item_id='".$data['download_id']."'");
	$info = dbresult($rate,0);
	$num_rating = dbcount("(rating_vote)", DB_RATINGS, "rating_type='D' AND rating_item_id='".$data['download_id']."'");
	$download_rating = ($num_rating ? $info / $num_rating : 0);
	$rate_avg_title= round($download_rating, 2)."";
	echo"<div style='margin-top:5px;'><img src='".BASEDIR."includes/downloads_includes/ratings/images/rate/".ceil($download_rating).".gif' width='64' height='12' alt='".$rate_avg_title." ".$locale['r136']."' style=' vertical-align:middle;' title='".$rate_avg_title." ".$locale['r136']."' /></div>";
	}else{
	echo"---";
	}
	if(!isset($_GET['download_cat'])) {
	echo "<span style='font-size: 10px;'>".$data['download_cat_name']."</span><br />"; 
	}
	echo "<span style='font-size: 10px;'>".$locale['dlm002'].$data['download_count'].$locale['dlm003']."</span>"; 
	echo "<a href='".BASEDIR."downloads.php?download_cat=".$data['download_cat']."&amp;download_id=".$data['download_id']."'>\n";
	echo "<div class='dl-messageb' style='margin-top: 10px; margin-bottom: 5px;'><strong>".$locale['416']."</strong>";
	echo"</div></a>";

	echo "</div>\n";
	echo "</td>\n";
	$counter++; 
	$i0;
	}

	echo "<tr>\n<td class='tbl2 small2' align='right' colspan='8'></td>\n";
	echo "</table>\n";
	echo "<!--sub_download_idx-->";
	} else {
	echo"<div style='text-align: center; padding: 5px;'>".$locale['dlm001']."</div>"; 
	}
	closetable();


	if (isset($_GET['download_cat'])) {
	if ($row_check> $settingsb['downloads_per_page']) echo "<div align='center'>".makepagenav($_GET['rowstart'], $settingsb['downloads_per_page'], $row_check, 3,FUSION_SELF."?download_cat=".$_GET['download_cat']."&amp;")."</div>\n";
	}else{
	if ($row_check > $settingsb['downloads_per_page']) echo "<div align='center'>".makepagenav($_GET['rowstart'], $settingsb['downloads_per_page'], $row_check, 3,FUSION_SELF."?")."</div>\n";
	}

	// opentable closetable Added to Downloads Stats by Craig - www.phpfusionmods.co.uk
	opentable($locale['429']);
	echo $dl_stats;
	closetable();

	}
	/////////////////////////





// Download details

if (isset($_GET['download_id']) && isnum($_GET['download_id'])) {

	$result = dbquery("SELECT td.*,
	tc.download_cat_id, tc.download_cat_access, tc.download_cat_name,
	tu.user_id, tu.user_name, tu.user_status
	FROM ".DB_DOWNLOADS." td
	LEFT JOIN ".DB_DOWNLOAD_CATS." tc ON td.download_cat=tc.download_cat_id
	LEFT JOIN ".DB_USERS." tu ON td.download_user=tu.user_id
	WHERE download_id='".$_GET['download_id']."'");

	if (dbrows($result)) {

	$data = dbarray($result);

	if (!checkgroup($data['download_cat_access'])) { redirect(FUSION_SELF);}

	add_to_head("<script type ='text/javascript'>
	$(window).ready(function(){
	$('div.waitb').css('display','none');

	$('a.download-it').one('click', function( event) {
	$(this).toggleClass('active').next().slideDown(1000, function() {
	startTimer(5);  // 60 seconds 
	setTimeout(function() {

	$('a.download-it').removeClass('active');
	window.location = '".FUSION_SELF."?cat_id=".$data['download_cat']."&file_id=".$data['download_id']."';
	$('div.waitb').css('display','none');		
	}, 5000);
	});

	return false;
	});
	});
	</script>");

	add_to_title($locale['global_200'].$locale['400']." - ".$data['download_title']);

	if ($data['download_image_thumb']) {
	$img_thumb = DOWNLOADS."images/".$data['download_image_thumb'];
	} else {
	$img_thumb = DOWNLOADS."images/no_image.jpg";
	}

	opentable($data['download_title']);
	echo "<!--pre_download_details-->\n";
	echo "<div class='tbl-border' style='margin-bottom:10px; padding:3px;'>\n";
	echo "<div class='tbl2' style='text-align:left;'>\n";
	echo "<a href='".FUSION_SELF."'>".$locale['417']."</a> &gt; <a href='".FUSION_SELF."?download_cat=".$data['download_cat']."'>".$data['download_cat_name']."</a> &gt; <strong>".$data['download_title']."</strong>";
	echo "</div>\n</div>\n";
	$desc = ($data['download_description'] != "" ? nl2br(parseubb(parsesmileys($data['download_description']))) : nl2br(stripslashes($data['download_description_short'])));
	echo "<table width='120' align='left' cellpadding='0' cellspacing='1'>\n<tr>\n";
	echo "<td  class=' dl-thumb-tbl tbl' align='center'>";
	if ($settings['download_screenshot'] && $data['download_image'] !=="") {
	echo"<a class='tozoom' href='".DOWNLOADS."images/".$data['download_image']."'><img class='thumb-dl' src='".$img_thumb."' style='float: left;margin:3px;' alt='".$data['download_title']."' /></a>";
	}else{
	echo"<img src='".$img_thumb."' style='float: left;margin:3px;' alt='".$data['download_title']."' />";
	}
	echo "</td></tr>";
	echo"<tr><td class='tbl' align='center'>";
	$parameterurl = urlencode($settings['siteurl'].FUSION_SELF."?download_cat=".$data['download_cat']."&download_id=".$data['download_id']);
	$title = $settings['sitename'].$locale['global_200'].$data['download_title'];
	echo "<div class='share-div'>
	<a class='dl-share-bookmark' onclick=\"window.open('http://www.facebook.com/share.php?u=".$parameterurl."&amp;t=".$title."','','location=no,scrollbars=yes,width=550,height=400,left='+(screen.availWidth/2-200)+',top='+(screen.availHeight/2-200)+'');return false;\"><img style='border:0px;' src='".get_image("facebook")."' alt='".$locale['share001']."'  title='".$locale['share001']."' /></a>\n
	<a style='padding-left: 3px;' class='dl-share-bookmark' onclick=\"window.open('http://twitter.com/share?url=".$parameterurl."&amp;text=$title','','location=no,scrollbars=yes,width=550,height=400,left='+(screen.availWidth/2-200)+',top='+(screen.availHeight/2-200)+'');return false;\"><img style='border:0px;' src='".get_image("twitter")."' alt='".$locale['share002']."'  title='".$locale['share002']."' /></a>\n
	<a style='padding-left: 3px;' class='dl-share-bookmark' onclick=\"window.open('https://plus.google.com/share?url=".$parameterurl."','','location=no,scrollbars=yes,width=550,height=400,left='+(screen.availWidth/2-200)+',top='+(screen.availHeight/2-200)+'');return false;\"><img style='border:0px;' src='".get_image("google+")."' alt='".$locale['share003']."'  title='".$locale['share003']."' /></a>\n</div>\n";
	echo"</td>";
	echo"</tr></table>";
	echo "<table class='dl-details-tbl' align='right' width='80%' cellpadding='0' cellspacing='1'>\n<tr>\n";
	echo "<td class='tbl1' width='80'><strong>".$locale['422'].":</strong></td>\n<td class='tbl1'>";
	echo  profile_link($data['user_id'], $data['user_name'], $data['user_status']);
	echo "</td>\n<td class='tbl1' width='80'><strong>".$locale['414']."</strong></td>\n";
	echo "<td class='tbl1'>".showdate("%d.%m.%Y %H:%M", $data['download_datestamp'])."";
	echo"</td>\n";
	echo "<td class='tbl1' width='80'><strong>".$locale['411']."</strong></td>\n";
	echo "<td class='tbl1'>";
	echo download_license();
	echo "</td></tr>";
	echo "<td class='tbl1' width='80'><strong>".$locale['418'].":</strong></td>\n";
	echo "<td class='tbl1'>"; 
	if ($data['download_homepage'] != "") {
	if (!strstr($data['download_homepage'], "http://") && !strstr($data['download_homepage'], "https://")) {
	$urlprefix = "http://";
	} else {
	$urlprefix = "";
	}
	echo "<a href='".$urlprefix.$data['download_homepage']."' title='".$urlprefix.$data['download_homepage']."' target='_blank'>".$locale['418b']."</a>";
	}else{
	echo "---";
	}
	echo"</td>\n";
	echo "<td class='tbl1' width='80'><strong>".$locale['415']."</strong></td>\n";
	echo "<td class='tbl1'>";
	echo $data['download_count']; 
	echo"</td>\n";
	echo "<td class='tbl1'><strong>".$locale['413']."</strong></td>\n";
	echo "<td class='tbl1'>";
	if ($data['download_version'] !="") {
	echo $data['download_version'];
	}else{
	echo"---";
	}			
	echo"</td>\n";
	echo "</tr>\n";
	echo "<tr><td colspan='6' class='tbl2'><strong>".$locale['428'].":</strong></td>\n";
	echo "</tr>\n<tr>\n<td colspan='6' class='tbl1'>";
	echo $desc;
	echo "</td>\n</tr>\n";
	echo"<tr><td colspan='6' style='padding-top: 15px;' class='tbl1'>";
	if ($data['download_os'] != "") {
	echo "<strong>".$locale['412']."</strong> ".$data['download_os']."\n";
	}
	if ($data['download_copyright'] != "") {
	echo " - <strong>".$locale['411b']."</strong> &copy; ".$data['download_copyright']."\n";
	}
	echo"</td></tr></table>";
	echo "<table style='height: 100px;' width='100%' cellpadding='0' cellspacing='1'>\n<tr>\n";
	echo "<tr>\n";
	echo "<td class='tbl' ><hr />\n";

	echo"<div class='dl-licb'>";
	echo download_license_colorbox();
	echo "</div><a  class='download-it' ><div class='dl-itb'>\n";
	echo "<div class='dl-message' style='margin-top: 20px; margin-bottom: 5px;'><strong>".$locale['416']."</strong>";
	if ($data['download_filesize'] != "") {
	echo " <span style='font-size: 10px;'>(".$data['download_filesize'].")</span>\n";
	}
	echo"</div></a>";
	echo"<div class='waitb message'>".$locale['dlm004']." <br />".$locale['dlm005']." <span id='countdownb' style='font-weight: bold; color: #ff0000;'>5</span> ".$locale['dlm006'].".</div>";
	echo"</div>";

	echo "</td></tr>";
	echo "</table>\n";
	echo "<!--sub_download_details-->\n";
	closetable();

	$result = dbquery("SELECT td.*, tu.user_id, tu.user_name, tu.user_status,
	tc.download_cat_id, tc.download_cat_access, tc.download_cat_name, tc.download_cat_description 
	FROM ".DB_DOWNLOADS." td
	LEFT JOIN ".DB_USERS." tu ON td.download_user=tu.user_id
	INNER JOIN ".DB_DOWNLOAD_CATS." tc ON td.download_cat=tc.download_cat_id
	".(iSUPERADMIN ? "" : " WHERE ".groupaccess('download_cat_access'))." AND  download_user='".$data['download_user']."' AND download_id !='".$data['download_id']."'
	ORDER BY RAND() DESC LIMIT 0,5");

	$row_color = ($i % 2 == 0 ? "tbl1 tbl-dl" : "tbl2 tbl2-dl");

	if (dbrows($result)) {
	opentable($locale['dlm007'].$data['user_name']);
	$i = 0;
	$dl_cat_name = "";
	if (($dl_cat_name == "") || ($dl_cat_name != $data['download_cat_name'])) {

	echo "<table cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>\n";
	echo "<tr>\n<td align='center' width='1%' style='background-color: #ccc; padding-top: 7px;' class='tbl2'><img src='".BASEDIR."includes/downloads_includes/images/download_cat_no.png' title='' alt='' border='0' /></td>";
	echo "<td class='tbl2' width='30%' style='background-color: #ccc;padding-left: 10px;'><strong>".$locale['416']."</strong>\n</td>\n";
	echo "<td class='tbl2 dlauthor' style='background-color: #ccc;padding: 5px;'><strong>".$locale['422']."</strong></td>";
	echo "<td class='tbl2 dldate' style='background-color: #ccc;padding: 5px;'><strong>".$locale['421']."</strong></td>";
	echo "<td class='tbl2 dlrat' style='background-color: #ccc;padding: 5px;'><strong>".$locale['426']."</strong></td>";
	echo "<td class='tbl2 dll' style='background-color: #ccc;padding: 5px;'><strong>".$locale['400']."</strong></td></tr>";
	}
	while ($datab = dbarray($result)) {
	$row_color = ($i % 2 == 0 ? "tbl1 tbl-dl" : "tbl2 tbl2-dl");

	if ($datab['download_datestamp'] + 604800 > time() + ($settings['timeoffset'] * 3600)) {
	$new = "<span style='font-weight: bold;'>".$datab['download_title']."</span> &nbsp;<img src='".BASEDIR."includes/downloads_includes/images/new_5.png' alt='".$locale['410']."' title='".$locale['410']."' class='dl-blink'  style='border:0px; vertical-align:middle;' />";
	} else {
	$new = $datab['download_title'];
	}

	echo "<tr>\n<td class='$row_color' align='center' width='1%'><a title='".$locale['416']." ".$datab['download_title']."' href='".FUSION_SELF."?download_cat=".$datab['download_cat']."&download_id=".$datab['download_id']."'><img src='".BASEDIR."includes/downloads_includes/images/downl.png' alt='".$locale['416']."' border='0' /></a></td>";
	echo "<td class='$row_color' style='padding: 5px;' width='25%'>";
	echo "<a href='".FUSION_SELF."?download_cat=".$datab['download_cat']."&download_id=".$datab['download_id']."' title='".$datab['download_title']." v".$datab['download_version']."'>  ".$new."</a>";
	echo "</td>\n<td class='$row_color dlauthorb' width='10%' nowrap>".profile_link($datab['user_id'], $datab['user_name'], $datab['user_status'])."</td>\n";
	echo "<td class='$row_color dldateb' width='10%' nowrap>".date("d.m.Y", $datab['download_datestamp'])."</td>\n";
	echo "<td class='$row_color dlratb' width='10%' nowrap>";
	if ($datab['download_allow_ratings']) {
	$rate = dbquery("SELECT SUM(rating_vote) FROM ".DB_RATINGS." WHERE rating_type='D' AND rating_item_id='".$datab['download_id']."'");
	$info = dbresult($rate,0);
	$num_rating = dbcount("(rating_vote)", DB_RATINGS, "rating_type='D' AND rating_item_id='".$datab['download_id']."'");
	$download_rating = ($num_rating ? $info / $num_rating : 0);
	echo"<img src='".BASEDIR."includes/downloads_includes/ratings/images/rate/".ceil($download_rating).".gif' width='64' height='12' alt='".ceil($download_rating)." ".$locale['r136']."' style=' vertical-align:middle;' title='".ceil($download_rating)." ".$locale['r136']."' />";
	}else{
	echo"---";
	}
	echo"</td>\n";
	echo "<td class='$row_color dllb' width='1%' nowrap>".$datab['download_count']."</td>";
	$i++;
	}
	echo "</tr></table>\n";
	closetable();
	} 

	echo "<!--pre_download_comments-->\n";
	// Ajax Star Ratings Added by Craig - www.phpfusionmods.co.uk
	include INCLUDES."downloads_includes/ratings/rating_functions.php";
	include INCLUDES."comments_include.php";
	if ($data['download_allow_ratings']) { showstarratings("D", $_GET['download_id'], FUSION_SELF."?cat_id=".$data['download_cat']."&amp;download_id=".$_GET['download_id']); }
	if ($data['download_allow_comments']) { showcomments("D", DB_DOWNLOADS, "download_id", $_GET['download_id'], FUSION_SELF."?cat_id=".$data['download_cat']."&amp;download_id=".$_GET['download_id']); }

	}else{
	redirect(FUSION_SELF);
	}
	}
	
require_once THEMES."templates/footer.php";
?>