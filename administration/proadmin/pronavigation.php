<?php

/*-------------------------------------------------------+

| PHP-Fusion Content Management System

| Copyright  2002 - 2009 Nick Jones

| http://www.php-fusion.co.uk/

+--------------------------------------------------------+

| Filename: pronavigation.php

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

			$hour = time()+3600;

			if (isset($_COOKIE['navigation']) && $_COOKIE['navigation'] !="") { $navcookie=$_COOKIE['navigation']; } else { $navcookie=-1; }

			$ul_close = FALSE;

			$starter = 1;

echo '		<div><ul id="navigation" style="list-style-type: none; margin: 0px; padding: 0px;" class="menu noaccordion">

				<li><a href="'.ADMIN.'dashboard.php'.$aidlink.'" style="cursor:pointer;" onclick="window.open (\''.ADMIN.'dashboard.php'.$aidlink.'\',\'_self\',false);">

					<div style="height:36px;width:100%;clear:both;background-image:url('.THEMES.'templates/images/admin/left-content-bg.png);background-repeat: repeat-x;margin: 0px;">
		
						<div style="width: auto;margin: 0px 7px 0px 7px;line-height:300%">
		
							<img src="'.THEMES.'templates/images/admin/dashboard.gif" border="0" /> &nbsp;&nbsp;'.$locale['pro_1007'].'
		
						</div>
		
					</div>

				</a></li>

			</ul></div>

			<div><ul id="navigation" style="list-style-type: none; margin: 0px; padding: 0px;" class="menu noaccordion">

				<li><a style="cursor:pointer;" onclick="cookieyaz(1);">

					<div style="height:36px;width:100%;clear:both;background-image:url('.THEMES.'templates/images/admin/left-content-bg.png);background-repeat: repeat-x;margin: 0px;">
		
						<div style="width: auto;margin: 0px 7px 0px 7px;line-height:300%">
		
							<img src="'.THEMES.'templates/images/admin/content.gif" border="0" /> &nbsp;&nbsp;'.$locale['pro_1002'].'
		
						</div>
		
					</div>

				</a>';


echo '			<ul'.($navcookie==1?" id='soul'":"").'>';

					$adresult = dbquery("SELECT admin_id, admin_title, admin_page, admin_rights, admin_link FROM ".DB_ADMIN." WHERE admin_page='1' ORDER BY admin_title ASC");

					if (dbrows($adresult)) {

					$ul_close = TRUE;
					
						while ($data1 = dbarray($adresult)) {		
						
							if ($data1['admin_link'] != "reserved" && checkrights($data1['admin_rights'])) {
	
								if (isset($_COOKIE["menu"]) && ($_COOKIE["menu"] == $data1['admin_id'])) { $menu1 = ' style="background-color: #4f4d4c;color: #dad7d7;line-height:200%"'; setcookie("menu", "", time()-3700); } else { $menu1 = ' style="color: #fff;line-height:200%"'; }
	
								echo '<li onclick="setCookie(\'menu\',\''.$data1['admin_id'].'\',\''.$hour.'\')"'.$menu1.'><a href="'.ADMIN.$data1['admin_link'].$aidlink.'" class="grey">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.THEME_BULLET.' '.preg_replace("/&(?!(#\d+|\w+);)/", "&amp;", $data1['admin_title']).'</a></li>';
						
							}
						
						}

					$ul_close = FALSE;

					}
		
echo '				
				</ul></li>
	
			</ul></div>
	
			<div><ul id="navigation" style="list-style-type: none; margin: 0px; padding: 0px;" class="menu noaccordion">

				<li><a style="cursor:pointer;" onclick="cookieyaz(2);">

					<div style="height:36px;width:100%;clear:both;background-image:url('.THEMES.'templates/images/admin/left-content-bg.png);background-repeat: repeat-x;margin: 0px;">
		
						<div style="width: auto;margin: 0px 7px 0px 7px;line-height:300%">
		
							<img src="'.THEMES.'templates/images/admin/user.gif" border="0" /> &nbsp;&nbsp;'.$locale['pro_1003'].'
		
						</div>
		
					</div>

				</a>';


echo '			<ul'.($navcookie==2?" id='soul'":"").'>';

					$adresult = dbquery("SELECT admin_title, admin_page, admin_rights, admin_link FROM ".DB_ADMIN." WHERE admin_page='2' ORDER BY admin_title ASC");

					if (dbrows($adresult)) {

					$ul_close = TRUE;
					
						while ($data1 = dbarray($adresult)) {		
						
							if ($data1['admin_link'] != "reserved" && checkrights($data1['admin_rights'])) {
	
								echo '<li style="line-height:200%"><a href="'.ADMIN.$data1['admin_link'].$aidlink.'" class="grey">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.THEME_BULLET.' '.preg_replace("/&(?!(#\d+|\w+);)/", "&amp;", $data1['admin_title']).'</a></li>';
						
							}
						
						}

					$ul_close = FALSE;
		
					}
echo '
	
				</ul></li>
	
			</ul></div>

			<div><ul id="navigation" style="list-style-type: none; margin: 0px; padding: 0px;" class="menu noaccordion">

				<li><a style="cursor:pointer;" onclick="cookieyaz(3);">

					<div style="height:36px;width:100%;clear:both;background-image:url('.THEMES.'templates/images/admin/left-content-bg.png);background-repeat: repeat-x;margin: 0px;">
		
						<div style="width: auto;margin: 0px 7px 0px 7px;line-height:300%">
		
							<img src="'.THEMES.'templates/images/admin/system.gif" border="0" /> &nbsp;&nbsp;'.$locale['pro_1004'].'
		
						</div>
		
					</div>

				</a>';


echo '			<ul'.($navcookie==3?" id='soul'":"").'>';

					$adresult = dbquery("SELECT admin_title, admin_page, admin_rights, admin_link FROM ".DB_ADMIN." WHERE admin_page='3' ORDER BY admin_title ASC");

					if (dbrows($adresult)) {

					$ul_close = TRUE;
					
						while ($data1 = dbarray($adresult)) {		
						
							if ($data1['admin_link'] != "reserved" && checkrights($data1['admin_rights'])) {
	
								echo '<li style="line-height:200%"><a href="'.ADMIN.$data1['admin_link'].$aidlink.'" class="grey">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.THEME_BULLET.' '.preg_replace("/&(?!(#\d+|\w+);)/", "&amp;", $data1['admin_title']).'</a></li>';
						
							}
						
						}

					$ul_close = FALSE;
			
					}
echo '
	
				</ul></li>
	
			</ul></div>

			<div><ul id="navigation" style="list-style-type: none; margin: 0px; padding: 0px;" class="menu noaccordion">

				<li><a style="cursor:pointer;" onclick="cookieyaz(4);">

					<div style="height:36px;width:100%;clear:both;background-image:url('.THEMES.'templates/images/admin/left-content-bg.png);background-repeat: repeat-x;margin: 0px;">
		
						<div style="width: auto;margin: 0px 7px 0px 7px;line-height:300%">
		
							<img src="'.THEMES.'templates/images/admin/setting.gif" border="0" /> &nbsp;&nbsp;'.$locale['pro_1005'].'
		
						</div>
		
					</div>

				</a>';


echo '			<ul'.($navcookie==4?" id='soul'":"").'>';

					$adresult = dbquery("SELECT admin_title, admin_page, admin_rights, admin_link FROM ".DB_ADMIN." WHERE admin_page='4' ORDER BY admin_title ASC");

					if (dbrows($adresult)) {

					$ul_close = TRUE;
					
						while ($data1 = dbarray($adresult)) {		
						
							if ($data1['admin_link'] != "reserved" && checkrights($data1['admin_rights'])) {
	
								echo '<li style="line-height:200%"><a href="'.ADMIN.$data1['admin_link'].$aidlink.'" class="grey">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.THEME_BULLET.' '.preg_replace("/&(?!(#\d+|\w+);)/", "&amp;", $data1['admin_title']).'</a></li>';
						
							}
						
						}

					$ul_close = FALSE;

					}
echo '
	
				</ul></li>
	
			</ul></div>

			<div><ul id="navigation" style="list-style-type: none; margin: 0px; padding: 0px;" class="menu noaccordion">

				<li><a style="cursor:pointer;" onclick="cookieyaz(5);">

					<div style="height:36px;width:100%;clear:both;background-image:url('.THEMES.'templates/images/admin/left-content-bg.png);background-repeat: repeat-x;margin: 0px;">
		
						<div style="width: auto;margin: 0px 7px 0px 7px;line-height:300%">
		
							<img src="'.THEMES.'templates/images/admin/infustion.gif" border="0" /> &nbsp;&nbsp;'.$locale['pro_1006'].'
		
						</div>
		
					</div>

				</a>';


echo '			<ul'.($navcookie==5?" id='soul'":"").'>';

					$adresult = dbquery("SELECT admin_title, admin_page, admin_rights, admin_link FROM ".DB_ADMIN." WHERE admin_page='5' ORDER BY admin_title ASC");

					if (dbrows($adresult)) {

					$ul_close = TRUE;
					
						while ($data1 = dbarray($adresult)) {		
						
							if ($data1['admin_link'] != "reserved" && checkrights($data1['admin_rights'])) {
	
								echo '<li style="line-height:200%"><a href="'.ADMIN.$data1['admin_link'].$aidlink.'" class="grey">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.THEME_BULLET.' '.preg_replace("/&(?!(#\d+|\w+);)/", "&amp;", $data1['admin_title']).'</a></li>';
						
							}
						
						}

					$ul_close = FALSE;

					}
echo '
	
				</ul></li>
	
			</ul></div>';
?>