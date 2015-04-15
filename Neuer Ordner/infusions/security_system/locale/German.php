<?php
/*----------------------------------------------+
| SECURITY SYSTEM V1.0 FÜR PHP-FUSION           |
| copyright (c) 2006 by BS-Fusion Deutschland   |
| Email-Support: webmaster[at]bs-fusion.de      |
| Homepage: http://www.bs-fusion.de             |
| Inhaber: Manuel Kurz                          |
+----------------------------------------------*/
if (!defined("IN_FUSION")) die();
$locale['SYS100'] = "Security System";
$locale['SYS101'] = "Das Security System &uuml;berwacht diese PHP-Fusion-Seite und sie vor SQL-Injection, Floodeintr&auml;ge in die Datenbank. Weiterhin &uuml;berpr&uuml;ft es einzelne Postfelder auf Spamw&ouml;rter. Es ist eine Proxykontrolle integriert. Man kann Proxies das Login und das Registrieren erlauben oder verbieten."; // &Auml;nderung ab Version 1.8.2
$locale['SYS102'] = "Hackversuche";
$locale['SYS103'] = "Blocks durch Filterliste";
$locale['SYS104'] = "Floodversuche";
$locale['SYS105'] = "&Uuml;bersicht";
$locale['SYS106'] = "Logeintr&auml;ge";
$locale['SYS107'] = "Filterliste";
$locale['SYS108'] = "Einstellungen";
$locale['SYS109'] = "Neuer Eintrag f&uuml;r die Filterliste";
$locale['SYS110'] = "markierte Eintr&auml;ge l&ouml;schen";
$locale['SYS111'] = "zur Filterliste hinzuf&uuml;gen";
$locale['SYS112'] = "User-Agent oder IP/IP Auszug";
$locale['SYS112_1'] = "(Beispiel: <b>127.0.0.1</b> od. <b>127.0.0.</b> etc... oder <b>Agentname/-bezeichnung</b>)";
$locale['SYS113'] = "# Ergebnisse anzeigen";
$locale['SYS114'] = "Eintrag";
$locale['SYS115'] = "Eintr&auml;ge";
$locale['SYS116'] = "Alle";
$locale['SYS117'] = "von";
$locale['SYS118'] = "Gesamt";
$locale['SYS119'] = "Willst Du diesen Filtereintrag wirklich löschen?";
$locale['SYS120'] = "Willst Du diesen Logeintrag wirklich löschen?";
$locale['SYS121'] = "Es wurden noch keine Logs erstellt!";
$locale['SYS122'] = "Du hast keinen Eintrag zum Löschen ausgewählt!";
$locale['SYS123'] = "Alle Eintr&auml;ge markieren!";
$locale['SYS124'] = "Datum";
$locale['SYS125'] = "IP-Adresse";
$locale['SYS126'] = "Query-String";
$locale['SYS127'] = "Referer Link";
$locale['SYS128'] = "User-Agent";
$locale['SYS129'] = "Forum Floodzeit:";
$locale['SYS130'] = "Shoutbox Floodzeit:";
$locale['SYS131'] = "Kommentar Floodzeit:";
$locale['SYS132'] = "Kontakt Floodzeit:";
$locale['SYS133'] = "PM Floodzeit:";
$locale['SYS134'] = "G&auml;stebuch Floodzeit:";
$locale['SYS135'] = "Flood Control Interval:";
$locale['SYS135_1'] = "Ab der Version 6.01 gibt es eine Floodkontrolle, um diese zu deaktivieren, setze dieses Interval auf <b>0</b>, da sonst Probleme auftreten w&uuml;rden!";

$locale['SYS136'] = "Flood Kontrolle starten?:";   // &Auml;nderung ab Version 1.8.1

$locale['SYS137'] = "Mitglieder automatisch sperren:";
$locale['SYS138'] = "Ja";
$locale['SYS139'] = "Nein";
$locale['SYS140'] = "aktiviert";
$locale['SYS141'] = "Aktivieren";
$locale['SYS142'] = "deaktiviert";
$locale['SYS143'] = "Deaktivieren";

$locale['SYS144'] = "Du kannst hier Einstellungen am Security System vornehmen. Es ist m&ouml;glich es abzuschalten, sowie einzelne Funktionen zu erlauben und zu verbieten. Die Spamkontrolle wird f&uuml;r Mitglieder und G&auml;ste durchgef&uuml;hrt. Wenn man in einem Forum Moderator ist, wird man auch von der Spamkontrolle und der Floodkontrolle befreit. Ab dem Benutzerlevel Administrator ist man von allen Kontrollen außer der Proxykontrolle, wenn diese aktiviert ist, befreit."; // &Auml;nderung ab Version 1.8.2

