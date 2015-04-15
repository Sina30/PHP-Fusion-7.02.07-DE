<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: core.php
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

require_once "../../../maincore.php";
require_once THEMES."templates/admin_header.php";

if (!defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect(BASEDIR."index.php"); }

include INFUSIONS."vaContact/infusion_db.php";

// Aufruf eigene Sprachdateien
if (file_exists(INFUSIONS."vaContact/locale/".$settings['locale'].".php")) { include INFUSIONS."vaContact/locale/".$settings['locale'].".php"; } else { include INFUSIONS."vaContact/locale/German.php"; }

if(isset($_GET['section'])) { $section = stripinput($_GET['section']); } else { $section = "info"; }
if (isset($_GET['rowstart']) AND isnum($_GET['rowstart'])) { $rowstart = stripinput($_GET['rowstart']); } else { $rowstart = 0; }

opentable($locale['title_core']);

echo "<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>\n";
	echo "<tr>\n";
	
		echo "<td width='25%' class=".($section == "einstellungen" ? "tbl1" : "tbl2")." align='left'>";
		echo "&middot;&nbsp;<span class='small'>".($section == "einstellungen" ? "Impressum" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=einstellungen'><b>".$locale['title']."</b></a>")."</span></td>";
		
		echo "<td width='25%' class=".($section == "haftung" ? "tbl1" : "tbl2")." align='left'>";
		echo "&middot;&nbsp;<span class='small'>".($section == "haftung" ? "Haftungsausschluss" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=haftung'><b>".$locale['title_disclaim']."</b></a>")."</span></td>";
		
		echo "<td width='25%' class=".($section == "kontakt" ? "tbl1" : "tbl2")." align='left'>\n";
		echo "&middot;&nbsp;<span class='small'>".($section == "kontakt" ? "Kontakt" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=kontakt'><b>".$locale['core_contact']."</b></a>")."</span></td>\n";
		
		echo "<td width='25%' class=".($section == "kon_archiv" ? "tbl1" : "tbl2")." align='left'>\n";
		echo "&middot;&nbsp;<span class='small'>".($section == "kon_archiv" ? "Archiv" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=kon_archiv'><b>".$locale['core_archiv']."</b></a>")."</span></td>\n";
	
	echo "</tr>\n";
echo "</table>\n";

closetable();
tablebreak();

switch($section) {

case "info":
include(INFUSIONS."vaContact/corefiles/inc_info.php");
break;

case "einstellungen":
include(INFUSIONS."vaContact/corefiles/imp_set.php");
break;

case "haftung":
include(INFUSIONS."vaContact/corefiles/imp_set2.php");
break;

case "kontakt":
include(INFUSIONS."vaContact/corefiles/kon_set.php");
break;

case "kon_archiv":
include(INFUSIONS."vaContact/corefiles/kon_set2.php");
break;


}
require_once THEMES."templates/footer.php";
?>