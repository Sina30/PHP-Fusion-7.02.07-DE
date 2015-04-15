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
$version_data = dbarray(dbquery("SELECT inf_version FROM ".DB_INFUSIONS." WHERE inf_folder = 'tutorial_portal_panel'"));	
$version = $version_data['inf_version'];
opentable("Admin-Navigation");
echo "<table class='tbl' border='0' cellpadding='0' cellspacing='0' width='100%'><tr>";
echo "<td align='center' width='20%'><a href='".INFUSIONS."tutorial_portal_panel/admin/translations_admin.php".$aidlink."' class='button'><span style='color:white;font-size:12px;'><b>Administration</b></a></span></td>";
echo "<td align='center' width='20%'><a href='".INFUSIONS."tutorial_portal_panel/admin/translations_settings.php".$aidlink."'class='button'><span style='color:white;font-size:12px;'><b>Einstellungen</b></a></span></td>";
echo "<td align='center' width='20%'><a href='".INFUSIONS."tutorial_portal_panel/admin/translations_cats.php".$aidlink."'class='button'><span style='color:white;font-size:12px;'><b>Kategorien</b></a></span></td>";
echo "<td align='center' width='20%'><a href='".INFUSIONS."tutorial_portal_panel/admin/translations_logsys.php".$aidlink."'class='button'><span style='color:white;font-size:12px;'><b>Log-System</b></a></span></td>";
echo "</tr></table>";
echo "<div style='text-align: right;'><a href='http://fusion-mods.de' target='_blank' title='".$locale['translation_desc']." ".showdate("%Y",time())."'><span class='small'>&copy;</span></a></div>";
closetable();
?>