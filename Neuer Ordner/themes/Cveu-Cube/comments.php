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

<?php function render_comments($c_data, $c_info){
      global $locale, $settings; ?>

	<?php if (!empty($c_data)){ ?>
		<div class="comments floatfix">
            <div style="margin-bottom: 15px;" class="floatfix">
				<?php $c_makepagenav = ''; ?>
                <?php if ($c_info['c_makepagenav'] !== false) { echo $c_makepagenav = "<div class='flleft'>".$c_info['c_makepagenav']."</div>\n"; } ?>
                <?php if ($c_info['admin_link'] !== false) { echo "<div class='flright'>".$c_info['admin_link']."</div>\n"; } ?>
            </div>
            
            <div class="comment-main">
            <?php foreach($c_data as $data) { ?>
                <?php $comm_count = "<a href='".FUSION_REQUEST."#c".$data['comment_id']."' id='c".$data['comment_id']."' name='c".$data['comment_id']."'>#".$data['i']."</a>"; ?>
                <?php if ($settings['comments_avatar'] == "1") { ?>
                    <div class="comment-avatar-wrap"><?php echo $data['user_avatar']; ?></div>
                <?php } ?>
                <div class="comment">
                <div class="flright"><?php echo $comm_count; ?></div>
                <div class="user"><?php echo $data['comment_name']; ?>
                <span class="date small"><?php echo $data['comment_datestamp']; ?></span>
                </div>
                <div class="comment-body"><p><?php echo $data['comment_message']; ?></p></div>
                    <?php if ($data['edit_dell'] !== false) { echo "<span class='comment_actions'>".$data['edit_dell']."\n</span>\n"; } ?>
                </div>
            <?php } ?>
            </div>
           
            <?php echo $c_makepagenav; ?>
		</div>

	<?php } else { ?>
	    <div class="nocomments-message spacer"><?php echo $locale['c101']; ?></div>
	<?php } ?>

<?php } ?>
