<?PHP
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: inc_info.php
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

// Aufruf eigene Sprachdateien
if (file_exists(INFUSIONS."vaContact/locale/".$settings['locale'].".php")) { include INFUSIONS."vaContact/locale/".$settings['locale'].".php"; } else { include INFUSIONS."vaContact/locale/German.php"; }

opentable($locale['title_inc']);
echo "<table align='center' cellspacing='0' cellpadding='1' width='100%'>\n";
echo "<tr>\n";

echo "<td align='center' valign='top'>\n";
	echo "&nbsp;".$locale['inc_info']."<br><br>";
echo "</td>";

echo "</tr>\n";

echo "<tr>\n<td align='right' style='padding-right:10px;'><a href='http://coretraxx.nl' target='_blank'>&copy; by CoreTraxx.NL</a></td></tr>\n";
echo "</table>\n";
closetable();
?>