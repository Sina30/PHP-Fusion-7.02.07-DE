<?php

/*-------------------------------------------------------+

| PHP-Fusion Content Management System

| Copyright  2002 - 2009 Nick Jones

| http://www.php-fusion.co.uk/

+--------------------------------------------------------+

| Filename: promembers.php

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


$result = dbquery("SELECT user_id, user_name, user_avatar, user_joined, user_ip FROM ".DB_USERS." ORDER BY user_joined DESC LIMIT 0,10");


echo '<div class="col-sm-6">
										<div class="widget-box">
											<div class="widget-header">
												<h4 class="widget-title lighter smaller">
													<i class="fa fa-comment-o"></i>';
												echo"<img class='img-responsive pull-left' src='../administration/images/Mitglieder.png'>&nbsp;&nbsp;".$locale['pro_1032']."";
												echo '</h4>
											</div>

											<div class="widget-body">
												<div class="widget-main no-padding">
													<!-- #section:pages/dashboard.conversations -->
													<div class="dialogs ace-scroll"><div class="scroll-track scroll-active" style="display: block;><div class="scroll-bar" style="top: 0px;"></div></div><div class="scroll-content">
														<div class="itemdiv dialogdiv">
															<div class="user">
																
															</div>

															<div class="body">
																<div class="time">
																	<i class="ace-icon fa fa-clock-o"></i>
																</div>

																<div class="name">';
																if (dbrows($result)) {

	$i = 0;

	echo "<table cellpadding='0' cellspacing='0' width='100%'>\n<tr>\n";

	echo "<td width='45' class='tbl2' height='27' style='border-bottom: 1px solid #d5d5d5;width:50px' align='center'><strong>".$locale['pro_1021']."</strong></td>\n";

	echo "<td width='55%' class='tbl2' height='27' style='border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5'><strong>".$locale['global_101']."</strong></td>\n";

	echo "<td width='1%' class='tbl2' style='text-align:center;white-space:nowrap;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5' height='27'><strong>".$locale['pro_1024']."</strong></td>\n";

	echo "<td width='1%' class='tbl2' style='text-align:center;white-space:nowrap;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5' height='27'><strong>".$locale['pro_1022']."</strong></td>\n";

	echo "<td width='80' class='tbl2' style='text-align:center;white-space:nowrap;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5' height='27'><strong>".$locale['pro_1023']."</strong></td>\n";

	echo "</tr>\n";

	while ($data = dbarray($result)) {

		$row_color = ($i % 2 == 0 ? "tbl1" : "tbl2");

		echo "<tr>\n<td class='".$row_color."' style='border-bottom: 1px solid #d5d5d5;border-top: 1px solid #fff;width:50px' height='58' width='45' align='center'>";

		if (!$data['user_avatar']) { 
	
			echo '<img src="'.THEMES.'templates/images/admin/no-avatar.jpg" class="avatar-effect" width="35" height="35" /></a>'; 
	
		} else {
	
			echo '<img src="'.IMAGES.'avatars/'.$data['user_avatar'].'" width="35" height="35" class="avatar-effect" /></a>';
	
		}

		echo "</td>\n";

		echo "<td width='55%' class='".$row_color."' style='border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5;border-top: 1px solid #fff' height='58'><a href='".BASEDIR."profile.php?lookup=".$data['user_id']."'>".trimlink($data['user_name'], 30)."</a></td>\n";

		echo "<td width='1%' class='".$row_color."' style='text-align:center;white-space:nowrap;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5;border-top: 1px solid #fff' height='58'>".$data['user_ip']."</td>\n";

		echo "<td width='1%' class='".$row_color."' style='text-align:center;white-space:nowrap;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5;border-top: 1px solid #fff' height='58'>".showdate("longdate", $data['user_joined'])."</td>\n";

		echo "<td width='80' class='".$row_color."' align='center' style='text-align:center;white-space:nowrap;border-left: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5;border-top: 1px solid #fff' height='58'>";

		echo '<div style="width:86px;" align="center">';

		echo '<div class="square-button" style="float:left;margin-right:5px;"><a href="'.ADMIN.'members.php'.$aidlink.'&step=edit&user_id='.$data['user_id'].'" title="'.$locale['global_076'].'"><img src="'.THEMES.'templates/images/admin/edit.png" /></a></div>';

		echo '<div class="square-button" style="float:left;margin-right:5px"><a href="'.ADMIN.'members.php'.$aidlink.'&step=delete&status=0&user_id='.$data['user_id'].'" title="'.$locale['pro_1019'].'"onclick="return confirm(\''.$locale['pro_1026'].'\');"><img src="'.THEMES.'templates/images/admin/delete.png" /></a></div>';

		echo '<div class="square-button" style="float:left;"><a href="'.BASEDIR.'profile.php?lookup='.$data['user_id'].'" title="'.$locale['pro_1025'].'"><img src="'.THEMES.'templates/images/admin/view.png" /></a></div>';
	
		echo '</div>';

		echo "</td>\n";

		echo "</tr>\n";

		$i++;

	}

	echo "</table>\n";

	echo "<div class='tbl1' style='text-align:center;height:30px;line-height:30px;background-image:url(".THEME."images/admin/table-shade.png);background-position: left bottom;background-repeat: repeat-x;'>\n";

	$members_registered = dbcount("(user_id)", DB_USERS, "user_status<='1' OR user_status='3' OR user_status='5'");

	$members_banned = dbcount("(user_id)", DB_USERS, "user_status='1'");

	$members_unactive = dbcount("(user_id)", DB_USERS, "user_status='2'");

	$members_suspended = dbcount("(user_id)", DB_USERS, "user_status='3'");

	echo "<a href='".ADMIN."members.php'.$aidlink.'&sortby=all&status=0&rowstart=0' title='".$members_registered." ".$locale['global_014']."'>".$locale['pro_1027']."</a> - ";

	echo "<a href='".ADMIN."members.php'.$aidlink.'&sortby=all&status=2&rowstart=0' title='".$members_unactive." ".$locale['pro_1030']."'>".$locale['pro_1030']."</a> - ";

	echo "<a href='".ADMIN."members.php'.$aidlink.'&sortby=all&status=3&rowstart=0' title='".$members_suspended." ".$locale['pro_1029']."'>".$locale['pro_1029']."</a> - ";

	echo "<a href='".ADMIN."members.php'.$aidlink.'&sortby=all&status=1&rowstart=0' title='".$members_banned." ".$locale['pro_1028']."'>".$locale['pro_1028']."</a>";


	echo "</div>\n";

} else { echo '<br /><div align="center">'.$locale['pro_1053'].'</div><br />'; }
															echo '	</div>

																<div class="tools">
																	</a>
																</div>
															</div>
														</div>
													</div></div>
												</div><!-- /.widget-main -->
											</div><!-- /.widget-body -->
										</div><!-- /.widget-box -->
									</div>';

?>