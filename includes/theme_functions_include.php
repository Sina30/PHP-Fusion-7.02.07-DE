<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: theme_functions_include.php
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
if (!defined("IN_FUSION")) { die("Access Denied"); }

function check_panel_status($side) {

	global $settings;

	$exclude_list = "";

	if ($side == "left") {
		if ($settings['exclude_left'] != "") {
			$exclude_list = explode("\r\n", $settings['exclude_left']);
		}
	} elseif ($side == "upper") {
		if ($settings['exclude_upper'] != "") {
			$exclude_list = explode("\r\n", $settings['exclude_upper']);
		}
	} elseif ($side == "lower") {
		if ($settings['exclude_lower'] != "") {
			$exclude_list = explode("\r\n", $settings['exclude_lower']);
		}
	} elseif ($side == "right") {
		if ($settings['exclude_right'] != "") {
			$exclude_list = explode("\r\n", $settings['exclude_right']);
		}
	}

	if (is_array($exclude_list)) {
		$script_url = explode("/", $_SERVER['PHP_SELF']);
		$url_count = count($script_url);
		$base_url_count = substr_count(BASEDIR, "/")+1;
		$match_url = "";
		while ($base_url_count != 0) {
			$current = $url_count - $base_url_count;
			$match_url .= "/".$script_url[$current];
			$base_url_count--;
		}
		if (!in_array($match_url, $exclude_list) && !in_array($match_url.(FUSION_QUERY ? "?".FUSION_QUERY : ""), $exclude_list)) {
			return true;
		} else {
			return false;
		}
	} else {
		return true;
	}
}

function showbanners($display = "") {
	global $settings;
	ob_start();
	if ($display == 2) {
		if ($settings['sitebanner2']) {
			eval("?>".stripslashes($settings['sitebanner2'])."<?php ");
		}
	} else {
		if ($display == "" && $settings['sitebanner2']) {
			eval("?><div style='float: right;'>".stripslashes($settings['sitebanner2'])."</div>\n<?php ");
		}
		if ($settings['sitebanner1']) {
			eval("?>".stripslashes($settings['sitebanner1'])."\n<?php ");
		} elseif ($settings['sitebanner']) {
			echo "<a href='".$settings['siteurl']."'><img src='".BASEDIR.$settings['sitebanner']."' alt='".$settings['sitename']."' style='border: 0;' /></a>\n";
		} else {
			echo "<a href='".$settings['siteurl']."'>".$settings['sitename']."</a>\n";
		}
	}
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}

function showsublinks($sep = "&middot;", $class = "") {
	$sres = dbquery(
		"SELECT link_name, link_url, link_window, link_visibility FROM ".DB_SITE_LINKS."
		WHERE link_position='2' OR link_position='3' ORDER BY link_order"
	);
	if (dbrows($sres)) {
		$i = 0;
		$res = "<ul>\n";
		while ($sdata = dbarray($sres)) {
			$li_class = $class; $i++;
			if ($sdata['link_url'] != "---" && checkgroup($sdata['link_visibility'])) {
				$link_target = ($sdata['link_window'] == "1" ? " target='_blank'" : "");
				if ($i == 1) { $li_class .= ($li_class ? " " : "")."first-link"; }
				if (START_PAGE == $sdata['link_url']) { $li_class .= ($li_class ? " " : "")."current-link"; }
				if (preg_match("!^(ht|f)tp(s)?://!i", $sdata['link_url'])) {
					$res .= "<li".($li_class ? " class='".$li_class."'" : "").">".$sep."<a href='".$sdata['link_url']."'".$link_target.">\n";
					$res .= "<span>".parseubb($sdata['link_name'], "b|i|u|color|img")."</span></a></li>\n";
				} else {
					$res .= "<li".($li_class ? " class='".$li_class."'" : "").">".$sep."<a href='".BASEDIR.$sdata['link_url']."'".$link_target.">\n";
					$res .= "<span>".parseubb($sdata['link_name'], "b|i|u|color|img")."</span></a></li>\n";
				}
			}
		}
		$res .= "</ul>\n";
		return $res;
	}
}

