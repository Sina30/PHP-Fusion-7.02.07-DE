<?php

/*
+--------------------------------------------------+
| Deutsche Sprachdatei fuer PHP-Fusion v7.02.04    |
+--------------------------------------------------+
| Hiermit moechten wir uns bei allen Benutzern     |
| bedanken, die uns geholfen haben, diese deutsche |
| Sprachdatei herzustellen.                        |
+--------------------------------------------------+
| Benutzer welche Mitgeholfen haben (Accountname)  |
| - Sascha                                         |
| - ghost2k                                        |
| - Dav (frueher Hads)                             |
| - Layzee                                         |
| - MarcusG                                        |
| - Sunflow1991                                    |
| - Ingrimmsch                                     |
| - Thickbox                                       |
| - Player_Shadow                                  |
+--------------------------------------------------+
| http://www.phpfusion-support.de/                 |
+--------------------------------------------------+
*/

// Sprachdatei Einstellungen
setlocale(LC_TIME, "de_DE.UTF8", "de", "DE");
$locale['charset']   = "UTF-8";
$locale['xml_lang']  = "de";
$locale['tinymce']   = "de";
$locale['phpmailer'] = "de";

// Monate
$locale['months']      = "&nbsp|Januar|Februar|M&auml;rz|April|Mai|Juni|Juli|August|September|Oktober|November|Dezember";
$locale['shortmonths'] = "&nbsp|Jan|Feb|M&auml;r|Apr|Mai|Jun|Jul|Aug|Sept|Okt|Nov|Dez";

// Benutzerlevel
$locale['user0']          = "Gast";
$locale['user1']          = "Mitglied";
$locale['user2']          = "Administrator";
$locale['user3']          = "Seiten Administrator";
$locale['user_na']        = "N/A";
$locale['user_anonymous'] = "Anonymer Benutzer";

// Benutzerstatuse
$locale['status0'] = "Aktiv";
$locale['status1'] = "Gebannt";
$locale['status2'] = "Unaktiviert";
$locale['status3'] = "Tempor&auml;r gesperrt";
$locale['status4'] = "Sicherheitshalber gebannt";
$locale['status5'] = "Ung&uuml;ltig";
$locale['status6'] = "Anonym";
$locale['status7'] = "Deaktiviert";
$locale['status8'] = "Inaktiv";

// Forum Moderator
$locale['userf1'] = "Moderator";

// Navigation
$locale['global_001'] = "Navigation";
$locale['global_002'] = "Keine Links angelegt.";

// Benutzer Online
$locale['global_010'] = "Mitglieder Online";
$locale['global_011'] = "G&auml;ste Online";
$locale['global_012'] = "Mitglieder Online";
$locale['global_013'] = "Keine Mitglieder Online";
$locale['global_014'] = "Mitglieder insgesamt";
$locale['global_015'] = "Unaktivierte Mitglieder";
$locale['global_016'] = "Neuestes Mitglied";

// Forum Seitenpanel
$locale['global_020'] = "Foren Themen";
$locale['global_021'] = "Neueste Themen";
$locale['global_022'] = "Hei&szlig;este Themen";
$locale['global_023'] = "Keine Themen erstellt";

// Kommentare Seitenpanel
$locale['global_025'] = "Neueste Kommentare";
$locale['global_026'] = "Keine Kommentare verf&uuml;gbar";

// Artikel Seitenpanel
$locale['global_030'] = "Neueste Artikel";
$locale['global_031'] = "Keine Artikel verf&uuml;gbar";

// Downloads Seitenpanel
$locale['global_032'] = "Neueste Downloads";
$locale['global_033'] = "Keine Downloads verf&uuml;gbar";

// Willkommenspanel
$locale['global_035'] = "Willkommen";

