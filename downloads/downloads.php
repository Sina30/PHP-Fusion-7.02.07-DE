<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) PHP-Fusion Inc
| https://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: downloads.php
| Author: Nick Jones (Digitanium)
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
add_to_title($locale['global_200'].$locale['400']);
// download the file
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
				$object->use_resume = TRUE;
				$object->download();
				exit;
			} elseif (!empty($data['download_url'])) {
				$res = 1;
				redirect($data['download_url']);
			}
		}
	}
	if ($res == 0) {
		redirect("downloads.php");
	}
}
// Statistics
$dl_stats = "";
$dl_stats .= "<div class='row m-t-20'>\n";
$dl_stats .= "<div class='col-md-6 col-lg-6'>\n";
$dl_stats .= "<h4><strong>".$locale['441']."</strong>\n</h4>";
$result = dbquery("SELECT td.download_id, td.download_title, td.download_count, td.download_cat,
            tc.download_cat_id, tc.download_cat_access
            FROM ".DB_DOWNLOADS." td
            LEFT JOIN ".DB_DOWNLOAD_CATS." tc ON td.download_cat=tc.download_cat_id
            WHERE ".groupaccess('download_cat_access')."
            ORDER BY download_count DESC LIMIT 0,15
            ");
if (dbrows($result) != 0) {
	$dl_stats .= "<div class='list-group' style='width:90%'>\n";
	while ($data = dbarray($result)) {
		$dl_stats .= "<div class='list-group-item'>";
		$download_title = $data['download_title'];
		$dl_stats .= "<a href='".FUSION_SELF."?download_id=".$data['download_id']."' title='".$download_title."'>".trimlink($data['download_title'], 100)."</a>";
		$dl_stats .= "<span class='pull-right'><span class='badge'>&nbsp;<i title='".$locale['424']."' class='fa fa-cloud-download'></i>&nbsp;".$data['download_count']." </span>\n";
		$dl_stats .= "</div>\n";
	}
	$dl_stats .= "</div>\n";
}
$dl_stats .= "</div>\n<div class='col-md-6 col-lg-6'>\n";
$dl_stats .= "<h4><strong>".$locale['442']."</strong>\n</h4>";
$result = dbquery("SELECT td.download_id, td.download_title, td.download_count, td.download_cat, td.download_datestamp, tc.download_cat_id, tc.download_cat_access
		FROM ".DB_DOWNLOADS." td
		LEFT JOIN ".DB_DOWNLOAD_CATS." tc ON td.download_cat=tc.download_cat_id
		WHERE ".groupaccess('download_cat_access')."
		ORDER BY download_datestamp DESC LIMIT 0,15");
if (dbrows($result) != 0) {
	$dl_stats .= "<div class='list-group' style='width:90%'>\n";
	while ($data = dbarray($result)) {
		$dl_stats .= "<div class='list-group-item'>";
		$download_title = $data['download_title'];
		$dl_stats .= " <a href='".FUSION_SELF."?download_id=".$data['download_id']."' title='".$download_title."'>".trimlink($data['download_title'], 100)."</a>";
		$dl_stats .= "<span class='pull-right'><span class='badge'>&nbsp;<i title='".$locale['424']."' class='fa fa-cloud-download'></i>&nbsp;".$data['download_count']." </span>\n";
		$dl_stats .= "</div>\n";
	}
	$dl_stats .= "</div>\n";
}
$dl_stats .= "</div>\n</div>\n";
$dl_stats .= "</div>\n</div>\n";
// Filter form, list of existing cats and downloads
if (!isset($_GET['download_id']) || !isnum($_GET['download_id'])) {
	opentable($locale['400']);
	echo "<!--pre_download_idx-->\n";
	$cat_list_result = dbquery(
		"SELECT download_cat_id, download_cat_name
		FROM ".DB_DOWNLOAD_CATS." WHERE ".groupaccess('download_cat_access')."
		ORDER BY download_cat_name");
	$cats_list = ""; $filter = ""; $order_by = ""; $sort = ""; $getString = "";
	if (dbrows($cat_list_result)) {
		while ($cat_list_data = dbarray($cat_list_result)) {
			$sel = (isset($_GET['cat_id']) && $_GET['cat_id'] == $cat_list_data['download_cat_id'] ? " selected='selected'" : "");
			$cats_list .= "<option value='".$cat_list_data['download_cat_id']."'".$sel.">".$cat_list_data['download_cat_name']."</option>";
		}

		if (!isset($_GET['rowstart']) || !isnum($_GET['rowstart']) || $_GET['rowstart'] > dbrows($cat_list_result)) { $_GET['rowstart'] = 0; }
		if (isset($_GET['cat_id']) && isnum($_GET['cat_id']) && $_GET['cat_id'] != "all") {
			$filter .= " AND download_cat_id='".$_GET['cat_id']."'";
			$order_by_allowed = array("download_id", "download_user", "download_count", "download_datestamp");
			if (isset($_GET['orderby']) && in_array($_GET['orderby'], $order_by_allowed)) {
				$order_by = $_GET['orderby'];
				$getString .= "&amp;orderby=".$order_by;
			} else {
				$order_by = "";
			}
			if (isset($_GET['sort']) && $_GET['sort'] == "DESC") {
				$sort = "DESC";
				$getString .= "&amp;sort=DESC";
			} else {
				$sort = "ASC";
			}
		} else {
			$filter = ""; $order_by = ""; $sort = ""; // Can be removed
		}
		echo "<ol class='breadcrumb'>\n";
		echo "<li><a href='".FUSION_SELF."'>".$locale['417']."</a> / <a href='".FUSION_SELF."?cat_id=".$_data['download_cat_id']."'>".$_data['download_cat_name']."</a></li>\n";
		echo "</ol>\n";
		
		echo "<div class='panel panel-default'>\n";
		echo "<div class='panel-body p-b-0'>\n";
		echo "</form>\n";
		echo "<form name='searchform' method='get' action='".BASEDIR."search.php'>\n";
		echo "<span class='small'>".$locale['460']." </span><br />\n";
		echo "<input type='text' name='stext' class='textbox' style='width:90%' />\n";
		echo "<input type='submit' name='search' value='".$locale['461']."' class='btn btn-default button' />\n";
		echo "<input type='hidden' name='stype' value='downloads' />\n";
		echo "</form>\n";
		echo "<script language='JavaScript' type='text/javascript'>\n";
		echo "/* <![CDATA[ */\n";
		echo "jQuery(document).ready(function() {
				jQuery('#filter_button').hide();
			});";
		echo "/* ]]>*/\n";
		echo "</script>\n";
		echo "</div>\n";
		echo "<div class='panel-footer clearfix'>\n";
		echo "<form name='filter_form' method='get' action='".FUSION_SELF."'>\n";
		echo "<tr>\n";
		//echo "<td class='tbl1' style='width:40%; text-align:left;'>".$locale['450']."</td>\n";
		echo "<td class='tbl1' style='width:90%; text-align:right;'>".$locale['462']."\n";
		echo "<select name='cat_id' class='textbox' onchange='this.form.submit();' style='width: 250px;'>\n";
		echo "<option value='all'>".$locale['451']."</option>".$cats_list."</select>\n";
		echo "</td>\n";
		echo "</tr>\n";
		if (isset($_GET['cat_id']) && isnum($_GET['cat_id'])) {
			echo "<tr>\n";
			echo "<span class='pull-right'>".$locale['463']." <select name='orderby' class='textbox' onchange='this.form.submit();'>\n";
			echo "<option value='download_id'".($order_by == "download_id" ? " selected='selected'" : "").">".$locale['452']."</option>\n";
			echo "<option value='download_title'".($order_by == "download_title" ? " selected='selected'" : "").">".$locale['453']."</option>\n";
			echo "<option value='download_user'".($order_by == "download_user" ? " selected='selected'" : "").">".$locale['454']."</option>\n";
			echo "<option value='download_count'".($order_by == "download_count" ? " selected='selected'" : "").">".$locale['455']."</option>\n";
			echo "<option value='download_datestamp'".($order_by == "download_datestamp" ? " selected='selected'" : "").">".$locale['456']."</option>\n";
			echo "</select>\n";
			echo "<select name='sort' class='textbox' onchange='this.form.submit();'>\n";
			echo "<option value='ASC'".($sort == "ASC" ? " selected='selected'" : "").">".$locale['457']."</option>\n";
			echo "<option value='DESC'".($sort == "DESC" ? " selected='selected'" : "").">".$locale['458']."</option>\n";
			echo "</select></span>";
			echo "</td>\n";
			echo "</tr>\n";
		}
		echo "</div>\n</div>\n";
		
		
	}
	$cat_result = dbquery("SELECT download_cat_id, download_cat_name, download_cat_description, download_cat_access, download_cat_sorting
			FROM ".DB_DOWNLOAD_CATS."
			WHERE ".groupaccess('download_cat_access').$filter."
			ORDER BY download_cat_name");
	if (dbrows($cat_result)) {
		echo "<div class='list-group' style='width:90%'>\n";
		echo "<div class='list-group-item'>\n";
		echo "<span class='pull-left'><strong>".$locale['415']." ".dbcount("(download_cat)", DB_DOWNLOADS)." </strong>\n</span>\n";
		$i_alt = dbresult(dbquery("SELECT SUM(download_count) FROM ".DB_DOWNLOADS), 0);
		echo "<span class='pull-right'><strong>".$locale['440']." ".($i_alt ? $i_alt : "0")."</strong></span><br/>\n";
		echo "</div>\n";
		while ($cat_data = dbarray($cat_result)) {
			echo "<div class='list-group-item'>\n";
			echo "<h1><a href='".FUSION_SELF."?cat_id=".$cat_data['download_cat_id']."'><strong>".$cat_data['download_cat_name']."</strong></a></h1>\n";
			echo (isset($_POST['cat_id']) && isnum($_POST['cat_id']) && $cat_data['download_cat_description']) ? "<span>".$cat_data['download_cat_description']."</span>\n<br/>" : '';
			if (checkgroup($cat_data['download_cat_access'])) {
				echo "<!--pre_download_cat-->";
				$rows = dbcount("(download_id)", DB_DOWNLOADS, "download_cat='".$cat_data['download_cat_id']."'");
				if (!isset($_GET['rowstart'.$cat_data['download_cat_id']]) || !isnum($_GET['rowstart'.$cat_data['download_cat_id']]) || $_GET['rowstart'.$cat_data['download_cat_id']] > $rows) {
					$_GET['rowstart'.$cat_data['download_cat_id']] = 0;
				}
				if ($rows != 0) {
					$result = dbquery("SELECT td.download_id, td.download_user, td.download_datestamp, td.download_image_thumb, td.download_cat,
									td.download_title, td.download_version, td.download_count, td.download_description_short,
									tu.user_id, tu.user_name, tu.user_avatar, tu.user_status,
                                    SUM(tr.rating_vote) AS sum_rating,
                                    COUNT(tr.rating_item_id) AS count_votes
                                    FROM ".DB_DOWNLOADS." td
                                    LEFT JOIN ".DB_USERS." tu ON td.download_user=tu.user_id
                                    LEFT JOIN ".DB_RATINGS." tr ON tr.rating_item_id = td.download_id AND tr.rating_type='D'
                                    WHERE download_cat='".$cat_data['download_cat_id']."'
                                    GROUP BY download_id
                                    ORDER BY ".($order_by == "" ? $cat_data['download_cat_sorting'] : $order_by." ".$sort)."
                                    LIMIT ".$_GET['rowstart'.$cat_data['download_cat_id']].",".$settings['downloads_per_page']);
					$numrows = dbrows($result);
					$i = 1;
					while ($data = dbarray($result)) {
						if ($data['download_datestamp']+604800 > time()+($settings['timeoffset']*3600)) {
							$new = " <span class='label label-success'> &nbsp;<img src='".THEME."images/icons/new_dl_icon.png' alt='Neu' title='Neu' style='border:0px; vertical-align:middle;' /></span>";
						} else {
							$new = "";
						}
						if ($data['download_image_thumb']) {
							$img_thumb = DOWNLOADS."images/".$data['download_image_thumb'];
						} else {
							$img_thumb = DOWNLOADS."images/no_image.jpg";
						}
						$comments_count = dbcount("(comment_id)", DB_COMMENTS, "comment_type='D' AND comment_item_id='".$data['download_id']."'");
						echo "<div class='media clearfix'>\n";
						echo ($settings['download_screenshot']) ? "<a class='pull-left' href='".FUSION_SELF."?cat_id=".$cat_data['download_cat_id']."&amp;download_id=".$data['download_id']."'>\n<img class='img-responsive img-thumbnail' src='".$img_thumb."' style='float: left;margin:3px;' alt='".$data['download_title']."' />\n</a>\n" : '';
						echo "<div class='media-body'>\n";
						echo "<h3 class='media-heading'><a href='".FUSION_SELF."?cat_id=".$cat_data['download_cat_id']."&amp;download_id=".$data['download_id']."'>".$data['download_title']."</a> <small>$new</small></h3>\n";
						echo "<div class='media-info'><strong>\n";
						echo "<i title='".$locale['421']."' class='fa fa-calendar-o'></i> ".showdate("shortdate", $data['download_datestamp'])."\n";
						if ($data['user_avatar'] && file_exists(IMAGES."avatars/".$data['user_avatar'])) { $asrc = IMAGES."avatars/".$data['user_avatar']; }
      else { $src = IMAGES."avatars/noavatar50.png"; }
     if($data['user_avatar'] && file_exists(IMAGES."avatars/".$data['user_avatar'])) { $src = IMAGES."avatars/".$data['user_avatar']; }
      else { $src = IMAGES."avatars/noavatar50.png"; }
		echo "<img class='img-responsive img-rounded m-r-10' style='display:inline; max-width:15px; max-height:15px;  border-radius: 6px;' src='".$src."' alt='".$src."' />";
						echo "&nbsp;<i title='".$locale['422']."' class='fa fa-user'></i> ".profile_link($data['user_id'], $data['user_name'], $data['user_status']);
						echo($data['download_version'] ? "&nbsp;<i title='".$locale['423']."' class='fa fa-code-fork'></i>  ".$data['download_version'] : "--");
						echo "&nbsp;<i title='".$locale['424']."' class='fa fa-cloud-download'></i>&nbsp;".number_format($data['download_count']);
						echo($data['count_votes'] > 0 ? str_repeat("&nbsp;<i title='".$locale['426']."' class='fa fa-star' style='vertical-align:middle; width:10px;height:10px;' /></i>", ceil($data['sum_rating']/$data['count_votes'])) : "");
						echo "</strong></div>";
						echo $data['download_description_short'] ? $data['download_description_short'] : '';
						echo "</div>\n</div>\n";
					}
					if ($rows > $settings['downloads_per_page']) {
						echo "<div class='text-center'>\n".makepagenav($_GET['rowstart'.$cat_data['download_cat_id']], $settings['downloads_per_page'], $rows, 3, FUSION_SELF."?cat_id=".$cat_data['download_cat_id'].$getString."&amp;", "rowstart".$cat_data['download_cat_id'])."\n</div>\n";
					}
				} else {
					echo $locale['431'];
					echo "<!--sub_download_cat-->";
				}
			}
			echo "</div>\n";
		}
	} else {
		echo "<div style='text-align:center'><br />\n".$locale['430']."<br /><br />\n</div>\n";
	}
	echo "<!--sub_download_idx-->";
}
// Download details
if (isset($_GET['download_id']) && isnum($_GET['download_id'])) {
	add_to_head("<link rel='stylesheet' href='".INCLUDES."jquery/colorbox/colorbox.css' type='text/css' media='screen' />");
	add_to_head("<script type='text/javascript' src='".INCLUDES."jquery/colorbox/jquery.colorbox.js'></script>");
	add_to_head("<script type='text/javascript'>\n
	/* <![CDATA[ */\n
	jQuery(document).ready(function(){
		jQuery('a.tozoom').colorbox();
	});\n
	/* ]]>*/\n
	</script>\n");
	$result = dbquery("SELECT td.*,
				tc.download_cat_id, tc.download_cat_access, tc.download_cat_name,
				tu.user_id, tu.user_name, tu.user_status, tu.user_avatar, tu.user_level
                FROM ".DB_DOWNLOADS." td
                LEFT JOIN ".DB_DOWNLOAD_CATS." tc ON td.download_cat=tc.download_cat_id
                LEFT JOIN ".DB_USERS." tu ON td.download_user=tu.user_id
                WHERE download_id='".$_GET['download_id']."'");
	if (dbrows($result)) {
		$data = dbarray($result);
		if (!checkgroup($data['download_cat_access'])) {
			redirect(FUSION_SELF);
		}
		opentable($locale['400'].": ".$data['download_title']);
		echo "<ol class='breadcrumb'>\n";
		echo "<li><a href='".BASEDIR."downloads/downloads.php'>".$locale['417']."</a> / <a href='".BASEDIR."downloads/downloads.php?cat_id=".$data['download_cat']."'>".$data['download_cat_name']."</a> / ".$data['download_title']."</li>\n";
		echo "</ol>\n";
		echo "<!--pre_download_details-->\n";
		echo "<h2>".$data['download_title']." V:".$data['download_version']."</h2>\n";
		echo "<div class='row'>\n";
		echo "<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>\n";
		echo "<div class='panel panel-default'>\n";
		echo "<div class='panel-body'>\n";
		$na = $locale['429a'];
		echo $data['download_image'] && file_exists(DOWNLOADS."images/".$data['download_image']) ? "<img class='img-responsive' src='".DOWNLOADS."images/".$data['download_image']."' />" : "<img class='img-responsive' src='".DOWNLOADS."images/Download.svg".$data['download_image']."' />";
		echo "<div>\n";
		echo "<a href='".BASEDIR."downloads/downloads.php?cat_id=".$data['download_cat_id']."&amp;file_id=".$data['download_id']."' class='btn btn-success m-t-10 btn-block' target='_blank'><strong>".$locale['416']."
                ".($data['download_filesize'] ? "(".$data['download_filesize'].")" : '')."
                </strong></a>\n";
		if ($settings['download_screenshot'] && $data['download_image'] != "") {
			echo "<a class='btn btn-primary m-t-10 btn-block' href='".DOWNLOADS."images/".$data['download_image']."'><strong>".$locale['419']."</strong></a>\n";
		}
		echo "</div>\n";
		echo "</div>\n</div>\n";
		echo $data['download_description'] != "" ? nl2br(parseubb(parsesmileys($data['download_description']))) : nl2br(stripslashes($data['download_description_short']));
		echo "</div><div class='col-xs-12 col-sm-4 col-md-4 col-lg-4 text-smaller'>\n";
		if ($data['download_homepage'] != "") {
			if (!strstr($data['download_homepage'], "http://") && !strstr($data['download_homepage'], "https://")) {
				$urlprefix = "http://";
			} else {
				$urlprefix = "";
			}
			echo "<div class='panel panel-default'>\n<div class='panel-body'>\n";
			echo "<div class='row m-0'>\n<label class='text-left col-xs-12 col-sm-5 col-md-5 col-lg-5 p-l-0'>".$locale['418']."</label>\n";
			echo "<a href='".$urlprefix.$data['download_homepage']."' title='".$urlprefix.$data['download_homepage']."' target='_blank'>".$locale['418b']."</a>";
			echo "</div>\n";
			echo "<div class='row m-0'>\n<label class='text-left col-xs-12 col-sm-5 col-md-5 col-lg-5 p-l-0'>".$locale['427']."</label>\n";
			echo "".showdate("shortdate", $data['download_datestamp'])."\n";
			echo "</div>\n";
			if ($data['download_version'] != "" || $data['download_license'] != "" || $data['download_os'] != "" || $data['download_copyright'] != "") {
				echo "<div class='row m-0'>\n<label class='text-left col-xs-12 col-sm-5 col-md-5 col-lg-5 p-l-0'>".$locale['428'].":</label> ".$data['download_copyright']."</div>";
				echo $data['download_version'] ? "<div class='row m-0'>\n<label class='text-left col-xs-12 col-sm-5 col-md-5 col-lg-5 p-l-0'>".$locale['413']."</label> ".$data['download_version']."</div>" : '';
				echo $data['download_license'] ? "<div class='row m-0'>\n<label class='text-left col-xs-12 col-sm-5 col-md-5 col-lg-5 p-l-0'>".$locale['411']."</label> ".$data['download_license']."</div>" : '';
				echo $data['download_os'] ? "<div class='row m-0'>\n<label class='text-left col-xs-12 col-sm-5 col-md-5 col-lg-5 p-l-0'>".$locale['412']."</label> ".$data['download_os']."</div>" : '';
			}
			echo "</div>\n</div>\n";
		}
		echo "<div class='panel panel-default'>\n<div class='panel-body'>\n";
		echo "<img style='max-width:20px; margin-right:10px;' src='".get_image("downloads")."' alt='".$locale['424']."' /><span class='icon-sm'><strong>".$data['download_count']."</strong></span> ".$locale['416']."\n";
		echo "</div>\n</div>\n";
		echo "<div class='clearfix'>\n";
		echo "<div class='pull-left m-r-10 display-inline-block' style='margin-top:0px; margin-bottom:10px; margin: 2px 10px 0px 5px;'>".display_avatar($data, '50px')."</div>\n";
		echo "<strong> ".profile_link($data['user_id'], $data['user_name'], $data['user_status'])."</strong><br/>\n".getuserlevel($data['user_level'])." ";
		echo "</div>\n";
		echo "</div>\n</div>\n";
		echo "<!--sub_download_details-->\n";
		closetable();
		echo "<!--pre_download_comments-->\n";
		include INCLUDES."comments_include.php";
		include INCLUDES."ratings_include.php";
		if ($data['download_allow_comments']) {
			showcomments("D", DB_DOWNLOADS, "download_id", $_GET['download_id'], FUSION_SELF."?cat_id=".$data['download_cat']."&amp;download_id=".$_GET['download_id']);
		}
		if ($data['download_allow_ratings']) {
			showratings("D", $_GET['download_id'], FUSION_SELF."?cat_id=".$data['download_cat']."&amp;download_id=".$_GET['download_id']);
		}
	}
}
echo $dl_stats;
closetable();
require_once THEMES."templates/footer.php";
?>