function showsubdate($type=1)
{                            
  global $settings;          
  $retValue = "";            

  switch ($type)
        {       
          case 1:
                  $retValue = ucwords(showdate($settings['subheaderdate'], time()));
                  break;                                                            
          case 2:                                                                   
                  $jscript ="<script type='text/javascript'>                        
                              var ZeitString;                                       
                              function ZeitDatum ()                                 
                              {                                                     
                                Jetzt = new Date();                                 
                                //aktuelle Uhrzeit                                  
                                Stunden = Jetzt.getHours();                         
                                Minuten = Jetzt.getMinutes();                       
                                Sekunden = Jetzt.getSeconds();                      
                                ZeitString = Stunden;                               
                                ZeitString += ((Minuten < 10) ? \":0\" : \":\") + Minuten;
                                ZeitString += ((Sekunden < 10) ? \":0\" : \":\") + Sekunden;
                                document.getElementById('zeit').innerHTML = ZeitString;     
                                setTimeout(\"ZeitDatum()\", 1000);                          
                              }                                                             
                              </script>";                                                   
                  add_to_head($jscript);                                                    
                  $retValue = str_replace(array("May"),array("Mai"),date("d. F Y")."<span id=\"zeit\"></span>");
                  $retValue .= "<script>ZeitDatum();</script>";                                                        
                  break;
			case 3:                                                                   
                  $jscript ="<script type='text/javascript'>                        
                              var ZeitString;                                       
                              function ZeitDatum ()                                 
                              {                                                     
                                Jetzt = new Date();                                 
                                //aktuelle Uhrzeit                                  
                                Stunden = Jetzt.getHours();                         
                                Minuten = Jetzt.getMinutes();                       
                                Sekunden = Jetzt.getSeconds();                      
                                ZeitString = Stunden;                               
                                ZeitString += ((Minuten < 10) ? \":0\" : \":\") + Minuten;
                                ZeitString += ((Sekunden < 10) ? \":0\" : \":\") + Sekunden;
                                document.getElementById('zeit').innerHTML = ZeitString;     
                                setTimeout(\"ZeitDatum()\", 1000);                          
                              }                                                             
                              </script>";                                                   
                  add_to_head($jscript);                                                    
                  $retValue = str_replace(array("May"),array("Mai"),date("d. F Y")."<span id=\"zeit\"></span>");
                  $retValue .= "<script>ZeitDatum();</script>";                                                        
                  break; 				  
          default:                                                                                                     
                  $retValue = ucwords(showdate($settings['subheaderdate'], time()));                                   
                  break;                                                                                               
        }                                                                                                              
  return $retValue;                                                                                                    
}

function newsposter($info, $sep = "", $class = "") {
	global $locale; $res = "";
	$link_class = $class ? " class='$class' " : "";
	$res = THEME_BULLET." <span ".$link_class.">".profile_link($info['user_id'], $info['user_name'], $info['user_status'])."</span> ";
	$res .= $locale['global_071'].showdate("newsdate", $info['news_date']);
	$res .= $info['news_ext'] == "y" || $info['news_allow_comments'] ? $sep."\n" : "\n";
	return "<!--news_poster-->".$res;
}

function newsopts($info, $sep, $class = "") {
	global $locale, $settings; $res = "";
	$link_class = $class ? " class='$class' " : "";
	if (!isset($_GET['readmore']) && $info['news_ext'] == "y") $res = "<a href='news.php?readmore=".$info['news_id']."'".$link_class.">".$locale['global_072']."</a> ".$sep." ";
	if ($info['news_allow_comments'] && $settings['comments_enabled'] == "1") { $res .= "<a href='news.php?readmore=".$info['news_id']."#comments'".$link_class.">".$info['news_comments'].($info['news_comments'] == 1 ? $locale['global_073b'] : $locale['global_073'])."</a> ".$sep." "; }
	if ($info['news_ext'] == "y" || ($info['news_allow_comments'] && $settings['comments_enabled'] == "1")) { $res .= $info['news_reads'].$locale['global_074']."\n ".$sep; }
	return "<!--news_opts-->".$res;
}

function newscat($info, $sep = "", $class = "") {
	global $locale; $res = "";
	$link_class = $class ? " class='$class' " : "";
	$res .= $locale['global_079'];
	if ($info['cat_id']) {
		$res .= "<a href='news_cats.php?cat_id=".$info['cat_id']."'$link_class>".$info['cat_name']."</a>";
	} else {
		$res .= "<a href='news_cats.php?cat_id=0'$link_class>".$locale['global_080']."</a>";
	}
	return "<!--news_cat-->".$res." $sep ";
}

function articleposter($info, $sep = "", $class = "") {
	global $locale, $settings; $res = "";
	$link_class = $class ? " class='$class' " : "";
	$res = THEME_BULLET." ".$locale['global_070']."<span ".$link_class.">".profile_link($info['user_id'], $info['user_name'], $info['user_status'])."</span>\n";
	$res .= $locale['global_071'].showdate("newsdate", $info['article_date']);
	$res .= ($info['article_allow_comments'] && $settings['comments_enabled'] == "1" ? $sep."\n" : "\n");
	return "<!--article_poster-->".$res;
}

function articleopts($info, $sep) {
	global $locale, $settings; $res = "";
	if ($info['article_allow_comments'] && $settings['comments_enabled'] == "1") { $res = "<a href='articles.php?article_id=".$info['article_id']."#comments'>".$info['article_comments'].($info['article_comments'] == 1 ? $locale['global_073b'] : $locale['global_073'])."</a> ".$sep."\n"; }
	$res .= $info['article_reads'].$locale['global_074']." ".$sep."\n";
	$res .= "<a href='print.php?type=A&amp;item_id=".$info['article_id']."'><img src='".get_image("printer")."' alt='".$locale['global_075']."' style='vertical-align:middle;border:0;' /></a>\n";
	return "<!--article_opts-->".$res;
}

function articlecat($info, $sep = "", $class = "") {
	global $locale; $res = "";
	$link_class = $class ? " class='$class' " : "";
	$res .= $locale['global_079'];
	if ($info['cat_id']) {
		$res .= "<a href='articles.php?cat_id=".$info['cat_id']."'$link_class>".$info['cat_name']."</a>";
	} else {
		$res .= "<a href='articles.php?cat_id=0'$link_class>".$locale['global_080']."</a>";
	}
	return "<!--article_cat-->".$res." $sep ";
}

function itemoptions($item_type, $item_id) {
	global $locale, $aidlink; $res = "";
	if ($item_type == "N") {
		if (iADMIN && checkrights($item_type)) { $res .= "<!--article_news_opts--> &middot; <a href='".ADMIN."news.php".$aidlink."&amp;action=edit&amp;news_id=".$item_id."'><img src='".get_image("edit")."' alt='".$locale['global_076']."' title='".$locale['global_076']."' style='vertical-align:middle;border:0;' /></a>\n"; }
	} elseif ($item_type == "A") {
	if (iADMIN && checkrights($item_type)) { $res .= "<!--article_admin_opts--> &middot; <a href='".ADMIN."articles.php".$aidlink."&amp;action=edit&amp;article_id=".$item_id."'><img src='".get_image("edit")."' alt='".$locale['global_076']."' title='".$locale['global_076']."' style='vertical-align:middle;border:0;' /></a>\n"; }
	}
	return $res;
}

function showrendertime($queries = true) {
	global $locale, $mysql_queries_count, $settings;

	if ($settings['rendertime_enabled'] == 1 || ($settings['rendertime_enabled'] == 2 && iADMIN)) {
		$res = sprintf($locale['global_172'], substr((get_microtime() - START_TIME),0,4));
		$res .= ($queries ? " - $mysql_queries_count ".$locale['global_173'] : "");
		return $res;
	} else {
		return "";
	}
}

function showcopyright($class = "", $nobreak = false) {
	$link_class = $class ? " class='$class' " : "";
	$res = "Powered by <a href='http://www.php-fusion.co.uk'".$link_class.">PHP-Fusion</a> copyright &copy; 2002 - ".date("Y")." by Nick Jones.";
	$res .= ($nobreak ? "&nbsp;" : "<br />\n");
	$res .= "Released as free software without warranties under <a href='http://www.fsf.org/licensing/licenses/agpl-3.0.html'".$link_class.">GNU Affero GPL</a> v3.<br />\n";
    $res .= "Deutsche Version powered by <a target='_blank' href='http://www.phpfusion-deutschland.de'>PHPFusion Deutschland</a> copyright &copy; 2013 - ".date("Y")."<br />\n";
	return $res;
}

function showcounter() {
	global $locale, $settings;
	if ($settings['visitorcounter_enabled']) {
		return "<!--counter-->".number_format($settings['counter'])." ".($settings['counter'] == 1 ? $locale['global_170'] : $locale['global_171']);
	} else {
		return "";
	}
}

function panelbutton($state, $bname) {
	$bname = preg_replace("/[^a-zA-Z0-9\s]/", "_", $bname);
	if (isset($_COOKIE["fusion_box_".$bname])) {
		if ($_COOKIE["fusion_box_".$bname] == "none") {
			$state = "off";
		} else {
			$state = "on";
		}
	}
	return "<img src='".get_image("panel_".($state == "on" ? "off" : "on"))."' id='b_".$bname."' class='panelbutton' alt='' onclick=\"javascript:flipBox('".$bname."')\" />";
}

function panelstate($state, $bname) {
	$bname = preg_replace("/[^a-zA-Z0-9\s]/", "_", $bname);
	if (isset($_COOKIE["fusion_box_".$bname])) {
		if ($_COOKIE["fusion_box_".$bname] == "none") {
			$state = "off";
		} else {
			$state = "on";
		}
	}
	return "<div id='box_".$bname."'".($state == "off" ? " style='display:none'" : "").">\n";
}

function display_avatar($userdata, $size, $class = FALSE) {
	$class = ($class) ? "class='$class'" : '';
	if (array_key_exists('user_avatar', $userdata) && $userdata['user_avatar'] && file_exists(IMAGES."avatars/".$userdata['user_avatar']) && $userdata['user_status'] !='5' && $userdata['user_status'] !='6') {
		$userdata['user_id'] = array_key_exists('user_id', $userdata) && $userdata['user_id'] ? $userdata['user_id'] : 1;
		return "<a $class title='".$userdata['user_name']."' href='".BASEDIR."profile.php?lookup=".$userdata['user_id']."'><img class='img-responsive img-thumbnail m-r-10' style='display:inline; max-width:$size; max-height:$size;' src='".IMAGES."avatars/".$userdata['user_avatar']."'></a>\n";
	} else {
		$userdata['user_id'] = array_key_exists('user_id', $userdata) && $userdata['user_id'] ? $userdata['user_id'] : 1;
		return "<a $class title='".$userdata['user_name']."' href='".BASEDIR."profile.php?lookup=".$userdata['user_id']."'><img class='img-responsive img-thumbnail m-r-10' style='display:inline; max-width:$size; max-height:$size;' src='".IMAGES."avatars/noavatar100.png'></a>\n";
	}
}

function timer($updated = FALSE) {
	if (!$updated) {
		$updated = time();
	}
	$updated = stripinput($updated);
	$current = time();
	$calculated = $current-$updated;
	$second = 1;
	$minute = $second*60;
	$hour = $minute*60;
	$day = 24*$hour;
	$month = days_current_month()*$day;
	$year = (date("L", $updated) > 0) ? 366*$day : 365*$day;
	if ($calculated < 1) {
		return "<abbr class='atooltip' data-toggle='tooltip' data-placement='top' title='".showdate('longdate', $updated)."'>gerade jetzt</abbr>\n";
	}
	$timer = array($year => "Jahren", $month => "Monate", $day => "Tag", $hour => "Stunden", $minute => "Minuten",
		$second => "Sekunden");
	foreach ($timer as $arr => $unit) {
		$calc = $calculated/$arr;
		if ($calc >= 1) {
			$answer = round($calc);
			$s = ($answer > 1) ? "s" : "";
			return "Vor <abbr class='atooltip' data-toggle='tooltip' data-placement='top' title='".showdate('longdate', $updated)."'>$answer ".$unit.$s."</abbr>";
		}
	}
}
function days_current_month() {
	$year = showdate("%Y", time());
	$month = showdate("%m", time());
	return $month == 2 ? ($year%4 ? 28 : ($year%100 ? 29 : ($year%400 ? 28 : 29))) : (($month-1)%7%2 ? 30 : 31);
}
function countdown($time) {
	$updated = stripinput($time);
	$second = 1;
	$minute = $second*60;
	$hour = $minute*60;
	$day = 24*$hour;
	$month = days_current_month()*$day;
	$year = (date("L", $updated) > 0) ? 366*$day : 365*$day;
	$timer = array($year => "year", $month => "month", $day => "day", $hour => "hour", $minute => "minute",
		$second => "second");
	foreach ($timer as $arr => $unit) {
		$calc = $updated/$arr;
		if ($calc >= 1) {
			$answer = round($calc);
			$s = ($answer > 1) ? "s" : "";
			return "<abbr class='atooltip' data-toggle='tooltip' data-placement='top' title='~".showdate('newsdate', $updated+time())."'>$answer ".$unit.$s."</abbr>";
		}
	}
	if (!isset($answer)) {
		return "<abbr class='atooltip' data-toggle='tooltip' data-placement='top' title='".showdate('newsdate', time())."'>now</abbr>";
	}
}
function tab_active($tab_title, $default_active, $link_mode=false) {
	if ($link_mode) {
		$section = isset($_GET['section']) && $_GET['section'] ? $_GET['section'] : $default_active;
		$count = count($tab_title['title']);
		if ($count > 0) {
			for ($i = 0; $i <= $count; $i++) {
				$id = $tab_title['id'][$i];
				if ($section == $id) {
					return $id;
				}
			}
		} else {
			return $default_active;
		}
	} else {
		$id = $tab_title['id'][$default_active];
		$title = $tab_title['title'][$default_active];
		$v_link = str_replace(" ", "-", $title);
		$v_link = str_replace("/", "-", $v_link);
		return "".$id."$v_link";
	}
}
// v6 compatibility
function opensidex($title, $state = "on") {

	openside($title, true, $state);

}

function closesidex() {

	closeside();

}

function tablebreak() {
	return true;
}
?>