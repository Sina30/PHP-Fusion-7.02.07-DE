<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2014 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Addon Name: PFMUK Downloads Mod
| Filename: downloads_functions.php
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

if (!defined("IN_FUSION")) { die("Access Denied"); }

add_to_head("<link rel='stylesheet' href='".BASEDIR."includes/downloads_includes/downloads_styles.css' type='text/css' />");
	
if(FUSION_SELF =="downloads.php" && isset($_GET['download_id']) && isnum($_GET['download_id'])) {
	add_to_head("<link rel='stylesheet' href='".INCLUDES."jquery/colorbox/colorbox.css' type='text/css' media='screen' />");
	add_to_head("<script type='text/javascript' src='".INCLUDES."jquery/colorbox/jquery.colorbox.js'></script>");
	add_to_head("<script type='text/javascript'>\n
	/* <![CDATA[ */\n
	jQuery(document).ready(function(){
	jQuery('a.tozoom').colorbox({
	width:'95%', height:'95%'
	});
	});\n
	/* ]]>*/\n
	</script>\n");
	add_to_head("<script type='text/javascript'>\n
	/* <![CDATA[ */\n
	jQuery(document).ready(function(){
	jQuery('a.tozoomb').colorbox({
	width:'60%', height:'60%'
	});
	});\n
	/* ]]>*/\n
	</script>\n");
	
	add_to_footer("<script type = 'text/javascript'>
	/*author Philip M. 2010*/
	var timeInSecs;
	var ticker;
	function startTimer(secs){
	timeInSecs = parseInt(secs)-1;
	ticker = setInterval('tick()',1000);   // every second
	}
	function tick() {
	var secs = timeInSecs;
	if (secs>0) {
	timeInSecs--;
	}else {
	clearInterval(ticker); // stop counting at zero
	// startTimer(60);  // remove forward slashes in front of startTimer to repeat if required
	}
	document.getElementById('countdownb').innerHTML = secs;
	}
	</script>");
	
	set_image("facebook",   BASEDIR."includes/downloads_includes/images/share/facebook.png");
	set_image("google+",  BASEDIR."includes/downloads_includes/images/share/google.png");
	set_image("twitter",   BASEDIR."includes/downloads_includes/images/share//twitter.png");
}
	
	//Based on code from theme.php for panels button
	function divbutton($div_state, $bname) {
	$bname = preg_replace("/[^a-zA-Z0-9\s]/", "_", $bname);
	if (isset($_COOKIE["fusion_box_".$bname])) {
	if ($_COOKIE["fusion_box_".$bname] == "none") {
	$div_state = "off";
	} else {
	$div_state = "on";
	}
	}
	return "<img style='float:right; padding-right: 15px;' src='".get_image("panel_".($div_state == "on" ? "off" : "on"))."' id='b_".$bname."' class='panelbutton' alt='' onclick=\"javascript:flipBox('".$bname."')\" />";
	}

	//Based on code from theme.php for panels state
	function div_state($div_state, $bname) {
	$bname = preg_replace("/[^a-zA-Z0-9\s]/", "_", $bname);
	if (isset($_COOKIE["fusion_box_".$bname])) {
	if ($_COOKIE["fusion_box_".$bname] == "none") {
	$div_state = "off";
	} else {
	$div_state = "on";
	}
	}
	return "<div id='box_".$bname."'".($div_state == "off" ? " style='display:none'" : "").">\n";
	}

	//Based on code from theme.php for opentable
	function opendiv($title, $collapse = false, $div_state = "on") {
	global $div_collapse; $div_collapse = $collapse;
	echo "<div class='forum-caption' style='margin-top: 20px; margin-bottom: 5px;'>";
	if ($collapse == true) {
	$boxname = str_replace(" ", "", $title);
	echo "<div class='panelbutton'>".divbutton($div_state,$boxname)."</div>";
	}
	echo $title."</div>\n\n";
	if ($collapse == true) { echo div_state($div_state, $boxname); }
	}

	//Based on code from theme.php for closetable
	function closediv($collapse = false) {
	global $div_collapse;
	if ($div_collapse == true) { echo "</div>\n"; }

	}
	
if(FUSION_SELF =="downloads.php" && isset($_GET['download_id']) && isnum($_GET['download_id'])) {	
function download_license() {
	if (isset($_GET['download_id']) && isnum($_GET['download_id'])) {
		$result = dbquery("SELECT download_license FROM ".DB_DOWNLOADS." WHERE download_id='".$_GET['download_id']."'");
		if (dbrows($result)) {
			while ($data = dbarray($result)) {
				if ($data['download_license'] != "") {
					$license = $data['download_license'];
					$agpl = stripos($license, "AGPL");
					$gnu = stripos($license, "GNU");
					if ($agpl === false && $gnu === false) {
						$license_output = $data['download_license'];
					} else {
						$license_output = "<a href='http://www.fsf.org/licensing/licenses/agpl-3.0.html' target='_blank'>AGPL 3</a>";
					}
				}else{
				$license_output = "---";
				}
			}

		}

	}
		return $license_output;
}


	function download_license_colorbox() {
	include LOCALE.LOCALESET."downloads.php";
	if (isset($_GET['download_id']) && isnum($_GET['download_id'])) {
		$result = dbquery("SELECT download_license FROM ".DB_DOWNLOADS." WHERE download_id='".$_GET['download_id']."'");
		if (dbrows($result)) {
			while ($data = dbarray($result)) {
	if ($data['download_license'] !="") {
			$license = $data['download_license'];
				$agpl = stripos($license, "AGPL");
				$gnu = stripos($license, "GNU");
				if ($agpl === false && $gnu === false) {
				 $license_colorbox_output = "<div class='license-message' style='margin-top: 20px; margin-bottom: 5px;'> ".$locale['429c'].$data['download_license']."<div style='float: right; margin-top: 2px;'>\n</div>\n</div></a>";
				} else {
			      $license_colorbox_output = "<a class='tozoomb' href='".BASEDIR."includes/downloads_includes/agpl.html'><div class='license-message' style='margin-top: 20px; margin-bottom: 5px;'><strong>".$locale['429b']."</strong><div style='float: right; margin-top: 2px;'>\n</div>\n</div></a>";
	}
	}
	}
	}
	}
	 return $license_colorbox_output;
	}
	}

?>