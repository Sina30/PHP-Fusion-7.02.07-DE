<?php

/*-------------------------------------------------------+

| PHP-Fusion Content Management System

| Copyright  2002 - 2009 Nick Jones

| http://www.php-fusion.co.uk/

+--------------------------------------------------------+

| Filename: proprofile.php

| Author: Hessan Adnani (ProZillaZ)

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

include LOCALE.LOCALESET."admin/adminpro.php";

echo '			<div style="height:164px;width:100%;clear:both;background-image:url('.THEMES.'templates/images/admin/left-avatar-bg.png);background-repeat: repeat-x;margin: 0px;">';				
					echo '<div style="width: auto;margin: 0px 7px 0px 7px;">';		
						echo '<div style="width:100px;float:left">';		
							echo '<br />';	
							echo '<font style="font-size:13px"><b>'.$userdata['user_name'].'</b></font><br /><br />';		
							if (!$userdata['user_avatar']) { echo '<img src="'.THEMES.'templates/images/admin/no-avatar.jpg" class="avatar-effect" />';			
							} else { echo '<img src="'.IMAGES.'avatars/'.$userdata['user_avatar'].'" width="100" height="100" class="avatar-effect" />'; }	
echo '				</div>';	
						echo '<div style="float:right;height:100px;margin-top:40px;line-height:185%">';		
							echo ''.THEME_BULLET.' <a href="'.BASEDIR.'edit_profile.php" class="grey">'.$locale['global_120'].'</a><br />';			
							echo ''.THEME_BULLET.' <a href="'.BASEDIR.'messages.php" class="grey">'.$locale['global_121'].'</a><br />';			
							echo ''.THEME_BULLET.' <a href="'.BASEDIR.'members.php" class="grey">'.$locale['global_122'].'</a><br />';			
							echo ''.THEME_BULLET.' <a href="'.BASEDIR.'" class="grey">'.$locale['global_181'].'</a><br />';		
							echo ''.THEME_BULLET.' <a href="'.FUSION_SELF.'?logout=yes" class="grey"><font color="red">'.$locale['global_124'].'</font></a><br />';	
						echo '</div>';	
					echo '</div>';
				echo '</div>';
?>