// Letzte aktive Foren Themen Panel
$locale['global_040'] = "Letzte aktive Foren Themen";
$locale['global_041'] = "Meine letzten Themen";
$locale['global_042'] = "Meine letzten Beitr&auml;ge";
$locale['global_043'] = "Neue Beitr&auml;ge";
$locale['global_044'] = "Thema";
$locale['global_045'] = "Aufrufe";
$locale['global_046'] = "Antworten";
$locale['global_047'] = "Letzter Beitrag";
$locale['global_048'] = "Forum";
$locale['global_049'] = "Geschrieben";
$locale['global_050'] = "Autor";
$locale['global_051'] = "Umfrage";
$locale['global_052'] = "Verschoben";
$locale['global_053'] = "Du hast bisher noch keine Foren Themen verfasst.";
$locale['global_054'] = "Du hast bisher noch keine Foren Beitr&auml;ge verfasst.";
$locale['global_055'] = "Seit deinem letzten Besuch gibt es %u neue Beitr&auml;ge in %u unterschiedlichen Themen.";
$locale['global_056'] = "Meine abonnierten Themen";
$locale['global_057'] = "Optionen";
$locale['global_058'] = "Stop";
$locale['global_059'] = "Aktuell hast du keine Themen abonniert.";
$locale['global_060'] = "Dieses Thema nicht mehr verfolgen?";

// News und Artikel
$locale['global_070']  = "Geschrieben von ";
$locale['global_071']  = ", ";
$locale['global_072']  = "Mehr lesen";
$locale['global_073']  = " Kommentare";
$locale['global_073b'] = " Kommentar";
$locale['global_074']  = " Gelesen";
$locale['global_075']  = "Drucken";
$locale['global_076']  = "Bearbeiten";
$locale['global_077']  = "News";
$locale['global_078']  = "Bisher wurden keine News verfasst.";
$locale['global_079']  = "In ";
$locale['global_080']  = "keiner Kategorie";

// Seiten Navigation
$locale['global_090'] = "Zur&uuml;ck";
$locale['global_091'] = "Vorw&auml;rts";
$locale['global_092'] = "Seite ";
$locale['global_093'] = " von ";

// Gaeste Menu
$locale['global_100'] = "Login";
$locale['global_101'] = "Benutzername";
$locale['global_102'] = "Passwort";
$locale['global_103'] = "Eingeloggt bleiben";
$locale['global_104'] = "Login";
$locale['global_105'] = "Noch kein Mitglied?<br /><a href='".BASEDIR."register.php' class='side' title='Klicke hier'>Klicke hier</a> um dich zu registrieren";
$locale['global_106'] = "Passwort vergessen?<br />Um ein neues Passwort anzufordern <a href='".BASEDIR."lostpassword.php' class='side' title='klicke hier'>klicke hier</a>.";
$locale['global_107'] = "Registrieren";
$locale['global_108'] = "Passwort vergessen?";

// Mitglieder Menu
$locale['global_120'] = "Profil bearbeiten";
$locale['global_121'] = "Private Nachrichten";
$locale['global_122'] = "Mitgliederliste";
$locale['global_123'] = "Adminbereich";
$locale['global_124'] = "Logout";
$locale['global_125'] = "Du hast %u neue ";
$locale['global_126'] = "Nachricht";
$locale['global_127'] = "Nachrichten";
$locale['global_128'] = "Einsendung";
$locale['global_129'] = "Einsendungen";

// Umfrage
$locale['global_130'] = "Mitglieder Umfrage";
$locale['global_131'] = "Abstimmen";
$locale['global_132'] = "Du musst eingeloggt sein, um abstimmen zu k&ouml;nnen.";
$locale['global_133'] = "Stimme";
$locale['global_134'] = "Stimmen";
$locale['global_135'] = "Stimmen: ";
$locale['global_136'] = "Gestartet: ";
$locale['global_137'] = "Beendet: ";
$locale['global_138'] = "Umfragenarchiv";
$locale['global_139'] = "W&auml;hle eine Umfrage aus der Liste aus:";
$locale['global_140'] = "Anzeigen";
$locale['global_141'] = "Umfrage anzeigen";
$locale['global_142'] = "Es wurden keine Umfragen erstellt.";

