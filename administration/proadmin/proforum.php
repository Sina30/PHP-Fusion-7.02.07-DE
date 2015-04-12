<?php

/*-------------------------------------------------------+

| PHP-Fusion Content Management System

| Copyright  2002 - 2009 Nick Jones

| http://www.php-fusion.co.uk/

+--------------------------------------------------------+

| Filename: procomment.php

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

opentidetable($locale['global_021']);
		
global $lastvisited;

if (!isset($lastvisited) || !isnum($lastvisited)) { $lastvisited = time(); }


$data = dbarray(dbquery(

	"SELECT tt.thread_lastpost

	FROM ".DB_FORUMS." tf

	INNER JOIN ".DB_THREADS." tt ON tf.forum_id = tt.forum_id

	WHERE ".groupaccess('tf.forum_access')." AND thread_hidden='0'

	ORDER BY tt.thread_lastpost DESC LIMIT ".($settings['numofthreads']-1).", ".$settings['numofthreads']

));

$timeframe = empty($data['thread_lastpost']) ? 0 : $data['thread_lastpost'];

$result = dbquery(

	"SELECT tt.thread_id, tt.thread_subject, tt.thread_views, tt.thread_lastuser, tt.thread_lastpost,

	tt.thread_poll, tf.forum_id, tf.forum_name, tf.forum_access, tt.thread_lastpostid, tt.thread_postcount, tu.user_id, tu.user_name,

	tu.user_status

	FROM ".DB_THREADS." tt

	INNER JOIN ".DB_FORUMS." tf ON tt.forum_id=tf.forum_id

	INNER JOIN ".DB_USERS." tu ON tt.thread_lastuser=tu.user_id

	WHERE ".groupaccess('tf.forum_access')." AND tt.thread_lastpost >= ".$timeframe." AND tt.thread_hidden='0'

	ORDER BY tt.thread_lastpost DESC LIMIT 0,".$settings['numofthreads']
);

if (dbrows($result)) {

	$i = 0;

	echo "<table cellpadding='0' cellspacing='0' width='100%'>\n<tr>\n";

	echo "<td class='tbl2' height='27' style='border-bottom: 1px solid #d5d5d5;width:40px'>&nbsp;</td>\n";

	echo "<td width='100%' class='tbl2' height='27' style='border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5'><strong>".$locale['global_044']."</strong></td>\n";

	echo "<td width='1%' class='tbl2' style='text-align:center;white-space:nowrap;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5' height='27'><strong>".$locale['global_045']."</strong></td>\n";

	echo "<td width='1%' class='tbl2' style='text-align:center;white-space:nowrap;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5' height='27'><strong>".$locale['global_046']."</strong></td>\n";

	echo "<td width='1%' class='tbl2' style='text-align:center;white-space:nowrap;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5' height='27'><strong>".$locale['global_047']."</strong></td>\n";

	echo "</tr>\n";

	while ($data = dbarray($result)) {

		$row_color = ($i % 2 == 0 ? "tbl1" : "tbl2");

		echo "<tr>\n<td class='".$row_color."' style='border-bottom: 1px solid #d5d5d5;border-top: 1px solid #fff;width:40px' height='58'>";

		if ($data['thread_lastpost'] > $lastvisited) {

			$thread_match = $data['thread_id']."\|".$data['thread_lastpost']."\|".$data['forum_id'];

			if (iMEMBER && ($data['thread_lastuser'] == $userdata['user_id'] || preg_match("(^\.{$thread_match}$|\.{$thread_match}\.|\.{$thread_match}$)", $userdata['user_threads']))) {

				echo "<img src='".THEMES."templates/images/admin/forum-bullet-off.jpg' title='Read' alt='' />";

			} else {

				echo "<img src='".THEMES."templates/images/admin/forum-bullet.jpg' title='New' alt='' />";

			}

		} else {

			echo "<img src='".THEMES."templates/images/admin/forum-bullet-off.jpg' title='Read' alt='' />";

		}

		echo "</td>\n";

		echo "<td width='100%' class='".$row_color."' style='border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5;border-top: 1px solid #fff' height='58'><a href='".FORUM."viewthread.php?thread_id=".$data['thread_id']."&amp;pid=".$data['thread_lastpostid']."#post_".$data['thread_lastpostid']."''>".trimlink($data['thread_subject'], 30)."</a><br />\n".$data['forum_name']."</td>\n";

		echo "<td width='1%' class='".$row_color."' style='text-align:center;white-space:nowrap;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5;border-top: 1px solid #fff' height='58'>".$data['thread_views']."</td>\n";

		echo "<td width='1%' class='".$row_color."' style='text-align:center;white-space:nowrap;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5;border-top: 1px solid #fff' height='58'>".($data['thread_postcount']-1)."</td>\n";

		echo "<td width='1%' class='".$row_color."' style='text-align:center;white-space:nowrap;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5;border-top: 1px solid #fff' height='58'>".profile_link($data['thread_lastuser'], $data['user_name'], $data['user_status'])."<br />\n".showdate("forumdate", $data['thread_lastpost'])."</td>\n";

		echo "</tr>\n";

		$i++;

	}

	echo "</table>\n";

	if (iMEMBER) {

		echo "<div class='tbl1' style='text-align:center;height:30px;line-height:30px;background-image:url('.THEMES.'templates/images/admin/table-shade.png);background-position: left bottom;background-repeat: repeat-x;'><a href='".INFUSIONS."forum_threads_list_panel/my_threads.php'>".$locale['global_041']."</a> - ";

		echo "<a href='".INFUSIONS."forum_threads_list_panel/my_posts.php'>".$locale['global_042']."</a> - ";

		echo "<a href='".INFUSIONS."forum_threads_list_panel/new_posts.php'>".$locale['global_043']."</a>";

		if($settings['thread_notify']) {

			echo " - <a href='".INFUSIONS."forum_threads_list_panel/my_tracked_threads.php'>".$locale['global_056']."</a>";

		}

		echo "</div>\n";

	}

} else { echo '<br /><div align="center">'.$locale['pro_1053'].'</div><br />'; }

closetidetable();

?>