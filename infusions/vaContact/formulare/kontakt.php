<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: kontakt.php
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
require_once THEMES."templates/header.php";

include INFUSIONS."vaContact/infusion_db.php";

// Aufruf eigene Sprachdateien
if (file_exists(INFUSIONS."vaContact/locale/".$settings['locale'].".php")) { include INFUSIONS."vaContact/locale/".$settings['locale'].".php"; } else { include INFUSIONS."vaContact/locale/German.php"; }

if (isset($_POST['kontakt_send'])) {
	include_once INCLUDES."securimage/securimage.php";
	$error = "";
	$kon_name = substr(stripinput(trim($_POST['kon_name'])),0, 100);
	$kon_email = substr(stripinput(trim($_POST['kon_email'])),0, 100);
	$kon_anfrage = substr(stripinput(trim($_POST['kon_anfrage'])),0, 100);
	$kon_text = substr(stripinput(trim($_POST['kon_text'])),0, 500);
		if ($kon_name == "") { $error .= "&middot;&nbsp;<span class='alt'>".$locale['2kontakt001']."</span><br>\n"; }
		if ($kon_email == "") { $error .= "&middot;&nbsp;<span class='alt'>".$locale['2kontakt002']."</span><br>\n"; }
		if ($kon_text == "") { $error .= "&middot;&nbsp;<span class='alt'>".$locale['2kontakt003']."</span><br>\n"; }
	$securimage = new Securimage();
	if (!isset($_POST['captcha_code']) || $securimage->check($_POST['captcha_code']) == false) {
		$error .= "&middot;&nbsp;<span class='alt'>".$locale['2kontakt004']."</span><br />\n";
	}
	
if (!$error) {
require_once INCLUDES."sendmail_include.php";
$anlage = "
Name:   ".$kon_name." 

Anliegen: ".$kon_anfrage."

Kontakttext:
".$kon_text."



User IP: ".USER_IP."
";
// -------------		
		if (!sendemail($settings['siteusername'],$settings['siteemail'],$kon_name,$kon_email,$kon_anfrage,$anlage)) {
			$error .= "&middot;&nbsp;".$locale['int_fehler']."</span><br />\n";
		}
	}
if ($error) {
		opentable($locale['title_fehler']);
		echo "<table cellpadding='0' cellspacing='0' class='center' width='96%'>
		<tr>
		<td align='left' class='tbl'>
		<br />\n".$locale['fehler001']."<br /><br />\n<ul>".$error."</ul><br />\n".$locale['fehler001a']."<br />\n";
        echo "<p><a href='".INFUSIONS."vaContact/formulare/impressum.php' target='_self'>".$locale['fehler001b']."</a></p>\n";
		echo "</td></tr></table>";
		closetable();
} else {
		opentable($locale['title_erfolgreich']);
		echo "<table cellpadding='0' cellspacing='0' class='center' width='100%'>
		<tr>
		<td align='left' class='tbl'>
		<br />\n".$locale['antw_001a']."<br /><br />\n".$locale['antw_001b']."<br />\n";
		echo "</td></tr></table>";
		closetable();
		
		$csvzeit = showdate("longdate", time());
		$csvuserip = USER_IP;
		$csvanhang = $csvzeit.";". $kon_name.";". $kon_email.";". $kon_anfrage.";". $kon_text.";". $csvuserip.";"."\n";
		$csv = INFUSIONS."vaContact/logs/kontakt.csv";
		if (file_exists($csv)) {
	     	$fp = fopen($csv,"a");
		} else {
			$string = '"'.$locale['csv_zeit'].'"; "'.$locale['csv_name'].'"; "'.$locale['csv_mail'].'"; "'.$locale['csv_anliegen'].'"; "'.$locale['csv_nachricht'].'"; "'.$locale['csv_ip'].'";'."\n";
			$fp = fopen($csv,"w");
			fwrite($fp, $string);
			}
			fwrite($fp, $csvanhang);
		    fclose($fp);
  		}
} else {



opentable($locale['title_kontakt']);

echo "<form name='userform' method='post' action='".FUSION_SELF."'>\n";
echo "<table cellpadding='0' cellspacing='0' width='96%'>\n";
echo "<tr>
         <td align='left' class='tbl' style='width:30%;'>".$locale['kontakt001']."</td>
         <td align='left' class='tbl'><input type='text' name='kon_name' class='textbox' style='width:100%;'>
	  </tr>
      <tr>	  
	     <td align='left' class='tbl'>".$locale['kontakt002']."</td>	 
		 <td align='left' class='tbl'><input type='text' name='kon_email' class='textbox' style='width:100%;'></td>
	  </tr>
	  <tr>
	     <td align='left' class='tbl'>".$locale['kontakt003']."</td>
	     <td align='left' class='tbl'><select name='kon_anfrage' id='kon_anfrage' style='width:100%;'>";
		    $result = dbquery("SELECT * FROM ".DB_KON."");
			while($data = dbarray($result)){
			echo "<option>".$data['anliegen']."</option>";
			}
echo "</select></td>
      </tr>
	  </tr>
	     <td align='left' class='tbl' valign='top'>".$locale['kontakt004']."</td>
         <td align='left' class='tbl'><textarea style='width:100%;' name='kon_text' rows='10' class='textbox'></textarea></td>
	  </tr>
	  <tr>
	     <td align='left' class='tbl' valign='top'>".$locale['kontakt005']."</td>
         <td align='left' class='tbl'><img id='captcha' src='".INCLUDES."captchas/securimage/securimage_show.php' alt='' align='left' />\n";
            echo "<a href='".INCLUDES."captchas/securimage/securimage_play.php'><img src='".INCLUDES."captchas/securimage/images/audio_icon.gif' alt='' align='top' class='tbl-border' style='margin-bottom:1px' /></a><br />\n";
            echo "<a href='#' onclick=\"document.getElementById('captcha').src = '".INCLUDES."captchas/securimage/securimage_show.php?sid=' + Math.random(); return false\"><img src='".INCLUDES."captchas/securimage/images/refresh.gif' alt='' align='bottom' class='tbl-border' /></a>\n";
   echo "</td>
      </tr>
	  <tr>
	     <td align='left' class='tbl' valign='top'>".$locale['kontakt006']."</td>
         <td align='left' class='tbl' valign='top'><input type='text' name='captcha_code' class='textbox' style='width:50%;' /></td>
      </tr>
	  <tr>
         <td align='left' class='tbl'><b>Ihre IP:</b></td>
		 <td align='left' class='tbl'>".USER_IP."</td>
	  </tr>
	  <tr>
	     <td align='left' class='tbl'></td>
	     <td align='left' class='tbl'><input type='submit' name='kontakt_send' value='".$locale['kontakt007']."' class='button' /></td>
	  </tr>
	  </table></form>\n";

closetable();

}

require_once THEMES."templates/footer.php";
?>