// Sicherheitscode
$locale['global_150'] = "Sicherheitscode:";
$locale['global_151'] = "Sicherheitscode eingeben:";

// Footer Z&auml;hler
$locale['global_170'] = "eindeutiger Besuch";
$locale['global_171'] = "eindeutige Besuche";
$locale['global_172'] = "Seitenaufbau in %s Sekunden";
$locale['global_173'] = "DB-Abfragen";

// Admin Navigation
$locale['global_180'] = "Admin &Uuml;bersicht";
$locale['global_181'] = "Zur&uuml;ck zur Seite";
$locale['global_182'] = "<strong>Hinwei&szlig;:</strong> Dein Admin Passwort ist fehlerhaft oder wurde nicht eingegeben.";

// Verschiedenes
$locale['global_190'] = "Wartungsmodus aktiviert";
$locale['global_191'] = "Deine IP-Adresse ist bei uns auf der Blacklist.";
$locale['global_192'] = "Dein Benutzercookie ist abgelaufen. Bitte logge dich erneut ein, um fortfahren zu k&ouml;nnen.";
$locale['global_193'] = "Das Benutzercookie konnte nicht gesetzt werden. Bitte stelle sicher, dass Cookies aktiviert sind, um dich korrekt anmelden zu k&ouml;nnen.";
$locale['global_194'] = "Dieser Account ist zur Zeit gesperrt.";
$locale['global_195'] = "Dieser Account ist noch nicht aktiviert.";
$locale['global_196'] = "Falscher Benutzername oder falsches Passwort.";
$locale['global_197'] = "Bitte warte, w&auml;hrend du weitergeleitet wirst ...<br /><br />";
$locale['global_197'] = "[ <a href='index.php' title='Oder klicke hier, wenn du nicht warten m&ouml;chtest'>Oder klicke hier, wenn du nicht warten m&ouml;chtest</a> ]";
$locale['global_198'] = "<strong>Hinwei&szlig;:</strong> setup.php wurde gefunden. Bitte umgehend l&ouml;schen.";
$locale['global_199'] = "<strong>Hinwei&szlig;:</strong> Du hast noch kein Admin Passwort gesetzt, klicke auf <a href='".BASEDIR."edit_profile.php' title='Profil bearbeiten'>Profil bearbeiten</a> um eines zu setzen.";

// Titel
$locale['global_200'] = " - ";
$locale['global_201'] = ": ";
$locale['global_202'] = $locale['global_200']."Suche";
$locale['global_203'] = $locale['global_200']."FAQ";
$locale['global_204'] = $locale['global_200']."Forum";

// Themes
$locale['global_210'] = "Zum Inhalt";

// No themes found
$locale['global_300']  = "Kein Theme gefunden";
$locale['global_301']  = "Wir m&ouml;chten uns Entschuldigen, aber diese Seite kann leider nicht angezeigt werden.\n";
$locale['global_301'] .= "Es wurde kein Theme gefunden.<br />\n";
$locale['global_301'] .= "Wenn du ein Seiten Administrator bist, nutze bitte dein FTP-Programm, um ein geeignetes Theme f&uuml;r <strong><em>PHP-Fusion v7</em></strong> in den Ordner <strong><em>themes/</em></strong> hochzuladen.\n";
$locale['global_301'] .= "Nach dem Upload &uuml;berpr&uuml;fe in den <strong><em>Haupteinstellungen</em></strong> ob das gew&auml;hlte Theme korrekt in den Ordner <strong><em>themes/</em></strong> hochgeladen wurde.\n";
$locale['global_301'] .= "Bitte beachte, dass der hochgeladene Theme Ordner den selben Namen (inklusive Gro&szlig;-/Kleinschreibung) wie in den <strong><em>Haupteinstellungen</em></strong> haben muss.<br />\n";
$locale['global_301'] .= "Wenn du ein normaler Benutzer bist, berichte bitte dem Seiten Administrator unter ".hide_email($settings['siteemail'])." &uuml;ber dieses Problem.<br />\n";
$locale['global_302']  = "Das in den Haupteinstellungen ausgew&auml;hlte Theme existiert nicht oder ist unvollst&auml;ndig.";

