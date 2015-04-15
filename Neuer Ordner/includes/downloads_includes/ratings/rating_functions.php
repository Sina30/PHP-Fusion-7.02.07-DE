<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Type:  Ratings Infusion
| Name: Dynamic Star Ratings
| Version: 1.00
| File Name: rating_functions.php
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

if (!defined("IN_FUSION")) { die("Access Denied"); }

include LOCALE.LOCALESET."ratings.php";

function rating($id, $type) {
global $locale;

$wynik = dbquery("SELECT SUM(rating_vote) FROM ".DB_RATINGS." WHERE rating_item_id='".$id."'");
$info = dbresult($wynik,0);
$num_rating = dbcount("(rating_vote)", DB_RATINGS, "rating_item_id='".$id."'");
$wyn_rating = ($num_rating ? $info / $num_rating : 0);

if ($wyn_rating > 0) {
$text = ceil($wyn_rating)." ".$locale['r136']." <img src='".INCLUDES."downloads_includes/ratings/images/".ceil($wyn_rating).".gif' alt='".$locale['r130'].ceil($wyn_rating)."' title='".$locale['r130'].ceil($wyn_rating)."' style='vertical-align:middle; border: 0;' />\n";
} else {
$text = "0 Ratings";
}

return $text;
}

function getRating($id, $rtype) {
$total = 0;
$rows = 0;

$sel = dbquery("SELECT rating_vote FROM ".DB_RATINGS." WHERE rating_item_id = '$id' AND rating_type = '".$rtype."'");

if(dbrows($sel) != 0){
while($data = dbarray($sel)) {
$total = $total + $data['rating_vote'];
$rows++;
}

$perc = ($total/$rows) * 20;
$newPerc = round($perc,2);
return $newPerc.'%';
} else {
return '0%';
}
return '0%';
}

function outOfFive($id, $rtype) {
$total = 0;
$rows = 0;

$sel = dbquery("SELECT rating_vote FROM ".DB_RATINGS." WHERE rating_item_id = '".$id."' AND rating_type = '".$rtype."'");

if(dbrows($sel) != 0) {
while($data = dbarray($sel)){
$total = $total + $data['rating_vote'];
$rows++;
}

$perc = ($total/$rows);
return round($perc,2);
} else {
return '0';
}
return '0';
}

function getVotes($id, $rtype){
global $locale;

$sel = dbquery("SELECT rating_vote FROM ".DB_RATINGS." WHERE rating_item_id = '$id' AND rating_type = '".$rtype."'");
$rows = dbrows($sel);

if ($rows == 0) {
$votes = "0";
} else if($rows == 1) {
$votes = "1";
} else if($rows > 1 && $rows < 5) {
$votes = $rows;
} else {
$votes = $rows;
}
return $votes;
}

