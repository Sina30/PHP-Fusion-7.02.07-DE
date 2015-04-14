<?php

// Allgemeines
$locale['title']     = "PHP-Fusion Core v7.02.07 DE Edition Setup";
$locale['sub-title'] = "PHP-Fusion Core v7.02.07 DE Edition Setup";
$locale['xml_lang']  = "de";
$locale['os_version'] = '7.02.07 DE';
$locale['charset']   = "UTF-8";
$locale['setup_0005'] = " Ich habe die AGBs gelesen <a href='https://php-fusion.co.uk/license/'>(AGBs)</a> und Akzeptiere diese.";
$locale['setup_0003'] = "Der Installations Anleitung führt Sie durch die erforderlichen Schritte zum PHP-Fusion CMS auf Ihrem Server zu installieren. Sollten Sie weitere Unterstützung, überprüfen Sie bitte unsere <a class='strong' href='https://php-fusion.co.uk/infusions/wiki/documentation.php?page=208'>Online Installations dokumentation</a>.";

// Neue Ausgabe der Texte bei der Installation

$locale['500'] = "PHP Fusion 7";
$locale['501'] = "<b>Willkommen bei der Installation von PHP Fusion v7.02.07 DE</b>"; 
$locale['502'] = "Installation starten";
$locale['503'] = "Aktuelle Version 7.02.07 Deutsch";
$locale['504'] = "Bei Fragen oder Problemen steht Dir das Team von <a target='_blank' href='http://www.phpfusion-deutschland.de'>PHP Fusion Deutschland</a> zur Seite.";
$locale['505'] = "PHP Fusion 7.02.07 Installation";
$locale['506'] = "System vorbereiten";
$locale['507'] = "Schreibrechte der Ordner und Dateien pr&uuml;fen";
$locale['508'] = "Infobox";
$locale['509'] = "In diesem Schritt der Installation werden die Schreibrechte der Dateien und Ordner gepr&uuml;ft.<br /><br />";
$locale['509'] .= "Erscheinen hier rote Kreuze, sind die entsprechenden Schreibrechte nicht korrekt gesetzt.<br /><br />";
$locale['509'] .= "Bitte gib dann den Dateien/Ordner die notwendigen Schreibrechte und klicke auf \"Erneut Pr&uuml;fen\".<br /><br />";
$locale['509'] .= " Wenn alle Felder gr&uuml;n sind klicke auf \"Weiter\" ";
$locale['510'] = "Datenbank Verbindung";
$locale['511'] = "Verbindung mit der Datenbank herstellen";
$locale['512'] = "Gib in diese Felder die Datenbankdaten Deiner MySQL-Datenbank ein. <br /><br />";
$locale['512'] .= "Datenbank Pr&auml;fix und Cookie Pr&auml;fix werden durch zuf&auml;llige Werte gef&uuml;llt, Du kannst hier aber auch eigene Werte angeben. <br /><br />";
$locale['512'] .= "Nachdem alle Felder ausgef&uuml;llt wurden klicke auf \"Weiter\".";
$locale['513'] = "Verbindung mit der MySQL Datenbank herstellen";
$locale['514'] = "Datenbank Host:";
$locale['515'] = "Datenbank Benutzername:";
$locale['516'] = "Datenbank Passwort:";
$locale['517'] = "Datenbank Name:";
$locale['518'] = "Datenbank Pr&auml;fix:";
$locale['519'] = "Cookie Pr&auml;fix:";
$locale['520'] = "Erfolgreich";
$locale['521'] = "Die Verbindung zur Datenbank war erfolgreich";
$locale['522'] = "Verbindungslog: ";
$locale['523'] = "Fehler";
$locale['524'] = "Es ist ein Fehler aufgetreten!";
$locale['525'] = "Folgender Fehler ist aufgetreten: ";
$locale['526'] = "Administrator Account erstellen";
$locale['527'] = "Administrator anlegen";
$locale['528'] = "Erstelle auf dieser Seite den Administrator Account f&uuml;r Deine neue Webseite. <br /><br />";
$locale['528'] .= "Bitte verwende sichere Passw&ouml;rter aus Buchstaben und Zahlen. <br /><br />";
$locale['528'] .= "Der Seitenadministrator hat nach der Installation Zugriff auf alle Bereiche der Webseite. ";
$locale['529'] = "Administrator Account f&uuml;r die Webseite erstellen ";
$locale['530'] = "Benutzername:";
$locale['531'] = "Passwort:";
$locale['532'] = "Passwort wiederholen:";
$locale['533'] = "Admin-Passwort:";
$locale['534'] = "Admin-Passwort wiederholen:";
$locale['535'] = "E-Mail Adresse:";
$locale['536'] = "Gl&uuml;ckwunsch";
$locale['537'] = "PHP Fusion wurde erfolgreich installiert!";
$locale['538'] = "Installation abschlie&szlig;en ";
$locale['539'] = "Die Installation von PHP-Fusion V7 ist nun abgeschlossen. Du kannst Deine neue Webseite nun nutzen.<br /><br />";
$locale['539'] .= "Sobald du unterhalb auf \"Weiter zur Webseite\" klickst, wird Deine neue Homepage ge&aouml;ffnet.<br /><br />";
$locale['539'] .= "ACHTUNG Nachdem du deine Homepage betreten hast, l&ouml;sche unbedingt die setup.php von deinem Server und setzte die Schreibrechte der config.php auf 0644! Anderenfalls entsteht eine Sicherheitsl&uuml;cke.<br /><br />";
$locale['539'] .= "Vielen Dank, dass du dich f&uuml;r PHP-Fusion entschieden hast. ";
$locale['540'] = " zur Webseite";

