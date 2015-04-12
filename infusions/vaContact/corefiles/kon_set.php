<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: kon_set.php
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

if (isset($_GET['kon_del']) && isnum($_GET['kon_del'])) {
	$result = dbquery("DELETE FROM ".DB_KON." WHERE konid='".$_GET['kontakt_delete']."'");
} else if (isset($_POST['kontakt_save'])) {
$error = "";
$anliegen = substr(stripinput(trim($_POST['anliegen'])),0,500);

if ($anliegen == "") { $error .= "· <span class='alt'>".$locale['kon_set001']."</span><br>\n"; }

if ($error != "") {

opentable($locale['title_kon_set1']);
echo "<center>".$locale['kon_set002']."<br><br>$error<br><br></center>";
closetable();
redirect(FUSION_SELF.$aidlink."&section=kontakt");	
} else {

$result = dbquery("INSERT INTO ".DB_KON." SET anliegen = '".$anliegen."'");
redirect(FUSION_SELF.$aidlink."&section=kontakt");	
}
}
opentable($locale['title2_kon_set1']);
echo "<form action='".FUSION_SELF.$aidlink."&section=kontakt' method='post'>";
echo "<table align='center' cellspacing='1' cellpadding='1' width='100%'>
		<tr><td align='left' width='10%' valign='top'>".$locale['kon_set003']."</td>
			<td align='left' width='40%'><input type='text' name='anliegen' class='textbox' style='width:200px'></td>
		  	<td align='left' width='10%'><input type='submit' name='kontakt_save' class='button' value='".$locale['imp014']."'></td>
		</tr>
	  	</form>

		<tr><td colspan='3' style='border-bottom:1px solid #000;'>&nbsp;</td></tr>

		<tr>
		<td width='60%' colspan='2' class='tbl2' valign='top'>".$locale['kon_set004']."</td>
        <td width='10%'class='tbl2' valign='top'>".$locale['kon_set005']."</td>
		</tr>";
				  
		$result = dbquery("SELECT * FROM ".DB_KON."");
		while ($data = dbarray($result)) {
		
		echo "<tr>
		<td colspan='2' valign='top'>".$data['anliegen']."</td>
		<td valign='top' align='left'><a href='".FUSION_SELF.$aidlink."&section=kontakt&kon_del=".$data['konid']."'><img src='".INFUSIONS."vaContact/images/delete.png' border='0'></a></td>
		</tr>";
		}
		
echo "</table>";
closetable();
?>