function showstarratings($rtype, $id) {
global $show5, $showPerc, $showVotes, $static, $user, $userdata, $locale;

$show5 = false; $showPerc = false; $showVotes = false; $static = NULL;

opentable($locale['r100']);

add_to_head('<link href="'.INCLUDES.'downloads_includes/ratings/css/rating_style.css" rel="stylesheet" type="text/css" media="all" />');
add_to_head('<script type="text/javascript" src="'.INCLUDES.'downloads_includes/ratings/js/rating_update.js"></script>');

if (iMEMBER) { $user = $userdata['user_id']; } else { $user = "0"; }
$sel = dbarray(dbquery("SELECT * FROM ".DB_RATINGS." WHERE rating_item_id = '".$id."' AND rating_type='".$rtype."' AND rating_user='".$user."'"));
if(iADMIN && checkrights("D")) { 
$user = dbquery("SELECT ra.*, ru.*
FROM ".DB_RATINGS." ra
LEFT JOIN ".DB_USERS." ru ON ra.rating_user=ru.user_id
WHERE rating_item_id = '".$id."' AND rating_type = '".$rtype."' AND rating_user !='".$userdata['user_id']."'
ORDER BY RAND()
ASC ");
}

if(iGUEST || $sel['rating_user'] == $userdata['user_id']) {
echo "<div style='width: 100%; margin: 0 auto 0 auto;  text-align: center;' class='tbl2 center'>\n";
echo "<div class='rated_text' style=>\n
<strong>".$locale['r130']."</strong> \n
</div>\n

<ul class='star-rating2' id='rater_".$id."'>\n
<li class='current-rating' style='width:".getRating($id, $rtype).";' id='ul_".$id."'></li>\n
<li><a onclick='return true;' href='#' title='".outOfFive($id, $rtype)." ".$locale['r683']." 5' class='one-star'>1</a></li>\n
<li><a onclick='return true;' href='#' title='".outOfFive($id, $rtype)." ".$locale['r684']." 5' class='two-stars'>2</a></li>\n
<li><a onclick='return true;' href='#' title='".outOfFive($id, $rtype)." ".$locale['r684']." 5' class='three-stars'>3</a></li>\n
<li><a onclick='return true;' href='#' title='".outOfFive($id, $rtype)." ".$locale['r684']." 5' class='four-stars'>4</a></li>\n
<li><a onclick='return true;' href='#' title='".outOfFive($id, $rtype)." ".$locale['r684']." 5' class='five-stars'>5</a></li>\n
</ul>\n

<strong>".$locale['r135']."</strong><strong>".outOfFive($id, $rtype)."</strong> ".$locale['r136']." <br />(".$locale['r131']." <span id='showvotes_".$id."' class='votesClass'><strong>".getVotes($id, $rtype)."</strong></span>)</div>\n
<div align='center' id='loading_".$id."'></div><br />\n";

if(iADMIN && checkrights("D")) {
$count=1;

echo "<div style='width: 100%;' class='tbl2 center'>\n";


echo"<div style='text-align: center;'><strong>Members Who Rated This</strong><br />";

while ($data_user = dbarray($user)) {



echo ($data_user['rating_user'] == $userdata['user_id'] ? "" : profile_link($data_user['rating_user'], $data_user['user_name'], $data_user['user_status']).", ")."";

if (($count % 7) == 0) { echo"<br />"; } $count++;

}

echo"</div>\n";

echo"</div>\n";
}


if (!iMEMBER) {
echo "<div style='width: 100%; text-align:center;' class='tbl2 center'>".$locale['r104']."</div>\n";
} 

} else {
$show5bool = 'false'; $showPercbool = 'false'; $showVotesbool = 'false';
echo "<div style='width: 100%; margin: 0 auto 0 auto;  text-align: center;' class='tbl2 center'>\n
<div class='rated_text' style=>\n
<strong>".$locale['r130']."</strong>\n
</div>\n
<ul class='star-rating' id='rater_".$id."'>
<li class='current-rating' style='width:".getRating($id, $rtype).";' id='ul_".$id."'></li>
<li><a name='rate' onclick='rate(\"1\",\"".$id."\",".$show5bool.",".$showPercbool.",".$showVotesbool.",\"".$rtype."\",\"".INCLUDES."downloads_includes/ratings/"."\"); return false;' href='".INCLUDES."downloads_includes/ratings/rating_process.php?id=".$id."&amp;rating=1&amp;rtype=".$rtype."&amp;ratedir=".INCLUDES."downloads_includes/ratings/' title='1 ".$locale['r683']." 5' class='one-star'>1</a></li>
<li><a name='rate' onclick='rate(\"2\",\"".$id."\",".$show5bool.",".$showPercbool.",".$showVotesbool.",\"".$rtype."\",\"".INCLUDES."downloads_includes/ratings/"."\"); return false;' href='".INCLUDES."downloads_includes/ratings/rating_process.php?id=".$id."&amp;rating=2&amp;rtype=".$rtype."&amp;ratedir=".INCLUDES."downloads_includes/ratings/' title='2 ".$locale['r684']." 5' class='two-stars'>2</a></li>
<li><a name='rate' onclick='rate(\"3\",\"".$id."\",".$show5bool.",".$showPercbool.",".$showVotesbool.",\"".$rtype."\",\"".INCLUDES."downloads_includes/ratings/"."\"); return false;' href='".INCLUDES."downloads_includes/ratings/rating_process.php?id=".$id."&amp;rating=3&amp;rtype=".$rtype."&amp;ratedir=".INCLUDES."downloads_includes/ratings/' title='3 ".$locale['r684']." 5' class='three-stars'>3</a></li>
<li><a name='rate' onclick='rate(\"4\",\"".$id."\",".$show5bool.",".$showPercbool.",".$showVotesbool.",\"".$rtype."\",\"".INCLUDES."downloads_includes/ratings/"."\"); return false;' href='".INCLUDES."downloads_includes/ratings/rating_process.php?id=".$id."&amp;rating=4&amp;rtype=".$rtype."&amp;ratedir=".INCLUDES."downloads_includes/ratings/' title='4 ".$locale['r684']." 5' class='four-stars'>4</a></li>
<li><a name='rate' onclick='rate(\"5\",\"".$id."\",".$show5bool.",".$showPercbool.",".$showVotesbool.",\"".$rtype."\",\"".INCLUDES."downloads_includes/ratings/"."\"); return false;' href='".INCLUDES."downloads_includes/ratings/rating_process.php?id=".$id."&amp;rating=5&amp;rtype=".$rtype."&amp;ratedir=".INCLUDES."downloads_includes/ratings/' title='5 ".$locale['r684']." 5' class='five-stars'>5</a></li>
</ul>\n
<strong>".$locale['r135']."</strong><strong>".outOfFive($id, $rtype)."</strong> ".$locale['r136']." <br />(".$locale['r131']." <span id='showvotes_".$id."' class='votesClass'><strong>".getVotes($id, $rtype)."</strong></span>)</div>\n
<div align='center' id='loading_".$id."'></div><br />\n";

if (!iMEMBER) {
echo "<div style='text-align:center'>".$locale['r104']."</div>\n";
} 

}
closetable();
}

?>