<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
| Lizenz:CCL v1.0
+--------------------------------------------------------+
| Filename: german.php
| Author: matze
+--------------------------------------------------------*/
global $userdata;
/* Titles */
$locale['translation_title'] = "Tutorial-Portal";
$locale['translation_desc'] = "Tutorial-Portal 1.0 Unikat";
$locale['translation_admin'] = "Tutorial-Portal";
// Registration
$locale['reg01'] = "Tutorial-Portal registrieren";
$locale['reg02'] = "Hallo %s, bevor Du das Portal nutzen kannst, musst Du es registrieren.";
$locale['reg03'] = "";
$locale['reg04'] = "Diese Seiten-URL kopieren:";
$locale['reg05'] = "Reg. Key holen:";
$locale['reg06'] = "Zum Registrierungs-Formular";
$locale['reg07'] = "Ident Key eingeben:";
$locale['reg08'] = "Reg. Key eingeben:";
$locale['reg09'] = "Speichern";
$locale['reg10'] = "Infusions Verifizierung";
$locale['reg11'] = "Wenn die Registrierung erfolgreich war und die Keys g&uumlltig sind, wird sich das Admin dieser Infusion nach klick auf Speichern &ouml;ffnen und sich die Funktionen dieser Infusion Aktivieren.";
//Locales
$locale['translation_g000'] = "Nein";
$locale['no-color'] = "#d61111";
$locale['translation_g001'] = "Ja";
$locale['yes-color'] = "#0eb72b";
$locale['translation_g003'] = "Optionen";
$locale['translation_g004'] = "Bearbeiten";
$locale['translation_g005'] = "L&ouml;schen";
$locale['translation_g006'] = "Eingesendet von";
$locale['translation_g006a'] = "Eisendung";
$locale['translation_g006b'] = " von ";
$locale['translation_g007'] = "Status";
$locale['translation_g009'] = "Unklar";
$locale['translation_g010'] = "Tutorial";
$locale['translation_g011'] = "Name des Tutorials";
$locale['translation_g012'] = "Tutorial erneuert";
$locale['translation_g013'] = "N/A";
//Fehlermeldungen
$locale['translation_e000'] = "<strong>".(iMEMBER ? $userdata['user_name'] : "Gast")."</strong> du hast keinen Zugang!";
$locale['translation_e001'] = "Du hast keinen Zugriff auf die Kategorie! ";
$locale['translation_e002'] = "Du hast keinen Zugang zu dieser Seite!.";
$locale['translation_e003'] = "Du hast keine Berechtigung die Datei herunterzuladen!";
$locale['translation_e004'] = "Du hast keine Berechtigung die Datei herunterzuladen!";
//admin_navigation.php
$locale['translation_an001'] = "Tutorial-Administration";
$locale['translation_an002'] = "Einstellungen";
$locale['translation_an003'] = "Kategorien";
//Errors > translation_admin.php
$locale['translation_ae000'] = "Name kann nicht leer bleiben";
$locale['translation_ae001'] = "Unkorrekter Dateiname";
$locale['translation_ae002'] = "Datei muss mindestens %s.";
$locale['translation_ae003'] = "Folgende Dateitypen sind erlaubt: %s.";
$locale['translation_ae004'] = "Beschreibung darf nicht lerr sein.";
$locale['translation_ae005'] = "Unklarer Fehler";
//translation_admin.php
$locale['translation_am001'] = "Neues Tutorial wurde erstellt";
$locale['translation_am002'] = "Wurde erneuert";
$locale['translation_am003'] = "Wurde gel&ouml;scht";
$locale['translation_a000'] = "Folgendes Tutorial bearbeiten: ";
$locale['translation_a001'] = "Neues Tutorial erstellen";
$locale['translation_a002'] = "Name";
$locale['translation_a003'] = "Author";
$locale['translation_a014'] = "Status";
$locale['translation_a015'] = "Kategorie";
$locale['translation_a018'] = "Datei";
$locale['translation_a019'] = "Max. Dateigr&ouml;sse: %s / Erlaubte Dateitypen: %s";
$locale['translation_a020'] = "Fertigstellung";
$locale['translation_a020a'] = " Datum";
$locale['translation_a021'] = " Typ";
$locale['translation_a022'] = "Beschreibung";
$locale['translation_a022a'] = "Beschreibung deines Tutorials";
$locale['translation_a023'] = "Code/Beschreibung";
$locale['translation_a023a'] = "";
$locale['translation_a026'] = "Kommentare erlauben";
$locale['translation_a027'] = "Bewertungen erlauben";
$locale['translation_a028'] = "Hide Author";
$locale['translation_a028m'] = "Zugang";
$locale['translation_a028m2'] = "Zugang zum Download";
$locale['translation_a028m3'] = " Heutiges Datum setzen";
$locale['translation_a029'] = "Update Tutorial";
$locale['translation_a030'] = "Neues Tutorial speichern";
$locale['translation_a031'] = "Aktuelle Tutorials in den Kategorien";
$locale['translation_a032'] = "Name";
$locale['translation_a036'] = "Speichern";
$locale['translation_a037'] = "L&ouml;schen";
$locale['translation_a038'] = "Nichts vorhanden!.";
//translation_settings.php
$locale['translation_as000'] = "Einstellungen";
$locale['translation_as001'] = "Seiten Einstellungen";
$locale['translation_as002'] = "Anzeige pro Seite";
$locale['translation_as003'] = "Kategorie pro Seite";
$locale['translation_as004'] = "Reihen-Einstellungen";
$locale['translation_as005'] = "Kategorie Reihenanzeige";
$locale['translation_as006'] = "1er Reihe";
$locale['translation_as007'] = "2er Reihe";
$locale['translation_as008'] = "3er Reihe";
$locale['translation_as009'] = "Tutorial-Reihenanzeige";
$locale['translation_as010'] = "Andere Einstellungen";
$locale['translation_as011'] = "Kommentare Ein";
$locale['translation_as013'] = "Status Panel Ein";
$locale['translation_as014'] = "Zugang hat";
$locale['translation_as015'] = "Einstellungen speichern";
//translation_cats.php
$locale['translation_ac000'] = "Kategorie erstellen";
$locale['translation_ac001'] = "Kategorie wurde erneuert";
$locale['translation_ac002'] = "Kategorie kann nicht gel&ouml;scht werden";
$locale['translation_ac003'] = "Es befinden sich &Uuml;bersetzungen in dieser Kategorie!";
$locale['translation_ac004'] = "Kategorie wurde gel&ouml;scht";
$locale['translation_ac005'] = "Kategorie bearbeiten ";
$locale['translation_ac006'] = "Erstelle eine neue Kategorie";
$locale['translation_ac007'] = "Kategoriename";
$locale['translation_ac008'] = "Beschreibung";
$locale['translation_ac009'] = "Sortieren nach";
$locale['translation_ac010'] = "Tutorial-ID";
$locale['translation_ac011'] = "Tutorial-Name";
$locale['translation_ac012'] = "Tutorial-Datum";
$locale['translation_ac013'] = "Aufw&auml;rts";
$locale['translation_ac014'] = "Abw&auml;rts";
$locale['translation_ac015'] = "Kategoriezugang";
$locale['translation_ac016'] = "Kategoriegrafik";
$locale['translation_ac017'] = "Kategorie speichern";

