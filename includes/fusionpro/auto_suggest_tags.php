<?php

require_once "../../maincore.php";

$counter='0';
echo "{";
echo "query:'$query',";
echo "suggestions:[";
$res = dbquery("SELECT admin_id, admin_title, admin_page, admin_rights, admin_link FROM ".DB_ADMIN." WHERE admin_title LIKE '$query%' ORDER BY admin_title ASC");
while ($row = dbarray($res)) {
if ($row['admin_link'] != "reserved" && checkrights($row['admin_rights'])) {
$counter++;
if ($counter > 1) {
echo ",";
}
$name=$row["admin_title"];
echo "'$name'";
}
}
echo "],}";
?>
