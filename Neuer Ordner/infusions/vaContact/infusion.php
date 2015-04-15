<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion.php
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

include INFUSIONS."vaContact/infusion_db.php";

$inf_title = "Kontaktsystem v11.1";
$inf_description = "Modul der nextPowertools v11.0";
$inf_version = "11.1";
$inf_developer = "Markus Varnei";
$inf_email = "markus@varnei.de";
$inf_weburl = "http://www.coretraxx.de";
$inf_folder = "vaContact";

$inf_newtable[1] = DB_KON." (
konid INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
anliegen VARCHAR(100) NOT NULL default '',
PRIMARY KEY (konid)
) ";

$inf_newtable[2] = DB_IMP." (
impid INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
ueberschrift varchar(200) NOT NULL default '',
vorname varchar(200) NOT NULL default '',
nachname varchar(200) NOT NULL default '',
anschrift varchar(200) NOT NULL default '',
plzort varchar(200) NOT NULL default '',
telefon varchar(200) NOT NULL default '',
tel_info varchar(200) NOT NULL default '',
fax varchar(200) NOT NULL default '',
fax_info varchar(200) NOT NULL default '',
email varchar(200) NOT NULL default '',
switch1 varchar(200) NOT NULL default '',
switch2 varchar(200) NOT NULL default '',
PRIMARY KEY (impid)
) ";

$inf_newtable[3] = DB_HAFT." (
haftid INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
inhalt TEXT NOT NULL default '',
verweise TEXT NOT NULL default '',
urheber TEXT NOT NULL default '',
datenschutz TEXT NOT NULL default '',
recht TEXT NOT NULL default '',
info TEXT NOT NULL default '',
switch1 varchar(200) NOT NULL default '',
switch2 varchar(200) NOT NULL default '',
switch3 varchar(200) NOT NULL default '',
switch4 varchar(200) NOT NULL default '',
switch5 varchar(200) NOT NULL default '',
switch6 varchar(200) NOT NULL default '',
PRIMARY KEY (haftid)
) ";