$locale['cat_open'] = "Vorhandene Kategorien";
$locale['cat_name'] = "Kategorie";
$locale['cat_zu'] = "Zugang";
$locale['translation_ac021'] = "Kategorie l&ouml;schen?";
$locale['no_cat'] = "Keine Kategorien vorhanden.";
//translation_reports.php
$locale['translation_ar000'] = "Nicht zuweisbar";
$locale['translation_ar001'] = "Tutorial-ID";
$locale['translation_ar002'] = "Fehler von";
$locale['translation_ar003'] = "Erl&auml;uterung";
$locale['translation_ar004'] = "Link nicht definierbar";
$locale['translation_ar005'] = "Zuweisbar";
$locale['translation_ar006'] = "Nicht zugewiesen";
$locale['translation_ar007'] = "Beauftragt";
$locale['translation_ar008'] = "Nicht ausführbar";
$locale['translation_ar009'] = "Fix";
$locale['translation_ar010'] = "Tutorial: ";
$locale['translation_ar011'] = "Fehlermeldung";
$locale['translation_ap008'] = "Kommentare";
//translation_panel.php
$locale['translation_dip000'] = "Tutorial-Portal 1.0";
$locale['translation_dip002'] = "Name";
$locale['translation_dip003'] = "Kategorie";
$locale['translation_dip004'] = "Erstellt am";
$locale['translation_dip005'] = "Author";
$locale['translation_dip007'] = "Fertiggestellt";
$locale['translation_dip010'] = "Die Kategorie hat einen Download";
$locale['translation_dip012'] = "Fertigstellung";
$locale['translation_dip013a'] = "Tutorial erstellen";
$locale['translation_dip014'] = "Downloads";
$locale['translation_dip015'] = "Popul&auml;rste";
$locale['translation_dip016'] = "Bewertungen";
$locale['translation_dip018'] = "Kein Tutorial vorhanden.";
//translation.php
$locale['translation_d000'] = "Tutorial-Kategorien";
$locale['translation_d001'] = " Neu";
$locale['translation_d002'] = "Keine Kategorien gefunden ";
$locale['translation_d003'] = "Kategorie";
$locale['translation_d004'] = "Alle";
$locale['translation_d005'] = "Sortieren nach ";
$locale['translation_d006'] = "Tutorial-ID";
$locale['translation_d007'] = "Tutorial-Name";
$locale['translation_d008'] = "Author";
$locale['translation_d009'] = "Downloadz&auml;hler";
$locale['translation_d010'] = "Datum";
$locale['translation_d011'] = "Neuste Tutorials";
$locale['translation_d012'] = "Letztes Update";
$locale['translation_d013'] = "ASC";
$locale['translation_d014'] = "DESC";
$locale['translation_d015'] = "Author ";
$locale['translation_d018'] = "Status ";
$locale['translation_d021'] = "Kommentare";
$locale['translation_d022'] = "Geschlossen";
$locale['translation_d023'] = "Keine Addons vorhanden.";
//NEW
$locale['translation_d024'] = "Keine Eintr&auml;ge vorhanden.";
$locale['translation_scn'] = "Werden jedem Mitglied abgezogen";
$locale['no-sc'] = "#d61111";
$locale['translation_scj'] = "Werden nicht abgezogen";
$locale['yes-sc'] = "#0eb72b";
//portal.php
$locale['translation_v001'] = "Letztes Update";
$locale['translation_v003'] = "Kategorie";
$locale['translation_v004'] = "Kompatibel";
$locale['translation_v005'] = "Tutorial Author";
$locale['translation_v006'] = "Letztes Update";
$locale['translation_v007'] = "Erstellt";
$locale['translation_v008'] = "Ver&ouml;ffentlichung";
$locale['translation_v012'] = "Beschreibung";
$locale['translation_v013'] = "Hinweis";
$locale['translation_v014'] = "Historie";
$locale['translation_v016'] = "Erstellt";
$locale['translation_v017'] = "Fertiggestellt";
$locale['translation_v019'] = "Item";
$locale['translation_v020'] = "Datum";
$locale['translation_v022'] = "&Auml;hnliche Tutorials";
$locale['translation_v023'] = "Name";
$locale['translation_v024'] = "Kategorie";
$locale['translation_v025'] = "Author";
$locale['translation_v026'] = "Erstellt";
$locale['translation_v030'] = "Fehler";
$locale['translation_v032'] = "Bewertungen";
$locale['translation_v033'] = "Bewertungen sind momentan deaktiviert.";
$locale['translation_v034'] = "Kommentare";
$locale['translation_v035'] = "Kommentare sind momentan deaktiviert.";
//downloads.php
$locale['translation_dd000'] = "Tutorial-&Uuml;bersicht";
$locale['translation_dd001'] = "Name";
$locale['translation_dd002'] = "Kategorie";
$locale['translation_dd003'] = "Author";
$locale['translation_dd005'] = "Downloads";
$locale['translation_dd006'] = "Es befinden sich keine Downloads hier.";
//popular.php
$locale['translation_pd000'] = "%u Beliebtesten";
$locale['translation_pd001'] = "Name";
$locale['translation_pd002'] = "Kategorie";
$locale['translation_pd003'] = "Author";
$locale['translation_pd004'] = "Version";
$locale['translation_pd005'] = "Downloads";
$locale['translation_pd006'] = "Keine Tutorials gefunden.";
//Bewertungen
$locale['translation_tr000'] = "Bewertungs-&Uuml;bersicht";
$locale['translation_tr001'] = "Name";
$locale['translation_tr002'] = "Kategorie";
$locale['translation_tr003'] = "Author";
$locale['translation_tr004'] = "Bewertung";
$locale['translation_tr005'] = "Keine Bewertungen";
$locale['translation_tr006'] = "Es wurde momentan nichts bewertet!";
//includes/nav.php
$locale['translation_dn000'] = "Tutorials";
$locale['translation_dn001'] = "Downloads";
$locale['translation_dn002'] = "Bewertungen";
$locale['translation_dn005'] = "Administration";
$locale['hinweis'] = "Hinweisnachricht";
//includes/stats.php
$locale['translation_ds000'] = "Tutorial-Info";
$locale['translation_ds001'] = "Tutorial";
$locale['translation_ds002'] = " Tutorials";
$locale['translation_ds007'] = " Heute erstellte";
$locale['translation_ds008'] = " Aktualisierte Heute";
$locale['translation_ds009'] = "Tutorials: ";
$locale['translation_ds010'] = "Am aktivsten: ";
$locale['translation_ds011'] = "Die Neusten: ";

//Übersicht-Member
$locale['dat_000'] = "&Uuml;bersicht-Mitglieder";
$locale['dat_001'] = "Mitgliedsname";
$locale['dat_002'] = "User-IP";
$locale['dat_003'] = "Kosten";
$locale['dat_004'] = "PN Schicken";
$locale['dat_005'] = "Dateiname";
$locale['dat_006'] = "Wieviel mal?";
$locale['dat_007'] = "Wann?";
$locale['dat_008'] = "Optionen";
$locale['dat_009'] = "L&ouml;schen";
?>