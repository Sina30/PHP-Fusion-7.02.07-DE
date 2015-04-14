<?php
/*-------------------------------------------------------+

| PHP-Fusion Content Management System

| Copyright (C) 2002 - 2011 Nick Jones

| http://www.php-fusion.co.uk/

+--------------------------------------------------------+

| Filename: dashboard.php

| Author: Hessan Adnani (ProZillaZ)

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

include LOCALE.LOCALESET."admin/adminpro.php";

$options = dbquery("SELECT * FROM ".DB_ADMINOPTIONS." WHERE option_name='admin_style'");

if (dbrows($options)) {

	$option = dbarray($options);

	if ($option['option_value'] == "classic") { redirect("index.php".$aidlink); }

}

if ($_POST) {

	if (isset($_POST['right_panels'])) {

		$right_panels = $_POST['right_panels'];

		for ($i = 0; $i < count($right_panels); $i++) {
		
			$panel_id = $right_panels[$i];
	
			$order = $i+1;
		
			$orderpanel = dbquery("UPDATE ".DB_ADMINPANELS." SET panel_order='".$order."', panel_side='2' WHERE panel_id='".$panel_id."'");
		
		}
		
		return;

	}

	if (isset($_POST['left_panels'])) {

		$left_panels = $_POST['left_panels'];

		for ($i = 0; $i < count($left_panels); $i++) {
		
			$panel_id = $left_panels[$i];
	
			$order = $i+1;
		
			$orderpanel = dbquery("UPDATE ".DB_ADMINPANELS." SET panel_order='".$order."', panel_side='1' WHERE panel_id='".$panel_id."'");
		
		}
		
		return;

	}

	if (isset($_POST['side_panels'])) {

		$side_panels = $_POST['side_panels'];

		for ($i = 0; $i < count($side_panels); $i++) {
		
			$panel_id = $side_panels[$i];
	
			$order = $i+1;
		
			$orderpanel = dbquery("UPDATE ".DB_ADMINPANELS." SET panel_order='".$order."', panel_side='3' WHERE panel_id='".$panel_id."'");
		
		}
		
		return;

	}

	if (isset($_POST['switchdata'])) {

		$switch = explode("_", $_POST['switchdata']);

		$panel_name = "";

		for ($i = 0; $i < count($switch); $i++) {

			if ($i == 0) {

			} elseif ($i == 1) {

				$panel_name .= $switch[1];

			} else {

				$panel_name .= " ".$switch[$i];

			}

		}

		if ($panel_name == $locale['global_025']) { $panel_name = 'Admin Comments'; }
	
		if ($panel_name == $locale['global_021']) { $panel_name = 'Admin Forums'; }
	
		if ($panel_name == $locale['pro_1032']) { $panel_name = 'Admin Members'; }
	
		if ($panel_name == $locale['pro_1033']) { $panel_name = 'Admin Messages'; }
	
		if ($panel_name == $locale['pro_1042']) { $panel_name = 'Admin Submissions'; }
	
		$change = dbquery("UPDATE ".DB_ADMINPANELS." SET panel_display='".$switch[0]."' WHERE panel_name='".$panel_name."'");

	}

}


if (!iADMIN || $userdata['user_rights'] == "" || !defined("iAUTH") || !isset($_GET['aid']) || $_GET['aid'] != iAUTH) { redirect("../index.php"); }

require_once THEMES."templates/admin_header.php";

$submission_num = dbcount("(submit_id)", DB_SUBMISSIONS);

$infusions_num = dbcount("(inf_id)", DB_INFUSIONS);

$panels_num = dbcount("(panel_id)", DB_PANELS);

$bbcodes_num = dbcount("(bbcode_id)", DB_BBCODES);

$smileys_num = dbcount("(smiley_id)", DB_SMILEYS);

$site_links_num = dbcount("(link_id)", DB_SITE_LINKS);

$articles_num = dbcount("(article_id)", DB_ARTICLES);

$news_num = dbcount("(news_id)", DB_NEWS);

$downloads_num = dbcount("(download_id)", DB_DOWNLOADS);

$weblinks_num = dbcount("(weblink_id)", DB_WEBLINKS);

$members_num = dbcount("(user_id)", DB_USERS, "user_joined>='".strtotime("yesterday")."'");

/*echo '

<div class="center-notifications" align="center">

	<div class="noti-button-wrapper">

		<div class="noti-button-article"><div class="img-caption"><a href="'.ADMIN.'infusions.php'.$aidlink.'" title="'.$locale['pro_1010'].'"><img src="'.THEMES.'templates/images/admin/infusion.png" border="0" /></a><h5><span>'.$infusions_num.'</span></h5></div></div>
		
		<div class="noti-button-article"><div class="img-caption"><a href="'.ADMIN.'panels.php'.$aidlink.'" title="'.$locale['pro_1100'].'"><img src="'.THEMES.'templates/images/admin/panel.png" border="0" /></a><h5><span>'.$panels_num.'</span></h5></div></div>
		
		<div class="noti-button-article"><div class="img-caption"><a href="'.ADMIN.'bbcodes.php'.$aidlink.'" title="'.$locale['pro_1101'].'"><img src="'.THEMES.'templates/images/admin/bbcodes.png" border="0" /></a><h5><span>'.$bbcodes_num.'</span></h5></div></div>
		
		<div class="noti-button-article"><a href="'.ADMIN.'settings_main.php'.$aidlink.'" title="'.$locale['pro_1102'].'"><img src="'.THEMES.'templates/images/admin/Einstellungen.png" border="0" /></a></div>
		
		<div class="noti-button-article"><div class="img-caption"><a href="'.ADMIN.'smileys.php'.$aidlink.'" title="'.$locale['pro_1103'].'"><img src="'.THEMES.'templates/images/admin/Smiley.png" border="0" /></a><h5><span>'.$smileys_num.'</span></h5></div></div>
	
		<div class="noti-button-article"><div class="img-caption"><a href="'.ADMIN.'site_links.php'.$aidlink.'" title="'.$locale['pro_1104'].'"><img src="'.THEMES.'templates/images/admin/SEITEN-LINK.png" border="0" /></a><h5><span>'.$site_links_num.'</span></h5></div></div>
	
		<div class="noti-button-article"><div class="img-caption"><a href="'.ADMIN.'articles.php'.$aidlink.'" title="'.$locale['pro_1105'].'"><img src="'.THEMES.'templates/images/admin/noti-article.png" border="0" /></a><h5><span>'.$articles_num.'</span></h5></div></div>
	
		<div class="noti-button-news"><div class="img-caption"><a href="'.ADMIN.'news.php'.$aidlink.'" title="'.$locale['pro_1011'].'"><img src="'.THEMES.'templates/images/admin/news.png" border="0" /></a><h5><span>'.$news_num.'</span></h5></div></div>
	
		<div class="noti-button-download"><div class="img-caption"><a href="'.ADMIN.'downloads.php'.$aidlink.'" title="'.$locale['pro_1012'].'"><img src="'.THEMES.'templates/images/admin/downloads.png" border="0" /></a><h5><span>'.$downloads_num.'</span></h5></div></div>

		<div class="noti-button-link"><div class="img-caption"><a href="'.ADMIN.'weblinks.php'.$aidlink.'" title="'.$locale['pro_1049'].'"><img src="'.THEMES.'templates/images/admin/weblinks.png" border="0" /></a><h5><span>'.$weblinks_num.'</span></h5></div></div>
	
		<div class="noti-button-submission"><div class="img-caption"><a href="'.ADMIN.'submissions.php'.$aidlink.'" title="'.$locale['pro_1013'].'"><img src="'.THEMES.'templates/images/admin/Einsendungen.png" border="0" /></a><h5><span>'.$submission_num.'</span></h5></div></div>
	
		<div class="noti-button-member"><div class="img-caption"><a href="'.ADMIN.'members.php'.$aidlink.'" title="'.$locale['pro_1014'].'"><img src="'.THEMES.'templates/images/admin/Mitglieder.png" border="0" /></a><h5><span>'.$members_num.'</span></h5></div></div>

	</div>';*/