$inf_insertdbrow[1] = DB_HAFT." (inhalt, verweise, urheber, datenschutz, recht, info, switch1, switch2, switch3, switch4, switch5, switch6) VALUES ('Der Autor &uuml;bernimmt keinerlei Gew&auml;hr f&uuml;r die Aktualit&auml;t, Korrektheit, Vollst&auml;ndigkeit oder Qualit&auml;t der bereitgestellten Informationen. Haftungsanspr&uuml;che gegen den Autor, welche sich auf Sch&auml;den materieller oder ideeller Art beziehen, die durch die Nutzung oder Nichtnutzung der dargebotenen Informationen bzw. durch die Nutzung fehlerhafter und unvollst&auml;ndiger Informationen verursacht wurden, sind grunds&auml;tzlich ausgeschlossen, sofern seitens des Autors kein nachweislich vors&auml;tzliches oder grob fahrl&auml;ssiges Verschulden vorliegt. Alle Angebote sind freibleibend und unverbindlich. Der Autor beh&auml;lt es sich ausdr&uuml;cklich vor, Teile der Seiten oder das gesamte Angebot ohne gesonderte Ank&uuml;ndigung zu ver&auml;ndern, zu erg&auml;nzen, zu l&ouml;schen oder die Ver&ouml;ffentlichung zeitweise oder endg&uuml;ltig einzustellen.', 'Bei direkten oder indirekten Verweisen auf fremde Webseiten (Hyperlinks), die au&szlig;erhalb des Verantwortungsbereiches des Autors liegen, w&uuml;rde eine Haftungsverpflichtung ausschlie&szlig;lich in dem Fall in Kraft treten, in dem der Autor von den Inhalten Kenntnis hat und es ihm technisch m&ouml;glich und zumutbar w&auml;re, die Nutzung im Falle rechtswidriger Inhalte zu verhindern. Der Autor erkl&auml;rt hiermit ausdr&uuml;cklich, dass zum Zeitpunkt der Linksetzung keine illegalen Inhalte auf den zu verlinkenden Seiten erkennbar waren. Auf die aktuelle und zuk&uuml;nftige Gestaltung, die Inhalte oder die Urheberschaft der verlinkten/verkn&uuml;pften Seiten hat der Autor keinerlei Einfluss. Deshalb distanziert er sich hiermit ausdr&uuml;cklich von allen Inhalten aller verlinkten /verkn&uuml;pften Seiten, die nach der Linksetzung ver&auml;ndert wurden. Diese Feststellung gilt f&uuml;r alle innerhalb des eigenen Internetangebotes gesetzten Links und Verweise sowie f&uuml;r Fremdeintr&auml;ge in vom Autor eingerichteten G&auml;steb&uuml;chern, Diskussionsforen, Linkverzeichnissen, Mailinglisten und in allen anderen Formen von Datenbanken, auf deren Inhalt externe Schreibzugriffe m&ouml;glich sind. F&uuml;r illegale, fehlerhafte oder unvollst&auml;ndige Inhalte und insbesondere f&uuml;r Sch&auml;den, die aus der Nutzung oder Nichtnutzung solcherart dargebotener Informationen entstehen, haftet allein der Anbieter der Seite, auf welche verwiesen wurde, nicht derjenige, der &uuml;ber Links auf die jeweilige Ver&ouml;ffentlichung lediglich verweist.', 'Der Autor ist bestrebt, in allen Publikationen die Urheberrechte der verwendeten Grafiken, Tondokumente, Videosequenzen und Texte zu beachten, von ihm selbst erstellte Grafiken, Tondokumente, Videosequenzen und Texte zu nutzen oder auf lizenzfreie Grafiken, Tondokumente, Videosequenzen und Texte zur&uuml;ckzugreifen. Alle innerhalb des Internetangebotes genannten und ggf. durch Dritte gesch&uuml;tzten Marken- und Warenzeichen unterliegen uneingeschr&auml;nkt den Bestimmungen des jeweils g&uuml;ltigen Kennzeichenrechts und den Besitzrechten der jeweiligen eingetragenen Eigent&uuml;mer. Allein aufgrund der blo&szlig;en Nennung ist nicht der Schluss zu ziehen, dass Markenzeichen nicht durch Rechte Dritter gesch&uuml;tzt sind! Das Copyright f&uuml;r ver&ouml;ffentlichte, vom Autor selbst erstellte Objekte bleibt allein beim Autor der Seiten. Eine Vervielf&auml;ltigung oder Verwendung solcher Grafiken, Tondokumente, Videosequenzen und Texte in anderen elektronischen oder gedruckten Publikationen ist ohne ausdr&uuml;ckliche Zustimmung des Autors nicht gestattet.', 'Sofern innerhalb des Internetangebotes die M&ouml;glichkeit zur Eingabe pers&ouml;nlicher oder gesch&auml;ftlicher Daten (Emailadressen, Namen, Anschriften) besteht, so erfolgt die Preisgabe dieser Daten seitens des Nutzers auf ausdr&uuml;cklich freiwilliger Basis. Die Inanspruchnahme und Bezahlung aller angebotenen Dienste ist - soweit technisch m&ouml;glich und zumutbar - auch ohne Angabe solcher Daten bzw. unter Angabe anonymisierter Daten oder eines Pseudonyms gestattet. Die Nutzung der im Rahmen des Impressums oder vergleichbarer Angaben ver&ouml;ffentlichten Kontaktdaten wie Postanschriften, Telefon- und Faxnummern sowie Emailadressen durch Dritte zur &Uuml;bersendung von nicht ausdr&uuml;cklich angeforderten Informationen ist nicht gestattet. Rechtliche Schritte gegen die Versender von sogenannten Spam-Mails bei Verst&ouml;ssen gegen dieses Verbot sind ausdr&uuml;cklich vorbehalten.', 'Dieser Haftungsausschluss ist als Teil des Internetangebotes zu betrachten, von dem aus auf diese Seite verwiesen wurde. Sofern Teile oder einzelne Formulierungen dieses Textes der geltenden Rechtslage nicht, nicht mehr oder nicht vollst&auml;ndig entsprechen sollten, bleiben die &uuml;brigen Teile des Dokumentes in ihrem Inhalt und ihrer G&uuml;ltigkeit davon unber&uuml;hrt.', 'Trotz sorgf&auml;ltiger inhaltlicher Kontrolle &uuml;bernehmen wir keine Haftung f&uuml;r die Inhalte externer Links. F&uuml;r den Inhalt der verlinkten Seiten sind ausschlie&szlig;lich deren Betreiber verantwortlich.', 'Ein', 'Ein', 'Ein', 'Ein', 'Ein', 'Ein')";
$inf_insertdbrow[2] = DB_IMP." (ueberschrift, vorname, nachname, anschrift, plzort, telefon, tel_info, fax, fax_info, email, switch1, switch2) VALUES ('Verantwortlich im Sinne &sect; 6 Teledienstegesetz (TDG) und &sect; 10 Mediendienste-Staatsvertrag (MDStV), Betreiber der Internetseite, Redaktion, Community, Content Page/Streams', 'Max', 'Mustermann', 'Musterstra&szlig;e 10', '12345 Musterstadt', '0123/4567890-01', '(19ct aus dem Festnetz der dt. Telekom, Mobilfunkpreise weichen ab.)', '0123/4567890-01', '(19ct aus dem Festnetz der dt. Telekom, Mobilfunkpreise weichen ab.)', 'name@topleveldomain.tld', 'Ein', 'Ein')";

$inf_droptable[1] = DB_KON;
$inf_droptable[2] = DB_IMP;
$inf_droptable[3] = DB_HAFT;


$inf_adminpanel[1] = array(
	"title" => "va Impressum",
	"panel" => "corefiles/core.php",
	"rights" => "VA1"
);

?>