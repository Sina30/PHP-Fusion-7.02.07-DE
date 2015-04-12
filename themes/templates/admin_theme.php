<?php

if (!defined("IN_FUSION")) { die("Access Denied"); }

define("THEME_BULLET", "<span class='bullet'>&middot;</span>");

require_once INCLUDES."theme_functions_include.php";

include LOCALE.LOCALESET."admin/adminpro.php";

$repeat = dbcount("(visit_id)", DB_ADMINVISIT, "visit_link='".FUSION_SELF."' AND visit_admin='".$userdata['user_id']."'");

if ($repeat == 0 && FUSION_SELF != "dashboard.php" && FUSION_SELF != "ibdex.php") { $result = dbquery("INSERT INTO ".DB_ADMINVISIT." (visit_link, visit_admin, visit_time) VALUES ('".FUSION_SELF."', '".$userdata['user_id']."', '".time()."')"); }

$visitcount = dbcount("(visit_id)", DB_ADMINVISIT, "visit_admin='".$userdata['user_id']."'");

if ($visitcount > 5) { 

	$adminvisit = dbquery("SELECT visit_id FROM ".DB_ADMINVISIT." WHERE visit_admin='".$userdata['user_id']."' ORDER BY visit_time ASC LIMIT 0,1");

	$lastv = dbarray($adminvisit);

	$result = dbquery("DELETE FROM ".DB_ADMINVISIT." WHERE visit_id='".$lastv['visit_id']."'"); 

}