$timestamp = time();
$datum = date("Y");

// Standart Daten - Willkommensnachricht
$locale['230'] = "Gl&uuml;ckwunsch, Du hast erfolgreich PHP Fusion 7.02.07 installiert.<br /><br />";
$locale['230'] .= "Jetzt kannst Du dich auf der Rechten Seiten mit Deinem Administrator Account anmelden.<br />";
$locale['230'] .= "<strong>Wichtig: Stelle bitte noch die config.php auf die Schreibrechte CHMOD 644 ein und l&ouml;sche die setup.php</strong><br /><br />";

// Die Schritte
$locale['001'] = "Schritt 1: Sprache";
$locale['002'] = "Schritt 2: Schreibrechte &Uuml;berpr&uuml;fung";
$locale['003'] = "Schritt 3: Datenbank Einstellungen";
$locale['004'] = "Schritt 4: Konfiguration und Datenbank erstellen";
$locale['setup_0105'] = "Schritt 5: Configure Core System";
$locale['005'] = "Schritt 6: Seiten Administrator erstellen";
$locale['006'] = "Schritt 7: End Einstellungen";
$locale['007'] = "Weiter";
$locale['008'] = "Zur&uuml;ck";
$locale['009'] = "Fertig";

// Schritt 1
$locale['010'] = "<b>Bitte w&auml;hle die gew&uuml;nschte Sprache aus:</b>";
$locale['011'] = "Weitere Sprachen kannst du auf <a href='http://www.php-fusion.co.uk/' title='PHP-Fusion Official Support Seite' target='_blank' rel='nofollow'>PHP-Fusion Official Support Seite</a> herunterladen.";

// Schritt 2
$locale['020'] = "Um die Installation fortzusetzten, m&uuml;ssen die folgenden Dateien/Ordner schreibbar sein:";
$locale['021'] = "Alle Schreibrechte sind in Ordnung, klicke bitte auf &quot;<em>Weiter</em>&quot; um fortzufahren.";
$locale['022'] = "Die Schreibrechte sind nicht in Ordnung. Bitte gib den markierten Dateien/Ordnern die ben&ouml;tigten Schreibrechte.";
$locale['023'] = "Korrekt";
$locale['024'] = "Fehlerhaft";
$locale['025'] = "Erneut Pr&uuml;fen";