$locale['SYS145'] = "Systemeinstellungen";   // &Auml;nderung ab Version 1.8.1
$locale['SYS146'] = "Einstellungen speichern";
$locale['SYS147'] = "Floodversuche f&uuml;r Mitglieder";
$locale['SYS148'] = "Forum-Kontrolle nicht f&uuml;r:";
$locale['SYS149'] = "Shoutbox-Kontrolle nicht f&uuml;r:";
$locale['SYS150'] = "Kommentar-Kontrolle nicht f&uuml;r:";
$locale['SYS151'] = "Kontakt-Kontrolle nicht f&uuml;r:";
$locale['SYS152'] = "PM-Kontrolle nicht f&uuml;r:";
$locale['SYS153'] = "G&auml;stebuch-Kontrolle nicht f&uuml;r:";
$locale['SYS154'] = "Gesperrte Mitglieder";
$locale['SYS155'] = "markierte Mitglieder entsperren";
$locale['SYS156'] = "Keine Mitglieder zum entsperren vorhanden!";
$locale['SYS157'] = "Mitgliedsname";
$locale['SYS158'] = "Dieser Datensatz ist bereits vorhanden!";
$locale['SYS159'] = "Du musst einen UserAgent Namen oder eine IP/IP-Auszug angeben!";
$locale['SYS160'] = "Spamw&ouml;rter";
$locale['SYS161'] = "Spamwort hinzuf&uuml;gen";
$locale['SYS161_1'] = "Bitte alle Spamw&ouml;rter kleinschreiben!";
$locale['SYS162'] = "markierte Spamw&ouml;rter entfernen";
$locale['SYS163'] = "Du hast kein Spamwort angegeben!";
$locale['SYS164'] = "M&ouml;chtest Du wirklich die markierten Spamwörter löschen";
$locale['SYS165'] = "Zur Liste hinzuf&uuml;gen";
$locale['SYS166'] = "Spamwort Liste";
$locale['SYS167'] = "Es wurden noch keine Spamw&ouml;rter eingetragen!";
$locale['SYS168'] = "Spamversuche";
$locale['SYS169'] = "Inhalt der Mitteilung";
$locale['SYS170'] = "Zur&uuml;ck zum Adminbereich";
$locale['SYS171'] = "Anzeige im Panel";
$locale['SYS200'] = "Sekunden";
$locale['SYS201'] = "Minute";
$locale['SYS202'] = "Minuten";
$locale['SYS203'] = "Stunde";
$locale['SYS204'] = "Stunden";
$locale['SYS205'] = "Tag";
$locale['SYS206'] = "Tage";
$locale['SYS207'] = "Du hast versucht einen Floodeintrag in unser System einzuf&uuml;gen. Dies wurde durch unser System blockiert und protokolliert.";
$locale['SYS208'] = "Um einen neuen Thread oder Beitrag im Forum eintragen zu k&ouml;nnen musst Du %s warten.";
$locale['SYS209'] = "Um einen neuen Beitrag in der Shoutbox eintragen zu k&ouml;nnen musst Du %s warten.";
$locale['SYS210'] = "Um einen neuen Beitrag in den Kommentaren eintragen zu k&ouml;nnen musst Du %s warten.";
$locale['SYS211'] = "Um einen neuen Eintrag ins G&auml;stebuch eintragen zu k&ouml;nnen musst Du %s warten.";
$locale['SYS212'] = "Um eine neue Mitteilung an dieses Mitglied senden zu k&ouml;nnen musst Du %s warten.";
$locale['SYS213'] = "Um einen neue Kontakt an uns senden zu k&ouml;nnen musst Du %s warten.";
$locale['SYS214'] = "Wir bedanken uns f&uuml;r Dein Verst&auml;ndnis<br>Euer ".$settings['sitename']."-Team";
$locale['SYS215'] = "Dein Account wurde gesperrt!<br>Bitte wende Dich an einen Techn. Administrator um deinen Account wieder freischalten zu lassen!";
$locale['SYS216'] = "markierte Filter aktivieren";
$locale['SYS217'] = "markierte Filter deaktivieren";
$locale['SYS218'] = "Filter in roter Schrift sind deaktiviert, in gr&uuml;ner Schrift aktiviert";
$locale['SYS219'] = "Du hast keinen Filter zur Aktivierung/Deaktivierung gew&auml;hlt";
$locale['SYS220'] = "Komplette Logfiles Tabelle leeren!";
$locale['SYS221'] = "Willst du die komplette Logfile-Tabelle wirklich leeren?";


// NEUE LOCALE DATEN START
$locale['SYS222'] = "Security System starten?:";
$locale['SYS223'] = "Proxy Kontrolle?:";
$locale['SYS224'] = "Proxy Registrierung erlauben?:";
$locale['SYS225'] = "Proxy Login erlauben?:";
$locale['SYS226'] = "Proxy Login";
$locale['SYS227'] = "Proxy Registrierung";
$locale['SYS228'] = "Proxy Zugriff";
$locale['SYS229'] = "%s wurde erfolgreich blockiert.";
$locale['SYS230'] = "Weitere Einstellungen";
$locale['SYS231'] = "Online Dokumentation";

