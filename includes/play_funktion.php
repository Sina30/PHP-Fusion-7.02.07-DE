<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: playfunktion.php
| Author: matze
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }
function playimage2($wert, $height, $width) {
  $img_path = "".IMAGES."pl/";
   $num = "";
  $anzahl = strlen($wert);
 for ($pos=0;$pos<$anzahl;$pos++) {
  $ziffer = substr($wert, $pos, 1);
   if(!preg_match('#\ |\,|\.|\*|\€#is', $ziffer)){
   $num .= "<img src='".$img_path.$ziffer.".gif' height='".$height."' width='".$width."' alt='".$ziffer."'/>";
  } else if(preg_match('#\ |\,|\.|\*|\€#is', $ziffer)){
    if(preg_match('#\,#is', $ziffer)){
    $num .= "<img src='".$img_path."komma.gif' height='".$height."' width='".$width."' alt=','/>";
    } else
    if(preg_match('#\.#is', $ziffer)){
    $num .= "<img src='".$img_path."punkt.gif' height='".$height."' width='".$width."' alt='.'/>";
    } else
    if(preg_match('#\*#is', $ziffer)){
    $num .= "<img src='".$img_path."stern.gif' height='".$height."' width='".$width."' alt='*'/>";
    } else
    if(preg_match('#\€#is', $ziffer)){
    $num .= "<img src='".$img_path."euro.gif' height='".$height."' width='".$width."' alt='€'/>";
    }
   } else {
    $num .= $ziffer;
   }
 }
 return $num;
}
?>
