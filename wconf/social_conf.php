<?php
////////////////////////////////////////////////
// PHPF4You - Mainteance
// File: social_conf.php 
// Author: Manuel © PHPFusion-4you.de
// File Version: v1.0
////////////////////////////////////////////////

// On | Off Settings
$fbon = "1"; // 1 = On | 0 = Off (Facebook)
$ton = "1"; // 1 = On | 0 = Off (Twitter)
$lon = "1"; // 1 = On | 0 = Off (LinkedIn)

// Links Settings
$fblink = "https://www.facebook.com/pages/PHPFusion-4you/216074168425692?fref=ts"; // Facebook Link
$tlink = "http://twitter.com"; // Twitter Link
$llink = "http://linkedin.com"; // LinkedIn Link

// Ab hier bitte nichts mehr ändern.

if($fbon == "1"){
echo "<div class='boxIndent icon'>\n";
echo "<div class='boxIndentLeft'></div>\n";
echo "<div class='boxIndentRight'></div>\n";
echo "<div class='boxIndentMiddle'>\n";
echo "<div class='boxIndentContent'>\n";
echo "<a href='".$fblink."' target='_blank'><img src='".IMAGES."wartung/facebook.png' alt='Facebook - Follow us' title='PHPFusion-4you - Folgen' width='30px' height='30px' /></a>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";
}else{

}

if($ton == "1"){
echo "<div class='boxIndent icon'>\n";
echo "<div class='boxIndentLeft'></div>\n";
echo "<div class='boxIndentRight'></div>\n";
echo "<div class='boxIndentMiddle'>\n";
echo "<div class='boxIndentContent'>\n";
echo "<a href='".$tlink."' target='_blank'><img src='".IMAGES."wartung/twitter.png' alt='' title='' width='30px' height='30px' /></a>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";
}else{

}

if($lon == "1"){
echo "<div class='boxIndent icon'>\n";
echo "<div class='boxIndentLeft'></div>\n";
echo "<div class='boxIndentRight'></div>\n";
echo "<div class='boxIndentMiddle'>\n";
echo "<div class='boxIndentContent'>\n";
echo "<a href='".$llink."' target='_blank'><img src='".IMAGES."wartung/linkedin.png' alt='' title='' width='30px' height='30px' /></a>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";
}else{

}
?>