// Javascript deaktiviert
$locale['global_303']  = "Du hast in deinem Browser kein <strong>Javascript</strong> aktiviert.<br />\n";
$locale['global_303'] .= "Um diese Seite korrekt anzuzeigen ist Javascript jedoch zwingend n&ouml;tig.<br />\n";
$locale['global_303'] .= "Bitte aktiviere Javascript in den Einstellungen deines Browser beziehungswei&szlig;e besorge dir einen Browser, der diesen unterst&uuml;tzt.<br />\n";
$locale['global_303'] .= "<a href='http://www.firefox.com/' rel='nofollow' title='Mozilla Firefox'>Mozilla Firefox</a>&nbsp;|&nbsp;\n";
$locale['global_303'] .= "<a href='http://www.apple.com/safari/' rel='nofollow' title='Safari'>Safari</a>&nbsp;|&nbsp;\n";
$locale['global_303'] .= "<a href='http://www.opera.com/' rel='nofollow' title='Opera'>Opera</a>&nbsp;|&nbsp;\n";
$locale['global_303'] .= "<a href='http://www.google.com/chrome/' rel='nofollow' title='Google Chrome'>Google Chrome</a>&nbsp;|&nbsp;\n";
$locale['global_303'] .= "<a href='http://www.microsoft.com/windows/internet-explorer/' rel='nofollow' title='Internet Explorer'>Internet Explorer h&ouml;her Version 6</a>\n";

// Mitgliederstatus
$locale['global_400'] = "Tempor&auml;r gesperrt";
$locale['global_401'] = "Gebannt";
$locale['global_402'] = "Deaktiviert";
$locale['global_403'] = "Account gel&ouml;scht";
$locale['global_404'] = "Account anonymisiert";
$locale['global_405'] = "Anonymer Benutzer";
$locale['global_406'] = "Dieser Account wurde aus folgenden Grund gesperrt:";
$locale['global_407'] = "Dieser Account ist tempor&auml;r gesperrt bis ";
$locale['global_408'] = " aus folgenden Grund:";
$locale['global_409'] = "Dieser Account wurde aus Sicherheitsgr&uuml;nden gesperrt.";
$locale['global_410'] = "Der Grund daf&uuml;r ist: ";
$locale['global_411'] = "Dieser Account wurde gel&ouml;scht.";
$locale['global_412'] = "Dieser Account wurde anonymisiert, weil der Benutzer m&ouml;glicherwei&szlig;e inaktiv war.";

// Autoban wegen Spam
$locale['global_440']  = "Automatische Sperre durch die Floodkontrolle";
$locale['global_441']  = "Dein Account auf ".$settings['sitename']." wurde gesperrt";
$locale['global_442']  = "Hallo [USER_NAME],\n\n";
$locale['global_442'] .= "dein Account auf ".$settings['sitename']." wurde wegen zuvieler Anfragen beziehungsweiße Postings über die IP-Adresse ".USER_IP." gesperrt.\n";
$locale['global_442'] .= "Dies geschah zum Schutz vor Spambots.\n";
$locale['global_442'] .= "Um deinen Account wieder zu aktivieren, oder uns mitzuteilen, dass dies nicht der Grund für die Sperre sein kann, kontaktiere bitte einen Administrator unter ".$settings['siteemail']."\n\n";
$locale['global_442'] .= "Mit freundlichen Grüßen ".$settings['siteusername'];

