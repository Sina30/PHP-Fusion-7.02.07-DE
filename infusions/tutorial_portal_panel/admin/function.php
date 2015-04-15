<?php
if (!defined("IN_FUSION")) { die("Access Denied"); }
include INFUSIONS."tutorial_portal_panel/infusion_db.php";
function DC_LOGSYS($user, $tid) {
	
$auswahl = dbquery("SELECT * FROM ".DB_FUSION_TUTORIAL_LOGSYS." WHERE tuserid='".$user."' && tdid='".$tid."' LIMIT 1 ");
if (!dbrows($auswahl)) {
$schreiben = dbquery("INSERT INTO ".DB_FUSION_TUTORIAL_LOGSYS."(tuserid, tdid, tdatum, tdb)	VALUES ('".$user."', '".$tid."', '".time()."', '1') ");
} else {
$update = dbquery("UPDATE ".DB_FUSION_TUTORIAL_LOGSYS." SET tdb = tdb + 1, tdatum = '".time()."' WHERE tuserid ='".$user."' && tdid='".$tid."'  ");
}
}
function DC_DELETESYS($tid){
$result = dbquery("DELETE FROM ".DB_FUSION_TUTORIAL_LOGSYS." WHERE tdid='".$tid."' ");
}

?>