// Schritt 3
$locale['030'] = "Bitte gib deine MySQL-Datenbank Daten an, um die Installation fortzusetzten.";
$locale['031'] = "Datenbank Host:";
$locale['032'] = "Datenbank Benutzername:";
$locale['033'] = "Datenbank Passwort:";
$locale['034'] = "Datenbank Name:";
$locale['035'] = "Tabellen Prefix:";
$locale['036'] = "Cookie Prefix:";
$locale['037']  = "PDO zu aktivieren?";
$locale['038']  = "PDO scheint nicht verfügbar";
$locale['039']  = "Nein";
$locale['039b'] = "Ja";
$locale['039c'] = "Wählen Sie die Sprachen<br> aus die sie verwenden:";

// Schritt 4
$locale['040'] = "Die Datenbank Verbindung wurde hergestellt.";
$locale['041'] = "Die Konfiguration wurde erstellt.";
$locale['042'] = "Die Datenbank Tabellen wurden erstellt.";
$locale['043'] = "Fehler:";
$locale['044'] = "Die Verbindung zu dem MySQL-Server konnte nicht hergestellt werden.";
$locale['045'] = "Bitte &uuml;berpr&uuml;fe, ob dein Benutzername oder dein Passwort fehlerhaft ist.";
$locale['046'] = "Die Konfiguration konnte nicht erstellt werden.";
$locale['047'] = "Bitte &uuml;berpr&uuml;fe, ob die config.php schreibbar ist.";
$locale['048'] = "Die Datenbank Tabellen konnten nicht erstellt werden.";
$locale['049'] = "Du musst einen Namen f&uuml;r die Datenbank angeben.";
$locale['050'] = "Die Verbindung zu der MySQL-Datenbank konnte nicht hergestellt werden.";
$locale['051'] = "Die angegebene Datenbank existiert nicht.";
$locale['052'] = "Tabellen Prefix Fehler.";
$locale['053'] = "Das angegeben Tabellen Prefix ist bereits in Verwendung.";
$locale['054'] = "Die Datenbank Tabellen konnten nicht gel&ouml;scht und erstellt werden.";
$locale['055'] = "Bitte &uuml;berpr&uuml;fe, ob der Datenbank Benutzer f&uuml;r diese Datenbank die Rechte zum lesen, schreiben und l&ouml;schen hat.";
$locale['056'] = "Leere Felder.";
$locale['057'] = "Du musst alle Felder ausf&uuml;llen.";

// Step 5
$locale['setup_1400'] = "Please configure your core system.";
$locale['setup_1401'] = "IMPORTANT: Please back up your data if any before proceed. Removing a System will permanently erase all existing records.";
$locale['setup_1402'] = "Core System Ready.";
$locale['setup_1403'] = "Your website is now fully configured.<br/><br/>If you have not setup your Super Admin account yet, please proceed to the next step, otherwise, you can remove the installer.";
$locale['setup_1404'] = 'Install';
$locale['setup_1405'] = 'Uninstall';
$locale['setup_1406'] = '%s system have been successfully installed.';
$locale['setup_1407'] = '%s system system installation failed.';
$locale['setup_1408'] = '%s system have been successfully removed.';
$locale['setup_1409'] = '%s system cannot be removed or failed.';

// Schritt 5
$locale['060'] = "Bitte gib hier die Daten f&uuml;r deinen Seiten Administrator Account an.";
$locale['061'] = "Benutzername:";
$locale['062'] = "Passwort:";
$locale['063'] = "Passwort best&auml;tigen:";
$locale['064'] = "Admin Passwort:";
$locale['065'] = "Admin Passwort best&auml;tigen:";
$locale['066'] = "E-Mail Adresse:";

