<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: kon_set2.php
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

opentable($locale['title_kon_set2']);

$log_kontakt = ''.INFUSIONS.'vaContact/logs/kontakt.csv';
if (file_exists($log_kontakt)) {
		
		echo "<table align='center' cellspacing='1' cellpadding='1' border='0' width='100%'>";
		echo "<tr><td align='left'>".$locale['kon_set2-001']."</td></tr>";
		echo "<tr><td align='left'><ul>";
		echo "<li><a href='".INFUSIONS."vaContact/logs/kontakt.csv' target='_blank'>".$locale['kon_set2-002']."</a></li>";
		echo "</ul></td></tr>";
		echo "</table>";
		
} else {

		echo "<table align='center' cellspacing='1' cellpadding='1' border='0' width='100%'>";
		echo "<tr><td align='left'>".$locale['kon_set2-003']."</td></tr>";
		echo "</table>";
}
closetable();

?>