<?php
if (!defined("IN_FUSION") || !iSUPERADMIN) {die();}
$secsys_version = "1.9.0";
$secsys_current_version=$sys_setting['version'];

$op = isset($_REQUEST['op']) && is_string($_REQUEST['op']) ? $_REQUEST['op'] : "start";
if (str_replace(".","",$secsys_current_version)<str_replace(".","",$secsys_version)) {


function secsys_mysql_field_exists($table,$field) {
    $fields = dbquery("SHOW COLUMNS FROM ".DB_PREFIX.$table);
	$found = false; $flags=array();$i=0;
	if (dbrows($fields)) {
	while($flags=dbarray($fields)) {
if (in_array($field,$flags)) {$found=true;} 
    }
    }
return $found;
} 

function secsys_mysql_table_exists($table) {
    $tables = dbquery("SHOW TABLES");
$found = false; $flags=array();$i=0;
	if (dbrows($tables)) {
    while($flags=dbarray($tables)) {
if (in_array(DB_PREFIX.$table,$flags)) {$found=true;} 
    }
    }
return $found;
} 
if (!secsys_mysql_table_exists("secsys_blacklist")) {
$mysql[] = "CREATE TABLE IF NOT EXISTS ".DB_PREFIX."secsys_blacklist (
  blacklist_ip varchar(15) NOT NULL DEFAULT '0.0.0.0',
  blacklist_datestamp int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (blacklist_ip)
) TYPE=MyISAM;";
}
if (!secsys_mysql_table_exists("secsys_proxy_blacklist")) {
$mysql[] = "CREATE TABLE IF NOT EXISTS ".DB_PREFIX."secsys_proxy_blacklist (
  proxy_id int(11) unsigned NOT NULL AUTO_INCREMENT,
  proxy_ip varchar(15) NOT NULL DEFAULT '0.0.',
  proxy_datestamp int(11) unsigned NOT NULL,
  PRIMARY KEY (proxy_id)
) TYPE=MyISAM;";
}

if (!secsys_mysql_table_exists("secsys_proxy_whitelist")) {
$mysql[] = "CREATE TABLE IF NOT EXISTS ".DB_PREFIX."secsys_proxy_whitelist (
  proxy_id int(11) unsigned NOT NULL AUTO_INCREMENT,
  proxy_ip varchar(15) NOT NULL DEFAULT '0.0.',
  proxy_datestamp int(11) unsigned NOT NULL,
  proxy_status TINYINT(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (proxy_id)
) TYPE=MyISAM;";
}

// Update der Einstellungen
if (!secsys_mysql_field_exists("secsys_settings","secsys_started")) {	
	$mysql[] = "ALTER TABLE ".DB_PREFIX."secsys_settings ADD secsys_started TINYINT(1) UNSIGNED NOT NULL DEFAULT '1' FIRST;";
	}
	if (!secsys_mysql_field_exists("secsys_settings","proxy_visit")) {	
$mysql[] = "ALTER TABLE ".DB_PREFIX."secsys_settings ADD proxy_visit TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER secsys_started";
	}
	if (!secsys_mysql_field_exists("secsys_settings","proxy_register")) {	
$mysql[] = "ALTER TABLE ".DB_PREFIX."secsys_settings ADD proxy_register TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER proxy_visit";
	}
	if (!secsys_mysql_field_exists("secsys_settings","proxy_login")) {	
$mysql[] = "ALTER TABLE ".DB_PREFIX."secsys_settings ADD proxy_login TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER proxy_register";
	}
	if (!secsys_mysql_field_exists("secsys_settings","ctracker_log")) {	
$mysql[] = "ALTER TABLE ".DB_PREFIX."secsys_settings ADD ctracker_log TINYINT(1) UNSIGNED NOT NULL DEFAULT '1' AFTER gb_access";
	}
	if (!secsys_mysql_field_exists("secsys_settings","filter_log")) {	
$mysql[] = "ALTER TABLE ".DB_PREFIX."secsys_settings ADD filter_log TINYINT(1) UNSIGNED NOT NULL DEFAULT '1' AFTER ctracker_log";
	}				
	if (!secsys_mysql_field_exists("secsys_settings","spam_log")) {	
$mysql[] = "ALTER TABLE ".DB_PREFIX."secsys_settings ADD spam_log TINYINT(1) UNSIGNED NOT NULL DEFAULT '1' AFTER filter_log";
	}
	if (!secsys_mysql_field_exists("secsys_settings","flood_log")) {	
$mysql[] = "ALTER TABLE ".DB_PREFIX."secsys_settings ADD flood_log TINYINT(1) UNSIGNED NOT NULL DEFAULT '1' AFTER spam_log";
	}
	if (!secsys_mysql_field_exists("secsys_settings","proxy_log")) {	
$mysql[] = "ALTER TABLE ".DB_PREFIX."secsys_settings ADD proxy_log TINYINT(1) UNSIGNED NOT NULL DEFAULT '1' AFTER flood_log";
	}
	if (!secsys_mysql_field_exists("secsys_settings","log_autodelete")) {	
$mysql[] = "ALTER TABLE ".DB_PREFIX."secsys_settings ADD log_autodelete TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER proxy_log";
	}
	if (!secsys_mysql_field_exists("secsys_settings","log_max")) {	
$mysql[] = "ALTER TABLE ".DB_PREFIX."secsys_settings ADD log_max SMALLINT(5) UNSIGNED NOT NULL DEFAULT '200' AFTER log_autodelete";
	}
	if (!secsys_mysql_field_exists("secsys_settings","log_expired")) {	
$mysql[] = "ALTER TABLE ".DB_PREFIX."secsys_settings ADD log_expired SMALLINT(5) UNSIGNED NOT NULL DEFAULT '30' AFTER log_max";
	}