// Scrhitt 6
$locale['070']   = "Der Benutzername enth&auml;hlt ung&uuml;ltige Zeichen.";
$locale['070b']  = "Du musst einen Benutzernamen angeben.";
$locale['071']   = "Die beiden Login Passw&ouml;rter stimmen nicht &uuml;berein.";
$locale['072']   = "Das Login Passwort enth&auml;hlt ung&uuml;ltige Zeichen.<br />\n";
$locale['072']  .= "Das Login Passwort muss mindestens 8 Zeichen lang sein.";
$locale['072b']  = "Du musst ein Login Passwort angeben.";
$locale['073']   = "Die beiden Admin Passw&ouml;rter stimmen nicht &uuml;berein.";
$locale['074']   = "Das Login Passwort und Admin Passwort m&uuml;ssen sich von einander unterscheiden.";
$locale['075']   = "Das Admin Passwort enth&auml;hlt ung&uuml;ltige Zeichen.<br />\n";
$locale['075']  .= "Das Admin Passwort muss mindestens 8 Zeichen lang sein.";
$locale['075b']  = "Du musst ein Admin Passwort angeben.";
$locale['076']   = "Die E-Mail Adresse enth&auml;hlt ung&uuml;ltige Zeichen oder ist fehlerhaft.";
$locale['076b']  = "Du musst eine E-Mail Adresse angeben.";
$locale['077']   = "Dein Seiten Administrator Account konnte nicht erstellt werden.";

// Standart Daten - Administrations Punkte
$locale['080']  = "Administratoren";
$locale['081']  = "Artikel Kategorien";
$locale['082']  = "Artikel";
$locale['083']  = "Banner";
$locale['084']  = "BB-Codes";
$locale['085']  = "Blacklist";
$locale['086']  = "Kommentare";
$locale['087']  = "Eigene Seiten";
$locale['088']  = "Datenbank Backup";
$locale['089']  = "Download Kategorien";
$locale['090']  = "Downloads";
$locale['091']  = "FAQs";
$locale['092']  = "Forum";
$locale['093']  = "Bilder";
$locale['094']  = "Infusions";
$locale['095']  = "Infusions Panels";
$locale['096']  = "Benutzer";
$locale['097']  = "News Kategorien";
$locale['098']  = "News";
$locale['099']  = "Panels";
$locale['100']  = "Fotoalben";
$locale['101']  = "PHP Information";
$locale['102']  = "Umfragen";
$locale['103']  = "Navigationslinks";
$locale['104']  = "Navigationslinks";
$locale['105']  = "Smileys";
$locale['106']  = "Einsendungen";
$locale['107']  = "Update";
$locale['108']  = "Benutzergruppen";
$locale['109']  = "Link Kategorien";
$locale['110']  = "Links";
$locale['111']  = "Allgemeines";
$locale['112']  = "Zeit und Datum";
$locale['113']  = "Forum";
$locale['114']  = "Registration";
$locale['115']  = "Fotogalerie";
$locale['116']  = "Sonstiges";
$locale['117']  = "Private Nachrichten";
$locale['118']  = "Benutzerfelder";
$locale['119']  = "Foren R&auml;nge";
$locale['120']  = "Benutzerfelder Kategorien";
$locale['121']  = "News";
$locale['122']  = "Benutzer Verwaltung";
$locale['123']  = "Downloads";
$locale['124']  = "Objekte pro Seite";
$locale['125']  = "Sicherheit";
$locale['126']  = "News";      // Einstellungen
$locale['127']  = "Downloads"; // Einstellungen
$locale['128']  = "Admin Passw&ouml;rter zur&uuml;cksetzen";
$locale['129']  = "Fehlerlog";
$locale['129a'] = "Benutzerlog";
$locale['129b'] = "robots.txt";

// Standart Daten - Navigation
$locale['130'] = "Startseite";
$locale['131'] = "Artikel";
$locale['132'] = "Downloads";
$locale['133'] = "FAQ";
$locale['134'] = "Forum";
$locale['135'] = "Kontakt";
$locale['136'] = "News Kategorien";
$locale['137'] = "Weblinks";
$locale['138'] = "Fotogalerie";
$locale['139'] = "Suche";
$locale['140'] = "Link einsenden";
$locale['141'] = "News einsenden";
$locale['142'] = "Artikel einsenden";
$locale['143'] = "Foto einsenden";
$locale['144'] = "Download einsenden";

