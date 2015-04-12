<?php

/*-------------------------------------------------------+

| PHP-Fusion Content Management System

| Copyright  2002 - 2009 Nick Jones

| http://www.php-fusion.co.uk/

+--------------------------------------------------------+

| Filename: proinfo.php

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

			openside($locale['pro_1066']);

echo '			<div style="width:100%;height:25px;background-color:#5d5857;line-height:200%" align="center">'.$locale['pro_1067'].'</div>';

				$members_registered = dbcount("(user_id)", DB_USERS, "user_status<='1' OR user_status='3' OR user_status='5'");
					
				$members_unactivated = dbcount("(user_id)", DB_USERS, "user_status='2'");
					
				$members_security_ban = dbcount("(user_id)", DB_USERS, "user_status='4'");
					
				$members_canceled = dbcount("(user_id)", DB_USERS, "user_status='5'");

				if (checkrights("M")) {
					
					echo "<a href='".ADMIN."members.php".$aidlink."' class='grey'>".$locale['251']."</a> $members_registered<br />\n";
					
					echo "<a href='".ADMIN."members.php".$aidlink."&amp;status=2' class='grey'>".$locale['252']."</a> $members_unactivated<br />\n";
				
					echo "<a href='".ADMIN."members.php".$aidlink."&amp;status=4' class='grey'>".$locale['253']."</a> $members_security_ban<br />\n";
					
					echo "<a href='".ADMIN."members.php".$aidlink."&amp;status=5' class='grey'>".$locale['263']."</a> $members_canceled<br />\n";
					
					if ($settings['enable_deactivation'] == "1") {
					
						$time_overdue = time() - (86400 * $settings['deactivation_period']);
					
						$members_inactive = dbcount("(user_id)", DB_USERS, "user_lastvisit<'$time_overdue' AND user_actiontime='0' AND user_joined<'$time_overdue' AND user_status='0'");
					
						echo "<a href='".ADMIN."members.php".$aidlink."&amp;status=8' class='grey'>".$locale['264']."</a> $members_inactive<br />\n";
					
					}
					
				} else {
				
					echo $locale['251']." ".$members_registered."<br />\n";
				
					echo $locale['252']." ".$members_unactivated."<br />\n";
					
					echo $locale['253']." ".$members_security_ban."<br />\n";
					
					echo $locale['263']." ".$members_canceled."<br />\n";
					
				}

echo '			<br /><div style="width:100%;height:25px;background-color:#5d5857;line-height:200%" align="center">'.$locale['pro_1068'].'</div>';

echo '
				'.(checkrights("SU") ? "<a href='".ADMIN."submissions.php".$aidlink."#news_submissions' class='grey'>".$locale['254']."</a>" : $locale['254'])." ".dbcount("(submit_id)", DB_SUBMISSIONS, "submit_type='n'").'<br />

				'.(checkrights("SU") ? "<a href='".ADMIN."submissions.php".$aidlink."#article_submissions' class='grey'>".$locale['255']."</a>" : $locale['255'])." ".dbcount("(submit_id)", DB_SUBMISSIONS, "submit_type='a'").'<br />

				'.(checkrights("SU") ? "<a href='".ADMIN."submissions.php".$aidlink."#link_submissions' class='grey'>".$locale['256']."</a>" : $locale['256'])." ".dbcount("(submit_id)", DB_SUBMISSIONS, "submit_type='l'").'<br />

				'.(checkrights("SU") ? "<a href='".ADMIN."submissions.php".$aidlink."#photo_submissions' class='grey'>".$locale['260']."</a>" : $locale['260'])." ".dbcount("(submit_id)", DB_SUBMISSIONS, "submit_type='p'").'<br />

				'.(checkrights("SU") ? "<a href='".ADMIN."submissions.php".$aidlink."#download_submissions' class='grey'>".$locale['265']."</a>" : $locale['265'])." ".dbcount("(submit_id)", DB_SUBMISSIONS, "submit_type='d'").'


				<br /><br /><div style="width:100%;height:25px;background-color:#5d5857;line-height:200%" align="center">'.$locale['pro_1069'].'</div>

				'.$locale['257']." ".dbcount("(comment_id)", DB_COMMENTS).'<br />
				
				'.$locale['259']." ".dbcount("(post_id)", DB_POSTS).'<br />
				
				'.$locale['261']." ".dbcount("(photo_id)", DB_PHOTOS).'<br />

';

			closeside();

?>