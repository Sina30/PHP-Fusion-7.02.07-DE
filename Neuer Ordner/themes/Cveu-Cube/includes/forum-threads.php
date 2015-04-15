<?php
if (!defined("IN_FUSION")) { die("Access Denied"); }

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

	$i = 0;

	echo "<table cellpadding='0' cellspacing='1' width='100%'>\n<tr>\n";
	echo "<td width='100%' class='forum-msg-tbl'>".$locale['global_044']."</td>\n";
	echo "<td width='1%' class='forum-msg-tbl' style='text-align:center;white-space:nowrap'>".$locale['global_045']."</td>\n";
	echo "<td width='1%' class='forum-msg-tbl' style='text-align:center;white-space:nowrap'>".$locale['global_046']."</td>\n";
	echo "<td width='1%' class='forum-msg-tbl' style='text-align:center;white-space:nowrap'>".$locale['global_047']."</td>\n";
	echo "</tr>\n";
	while ($data = dbarray($result)) {
		echo "<tr>\n";
		echo "<td width='100%' class='forum-msg-tbl'><a href='".FORUM."viewthread.php?thread_id=".$data['thread_id']."&amp;pid=".$data['thread_lastpostid']."#post_".$data['thread_lastpostid']."' title='".$data['thread_subject']."'>".trimlink($data['thread_subject'], 30)."</a><br />\n<span style='font-size: 14px;'>".$data['forum_name']."</span></td>\n";
		echo "<td width='1%' class='forum-msg-tbl' style='text-align:center;white-space:nowrap'>".$data['thread_views']."</td>\n";
		echo "<td width='1%' class='forum-msg-tbl' style='text-align:center;white-space:nowrap'>".($data['thread_postcount']-1)."</td>\n";
		echo "<td width='1%' class='forum-msg-tbl' style='text-align:center;white-space:nowrap'>".profile_link($data['thread_lastuser'], $data['user_name'], $data['user_status'])."<br />\n<span style='font-size: 14px;'>".showdate("forumdate", $data['thread_lastpost'])."</span></td>\n";
		echo "</tr>\n";
		$i++;
	}
	echo "</table>\n";

?>
