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

<?php function render_news($subject, $news, $info) {
	  global $locale, $settings, $aidlink; ?>
      
	  <?php if (file_exists(THEME."locale/".$settings['locale'].".php")) {
		include THEME."locale/".$settings['locale'].".php";
		} else { include THEME."locale/English.php"; } ?>
      
<?php set_image("edit", THEME."images/icons/news_edit.png"); ?>

	<div class="capmain-news floatfix">
        <div class="flleft"><h2 class='title'><?php echo $subject; ?></h2></div>  
	</div>
    
	<div class="spacer">
        <div class="news-meta middle-border floatfix">
        	<div class="flright">
        	<?php echo "<a href='".BASEDIR."print.php?type=N&amp;item_id=".$info['news_id']."'><img src='".THEME."images/icons/printer.png' /></a>"; ?>
            <?php if (iADMIN && checkrights("N")) { echo "<a href='".ADMIN."news.php".$aidlink."&amp;action=edit&amp;news_id=".$info['news_id']."'><img src='".THEME."images/icons/edit.png' /></a>"; } ?>
            </div>
            <ul>
                <li><?php echo $locale['cube_0001']; ?> <?php echo profile_link($info['user_id'], $info['user_name'], $info['user_status']); ?></li>
                <li><?php echo $locale['cube_0002']; ?>  <?php echo showdate("%d %b %Y", $info['news_date']); ?></li>
                
                <?php if ($info['cat_id']) { ?>
                    <li><?php echo $locale['cube_0003']; ?>  <?php echo "<a href='".BASEDIR."news_cats.php?cat_id=".$info['cat_id']."'>".$info['cat_name']."</a>"; ?></li>
                <?php } else {  ?>
                    <li><?php echo $locale['cube_0003']; ?>  <?php echo "<a href='".BASEDIR."news_cats.php?cat_id=0'>".$locale['global_080']."</a>"; ?></li>
                <?php } ?>
            </ul>
        </div>
    
        <div class="news-body floatfix">
           
            <?php echo $info['cat_image'].$news; ?> <br />
            
            <?php if (!isset($_GET['readmore']) && $info['news_ext'] == "y") { ?>
                <div class="flright">
                <?php if ($info['news_ext'] == "y" || ($info['news_allow_comments'] && $settings['comments_enabled'] == "1")) { ?>
                <span id="news-reads"><?php echo $info['news_reads'].$locale['global_074']; ?></span>
                <?php } ?>
                
                <?php if ($info['news_allow_comments'] && $settings['comments_enabled'] == "1") { ?>
                <span id="news-comments"><?php echo $info['news_comments'].($info['news_comments'] == 1 ? $locale['global_073b'] : $locale['global_073']); ?></span>
                <?php } ?>
                
                <?php echo "<a href='".BASEDIR."news.php?readmore=".$info['news_id']."' class='readmore'>".$locale['global_072']."</a>"; ?>

                </div>
            <?php } ?>
        </div>
	</div>

<?php } ?>