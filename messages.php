<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: messages.php
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
require_once "maincore.php";
require_once THEMES."templates/header.php";
include LOCALE.LOCALESET."messages.php";

if (!iMEMBER) { redirect("index.php"); }

// ein paar zusätzliche Styles
add_to_head("<style media='screen' type='text/css'><!-- 
    #writeForm { margin-bottom: 15px; }   
    form#writeMessage { padding: 10px; width: 100%; }             
    form#writeMessage p { clear: both; margin: 5px 0; padding-bottom: 0; }       
    #writeMessage .messageTo { position: relative; }      
    form#writeMessage label { float: left; width: 70px; }  
    form#writeMessage input[type='text'] { width: 250px; }       
    form#writeMessage textarea { width: 315px; }     
    form#writeMessage .buttons { margin-left: 70px; text-align: right; width: 323px; }     
    form#writeMessage .bbcodes { margin-left: 70px; text-align: right; width: 333px }                   
 --></style>");

add_to_title($locale['global_200'].$locale['400']);

$msg_settings = dbarray(dbquery("SELECT * FROM ".DB_MESSAGES_OPTIONS." WHERE user_id='0'"));

if (iADMIN  || $userdata['user_id'] == 1) {
	$msg_settings['pm_inbox'] = 0;
	$msg_settings['pm_savebox'] = 0;
	$msg_settings['pm_sentbox'] = 0;
}

if (!isset($_GET['folder']) || !preg_check("/^(inbox|outbox|archive|options)$/", $_GET['folder'])) { $_GET['folder'] = "inbox"; }
if (isset($_POST['msg_send']) && isnum($_POST['msg_send'])) { $_GET['msg_send'] = $_POST['msg_send']; }
if (isset($_POST['msg_to_group']) && isnum($_POST['msg_to_group'])) { $_GET['msg_to_group'] = $_POST['msg_to_group']; }

$error = ""; $msg_ids = ""; $status = false; $check_count = 0;

if (isset($_POST['check_mark'])) {
	if (is_array($_POST['check_mark']) && count($_POST['check_mark']) > 1) {
		foreach ($_POST['check_mark'] as $thisnum) {
			if (isnum($thisnum)) $msg_ids .= ($msg_ids ? "," : "").$thisnum;
			$check_count++;
		}
	} else {
		if (isnum($_POST['check_mark'][0])) $msg_ids = $_POST['check_mark'][0];
		$check_count = 1;
	}
}

if (isset($_POST['save_options'])) {
	$pm_email_notify = isnum($_POST['pm_email_notify']) ? $_POST['pm_email_notify'] : "0";
	$pm_save_sent = isnum($_POST['pm_save_sent']) ? $_POST['pm_save_sent'] : "0";
	if ($_POST['update_type'] == "insert") {
		$result = dbquery("INSERT INTO ".DB_MESSAGES_OPTIONS." (user_id, pm_email_notify, pm_save_sent, pm_inbox, pm_savebox, pm_sentbox) VALUES ('".$userdata['user_id']."', '$pm_email_notify', '$pm_save_sent', '0', '0', '0')");
	} else {
		$result = dbquery("UPDATE ".DB_MESSAGES_OPTIONS." SET pm_email_notify='$pm_email_notify', pm_save_sent='$pm_save_sent' WHERE user_id='".$userdata['user_id']."'");
	}
	redirect(FUSION_SELF."?folder=options&amp;status=s_opt_ok");
}


if (isset($_GET['msg_id']) && isnum($_GET['msg_id'])) {
	if (isset($_POST['save'])) {
		$archive_total = dbcount("(message_id)", DB_MESSAGES, "message_to='".$userdata['user_id']."' AND message_folder='2'");
		if ($msg_settings['pm_savebox'] == "0" || ($archive_total + 1) <= $msg_settings['pm_savebox']) {
			$result = dbquery("UPDATE ".DB_MESSAGES." SET message_folder='2' WHERE message_id='".$_GET['msg_id']."' AND message_to='".$userdata['user_id']."'");
			$status = "a_save";
		} else {
			$error = "1";
		}
		redirect(FUSION_SELF."?folder=".$_GET['folder'].($error ? "&amp;status=error_".($error+1) : "").($status && !$error ? "&amp;status=".$status : ""));
		//redirect(FUSION_SELF."?folder=archive".($error ? "&amp;error=$error" : ""));
	} elseif (isset($_POST['unsave'])) {
		$inbox_total = dbcount("(message_id)", DB_MESSAGES, "message_to='".$userdata['user_id']."' AND message_folder='0'");
		if ($msg_settings['pm_inbox'] == "0" || ($inbox_total + 1) <= $msg_settings['pm_inbox']) {
			$result = dbquery("UPDATE ".DB_MESSAGES." SET message_folder='0' WHERE message_id='".$_GET['msg_id']."' AND message_to='".$userdata['user_id']."'");
			$status = "a_unsave";
		} else {
			$error = "1";
		}
		redirect(FUSION_SELF."?folder=".$_GET['folder'].($error ? "&amp;status=error_".($error+1) : "").($status && !$error ? "&amp;status=".$status : ""));
        //redirect(FUSION_SELF."?folder=archive".($error ? "&error=$error" : ""));
	} elseif (isset($_POST['delete'])) {
		$result = dbquery("DELETE FROM ".DB_MESSAGES." WHERE message_id='".$_GET['msg_id']."' AND message_to='".$userdata['user_id']."'");
		redirect(FUSION_SELF."?folder=".$_GET['folder']."&amp;status=delete_s");
	} elseif (isset($_GET['action']) && $_GET['action'] == "delete") {
        $result = dbquery("DELETE FROM ".DB_MESSAGES." WHERE message_id='".$_GET['msg_id']."' AND message_to='".$userdata['user_id']."'");
        redirect(FUSION_SELF."?folder=".$_GET['folder']."&amp;status=delete_s");
    }	
}

if ($msg_ids && $check_count > 0) {
    if (isset($_POST['save_msg'])) {
		$archive_total = dbcount("(message_id)", DB_MESSAGES, "message_to='".$userdata['user_id']."' AND message_folder='2'");
		if ($msg_settings['pm_savebox'] == "0" || ($archive_total + $check_count) <= $msg_settings['pm_savebox']) {
			$result = dbquery("UPDATE ".DB_MESSAGES." SET message_folder='2' WHERE message_id IN(".$msg_ids.") AND message_to='".$userdata['user_id']."'");
			$status = "a_save";
		} else {
			$error = "1";
		}
	} elseif (isset($_POST['unsave_msg'])) {
		$inbox_total = dbcount("(message_id)", DB_MESSAGES, "message_to='".$userdata['user_id']."' AND message_folder='0'");
		if ($msg_settings['pm_inbox'] == "0" || ($inbox_total + $check_count) <= $msg_settings['pm_inbox']) {
			$result = dbquery("UPDATE ".DB_MESSAGES." SET message_folder='0' WHERE message_id IN(".$msg_ids.") AND message_to='".$userdata['user_id']."'");
			$status = "a_unsave";
		} else {
			$error = "1";
		}
	} elseif (isset($_POST['read_msg'])) {
		$result = dbquery("UPDATE ".DB_MESSAGES." SET message_read='1' WHERE message_id IN(".$msg_ids.") AND message_to='".$userdata['user_id']."'");
		$status = "read_ok";
	} elseif (isset($_POST['unread_msg'])) {
		$result = dbquery("UPDATE ".DB_MESSAGES." SET message_read='0' WHERE message_id IN(".$msg_ids.") AND message_to='".$userdata['user_id']."'");
		$status = "unread_ok";
	} elseif (isset($_POST['delete_msg'])) {
		$result = dbquery("DELETE FROM ".DB_MESSAGES." WHERE message_id IN(".$msg_ids.") AND message_to='".$userdata['user_id']."'");
		$status = "delete_p";
	}
	redirect(FUSION_SELF."?folder=".$_GET['folder'].($error ? "&amp;status=error_".($error+1) : "").($status && !$error ? "&amp;status=".$status : ""));
}

if (isset($_POST['send_message'])) {
	$result = dbquery("SELECT * FROM ".DB_MESSAGES_OPTIONS." WHERE user_id='".$userdata['user_id']."'");
	if (dbrows($result)) {
		$my_settings = dbarray($result);
	} else {
		$my_settings['pm_save_sent'] = $msg_settings['pm_save_sent'];
		$my_settings['pm_email_notify'] = $msg_settings['pm_email_notify'];
	}
	
	if($_POST['subject'] == "") {
        $subject = $locale['msg_add_10'];
    } else {
        $subject = stripinput(trim($_POST['subject']));
    }	
	
	$message = stripinput(trim($_POST['message']));
	if ($subject == "" || $message == "") { redirect(FUSION_SELF."?folder=inbox"); }
	$smileys = isset($_POST['chk_disablesmileys']) || preg_match("#(\[code\](.*?)\[/code\]|\[geshi=(.*?)\](.*?)\[/geshi\]|\[php\](.*?)\[/php\])#si", $message) ? "n" : "y";
	require_once INCLUDES."sendmail_include.php";
	if (iADMIN && isset($_POST['chk_sendtoall']) && isnum($_POST['msg_to_group'])) {
		$msg_to_group = $_POST['msg_to_group'];
		if ($msg_to_group == "101" || $msg_to_group == "102" || $msg_to_group == "103") {
			$result = dbquery(
				"SELECT u.user_id, u.user_name, u.user_email, mo.pm_email_notify FROM ".DB_USERS." u
				LEFT JOIN ".DB_MESSAGES_OPTIONS." mo USING(user_id)
				WHERE user_level>='".$msg_to_group."' AND user_status='0'"
			);
			if (dbrows($result)) {
				while ($data = dbarray($result)) {
					if ($data['user_id'] != $userdata['user_id']) {
						$result2 = dbquery("INSERT INTO ".DB_MESSAGES." (message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder) VALUES('".$data['user_id']."','".$userdata['user_id']."','".$subject."','".$message."','".$smileys."','0','".time()."','0')");
						$message_content = str_replace("[SUBJECT]", $subject, $locale['626']);
						$message_content = str_replace("[USER]", $userdata['user_name'], $message_content);
						$send_email = isset($data['pm_email_notify']) ? $data['pm_email_notify'] : $msg_settings['pm_email_notify'];
						if ($send_email == "1") { sendemail($data['user_name'], $data['user_email'], $settings['siteusername'], $settings['siteemail'], $locale['625'], $data['user_name'].$message_content); }
					}
				}
			} else {
				redirect(FUSION_SELF."?folder=inbox");
			}
		} else {
			$result = dbquery(
				"SELECT u.user_id, u.user_name, u.user_email, mo.pm_email_notify FROM ".DB_USERS." u
				LEFT JOIN ".DB_MESSAGES_OPTIONS." mo USING(user_id)
				WHERE user_groups REGEXP('^\\\.{$msg_to_group}$|\\\.{$msg_to_group}\\\.|\\\.{$msg_to_group}$') AND user_status='0'"
			);
			if (dbrows($result)) {
				while ($data = dbarray($result)) {
					if ($data['user_id'] != $userdata['user_id']) {
						$result2 = dbquery("INSERT INTO ".DB_MESSAGES." (message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder) VALUES('".$data['user_id']."','".$userdata['user_id']."','".$subject."','".$message."','".$smileys."','0','".time()."','0')");
						$message_content = str_replace("[SUBJECT]", $subject, $locale['626']);
						$message_content = str_replace("[USER]", $userdata['user_name'], $message_content);
						$send_email = isset($data['pm_email_notify']) ? $data['pm_email_notify'] : $msg_settings['pm_email_notify'];
						if ($send_email == "1") { sendemail($data['user_name'], $data['user_email'], $settings['siteusername'], $settings['siteemail'], $locale['625'], $data['user_name'].$message_content); }
					}
				}
			} else {
				redirect(FUSION_SELF."?folder=inbox");
			}
		}
	} elseif (isnum($_GET['msg_send'])) {
		require_once INCLUDES."flood_include.php";
		if (!flood_control("message_datestamp", DB_MESSAGES, "message_from='".$userdata['user_id']."'")) {
			$result = dbquery(
				"SELECT u.user_id, u.user_name, u.user_email, u.user_level, mo.pm_email_notify, s.pm_inbox, COUNT(message_id) as message_count
				FROM ".DB_USERS." u
				LEFT JOIN ".DB_MESSAGES_OPTIONS." mo USING(user_id)
				LEFT JOIN ".DB_MESSAGES_OPTIONS." s ON s.user_id='0'
				LEFT JOIN ".DB_MESSAGES." ON message_to=u.user_id AND message_folder='0'
				WHERE u.user_id='".$_GET['msg_send']."' GROUP BY u.user_id"
			);
			if (dbrows($result)) {
				$data = dbarray($result);
				if ($data['user_id'] != $userdata['user_id']) {
					if ($data['user_id'] == 1 || $data['user_level'] > 101 || $data['pm_inbox'] == "0" || ($data['message_count'] + 1) <= $data['pm_inbox']) {
						$result = dbquery("INSERT INTO ".DB_MESSAGES." (message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder) VALUES('".$data['user_id']."','".$userdata['user_id']."','".$subject."','".$message."','".$smileys."','0','".time()."','0')");
						// Beantwortet eintragen
						if(isset($_POST['reply_id']) && isnum($_POST['reply_id'])) { $result = dbquery("UPDATE ".DB_MESSAGES." SET message_reply='1' WHERE message_id='".$_POST['reply_id']."' AND message_to='".$userdata['user_id']."'"); }                         
                        // Ende
                        $send_email = isset($data['pm_email_notify']) ? $data['pm_email_notify'] : $msg_settings['pm_email_notify'];
						if ($send_email == "1") {
							$message_content = str_replace("[SUBJECT]", $subject, $locale['626']);
							$message_content = str_replace("[USER]", $userdata['user_name'], $message_content);
							sendemail($data['user_name'], $data['user_email'], $settings['siteusername'], $settings['siteemail'], $locale['625'], $data['user_name'].$message_content);
						}
					} else {
						$error = "2";
					}
				}
			} else {
				redirect(FUSION_SELF."?folder=inbox&amp;status=error_4");
			}
		} else {
			redirect(FUSION_SELF."?folder=inbox&amp;status=error_5");
		}
	}
	if (!$error) {
		$cdata = dbarray(dbquery("SELECT COUNT(message_id) AS outbox_count, MIN(message_id) AS last_message FROM ".DB_MESSAGES." WHERE message_to='".$userdata['user_id']."' AND message_folder='1' GROUP BY message_to"));
		if ($my_settings['pm_save_sent']) {
			if ($msg_settings['pm_sentbox'] != "0" && ($cdata['outbox_count'] + 1) > $msg_settings['pm_sentbox']) {
				$result = dbquery("DELETE FROM ".DB_MESSAGES." WHERE message_id='".$cdata['last_message']."' AND message_to='".$userdata['user_id']."'");
			}
			if (isset($_POST['chk_sendtoall']) && isnum($_POST['msg_to_group'])) {
				$outbox_user = $userdata['user_id'];
			} elseif (isset($_GET['msg_send']) && isnum($_GET['msg_send'])) {
				$outbox_user = $_GET['msg_send'];
			} else {
				$outbox_user = "";
			}
			if ($outbox_user && $outbox_user != $userdata['user_id']) { $result = dbquery("INSERT INTO ".DB_MESSAGES." (message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder) VALUES ('".$userdata['user_id']."','".$outbox_user."','".$subject."','".$message."','".$smileys."','1','".time()."','1')"); }
		}
	}
	redirect(FUSION_SELF."?folder=inbox".($error ? "&amp;status=error_".($error+1)."" : "&amp;status=send_ok"));
}

//if (isset($_GET['error'])) {
//	if ($_GET['error'] == "1") {
//		$message = $locale['629'];
//	} elseif ($_GET['error'] == "2") {
//		$message = $locale['628'];
//	} elseif ($_GET['error'] == "noresult") {
//		$message = $locale['482'];
//	} elseif ($_GET['error'] == "flood") {
//		$message = sprintf($locale['487'], $settings['flood_interval']);
//	} else {
//		$message = "";
//	}
//	add_to_title($locale['global_201'].$locale['627']);
//	opentable($locale['627']);
//	echo "<div style='text-align:center'>".$message."</div>\n";
//	closetable();
//}

	/**
	 * Damit der Arme User auch weiß, was nun abgeht die Stati
	 **/
    if(isset($_GET['status'])) {
        $outputMsg = array("message" => "", "positiv" => true);
        switch($_GET['status']) {
            case "s_opt_ok"  : $outputMsg['message'] = $locale['msg_status_01']; break;
            case "a_save"    : $outputMsg['message'] = $locale['msg_status_02']; break;
            case "a_unsave"  : $outputMsg['message'] = $locale['msg_status_03']; break;
            case "delete_s"  : $outputMsg['message'] = $locale['msg_status_04']; break; // Löschen eine Nachricht
            case "read_ok"   : $outputMsg['message'] = $locale['msg_status_05']; break;
            case "unread_ok" : $outputMsg['message'] = $locale['msg_status_06']; break;
            case "delete_p"  : $outputMsg['message'] = $locale['msg_status_07']; break; // löschen mehrere nachrichten
            case "send_ok"   : $outputMsg['message'] = $locale['msg_status_08']; break;
            case "error_1"   : $outputMsg['message'] = $locale['msg_status_09']; $outputMsg['positiv'] = false; break;
            // Standart Errors auch hier mit rein
            case "error_2"   : $outputMsg['message'] = $locale['629']; $outputMsg['positiv'] = false; break; // verschieben error Ordner voll
            case "error_3"   : $outputMsg['message'] = $locale['628']; $outputMsg['positiv'] = false; break; // senden Fail. Posteingang von Empfänger voll
            case "error_4"   : $outputMsg['message'] = $locale['482']; $outputMsg['positiv'] = false; break; // noresult falsche user id
            case "error_5"   :
                $outputMsg['message'] = sprintf($locale['487'], $settings['flood_interval']);
                $outputMsg['positiv'] = false;
                break;// flood
        }
    }
    /**
     * Ende
     **/

if (!isset($_GET['msg_send']) && !isset($_GET['msg_read']) && $_GET['folder'] != "options") {
	if (!isset($_GET['rowstart']) || !isnum($_GET['rowstart'])) { $_GET['rowstart'] = 0; }
	$bdata = dbarray(dbquery(
		"SELECT COUNT(IF(message_folder=0, 1, null)) inbox_total,
		COUNT(IF(message_folder=1, 1, null)) outbox_total, COUNT(IF(message_folder=2, 1, null)) archive_total
		FROM ".DB_MESSAGES." WHERE message_to='".$userdata['user_id']."' GROUP BY message_to"
	));
	$bdata['inbox_total'] = isset($bdata['inbox_total']) ? $bdata['inbox_total'] : "0";
	$bdata['outbox_total'] = isset($bdata['outbox_total']) ? $bdata['outbox_total'] : "0";
	$bdata['archive_total'] = isset($bdata['archive_total']) ? $bdata['archive_total'] : "0";
	if ($_GET['folder'] == "inbox") {
		$total_rows = $bdata['inbox_total'];
		$result = dbquery(
			"SELECT m.message_id, m.message_subject, m.message_read, m.message_datestamp, m.message_reply,
			u.user_id, u.user_name, u.user_status, u.user_avatar
			FROM ".DB_MESSAGES." m
			LEFT JOIN ".DB_USERS." u ON m.message_from=u.user_id
			WHERE message_to='".$userdata['user_id']."' AND message_folder='0'
			ORDER BY message_datestamp DESC LIMIT ".$_GET['rowstart'].",20"
		);
	} elseif ($_GET['folder'] == "outbox") {
		$total_rows = $bdata['outbox_total'];
		$result = dbquery(
			"SELECT m.message_id, m.message_subject, m.message_read, m.message_datestamp, m.message_reply,
			u.user_id, u.user_name, u.user_status, u.user_avatar
			FROM ".DB_MESSAGES." m
			LEFT JOIN ".DB_USERS." u ON m.message_from=u.user_id
			WHERE message_to='".$userdata['user_id']."' AND message_folder='1'
			ORDER BY message_datestamp DESC LIMIT ".$_GET['rowstart'].",20"
		);
	} elseif ($_GET['folder'] == "archive") {
		$total_rows = $bdata['archive_total'];
		$result = dbquery(
			"SELECT m.message_id, m.message_subject, m.message_read, m.message_datestamp, m.message_reply,
			u.user_id, u.user_name, u.user_status, u.user_avatar
			FROM ".DB_MESSAGES." m
			LEFT JOIN ".DB_USERS." u ON m.message_from=u.user_id
			WHERE message_to='".$userdata['user_id']."' AND message_folder='2'
			ORDER BY message_datestamp DESC LIMIT ".$_GET['rowstart'].",20"
		);
	}	

	$folders = array("inbox" => $locale['402'], "outbox" => $locale['403'], "archive" => $locale['404'], "options" => $locale['425']);
	add_to_title($locale['global_201'].$folders[$_GET['folder']]);
	opentable($locale['400']);
	// Neu by SuNflOw1991	
    if (isset($outputMsg) && $outputMsg['message'] != "") echo "<div id='close-message'>\n<div class='admin-message".(!$outputMsg['positiv'] ? " error" : "")."'>".$outputMsg['message']."</div>\n</div>\n";
	
    if (isset($_GET['folder']) && $_GET['folder'] == "inbox") {
		echo "<p>".($bdata['inbox_total'] == 1 ? $locale['msg_add_01_sing'] : $locale['msg_add_01_plur']).$bdata['inbox_total'].($bdata['inbox_total'] == 1 ? $locale['msg_add_02_sing'] : $locale['msg_add_02_plur']).$locale['402'].".</p>";
	} elseif (isset($_GET['folder']) && $_GET['folder'] == "outbox") {
		echo "<p>".($bdata['outbox_total'] == 1 ? $locale['msg_add_01_sing'] : $locale['msg_add_01_plur']).$bdata['outbox_total'].($bdata['outbox_total'] == 1 ? $locale['msg_add_02_sing'] : $locale['msg_add_02_plur']).$locale['403'].".</p>";
	} elseif (isset($_GET['folder']) && $_GET['folder'] == "archive") {
		echo "<p>".($bdata['archive_total'] == 1 ? $locale['msg_add_01_sing'] : $locale['msg_add_01_plur']).$bdata['archive_total'].($bdata['archive_total'] == 1 ? $locale['msg_add_02_sing'] : $locale['msg_add_02_plur']).$locale['404'].".</p>";
	}
    // Ende Neu by SuNflOw1991	
	if ($total_rows) echo "<form name='pm_form' method='post' action='".FUSION_SELF."?folder=".$_GET['folder']."'>\n";
	echo "<table cellpadding='0' cellspacing='0' width='100%'>\n";
	echo "<tr>\n<td align='left' width='100%' class='tbl'>\n";
    // Neuer Button
    echo "<a class='button' href='".FUSION_SELF."?msg_send=0'>".$locale['401']."</a>\n";
    // Ende neuer Button
    echo "</td>\n";
	// Tolle Icons
    echo "<td width='1%' class='tbl' style='white-space:nowrap;font-weight:".($_GET['folder']=="inbox"?"bold":"normal")."'><a href='".FUSION_SELF."?folder=inbox'><img src='".IMAGES."icons/folder_inbox.png' alt='".$locale['402']."' title='".$locale['402']."' /> ".$locale['402']." [".$bdata['inbox_total']."/".($msg_settings['pm_inbox'] != 0 ? $msg_settings['pm_inbox'] : "&infin;")."]</a></td>\n";
	echo "<td width='1%' class='tbl' style='white-space:nowrap;font-weight:".($_GET['folder']=="outbox"?"bold":"normal")."'><a href='".FUSION_SELF."?folder=outbox'><img src='".IMAGES."icons/folder_outbox.png' alt='".$locale['403']."' title='".$locale['403']."' /> ".$locale['403']." [".$bdata['outbox_total']."/".($msg_settings['pm_inbox'] != 0 ? $msg_settings['pm_inbox'] : "&infin;")."]</a></td>\n";
	echo "<td width='1%' class='tbl' style='white-space:nowrap;font-weight:".($_GET['folder']=="archive"?"bold":"normal")."'><a href='".FUSION_SELF."?folder=archive'><img src='".IMAGES."icons/folder_archives.png' alt='".$locale['404']."' title='".$locale['404']."' /> ".$locale['404']." [".$bdata['archive_total']."/".($msg_settings['pm_inbox'] != 0 ? $msg_settings['pm_inbox'] : "&infin;")."]</a></td>\n";
	echo "<td width='1%' class='tbl' style='white-space:nowrap;font-weight:".($_GET['folder']=="options"?"bold":"normal")."'><a href='".FUSION_SELF."?folder=options'><img src='".IMAGES."icons/folder_wrench.png' alt='".$locale['425']."' title='".$locale['425']."' /> ".$locale['425']."</a></td>\n";
	// Ende tolle Icons
    echo "</tr>\n</table>\n";
    if ($total_rows) {
	    // Neues Design
	    echo "<table cellpadding='0' cellspacing='0' width='100%' class='tbl-border'>\n";
        echo "<colgroup>\n<col width='85'>\n<col width='70'>\n<col width='110'>\n<col width='232'>\n<col width='100'>\n<col width='100'>\n</colgroup>\n";
        echo "<tr>\n<td class='tbl2'>".$locale['msg_add_03'].":</td>\n";
        echo "<td class='tbl2' style='white-space:nowrap'>&nbsp;</td>\n";
        echo "<td class='tbl2' style='white-space:nowrap'>Name:</td>\n";
        echo "<td class='tbl2'>".$locale['405'].":</td>\n";
        echo "<td class='tbl2' style='white-space:nowrap'>".$locale['407'].":</td>\n";
        echo "<td class='tbl2'>&nbsp;</td>\n</tr>\n";
        // helpers
        $i = 0; // für die Farben
        while ($data = dbarray($result)) {
            $i % 2 == 0 ? $rowcolor = "tbl1" : $rowcolor = "tbl2";
            $message_subject = $data['message_subject'];
            if($_GET['folder'] == "outbox") {
                $status = $locale['msg_add_04'];
            } else {
                if($data['message_read'] == 0) {
                    $status = "<span style='font-weight: bold;'>".$locale['msg_add_06']."</span>";
                } else {
                    if($data['message_reply'] == 1) {
                        $status = $locale['msg_add_07'];
                    } else {
                        $status = $locale['msg_add_05'];
                    }
                }                
            }
            
            if ($data['user_avatar'] && file_exists(IMAGES."avatars/".$data['user_avatar'])) {
                $ava = "<img class='user-avatar' width='90%' border='0' src='".IMAGES."avatars/".$data['user_avatar']."' />";
            } else {
                $ava = "<img class='user-avatar' width='70px' border='0' src='".IMAGES."avatars/noavatar100.png' />";
            }  
            
            echo "<tr>\n<td class='".$rowcolor."'><input type='checkbox' name='check_mark[]' value='".$data['message_id']."' /> ".$status."</td>\n";
            echo "<td class='".$rowcolor."'>".profile_link($data['user_id'], $ava, $data['user_status'])."</td>\n";
            echo "<td class='".$rowcolor."'>".profile_link($data['user_id'], $data['user_name'], $data['user_status'])."</td>\n"; 
            echo "<td class='".$rowcolor."'><a href='".FUSION_SELF."?folder=".$_GET['folder']."&amp;msg_read=".$data['message_id']."'>".$message_subject."</a></td>\n";
            echo "<td class='".$rowcolor."'>".showdate("longdate", $data['message_datestamp'])."</td>";
            echo "<td class='".$rowcolor."'>\n";            
            echo "<a href='".FUSION_SELF."?folder=".$_GET['folder']."&amp;msg_read=".$data['message_id']."'><img src='".IMAGES."icons/mail_generic.png' /> ".$locale['414']."</a>\n<br />\n"; // Lesen
            if($_GET['folder'] != "outbox" && $_GET['folder'] != "archive") echo "<a href='".FUSION_SELF."?folder=".$_GET['folder']."&amp;msg_send=".$data['user_id']."&amp;msg_id=".$data['message_id']."&amp;reply=1'><img src='".IMAGES."icons/mail_send.png' /> ".$locale['433']."</a>\n<br />\n"; // Antworten
            echo "<a onclick='return ConfirmDelete();' href='".FUSION_SELF."?folder=".$_GET['folder']."&amp;msg_id=".$data['message_id']."&amp;action=delete'><img src='".IMAGES."icons/mail_delete.png' /> ".$locale['416']."</a>\n"; // Löschen                        
            echo "</td>\n</tr>\n";
            $i++;                                              
        }              
        echo "</table>\n";
        // Ende neues Design
		echo "<table cellpadding='0' cellspacing='0' width='100%'>\n";
		echo "<tr>\n<td class='tbl'>";
        echo "<img border='0' src='".IMAGES."arrow_top.gif'>";
        echo "<a href='#' onclick=\"javascript:setChecked('pm_form','check_mark[]',1);return false;\">".$locale['410']."</a> |\n";
		echo "<a href='#' onclick=\"javascript:setChecked('pm_form','check_mark[]',0);return false;\">".$locale['411']."</a></td>\n";
		echo "<td align='right' class='tbl'>".$locale['409']."\n";
		if ($_GET['folder'] == "inbox") { echo "<input type='submit' name='save_msg' value='".$locale['412']."' class='button' />\n"; }
		if ($_GET['folder'] == "archive") { echo "<input type='submit' name='unsave_msg' value='".$locale['413']."' class='button' />\n"; }
		// read und unread Markierung für archive und outbox nicht von nöten!
        if($_GET['folder']== "inbox") {
            echo "<input type='submit' name='read_msg' value='".$locale['414']."' class='button' />\n";
    		echo "<input type='submit' name='unread_msg' value='".$locale['415']."' class='button' />\n";            
        }
        // Ende
		echo "<input type='submit' name='delete_msg' value='".$locale['416']."' class='button' />\n";
		echo "</td>\n</tr>\n</table>\n</form>\n";
	} else {    
    	echo "<div style='text-align:center'><br />".$locale['461']."<br /><br /></div>";
	}
	echo "<script type='text/javascript'>\n";
	echo "/* <![CDATA[ */\n";
    echo "function ConfirmDelete() {\n";
    echo "return confirm('".$locale['msg_add_08']."');\n";
    echo "}\n";	
    echo "function setChecked(frmName,chkName,val) {"."\n";
	echo "dml=document.forms[frmName];"."\n"."len=dml.elements.length;"."\n"."for(i=0;i < len;i++) {"."\n";
	echo "if(dml.elements[i].name == chkName) {"."\n"."dml.elements[i].checked = val;"."\n";
	echo "}\n}\n}\n";
	echo "/* ]]> */\n";
	echo "</script>\n";
	closetable();
	if ($total_rows > 20) echo "<div align='center' style='margin-top:5px;'>\n".makepagenav($_GET['rowstart'], 20, $total_rows, 3, FUSION_SELF."?folder=".$_GET['folder']."&amp;")."\n</div>\n";
} elseif ($_GET['folder'] == "options") {
	$result = dbquery("SELECT * FROM ".DB_MESSAGES_OPTIONS." WHERE user_id='".$userdata['user_id']."'");
	if (dbrows($result)) {
		$my_settings = dbarray($result);
		$update_type = "update";
	} else {
		$options = dbarray(dbquery("SELECT pm_save_sent, pm_email_notify FROM ".DB_MESSAGES_OPTIONS." WHERE user_id='0' LIMIT 1"));
		$my_settings['pm_save_sent'] = $options['pm_save_sent'];
		$my_settings['pm_email_notify'] = $options['pm_email_notify'];
		$update_type = "insert";
	}
	$bdata = dbarray(dbquery(
		"SELECT COUNT(IF(message_folder=0, 1, null)) inbox_total,
		COUNT(IF(message_folder=1, 1, null)) outbox_total, COUNT(IF(message_folder=2, 1, null)) archive_total
		FROM ".DB_MESSAGES." WHERE message_to='".$userdata['user_id']."' GROUP BY message_to"
	));
	$bdata['inbox_total'] = isset($bdata['inbox_total']) ? $bdata['inbox_total'] : "0";
	$bdata['outbox_total'] = isset($bdata['outbox_total']) ? $bdata['outbox_total'] : "0";
	$bdata['archive_total'] = isset($bdata['archive_total']) ? $bdata['archive_total'] : "0";
	$folders = array("inbox" => $locale['402'], "outbox" => $locale['403'], "archive" => $locale['404'], "options" => $locale['425']);
	add_to_title($locale['global_201'].$folders[$_GET['folder']]);
	opentable($locale['400']);
	// User Output
    if (isset($outputMsg) && $outputMsg['message'] != "") echo "<div id='close-message'>\n<div class='admin-message".(!$outputMsg['positiv'] ? " error" : "")."'>".$outputMsg['message']."</div>\n</div>\n";
    	
    echo "<table cellpadding='0' cellspacing='0' width='100%'>\n";
	echo "<tr>\n<td align='left' width='100%' class='tbl'>\n";
    // Neuer Button
    echo "<a class='button' href='".FUSION_SELF."?msg_send=0'>".$locale['401']."</a>\n";
    // Ende neuer Button
    echo "</td>\n";
	// Tolle Icons
    echo "<td width='1%' class='tbl' style='white-space:nowrap;font-weight:".($_GET['folder']=="inbox"?"bold":"normal")."'><a href='".FUSION_SELF."?folder=inbox'><img src='".IMAGES."icons/folder_inbox.png' alt='".$locale['402']."' title='".$locale['402']."' /> ".$locale['402']." [".$bdata['inbox_total']."/".($msg_settings['pm_inbox'] != 0 ? $msg_settings['pm_inbox'] : "&infin;")."]</a></td>\n";
	echo "<td width='1%' class='tbl' style='white-space:nowrap;font-weight:".($_GET['folder']=="outbox"?"bold":"normal")."'><a href='".FUSION_SELF."?folder=outbox'><img src='".IMAGES."icons/folder_outbox.png' alt='".$locale['403']."' title='".$locale['403']."' /> ".$locale['403']." [".$bdata['outbox_total']."/".($msg_settings['pm_inbox'] != 0 ? $msg_settings['pm_inbox'] : "&infin;")."]</a></td>\n";
	echo "<td width='1%' class='tbl' style='white-space:nowrap;font-weight:".($_GET['folder']=="archive"?"bold":"normal")."'><a href='".FUSION_SELF."?folder=archive'><img src='".IMAGES."icons/folder_archives.png' alt='".$locale['404']."' title='".$locale['404']."' /> ".$locale['404']." [".$bdata['archive_total']."/".($msg_settings['pm_inbox'] != 0 ? $msg_settings['pm_inbox'] : "&infin;")."]</a></td>\n";
	echo "<td width='1%' class='tbl' style='white-space:nowrap;font-weight:".($_GET['folder']=="options"?"bold":"normal")."'><a href='".FUSION_SELF."?folder=options'><img src='".IMAGES."icons/folder_wrench.png' alt='".$locale['425']."' title='".$locale['425']."' /> ".$locale['425']."</a></td>\n";
	// Ende tolle Icons
    echo "</tr>\n</table>\n";
	echo "<div style='margin:4px;'></div>\n";
	echo "<form name='options_form' method='post' action='".FUSION_SELF."?folder=options'>\n";
	echo "<table cellpadding='0' cellspacing='1' width='0' class='center'>\n";
	echo "<tr><td class='tbl1' width='60%'>".$locale['621']."</td>\n";
	echo "<td class='tbl1' width='40%'><select name='pm_email_notify' class='textbox'>\n";
	echo "<option value='1'".($my_settings['pm_email_notify'] ? " selected='selected'" : "").">".$locale['631']."</option>\n";
	echo "<option value='0'".(!$my_settings['pm_email_notify'] ? " selected='selected'" : "").">".$locale['632']."</option>\n";
	echo "</select></td></tr>\n";
	echo "<tr><td class='tbl1' width='60%'>".$locale['622']."</td>\n";
	echo "<td class='tbl1' width='40%'><select name='pm_save_sent' class='textbox'>\n";
	echo "<option value='1'".($my_settings['pm_save_sent'] ? " selected='selected'" : "").">".$locale['631']."</option>\n";
	echo "<option value='0'".(!$my_settings['pm_save_sent'] ? " selected='selected'" : "").">".$locale['632']."</option>\n";
	echo "</select></td></tr>\n";
	echo "<tr><td align='center' colspan='2' class='tbl1'><br />\n";
	echo "<input type='hidden' name='update_type' value='$update_type' />\n";
	echo "<input type='submit' name='save_options' value='".$locale['623']."' class='button' /></td>\n</tr>\n";
	echo "</table></form>\n";
	closetable();
} elseif ((isset($_GET['msg_read']) && isnum($_GET['msg_read'])) && ($_GET['folder'] == "inbox" || $_GET['folder'] == "archive" || $_GET['folder'] == "outbox")) {
	/**
	 * neue Abfragen damit der gesamte Schriftverkehr angezeigt werden kann
	 **/
	 
	// Zuerst die Nachricht aus $_GET ($_GET['msg_read'])	
    $result = dbquery("SELECT mb.*, ub.user_id, ub.user_name, ub.user_status
                       FROM ".DB_MESSAGES." mb
                       LEFT JOIN ".DB_USERS." ub
                       ON mb.message_from=ub.user_id
                       WHERE message_id='".$_GET['msg_read']."'
                       AND message_to='".$userdata['user_id']."'");	
	
	if(dbrows($result)) {
        $data = dbarray($result);
        // Dann alle Nachrichten die von User geschickt wurden holen
        $resultAll = dbquery("SELECT m.*, u.user_id, u.user_name, u.user_avatar, u.user_status FROM ".DB_MESSAGES." m
    		                  LEFT JOIN ".DB_USERS." u ON m.message_from=u.user_id
    		                  WHERE message_to='".$userdata['user_id']."' AND message_from='".$data['message_from']."' 
                              AND message_folder".($_GET['folder'] != "archive"  ? "!=2" : "=2")."
                              ORDER BY message_datestamp DESC");
        
        if(dbrows($resultAll)) {
            $update = dbquery("UPDATE ".DB_MESSAGES." SET message_read='1' WHERE message_id='".$data['message_id']."'");            
            add_to_title($locale['global_201'].$locale['431']);
            opentable($locale['431']);
    		// User Output
            if (isset($outputMsg) && $outputMsg['message'] != "") echo "<div id='close-message'>\n<div class='admin-message".(!$outputMsg['positiv'] ? " error" : "")."'>".$outputMsg['message']."</div>\n</div>\n";    		
    		
            echo "<form name='pm_form' method='post' action='".FUSION_SELF."?folder=".$_GET['folder']."&amp;msg_send=".$data['user_id']."&amp;msg_id=".$data['message_id']."&amp;reply=1'>\n";
            echo "<table cellpadding='0' cellspacing='0' width='100%'>\n";
    		echo "<tr>\n<td colspan='2' class='tbl'><a href='".FUSION_SELF."?folder=".$_GET['folder']."'>".$locale['432']."</a></td>\n";
    		echo "<td align='right' class='tbl'>\n";
    		if ($_GET['folder'] == "inbox" && $data['message_folder'] == 0) { echo "<input type='submit' name='reply' value='".$locale['439']."' class='button' />\n"; }
    		if ($_GET['folder'] == "inbox" && $data['message_folder'] == 0) { echo "<input type='submit' name='save' value='".$locale['412']."' class='button' />\n"; }
    		if ($_GET['folder'] == "archive" && $data['message_folder'] == 2) { echo "<input type='submit' name='unsave' value='".$locale['413']."' class='button' />\n"; }
    		echo "<input onclick='return ConfirmDelete();' type='submit' name='delete' value='".$locale['416']."' class='button' />\n";
    		echo "</td>\n</tr>\n</table>\n</form>\n"; 
                       
            while ($dataAll = dbarray($resultAll)) {
                $message_message = $dataAll['message_message'];
                if ($dataAll['message_smileys'] == "y") $message_message = parsesmileys($message_message);
                
                // Avatar
                if ($_GET['folder'] == "outbox") {
                    if ($dataAll['message_folder'] == 1) {
                        if ($dataAll['user_avatar'] && file_exists(IMAGES."avatars/".$dataAll['user_avatar'])) {
                            $ava = "<img width='39px' style='background-color: #FFFFFF;' border='0' src='".IMAGES."avatars/".$dataAll['user_avatar']."' />";                        
                        } else {
                            $ava = "<img width='39px' style='background-color: #FFFFFF;' border='0' src='".IMAGES."avatars/noavatar50.png' />";
                        }
                        $avaLink = profile_link($dataAll['user_id'], $ava, $dataAll['user_status']);
                        $profLink = profile_link($dataAll['user_id'], $dataAll['user_name'], $dataAll['user_status']);                        
                    } else {
                        if ($userdata['user_avatar'] && file_exists(IMAGES."avatars/".$userdata['user_avatar'])) {
                            $ava = "<img width='39px' style='background-color: #FFFFFF;' border='0' src='".IMAGES."avatars/".$userdata['user_avatar']."' />";
                        } else {
                            $ava = "<img width='39px' style='background-color: #FFFFFF;' border='0' src='".IMAGES."avatars/noavatar50.png' />";
                        }
                        $avaLink = profile_link($userdata['user_id'], $ava, $userdata['user_status']);
                        $profLink = profile_link($userdata['user_id'], $userdata['user_name'], $userdata['user_status']);                        
                    }
                } else {
                    if ($dataAll['message_folder'] == 1) {
                        if ($userdata['user_avatar'] && file_exists(IMAGES."avatars/".$userdata['user_avatar'])) {
                            $ava = "<img width='39px' style='background-color: #FFFFFF;' border='0' src='".IMAGES."avatars/".$userdata['user_avatar']."' />";
                        } else {
                            $ava = "<img width='39px' style='background-color: #FFFFFF;' border='0' src='".IMAGES."avatars/noavatar50.png' />";
                        }
                        $avaLink = profile_link($userdata['user_id'], $ava, $userdata['user_status']);
                        $profLink = profile_link($userdata['user_id'], $userdata['user_name'], $userdata['user_status']);                        
                    } else {
                        if ($dataAll['user_avatar'] && file_exists(IMAGES."avatars/".$dataAll['user_avatar'])) {
                            $ava = "<img width='39px' style='background-color: #FFFFFF;' border='0' src='".IMAGES."avatars/".$dataAll['user_avatar']."' />";
                        } else {
                            $ava = "<img width='39px' style='background-color: #FFFFFF;' border='0' src='".IMAGES."avatars/noavatar50.png' />";
                        }
                        $avaLink = profile_link($dataAll['user_id'], $ava, $dataAll['user_status']);
                        $profLink = profile_link($dataAll['user_id'], $dataAll['user_name'], $dataAll['user_status']);                        
                    }
                }
                
                // Ausgabe
                echo "<div style='width: 100%; padding: 10px;".($_GET['msg_read'] != $dataAll['message_id'] ? " opacity: 0.5;" : "")."' class='tbl-border messagediv".($_GET['msg_read'] == $dataAll['message_id'] ? "-active tbl1" : " tbl")."'>";
                echo "<table width='900' align='center'>\n<tr>\n";
                echo "<td width='70' valign='top' rowspan='4'>\n".$avaLink."</td>\n";
                echo "<td width='50' valign='top'>\n".($_GET['folder'] != "outbox" ? "<strong>".$locale['406'].":</strong>" : "<strong>".$locale['421'].":</strong>")."</td>\n";
                echo "<td>\n".$profLink."<br />\n</td>\n</tr>\n";
                echo "<tr>\n";
        		if ($_GET['folder'] != "archive") {
                    echo "<td width='50'>".($_GET['folder'] != "inbox" ? "<strong>".$locale['406'].":</strong>" : "<strong>".$locale['421'].":</strong>")."</td>\n";
                } else {
                    echo "<td width='50'><strong>".$locale['421'].":</strong></td>\n";                    
                }                
                echo "<td>\n";                
                if ($_GET['folder'] == "outbox") {
                    if ($dataAll['message_folder'] == 0) {
                        echo "<b>".profile_link($dataAll['user_id'], $dataAll['user_name'], $dataAll['user_status'])."</b>\n";
                    } else {
                        echo "<b>".profile_link($userdata['user_id'], $userdata['user_name'], $userdata['user_status'])."</b>\n";
                    }
                } else {
                    if (($dataAll['message_folder'] == 0) || ($dataAll['message_folder'] == 2)) {
                        echo "<b>".profile_link($userdata['user_id'], $userdata['user_name'], $userdata['user_status'])."</b>\n";
                    } else {
                        echo "<b>".profile_link($dataAll['user_id'], $dataAll['user_name'], $dataAll['user_status'])."</b>\n";
                    }
                }
        	    echo "</td>\n</tr>\n<tr>\n";
        		echo "<td width='50'><b>".$locale['407'].":</b></td>\n";
        		echo "<td>".showdate("longdate", $dataAll['message_datestamp'])."</td>\n";
        		echo "</tr>\n<tr>\n";
        		echo "<td valign='top' colspan='2'><br>\n";
        		echo "<strong>".$dataAll['message_subject']."</strong><br>\n";
        		echo "<hr align='left' width='250' height='1'>\n";
                echo nl2br(parseubb($message_message));
                echo "</td>\n</tr>\n</table>\n</div><br />\n";                
            }            
            closetable();
        } else {
            redirect(FUSION_SELF);
        }                                               
    } else {
        redirect(FUSION_SELF);    
    }    
	/**
	 * neue Abfragen ENDE
	 **/
	echo "<script type='text/javascript'>\n";
	echo "/* <![CDATA[ */\n";
    echo "function ConfirmDelete() {\n";
    echo "return confirm('".$locale['msg_add_08']."');\n";
    echo "}\n";         
	echo "/* ]]> */\n";
	echo "</script>\n";    
} elseif (isset($_GET['msg_send']) && isnum($_GET['msg_send'])) {
	require_once INCLUDES."bbcode_include.php";
	if (isset($_POST['send_preview'])) {
		$subject = stripinput($_POST['subject']);
		$message = stripinput($_POST['message']);
		$message_preview = $message;
		if (isset($_POST['chk_sendtoall']) && isnum($_POST['msg_to_group'])) {
			$msg_to_group = $_POST['msg_to_group'];
			$sendtoall_chk = " checked='checked'";
			$msg_to_group_state = "";
			$msg_send_state = " disabled";
		} else {
			$msg_to_group = "";
			$sendtoall_chk = "";
			$msg_to_group_state = " disabled";
			$msg_send_state = "";
		}
		$disablesmileys_chk = isset($_POST['chk_disablesmileys']) || preg_match("#(\[code\](.*?)\[/code\]|\[geshi=(.*?)\](.*?)\[/geshi\]|\[php\](.*?)\[/php\])#si", $message_preview) ? " checked='checked'" : "";
		if (!$disablesmileys_chk) $message_preview = parsesmileys($message_preview);
		opentable($locale['438']);		        
        // Neue Ansicht auch für die Vorschau
        if ($_GET['msg_send'] != "0") { $prevData = dbarray(dbquery("SELECT u.user_id, u.user_name, u.user_status FROM ".DB_USERS." u WHERE user_id='".$_GET['msg_send']."'")); }
                
        if ($userdata['user_avatar'] && file_exists(IMAGES."avatars/".$userdata['user_avatar'])) {
            $ava = "<img width='39px' style='background-color: #FFFFFF;' border='0' src='".IMAGES."avatars/".$userdata['user_avatar']."' />";
        } else {
            $ava = "<img width='39px' style='background-color: #FFFFFF;' border='0' src='".IMAGES."avatars/noavatar50.png' />";
        }
        $avaLink = profile_link($userdata['user_id'], $ava, $userdata['user_status']);
        $profLink = profile_link($userdata['user_id'], $userdata['user_name'], $userdata['user_status']);
        
        echo "<div style='width: 100%; padding: 10px;' class='tbl-border messagediv-active tbl1'>";
        echo "<table width='0' align='center'>\n<tr>\n";
        echo "<td width='70' valign='top' rowspan='4'>\n".$avaLink."</td>\n";
        echo "<td width='50' valign='top'>\n<strong>".$locale['406'].":</strong></td>\n";
        echo "<td>\n".$profLink."<br />\n</td>\n</tr>\n<tr>\n";
        echo "<td width='50'><strong>".$locale['421'].":</strong></td>\n";
        echo "<td>\n".profile_link($prevData['user_id'], $prevData['user_name'], $prevData['user_status'])."</td>\n</tr>\n<tr>\n";
        echo "<td width='50'>".$locale['msg_add_09'].":</td>\n";
        echo "<td>".showdate("longdate", time())."</td>\n";
        echo "</tr>\n<tr>\n";
        echo "<td valign='top' colspan='2'><br>\n";
        echo "<strong>".$subject."</strong><br>\n";
        echo "<hr align='left' width='250' height='1'>\n";
        echo nl2br(parseubb($message_preview));
        echo "</td>\n</tr>\n</table>\n</div>\n";				
        // Ende                
		closetable();
	} else {
		$subject = ""; $message = ""; $msg_send_state = ""; $msg_to_group = "";
		$msg_to_group_state = " disabled"; $sendtoall_chk = ""; $disablesmileys_chk = "";
	}

	if (isset($_GET['msg_id']) && isnum($_GET['msg_id'])) {
		$result = dbquery(
			"SELECT m.message_subject, m.message_message, m.message_smileys, u.user_id, u.user_name FROM ".DB_MESSAGES." m
			LEFT JOIN ".DB_USERS." u ON m.message_from=u.user_id
			WHERE message_to='".$userdata['user_id']."' AND message_id='".$_GET['msg_id']."'"
		);
		$data = dbarray($result);
		$_GET['msg_send'] = $data['user_id'];
		if ($subject == "") $subject = (!strstr($data['message_subject'], "RE: ") ? "RE: " : "").$data['message_subject'];
		$reply_message = $data['message_message'];
		if (!$data['message_smileys']) $reply_message = parsesmileys($reply_message);
	} else {
		$reply_message = "";
	}

	if (!isset($_POST['chk_sendtoall']) || $_GET['msg_send'] != "0") {
		$user_list = ""; $user_types = ""; $sel = "";
		$result = dbquery("SELECT user_id, user_name FROM ".DB_USERS." WHERE user_status='0' ORDER BY user_level DESC, user_name ASC");
		while ($data = dbarray($result)) {
			if ($data['user_id'] != $userdata['user_id']) {
				$sel = ($_GET['msg_send'] == $data['user_id'] ? " selected='selected'" : "");
				$user_list .= "<option value='".$data['user_id']."'$sel>".$data['user_name']."</option>\n";
			}
		}
	}

	if (iADMIN && !isset($_GET['msg_id'])) {
		$user_groups = getusergroups();
		while(list($key, $user_group) = each($user_groups)){
			if ($user_group['0'] != "0") {
				$sel = ($msg_to_group == $user_group['0'] ? " selected='selected'" : "");
				$user_types .= "<option value='".$user_group['0']."'$sel>".$user_group['1']."</option>\n";
			}
		}
	}

	add_to_title($locale['global_201'].$locale['420']);
	if ($_GET['msg_send'] != "0") { $udata = dbarray(dbquery("SELECT u.user_id, u.user_name, u.user_status, u.user_avatar FROM ".DB_USERS." u WHERE user_id='".$_GET['msg_send']."'")); }	
    opentable($locale['420']);
    // Neuer Useroutput
    if (isset($outputMsg) && $outputMsg['message'] != "") echo "<div id='close-message'>\n<div class='admin-message".(!$outputMsg['positiv'] ? " error" : "")."'>".$outputMsg['message']."</div>\n</div>\n";    
    echo "<div id='writeForm'>\n";
    echo "<form id='writeMessage' class='tbl-border tbl' name='inputform' method='post' action='".FUSION_SELF."?msg_send=0".(isset($_GET['msg_id']) ? "&amp;msg_id=".$_GET['msg_id'] : "").(isset($_GET['reply']) && $_GET['reply'] == 1 ? "&amp;reply=1" : "&amp;reply=0")."' onsubmit=\"return ValidateForm(this)\">\n";
    if (iADMIN && !isset($_GET['msg_id'])) {
		echo "<p class='messageTo'>\n";        
        echo "<input class='textbox' name='chk_sendtoall' type='checkbox' ".$sendtoall_chk." />\n";
		echo $locale['434'].": <select class='textbox' name='msg_to_group' style='width: 210px;'>\n".$user_types."</select>\n";
		echo "</p>\n<br /><br />\n";
	}
    echo "<p class='messageTo clearfix'>\n";
    echo "<label for='msg_send'>".$locale['421'].":</label>\n";
	if ($_GET['msg_send'] == "0") {
		echo "<select class='textbox' name='msg_send'>\n".$user_list."</select>\n";
	} else {
		echo "<input class='textbox' value='".$udata['user_name']."' type='text' id='sendto' disabled='disabled'>\n";
		echo "<input type='hidden' name='msg_send' value='".$udata['user_id']."' />\n";
        if (isset($_GET['reply']) && $_GET['reply'] == 1) {
			echo "<input type='hidden' name='reply_id' value='".$_GET['msg_id']."' />\n";
		}
	}
    echo "<p class='messageTo clearfix'>\n";
    echo "<label for='subject'>".$locale['405'].":</label>\n";
    echo "<input class='textbox' type='text' value='".$subject."' name='subject' maxlength='100' id='subject'>\n";
    echo "</p>\n<p class='clearfix'>\n";
    echo "<label for='message'>".$locale['422'].":</label>\n";
    echo "<textarea class='textbox' cols='60' rows='11' name='message' id='body'>".$message."</textarea>\n";    
    echo "</p>\n";
    echo "<div class='bbcodes'>\n".display_bbcodes("98%", "message")."</div>\n";
    echo "<p class='buttons'>\n";
    echo "<input type='submit' name='send_preview' value='".$locale['429']."' class='button' />\n";
    echo "<input type='submit' value='".$locale['430']."' name='send_message' class='button'>\n";
    echo "</p>\n</form>\n</div>\n";	
    echo "<a href='".FUSION_SELF."?folder=inbox'>".$locale['435']."</a>\n<br />\n";
    // unten nochmal alle Nachrichten in der Übersicht            
    
    if(isset($udata) && $udata['user_id'] != "") {
        $resultAll = dbquery("SELECT m.*, u.user_id, u.user_name, u.user_avatar, u.user_status FROM ".DB_MESSAGES." m
        		              LEFT JOIN ".DB_USERS." u ON m.message_from=u.user_id
        		              WHERE message_to='".$userdata['user_id']."' AND message_from='".$udata['user_id']."'
                              AND message_folder!=2
                              ORDER BY message_datestamp DESC");
    
        if(dbrows($resultAll)) {
            if(isset($_GET['msg_id']) && isnum($_GET['msg_id']) && $_GET['msg_id'] != 0) { $update = dbquery("UPDATE ".DB_MESSAGES." SET message_read='1' WHERE message_id='".$_GET['msg_id']."'"); }            
            while ($dataAll = dbarray($resultAll)) {
                $message_message = $dataAll['message_message'];
                if ($dataAll['message_smileys'] == "y") $message_message = parsesmileys($message_message);
    
                // Avatar
                if ($_GET['folder'] == "outbox") {
                    if ($dataAll['message_folder'] == 1) {
                        if ($dataAll['user_avatar'] && file_exists(IMAGES."avatars/".$dataAll['user_avatar'])) {
                            $ava = "<img width='39px' style='background-color: #FFFFFF;' border='0' src='".IMAGES."avatars/".$dataAll['user_avatar']."' />";
                        } else {
                            $ava = "<img width='39px' style='background-color: #FFFFFF;' border='0' src='".IMAGES."avatars/noavatar50.png' />";
                        }
                        $avaLink = profile_link($dataAll['user_id'], $ava, $dataAll['user_status']);
                        $profLink = profile_link($dataAll['user_id'], $dataAll['user_name'], $dataAll['user_status']);
                    } else {
                        if ($userdata['user_avatar'] && file_exists(IMAGES."avatars/".$userdata['user_avatar'])) {
                            $ava = "<img width='39px' style='background-color: #FFFFFF;' border='0' src='".IMAGES."avatars/".$userdata['user_avatar']."' />";
                        } else {
                            $ava = "<img width='39px' style='background-color: #FFFFFF;' border='0' src='".IMAGES."avatars/noavatar50.png' />";
                        }
                        $avaLink = profile_link($userdata['user_id'], $ava, $userdata['user_status']);
                        $profLink = profile_link($userdata['user_id'], $userdata['user_name'], $userdata['user_status']);
                    }
                } else {
                    if ($dataAll['message_folder'] == 1) {
                        if ($userdata['user_avatar'] && file_exists(IMAGES."avatars/".$userdata['user_avatar'])) {
                            $ava = "<img width='39px' style='background-color: #FFFFFF;' border='0' src='".IMAGES."avatars/".$userdata['user_avatar']."' />";
                        } else {
                            $ava = "<img width='39px' style='background-color: #FFFFFF;' border='0' src='".IMAGES."avatars/noavatar50.png' />";
                        }
                        $avaLink = profile_link($userdata['user_id'], $ava, $userdata['user_status']);
                        $profLink = profile_link($userdata['user_id'], $userdata['user_name'], $userdata['user_status']);
                    } else {
                        if ($dataAll['user_avatar'] && file_exists(IMAGES."avatars/".$dataAll['user_avatar'])) {
                            $ava = "<img width='39px' style='background-color: #FFFFFF;' border='0' src='".IMAGES."avatars/".$dataAll['user_avatar']."' />";
                        } else {
                            $ava = "<img width='39px' style='background-color: #FFFFFF;' border='0' src='".IMAGES."avatars/noavatar50.png' />";
                        }
                        $avaLink = profile_link($dataAll['user_id'], $ava, $dataAll['user_status']);
                        $profLink = profile_link($dataAll['user_id'], $dataAll['user_name'], $dataAll['user_status']);
                    }
                }
    
                // Ausgabe
                echo "<div style='width: 530px; padding: 10px;".($_GET['msg_id'] != $dataAll['message_id'] ? " opacity: 0.5;" : "")."' class='tbl-border messagediv".($_GET['msg_id'] == $dataAll['message_id'] ? "-active tbl1" : " tbl")."'>";
                echo "<table width='0' align='center'>\n<tr>\n";
                echo "<td width='70' valign='top' rowspan='4'>\n".$avaLink."</td>\n";
                echo "<td width='50' valign='top'>\n".($_GET['folder'] != "outbox" ? "<strong>".$locale['406'].":</strong>" : "<strong>".$locale['421'].":</strong>")."</td>\n";
                echo "<td>\n".$profLink."<br />\n</td>\n</tr>\n";
                echo "<tr>\n";
            	if ($_GET['folder'] != "archive") {
                    echo "<td width='50'>".($_GET['folder'] != "inbox" ? "<strong>".$locale['406'].":</strong>" : "<strong>".$locale['421'].":</strong>")."</td>\n";
                } else {
                    echo "<td width='50'><strong>".$locale['421'].":</strong></td>\n";
                }
                echo "<td>\n";
                if ($_GET['folder'] == "outbox") {
                    if ($dataAll['message_folder'] == 0) {
                        echo profile_link($dataAll['user_id'], $dataAll['user_name'], $dataAll['user_status']);
                    } else {
                        echo profile_link($userdata['user_id'], $userdata['user_name'], $userdata['user_status']);
                    }
                } else {
                    if (($dataAll['message_folder'] == 0) || ($dataAll['message_folder'] == 2)) {
                        echo profile_link($userdata['user_id'], $userdata['user_name'], $userdata['user_status']);
                    } else {
                        echo profile_link($dataAll['user_id'], $dataAll['user_name'], $dataAll['user_status']);
                    }
                }
            	echo "</td>\n</tr>\n<tr>\n";
            	echo "<td width='50'>".$locale['msg_add_09'].":</td>\n";
            	echo "<td>".showdate("longdate", $dataAll['message_datestamp'])."</td>\n";
            	echo "</tr>\n<tr>\n";
            	echo "<td valign='top' colspan='2'><br>\n";
            	echo "<strong>".$dataAll['message_subject']."</strong><br>\n";
            	echo "<hr align='left' width='250' height='1'>\n";
                echo nl2br(parseubb($message_message));
                echo "</td>\n</tr>\n</table>\n</div><br />\n";
            }
        }
    }        
	closetable();
	echo "<script type='text/javascript'>\n";
	echo "/* <![CDATA[ */\n";
	echo "function ValidateForm(frm){\n";
	echo "if (frm.message.value == \"\"){\n";
	echo "alert(\"".$locale['486']."\");return false;}\n";
	echo "}\n";
	echo "/* ]]>*/\n";
	echo "</script>\n";    
} else {
	redirect(FUSION_SELF);
}

require_once THEMES."templates/footer.php";
?>