// Standart Daten - Panels
$locale['160'] = "Seiten Navigation";
$locale['161'] = "Benutzer Online";
$locale['162'] = "Foren Themen";
$locale['163'] = "Letzte Artikel";
$locale['164'] = "Willkommensnachricht";
$locale['165'] = "Letzte aktive Foren Themen";
$locale['166'] = "Benutzer Information";
$locale['167'] = "Mitglieder Umfrage";
$locale['168'] = "";

// Standart Daten - News Kategorien
$locale['180'] = "Fehler";
$locale['181'] = "Downloads";
$locale['182'] = "Spiele";
$locale['183'] = "Grafiken";
$locale['184'] = "Hardware";
$locale['185'] = "Magazin";
$locale['186'] = "Mitglieder";
$locale['187'] = "Mods";
$locale['188'] = "Filme";
$locale['189'] = "Netzwerk";
$locale['190'] = "News";
$locale['191'] = "PHP-Fusion";
$locale['192'] = "Sicherheit";
$locale['193'] = "Software";
$locale['194'] = "Themes";
$locale['195'] = "Windows";

// Standart Daten - Foren Raenge
$locale['200'] = "Seiten Administrator";
$locale['201'] = "Administrator";
$locale['202'] = "Moderator";
$locale['203'] = "Neuling";
$locale['204'] = "Jung Mitglied";
$locale['205'] = "Mitglied";
$locale['206'] = "Senior Mitglied";
$locale['207'] = "Veteran Mitglied";
$locale['208'] = "Fusioneer";

// Standart Daten - Smileys
$locale['210'] = "Smile";
$locale['211'] = "Wink";
$locale['212'] = "Sad";
$locale['213'] = "Frown";
$locale['214'] = "Shock";
$locale['215'] = "Pfft";
$locale['216'] = "Cool";
$locale['217'] = "Grin";
$locale['218'] = "Angry";

// Standart Daten - Benutzerfelder
$locale['220'] = "Kontakt Informationen";
$locale['221'] = "Sonstige Informationen";
$locale['222'] = "Optionen";
$locale['223'] = "Statistiken";
$locale['224'] = "Privacy";

// Abschlussnachricht
$locale['240']  = "Die Installation von PHP-Fusion v7 ist nun abgeschlossen und benutzbar.<br />\n";
$locale['240'] .= "Sobald du unterhalb auf &quot;<em>Weiter</em>&quot; klickst, kommst du auf deine neue Homepage.<br />\n";
$locale['240'] .= "<strong>ACHTUNG</strong> Nachdem du deine Homepage betreten hast, l&ouml;sche unbedingt die <strong>setup.php</strong> von deinem Server und setzte die <strong>Schreibrechte der config.php auf 0644</strong>! ";
$locale['240'] .= "Andersfalls entsteht eine Sicherheitsl&uuml;cke.<br />\n";
$locale['240'] .= "Vielen Dank, dass du dich f&uuml;r PHP-Fusion entschieden hast.\n";

// Standart Daten - Zeit und Datum
$locale['shortdate']     = "%d.%m.%y";
$locale['longdate']      = "%d. %B %Y um %H:%M:%S";
$locale['forumdate']     = "%d.%m.%Y um %H:%M";
$locale['newsdate']      = "%d. %B %Y";
$locale['subheaderdate'] = "%d. %B %Y - %H:%M:%S";
//Multilanguage table rights
    $locale['MLT001'] = "Articles";
    $locale['MLT002'] = "Custom Pages";
    $locale['MLT003'] = "Downloads";
    $locale['MLT004'] = "FAQs";
    $locale['MLT005'] = "Forums";
    $locale['MLT006'] = "News";
    $locale['MLT007'] = "Photogallery";
    $locale['MLT008'] = "Polls";
    $locale['MLT010'] = "Weblinks";
    $locale['MLT011'] = "Sitelinks";
    $locale['MLT012'] = "Panels";
    $locale['MLT013'] = "Forum Ranks";
// Language Admin
    $locale['L001'] = "Multi Language";	
?>