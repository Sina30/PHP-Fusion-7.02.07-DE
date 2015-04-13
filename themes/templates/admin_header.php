<?php

/*-------------------------------------------------------+

| PHP-Fusion Content Management System

| Copyright (C) 2002 - 2011 Nick Jones

| http://www.php-fusion.co.uk/

+--------------------------------------------------------+

| Filename: admin_header.php

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



define("ADMIN_PANEL", true);



require_once INCLUDES."output_handling_include.php";

require_once INCLUDES."header_includes.php";

require_once THEMES."templates/admin_theme.php";



if ($settings['maintenance'] == "1" && !iADMIN) { redirect(BASEDIR."maintenance.php"); }

if (iMEMBER) { $result = dbquery("UPDATE ".DB_USERS." SET user_lastvisit='".time()."', user_ip='".USER_IP."', user_ip_type='".USER_IP_TYPE."' WHERE user_id='".$userdata['user_id']."'"); }


echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>\n";

echo "<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='".$locale['xml_lang']."' lang='".$locale['xml_lang']."'>\n";

echo "<head>\n<title>".$settings['sitename']."</title>\n";

echo "<meta http-equiv='Content-Type' content='text/html; charset=".$locale['charset']."' />\n";

echo "<link rel='stylesheet' href='".THEMES."templates/styles_admin.css' type='text/css' media='screen' />\n";

if (file_exists(IMAGES."favicon.ico")) { echo "<link rel='shortcut icon' href='".IMAGES."favicon.ico' type='image/x-icon' />\n"; }

if (function_exists("get_head_tags")) { echo get_head_tags(); }

echo "<script type='text/javascript' src='".INCLUDES."jquery/jquery.js'></script>\n";

echo "<script type='text/javascript' src='".INCLUDES."jscript.js'></script>\n";

echo "<script type='text/javascript' src='".INCLUDES."jquery/admin-msg.js'></script>\n";

echo "<script type='text/javascript' src='".INCLUDES."fusionpro/menu.js'></script>\n";

echo "<script type='text/javascript' src='".INCLUDES."fusionpro/jquery.cookie.js'></script>";

echo '<script type="text/javascript" src="'.INCLUDES.'fusionpro/easyTooltip.js"></script>';

echo '<script type="text/javascript">

				$(document).ready(function(){
	
					$("a").easyTooltip();

					$("img").easyTooltip();

				});

			</script>';

echo '<script type="text/javascript">
function setCookie(c_name,value,exdays) {
		var exdate=new Date();
		exdate.setDate(exdate.getDate() + exdays);
		var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
		document.cookie=c_name + "=" + c_value;
	}
</script>';


echo "<script type=\"text/javascript\">
function cookieyaz(id) {
            $(function() {
                var COOKIE_NAME = 'navigation';
				if (id==$.cookie('navigation')) {
                    $.cookie(COOKIE_NAME, '', { path: '/', expires: -1 });
					} else {
					$.cookie(COOKIE_NAME, id, { path: '/', expires: 10 });	
					}
				return false;
                }
				);
	}
</script>";

echo '<script src="'.INCLUDES.'fusionpro/jquery.autocomplete.js" type="text/javascript"></script>';

echo '<script src="'.INCLUDES.'fusionpro/jquery.iphone-switch.js" type="text/javascript"></script>';

echo "</head>\n<body>\n";



require_once THEMES."templates/panels.php";



ob_start();

?>