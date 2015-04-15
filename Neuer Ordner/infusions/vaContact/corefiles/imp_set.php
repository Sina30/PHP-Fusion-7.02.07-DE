<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: imp_set.php
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

if (isset($_POST['einst_save'])) {
$ueberschrift = substr(stripinput(trim($_POST['ueberschrift'])),0,500);
$vorname = substr(stripinput(trim($_POST['vorname'])),0,100);
$nachname = substr(stripinput(trim($_POST['nachname'])),0,100);
$anschrift = substr(stripinput(trim($_POST['anschrift'])),0,100);
$plzort = substr(stripinput(trim($_POST['plzort'])),0,100);
$telefon = substr(stripinput(trim($_POST['telefon'])),0,100);
$tel_info = substr(stripinput(trim($_POST['tel_info'])),0,100);
$fax = substr(stripinput(trim($_POST['fax'])),0,100);
$fax_info = substr(stripinput(trim($_POST['fax_info'])),0,100);
$email = substr(stripinput(trim($_POST['email'])),0,100);
$kontakt = substr(stripinput(trim($_POST['kontakt'])),0,100);
$haftung = substr(stripinput(trim($_POST['haftung'])),0,100);

$result = dbquery("UPDATE ".DB_IMP." SET ueberschrift = '".$ueberschrift."', vorname = '".$vorname."', nachname = '".$nachname."', anschrift = '".$anschrift."', plzort = '".$plzort."', telefon = '".$telefon."', tel_info = '".$tel_info."', fax = '".$fax."', fax_info = '".$fax_info."', email = '".$email."', switch1 = '".$kontakt."', switch2 = '".$haftung."'");
redirect(FUSION_SELF.$aidlink."&section=einstellungen");	
}

opentable($locale['title_imp']);

$impressum = dbquery("SELECT * FROM ".DB_IMP."");
while ($data = dbarray($impressum)) {

echo "<form action='".FUSION_SELF.$aidlink."&section=einstellungen' method='post'>";
echo "<table align='center' cellspacing='2' cellpadding='3' width='100%'>";
echo "<tr>";
echo "<td align='left' width='15%'>".$locale['imp001']."</td>";
echo "<td align='left' width='30&'><input type='text' class='textbox' style='width:400px;' name='ueberschrift' value='".$data['ueberschrift']."'></td>";
echo "</tr>";
echo "<tr><td colspan='2'></td></tr>";
echo "<tr>";
echo "<td align='left' width='15%' valign='top'>".$locale['imp002']."</td>";
echo "<td align='left' width='30%'><input type='text' class='textbox' style='width:200px;' name='vorname' value='".$data['vorname']."'></td>";
echo "</tr><tr>";
echo "<td align='left' width='15%' valign='top'>".$locale['imp003']."</td>";
echo "<td align='left' width='30%'><input type='text' class='textbox' style='width:200px;' name='nachname' value='".$data['nachname']."'></td>";
echo "</tr><tr>";
echo "<td align='left' width='15%' valign='top'>".$locale['imp004']."</td>";
echo "<td align='left' width='30%'><input type='text' class='textbox' style='width:200px;' name='anschrift' value='".$data['anschrift']."'></td>";
echo "</tr><tr>";
echo "<td align='left' width='15%' valign='top'>".$locale['imp005']."</td>";
echo "<td align='left' width='30%'><input type='text' class='textbox' style='width:200px;' name='plzort' value='".$data['plzort']."'></td>";
echo "</tr>";
echo "<tr><td colspan='2'></td></tr>";
echo "<tr>";
echo "<td align='left' width='15%' valign='top'>".$locale['imp006']."</td>";
echo "<td align='left' width='30%'><input type='text' class='textbox' style='width:200px;' name='telefon' value='".$data['telefon']."'></td>";
echo "</tr>";
echo "<tr>";
echo "<td align='left' width='15%' valign='top'>".$locale['imp007']."</td>";
echo "<td align='left' width='30%'><input type='text' class='textbox' style='width:200px;' name='tel_info' value='".$data['tel_info']."'></td>";
echo "</tr>";
echo "<tr>";
echo "<td align='left' width='15%' valign='top'><b>&nbsp;</b></td>";
echo "<td align='left' width='30%'><input type='hidden' class='textbox' style='width:200px;' name='fax_info' value='0'>&nbsp;</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='left' width='15%' valign='top'>".$locale['imp008']."</td>";
echo "<td align='left' width='30%'><input type='text' class='textbox' style='width:200px;' name='fax' value='".$data['fax']."'></td>";
echo "</tr>";
echo "<tr><td colspan='2'></td></tr>";
echo "<tr>";
echo "<td align='left' width='15%' valign='top'>".$locale['imp009']."</td>";
echo "<td align='left' width='30%'><input type='text' class='textbox' style='width:200px;' name='email' value='".$data['email']."'></td>";
echo "</tr><tr>";
echo "<td align='left' width='15%' valign='top'></td>";
echo "<td align='left' width='30%'></td>";
echo "</tr>";
echo "<tr><td colspan='2'></td></tr>";
echo "<tr>";
echo "<td align='left' width='15%' valign='top'>".$locale['imp010']."</td>";
echo "<td align='left' width='30%'><select name='kontakt' id='kontakt' style='width:90px;'>";
		  	if($data['switch1'] == "Ein") {
			echo "<option selected value='Ein'>".$locale['imp011']."</option><option value='Aus'>".$locale['imp012']."</option>";
			} else {
			echo "<option value='Ein'>".$locale['imp011']."</option><option selected value='Aus'>".$locale['imp012']."</option>";
			}
echo "</select></td>";
echo "</tr><tr>";
echo "<td align='left' width='15%' valign='top'>".$locale['imp013']."</td>";
echo "<td align='left' width='30%'><select name='haftung' id='haftung' style='width:90px;'>";
		  	if($data['switch2'] == "Ein") {
			echo "<option selected value='Ein'>".$locale['imp011']."</option><option value='Aus'>".$locale['imp012']."</option>";
			} else {
			echo "<option value='Ein'>".$locale['imp011']."</option><option selected value='Aus'>".$locale['imp012']."</option>";
			}
echo "</select></td>";
echo "</tr>";

echo "<tr>";
echo "<td colspan='2'><input type='submit' name='einst_save' value='".$locale['imp014']."' class='button'></td>";
echo "</tr>";
echo "</table></form>";
}
closetable();

?>
