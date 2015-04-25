<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: settings_messages.php
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
require_once "../maincore.php";

if (!checkRights("S7") || !defined("iAUTH") || !isset($_GET['aid']) || $_GET['aid'] != iAUTH) { redirect("../index.php"); }

require_once THEMES."templates/admin_header.php";
include LOCALE.LOCALESET."admin/settings.php";

$count = 0;

if (isset($_GET['error']) && isnum($_GET['error']) && !isset($message)) {
	if ($_GET['error'] == 0) {
		$message = $locale['900'];
	} elseif ($_GET['error'] == 1) {
		$message = $locale['901'];
	}
	if (isset($message)) {
		echo "<div id='close-message'><div class='admin-message'>".$message."</div></div>\n";
	}
}

if (isset($_POST['saveoptions'])) {
	$error = 0;
	dbquery("UPDATE ".DB_MESSAGES_OPTIONS." SET
		pm_email_notify = '".(isnum($_POST['pm_email_notify']) ? $_POST['pm_email_notify'] : 0)."',
		pm_save_sent = '".(isnum($_POST['pm_save_sent']) ? $_POST['pm_save_sent'] : 0)."',
		pm_inbox = '".(isnum($_POST['pm_inbox']) ? $_POST['pm_inbox'] : 0)."',
		pm_sentbox = '".(isnum($_POST['pm_sentbox']) ? $_POST['pm_sentbox'] : 0)."',
		pm_savebox = '".(isnum($_POST['pm_savebox']) ? $_POST['pm_savebox'] : 0)."'
		WHERE user_id='0'"
	);
	if (!$result) { $error = 1; }
	redirect(FUSION_SELF.$aidlink."&error=".$error);
}

$options = dbarray(dbquery("SELECT * FROM ".DB_MESSAGES_OPTIONS." WHERE user_id='0'"), 0);
$pm_inbox = $options['pm_inbox'];
$pm_sentbox = $options['pm_sentbox'];
$pm_savebox = $options['pm_savebox'];

opentable($locale['400']);
echo "<form name='settingsform' method='post' action='".FUSION_SELF.$aidlink."'>\n";
		echo "<table class='tbl-border table table-responsive' border='0' width='100%' align='center'>";
		echo "<td class='tbl' align='center' colspan='2'><strong>".$locale['707']."</strong></tr>";
		echo "<tr><td class='tbl'>".$locale['701']."<br /><span class='small2'>".$locale['704']."</span></br>
		<input type='text' name='pm_inbox' value='".$pm_inbox."' maxlength='4' class='textbox' style='width:40px;' /></td>";
		
		echo "<td class='tbl'>".$locale['702']."<br /><span class='small2'>".$locale['704']."</span></br>
		<input type='text' name='pm_sentbox' value='".$pm_sentbox."' maxlength='4' class='textbox' style='width:40px;' /></br></td></tr>";
		
		echo "<tr><td class='tbl'>".$locale['703']."<br /><span class='small2'>".$locale['704']."</span></br>
		<input type='text' name='pm_savebox' value='".$pm_savebox."' maxlength='4' class='textbox' style='width:40px;' /></td>";
		
		echo "<tr></td>";
		
		echo "<td class='tbl' align='center' colspan='2'><strong>".$locale['708']."</strong></tr>";

		echo "<tr><td class='tbl'>".$locale['709']."</span></br><select name='pm_email_notify' class='textbox'>
		<option value='0'".($options['pm_email_notify'] == "0" ? " selected='selected'" : "").">".$locale['519']."</option>
		<option value='1'".($options['pm_email_notify'] == "1" ? " selected='selected'" : "").">".$locale['518']."</option></select></td>";
		
		echo "<td class='tbl'>".$locale['710']."</br><select name='pm_save_sent' class='textbox'>
		<option value='0'".($options['pm_save_sent'] == "0" ? " selected='selected'" : "").">".$locale['519']."</option>
		<option value='1'".($options['pm_save_sent'] == "1" ? " selected='selected'" : "").">".$locale['518']."</option></select></td></tr>";
		
		echo "</td></tr>";
echo "<td align='center' colspan='2' class='tbl'><span class='small2'>".$locale['711']."</span></td>\n";
		echo "</tr>\n<tr>\n";
		echo "<td align='center' colspan='2' class='tbl'><br />\n";
echo "<input type='submit' name='savesettings' value='".$locale['750']."' class='button' /></td>\n";
echo "</tr>\n</table>\n</form>\n";
closetable();

require_once THEMES."templates/footer.php";
?>
