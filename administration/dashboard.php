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

						echo "<td width='100%' class='tbl1'>";
									echo '<div style="float:right">';
									echo '<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">';
									echo '<div class="panel panel-default ">';
									echo '<div class="panel-body">';
									echo '<img class="pull-left m-r-10" src="../administration/images/members.gif">';
									echo '<h4 class="text-right m-t-0 m-b-0">'.dbcount("(user_id)", DB_USERS, "user_status='0'").'</h4><span class="m-t-10 text-uppercase text-lighter text-smaller pull-right"><strong>REGISTRIERTE MITGLIEDER</strong></span>';
								echo '</div>';
							echo '<div class="panel-footer"><div class="text-right text-uppercase">';
							echo "".(checkrights("M") ? "<div class='text-right text-uppercase'>\n<a class='text-smaller' href='".ADMIN."members.php".$aidlink."'>".$locale['255b']."</a><i class='entypo right-open-mini'></i></div>\n" : '')."";
									echo '</div></div></div></div>';
									echo '<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">';
									echo '<div class="panel panel-default ">';
									echo '<div class="panel-body">';
									echo '<img class="pull-left m-r-10" src="../administration/images/members.gif">';
									echo '<h4 class="text-right m-t-0 m-b-0">'.dbcount("(user_id)", DB_USERS, "user_status='6'").'</h4><span class="m-t-10 text-uppercase text-lighter text-smaller pull-right"><strong>ABGEBROCHEN MITGLIEDER</strong></span>';
								echo '</div>';
							echo '<div class="panel-footer"><div class="text-right text-uppercase">';
							echo "".(checkrights("M") ? "<div class='text-right text-uppercase'>\n<a class='text-smaller' href='".ADMIN."members.php".$aidlink."&amp;status=5'>".$locale['255b']."</a> <i class='entypo right-open-mini'></i></div>\n" : '')."";
							echo '</div></div></div></div>';
									echo '<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">';
									echo '<div class="panel panel-default ">';
									echo '<div class="panel-body">';
									echo '<img class="pull-left m-r-10" src="../administration/images/members.gif">';
									echo '<h4 class="text-right m-t-0 m-b-0">'.dbcount("(user_id)", DB_USERS, "user_status='2'").'</h4><span class="m-t-10 text-uppercase text-lighter text-smaller pull-right"><strong>NICHT AKTIVIERTEN MITGLIEDER</strong></span>';
								echo '</div>';
							echo '<div class="panel-footer"><div class="text-right text-uppercase">';
							echo "".(checkrights("M") ? "<div class='text-right text-uppercase'>\n<a class='text-smaller' href='".ADMIN."members.php".$aidlink."&amp;status=2'>".$locale['255b']."</a> <i class='entypo right-open-mini'></i></div>\n" : '')."";
									echo '</div></div></div></div>';
									echo '<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">';
									echo '<div class="panel panel-default ">';
									echo '<div class="panel-body">';
									echo '<img class="pull-left m-r-10" src="../administration/images/members.gif">';
									echo '<h4 class="text-right m-t-0 m-b-0">'.dbcount("(user_id)", DB_USERS, "user_status='1'").'</h4><span class="m-t-10 text-uppercase text-lighter text-smaller pull-right"><strong>SICHERHEIT BANNED MITGLIEDER</strong></span>';
								echo '</div>';
							echo '<div class="panel-footer"><div class="text-right text-uppercase">';
							echo "".(checkrights("M") ? "<div class='text-right text-uppercase'><a class='text-smaller' href='".ADMIN."members.php".$aidlink."&amp;status=1'>".$locale['255b']."</a> <i class='entypo right-open-mini'></i></div>\n" : '')."";
									echo '</div></div></div></div>';
				if ($settings['enable_deactivation'] == "1") {
				$time_overdue = time()-(86400*$settings['deactivation_period']);
				$members['inactive'] = dbcount("(user_id)", DB_USERS, "user_lastvisit<'$time_overdue' AND user_actiontime='0' AND user_joined<'$time_overdue' AND user_status='0'");
			}
							echo '<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">';
								echo '<div class="panel panel-default blank-stats purple-stats">';
								echo '<div class="panel-body">';
								echo '<span class="text-smaller text-uppercase"><strong>FORUM ÜBERSICHT</strong></span>';
							echo '<br>';
								echo '<div class="clearfix m-t-10">';
								echo '<img class="img-responsive pull-right" src="../administration/images/forums.gif">';
								echo '<div class="pull-left display-inline-block m-r-10">';
								echo '<span class="text-smaller">Forum&nbsp;&nbsp;&nbsp;&nbsp;</span>';
							echo '<br>';
						echo '<h4 class="m-t-0">'.dbcount("(forum_id)", DB_FORUMS).'</h4>';
								echo '</div>';
									echo '<div class="pull-left display-inline-block m-r-10">';
									echo '<span class="text-smaller">Themen&nbsp;&nbsp;&nbsp;&nbsp;</span>';
							echo '<br>';
									echo '<h4 class="m-t-0">'.dbcount("(thread_id)", DB_THREADS).'</h4>';
							echo '</div>';
									echo '<div class="pull-left display-inline-block m-r-10">';
									echo '<span class="text-smaller">Beiträge&nbsp;&nbsp;&nbsp;&nbsp;</span>';
							echo '<br>';
									echo '<h4 class="m-t-0">'.dbcount("(post_id)", DB_POSTS).'</h4>';
							echo '</div>';
						echo '<div class="pull-left display-inline-block m-r-10">';
									echo '<span class="text-smaller">Benutzer</span>';
							echo '<br>';
									echo '<h4 class="m-t-0">'.dbcount("('user_id')", DB_USERS, "user_posts > '0'").'</h4>';
						echo '</div></div></div></div></div>';
				echo '<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">';
							echo '<div class="panel panel-default green-stats">';
									echo '<div class="panel-body">';
									echo '<span class="text-smaller text-uppercase"><strong>DOWNLOADS ÜBERSICHT</strong></span>';
							echo '<br>';
									echo '<div class="clearfix m-t-10">';
									echo '<img class="img-responsive pull-right" src="../administration/images/dl.gif">';
									echo '<div class="pull-left display-inline-block m-r-10">';
									echo '<span class="text-smaller">Downloads&nbsp;&nbsp;&nbsp;&nbsp;</span>';
							echo '<br>';
										echo '<h4 class="m-t-0">'.dbcount("('download_id')", DB_DOWNLOADS).'</h4>';
							echo '</div>';
									echo '<div class="pull-left display-inline-block m-r-10">';
									echo '<span class="text-smaller">Kommentare&nbsp;&nbsp;&nbsp;&nbsp;</span>';
							echo '<br>';
									echo '<h4 class="m-t-0">'.dbcount("('comment_id')", DB_COMMENTS, "comment_type='d'").'</h4>';
							echo '</div>';
									echo '<div class="pull-left display-inline-block m-r-10">';
									echo '<span class="text-smaller">Bewertungen&nbsp;&nbsp;&nbsp;&nbsp;</span>';
							echo '<br>';
									echo '<h4 class="m-t-0">'.dbcount("('rating_id')", DB_RATINGS, "rating_type='d'").'</h4>';
							echo '</div>';
									echo '<div class="pull-left display-inline-block m-r-10">';
									echo '<span class="text-smaller">Einsendungen</span>';
							echo '<br>';
									echo '<h4 class="m-t-0">'.dbcount("(submit_id)", DB_SUBMISSIONS, "submit_type='d'").'</h4>';
							echo '</div></div></div></div></div>				';
				echo '<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">';
							echo '<div class="panel panel-default purple-stats">';
									echo '<div class="panel-body">';
									echo '<span class="text-smaller text-uppercase"><strong>NEWS ÜBERSICHT</strong></span>';
							echo '<br>';
									echo '<div class="clearfix m-t-10">';
									echo '<img class="img-responsive pull-right" src="../administration/images/news.png">';
									echo '<div class="pull-left display-inline-block m-r-10">';
									echo '<span class="text-smaller">Nachrichten&nbsp;&nbsp;&nbsp;&nbsp;</span>';
							echo '<br>';
									echo '<h4 class="m-t-0">'.dbcount("('news_id')", DB_NEWS).'</h4>';
							echo '</div>';
									echo '<div class="pull-left display-inline-block m-r-10">';
									echo '<span class="text-smaller">Kommentare&nbsp;&nbsp;&nbsp;&nbsp;</span>';
							echo '<br>';
									echo '<h4 class="m-t-0">'.dbcount("('comment_id')", DB_COMMENTS, "comment_type='n'").'</h4>';
							echo '</div>';
									echo '<div class="pull-left display-inline-block m-r-10">';
									echo '<span class="text-smaller">Bewertungen&nbsp;&nbsp;&nbsp;&nbsp;</span>';
							echo '<br>';
									echo '<h4 class="m-t-0">'.dbcount("('rating_id')", DB_RATINGS, "rating_type='n'").'</h4>';
							echo '</div>';		
									echo '<div class="pull-left display-inline-block m-r-10">';
									echo '<span class="text-smaller">Einsendungen</span>';
							echo '<br>';
									echo '<h4 class="m-t-0">'.dbcount("(submit_id)", DB_SUBMISSIONS, "submit_type='n'").'</h4>';
							echo '</div></div></div></div></div>';
				echo '<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">';
							echo '<div class="panel panel-default dark-stats">';
									echo '<div class="panel-body">';
									echo '<span class="text-smaller text-uppercase"><strong>Artikel Übersicht</strong></span>';
							echo '<br>';
									echo '<div class="clearfix m-t-10">';
									echo '<img class="img-responsive pull-right" src="../administration/images/articles.png">';
									echo '<div class="pull-left display-inline-block m-r-10">';
									echo '<span class="text-smaller">Artikel&nbsp;&nbsp;&nbsp;&nbsp;</span>';
							echo '<br>';
									echo '<h4 class="m-t-0">'.dbcount("('article_id')", DB_ARTICLES).'</h4>';
							echo '</div>';
									echo '<div class="pull-left display-inline-block m-r-10">';
									echo '<span class="text-smaller">Kommentare&nbsp;&nbsp;&nbsp;&nbsp;</span>';
							echo '<br>';
									echo '<h4 class="m-t-0">'.dbcount("('comment_id')", DB_COMMENTS, "comment_type='A'").'</h4>';
							echo '</div>';
									echo '<div class="pull-left display-inline-block m-r-10">';
									echo '<span class="text-smaller">Bewertungen&nbsp;&nbsp;&nbsp;&nbsp;</span>';
							echo '<br>';
									echo '<h4 class="m-t-0">'.dbcount("('rating_id')", DB_RATINGS, "rating_type='A'").'</h4>';
							echo '</div>';
									echo '<div class="pull-left display-inline-block m-r-10">';
									echo '<span class="text-smaller">Einsendungen</span>';
							echo '<br>';
									echo '<h4 class="m-t-0">'.dbcount("(submit_id)", DB_SUBMISSIONS, "submit_type='a'").'</h4>';
								echo '</div></div></div></div></div>';
				echo '<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">';
									echo '<div class="panel panel-default green-stats">';
									echo '<div class="panel-body">';
									echo '<span class="text-smaller text-uppercase"><strong>Weblinks Übersicht</strong></span>';
							echo '<br>';
									echo '<div class="clearfix m-t-10">';
									echo '<img class="img-responsive pull-right" src="../administration/images/wl.gif">';
									echo '<div class="pull-left display-inline-block m-r-10">';
									echo '<span class="text-smaller">'.$locale['271'].'&nbsp;&nbsp;&nbsp;&nbsp;</span>';
							echo '<br>';
									echo '<h4 class="m-t-0">'.dbcount("('weblink_id')", DB_WEBLINKS).'</h4>';
							echo '</div>';
									echo '<div class="pull-left display-inline-block m-r-10">';
									echo '<span class="text-smaller">Kommentare&nbsp;&nbsp;&nbsp;&nbsp;</span>';
							echo '<br>';
									echo '<h4 class="m-t-0">'.dbcount("('comment_id')", DB_COMMENTS, "comment_type='L'").'</h4>';
						echo '</div>';
						echo '<div class="pull-left display-inline-block m-r-10">';
									echo '<span class="text-smaller">Bewertungen&nbsp;&nbsp;&nbsp;&nbsp;</span>';
							echo '<br>';
									echo '<h4 class="m-t-0">'.dbcount("('rating_id')", DB_RATINGS, "rating_type='L'").'</h4>';
							echo '</div>';
					echo '<div class="pull-left display-inline-block m-r-10">';
					echo '<span class="text-smaller">Einsendungen</span>';
						echo '<br>';
					echo '<h4 class="m-t-0">'.dbcount("(submit_id)", DB_SUBMISSIONS, "submit_type='l'").'</h4>';
				echo '</div></div></div></div></div>';
						echo '<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">';
						echo '<div class="panel panel-default dark-stats">';
					echo '<div class="panel-body">';
					echo '<span class="text-smaller text-uppercase"><strong>Galerie Übersicht</strong></span>';
						echo '<br>';
				echo '<div class="clearfix m-t-10">';
				echo '<img class="img-responsive pull-right" src="../administration/images/photoalbums.gif">';
					echo '<div class="pull-left display-inline-block m-r-10">';
					echo '<span class="text-smaller">Galerie&nbsp;&nbsp;&nbsp;&nbsp;</span>';
						echo '<br>';
				echo '<h4 class="m-t-0">'.dbcount("('photo_id')", DB_PHOTOS).'</h4>';
		echo '</div>';
					echo '<div class="pull-left display-inline-block m-r-10">';
					echo '<span class="text-smaller">Kommentare&nbsp;&nbsp;&nbsp;&nbsp;</span>';
						echo '<br>';
				echo '<h4 class="m-t-0">'.dbcount("('comment_id')", DB_COMMENTS, "comment_type='P'").'</h4>';
		echo '</div>';
				echo '<div class="pull-left display-inline-block m-r-10">';
				echo '<span class="text-smaller">Einsendungen</span>';
			echo '<br>';
			echo '<h4 class="m-t-0">'.dbcount("(submit_id)", DB_SUBMISSIONS, "submit_type='p'").'</h4>';
			echo '</div></div></div></div></div>';
			echo '<div style="float:left">';
				echo '<div class="col-xs-12 co-sm-6 col-md-6 col-lg-3">';

					echo '<div class="panel panel-default ">';
					echo '<div class="panel-heading"><span class="text-smaller text-uppercase"><strong><img class="img-responsive pull-left" src="../administration/images/infusionss.png">&nbsp;&nbsp;Infusions</a></strong></span><span class="pull-right label label-warning">'.dbcount("(inf_id)", DB_INFUSIONS).'</span></div>';
					echo '<div class="panel-body">';
								echo '</div>';
							echo '<div class="panel-footer">';
							/*echo'<div class="text-right text-uppercase">';*/
							echo "".(checkrights("I") ? "<div class='text-right text-uppercase'>\n<a class='text-smaller' href='".ADMIN."infusions.php".$aidlink."'>".$locale['285']."</a><i class='entypo right-open-mini'></i>\n" : '')."";
									echo '</div></div></div></div>';
				echo '<div class="col-xs-12 co-sm-6 col-md-6 col-lg-3">';
					echo '<div class="panel panel-default ">';
					echo '<div class="panel-heading"><span class="text-smaller text-uppercase"><strong><img class="img-responsive pull-left" src="../administration/images/kommentare.png">&nbsp;&nbsp;NEUESTE KOMMENTARE</strong></span><span class="pull-right label label-warning">'.dbcount("(comment_id)", DB_COMMENTS).'</span></div>';
					echo '<div class="panel-body">';
				echo '<div class="text-center">'; 
	
	// comments commit, ratings commit, submissions commit bloat up.
	$comments_type = array(
		'N' => $locale['269'],
		'D' => $locale['268'],
		'P' => $locale['272'],
		'A' => $locale['270'],
	);
	$submit_type = array(
		'n' => $locale['269'],
		'd' => $locale['268'],
		'p' => $locale['272'],
		'a' => $locale['270'],
		'l' => $locale['271'],
	);
	$link = array(
		'N' => $settings['siteurl']."news.php?readmore=%s",
		'D' => $settings['siteurl']."downloads/downloads.php?download_id=%s",
		'P' => $settings['siteurl']."photogallery/photogallery.php?photo_id=%s",
		'A' => $settings['siteurl']."articles/articles.php?article_id=%s",
	);

	$rows = dbcount("('comment_id')", DB_COMMENTS);
	$_GET['c_rowstart'] = isset($_GET['c_rowstart']) && $_GET['c_rowstart'] <= $rows ? $_GET['c_rowstart'] : 0;
	$result = dbquery("SELECT c.*, u.user_id, u.user_name, u.user_status, u.user_avatar
	FROM ".DB_COMMENTS." c LEFT JOIN ".DB_USERS." u on u.user_id=c.comment_name
	ORDER BY comment_datestamp DESC LIMIT 0,2
	");
	$nav = '';
	if ($rows > $settings['comments_per_page']) {
		$nav = "<span class='pull-right text-smaller'>".makepagenav($_GET['c_rowstart'], $settings['comments_per_page'], $rows, 2)."</span>\n";
	}
	if (dbrows($result)>0) {
		$i = 0;

		while ($data = dbarray($result)) {
			echo "<!--Start Comment Item-->\n";
			echo "<div data-id='$i' class='comment_content clearfix p-t-10 p-b-10' ".($i > 0 ? "style='border-top:1px solid #ddd;'" : '')." >\n";
			echo "<div class='pull-left m-r-10 display-inline-block' style='margin-top:0px; margin-bottom:10px;'>".display_avatar($data, '40px')."</div>\n";
			echo "<div id='comment_action-$i' class='btn-group pull-right display-none' style='position:absolute; right: 30px; margin-top:27px;'>\n
			<a class='btn btn-xs btn-default' title='".$locale['274']."' href='".ADMIN."comments.php".$aidlink."&amp;ctype=".$data['comment_type']."&amp;cid=".$data['comment_item_id']."'><img src='".THEMES."templates/images/admin/view.png' /></a>
			<a class='btn btn-xs btn-default' title='".$locale['275']."' href='".ADMIN."comments.php".$aidlink."&amp;action=edit&amp;comment_id=".$data['comment_id']."&amp;ctype=".$data['comment_type']."&amp;cid=".$data['comment_item_id']."'><img src='".THEMES."templates/images/admin/edit.png' /></a>
			<a class='btn btn-xs btn-default' title='".$locale['276']."' href='".ADMIN."comments.php".$aidlink."&amp;action=delete&amp;comment_id=".$data['comment_id']."&amp;ctype=".$data['comment_type']."&amp;cid=".$data['comment_item_id']."'><img src='".THEMES."templates/images/admin/delete.png' /></a></div>\n";
			echo "<strong>".profile_link($data['user_id'], ucwords($data['user_name']), $data['user_status'])."</strong>\n";
			echo "<span class='text-smaller text-lighter'>".$locale['273']."</span> <a class='text-smaller t-1' href='".sprintf($link[$data['comment_type']], $data['comment_item_id'])."'><strong>".$comments_type[$data['comment_type']]."</strong></a>";
			echo "&nbsp;<span class='text-smaller'>".timer($data['comment_datestamp'])."</span><br/>\n";
			echo "<span class='text-smaller text-lighter'>".trimlink(parseubb($data['comment_message']), 70)."</span>\n";
			echo "</div>\n";
			echo "<!--End Comment Item-->\n";
			$i++;
		}
		echo "<div class='clearfix'>\n";
		echo $nav;
		echo "</div>\n";
	} else {
		echo "<div class='text-center'>".$locale['254c']."</div>\n";
	}

	echo'</div></div></div></div>';
		echo '<div class="col-xs-12 co-sm-6 col-md-6 col-lg-3">';
			echo '<div class="panel panel-default ">';
				echo '<div class="panel-heading"><span class="text-smaller text-uppercase"><strong><img class="img-responsive pull-left" src="../administration/images/bewertungen.png">&nbsp;&nbsp;NEUESTE BEWERTUNGEN</strong></span><span class="pull-right label label-warning">'.dbcount("(rating_id)", DB_RATINGS).'</span></div>';
				echo '<div class="panel-body">';
			echo '<div class="text-center">'; 

// Ratings
	$rows = dbcount("('rating_id')", DB_RATINGS);
	$_GET['r_rowstart'] = isset($_GET['r_rowstart']) && $_GET['r_rowstart'] <= $rows ? $_GET['r_rowstart'] : 0;
	$result = dbquery("SELECT r.*, u.user_id, u.user_name, u.user_status, u.user_avatar
	FROM ".DB_RATINGS." r LEFT JOIN ".DB_USERS." u on u.user_id=r.rating_user
	ORDER BY rating_datestamp DESC LIMIT 0,2
	");
	$nav = '';
	if ($rows > $settings['comments_per_page']) {
		$nav = "<span class='pull-right text-smaller'>".makepagenav($_GET['r_rowstart'], $settings['comments_per_page'], $rows, 2)."</span>\n";
	}
	if (dbrows($result)>0) {
		$i = 0;
		while ($data = dbarray($result)) {
			echo "<!--Start Rating Item-->\n";
			echo "<div class='comment_content clearfix p-t-10 p-b-10' ".($i > 0 ? "style='border-top:1px solid #ddd;'" : '')." >\n";
			echo "<div class='pull-left m-r-10 display-inline-block' style='margin-top:0px; margin-bottom:10px;'>".display_avatar($data, '40px')."</div>\n";
			echo "<strong>".profile_link($data['user_id'], ucwords($data['user_name']), $data['user_status'])."</strong>\n";
			echo "<span class='text-smaller text-lighter'>".$locale['273a']."</span>\n";
			echo "<a class='text-smaller' href='".sprintf($link[$data['rating_type']], $data['rating_item_id'])."'><strong>".$comments_type[$data['rating_type']]."</strong></a>";
			echo "<span class='text-smaller text-lighter m-l-10'> ".str_repeat("<img src='".get_image("star")."' alt='*' title='".$locale['426']."' style='vertical-align:middle; width:10px;height:10px;' />", $data['rating_vote'])."</span>\n";
			echo "&nbsp;<span class='text-smaller'>".timer($data['rating_datestamp'])."</span><br/>\n";
			echo "</div>\n";
			echo "<!--End Rating Item-->\n";
			$i++;
		}
		echo "<div class='clearfix'>\n";
		echo $nav;
		echo "</div>\n";
	} else {
		echo "<div class='text-center'>".$locale['254b']."</div>\n";
	}

echo '</div></div></div></div>';
			echo '<div class="col-xs-12 co-sm-6 col-md-6 col-lg-3">';
				echo '<div class="panel panel-default ">';
				echo '<div class="panel-heading"><span class="text-smaller text-uppercase"><strong><img class="img-responsive pull-left" src="../administration/images/einsendungen.png">&nbsp;&nbsp;NEUESTE EINSENDUNGEN</strong></span><span class="pull-right label label-warning">'.dbcount("(submit_id)", DB_SUBMISSIONS).'</span></div>';
			echo '<div class="panel-body">';
		echo '<div class="text-center">';
// Submissions

include LOCALE.LOCALESET."admin/adminpro.php";		
$result = dbquery("SELECT s.*, u.user_id, u.user_name, u.user_avatar FROM ".DB_SUBMISSIONS." s INNER JOIN ".DB_USERS." u ON s.submit_user =u.user_id ORDER BY s.submit_datestamp DESC LIMIT 0,2");

if (dbrows($result)) {
	$i = 0;
	echo "</tr>\n";
	while ($data = dbarray($result)) {
		$submit_criteria = unserialize($data['submit_criteria']);
		if ($data['submit_type'] == "n") { $submit_name = "news_subject"; $type = "News"; }
		if ($data['submit_type'] == "a") { $submit_name = "article_subject"; $type = "Article"; }
		if ($data['submit_type'] == "d") { $submit_name = "download_title"; $type = "Download"; }
		if ($data['submit_type'] == "p") { $submit_name = "photo_title"; $type = "Photo"; }
		if ($data['submit_type'] == "l") { $submit_name = "link_name"; $type = "Link"; }
		$row_color = ($i % 2 == 0 ? "tbl1" : "tbl2");
		echo "<div class='pull-left m-r-10 display-inline-block' style='margin-top:0px; margin-bottom:10px;'>".display_avatar($data, '40px')."</div>\n";
		echo "<strong>".profile_link($data['user_id'], ucwords($data['user_name']), $data['user_status'])."</strong>\n";
		echo "<td width='60%' height='25'>".$locale['273b']."<a href='".ADMIN."submissions.php".$aidlink."&action=2&t=".$data['submit_type']."&submit_id=".$data['submit_id']."'><b><font color='red'> $type</b></font></a></br><font color='green'>".$submit_criteria[$submit_name]."</font></td>\n";
		echo "&nbsp;<span class='text-smaller'>".timer($data['submit_datestamp'])."</span><br/>\n";
		echo "<td width='50' align='center' height='25'>";
		echo "<div id='submission_action-$i' class='btn-group pull-right display-none' style='position:absolute; right: 30px; margin-top:5px;'>\n
			<a class='btn btn-xs btn-default' title='".$locale['274']."' href='".ADMIN."submissions.php".$aidlink."&amp;action=2&amp;t=".$data['submit_type']."&amp;submit_id=".$data['submit_id']."'><img src='".THEMES."templates/images/admin/view.png' /></a>
			<a class='btn btn-xs btn-default' title='".$locale['276']."' href='".ADMIN."submissions.php".$aidlink."&amp;delete=".$data['submit_id']."'><img src='".THEMES."templates/images/admin/delete.png' /></a></div>\n";
		echo '<div>';
		echo '</div>';
		echo "</td>\n";
		echo "</tr>\n";
		$i++;
}
} else { echo '<div align="center">'.$locale['254a'].'</div>'; }

	echo "</div>\n";
	
							echo '<div>';
echo'</div></div></div></div>';	
#echo '<div></div>';
echo '<script type="text/javascript">
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
</script>';
echo '<div class="dashboard-content" id="large" style="display:none">';
	echo '<div style="float:left;width:49%;">';
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
echo '</div></div>';
echo '<div></div>';
echo '<div class="dashboard-content" id="small" style="display:none">
	<div style="width:100%;">';
		#include ADMIN."proadmin/promembers.php";
		#include ADMIN."proadmin/promessages.php";
echo '</div></div>';
echo '<div class="dashboard-content" id="small" style="display:none">
	<div style="width:100%;">';
		#include ADMIN."proadmin/promembers.php";
		#include ADMIN."proadmin/promessages.php";
echo '</div></div>';
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
