<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion_db.php
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

if (!defined("IN_FUSION")) { die("Access Denied"); }

if(!defined("DB_KON")) { define("DB_KON", DB_PREFIX."va_kontakt"); }
if(!defined("DB_IMP")) { define("DB_IMP", DB_PREFIX."va_imp"); }
if(!defined("DB_HAFT")) { define("DB_HAFT", DB_PREFIX."va_haft"); }
?>