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
require_once INFUSIONS."tutorial_portal_panel/infusion_db.php";
add_to_head ('<link rel="stylesheet" href="'.INFUSIONS.'tutorial_portal_panel/includes/css/add1.css"/>');
echo "<table id='iseqchart'><tr>";
#echo "<table class='tbl2' border='0' cellpadding='0' cellspacing='0' width='100%'><tr>";
echo "<td align='center' valign='top' width='15%' ><a ".(FUSION_SELF == "translations.php" && !isset($_GET['page']) && (!isset($_GET['cat_id']) || !isnum($_GET['cat_id'])) ? "" : "")." href='".TUT."translations.php'>
<span style='color:green;font-size:12px;'><b>".$locale['translation_dn000']."</b></a></span></td>";
echo "<td align='center' valign='top' width='15%'>
<a ".(FUSION_SELF == "translations.php" && (isset($_GET['page']) && $_GET['page'] == "dls") ? "" : "")." href='".TUT."translations.php?page=dls'>
<span style='color:green;font-size:12px;'><b>".$locale['translation_dn001']."</b></a>
</span></td>";
echo "<td align='center' valign='top' width='15%'>
<a ".(FUSION_SELF == "translations.php" && (isset($_GET['page']) && $_GET['page'] == "tor") ? "" : "")." href='".TUT."translations.php?page=tor'>
<span style='color:green;font-size:12px;'><b>".$locale['translation_dn002']."</b></a>
</span></td>";
if (checkrights('TUTP')) { 
echo "<td align='center' valign='top' width='15%'><a href='".TUT_ADMIN."translations_admin.php".$aidlink."'><span style='color:red;font-size:12px;'><b>".$locale['translation_dn005']."</b></a></span></td>";
}
echo "</tr></table>";
echo "<div style='text-align: right;'><a href='http://fusion-mods.de' target='_blank' title='".$locale['translation_desc']." ".showdate("%Y",time())."'><span class='small'>&copy;</span></a></div>";

?>