// Account deaktivierung
$locale['global_450']  = "Sperre deines Accounts aufgehoben";
$locale['global_451']  = "Dein Account auf ".$settings['sitename']." wurde entsperrt";
$locale['global_452']  = "Hallo USER_NAME,\n\n";
$locale['global_452'] .= "die Sperre deines Accounts auf ".$settings['siteurl']." wurde aufgehoben.\n";
$locale['global_452'] .= "Deine Login Daten waren:\n";
$locale['global_452'] .= "Benutzername: USER_NAME\n";
$locale['global_452'] .= "Passwort: Aus Sicherheitsgründen nicht genannt.\n";
$locale['global_452'] .= "Solltest du dein Passwort vergessen haben, kannst du hier LOST_PASSWORD ein neues anfordern.\n\n";
$locale['global_452'] .= "Mit freundlichen Grüßen ".$settings['siteusername'];
$locale['global_453']  = "Hallo USER_NAME,\n\n";
$locale['global_453'] .= "die Sperre deines Accounts auf ".$settings['siteurl']." wurde aufgehoben.\n\n";
$locale['global_453'] .= "Mit freundlichen Grüßen ".$settings['siteusername'];
$locale['global_454']  = "Dein Account auf ".$settings['sitename']." wurde reaktiviert";
$locale['global_455']  = "Hallo USER_NAME,\n\n";
$locale['global_455'] .= "bei deinem letzten Login auf ".$settings['siteurl']." wurde dein Account reaktiviert und ist nicht mehr länger als inaktiv makiert.\n\n";
$locale['global_455'] .= "Mit freundlichen Grüßen ".$settings['siteusername'];

// Function parsebytesize()
$locale['global_460'] = "Leer";
$locale['global_461'] = "Bytes";
$locale['global_462'] = "kB";
$locale['global_463'] = "MB";
$locale['global_464'] = "GB";
$locale['global_465'] = "TB";

// Weiterleitung
$locale['global_500'] = "Bitte warte, du wirst weitergeleitet zu %s. Sollte die Weiterleitung nicht funktionieren, klicke bitte hier.";

// Sicherheitscode
$locale['global_600'] = "Sicherheitscode";
$locale['recaptcha']  = "de";

// Sonstiges
$locale['global_900'] = "Nicht m&ouml;glich HEX zu DEC umzuwandeln.";

// BITTE AB HIER NICHT MEHR BEARBEITEN !!
#$locale['global_060'] = utf8_encode($locale['global_060']);
#$locale['global_441'] = utf8_encode($locale['global_441']);
#$locale['global_442'] = utf8_encode($locale['global_442']);
#$locale['global_451'] = utf8_encode($locale['global_451']);
#$locale['global_452'] = utf8_encode($locale['global_452']);
#$locale['global_453'] = utf8_encode($locale['global_453']);
#$locale['global_454'] = utf8_encode($locale['global_454']);
#$locale['global_455'] = utf8_encode($locale['global_455']);

// Template Locale
$locale['pro_1001'] = "Suche ...";
$locale['pro_1002'] = "Content Admin";
$locale['pro_1003'] = "User Admin";
$locale['pro_1004'] = "System Admin";
$locale['pro_1005'] = "Einstellungen";
$locale['pro_1006'] = "Infusionen";
$locale['pro_1007'] = "Dashboard";
$locale['pro_1008'] = "Besuche";
$locale['pro_1009'] = "Benutzer";
$locale['pro_1010'] = "Artikel hinzufügen";
$locale['pro_1011'] = "News hinzufügen";
$locale['pro_1012'] = "Download hinzufügen";
$locale['pro_1013'] = "Überprüfen Sie Ihre Einsendungen";
$locale['pro_1014'] = "Überprüfen Sie Ihre Mitglieder";
$locale['pro_1049'] = "Hinzufügen eines Link";
$locale['pro_1053'] = "Keine Themen gefunden";
$locale['pro_1054'] = "Keine Nachrichten gefunden";
$locale['pro_1055'] = "Keine Beiträge gefunden";
$locale ['pro_1066'] = "Information";
$locale ['pro_1067'] = "Mitglieder";
$locale ['pro_1068'] = "Vorlagen";
$locale ['pro_1069'] = "Verschiedenes";
$locale ['pro_1077'] = "Aktivieren Panel Sorting";
$locale ['pro_1078'] = "Disable Panel Sorting";

