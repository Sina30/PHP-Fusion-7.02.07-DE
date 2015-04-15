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

	<div class="content-wrapper">
		<div class="main-bg">
                
			<?php if (LEFT) { ?>
				<div id="side-left"><?php echo LEFT; ?></div> 
			<?php } ?>
                
			<?php if (RIGHT) { ?>
            	<div id="side-right"><?php echo RIGHT; ?></div>
            <?php } ?>
                
			<div id="side-center" class="<?php echo $main_style; ?>">
				<div class="upper"><?php echo U_CENTER; ?></div>
  				<div class="content"><?php echo CONTENT; ?></div>
				<div class="lower"><?php echo L_CENTER; ?></div>
			</div>   
            
        </div>
	<div class="clear"></div>
    </div>