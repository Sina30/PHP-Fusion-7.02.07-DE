<?php
if (file_exists(INFUSIONS."video/locale/".$settings['locale'].".php")) {
    include INFUSIONS."video/locale/English.php";
	include INFUSIONS."video/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."video/locale/English.php";
}
?>