// Kommentare Panel
$locale['pro_1015'] = "kommentiert";
$locale['pro_1016'] = "Kommentare ein";
$locale['pro_1017'] = "in";
$locale['pro_1018'] = "Kategorie";
$locale['pro_1019'] = "Löschen";
$locale['pro_1020'] = "Sind Sie sicher, dass Sie diesen Kommentar wirklich löschen wollen?";
 
// Mitglieder-Panel
$locale['pro_1021'] = "Avatar";
$locale['pro_1022'] = "Registration Time";
$locale['pro_1023'] = "Optionen";
$locale['pro_1024'] = "IP-Adresse";
$locale['pro_1025'] = "Ansicht";
$locale['pro_1026'] = "Sind Sie sicher, dass Sie dieses Mitglied wirklich löschen?";
$locale['pro_1027'] = "Alle Mitglieder";
$locale['pro_1028'] = "Gebannte Mitglieder";
$locale['pro_1029'] = "Suspended Mitglieder";
$locale['pro_1030'] = "Unaktivierte Mitglieder";
$locale['pro_1031'] = "anzeigen";
$locale['pro_1032'] = "Neueste Mitglieder";
 
// Messages Panel
$locale['pro_1033'] = "Private Nachrichten";
$locale['pro_1034'] = "Aus";
$locale['pro_1035'] = "Betreff";
$locale['pro_1036'] = "Empfangszeit";
$locale['pro_1037'] = "lesen";
$locale['pro_1038'] = "Inbox";
$locale['pro_1039'] = "Postausgang";
$locale['pro_1040'] = "Archiv";
$locale['pro_1041'] = "Optionen";
 
// Submissions-Panel
$locale['pro_1042'] = "Warten auf Veröffentlichungen";
$locale['pro_1043'] = "Typ";
$locale['pro_1044'] = "Vorlagen Name";
$locale['pro_1045'] = "Eingereicht";
$locale['pro_1046'] = "Sind Sie sicher, dass Sie diese Vorlage löschen wollen?";
$locale['pro_1047'] = "Zeige alle Beiträge";
$locale['pro_1048'] = "Vorlagen Einstellungen";
 
// Search Page
$locale['pro_1050'] = "Suchergebnisse";
$locale['pro_1051'] = "Seitenname";
$locale['pro_1052'] = "Admin Suche";
  
// Zuletzt besuchte Seiten
$locale['pro_1056'] = "Zuletzt besuchte Abschnitte";
$locale['pro_1057'] = "Besucht auf";

// Adminoptionen
$locale['pro_1058'] = "Administratoren Optionen";
$locale['pro_1059'] = "Administratoren Panel Stil";
$locale['pro_1060'] = "Modern";
$locale['pro_1061'] = "Classic";
$locale['pro_1062'] = "Optionen speichern";
$locale['pro_1063'] = "Ein Fehler ist aufgetreten!";
$locale['pro_1064'] = "Optionen gespeichert!";
$locale['pro_1065'] = "Optionen";
$locale['pro_1070'] = "Zeige Letzten Kommentare ";
$locale['pro_1071'] = "Anzeigen";
$locale['pro_1072'] = "Verstecken";
$locale['pro_1073'] = "Zeige Neueste Mitglieder Panel";
$locale['pro_1074'] = "Aktuelle Beiträge Themen Panel";
$locale['pro_1075'] = "Zeige Private Nachrichten Panel";
$locale['pro_1076'] = "Zeige Submission Panel";
$locale['pro_1079'] = "Zeige Zuletzt besuchte Abschnitte Panel";
$locale['pro_1080'] = "Profil Information Panel";
$locale['pro_1081'] = "Navigationsbereich anzeigen";
$locale['pro_1082'] = "Zeige Information Panel";

?>