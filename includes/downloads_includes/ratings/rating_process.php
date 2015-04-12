<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Type:  Ratings Infusion
| Name: Dynamic Star Ratings
| Version: 1.00
| File Name: rating_process.php
| Author: Fangree Productions
| Site: http://www.fangree.co.uk
| Contact: admin@fangree.co.uk
| Developers: Fangree_Craig, Keddy & SiteMaster
+--------------------------------------------------------+
| Dynamic Star Rating Redux
| Developed by Jordan Boesch
| www.boedesign.com
| Licensed under Creative Commons - http://creativecommons.org/licenses/by-nc-nd/2.5/ca/
| Used CSS from komodomedia.com.
--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/

require_once "../../../maincore.php";

header("Cache-Control: no-cache");
header("Pragma: nocache");



// IF JAVASCRIPT IS ENABLED
 if (isset($_POST['rating']) && $_POST['rating'] !=="" && !isset($_GET['id']) || !isnum($_GET['id']) && isset($_GET['rtype']) && $_GET['rtype']="D") {
	$id = stripinput($_POST['id']);
	$rating = (int) stripinput($_POST['rating']);
	$rtype = stripinput($_POST['rtype']);
	
	if($rating <= 5 && $rating >= 1) {
		if (dbarray(dbquery("SELECT * FROM ".DB_RATINGS." WHERE rating_item_id='".$id."' AND rating_type='".$rtype."' AND rating_ip='".USER_IP."' AND rating_user = '".$userdata['user_id']."'"))) {
			echo 'already_voted'; exit;
		} else {
			$result = dbquery("INSERT INTO ".DB_RATINGS." (rating_item_id, rating_type, rating_user, rating_vote, rating_datestamp, rating_ip) VALUES ('$id', '".$rtype."', '".$userdata['user_id']."', '".$rating."', '".time()."', '".USER_IP."')");
			
			$total = 0;
			$rows = 0;
			
			$sel = dbquery("SELECT rating_vote FROM ".DB_RATINGS." WHERE rating_item_id = '$id' AND rating_type = '".$rtype."'");
			
			if(dbrows($sel) != 0) {
				while($data = dbarray($sel)){
					$total = $total + $data['rating_vote'];
					$rows++;
				}
				
				$perc = ($total/$rows) * 20;
				echo round($perc,2); exit;
			} else {
				return '0'; exit;
			}
		}
	}
}

// IF JAVASCRIPT IS DISABLED
if (isset($_GET['rating']) && $_GET['rating'] !=="" && !isset($_GET['id']) || !isnum($_GET['id']) && isset($_GET['rtype']) && $_GET['rtype']="D") {

	$id = stripinput(isnum($_GET['id']));
	$rating = (int) stripinput($_GET['rating']);
	$rtype = stripinput($_GET['rtype']);
	
	if($rating <= 5 && $rating >= 1){
		if (dbarray(dbquery("SELECT rating_item_id FROM ".DB_RATINGS." WHERE rating_item_id='".$id."' AND rating_type='".$rtype."' AND rating_ip='".USER_IP."' AND rating_user = '".$userdata."'"))) {
			echo 'already_voted'; exit;
		} else {
			$result = dbquery("INSERT INTO ".DB_RATINGS." (rating_item_id, rating_type, rating_user, rating_vote, rating_datestamp, rating_ip) VALUES ('$id', '".$rtype."', '".$userdata."', '".$rating."', '".time()."', '".USER_IP."')");
		}
		redirect(FUSION_SELF); die;
	} else {
		echo 'You cannot rate this more than 5 or less than 1 <a href="'.FUSION_SELF.'">back</a>';
	}
}
?>