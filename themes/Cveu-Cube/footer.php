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
if (!defined("IN_FUSION")) { die("Access Denied"); }     
    
if (file_exists(THEME."locale/".$settings['locale'].".php")) {
	include THEME."locale/".$settings['locale'].".php";
} else {
	include THEME."locale/English.php";
}

	echo "<div class='footer_bg'>
	<div class='protean_wrapper'>
	<div class='footer'>
	<div class='collumns'>
	<div class='collumn'>";
	echo '<!-- BEGIN .widget -->
						<div class="widget">
							<div class="w-title">
								<h3><i class="fa fa-info-circle"></i> Statistik</h3>
							</div>
							<div class="article-list">
								<t style="color:#fff;"><i class="fa fa-users"></i> Mitglieder</t><div style="float: right;">'.dbcount("(user_id)", DB_USERS).'</div><br>
                                <t style="color:#fff;"><i class="fa fa-comments"></i> Kommentare</t><div style="float: right;">'.dbcount("(comment_id)", DB_COMMENTS).'</div><br>
                                <t style="color:#fff;"><i class="fa fa-folder-o"></i> Forenthemen</t><div style="float: right;">'.dbcount("(thread_id)", DB_THREADS).'</div><br>
                                <t style="color:#fff;"><i class="fa fa-folder"></i> Forumbeiträge</t><div style="float: right;">'.dbcount("(post_id)", DB_POSTS).'</div><br>
                                <t style="color:#fff;"><i class="fa fa-angle-double-right"></i> Private Nachrichten</t><div style="float: right;">'.dbcount("(message_id)", DB_MESSAGES).'</div><br>
                                <t style="color:#fff;"><i class="fa fa-check"></i> Links zu Webseiten</t><div style="float: right;">'.dbcount("(weblink_id)", DB_WEBLINKS).'</div><br>';
								echo '<t style="color:#fff;"><i class="fa fa-check"></i> Downloadkategorien</t><div style="float: right;">'.dbcount("(download_cat_id)", DB_DOWNLOAD_CATS).'</div><br>';
								echo '<t style="color:#fff;"><i class="fa fa-check"></i> Downloads</t><div style="float: right;">'.dbcount("(download_id)", DB_DOWNLOADS).'</div><br>';
								echo'    <t style="color:#fff;"><i class="fa fa-share"></i> Besucher</t><div style="float: right;"><!--counter-->';echo"".showcounter()."";echo'</div><br>';
								echo'    <t style="color:#fff;"><i class="fa fa-share"></i> Datum - Uhrzeit</t><div style="float: right;"><!--counter-->';echo"".showsubdate(2)."";echo'</div><br>
                    	

							</div>
						<!-- END .widget -->
						</div>
						</div>';
	echo "<div class='collumn'>";
	$settingsb['numofthreads'] = 12;
	$datab = dbarray(dbquery("SELECT tt.thread_lastpost
	FROM ".DB_FORUMS." tf
	INNER JOIN ".DB_THREADS." tt ON tf.forum_id = tt.forum_id
	WHERE ".groupaccess('tf.forum_access')." AND thread_hidden='0'
	ORDER BY tt.thread_lastpost DESC LIMIT ".($settingsb['numofthreads']-1).", ".$settingsb['numofthreads']));

	$timeframeb = empty($datab['thread_lastpost']) ? 0 : $datab['thread_lastpost'];

	$result = dbquery("SELECT tt.thread_id, tt.thread_subject, tt.thread_views, tt.thread_lastuser, tt.thread_lastpost,
	tt.thread_poll, tf.forum_id, tf.forum_name, tf.forum_access, tt.thread_lastpostid, tt.thread_postcount, tu.user_id, tu.user_name,
	tu.user_status
	FROM ".DB_THREADS." tt
	INNER JOIN ".DB_FORUMS." tf ON tt.forum_id=tf.forum_id
	INNER JOIN ".DB_USERS." tu ON tt.thread_lastuser=tu.user_id
	WHERE ".groupaccess('tf.forum_access')." AND tt.thread_lastpost >= ".$timeframeb." AND tt.thread_hidden='0'
	ORDER BY tt.thread_lastpost DESC LIMIT 0,".$settingsb['numofthreads']);
	if (dbrows($result)) {
	echo"	<h4>NEUESTEN AKTIVEN THREADS</h4>";
	while($data = dbarray($result)) {
	$itemsubject = trimlink($data['thread_subject'], 33);
	echo " <span><a href='".FORUM."viewthread.php?thread_id=".$data['thread_id']."' title='".$data['thread_subject']."'>$itemsubject</a><span>\n";
	}
	} 
	echo"</div>
	<div class='collumn'>
	<h4>DIE AKTUELLSTEN DOWNLOADS</h4>";
	$result = dbquery("SELECT td.download_id, td.download_datestamp,td.download_title, td.download_cat,
	tc.download_cat_id, tc.download_cat_access
	FROM ".DB_DOWNLOADS." td
	LEFT JOIN ".DB_DOWNLOAD_CATS." tc ON td.download_cat=tc.download_cat_id
	WHERE ".groupaccess('download_cat_access')."
	ORDER BY download_datestamp DESC LIMIT 0,12");
	if (dbrows($result)) {
	echo"<ul class='footer_section'>";
	while ($dldata = dbarray($result)) {
	$dl_title = trimlink(strip_tags(parseubb($dldata['download_title'])), 33);
	if ($dldata['download_datestamp'] + 604800 > time() + ($settings['timeoffset'] * 3600)) {
	$new = "<span><a style='font-weight: 700; color: #FF9933;' title='".$dldata['download_title']."' href='".BASEDIR."downloads/downloads.php?cat_id=".$dldata['download_cat_id']."&amp;download_id=".$dldata['download_id']."'>".$dl_title."</a> &nbsp;<img src='".THEME."images/icons/new_dl.png' alt='Neu' title='Neu' class='blink'  style='border:0px; vertical-align:middle;' /></span>";
	} else {
	$new = "<span><a title='".$dldata['download_title']."' href='".BASEDIR."downloads/downloads.php?cat_id=".$dldata['download_cat_id']."&amp;download_id=".$dldata['download_id']."'>".$dl_title."</a></span>";
	}
	echo "".$new."";

	}
	}else{
	echo"<span>No Downloads</span>";
	}		
	echo"</div>
	<div class='collumn'>
	<h4>".$locale['protean_006']."</h4>
	<ul class='footer_section'>";
	$result = dbquery("SELECT * FROM ".DB_USERS." WHERE user_lastvisit !='0'  AND user_status ='0' ORDER BY  user_lastvisit DESC LIMIT 14");

	while ($data = dbarray($result)) {

	$lseen = time() - stripinput($data['user_lastvisit']);
	if($lseen < 60) { 
	if ($data['user_avatar'] && file_exists(IMAGES."avatars/".$data['user_avatar']) && $data['user_status']!=6 && $data['user_status']!=5) { echo "<a href='".BASEDIR."profile.php?lookup=".$data['user_id']."'><img class='lstsn-users-online' src='".IMAGES."avatars/".$data['user_avatar']."'   title='".$data['user_name'].$locale['modish_006']."' alt='' /></a>";
	} else { echo "<a href='".BASEDIR."profile.php?lookup=".$data['user_id']."'><img class='lstsn-users-online' src='".IMAGES."avatars/noavatar100.png' alt=''  title=' ".$data['user_name'].$locale['modish_006']."' /></a>";
	} 
	} elseif($lseen < 300) {  if ($data['user_avatar'] && file_exists(IMAGES."avatars/".$data['user_avatar']) && $data['user_status']!=6 && $data['user_status']!=5) { echo "<a href='".BASEDIR."profile.php?lookup=".$data['user_id']."'><img class='lstsn-users-five lstsn-user' src='".IMAGES."avatars/".$data['user_avatar']."'   title='".$data['user_name'].$locale['modish_007']."' alt='' /></a>";
	} else { echo "<a href='".BASEDIR."profile.php?lookup=".$data['user_id']."'><img class='lstsn-users-five lstsn-user' src='".IMAGES."avatars/noavatar100.png'  alt=''  title=' ".$data['user_name'].$locale['modish_007']."' /></a>";
	} 
	}else{ if ($data['user_avatar'] && file_exists(IMAGES."avatars/".$data['user_avatar']) && $data['user_status']!=6 && $data['user_status']!=5) { echo "<a href='".BASEDIR."profile.php?lookup=".$data['user_id']."'><img class='lstsn-users-offline lstsn-user' src='".IMAGES."avatars/".$data['user_avatar']."'   title='".$data['user_name'].$locale['modish_008'].showdate("shortdate", $data['user_lastvisit'])."' alt='' /></a>";
	} else { echo "<a href='".BASEDIR."profile.php?lookup=".$data['user_id']."'><img class='lstsn-users-offline lstsn-user' src='".IMAGES."avatars/noavatar100.png' alt=''  title=' ".$data['user_name'].$locale['modish_008'].showdate("shortdate", $data['user_lastvisit'])."' /></a>";
	}
	}
	}
	echo"</ul>";
	$result = dbquery("SELECT * FROM ".DB_ONLINE." WHERE online_user=".($userdata['user_level'] != 0 ? "'".$userdata['user_id']."'" : "'0' AND online_ip='".USER_IP."'"));
	if (dbrows($result)) {
	$result = dbquery("UPDATE ".DB_ONLINE." SET online_lastactive='".time()."' WHERE online_user=".($userdata['user_level'] != 0 ? "'".$userdata['user_id']."'" : "'0' AND online_ip='".USER_IP."'")."");
	} else {
	$result = dbquery("INSERT INTO ".DB_ONLINE." (online_user, online_ip, online_lastactive) VALUES ('".($userdata['user_level'] != 0 ? $userdata['user_id'] : "0")."', '".USER_IP."', '".time()."')");
	}
	$result = dbquery("DELETE FROM ".DB_ONLINE." WHERE online_lastactive<".(time()-60)."");

	$result = dbquery("SELECT ton.*, tu.user_id,
	tu.user_name, tu.user_status,
	tu.user_level FROM ".DB_ONLINE." ton
	LEFT JOIN ".DB_USERS." tu ON ton.online_user=tu.user_id");

	$guests = 0; $members = array();
	while ($data = dbarray($result)) {
	if ($data['online_user'] == "0") {
	$guests++;
	} else {
	array_push($members, array($data['user_id'], $data['user_name'], $data['user_status'], $data['user_level']));
	}
	}
	$count_total = dbcount("(online_user)", DB_ONLINE, (iMEMBER ? "online_user='".$userdata['user_id']."'" : "online_user='0' AND online_ip='".USER_IP."'") == 1);
	//$new_members_today = number_format(dbcount("(user_id)", DB_USERS, "user_status<='1' AND user_joined > UNIX_TIMESTAMP(CURDATE())"));
	//Guests and Members online
	echo "<span><div id='users'>".$locale['protean_010'].": <strong> ".$count_total."</strong>&nbsp;::&nbsp;".$locale['protean_011'].": <strong>".count($members)."</strong>&nbsp;::&nbsp;".$locale['protean_012'].": <strong>".$guests."</strong>";
	echo"<br />".$locale['protean_013'].": <strong>".number_format(dbcount("(user_id)", DB_USERS, "user_status<='1' AND user_lastvisit > UNIX_TIMESTAMP(CURDATE())"))."</strong>";
	//echo"<br />".$locale['protean_014'].": <strong>".$new_members_today."</strong>";
	$count_new = dbcount("(user_id)", DB_USERS, "user_status='2'");
	if($settings['visitorcounter_enabled']) {
	echo " <br /> Eindeutige Besuche: <strong>".number_format($settings['counter'])."</strong>";
	}
	if (iADMIN && checkrights("M") && $settings['admin_activation'] == "1" && $count_new > 0) {
	echo "<br /><strong><span style='color:#FF6100;'>".$locale['protean_015'].":</span> <a href='".ADMIN."members.php".$aidlink."&amp;status=2'>".$locale['protean_016']."</a>\n";
	echo ":</strong> ".dbcount("(user_id)", DB_USERS, "user_status='2'")."\n";
	}
	echo"</div></span>";
	echo"</div>";
	echo"<div class='clear'></div>
	</div>
	<div class='footer_top'>
	<div class='footer_nav_right'>
	<p>".stripslashes($settings['footer'])."</p>";
	echo"<br />";
	echo"</div>
	<div class='copy'>
	<p class='link'><span>";
	if (!$license) { echo showcvisioncr(); }
	echo"</span></p>
	</div>
	<div class='clear'></div>
	</div>
	</div>
	</div>
	</div>";

add_to_footer("<script type='text/javascript'>
$('body').show();
NProgress.start();
setTimeout(function() { NProgress.done(); $('.fade').removeClass('out'); }, 1000);
$('#b-0').click(function() { NProgress.start(); });
$('#b-40').click(function() { NProgress.set(0.4); });
$('#b-inc').click(function() { NProgress.inc(); });
$('#b-100').click(function() { NProgress.done(); });
</script>");
?>	