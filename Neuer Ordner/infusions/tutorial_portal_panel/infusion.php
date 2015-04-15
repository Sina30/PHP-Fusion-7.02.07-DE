<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion.php
| Author: matze
| Lizenz: CCL v1.0
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

include INFUSIONS."tutorial_portal_panel/infusion_db.php";

if (file_exists(INFUSIONS."tutorial_portal_panel/locale/".$settings['locale'].".php")) {
    include INFUSIONS."tutorial_portal_panel/locale/".$settings['locale'].".php";
} else {
    include INFUSIONS."tutorial_portal_panel/locale/German.php";
}

$inf_title = $locale['translation_title'];
$inf_version = "1.2";
$inf_developer = "matze";
$inf_weburl = "http://fusion-mods.de";
$inf_email = "matt41@live.de";
$inf_folder = "tutorial_portal_panel";
$inf_description = $locale['translation_desc'];

$inf_newtable[1] = DB_FUSION_TUTORIAL." (
  tut_id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  tut_author MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  tut_name varchar(50) NOT NULL default '',
  tut_kosten_cur varchar(50) NOT NULL default '',
  tut_lizenz TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL,
  tut_kosten varchar(255) NOT NULL default '',
  tut_file VARCHAR(100) NOT NULL DEFAULT '',
  tut_fcount INT(10) UNSIGNED NOT NULL DEFAULT '0',
  tut_cat mediumint(8) unsigned NOT NULL default '0',
  tut_access TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL,
  tut_dlaccess TINYINT(3) unsigned NOT NULL default '0',
  tut_allow_comments TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL,
  tut_allow_ratings TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL,
  tut_hideauthor TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL,
  tut_author_notice TEXT NOT NULL,
  tut_releasetype CHAR(3) DEFAULT 'NS' NOT NULL,
  tut_created INT(10) UNSIGNED NOT NULL default '0',
  tut_updated INT(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (tut_id),
  KEY (tut_name)
) ENGINE = MyISAM;";

$inf_newtable[2] = DB_FUSION_TUTORIAL_LOGSYS." (
	trans_id INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
	tuserid INT(8) UNSIGNED NOT NULL DEFAULT '0',
	tdid INT(8) UNSIGNED NOT NULL DEFAULT '0',
	tdatum INT(11) UNSIGNED NOT NULL DEFAULT '0',
	tdb SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (trans_id)
) ENGINE=MyISAM;";

$inf_newtable[3] = DB_FUSION_TUTORIAL_CATS." (
  tut_cat_id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  tut_cat_name VARCHAR(50) NOT NULL DEFAULT '',
  addon_name VARCHAR(100) NOT NULL DEFAULT '',
  tut_cat_description TEXT NOT NULL,
  tut_cat_image VARCHAR(100) NOT NULL default '',
  tut_cat_sorting VARCHAR(50) NOT NULL default 'tut_name ASC',
  tut_cat_access TINYINT(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (tut_cat_id),
  KEY (tut_cat_name)
) ENGINE = MyISAM;";

$inf_newtable[4] = DB_FUSION_TUTORIAL_SETTINGS." (
  tut_perpage VARCHAR(10) NOT NULL DEFAULT '10',
  tut_cats_perpage VARCHAR(10) NOT NULL DEFAULT '10',
  tut_cats_colum TINYINT(1) UNSIGNED NOT NULL DEFAULT '3',
  tut_colum TINYINT(1) UNSIGNED NOT NULL DEFAULT '2',
  tut_comments TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
  tut_access TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  tut_log_on TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  tut_ftypes VARCHAR(200) NOT NULL DEFAULT '.zip,.rar,.tar,.bz2,.7z',
  tut_fmaxsize INT(12) UNSIGNED NOT NULL DEFAULT '4200000'
) ENGINE = MyISAM;";


$inf_droptable[1] = DB_FUSION_TUTORIAL;
$inf_droptable[2] = DB_FUSION_TUTORIAL_LOGSYS;
$inf_droptable[3] = DB_FUSION_TUTORIAL_CATS;
$inf_droptable[4] = DB_FUSION_TUTORIAL_SETTINGS;

$inf_insertdbrow[1] = DB_PANELS." (panel_name, panel_filename, panel_side, panel_order, panel_type, panel_access, panel_display, panel_status) VALUES('".$locale['translation_title']."', 'tutorial_portal_panel', '2', '3', 'file', '0', '0', '1')";
$inf_insertdbrow[2] = DB_FUSION_TUTORIAL_SETTINGS." (tut_perpage, tut_cats_perpage, tut_cats_colum, tut_colum, tut_comments, tut_access, tut_log_on,
tut_ftypes, tut_fmaxsize)VALUES('1', '1', '2', '2', '1', '1', '1','.zip,.rar,.tar,.bz2,.7z', '1500000')";
$inf_insertdbrow[3] = DB_FUSION_TUTORIAL_CATS." (tut_cat_name, addon_name, tut_cat_description, tut_cat_sorting, tut_cat_image, tut_cat_access) VALUES ('Fusion 7.02', 'Infusion', '', 'tut_name ASC', '1.png', '0')";
$inf_insertdbrow[4] = DB_FUSION_TUTORIAL_CATS." (tut_cat_name, addon_name, tut_cat_description, tut_cat_sorting, tut_cat_image, tut_cat_access) VALUES ('Fusion 7.02', 'Panels', '', 'tut_name ASC', '2.png', '0')";
$inf_insertdbrow[5] = DB_FUSION_TUTORIAL_REG." SET conf = '1',  dat_dom = 'fusionmods', inf_name = '', site_url = '' ";

$inf_deldbrow[1] = DB_PANELS." WHERE panel_filename='tutorial_portal_panel'";
$inf_deldbrow[2] = DB_COMMENTS." WHERE comment_type='TR'";
$inf_deldbrow[3] = DB_COMMENTS." WHERE comment_type='PP'";
$inf_deldbrow[4] = DB_RATINGS." WHERE rating_type='J'";


$inf_adminpanel[1] = array(
    "title" => $locale['translation_admin'], 
    "image" => "translate.png",
    "panel" => "admin/translations_admin.php", 
    "rights" => "TUTP" 
);

$inf_sitelink[1] = array(
	"title" => "Tutorial-Portal",
	"url" => "translations.php",
	"visibility" => "0"
);

?>