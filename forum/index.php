<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: index.php
| Author: Nick Jones (Digitanium)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "../maincore.php";
require_once THEMES."templates/header.php";
include LOCALE.LOCALESET."forum/main.php";

if (!isset($lastvisited) || !isnum($lastvisited)) { $lastvisited = time(); }

add_to_title($locale['global_200'].$locale['400']);

opentable();
echo "<!--pre_forum_idx--><table cellpadding='0' cellspacing='1' width='100%' class='tbl-border forum_idx_table'>\n";

$forum_list = ""; $current_cat = "";
$result = dbquery(
	"SELECT f.*, f2.forum_name AS forum_cat_name, u.user_id, u.user_name, u.user_status
	FROM ".DB_FORUMS." f
	LEFT JOIN ".DB_FORUMS." f2 ON f.forum_cat = f2.forum_id
	LEFT JOIN ".DB_USERS." u ON f.forum_lastuser = u.user_id
	WHERE ".groupaccess('f.forum_access')." AND f.forum_cat!='0'
	GROUP BY forum_id ORDER BY f2.forum_order ASC, f.forum_order ASC"
);

$result = dbquery(
   "SELECT f.forum_id, f.forum_cat, f.forum_name, f.forum_description, f.forum_moderators, f.forum_lastpost, f.forum_postcount,
   f.forum_threadcount, f.forum_lastuser, f.forum_access, f2.forum_name AS forum_cat_name,
   t.thread_id, t.thread_lastpost, t.thread_lastpostid, t.thread_subject, t.thread_locked,
   u.user_id, u.user_name,u.user_avatar, u.user_status, tu1.user_name AS user_author, tu1.user_status AS status_author, tu3.user_avatar AS user_avatarlastuser, tu1.user_avatar, tu1.user_id,
      tu2.user_name AS user_lastuser, tu2.user_status AS status_lastuser
   FROM ".DB_FORUMS." f
   LEFT JOIN ".DB_FORUMS." f2 ON f.forum_cat = f2.forum_id
   LEFT JOIN ".DB_THREADS." t ON f.forum_id = t.forum_id AND f.forum_lastpost=t.thread_lastpost
   LEFT JOIN ".DB_USERS." u ON f.forum_lastuser = u.user_id
   LEFT JOIN ".DB_USERS." tu1 ON t.thread_author = tu1.user_id
      LEFT JOIN ".DB_USERS." tu2 ON t.thread_lastuser = tu2.user_id
      LEFT JOIN ".DB_USERS." tu3 ON t.thread_lastuser = tu3.user_id
   WHERE ".$catWhere." ".groupaccess('f.forum_access')." AND f.forum_cat!='0'
   GROUP BY forum_id ORDER BY f2.forum_order ASC, f.forum_order ASC, t.thread_lastpost DESC"
);

