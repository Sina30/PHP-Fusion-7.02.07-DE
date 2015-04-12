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

echo '

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

	</div>';

	
	
	
echo'	
	<div style="float:right">';

		if (isset($_GET['status']) && $_GET['status'] == 'sort') { 

			echo '<div style="float:left;margin-right:5px"><a href="'.FUSION_SELF.$aidlink.'"><img src="'.THEMES.'templates/images/admin/sort-button.jpg" /></a></div>';
			
			echo '<div style="float:left;line-height:300%"><a href="'.FUSION_SELF.$aidlink.'">'.$locale['pro_1078'].'</a></div>';

		} else {

			echo '<div style="float:left;margin-right:5px"><a href="'.FUSION_SELF.$aidlink.'&status=sort"><img src="'.THEMES.'templates/images/admin/sort-button.jpg" /></a></div>';
			
			echo '<div style="float:left;line-height:300%"><a href="'.FUSION_SELF.$aidlink.'&status=sort">'.$locale['pro_1077'].'</a></div>';

		}

echo '

	</div>

</div>

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
