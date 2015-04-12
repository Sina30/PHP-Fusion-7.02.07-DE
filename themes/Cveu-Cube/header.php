<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2014 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Theme name: Cube
| Theme version: 1.0
| Author: Vlad Fagarasanu (Faga)
| Web: www.cvision.eu
| EMail: office@cvision.eu
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); } ?>

   	<?php global $locale; ?>
	<?php if (file_exists(THEME."locale/".$settings['locale'].".php")) {
		include THEME."locale/".$settings['locale'].".php";
		} else { include THEME."locale/English.php"; } ?>
      
	<?php include THEME.("includes/user-menu.php"); ?>
    
	<div class="header-wrapper">
		<div class="header clearfix floatfix">
			<?php echo showlogo(); ?>
			<?php include THEME.("includes/search.php"); ?>
		</div>
            
		<div class="sub-header clearfix floatfix">
			<div class="main-nav-wrapper clearfix floatfix">
				<div class="main-nav"><?php echo showsublinks("",""); ?></div>
			</div>
            
            <?php //DISPLAY WELCOME MESSAGE FROM ADMIN MAIN SETTINGS ?>
			<?php if (FUSION_SELF == "".$settings['opening_page'].""): ?>
                <div class="welcome-msg clearfix floatfix">
               		<?php echo stripslashes($settings['siteintro']); ?>
                </div>
            
            <?php //DISPLAY MESSAGE IN ADMIN PANEL ?>   
			<?php elseif (preg_match("#^/administration/#i", TRUE_PHP_SELF)): ?>
            	<div class="welcome-msg clearfix floatfix">
               		<?php echo $locale['cube_0004']; ?>
                </div>  
            
			<?php //DISPLAY MESSAGE IN ADMIN PANEL ?>   
			<?php elseif (preg_match("#^/downloads/#i", TRUE_PHP_SELF)): ?>
            	<div class="welcome-msg clearfix floatfix">
               		<?php include THEME.("includes/downloads.php"); ?>
                </div> 
			
			<?php //DISPLAY MESSAGE IN ADMIN PANEL ?>   
			<?php elseif (preg_match("#^/weblinks/#i", TRUE_PHP_SELF)): ?>
            	<div class="welcome-msg clearfix floatfix">
               		<?php include THEME.("includes/weblinks.php"); ?>
                </div> 
			
			<?php //DISPLAY MESSAGE IN ADMIN PANEL ?>   
			<?php elseif (preg_match("#^/articles/#i", TRUE_PHP_SELF)): ?>
            	<div class="welcome-msg clearfix floatfix">
               		<?php include THEME.("includes/artikel.php"); ?>
                </div> 
			
			<?php //DISPLAY MESSAGE IN ADMIN PANEL ?>   
			<?php elseif (preg_match("#^/infusions/vaContact/#i", TRUE_PHP_SELF)): ?>
            	<div class="welcome-msg clearfix floatfix">
               		<?php echo $locale['cube_0007']; ?>
                </div> 
			
            <?php //DISPLAY FORUM THREADS ?> 
            <?php elseif (preg_match('#^/forum/#i', TRUE_PHP_SELF)): ?>
            	<div class="forum-msg clearfix floatfix">
               		<?php include THEME.("includes/forum-threads.php"); ?>
                </div>   
                      
            <?php endif; ?>
            
		</div>
	</div>