<?php 
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: maintenance.php
| Author: Nick Jones (Digitanium)
+--------------------------------------------------------+
| Modified by PHPFusion-4you.de
| Author: Manuel Wensierski (Manuel)
| Kontakt und Support: http://PHPFusion-4you.de
| Version: 2.0.4
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once  "maincore.php";

define("WCONF", BASEDIR."wconf/");

require_once WCONF."status_conf.php";
require_once WCONF."color_conf.php";
include THEME."theme.php";

$conf['version'] = "PHPF4You - Maintenance v2.0.4";

if (!$settings['maintenance']) { redirect("index.php"); }
if (iMEMBER) { redirect("index.php");
}else{
if(isset($_GET['admin'])){
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>\n";
echo "<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='".$locale['xml_lang']."' lang='".$locale['xml_lang']."'>\n";
echo "<!--[if lt IE 7 ]><html class='ie ie6' lang='en'> <![endif]-->\n";
echo "<!--[if IE 7 ]><html class='ie ie7' lang='en'> <![endif]-->\n";
echo "<!--[if IE 8 ]><html class='ie ie8' lang='en'> <![endif]-->\n";
echo "<!--[if (gte IE 9)|!(IE)]><!--> 	<html lang='en'> <!--<![endif]-->\n";
echo "<head>\n";
echo "<title>".$settings['sitename']."</title>\n";
echo "<meta http-equiv='Content-Type' content='text/html; charset=".$locale['charset']."' />\n";
echo "<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><!-- Force Latest IE rendering engine -->\n";
echo "<meta name='description' content='".$settings['description']."' />\n";
echo "<meta name='keywords' content='".$settings['keywords']."' />\n";
echo "<!--[if lt IE 9]><script src='http://html5shim.googlecode.com/svn/trunk/html5.js'></script><![endif]-->\n";
echo "<!-- Mobile Specific Metas -->\n";
echo "<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1' />\n";	
echo "<!-- Stylesheets -->\n";
echo "<link rel='stylesheet' href='".BASEDIR."css/base.css'>\n";
echo "<link rel='stylesheet' href='".BASEDIR."css/skeleton.css'>\n";
echo "<link rel='stylesheet' href='".BASEDIR."css/layout.css'>\n";
echo "<link rel='shortcut icon' href='".IMAGES."favicon.ico' type='image/x-icon' />\n";
echo "</head>\n<body>\n";
echo "<div class='notice'>\n";
echo "<p class='warn'>Herzlich Willkommen im Admin Login!</p>\n";
echo "</div>\n";
echo "<div class='container'>\n";
echo "<div class='form-bg'>\n";
if (!iMEMBER) {
echo "<form class='form-1' name='loginform' method='post' action='".FUSION_SELF."'>\n";
echo "<h2>Administrator - Login</h2>\n";
echo "<p><input type='text' name='user_name' placeholder='Benutzername'></p>\n";
echo "<p><input type='password' name='user_pass' placeholder='Passwort'></p>\n";
echo "<button type='submit' name='login'></button>\n";
echo "<form>\n";
}

if (ob_get_length() !== FALSE){
	ob_end_flush();
}

mysql_close($db_connect);

echo "</div>\n";
echo "<p class='forgot'>Powered by <a href='http://www.php-fusion.co.uk'>PHP-Fusion Nick Jones</a> &copy; 2003 - ".date("Y")."<br />".$conf['version']." &copy; <a href='http://www.phpfusion-4you.de/profile.php?lookup=2208' target='_blank'>PHPFusion-4you - Manuel</a><br>Design by Oussama Afellad / Port to Fusion by <a href='http://www.phpfusion-4you.de/profile.php?lookup=2208' target='_blank'>PHPFusion-4you - Manuel</a>";
echo "<br />Version Check:"; 
include WCONF."version_check.php";
echo "</p>\n";
echo "</div><!-- container -->\n";
echo "<!-- JS  -->\n";
echo "<script src='//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.js'></script>\n";
echo "<!-- End Document -->\n";



		
echo "</body>\n</html>\n";
}else{
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>\n";
echo "<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='".$locale['xml_lang']."' lang='".$locale['xml_lang']."'>\n";
echo "<head>\n";
echo "<title>".$settings['sitename']."</title>\n";
echo "<meta http-equiv='Content-Type' content='text/html; charset=".$locale['charset']."' />\n";
echo "<meta name='description' content='".$settings['description']."' />\n";
echo "<meta name='keywords' content='".$settings['keywords']."' />\n";
echo "<link rel='stylesheet' href='".BASEDIR."css/main.css' />\n";
echo "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js'></script>\n";
echo "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js'></script>\n";
echo "<script type='text/javascript' src='http://code.jquery.com/jquery-1.6.4.min.js'></script>\n";
echo "<link rel='stylesheet' href='".BASEDIR."css/status.css' />";
echo "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js'></script>";
echo "<link rel='shortcut icon' href='".IMAGES."favicon.ico' type='image/x-icon' />\n";
echo "</head>\n<body class='tbl2 setuser_body'>\n";
echo "<div class='container'>\n";
echo "<div class='header ".$farbe."'></div>\n";
echo "<div class='content'>\n";
echo "<img src='".IMAGES."logo.png'>\n";
echo "<br>\n";
echo "<br><br><h1>Wartungsarbeiten!</h1>\n";
echo "<div style='clear:both;'></div>\n";
echo "<br>\n";
echo "<b>\n";	
echo stripslashes(nl2br($settings['maintenance_message']))."</b>";
echo "<br /><br />";
echo '   
                    <div class="progress progress-striped">
                      <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: '.$s_conf['percent'].'">
                        <span>'.$s_conf['percent'].'</span>
                      </div>
                    </div>
                  ';
echo "<br />\n";		
echo "Powered by <a href='http://www.php-fusion.co.uk'>PHP-Fusion Nick Jones</a> &copy; 2003 - ".date("Y")."<br />".$conf['version']." &copy; <a href='http://www.phpfusion-4you.de/profile.php?lookup=2208' target='_blank'>PHPFusion-4you - Manuel</a>\n";
echo "<br />Version Check:"; 
include WCONF."version_check.php";
echo "<div class='space24'></div>\n";	
echo "</div>\n";	
echo "<div class='footer'></div>\n";
echo "<div class='bottomBar'>\n";
echo "<div class='followUs clear'>\n";
include WCONF."social_conf.php";
echo "<div class='boxIndent icon'>\n";
echo "<div class='boxIndentLeft'></div>\n";
echo "<div class='boxIndentRight'></div>\n";
echo "<div class='boxIndentMiddle'>\n";
echo "<div class='boxIndentContent'>\n";
echo "<a href='".BASEDIR."maintenance.php?file=admin&amp;admin'><img src='".IMAGES."wartung/admin.png' alt='' title='Admin Login' width='30px' height='30px' /></a>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";			
echo "</body>\n</html>\n";
}
}
?>