echo "<td width='100%' class='tbl1'>";
echo '<div style="float:right">
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
<div class="panel panel-default ">
<div class="panel-body">
<img class="pull-left m-r-10" src="../administration/images/members.gif">
<h4 class="text-right m-t-0 m-b-0">
'.dbcount("(user_id)", DB_USERS, "user_status<='1' OR user_status='3' OR user_status='5'").'</h4><span class="m-t-10 text-uppercase text-lighter text-smaller pull-right"><strong>Registered Members</strong></span>
</div>
<div class="panel-footer"><div class="text-right text-uppercase">
</div>
</div>
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
<div class="panel panel-default ">
<div class="panel-body">
<img class="pull-left m-r-10" src="../administration/images/members.gif">
<h4 class="text-right m-t-0 m-b-0">
'.dbcount("(user_id)", DB_USERS, "user_status='2'").'</h4><span class="m-t-10 text-uppercase text-lighter text-smaller pull-right"><strong>Canceled Members</strong></span>
</div>
<div class="panel-footer"><div class="text-right text-uppercase">
</div>
</div>
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
<div class="panel panel-default ">
<div class="panel-body">
<img class="pull-left m-r-10" src="../administration/images/members.gif">
<h4 class="text-right m-t-0 m-b-0">
'.dbcount("(user_id)", DB_USERS, "user_status='4'").'</h4><span class="m-t-10 text-uppercase text-lighter text-smaller pull-right"><strong>Unactivated Members</strong></span>
</div>
<div class="panel-footer"><div class="text-right text-uppercase">
</div>
</div>
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
<div class="panel panel-default ">
<div class="panel-body">
<img class="pull-left m-r-10" src="../administration/images/members.gif">
<h4 class="text-right m-t-0 m-b-0">
'.dbcount("(user_id)", DB_USERS, "user_status='5'").'</h4><span class="m-t-10 text-uppercase text-lighter text-smaller pull-right"><strong>Security Banned Members</strong></span>
</div>
<div class="panel-footer"><div class="text-right text-uppercase">
</div>
</div>
</div>
</div>';
if ($settings['enable_deactivation'] == "1") {
	$time_overdue = time()-(86400*$settings['deactivation_period']);
	$members['inactive'] = dbcount("(user_id)", DB_USERS, "user_lastvisit<'$time_overdue' AND user_actiontime='0' AND user_joined<'$time_overdue' AND user_status='0'");
}
echo '				
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
<div class="panel panel-default blank-stats">
<div class="panel-body">
<span class="text-smaller text-uppercase"><strong>Forum Overview</strong></span>
<br>
<div class="clearfix m-t-10">
<img class="img-responsive pull-right" src="../administration/images/forums.gif">
<div class="pull-left display-inline-block m-r-10">
<span class="text-smaller">Forum</span>
<br>
<h4 class="m-t-0">'.dbcount("(forum_id)", DB_FORUMS).'</h4>
</div>
<div class="pull-left display-inline-block m-r-10">
<span class="text-smaller">Threads</span>
<br>
<h4 class="m-t-0">'.dbcount("(thread_id)", DB_THREADS).'</h4>
</div>
<div class="pull-left display-inline-block m-r-10">
<span class="text-smaller">Posts</span>
<br>
<h4 class="m-t-0">'.dbcount("(post_id)", DB_POSTS).'</h4>
</div>
<div class="pull-left display-inline-block m-r-10">
<span class="text-smaller">Users</span>
<br>
<h4 class="m-t-0">'.dbcount("('user_id')", DB_USERS, "user_posts > '0'").'</h4>
</div>
</div>
</div>
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
<div class="panel panel-default green-stats">
<div class="panel-body">
<span class="text-smaller text-uppercase"><strong>Downloads Overview</strong></span>
<br>
<div class="clearfix m-t-10">
<img class="img-responsive pull-right" src="../administration/images/dl.gif">
<div class="pull-left display-inline-block m-r-10">
<span class="text-smaller">Downloads</span>
<br>
<h4 class="m-t-0">'.dbcount("('download_id')", DB_DOWNLOADS).'</h4>
</div>
<div class="pull-left display-inline-block m-r-10">
<span class="text-smaller">Comments</span>
<br>
<h4 class="m-t-0">'.dbcount("('comment_id')", DB_COMMENTS, "comment_type='d'").'</h4>
</div>
<div class="pull-left display-inline-block m-r-10">
<span class="text-smaller">Submissions</span>
<br>
<h4 class="m-t-0">'.dbcount("(submit_id)", DB_SUBMISSIONS, "submit_type='d'").'</h4>
</div>
</div>
</div>
</div>
</div>				
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
<div class="panel panel-default purple-stats">
<div class="panel-body">
<span class="text-smaller text-uppercase"><strong>News Overview</strong></span>
<br>
<div class="clearfix m-t-10">
<img class="img-responsive pull-right" src="../administration/images/news.png">
<div class="pull-left display-inline-block m-r-10">
<span class="text-smaller">News</span>
<br>
<h4 class="m-t-0">'.dbcount("('news_id')", DB_NEWS).'</h4>
</div>
<div class="pull-left display-inline-block m-r-10">
<span class="text-smaller">Comments</span>
<br>
<h4 class="m-t-0">'.dbcount("('comment_id')", DB_COMMENTS, "comment_type='n'").'</h4>
</div>
<div class="pull-left display-inline-block m-r-10">
<span class="text-smaller">Submissions</span>
<br>
<h4 class="m-t-0">'.dbcount("(submit_id)", DB_SUBMISSIONS, "submit_type='n'").'</h4>
</div>
</div>
</div>
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
<div class="panel panel-default dark-stats">
<div class="panel-body">
<span class="text-smaller text-uppercase"><strong>Articles Overview</strong></span>
<br>
<div class="clearfix m-t-10">
<img class="img-responsive pull-right" src="../administration/images/articles.png">
<div class="pull-left display-inline-block m-r-10">
<span class="text-smaller">Articles</span>
<br>
<h4 class="m-t-0">'.dbcount("('article_id')", DB_ARTICLES).'</h4>
</div>
<div class="pull-left display-inline-block m-r-10">
<span class="text-smaller">Comments</span>
<br>
<h4 class="m-t-0">'.dbcount("('comment_id')", DB_COMMENTS, "comment_type='A'").'</h4>
</div>
<div class="pull-left display-inline-block m-r-10">
<span class="text-smaller">Submissions</span>
<br>
<h4 class="m-t-0">'.dbcount("(submit_id)", DB_SUBMISSIONS, "submit_type='a'").'</h4>
</div>
</div>
</div>
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
<div class="panel panel-default blank-stats">
<div class="panel-body">
<span class="text-smaller text-uppercase"><strong>Weblinks Overview</strong></span>
<br>
<div class="clearfix m-t-10">
<img class="img-responsive pull-right" src="../administration/images/wl.gif">
<div class="pull-left display-inline-block m-r-10">
<span class="text-smaller">Weblinks</span>
<br>
<h4 class="m-t-0">'.dbcount("('weblink_id')", DB_WEBLINKS).'</h4>
</div>
<div class="pull-left display-inline-block m-r-10">
<span class="text-smaller">Comments</span>
<br>
<h4 class="m-t-0">'.dbcount("('comment_id')", DB_COMMENTS, "comment_type='L'").'</h4>
</div>
<div class="pull-left display-inline-block m-r-10">
<span class="text-smaller">Submissions</span>
<br>
<h4 class="m-t-0">'.dbcount("(submit_id)", DB_SUBMISSIONS, "submit_type='l'").'</h4>
</div>
</div>
</div>
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
<div class="panel panel-default flat-stats">
<div class="panel-body">
<span class="text-smaller text-uppercase"><strong>Gallery Overview</strong></span>
<br>
<div class="clearfix m-t-10">
<img class="img-responsive pull-right" src="../administration/images/photoalbums.gif">
<div class="pull-left display-inline-block m-r-10">
<span class="text-smaller">Gallery</span>
<br>
<h4 class="m-t-0">'.dbcount("('photo_id')", DB_PHOTOS).'</h4>
</div>
<div class="pull-left display-inline-block m-r-10">
<span class="text-smaller">Comments</span>
<br>
<h4 class="m-t-0">'.dbcount("('comment_id')", DB_COMMENTS, "comment_type='P'").'</h4>
</div>
<div class="pull-left display-inline-block m-r-10">
<span class="text-smaller">Submissions</span>
<br>
<h4 class="m-t-0">'.dbcount("(submit_id)", DB_SUBMISSIONS, "submit_type='p'").'</h4>
</div>
</div>
</div>
</div>
</div>
<div style="float:left">
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
<div class="panel panel-default ">
<div class="panel-heading"><span class="text-smaller text-uppercase"><strong><a href="'.ADMIN.'infusions.php'.$aidlink.'">Infusions</a></strong></span><span class="pull-right label label-warning">'.dbcount("(inf_id)", DB_INFUSIONS).'</span></div>
<div class="panel-body">
<div class="text-center">'; 
echo '</div>
</div>
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
<div class="panel panel-default ">
<div class="panel-heading"><span class="text-smaller text-uppercase"><strong>Latest Comments</strong></span><span class="pull-right label label-warning">'.dbcount("(comment_id)", DB_COMMENTS).'</span></div>
<div class="panel-body">
<div class="text-center">'; 
include LOCALE.LOCALESET."admin/adminpro.php";		
		$result = dbquery(
		
			"SELECT c.comment_id, c.comment_name, c.comment_message, c.comment_datestamp, c.comment_ip, c.comment_type, c.comment_item_id, u.user_id, u.user_name, u.user_status, u.user_level, u.user_avatar FROM ".DB_COMMENTS." c
		
			LEFT JOIN ".DB_USERS." u ON c.comment_name=u.user_id ORDER BY c.comment_datestamp DESC LIMIT 0,1");

			if (dbrows($result)) {

				$counter = 0; $type = ""; $type_id = "";


				while ($data = dbarray($result)) {

					$counter++;

					if (($type != $data['comment_type'] || $type_id !=  $data['comment_item_id']) && $counter >= '2') { echo "<hr />"; }

					if ($type != $data['comment_type'] || $type_id !=  $data['comment_item_id']) { 

						echo ''.$locale['pro_1016'];

							if ($data['comment_type'] == "N") { $db_name = DB_NEWS; $db_id = 'news_id'; $db_field = 'news_subject'; $db_link = 'news.php?readmore='; $db_org = "News"; }

							if ($data['comment_type'] == "A") { $db_name = DB_ARTICLES; $db_id = 'article_id'; $db_field = 'article_subject'; $db_link = 'articles.php?article_id='; $db_org = "Articles"; }

							if ($data['comment_type'] == "D") { $db_name = DB_DOWNLOADS; $db_id = 'download_id'; $db_field = 'download_title'; $db_link = 'downloads.php?download_id='; $db_org = "Downloads"; }

							if ($data['comment_type'] == "P") { $db_name = DB_PHOTOS; $db_id = 'photo_id'; $db_field = 'photo_title'; $db_link = 'photogallery.php?photo_id='; $db_org = "Photos"; }

							$result_org = dbquery("SELECT ".$db_id.", ".$db_field." FROM ".$db_name." WHERE ".$db_id."='".$data['comment_item_id']."'");

							if (dbrows($result_org)) {

								$org = dbarray($result_org);

								echo '<b><a href="'.BASEDIR.$db_link.$org[$db_id].'" target="_blank"> '.$org[$db_field].'</a></b>';

								//echo ' '.$locale['pro_1017'].' '.$db_org.' '.$locale['pro_1018'];
							}
					}
					if ($data['user_level'] == "102" || $data['user_level'] == "103") {
echo ' <b><font color="red">'.$data['user_name'].'</b></font> '.$locale['pro_1015'].'
';
					}
					$type = $data['comment_type'];
					$type_id = $data['comment_item_id'];
				}
			} else {
				//echo '<br /><div align="center">'.$locale['global_026'].'</div><br />';
			}

echo'</div>
</div>
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
<div class="panel panel-default ">
<div class="panel-heading"><span class="text-smaller text-uppercase"><strong>Latest Ratings</strong></span><span class="pull-right label label-warning">'.dbcount("(rating_id)", DB_RATINGS).'</span></div>
<div class="panel-body">
<div class="text-center">'; 

echo '</div>
</div>
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
<div class="panel panel-default ">
<div class="panel-heading"><span class="text-smaller text-uppercase"><strong><a href="'.ADMIN.'submissions.php'.$aidlink.'">Latest Submissions</a></strong></span><span class="pull-right label label-warning">'.dbcount("(submit_id)", DB_SUBMISSIONS).'</span></div>
<div class="panel-body">
<div class="text-center">';

include LOCALE.LOCALESET."admin/adminpro.php";		
$result = dbquery("SELECT s.*, u.user_id, u.user_name, u.user_avatar FROM ".DB_SUBMISSIONS." s INNER JOIN ".DB_USERS." u ON s.submit_user =u.user_id ORDER BY s.submit_datestamp DESC LIMIT 0,1");

if (dbrows($result)) {

	$i = 0;

	echo "<table cellpadding='0' cellspacing='0' width='100%'>\n<tr>\n";
	echo "</tr>\n";

	while ($data = dbarray($result)) {

		$submit_criteria = unserialize($data['submit_criteria']);

		if ($data['submit_type'] == "n") { $submit_name = "news_subject"; $type = "News"; }

		if ($data['submit_type'] == "a") { $submit_name = "article_subject"; $type = "Article"; }

		if ($data['submit_type'] == "d") { $submit_name = "download_title"; $type = "Download"; }

		if ($data['submit_type'] == "p") { $submit_name = "photo_title"; $type = "Photo"; }

		if ($data['submit_type'] == "l") { $submit_name = "link_name"; $type = "Link"; }

		$row_color = ($i % 2 == 0 ? "tbl1" : "tbl2");

		echo "<td width='1%' height='25'>$type</td>\n";

		echo "<td width='60%' height='25'><a href='".ADMIN."submissions.php".$aidlink."&action=2&t=".$data['submit_type']."&submit_id=".$data['submit_id']."'><b><font color='red'>".$submit_criteria[$submit_name]."</b></font></a></td>\n";

		echo "<td width='50' align='center' height='25'>";

		echo '<div style="width:49px;" align="center">';

		echo '<div  style="float:left;margin-right:5px"><a href="'.ADMIN.'submissions.php'.$aidlink.'&action=2&t='.$data['submit_type'].'&submit_id='.$data['submit_id'].'" title="'.$locale['pro_1025'].'"><img src="'.THEMES.'templates/images/admin/view.png" /></a></div>';

		echo '<div  style="float:left"><a href="'.ADMIN.'submissions.php'.$aidlink.'&delete='.$data['submit_id'].'" title="'.$locale['pro_1019'].'"onclick="return confirm(\''.$locale['pro_1046'].'\');"><img src="'.THEMES.'templates/images/admin/delete.png" /></a></div>';

		echo '</div>';

		echo "</td>\n";

		echo "</tr>\n";

		$i++;

	}

	echo "</table>\n";

} else { echo '<div align="center">'.$locale['pro_1055'].'</div>'; }

echo'</div>
</div>
</div>
</div>';	
	
echo '


<script type="text/javascript">

function hideDiv(){

    if ($(window).width() > 1215) {

        $("#small").fadeOut("slow");
        $("#large").fadeIn("slow");

    }else{

        $("#small").fadeIn("slow");
        $("#large").fadeOut("slow");

    }

}

//run on document load and on window resize
$(document).ready(function () {

    //on load
    hideDiv();

    //on resize
    $(window).resize(function(){
        hideDiv();
    });

});

</script>

<div class="dashboard-content" id="large" style="display:none">

	<div style="float:left;width:49%;">';

	if (isset($_GET['status']) && $_GET['status'] == 'sort') {

		echo '<ul id="admin-panels-left" style="list-style-type: none;margin:0;padding:0">';

	}

		$panels = dbquery("SELECT * FROM ".DB_ADMINPANELS." WHERE panel_display='1' AND panel_side='1' ORDER BY panel_order ASC");

		if (dbrows($panels)) {

			while ($panel = dbarray($panels)) {

				if (isset($_GET['status']) && $_GET['status'] == 'sort') {

					echo '<li data-itemid="'.$panel['panel_id'].'">';
		
					echo '<div style="cursor:move;">';

				}
	
					include ADMIN."proadmin/".$panel['panel_file'];
		
				if (isset($_GET['status']) && $_GET['status'] == 'sort') {

					echo '</div>';
		
					echo '</li>';

				}

			}

		}

	if (isset($_GET['status']) && $_GET['status'] == 'sort') {

		echo '</ul>';
	}

echo '</div>

	<div style="float:right;width:50%;">';

	if (isset($_GET['status']) && $_GET['status'] == 'sort') {

		echo '<ul id="admin-panels-right" style="list-style-type: none;margin:0;padding:0">';

	}

		$panels = dbquery("SELECT * FROM ".DB_ADMINPANELS." WHERE panel_display='1' AND panel_side='2' ORDER BY panel_order ASC");

		if (dbrows($panels)) {

			while ($panel = dbarray($panels)) {

				if (isset($_GET['status']) && $_GET['status'] == 'sort') {

					echo '<li data-itemid="'.$panel['panel_id'].'">';
	
					echo '<div style="cursor:move;">';

				}
	
					include ADMIN."proadmin/".$panel['panel_file'];

				if (isset($_GET['status']) && $_GET['status'] == 'sort') {
		
					echo '</div>';
		
					echo '</li>';

				}

			}

		}

	if (isset($_GET['status']) && $_GET['status'] == 'sort') {

		echo '</ul>';

	}

echo '</div>

</div>
';

echo '
<div class="dashboard-content" id="small" style="display:none">

	<div style="width:100%;">';

		include ADMIN."proadmin/proforum.php";

		include ADMIN."proadmin/promembers.php";

		include ADMIN."proadmin/procomment.php";

		include ADMIN."proadmin/promessages.php";

		include ADMIN."proadmin/prosubmission.php";

echo '</div>

</div>';

echo '	<script type="text/javascript" src="'.INCLUDES.'fusionpro/jquery.dragsort-0.5.1.min.js"></script>
<!-- Bottom Scripts -->
	<script type="text/javascript" src="'.THEMES.'templates/assets/js/bootstrap.min.js"></script>
	<script src="'.THEMES.'templates/assets/js/TweenMax.min.js"></script>
	<script src="'.THEMES.'templates/assets/js/resizeable.js"></script>
	<script src="'.THEMES.'templates/assets/js/joinable.js"></script>
	<script src="'.THEMES.'templates/assets/js/xenon-api.js"></script>
	<script src="'.THEMES.'templates/assets/js/xenon-toggles.js"></script>


	<!-- Imported scripts on this page -->
	<script src="'.THEMES.'templates/assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="'.THEMES.'templates/assets/js/jvectormap/regions/jquery-jvectormap-world-mill-en.js"></script>
	<script src="'.THEMES.'templates/assets/js/xenon-widgets.js"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="'.THEMES.'templates/assets/js/xenon-custom.js"></script>
		<script type="text/javascript">

		    $("#admin-panels-left, #admin-panels-right").dragsort({ dragSelector: "div", dragBetween: true, dragEnd: saveOrder, placeHolderTemplate: "<li class=\'placeHolder\'><div></div></li>" });


		    function saveOrder() {

				var dataleft = $("#admin-panels-left li").map(function() { return $(this).data("itemid"); }).get();

				var dataright = $("#admin-panels-right li").map(function() { return $(this).data("itemid"); }).get();

		        $.post("'.ADMIN.'dashboard.php", { "left_panels[]": dataleft });

		        $.post("'.ADMIN.'dashboard.php", { "right_panels[]": dataright });

		    };

	    </script>';

require_once THEMES."templates/footer.php";
?>