function render_page($license = false) {
	
	global $settings, $main_style, $locale, $mysql_queries_time, $userdata, $locale, $aidlink, $navi_name;

	//Header

	echo '
	
	<div class="main-area">

		<div class="top-bar">

			<div style="float:left;margin-top:13px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="'.BASEDIR.'images/php-fusion.png" border="0" /></div>

			<div style="float:right;width:200px;margin-top:15px;margin-right:10px" align="left">

				<div style="float:left;margin-left:10px"><a href="'.ADMIN.'proadmin/prooptions.php'.$aidlink.'" title="'.$locale['pro_1065'].'"><img src="'.THEMES.'templates/images/admin/options.jpg" border="0" /></a></div>

				<div style="float:left;margin-left:10px"><img src="'.THEMES.'templates/images/admin/top-search.jpg" border="0" /></div>

				<div style="float:left;margin-left:10px"><a href="'.ADMIN.'dashboard.php'.$aidlink.'" title="'.$locale['pro_1007'].'"><img src="'.THEMES.'templates/images/admin/top-dash.jpg" border="0" /></a></div>

				<div style="float:left;margin-left:10px"><a href="'.BASEDIR.'" title="'.$locale['global_181'].'"><img src="'.THEMES.'templates/images/admin/top-return.jpg" border="0" /></a></div>

				<div style="float:left;margin-left:10px"><a href="'.FUSION_SELF.'?logout=yes" title="'.$locale['global_124'].'"><img src="'.THEMES.'templates/images/admin/top-logout.jpg" border="0" /></a></div>

			</div>

		</div>

		<script type="text/javascript">
			 //<![CDATA[
			
			 var a1;
			
			 jQuery(function() {
			 var options = {
			 serviceUrl: \''.BASEDIR.'includes/fusionpro/auto_suggest_tags.php\',
			 width: 183,
			 delimiter: /(,|;)\s*/,
			 deferRequestBy: 0, //miliseconds
			 params: { country: \'Yes\' },
			 noCache: false //set to true, to disable caching
			 };
			
			 a1 = $(\'#query\').autocomplete(options);
			
			 $(\'#navigation a\').each(function() {
			 $(this).click(function(e) {
			 var element = $(this).attr(\'href\');
			 $(\'html\').animate({ scrollTop: $(element).offset().top }, 300, null, function() { document.location = element; });
			 e.preventDefault();
			 });
			 });
			
			 });
			
			//]]>
		</script>


		<div class="left-panel">

			<div style="height:54px;width:100%;clear:both;background-image: url('.THEMES.'templates/images/admin/left-search-bg.png);background-position:left top;margin: 0px;">

				<div style="width: auto; margin: 0px 7px 0px 25px;">

						<br />
	
						<div class="left-search-div">

							<form id="searchform" name="searchform" method="post" action="'.ADMIN.'search.php'.$aidlink.'">
		
							<input id="query" type="text" name="keyword" value="'.$locale['pro_1001'].'" class="left-search" onfocus="if(this.value==this.defaultValue) this.value=\'\';" />
		
							<input type="submit" name="search" value="" class="left-search-button" />
		
							</form>

						</div>
				</div>

			</div>';

			$panels = dbquery("SELECT * FROM ".DB_ADMINPANELS." WHERE panel_display='1' AND panel_side='3' ORDER BY panel_order ASC");
	
			if (dbrows($panels)) {
	
				if (isset($_GET['status']) && $_GET['status'] == 'sort') {
	
					echo '<ul id="admin-panels-side" style="list-style-type: none;margin:0;padding:0">';
	
				}
	
				while ($panel = dbarray($panels)) {
	
					if (isset($_GET['status']) && $_GET['status'] == 'sort') {
	
						echo '<li data-itemid="'.$panel['panel_id'].'">';
			
						echo '<div style="cursor:move;">';
	
					}
		
						include ADMIN."proadmin/".$panel['panel_file'];
			
					if (isset($_GET['status']) && $_GET['status'] == 'sort') {
	
						echo '</div>';
			
						echo '</li>';
	
					}
	
				}
	
				if (isset($_GET['status']) && $_GET['status'] == 'sort') {
	
					echo '</ul>';
				}
	
			}
	
echo '		<script type="text/javascript" src="'.INCLUDES.'fusionpro/jquery.dragsort-0.5.1.min.js"></script>
	
			<script type="text/javascript">
	
			    $("#admin-panels-side").dragsort({ dragSelector: "div", dragBetween: true, dragEnd: saveOrder, placeHolderTemplate: "<li class=\'placeHolderSide\'><div></div></li>" });
	
	
			    function saveOrder() {
	
					var dataside = $("#admin-panels-side li").map(function() { return $(this).data("itemid"); }).get();
	
			        $.post("'.ADMIN.'dashboard.php", { "side_panels[]": dataside });
	
			    };
	
		    </script>';

echo '	</div>

		<div class="center-panel">

			<div class="center-title">

				<div style="height:56px;margin-left:20px;float:left;">

					<img src="'.THEMES.'templates/images/admin/title-dash.gif" border="0" />';

					$navresult = dbquery("SELECT admin_title, admin_link FROM ".DB_ADMIN." WHERE admin_link='".FUSION_SELF."'");

					if (dbrows($navresult)) {

						$data2 = dbarray($navresult);

						echo '<b> '.$data2['admin_title'].'</b>';
						
					} else {

						echo '<b> '.$locale['pro_1007'].'</b>';

					}

echo '			</div>


				<div style="height:56px;float:right;margin-right:20px;line-height:50px">

					<div style="float:left;vertical-align:middle;height:36px;margin-top:15px"><img src="'.THEMES.'templates/images/admin/title-user.png" border="0" /></div>

					<div style="float:left;height:56px;margin-left:5px">';

						$members_registered = dbcount("(user_id)", DB_USERS, "user_status<='1' OR user_status='3' OR user_status='5'");

echo '					<div style="height:15px" align="center"><span style="font-weight:bold;font-size:14px;color:#ba6d6d"> '.$members_registered.'</span></div>

						<div style="height:15px">'.$locale['pro_1009'].'</div>

					</div>

				</div>

				<div style="width:2px;height:56px;float:right;margin-top:15px;margin-right:15px;"><img src="'.THEMES.'templates/images/admin/title-divider.gif" /></div>

				<div style="height:56px;float:right;margin-right:20px;line-height:50px">

					<div style="float:left;vertical-align:middle;height:36px;margin-top:15px"><img src="'.THEMES.'templates/images/admin/title-visit.png" border="0" /></div>

					<div style="float:left;height:56px;margin-left:5px">

						<div style="height:15px" align="center"><span style="font-weight:bold;font-size:14px;color:#6e97aa"> '.$settings['counter'].'</span></div>

						<div style="height:15px">'.$locale['pro_1008'].'</div>

					</div>

				</div>

			</div>

			<div class="center-navi">

				<div style="height:31px;margin-left:20px;float:left">

					<img src="'.THEMES.'templates/images/admin/navi-dash.png" border="0" />

					<a href="'.ADMIN.'dashboard.php'.$aidlink.'" class="dark"> <b>'.$locale['pro_1007'].'</b></a>

					<img src="'.THEMES.'templates/images/admin/navi-arrow.gif" /> ';

					if (isset($navi_name)) { echo $navi_name; }

					$navresult = dbquery("SELECT admin_title, admin_link FROM ".DB_ADMIN." WHERE admin_link='".FUSION_SELF."'");

					if (dbrows($navresult)) {

						$data2 = dbarray($navresult);

						echo $data2['admin_title'];
						
					}

echo '			</div>

			</div>

			<div class="center-main-area">

				'.U_CENTER.CONTENT.L_CENTER.'

			</div>

			<div class="bottom-footer">

				<div align="center">

					<br /><br />

					'.stripslashes($settings['footer']).'<br />

					Designed & Programmed by <a href="http://www.nilegraphic.com" target="_blank" title="Nile Graphic Web and Graphic Design">Nile Graphic</a><br />';

					if (!$license) { echo "\n".showcopyright(); }
				
echo '			</div>

			</div>

		</div>

	</div>
	';


	
	/*foreach ($mysql_queries_time as $query) {
		echo $query[0]." QUERY: ".$query[1]."<br />";
	}*/

}

/* New in v7.02 - render comments */
function render_comments($c_data, $c_info){
	global $locale, $settings;
	opentable($locale['c100']);
	if (!empty($c_data)){
		echo "<div class='comments floatfix'>\n";
			$c_makepagenav = '';
			if ($c_info['c_makepagenav'] !== FALSE) { 
			echo $c_makepagenav = "<div style='text-align:center;margin-bottom:5px;'>".$c_info['c_makepagenav']."</div>\n"; 
		}
			foreach($c_data as $data) {
	        $comm_count = "<a href='".FUSION_REQUEST."#c".$data['comment_id']."' id='c".$data['comment_id']."' name='c".$data['comment_id']."'>#".$data['i']."</a>";
			echo "<div class='tbl2 clearfix floatfix'>\n";
			if ($settings['comments_avatar'] == "1") { echo "<span class='comment-avatar'>".$data['user_avatar']."</span>\n"; }
	        echo "<span style='float:right' class='comment_actions'>".$comm_count."\n</span>\n";
			echo "<span class='comment-name'>".$data['comment_name']."</span>\n<br />\n";
			echo "<span class='small'>".$data['comment_datestamp']."</span>\n";
	if ($data['edit_dell'] !== false) { echo "<br />\n<span class='comment_actions'>".$data['edit_dell']."\n</span>\n"; }
			echo "</div>\n<div class='tbl1 comment_message'>".$data['comment_message']."</div>\n";
		}
		echo $c_makepagenav;
		if ($c_info['admin_link'] !== FALSE) {
			echo "<div style='float:right' class='comment_admin'>".$c_info['admin_link']."</div>\n";
		}
		echo "</div>\n";
	} else {
		echo $locale['c101']."\n";
	}
	closetable();   
}

function render_news($subject, $news, $info) {

	echo "<table cellpadding='0' cellspacing='0' width='100%'>\n<tr>\n";
	echo "<td class='capmain-left'></td>\n";
	echo "<td class='capmain'>".$subject."</td>\n";
	echo "<td class='capmain-right'></td>\n";
	echo "</tr>\n</table>\n";
	echo "<table width='100%' cellpadding='0' cellspacing='0' class='spacer'>\n<tr>\n";
	echo "<td class='main-body middle-border'>".$info['cat_image'].$news."</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td align='center' class='news-footer middle-border'>\n";
	echo newsposter($info," &middot;").newscat($info," &middot;").newsopts($info,"&middot;").itemoptions("N",$info['news_id']);
	echo "</td>\n";
	echo "</tr><tr>\n";
	echo "<td style='height:5px;background-color:#f6a504;'></td>\n";
	echo "</tr>\n</table>\n";

}

function render_article($subject, $article, $info) {
	
	echo "<table width='100%' cellpadding='0' cellspacing='0'>\n<tr>\n";
	echo "<td class='capmain-left'></td>\n";
	echo "<td class='capmain'>".$subject."</td>\n";
	echo "<td class='capmain-right'></td>\n";
	echo "</tr>\n</table>\n";
	echo "<table width='100%' cellpadding='0' cellspacing='0' class='spacer'>\n<tr>\n";
	echo "<td class='main-body middle-border'>".($info['article_breaks'] == "y" ? nl2br($article) : $article)."</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td align='center' class='news-footer'>\n";
	echo articleposter($info," &middot;").articlecat($info," &middot;").articleopts($info,"&middot;").itemoptions("A",$info['article_id']);
	echo "</td>\n</tr>\n</table>\n";

}

function opentable($title) {

	echo '<div class="table-top"><div style="float:left">&nbsp;&nbsp;&nbsp;'.$title.'</div>';

	if (FUSION_SELF == "dashboard.php") {

		echo '<div style="float:right;margin-right: 10px;margin-top:10px"><div id="switch_'.str_replace(" ", "_", $title).'"></div></div>';

		echo '<div id="space_'.str_replace(" ", "_", $title).'" style="display:none"><br /></div>';
	
		echo '<script type="text/javascript">
	
			$(\'#switch_'.str_replace(" ", "_", $title).'\').iphoneSwitch("on", 
		
		     function() {
	
				$("#div_'.str_replace(" ", "_", $title).'").fadeIn("slow");
	
				document.getElementById(\'space_'.str_replace(" ", "_", $title).'\').style.display = \'none\'; 
		
				$.post("'.ADMIN.'dashboard.php", { "switchdata": "1_'.str_replace(" ", "_", $title).'" });
		
		      },
		      function() {
		
				$("#div_'.str_replace(" ", "_", $title).'").fadeOut("slow");
	
				document.getElementById(\'space_'.str_replace(" ", "_", $title).'\').style.display = \'block\'; 
	
				$.post("'.ADMIN.'dashboard.php", { "switchdata": "0_'.str_replace(" ", "_", $title).'" });
	
		      },
		
		      {
		
		        switch_on_container_path: \''.THEMES.'templates/images/admin/iphone_switch_container_off.png\'
		
		      });
	
		</script>';

	}

 	echo '</div>';

	echo '<div id="div_'.str_replace(" ", "_", $title).'">';

	echo "<div class='table-main-body'>\n";

	echo '<div style="width:auto; height:auto; margin-left:5px; margin-right:5px; display: block; margin-bottom:5px">';

	echo '<br /></div>';

}

function closetable() {

	echo "<br /></div>\n";

	echo "</div>\n";

}

function opentidetable($title) {

	echo '<div class="table-top"><div style="float:left">&nbsp;&nbsp;&nbsp;'.$title.'</div>';

	if (FUSION_SELF == "dashboard.php") {

		echo '<div style="float:right;margin-right: 10px;margin-top:10px"><div id="switch_'.str_replace(" ", "_", $title).'"></div></div>';
	
		echo '<div id="space_'.str_replace(" ", "_", $title).'" style="display:none"><br /></div>';
	
		echo '<script type="text/javascript">
	
			$(\'#switch_'.str_replace(" ", "_", $title).'\').iphoneSwitch("on", 
		
		     function() {
	
				$("#div_'.str_replace(" ", "_", $title).'").fadeIn("slow");
	
				document.getElementById(\'space_'.str_replace(" ", "_", $title).'\').style.display = \'none\'; 
		
				$.post("'.ADMIN.'dashboard.php", { "switchdata": "1_'.str_replace(" ", "_", $title).'" });
		
		      },
		      function() {
		
				$("#div_'.str_replace(" ", "_", $title).'").fadeOut("slow");
	
				document.getElementById(\'space_'.str_replace(" ", "_", $title).'\').style.display = \'block\'; 
	
				$.post("'.ADMIN.'dashboard.php", { "switchdata": "0_'.str_replace(" ", "_", $title).'" });
	
		      },
		
		      {
		
		        switch_on_container_path: \''.THEMES.'templates/images/admin/iphone_switch_container_off.png\'
		
		      });
	
		</script>';

	}

	echo '</div>';

	echo '<div id="div_'.str_replace(" ", "_", $title).'">';

	echo "<div class='table-main-body'>\n";

	echo '<div style="width:auto; height:auto;">';

}

function closetidetable() {

	echo "</div>\n";

	echo "</div>\n";

	echo "</div>";

}

function openside($title) {

	
echo '<div style="width:100%;clear:both;background-image:url('.THEMES.'templates/images/admin/left-avatar-bg.png);background-repeat: repeat-x;margin: 0px; background-position: left bottom">';

echo '<div style="width:100%;height:1px;background-color: #545454;"> </div>';
	
echo '<div style="width: auto;margin: 0px 7px 0px 7px;">';
	
echo '<br /><font style="font-size:13px;"><b>'.$title.'</b></font><br /><br />';
	
}

function closeside() {
	
echo '<br /></div>';
	
echo '</div>';

}
?>
