<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2014 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Theme name: Cube
| Theme version: 1.0
| Author: Vlad Fagarasanu (Faga)
| Web: www.cvision.eu
| EMail: office@cvision.eu
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

set_image("folder",  THEME."forum/folder.png");
set_image("foldernew",  THEME."forum/foldernew.png");
set_image("folderlock",  THEME."forum/folderlock.png");
set_image("stickythread", THEME."forum/stickythread.png");
set_image("printer", THEME."images/icons/printer.png");
set_image("up", THEME."images/up.png");
set_image("down", THEME."images/down.png");
set_image("left", THEME."images/left.png");
set_image("right", THEME."images/right.png");

set_image("reply", THEME."forum/reply.gif");
set_image("delete", THEME."forum/delete.gif");
set_image("newthread", THEME."forum/newthread.gif");
set_image("web", THEME."forum/web.gif");
set_image("pm", THEME."forum/pm.gif");
set_image("quote", THEME."forum/quote.gif");
set_image("forum_edit", THEME."forum/edit.gif");

function theme_output($output) {
	
	$search = array(
		"@<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>@si",
		"@<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='(.*?)' lang='(.*?)'>@si",
		"@><img src='reply' alt='(.*?)' style='border:0px' />@si",
		"@><img src='newthread' alt='(.*?)' style='border:0px;?' />@si",
		"@><img src='web' alt='(.*?)' style='border:0;vertical-align:middle' />@si",
		"@><img src='pm' alt='(.*?)' style='border:0;vertical-align:middle' />@si",
		"@><img src='quote' alt='(.*?)' style='border:0px;vertical-align:middle' />@si",
		"@><img src='forum_edit' alt='(.*?)' style='border:0px;vertical-align:middle' />@si",
		"@<a href='".ADMIN."comments.php(.*?)&amp;ctype=(.*?)&amp;cid=(.*?)'>(.*?)</a>@si"
	);
	$replace = array(
		'<!doctype html>',
		'',
		' class="big button">$1',
		' class="big button">$1',
		' class="button" rel="nofollow" title="$1" style="margin: 0 4px 0 0;">Web',
		' class="button" title="$1" style="margin: 0 4px 0 0;">PM',
		' class="button" title="$1">$1',
		' class="negative button" title="$1">$1',
		'<a href="'.ADMIN.'comments.php$1&amp;ctype=$2&amp;cid=$3" class="big button">$4</a>'
	);
	$output = preg_replace($search, $replace, $output);

	return $output;
}	

function showcvisioncr($class = "", $nobreak = false) {
	$link_class = $class ? " class='$class' " : "";
	$res = "Powered by <a href='http://www.php-fusion.co.uk'".$link_class.">PHP-Fusion</a> copyright &copy; 2002 - ".date("Y")." by Nick Jones.";
	$res .= ($nobreak ? "&nbsp;" : "<br />\n");
	$res .= "Released as free software without warranties under <a href='http://www.fsf.org/licensing/licenses/agpl-3.0.html'".$link_class.">GNU Affero GPL</a> v3.\n";
	return $res;
}

function showlogo($display = "") {
	global $settings;
	ob_start();
	echo "<div id='logo'>\n";
	if ($settings['sitebanner1']) {
			eval("?>".stripslashes($settings['sitebanner1'])."\n<?php ");
		} elseif ($settings['sitebanner']) {
			echo "<a href='".$settings['siteurl']."'><img src='".BASEDIR.$settings['sitebanner']."' alt='".$settings['sitename']."' style='border: 0;' /></a>\n";
	}
	echo "</div>\n";
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}

function showsecondbanner($display = "") {
	global $settings;
	ob_start();
	if ($display == 2) {
		if ($settings['sitebanner2']) {
			eval("?>".stripslashes($settings['sitebanner2'])."<?php ");
		}
	} else {
		if ($display == "" && $settings['sitebanner2']) {
			eval("?>".stripslashes($settings['sitebanner2'])."<?php ");
		}
	}
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}

function opentable($title) {

	echo "<div class='capmain'><h2 class='title'>".$title."</h2></div>\n";

	echo "<div class='main-body floatfix spacer'>\n";

}

function closetable() {

	echo "</div>\n";

}

function openside($title, $collapse = false, $state = "on") {

	global $panel_collapse; $panel_collapse = $collapse;
	
	echo "<div class='scapmain floatfix clearfix'>\n";
	echo "<div class='flleft'><h2 class='title'>".$title."</h2></div>\n";
	if ($collapse == true) {
		$boxname = str_replace(" ", "", $title);
		echo "<div class='flright' style='padding-top: 2px;'>".panelbutton($state, $boxname)."</div>\n";
	}
	echo "</div>\n";

	echo "<div class='side-body floatfix spacer'>\n";
	if ($collapse == true) { echo panelstate($state, $boxname); }

}

function closeside() {

	global $panel_collapse;

	if ($panel_collapse == true) { echo "</div>\n"; }
	echo "</div>\n";

}

?>