if (dbrows($result) != 0) {
	while ($data = dbarray($result)) {
		if ($data['forum_cat_name'] != $current_cat) {
			$current_cat = $data['forum_cat_name'];
			echo "<tr>\n<a><td colspan='2' class='forum-caption forum_cat_name'><!--forum_cat_name-->".$data['forum_cat_name']."</td>\n";
			echo "<td align='center' width='1%' class='forum-caption' style='white-space:nowrap'>".$locale['402']."</td>\n";
			echo "<td align='center' width='1%' class='forum-caption' style='white-space:nowrap'>".$locale['403']."</td>\n";
			echo "<td width='1%' class='forum-caption' style='white-space:nowrap'>".$locale['404']."</td>\n";
			echo "</tr>\n";
		}
		$moderators = "";
		if ($data['forum_moderators']) {
			$mod_groups = explode(".", $data['forum_moderators']);
			foreach ($mod_groups as $mod_group) {
				if ($moderators) $moderators .= ", ";
				$moderators .= $mod_group<101 ? "<a href='".BASEDIR."profile.php?group_id=".$mod_group."'>".getgroupname($mod_group)."</a>" : getgroupname($mod_group);
			}
		}
		$forum_match = "\|".$data['forum_lastpost']."\|".$data['forum_id'];
		if ($data['forum_lastpost'] > $lastvisited) {
			if (iMEMBER && ($data['forum_lastuser'] == $userdata['user_id'] || preg_match("({$forum_match}\.|{$forum_match}$)", $userdata['user_threads']))) {
				$fim = "<img src='".get_image("folder")."' alt='".$locale['561']."' />";
			} else {
				$fim = "<img src='".get_image("foldernew")."' alt='".$locale['560']."' />";
			}
		} else {
			$fim = "<img src='".get_image("folder")."' alt='".$locale['561']."' />";
		}
		echo "<tr>\n";
		echo "<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>$fim</td>\n";
		echo "<td class='tbl11 forum_name'>";
		if ($data['forum_lastpost'] == 0) {
         echo $locale['405']."in&nbsp;-&nbsp;<a href='viewforum.php?forum_id=".$data['forum_id']."'>".$data['forum_name']."</a>";
      } else {

		 echo "<h2><b>";
      if ($tdata['thread_sticky'] == 1) {
         echo "<img src='".get_image("stickythread")."' alt='".$locale['474']."' style='vertical-align:middle;' />\n";
      }
		 echo"<a href='".FORUM."viewthread.php?thread_id=".$data['thread_id']."#post_".$data['thread_lastpostid']."' title='".$data['thread_subject']."'>";
		 echo trimlink($data['thread_subject'], 33)." </a></b></h2>\n";
		 
		echo "Gestartet von&nbsp;";
		 if ($data['user_avatar'] && file_exists(IMAGES."avatars/".$data['user_avatar'])) { $asrc = IMAGES."avatars/".$data['user_avatar']; }
      else { $src = IMAGES."avatars/noavatar50.png"; }
     if($data['user_avatar'] && file_exists(IMAGES."avatars/".$data['user_avatar'])) { $src = IMAGES."avatars/".$data['user_avatar']; }
      else { $src = IMAGES."avatars/noavatar50.png"; }
		echo "
         <img class='img-responsive img-rounded m-r-10' style='display:inline; max-width:15px; max-height:15px;  border-radius: 6px;' src='".$src."' alt='".$src."' />
         ".$data['thread_author'], $data['user_author']."\n";
		echo"<!--forum_name-->in&nbsp;".$data['forum_name']."&nbsp;-&nbsp;<a href='viewforum.php?forum_id=".$data['forum_id']."'>".$data['forum_cat_name']."</a>\n";
		echo "</td>\n";
		echo "<td align='center' width='1%' class='mainbody' style='white-space:nowrap'>".$data['forum_threadcount']."</td>\n";
		echo "<td align='center' width='1%' class='mainbody' style='white-space:nowrap'>".$data['forum_postcount']."</td>\n";
		echo "<td width='1%' class='tbl1' style='white-space:nowrap; padding-right:50px;'>";
				 if ($data['user_avatar'] && file_exists(IMAGES."avatars/".$data['user_avatar'])) { $asrc = IMAGES."avatars/".$data['user_avatar']; }
      else { $src = IMAGES."avatars/noavatar50.png"; }
     if($data['user_avatarlastuser'] && file_exists(IMAGES."avatars/".$data['user_avatarlastuser'])) { $src = IMAGES."avatars/".$data['user_avatarlastuser']; }
      else { $src = IMAGES."avatars/noavatar50.png"; }
		
			echo "<a href='".BASEDIR."profile.php?lookup=".$data['thread_lastuser']."' class='profile-link flleft'>
         <span ><img style='margin-right:4px; border-radius:6px;' width='30' src='".$src."' alt='".$src."' /></span></a>
         <span class='small'>".profile_link($data['thread_lastuser'], $data['user_lastuser'], $data['status_lastuser'])."</span><br />
         ".showdate("forumdate", $data['thread_lastpost'])."</td>\n";
}
		 }
	echo "<tr>\n<td colspan='5' class='tbl1'>".$locale['407']."</td>\n</tr>\n";
}
echo "<table class='tbl-border table table-responsive' border='0' width='100%' align='center'>";
echo "<tr><td><img src='".get_image("foldernew")."' alt='".$locale['560']."' style='vertical-align:middle; width:24px;' /> - ".$locale['470']."</td>";
echo "<td><img src='".get_image("folder")."' alt='".$locale['561']."' style='vertical-align:middle; width:24px;' /> - ".$locale['472']."</td></tr>";
echo "<tr><td><img src='".get_image("folderlock")."' alt='".$locale['564']."' style='vertical-align:middle; width:24px;' /> - ".$locale['473']."</td>";
echo "<td><img src='".get_image("stickythread")."' alt='".$locale['563']."' style='vertical-align:middle; width:24px;' /> - ".$locale['474']."</td></tr>";

echo "</table>\n<!--sub_forum-->\n";
closetable();
	
require_once THEMES."templates/footer.php";
?>
