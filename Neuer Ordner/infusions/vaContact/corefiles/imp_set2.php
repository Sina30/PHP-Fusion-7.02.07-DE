<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: imp_set2.php
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

if (isset($_POST['haft_save'])) {

$ha_inhalt = substr(stripinput(trim($_POST['ha_inhalt'])),0,5000);
$ha_verweise = substr(stripinput(trim($_POST['ha_verweise'])),0,5000);
$ha_urheber = substr(stripinput(trim($_POST['ha_urheber'])),0,5000);
$ha_datenschutz = substr(stripinput(trim($_POST['ha_datenschutz'])),0,5000);
$ha_recht = substr(stripinput(trim($_POST['ha_recht'])),0,5000);
$ha_info = substr(stripinput(trim($_POST['ha_info'])),0,5000);

$result = dbquery("UPDATE ".DB_HAFT." SET inhalt = '".$ha_inhalt."', verweise = '".$ha_verweise."', urheber = '".$ha_urheber."', datenschutz = '".$ha_datenschutz."', recht = '".$ha_recht."', info = '".$ha_info."', switch1 = 'Ein', switch2 = 'Ein', switch3 = 'Ein', switch4 = 'Ein', switch5 = 'Ein', switch6 = 'Ein',");
redirect(FUSION_SELF.$aidlink."&section=haftung");	
}

opentable($locale['title_imp2']);

$haft = dbquery("SELECT * FROM ".DB_HAFT."");
while($hdata = dbarray($haft)){
$inhalt = $hdata['inhalt'];
$verweise = $hdata['verweise'];
$urheber = $hdata['urheber'];
$datenschutz = $hdata['datenschutz'];
$recht = $hdata['recht'];
$info = $hdata['info'];
}

echo "<form action='".FUSION_SELF.$aidlink."&section=haftung' method='post'>";
echo "<table align='center' cellspacing='1' cellpadding='1' width='96%'>";

echo "<tr>";
echo "<td align='left' width='15%'>".$locale['disclaim001']."</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left' width='96&'><textarea rows='10' name='ha_inhalt' style='width:100%;' class='textbox'>".$inhalt."</textarea></td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left' width='15%'>".$locale['disclaim002']."</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left' width='96&'><textarea rows='10' name='ha_verweise' style='width:100%;' class='textbox'>".$verweise."</textarea></td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left' width='15%'>".$locale['disclaim003']."</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left' width='96&'><textarea rows='10' name='ha_urheber' style='width:100%;' class='textbox'>".$urheber."</textarea></td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left' width='15%'>".$locale['disclaim004']."</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left' width='96&'><textarea rows='10' name='ha_datenschutz' style='width:100%;' class='textbox'>".$datenschutz."</textarea></td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left' width='15%'>".$locale['imp2_disclaim001']."</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left' width='96&'><textarea rows='10' name='ha_recht' style='width:100%;' class='textbox'>".$recht."</textarea></td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left' width='15%'>".$locale['disclaim006']."</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left' width='96&'><textarea rows='10' name='ha_info' style='width:100%;' class='textbox'>".$info."</textarea></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left'><input type='submit' name='haft_save' value='".$locale['imp014']."' class='button'></td>";
echo "</tr>";

echo "</table></form>";
closetable();

?>