$locale['SUPD100'] = "Security System Update";
$locale['SUBD101'] = "Neues Update installiert";
$locale['SUBD102'] = "Das neue Update wurde erfolgreich installiert!";
$locale['SUBD103'] = "Kein Neues Update";
$locale['SUBD104'] = "Das Security System ist auf dem aktuellen Stand";
$locale['SUBD105'] = "Neues Update verf&uuml;gbar";
$locale['SUBD106'] = "Es wurde eine neue Version vom Security System gefunden. Zum Downloaden der Datei ist eine Mitgliedschaft auf BS-Fusion vorgesetzt.";
$locale['SUBD107'] = "Fehler beim Update";
$locale['SUBD108'] = "Es ist ein Fehler beim Update aufgetreten.<br>\n %s";
$locale['SUBD109'] = "Die benutzte Version ist &auml;lter, als die f&uuml;r das Update vorausgesetzt wird. Ben&ouml;tigt wird die Version %s";
$locale['SUBD110'] = "Es ist ein Fehler beim Update aufgetreten. Bitte wende Dich an den Entwickler des Systems.";
$locale['SUBD111'] = "Die Funktion \"fsockopen()\" ist deaktiviert. Bitte &uuml;berpr&uuml;fe nach Updates auf";
$locale['SUBD112'] = "Update";

// NEUE LOCALE DATEN END

// NEUES AB 1.8.2
$locale['PROXY000'] = "Proxy Whitelist";
$locale['PROXY001'] = "Neuen Proxy eintragen";
$locale['PROXY002'] = "Proxy freischalten";
$locale['PROXY003'] = "Proxy deaktivieren";
$locale['PROXY004'] = "Proxy l&ouml;schen";
$locale['PROXY005'] = "Sollen wirklich alle markierten Proxies gelöscht werden?";
$locale['PROXY006'] = "Sollen wirklich alle markierten Proxies freigeschaltet werden?";
$locale['PROXY007'] = "Sollen wirklich alle markierten Proxies deaktiviert werden?";
$locale['PROXY008'] = "Alle gr&uuml;n markierten IP's sind freigeschaltet! Alle rot markierten sind nicht freigeschaltet";
$locale['PROXY009'] = "Neue Proxy-IP";
$locale['PROXY010'] = "Du musst eine Proxy-IP eintragen!";
$locale['PROXY011'] = "Die einzutragene Proxy-IP existiert schon!"; 
$locale['PROXY012'] = "Proxy Blacklist";
$locale['PROXY013'] = "Proxy zur Blacklist hinzuf&uuml;gen";
$locale['PROXY014'] = "Es sind noch keine Proxies eingetragen";
$locale['PROXY015'] = "Sollen wirklich alle markierten Proxies in die Blacklist eingetragen werden?";
$locale['PROXY016'] = "<font style='font-size:10px;'>(Nur das Feld ausf&uuml;llen, was ben&ouml;tigt wird)</font>";

$locale['LOG000'] = "Einstellung f&uuml;r das Schreiben der Logeintr&auml;ge";
$locale['LOG001'] = "Automatisch Log l&ouml;schen?";
$locale['LOG002'] = "Logs f&uuml;r Hackversuche?";
$locale['LOG003'] = "Logs f&uuml;r Blockierungen aus der Filterliste?";
$locale['LOG004'] = "Logs f&uuml;r Spamversuche?";
$locale['LOG005'] = "Logs f&uuml;r Floodversuche?";
$locale['LOG006'] = "Logs f&uuml;r Proxykontrolle?";
$locale['LOG007'] = "maximale Logeintr&auml;ge in der Datenbank";
$locale['LOG008'] = "Logeintr&auml;ge g&uuml;ltig f&uuml;r";
// Ende



// Der Text darf frei definiert werden. Der Link zu BS-Fusion.de darf nicht entfernt werden. Vielen Dank hierf&uuml;r!
$locale['SYS300'] = '<a class="small" href="http://www.bs-fusion.de" target="_blank">Mehr Sicherheit</a> mit dem<br><a href="http://www.bs-fusion.de" target="_blank">BS-Fusion Security System</a>.';
$locale['SYS301'] = 'Gesch&uuml;tzt mit dem<br><a href="http://www.bs-fusion.de" target="_blank" class="small">BS-Fusion Security System</a><br><b>%s</b> Angriffe blockiert';
$locale['SYS302'] = '<b>%s</b> Angriff(e) blockiert';

$locale['SYS400'] = "Fenster schliessen";
$locale['SYS401'] = "Drucken";
$locale['license_accept'] = "Ich stimme dem Lizenzvertrag zu!";
?>
