<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2014 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Name: Quicksign Panel
| Version: 3.00
| File Name: quicksign_panel.php
| Author: PHP-Fusion Mods UK
| Developer: Craig
| Site: http://www.phpfusionmods.co.uk
+--------------------------------------------------------+
| Based on Signin Dropdown Box like Twitter with jQuery Turorial 
| by http://alessioatzeni.com
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

if (file_exists(INFUSIONS."quicksign_panel/locale/".$settings['locale'].".php" )) {
	include INFUSIONS."quicksign_panel/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."quicksign_panel/locale/English.php";
}

include LOCALE.LOCALESET."global.php";

add_to_head("<link rel='stylesheet' href='".INFUSIONS."quicksign_panel/includes/styles.css' type='text/css' media='screen' />");

global $userdata, $settings, $aidlink;

	if (!iMEMBER) {
	
		if (!preg_match('/login.php/i',FUSION_SELF)) {
		$action_url = FUSION_SELF.(FUSION_QUERY ? "?".FUSION_QUERY : "");
		if (isset($_GET['redirect']) && strstr($_GET['redirect'], "/")) {
		$action_url = cleanurl(urldecode($_GET['redirect']));
		}

	echo"<div id='position-fixed-top'>
	<div id='top-bar'>
	<div id='quicksign-container'>";
	echo"<form name='searchform' id='quicksign-search' method='get' action='".BASEDIR."search.php?stype=all' target='_top' onsubmit='return ValidateForm(this);'>
	<input type='hidden' name='stype' value='all' />
	<input autocomplete='off' name='stext' placeholder='".$locale['qsp_002']."' type='text'/>
	</form>";

	echo"<a title='".$locale['qsp_005']."' href='".BASEDIR."index.php'><div class='home' style='float:left;'>&nbsp;</div></a> <a title='".$locale['qsp_006']."'  href='#quicksign-to-the-top'><div class='up' style='float:left;'>&nbsp;</div></a><a title='".$locale['qsp_007']."'  href='#quicksign-to-the-bottom'><div class='down' style='float:left;'>&nbsp;</div></a> 
	<div class='user-data'>
	<script type='text/javascript'>
	var today = new Date();
	var hour = today.getHours();
	if (hour > 17) {document.write('".$locale['qsp_008']."');}
	if (hour >= 6 && hour <= 11) {document.write('".$locale['qsp_009']."');}
	if (hour >= 12 && hour <= 17) {document.write('".$locale['qsp_010']."');}
	if (hour >= 0 && hour < 6) {document.write('".$locale['qsp_009']."');}
	</script> ".$locale['qsp_011']."</div><noscript>
	<div style='padding-top:12px; color:#ff0000; font-weight: 600; font-size:12px;'>".$locale['qsp_012']."</div></noscript>
	<div id='top-navi'>
	<div class='active-linkage'>
	<div id='session'><a id='quicksign-login-link' href='#'><em>".$locale['qsp_001']."</em><strong>".$locale['global_104']."</strong></a></div>
	<div id='quicksign-login-dropdown'>
	<form  class='quicksign-login' name='loginform' method='post' action='".$action_url."'>
	<fieldset class='textboxq'>
	<label class='username'>
	<span>".$locale['global_101']."</span>
	<input id='username' name='user_name' value='' type='text' autocomplete='on'>
	</label>
	<label class='password'>
	<span>".$locale['global_102']."</span>
	<input id='password' name='user_pass' value='' type='password'>
	</label>
	</fieldset>
	<fieldset class='remb'>
	<label class='remember'>
	<input type='checkbox' name='remember_me' value='y' title='".$locale['global_103']."'  />
	<span>".$locale['global_103']."</span>
	</label>
	<input type='submit' name='login' value='".$locale['global_104']."' class='submit button' />
	</fieldset>
	<p>
	<a class='forgot' href='".BASEDIR."lostpassword.php'>".$locale['qsp_004']."</a>
	<br />
	<a class='mobile' href='".BASEDIR."register.php'>".$locale['global_107']."</a>
	</p>
	</form>
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>";
	}
	}else{

	echo"<div id='position-fixed-top'>
	<div id='top-bar'>
	<div id='quicksign-container'>";
	$msg_count = dbcount("(message_id)", DB_MESSAGES, "message_to='".$userdata['user_id']."' AND message_read='0' AND message_folder='0'");
	if (iADMIN && checkrights("SU")) { $subm_count = dbcount("(submit_id)", DB_SUBMISSIONS); }
	
	
	echo"<form name='searchform' id='quicksign-search' method='get' action='".BASEDIR."search.php?stype=all' target='_top' onsubmit='return ValidateForm(this);'>
<input type='hidden' name='stype' value='all' />
		<input autocomplete='off' name='stext' placeholder='".$locale['qsp_002']."' type='text'/>
</form>";

	echo "<a title='".$locale['qsp_005']."' href='".BASEDIR."index.php'><div class='home' style='float:left;'>&nbsp;</div></a> <a title='".$locale['qsp_006']."' href='#quicksign-to-the-top'><div class='up' style='float:left;'>&nbsp;</div></a> <a title='".$locale['qsp_007']."'  href='#quicksign-to-the-bottom'><div class='down' style='float:left;'>&nbsp;</div></a> 
	<div class='user-data'> <script type='text/javascript'>
	var today = new Date();var hour = today.getHours();
	if (hour > 17) {document.write('".$locale['qsp_008']."');}
	if (hour >= 6 && hour <= 11) {document.write('".$locale['qsp_009']."');}
	if (hour >= 12 && hour <= 17) {document.write('".$locale['qsp_010']."');}
	if (hour >= 0 && hour < 6) {document.write('".$locale['qsp_009']."');}
	</script>
	".$userdata['user_name'];
	if ($msg_count >0) {
	echo", <span class='new-msgs'><a href='".BASEDIR."messages.php'>".sprintf($locale['global_125'], $msg_count).($msg_count == 1 ? $locale['global_126'] : $locale['global_127'])."</a></span>";
	}
	if (iADMIN && checkrights("SU")) {
	if ($subm_count) {
	echo ", <span class='new-msgs'><a href='".ADMIN."submissions.php".$aidlink."'>".sprintf($locale['global_125'], $subm_count);
	echo ($subm_count == 1 ? $locale['global_128'] : $locale['global_129'])."</a></span>\n";
	}
	}
	echo"</div>";
	
	echo"<div id='top-navi'>
	<div class='active-linkage'>
	<div id='session'><a id='quicksign-login-link' href='#'><strong>".$locale['qsp_013']."</strong></a></div>
	<div id='quicksign-login-dropdown'>
	<p style='text-align: left;'>";
	echo"<div style='text-align:left; font-size: 10px; color: #fff; float:left; padding-left: 15px;'>".$locale['qsp_014'].": <strong>".$userdata['user_id']."</strong> <br />".$locale['global_101'].": <strong>".$userdata['user_name']."</strong> <br />".$locale['qsp_015'].": <strong>".showdate("shortdate", $userdata['user_joined'])."</strong></div><div style='float:right; padding-right: 15px;'>";
	if ($userdata['user_avatar'] && file_exists(IMAGES."avatars/".$userdata['user_avatar']) && $userdata['user_status']!=6 && $userdata['user_status']!=5) {
	echo "<img class='member-avatar' src='".IMAGES."avatars/".$userdata['user_avatar']."' alt='".$locale['qsp_016']."' />\n";
	} else {
	echo "<img class='member-avatar' src='".IMAGES."avatars/noavatar100.png' alt='".$locale['qsp_017']."' />\n";
	}
	echo"</div>";
	echo"<ul><a href='".BASEDIR."profile.php?lookup=".$userdata['user_id']."' class='side'><li class='your-profile'>".$locale['qsp_003'] ."</li></a>\n
	<a href='".BASEDIR."edit_profile.php' class='side'><li class='edit-proofile'>".$locale['global_120']."</li></a>\n
	<a href='".BASEDIR."messages.php' class='side'><li class='messages'>".$locale['global_121']."</li></a>\n
	<a href='".BASEDIR."members.php' class='side'><li class='members'>".$locale['global_122']."</li></a>\n";
	if (iADMIN && (iUSER_RIGHTS != "" || iUSER_RIGHTS != "C")) {
	echo "<a href='".ADMIN."index.php".$aidlink."' class='side'><li class='administrators'>".$locale['global_123']."</li></a>\n";
	}
	echo "<a href='".BASEDIR."index.php?logout=yes' class='side'><li class='logout'>".$locale['global_124']."</li></a>\n";
	echo"</ul>";
	if ($msg_count) {
	echo "<div style='text-align:center;margin-top:15px;'>\n
	<strong><a href='".BASEDIR."messages.php' class='side'>".sprintf($locale['global_125'], $msg_count);
	echo ($msg_count == 1 ? $locale['global_126'] : $locale['global_127'])."</a></strong>\n
	</div>\n";
	}
	if (iADMIN && checkrights("SU")) {

	if ($subm_count) {
	echo "<div style='text-align:center;margin-top:15px;'>\n
	<strong><a href='".ADMIN."submissions.php".$aidlink."' class='side'>".sprintf($locale['global_125'], $subm_count);
	echo ($subm_count == 1 ? $locale['global_128'] : $locale['global_129'])."</a></strong>\n";
	echo "</div>\n";
	}
	}
	echo"</p>
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>";
	}
	
