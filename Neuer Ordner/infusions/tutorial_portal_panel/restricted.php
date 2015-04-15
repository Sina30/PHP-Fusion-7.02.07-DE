<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion.php
| Author: matze
| Lizenz: CCL v1.0
+--------------------------------------------------------*/
require_once "../../maincore.php";
require_once THEMES."templates/header.php";
include INFUSIONS."tutorial_portal_panel/infusion_db.php";
require_once INFUSIONS."tutorial_portal_panel/includes/add.inc.php";
require_once INFUSIONS."tutorial_portal_panel/includes/add.functions.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."tutorial_portal_panel/locale/".$settings['locale'].".php")) {
// Load the locale file matching the current site locale setting.
    include INFUSIONS."tutorial_portal_panel/locale/".$settings['locale'].".php";
} 
	else {
// Load the infusion's default locale file.
    include INFUSIONS."tutorial_portal_panel/locale/German.php";
}
	
	
if((isset($_GET['re'])) && (isset($_GET['pro']) && isnum($_GET['pro']))) {
       $rdata = dbarray(dbquery("SELECT p.tut_name, p.tut_access, p.tut_cat, pc.tut_cat_name, pc.tut_cat_id
	   FROM ".DB_FUSION_TUTORIAL." p
	   LEFT JOIN ".DB_FUSION_TUTORIAL_CATS." pc ON pc.tut_cat_id=p.tut_cat
	   WHERE tut_id='".$_GET['pro']."'"));
}

global $userdata;

opentable("Zugang verweigert!");
if((isset($_GET['re']) && $_GET['re'] == "ndla") && (isset($_GET['pro']) && isnum($_GET['pro']))) {
  echo "<div class='access-denied'>".$locale['translation_e004']."<strong>".$rdata['tut_name']."</strong></div>";
}
closetable();
  
  require_once THEMES . "templates/footer.php";
?>