// Update der Statistiken
	if (!secsys_mysql_field_exists("secsys_statistics","proxy_visit")) {	
$mysql[] = "ALTER TABLE ".DB_PREFIX."secsys_statistics ADD proxy_visit INT(11) UNSIGNED NOT NULL DEFAULT '0' AFTER spams";
	}
	if (!secsys_mysql_field_exists("secsys_statistics","proxy_login")) {	
$mysql[] = "ALTER TABLE ".DB_PREFIX."secsys_statistics ADD proxy_login INT(11) UNSIGNED NOT NULL DEFAULT '0' AFTER proxy_visit";
	}
	if (!secsys_mysql_field_exists("secsys_statistics","proxy_register")) {	
$mysql[] = "ALTER TABLE ".DB_PREFIX."secsys_statistics ADD proxy_register INT(11) UNSIGNED NOT NULL DEFAULT '0' AFTER proxy_login";
	}
	if (!secsys_mysql_field_exists("secsys_statistics","proxy_blacklist")) {	
$mysql[] = "ALTER TABLE ".DB_PREFIX."secsys_statistics ADD proxy_blacklist INT(11) UNSIGNED NOT NULL DEFAULT '0' AFTER proxy_register";
	}
$mysql[] = "ALTER TABLE ".DB_PREFIX."secsys_settings CHANGE version version VARCHAR(15)  NOT NULL";	
$mysql[] = "UPDATE ".DB_PREFIX."secsys_settings SET version='$secsys_version'";

// Update der Infusions und Amdin-Tabelle
$mysql[] = "UPDATE ".DB_PREFIX."infusions SET inf_version='$secsys_version' WHERE inf_folder='security_system'";
$mysql[] = "UPDATE ".DB_PREFIX."admin SET admin_link='../infusions/security_system/admin/index.php' WHERE admin_title LIKE '".$locale['SYS100']."'";



switch($op) {
case "start":
opentable("<font color='red'>".$locale['SUPD100']."</font>");
if (!empty($mysql)) {
echo "<div style='font-size:13px;'><ol>";
$nextlink="";
echo "<ol>";
foreach($mysql as $query) {
	echo "<li><code>".$query."</code></li>\n";
}
echo "</ol></div>\n";
echo "<form method='get' action='".FUSION_SELF."'>\n";
echo "<input type='hidden' name='pagefile' value='update'><input type='hidden' name='op' value='step1'>
<input type='hidden' name='do_update' value='1'><input type='submit' class='button' value='Schritt 1 / Step 1'>\n";
echo "</form>\n";	
} else {
echo "<form method='get' action='".FUSION_SELF."'>\n";	
echo "<input type='hidden' name='op' value='step2'><input type='submit' class='button' value='Schritt 2 / Step 2'>
</form>\n";	
}
closetable();
break;
case "step1":
opentable("<font color='red'>".$locale['SUPD100']."</font>");
echo "<div style='font-size:13px;'><ol>\n";
$res = "";
$errors = 0;
$nextlink="";
echo "<ol>";
$res = "";
$errors = 0;
foreach($mysql as $query) {
	if($do_update) {
		if(dbquery($query)) {
			$res = "<span class='small2'>OK</span>";
		} else {
			++$errors;
			$res = "<b>FEHLER/ERROR!</b>";
		}
		$res .= " - ";
	}
	echo "<li><code>".$res.$query."</code></li>\n";
}
echo "</ol></div>\n";

if($do_update) {
	if($errors) {
		echo "ERRORS: $errors <br>";
		echo "Check your database!<br>";
		die("<b>Fehler!</b>");
	} else {
		echo "<p><b>".$locale['SUBD102']."</b></p>";
	}
} 
closetable();
break;
}
} else {
function secsys_new_version()
{
	$url = "http://update.bs-fusion.de/security_system/version.txt";
	$url_p = @parse_url($url);
	$host = $url_p['host'];
	$port = isset($url_p['port']) ? $url_p['port'] : 80;
	$fp = @fsockopen($url_p['host'], $port, $errno, $errstr, 5);
	if(!$fp) return false;
	@fputs($fp, 'GET '.$url_p['path'].' HTTP/1.1'.chr(10));
	@fputs($fp, 'HOST: '.$url_p['host'].chr(10));
	@fputs($fp, 'Connection: close'.chr(10).chr(10));
	$response = @fgets($fp, 1024);
	$content = @fread($fp,1024);
	$content = preg_replace("#(.*?)text/plain(.*?)$#is","$2",$content);
	@fclose ($fp);
	if(preg_match("#404#",$response)) return "Timeout";
	else return trim(str_replace("X-Pad: avoid browser bug","",$content));
}	
$newversion=str_replace("X-Pad: avoid browser bug","",secsys_new_version());
$new_version=$newversion!="Timeout" && intval(str_replace(".","",$newversion)) > intval(str_replace(".","",$secsys_version)) ? true : false; 
if ($new_version) {
	opentable($locale['SUBD105']);
	echo $locale['SUBD106']." <a href='http://www.bs-fusion.de/infusions/pro_download_panel/download.php?catid=22' target='_blank'>BS-Fusion Security System</a> <font style='font-size:11px;'><i><b>v".str_replace("X-Pad: avoid browser bug","",$newversion)."</b></i></font>";
       closetable(); 
} elseif ($newversion=="Timeout") {
	opentable($locale['SUBD105']);
	echo $locale['SUBD111']." <a href='http://www.bs-fusion.de/infusions/pro_download_panel/download.php?catid=22' target='_blank'>BS-Fusion Security System</a>";
	closetable();
} else {
	opentable($locale['SUBD103']);
	echo $locale['SUBD104'];
	closetable();
}
	
}	
?>