add_to_footer("<script type='text/javascript'>
		$(document).ready(function () {
		$('.active-linkage').click(function () {
		if ($('#quicksign-login-dropdown').is(':visible')) {
		$('#quicksign-login-dropdown').hide()
		$('#session').removeClass('active');
		} else {
		$('#quicksign-login-dropdown').show()
		$('#session').addClass('active');
		}
		return false;
		});
		$('#quicksign-login-dropdown').click(function(e) {
		e.stopPropagation();
		});
		$(document).click(function() {
		$('#quicksign-login-dropdown').hide();
		$('#session').removeClass('active');
		});
		});     
		</script>
		<script type='text/javascript'>
		jQuery(document).ready(function(){
		jQuery('a[href=#quicksign-to-the-top]').click(function(){
		jQuery('html, body').animate({scrollTop:0}, 'slow');
		return false;
		});
		});
		</script>
		<script type='text/javascript'>
		jQuery(document).ready(function(){
		jQuery('a[href=#quicksign-to-the-bottom]').click(function(){
		jQuery('html, body').animate({scrollTop:$(document).height()}, 'slow');
		return false;
		});
		});
		</script>
		<script type='text/javascript'>
		function ValidateForm(frm) {
		if(frm.stext.value=='') {
		alert('".$locale['qsp_018']."');
		return false;
		}
		if(frm.stext.value.length < 3){
		alert('".$locale['qsp_019']."');
		return false;
		}
		}
</script>");
?>