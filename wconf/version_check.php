<?php

////////////////////////////////////////////////

// PHPF4You - Mainteance

// File: version_check.php

// Author: Manuel © PHPFusion-4you.de

// File Version: v1.0

////////////////////////////////////////////////



// Bitte lassen Sie den Code unverändert. Nur so können wir gewährleisten das Sie die neusten Update Information erhalten.



define('REMOTE_VERSION', 'http://phpfusion-4you.de/vcheck/mainteance.txt');

define('VERSION', '2.0.4');



$script = file_get_contents(REMOTE_VERSION);

$version = VERSION;

$vcheckon = "1"; // Version Check An 1 | Aus 0



if($vcheckon == "1"){

if($version == $script) {

    echo " <font color='#00FF00'><b>Sie haben die aktuellste Version!</b></font>";

} elseif($version > $script) {

echo " Diese Version wurde Manipuliert! <a href='http://www.phpfusion-4you.de/downloads.php?page_id=276' target='_blank' >Original Download</a>";

}else{

    echo " <font color='#FF0000'><b>Es ist eine neue Version vorhanden!</b></font>";

}

}else{

echo "&nbsp;".$version."&nbsp;";

}

?>