-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 31. Mrz 2015 um 20:17
-- Server Version: 5.6.21
-- PHP-Version: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `test`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `arrowchat`
--

CREATE TABLE IF NOT EXISTS `arrowchat` (
`id` int(10) unsigned NOT NULL,
  `from` varchar(25) NOT NULL,
  `to` varchar(25) NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL,
  `read` int(10) unsigned NOT NULL,
  `user_read` tinyint(1) NOT NULL DEFAULT '0',
  `direction` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `arrowchat_admin`
--

CREATE TABLE IF NOT EXISTS `arrowchat_admin` (
`id` int(3) unsigned NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `arrowchat_admin`
--

INSERT INTO `arrowchat_admin` (`id`, `username`, `password`, `email`) VALUES
(1, 'Sina', 'e3c6d0d462e4100308487ff083ef2e03', 'test@mail.com');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `arrowchat_applications`
--

CREATE TABLE IF NOT EXISTS `arrowchat_applications` (
`id` int(3) unsigned NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `folder` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `icon` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `width` int(4) unsigned NOT NULL,
  `height` int(4) unsigned NOT NULL,
  `bar_width` int(3) unsigned DEFAULT NULL,
  `bar_name` varchar(100) DEFAULT NULL,
  `dont_reload` tinyint(1) unsigned DEFAULT '0',
  `default_bookmark` tinyint(1) unsigned DEFAULT '1',
  `show_to_guests` tinyint(1) unsigned DEFAULT '1',
  `link` varchar(255) DEFAULT NULL,
  `update_link` varchar(255) DEFAULT NULL,
  `version` varchar(20) DEFAULT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `arrowchat_banlist`
--

CREATE TABLE IF NOT EXISTS `arrowchat_banlist` (
`ban_id` int(10) unsigned NOT NULL,
  `ban_userid` varchar(25) DEFAULT NULL,
  `ban_ip` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `arrowchat_chatroom_banlist`
--

CREATE TABLE IF NOT EXISTS `arrowchat_chatroom_banlist` (
  `user_id` varchar(25) COLLATE utf8_bin NOT NULL,
  `chatroom_id` int(10) unsigned NOT NULL,
  `ban_length` int(10) unsigned NOT NULL,
  `ban_time` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `arrowchat_chatroom_messages`
--

CREATE TABLE IF NOT EXISTS `arrowchat_chatroom_messages` (
`id` int(10) unsigned NOT NULL,
  `chatroom_id` int(10) unsigned NOT NULL,
  `user_id` varchar(25) COLLATE utf8_bin NOT NULL,
  `username` varchar(100) COLLATE utf8_bin NOT NULL,
  `message` text COLLATE utf8_bin NOT NULL,
  `global_message` tinyint(1) unsigned DEFAULT '0',
  `is_mod` tinyint(1) unsigned DEFAULT '0',
  `is_admin` tinyint(1) unsigned DEFAULT '0',
  `sent` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `arrowchat_chatroom_rooms`
--

CREATE TABLE IF NOT EXISTS `arrowchat_chatroom_rooms` (
`id` int(10) unsigned NOT NULL,
  `author_id` varchar(25) COLLATE utf8_bin NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `password` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `length` int(10) unsigned NOT NULL,
  `max_users` int(10) NOT NULL DEFAULT '0',
  `session_time` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `arrowchat_chatroom_users`
--

CREATE TABLE IF NOT EXISTS `arrowchat_chatroom_users` (
  `user_id` varchar(25) COLLATE utf8_bin NOT NULL,
  `chatroom_id` int(10) unsigned NOT NULL,
  `is_admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_mod` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `block_chats` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `session_time` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `arrowchat_config`
--

CREATE TABLE IF NOT EXISTS `arrowchat_config` (
  `config_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `config_value` text,
  `is_dynamic` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `arrowchat_config`
--

INSERT INTO `arrowchat_config` (`config_name`, `config_value`, `is_dynamic`) VALUES
('admin_background_color', '', 0),
('admin_chat_all', '0', 0),
('admin_text_color', '', 0),
('admin_view_maintenance', '0', 0),
('announcement', '', 0),
('applications_guests', '1', 0),
('applications_on', '0', 0),
('auto_popup_chatbox', '1', 0),
('bar_fixed', '0', 0),
('bar_fixed_alignment', 'center', 0),
('bar_fixed_width', '900', 0),
('bar_padding', '15', 0),
('base_url', '/chat/', 0),
('blocked_words', 'fuck,[shit],nigger,[cunt],[ass],asshole', 0),
('buddy_list_heart_beat', '60', 0),
('chat_maintenance', '0', 0),
('chatroom_auto_join', '0', 0),
('chatroom_history_length', '60', 0),
('chatrooms_on', '0', 0),
('desktop_notifications', '0', 0),
('disable_arrowchat', '0', 0),
('disable_avatars', '0', 0),
('disable_buddy_list', '1', 0),
('disable_smilies', '0', 0),
('enable_chat_animations', '1', 0),
('enable_mobile', '0', 0),
('facebook_app_id', '', 0),
('file_transfer_on', '0', 0),
('guest_name_bad_words', 'fuck,cunt,nigger,shit,admin,administrator,mod,moderator,support', 0),
('guest_name_change', '1', 0),
('guest_name_duplicates', '0', 0),
('guests_can_chat', '0', 0),
('guests_can_view', '0', 0),
('guests_chat_with', '1', 0),
('heart_beat', '3', 0),
('hide_admins_buddylist', '0', 0),
('hide_applications_menu', '0', 0),
('hide_bar_on', '1', 0),
('idle_time', '3', 0),
('install_time', '1427741954', 0),
('language', 'en', 0),
('login_url', '', 0),
('notifications_on', '0', 0),
('online_timeout', '120', 0),
('popout_chat_on', '1', 0),
('push_on', '0', 0),
('push_publish', '', 0),
('push_subscribe', '', 0),
('search_number', '10', 0),
('show_bar_links_right', '0', 0),
('show_full_username', '0', 0),
('theme', 'new_facebook_full', 0),
('theme_change_on', '0', 0),
('us_time', '1', 0),
('user_chatrooms', '0', 0),
('user_chatrooms_flood', '10', 0),
('user_chatrooms_length', '30', 0),
('users_chat_with', '3', 0),
('video_chat', '1', 0),
('width_applications', '16', 0),
('width_buddy_list', '189', 0),
('width_chatrooms', '16', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `arrowchat_graph_log`
--

CREATE TABLE IF NOT EXISTS `arrowchat_graph_log` (
`id` int(6) unsigned NOT NULL,
  `date` varchar(30) NOT NULL,
  `user_messages` int(10) unsigned DEFAULT '0',
  `chat_room_messages` int(10) unsigned DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `arrowchat_notifications`
--

CREATE TABLE IF NOT EXISTS `arrowchat_notifications` (
`id` int(25) unsigned NOT NULL,
  `to_id` varchar(25) NOT NULL,
  `author_id` varchar(25) NOT NULL,
  `author_name` varchar(100) NOT NULL,
  `misc1` varchar(255) DEFAULT NULL,
  `misc2` varchar(255) DEFAULT NULL,
  `misc3` varchar(255) DEFAULT NULL,
  `type` int(3) unsigned NOT NULL,
  `alert_read` int(1) unsigned NOT NULL DEFAULT '0',
  `user_read` int(1) unsigned NOT NULL DEFAULT '0',
  `alert_time` int(15) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `arrowchat_notifications_markup`
--

CREATE TABLE IF NOT EXISTS `arrowchat_notifications_markup` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` int(3) unsigned NOT NULL,
  `markup` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `arrowchat_notifications_markup`
--

INSERT INTO `arrowchat_notifications_markup` (`id`, `name`, `type`, `markup`) VALUES
(1, 'Private Messages', 1, '<div class="arrowchat_notification_box arrowchat_blue_link"><img src="/chat/themes/new_facebook_full/images/icons/notification_message_icon.png" class="arrowchat_notification_icon" /><a href="#">{author_name}</a> has sent you a new message.<br /><div class="arrowchat_received">Received {longago}</div></div><div class="arrowchat_notifications_divider"></div>'),
(2, 'Friend Requests', 2, '<div class="arrowchat_notification_box arrowchat_blue_link"><img src="/chat/themes/new_facebook_full/images/icons/notification_friend_icon.png" class="arrowchat_notification_icon" /><a href="#">{author_name}</a> has sent you a friend request.<br /><div class="arrowchat_received">Received {longago}</div></div><div class="arrowchat_notifications_divider"></div>'),
(3, 'Wall Post', 3, '<div class="arrowchat_notification_box arrowchat_blue_link"><img src="/chat/themes/new_facebook_full/images/icons/notification_wall_post.png" class="arrowchat_notification_icon" /><a href="#">{author_name}</a> has wrote on your wall.<br /><div class="arrowchat_received">Received {longago}</div></div><div class="arrowchat_notifications_divider"></div>'),
(4, 'Event Invite', 4, '<div class="arrowchat_notification_box arrowchat_blue_link"><img src="/chat/themes/new_facebook_full/images/icons/notification_event.png" class="arrowchat_notification_icon" /><a href="#">{author_name}</a> has invited you to an event.<br /><div class="arrowchat_received">Received {longago}</div></div><div class="arrowchat_notifications_divider"></div>'),
(5, 'Group Invite', 5, '<div class="arrowchat_notification_box arrowchat_blue_link"><img src="/chat/themes/new_facebook_full/images/icons/notification_group.png" class="arrowchat_notification_icon" /><a href="#">{author_name}</a> has invited you to a group.<br />	<div class="arrowchat_received">Received {longago}</div></div><div class="arrowchat_notifications_divider"></div>'),
(6, 'Birthday', 6, '<div class="arrowchat_notification_box arrowchat_blue_link"><img src="/chat/themes/new_facebook_full/images/icons/notification_birthday.png" class="arrowchat_notification_icon" />It is <a href="#">{author_name}</a>''s birthday!<br /><div class="arrowchat_received">Received {longago}</div></div><div class="arrowchat_notifications_divider"></div>'),
(7, 'Comment', 7, '<div class="arrowchat_notification_box arrowchat_blue_link"><img src="/chat/themes/new_facebook_full/images/icons/notification_comment.png" class="arrowchat_notification_icon" /><a href="#">{author_name}</a> has left you a comment.<br /><div class="arrowchat_received">Received {longago}</div></div><div class="arrowchat_notifications_divider"></div>'),
(8, 'Reply', 8, '<div class="arrowchat_notification_box arrowchat_blue_link"><img src="/chat/themes/new_facebook_full/images/icons/notification_reply.png" class="arrowchat_notification_icon" /><a href="#">{author_name}</a> has replied to you.<br /><div class="arrowchat_received">Received {longago}</div></div><div class="arrowchat_notifications_divider"></div>'),
(9, 'Like Post', 9, '<div class="arrowchat_notification_box arrowchat_blue_link"><img src="/chat/themes/new_facebook_full/images/icons/notification_like.png" class="arrowchat_notification_icon" /><a href="#">{author_name}</a> has liked your post.<br /><div class="arrowchat_received">Received {longago}</div></div><div class="arrowchat_notifications_divider"></div>'),
(10, 'Like Comment', 10, '<div class="arrowchat_notification_box arrowchat_blue_link"><img src="/chat/themes/new_facebook_full/images/icons/notification_like.png" class="arrowchat_notification_icon" /><a href="#">{author_name}</a> has liked your comment.<br /><div class="arrowchat_received">Received {longago}</div></div><div class="arrowchat_notifications_divider"></div>'),
(11, 'Like Photo', 11, '<div class="arrowchat_notification_box arrowchat_blue_link"><img src="/chat/themes/new_facebook_full/images/icons/notification_like.png" class="arrowchat_notification_icon" /><a href="#">{author_name}</a> has liked your photo.<br /><div class="arrowchat_received">Received {longago}</div></div><div class="arrowchat_notifications_divider"></div>');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `arrowchat_smilies`
--

CREATE TABLE IF NOT EXISTS `arrowchat_smilies` (
`id` int(3) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `code` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `arrowchat_smilies`
--

INSERT INTO `arrowchat_smilies` (`id`, `name`, `code`) VALUES
(1, 'smiley', ':)'),
(2, 'smiley-mad', '>:('),
(3, 'smiley-lol', ':D'),
(4, 'smiley-wink', ';)'),
(5, 'smiley-surprise', ':o'),
(6, 'smiley-cool', '8)'),
(7, 'smiley-neutral', ':|'),
(8, 'smiley-cry', ':''('),
(9, 'smiley-razz', ':p'),
(10, 'smiley-confuse', ':s'),
(11, 'smiley', ':-)'),
(12, 'smiley-sad', ':-('),
(13, 'smiley-wink', ';-)'),
(14, 'smiley-surprise', ':-o'),
(15, 'smiley-cool', '8-)'),
(16, 'smiley-neutral', ':-|'),
(17, 'smiley-razz', ':-p'),
(18, 'smiley-confuse', ':-s'),
(20, 'smiley-sad', ':(');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `arrowchat_status`
--

CREATE TABLE IF NOT EXISTS `arrowchat_status` (
  `userid` varchar(25) NOT NULL,
  `guest_name` varchar(50) DEFAULT NULL,
  `message` text,
  `status` varchar(10) DEFAULT NULL,
  `theme` int(3) unsigned DEFAULT NULL,
  `popout` int(11) unsigned DEFAULT NULL,
  `typing` text,
  `hide_bar` tinyint(1) unsigned DEFAULT NULL,
  `play_sound` tinyint(1) unsigned DEFAULT '1',
  `window_open` tinyint(1) unsigned DEFAULT NULL,
  `only_names` tinyint(1) unsigned DEFAULT NULL,
  `chatroom_window` varchar(2) NOT NULL DEFAULT '-1',
  `chatroom_stay` varchar(2) NOT NULL DEFAULT '-1',
  `chatroom_block_chats` tinyint(1) unsigned DEFAULT NULL,
  `chatroom_sound` tinyint(1) unsigned DEFAULT NULL,
  `announcement` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `unfocus_chat` text,
  `focus_chat` varchar(50) DEFAULT NULL,
  `last_message` text,
  `clear_chats` text,
  `apps_bookmarks` text,
  `apps_other` text,
  `apps_open` int(10) unsigned DEFAULT NULL,
  `apps_load` text,
  `block_chats` text,
  `session_time` int(20) unsigned NOT NULL DEFAULT '0',
  `is_admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hash_id` varchar(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `arrowchat_themes`
--

CREATE TABLE IF NOT EXISTS `arrowchat_themes` (
`id` int(3) unsigned NOT NULL,
  `folder` varchar(25) NOT NULL,
  `name` varchar(100) NOT NULL,
  `active` tinyint(1) unsigned NOT NULL,
  `update_link` varchar(255) DEFAULT NULL,
  `version` varchar(20) DEFAULT NULL,
  `default` tinyint(1) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `arrowchat_themes`
--

INSERT INTO `arrowchat_themes` (`id`, `folder`, `name`, `active`, `update_link`, `version`, `default`) VALUES
(1, 'new_facebook_full', 'New Facebook Full', 1, 'http://www.arrowchat.com/updatecheck.php?id=8', '4.0', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `arrowchat_trayicons`
--

CREATE TABLE IF NOT EXISTS `arrowchat_trayicons` (
`id` int(3) unsigned NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `icon` varchar(100) NOT NULL,
  `location` varchar(255) NOT NULL,
  `target` varchar(25) DEFAULT NULL,
  `width` int(4) unsigned DEFAULT NULL,
  `height` int(4) unsigned DEFAULT NULL,
  `tray_width` int(3) unsigned DEFAULT NULL,
  `tray_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `tray_location` int(3) unsigned NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_admin`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_admin` (
`admin_id` mediumint(8) unsigned NOT NULL,
  `admin_rights` char(4) NOT NULL DEFAULT '',
  `admin_image` varchar(50) NOT NULL DEFAULT '',
  `admin_title` varchar(50) NOT NULL DEFAULT '',
  `admin_link` varchar(100) NOT NULL DEFAULT 'reserved',
  `admin_page` tinyint(1) unsigned NOT NULL DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fusionu92g5_admin`
--

INSERT INTO `fusionu92g5_admin` (`admin_id`, `admin_rights`, `admin_image`, `admin_title`, `admin_link`, `admin_page`) VALUES
(1, 'AD', 'admins.gif', 'Administratoren', 'administrators.php', 2),
(2, 'APWR', 'admin_pass.gif', 'Admin Passw&ouml;rter zur&uuml;cksetzen', 'admin_reset.php', 2),
(3, 'AC', 'article_cats.gif', 'Artikel Kategorien', 'article_cats.php', 1),
(4, 'A', 'articles.gif', 'Artikel', 'articles.php', 1),
(5, 'SB', 'banners.gif', 'Banner', 'banners.php', 3),
(6, 'BB', 'bbcodes.gif', 'BB-Codes', 'bbcodes.php', 3),
(7, 'B', 'blacklist.gif', 'Blacklist', 'blacklist.php', 2),
(8, 'C', '', 'Kommentare', 'reserved', 2),
(9, 'CP', 'c-pages.gif', 'Eigene Seiten', 'custom_pages.php', 1),
(10, 'DB', 'db_backup.gif', 'Datenbank Backup', 'db_backup.php', 3),
(11, 'DC', 'dl_cats.gif', 'Download Kategorien', 'download_cats.php', 1),
(12, 'D', 'dl.gif', 'Downloads', 'downloads.php', 1),
(13, 'ERRO', 'errors.gif', 'Fehlerlog', 'errors.php', 3),
(14, 'FQ', 'faq.gif', 'FAQs', 'faq.php', 1),
(15, 'F', 'forums.gif', 'Forum', 'forums.php', 1),
(16, 'IM', 'images.gif', 'Bilder', 'images.php', 1),
(17, 'I', 'infusions.gif', 'Infusions', 'infusions.php', 3),
(18, 'IP', '', 'Infusions Panels', 'reserved', 3),
(19, 'M', 'members.gif', 'Benutzer', 'members.php', 2),
(20, 'NC', 'news_cats.gif', 'News Kategorien', 'news_cats.php', 1),
(21, 'N', 'news.gif', 'News', 'news.php', 1),
(22, 'P', 'panels.gif', 'Panels', 'panels.php', 3),
(23, 'PL', 'permalink.gif', 'Permalinks', 'permalink.php', 3),
(24, 'PH', 'photoalbums.gif', 'Fotoalben', 'photoalbums.php', 1),
(25, 'PI', 'phpinfo.gif', 'PHP Information', 'phpinfo.php', 3),
(26, 'PO', 'polls.gif', 'Umfragen', 'polls.php', 1),
(27, 'SL', 'site_links.gif', 'Navigationslinks', 'site_links.php', 3),
(28, 'SM', 'smileys.gif', 'Smileys', 'smileys.php', 3),
(29, 'SU', 'submissions.gif', 'Einsendungen', 'submissions.php', 2),
(30, 'U', 'upgrade.gif', 'Update', 'upgrade.php', 3),
(31, 'UG', 'user_groups.gif', 'Benutzergruppen', 'user_groups.php', 2),
(32, 'WC', 'wl_cats.gif', 'Link Kategorien', 'weblink_cats.php', 1),
(33, 'W', 'wl.gif', 'Links', 'weblinks.php', 1),
(34, 'S1', 'settings.gif', 'Allgemeines', 'settings_main.php', 4),
(35, 'S2', 'settings_time.gif', 'Zeit und Datum', 'settings_time.php', 4),
(36, 'S3', 'settings_forum.gif', 'Forum', 'settings_forum.php', 4),
(37, 'S4', 'registration.gif', 'Registration', 'settings_registration.php', 4),
(38, 'S5', 'photoalbums.gif', 'Fotogalerie', 'settings_photo.php', 4),
(39, 'S6', 'settings_misc.gif', 'Sonstiges', 'settings_misc.php', 4),
(40, 'S7', 'settings_pm.gif', 'Private Nachrichten', 'settings_messages.php', 4),
(41, 'S8', 'settings_news.gif', 'News', 'settings_news.php', 4),
(42, 'S9', 'settings_users.gif', 'Benutzer Verwaltung', 'settings_users.php', 4),
(43, 'S10', 'settings_ipp.gif', 'Objekte pro Seite', 'settings_ipp.php', 4),
(44, 'S11', 'settings_dl.gif', 'Downloads', 'settings_dl.php', 4),
(45, 'S12', 'security.gif', 'Sicherheit', 'settings_security.php', 4),
(46, 'UF', 'user_fields.gif', 'Benutzerfelder', 'user_fields.php', 2),
(47, 'FR', 'forum_ranks.gif', 'Foren R&auml;nge', 'forum_ranks.php', 2),
(48, 'UFC', 'user_fields_cats.gif', 'Benutzerfelder Kategorien', 'user_field_cats.php', 2),
(49, 'UL', 'user_log.gif', 'Benutzerlog', 'user_log.php', 2),
(50, 'ROB', 'robots.gif', 'robots.txt', 'robots.php', 3),
(51, 'MAIL', 'email.gif', 'Email Templates', 'email.php', 3),
(52, 'LANG', 'languages.gif', 'Language Settings', 'settings_languages.php', 4),
(53, 'DPT', 'df_dev.png', 'Project Admin', '../infusions/df_project_panel/admin/project_admin.php', 5),
(54, 'DEV', 'df_dev.png', 'Development Admin', '../infusions/df_development_infusion/admin/development_admin.php', 5);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_admin_resetlog`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_admin_resetlog` (
`reset_id` mediumint(8) unsigned NOT NULL,
  `reset_admin_id` mediumint(8) unsigned NOT NULL DEFAULT '1',
  `reset_timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `reset_sucess` text NOT NULL,
  `reset_failed` text NOT NULL,
  `reset_admins` varchar(8) NOT NULL DEFAULT '0',
  `reset_reason` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_articles`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_articles` (
`article_id` mediumint(8) unsigned NOT NULL,
  `article_cat` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `article_subject` varchar(200) NOT NULL DEFAULT '',
  `article_snippet` text NOT NULL,
  `article_article` text NOT NULL,
  `article_draft` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `article_breaks` char(1) NOT NULL DEFAULT '',
  `article_name` mediumint(8) unsigned NOT NULL DEFAULT '1',
  `article_datestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `article_reads` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `article_allow_comments` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `article_allow_ratings` tinyint(1) unsigned NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_article_cats`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_article_cats` (
`article_cat_id` mediumint(8) unsigned NOT NULL,
  `article_cat_name` varchar(100) NOT NULL DEFAULT '',
  `article_cat_description` varchar(200) NOT NULL DEFAULT '',
  `article_cat_sorting` varchar(50) NOT NULL DEFAULT 'article_subject ASC',
  `article_cat_access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `article_cat_language` varchar(50) NOT NULL DEFAULT 'German'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_bbcodes`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_bbcodes` (
`bbcode_id` mediumint(8) unsigned NOT NULL,
  `bbcode_name` varchar(20) NOT NULL DEFAULT '',
  `bbcode_order` smallint(5) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fusionu92g5_bbcodes`
--

INSERT INTO `fusionu92g5_bbcodes` (`bbcode_id`, `bbcode_name`, `bbcode_order`) VALUES
(1, 'smiley', 1),
(2, 'b', 2),
(3, 'i', 3),
(4, 'u', 4),
(5, 'url', 5),
(6, 'mail', 6),
(7, 'img', 7),
(8, 'center', 8),
(9, 'small', 9),
(10, 'code', 10),
(11, 'quote', 11);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_blacklist`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_blacklist` (
`blacklist_id` mediumint(8) unsigned NOT NULL,
  `blacklist_user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `blacklist_ip` varchar(45) NOT NULL DEFAULT '',
  `blacklist_ip_type` tinyint(1) unsigned NOT NULL DEFAULT '4',
  `blacklist_email` varchar(100) NOT NULL DEFAULT '',
  `blacklist_reason` text NOT NULL,
  `blacklist_datestamp` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_captcha`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_captcha` (
  `captcha_datestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `captcha_ip` varchar(45) NOT NULL DEFAULT '',
  `captcha_ip_type` tinyint(1) unsigned NOT NULL DEFAULT '4',
  `captcha_encode` varchar(32) NOT NULL DEFAULT '',
  `captcha_string` varchar(15) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_comments`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_comments` (
`comment_id` mediumint(8) unsigned NOT NULL,
  `comment_item_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `comment_type` char(2) NOT NULL DEFAULT '',
  `comment_cat` mediumint(8) NOT NULL DEFAULT '0',
  `comment_name` varchar(50) NOT NULL DEFAULT '',
  `comment_message` text NOT NULL,
  `comment_datestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `comment_ip` varchar(45) NOT NULL DEFAULT '',
  `comment_ip_type` tinyint(1) unsigned NOT NULL DEFAULT '4',
  `comment_hidden` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_custom_pages`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_custom_pages` (
`page_id` mediumint(8) NOT NULL,
  `page_title` varchar(200) NOT NULL DEFAULT '',
  `page_access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `page_content` text NOT NULL,
  `page_allow_comments` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `page_allow_ratings` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `page_language` varchar(50) NOT NULL DEFAULT 'German'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_developments`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_developments` (
`development_id` smallint(5) unsigned NOT NULL,
  `development_developer` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `development_co_developer` text NOT NULL,
  `development_name` varchar(50) NOT NULL DEFAULT '',
  `development_version` varchar(10) NOT NULL DEFAULT '',
  `development_phpfv` varchar(11) NOT NULL DEFAULT '',
  `development_image` varchar(100) NOT NULL DEFAULT '',
  `development_image_thumb` varchar(100) NOT NULL DEFAULT '',
  `development_file` varchar(100) NOT NULL DEFAULT '',
  `development_filesize` varchar(20) NOT NULL DEFAULT '',
  `development_fcount` int(10) unsigned NOT NULL DEFAULT '0',
  `development_release_date` int(10) unsigned NOT NULL DEFAULT '0',
  `development_forum_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `development_about` text NOT NULL,
  `development_cat` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `development_percent` tinyint(1) NOT NULL DEFAULT '0',
  `development_statu` tinyint(1) NOT NULL DEFAULT '0',
  `development_access` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `development_allow_comments` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `development_allow_ratings` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `development_hideuser` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `development_statum` text NOT NULL,
  `development_datestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `development_datestamp2` int(10) unsigned NOT NULL DEFAULT '0',
  `development_datestamp3` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_development_cats`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_development_cats` (
`development_cat_id` smallint(5) unsigned NOT NULL,
  `development_cat_name` varchar(50) NOT NULL DEFAULT '',
  `development_cat_description` text NOT NULL,
  `development_cat_image` varchar(100) NOT NULL DEFAULT '',
  `development_cat_sorting` varchar(50) NOT NULL DEFAULT 'development_name ASC',
  `development_cat_access` tinyint(3) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fusionu92g5_development_cats`
--

INSERT INTO `fusionu92g5_development_cats` (`development_cat_id`, `development_cat_name`, `development_cat_description`, `development_cat_image`, `development_cat_sorting`, `development_cat_access`) VALUES
(1, 'Infusions', 'Infusion Developments', 'infusion.gif', 'development_name ASC', 0),
(2, 'Panels', 'Panel Developments', 'infusion.gif', 'development_name ASC', 0),
(3, 'Modifications', 'Modification Developments', 'infusion.gif', 'development_name ASC', 0),
(4, 'BB Codes', 'BB Code Developments', 'default.png', 'development_name ASC', 0),
(5, 'User Fields', 'User Field Developments', 'default.png', 'development_name ASC', 0),
(6, 'Themes', 'Theme Developments', 'infusion.gif', 'development_name ASC', 0),
(7, 'Code Snippits', 'Code Snippit Developments', 'default.png', 'development_name ASC', 0),
(8, 'Core', 'PHP-Fusion 7 Core', 'default.png', 'development_id ASC', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_development_ratings`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_development_ratings` (
`development_rating_id` mediumint(8) unsigned NOT NULL,
  `development_rating_item_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `development_rating_user` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `development_rating_vote` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `development_rating_datestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `development_rating_ip` varchar(45) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_development_settings`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_development_settings` (
  `devs_perpage` varchar(10) NOT NULL DEFAULT '0',
  `devs_comments` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `devs_screensh` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `devs_access` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `devs_statsp` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `devs_iconleg` tinyint(1) unsigned NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fusionu92g5_development_settings`
--

INSERT INTO `fusionu92g5_development_settings` (`devs_perpage`, `devs_comments`, `devs_screensh`, `devs_access`, `devs_statsp`, `devs_iconleg`) VALUES
('20', 1, 1, 0, 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_dfpp_cats`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_dfpp_cats` (
`project_cat_id` smallint(5) unsigned NOT NULL,
  `project_cat_name` varchar(50) NOT NULL DEFAULT '',
  `project_cat_description` text NOT NULL,
  `project_cat_image` varchar(100) NOT NULL DEFAULT '',
  `project_cat_sorting` varchar(50) NOT NULL DEFAULT 'project_name ASC',
  `project_cat_access` tinyint(3) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fusionu92g5_dfpp_cats`
--

INSERT INTO `fusionu92g5_dfpp_cats` (`project_cat_id`, `project_cat_name`, `project_cat_description`, `project_cat_image`, `project_cat_sorting`, `project_cat_access`) VALUES
(1, 'Infusions', 'Infusion Projects', 'default.png', 'project_name ASC', 0),
(2, 'Panels', 'Panel Projects', 'default.png', 'project_name ASC', 0),
(3, 'Modifications', 'Modification Projects', 'default.png', 'project_name ASC', 0),
(4, 'BB Codes', 'BB Code Projects', 'default.png', 'project_name ASC', 0),
(5, 'User Fields', 'User Field Projects', 'default.png', 'project_name ASC', 0),
(6, 'Themes', 'Theme Projects', 'default.png', 'project_name ASC', 0),
(7, 'Code Snippits', 'Code Snippit Projects', 'default.png', 'project_name ASC', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_dfpp_projects`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_dfpp_projects` (
`project_id` smallint(5) unsigned NOT NULL,
  `project_author` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `project_authors` text NOT NULL,
  `project_name` varchar(50) NOT NULL DEFAULT '',
  `project_version` varchar(10) NOT NULL DEFAULT '',
  `project_versiontype` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `project_syscompat` varchar(20) NOT NULL DEFAULT '',
  `project_syscompatv` varchar(20) NOT NULL DEFAULT '',
  `project_image` varchar(100) NOT NULL DEFAULT '',
  `project_image_thumb` varchar(100) NOT NULL DEFAULT '',
  `project_file` varchar(100) NOT NULL DEFAULT '',
  `project_fcount` int(10) unsigned NOT NULL DEFAULT '0',
  `project_forum_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `project_cat` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `project_percent` tinyint(1) NOT NULL DEFAULT '0',
  `project_status` char(3) NOT NULL DEFAULT 'NS',
  `project_access` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `project_dlaccess` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `project_allow_comments` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `project_allow_ratings` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `project_allow_proposals` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `project_hideauthor` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `project_descri` text NOT NULL,
  `project_author_notice` text NOT NULL,
  `project_releasetype` char(3) NOT NULL DEFAULT 'NS',
  `project_release` int(10) unsigned NOT NULL DEFAULT '0',
  `project_created` int(10) unsigned NOT NULL DEFAULT '0',
  `project_updated` int(10) unsigned NOT NULL DEFAULT '0',
  `project_tags` varchar(120) NOT NULL DEFAULT '',
  `project_langs` varchar(200) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_dfpp_proposals`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_dfpp_proposals` (
`project_proposal_id` mediumint(8) unsigned NOT NULL,
  `project_proposal_iid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `project_proposal_poster` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `project_proposal_admin` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `project_proposal_txt` text NOT NULL,
  `project_proposal_posted` int(10) unsigned NOT NULL DEFAULT '0',
  `project_proposal_updated` int(10) unsigned NOT NULL DEFAULT '0',
  `project_proposal_visi` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `project_proposal_visiacc` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `project_proposal_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `project_proposal_type` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_dfpp_reports`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_dfpp_reports` (
`project_report_id` mediumint(8) unsigned NOT NULL,
  `project_report_iid` mediumint(5) unsigned NOT NULL DEFAULT '0',
  `project_report_priority` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `project_report_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `project_reported_by` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `project_report_text` text NOT NULL,
  `project_report_date` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_dfpp_settings`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_dfpp_settings` (
  `project_perpage` varchar(10) NOT NULL DEFAULT '10',
  `project_cats_perpage` varchar(10) NOT NULL DEFAULT '10',
  `project_cats_colum` tinyint(1) unsigned NOT NULL DEFAULT '3',
  `project_colum` tinyint(1) unsigned NOT NULL DEFAULT '2',
  `project_comments` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `project_screenshot` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `project_access` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `project_stats` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `project_twidth` mediumint(5) NOT NULL DEFAULT '120',
  `project_theight` mediumint(5) NOT NULL DEFAULT '120',
  `project_swidth` mediumint(5) NOT NULL DEFAULT '1024',
  `project_sheight` mediumint(5) NOT NULL DEFAULT '900',
  `project_smaxsize` int(12) NOT NULL DEFAULT '300000',
  `project_ftypes` varchar(200) NOT NULL DEFAULT '.zip,.rar,.tar,.bz2,.7z',
  `project_fmaxsize` int(12) unsigned NOT NULL DEFAULT '4200000'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fusionu92g5_dfpp_settings`
--

INSERT INTO `fusionu92g5_dfpp_settings` (`project_perpage`, `project_cats_perpage`, `project_cats_colum`, `project_colum`, `project_comments`, `project_screenshot`, `project_access`, `project_stats`, `project_twidth`, `project_theight`, `project_swidth`, `project_sheight`, `project_smaxsize`, `project_ftypes`, `project_fmaxsize`) VALUES
('10', '10', 3, 2, 1, 1, 0, 1, 120, 120, 1024, 900, 300000, '.zip,.rar,.tar,.bz2,.7z', 4200000);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_downloads`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_downloads` (
`download_id` mediumint(8) unsigned NOT NULL,
  `download_user` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `download_homepage` varchar(100) NOT NULL DEFAULT '',
  `download_title` varchar(100) NOT NULL DEFAULT '',
  `download_description_short` varchar(255) NOT NULL,
  `download_description` text NOT NULL,
  `download_image` varchar(100) NOT NULL DEFAULT '',
  `download_image_thumb` varchar(100) NOT NULL DEFAULT '',
  `download_url` varchar(200) NOT NULL DEFAULT '',
  `download_file` varchar(100) NOT NULL DEFAULT '',
  `download_cat` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `download_license` varchar(50) NOT NULL DEFAULT '',
  `download_copyright` varchar(250) NOT NULL DEFAULT '',
  `download_os` varchar(50) NOT NULL DEFAULT '',
  `download_version` varchar(20) NOT NULL DEFAULT '',
  `download_filesize` varchar(20) NOT NULL DEFAULT '',
  `download_datestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `download_count` int(10) unsigned NOT NULL DEFAULT '0',
  `download_allow_comments` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `download_allow_ratings` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_download_cats`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_download_cats` (
`download_cat_id` mediumint(8) unsigned NOT NULL,
  `download_cat_name` varchar(100) NOT NULL DEFAULT '',
  `download_cat_description` text NOT NULL,
  `download_cat_sorting` varchar(50) NOT NULL DEFAULT 'download_title ASC',
  `download_cat_access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `download_cat_language` varchar(50) NOT NULL DEFAULT 'German'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_email_templates`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_email_templates` (
`template_id` mediumint(8) unsigned NOT NULL,
  `template_key` varchar(10) NOT NULL,
  `template_format` varchar(10) NOT NULL,
  `template_active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `template_name` varchar(300) NOT NULL,
  `template_subject` text NOT NULL,
  `template_content` text NOT NULL,
  `template_sender_name` varchar(30) NOT NULL,
  `template_sender_email` varchar(100) NOT NULL,
  `template_language` varchar(50) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fusionu92g5_email_templates`
--

INSERT INTO `fusionu92g5_email_templates` (`template_id`, `template_key`, `template_format`, `template_active`, `template_name`, `template_subject`, `template_content`, `template_sender_name`, `template_sender_email`, `template_language`) VALUES
(1, 'PM', 'html', 0, 'Notification on new PM', 'You have a new private message from [USER] waiting at [SITENAME]', 'Hello [RECEIVER],\r\nYou have received a new Private Message titled [SUBJECT] from [USER] at [SITENAME]. You can read your private message at [SITEURL]messages.php\r\n\r\nMessage: [MESSAGE]\r\n\r\nYou can disable email notification through the options panel of the Private Message page if you no longer wish to be notified of new messages.\r\n\r\nRegards,\r\n[SENDER].', 'Sina', 'test@mail.com', 'German'),
(2, 'POST', 'html', 0, 'Notification on new forum posts', 'Thread Reply Notification - [SUBJECT]', 'Hello [RECEIVER],\r\n\r\nA reply has been posted in the forum thread ''[SUBJECT]'' which you are tracking at [SITENAME]. You can use the following link to view the reply:\r\n\r\n[THREAD_URL]\r\n\r\nIf you no longer wish to watch this thread you can click the ''Stop tracking this thread'' link located at the top of the thread.\r\n\r\nRegards,\r\n[SENDER].', 'Sina', 'test@mail.com', 'German'),
(3, 'CONTACT', 'html', 0, 'Contact form', '[SUBJECT]', '[MESSAGE]', 'Sina', 'test@mail.com', 'German');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_email_verify`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_email_verify` (
  `user_id` mediumint(8) NOT NULL,
  `user_code` varchar(32) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_datestamp` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_errors`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_errors` (
`error_id` mediumint(8) unsigned NOT NULL,
  `error_level` smallint(5) unsigned NOT NULL,
  `error_message` text NOT NULL,
  `error_file` varchar(255) NOT NULL,
  `error_line` smallint(5) NOT NULL,
  `error_page` varchar(200) NOT NULL,
  `error_user_level` smallint(3) NOT NULL,
  `error_user_ip` varchar(45) NOT NULL DEFAULT '',
  `error_user_ip_type` tinyint(1) unsigned NOT NULL DEFAULT '4',
  `error_status` tinyint(1) NOT NULL DEFAULT '0',
  `error_timestamp` int(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fusionu92g5_errors`
--

INSERT INTO `fusionu92g5_errors` (`error_id`, `error_level`, `error_message`, `error_file`, `error_line`, `error_page`, `error_user_level`, `error_user_ip`, `error_user_ip_type`, `error_status`, `error_timestamp`) VALUES
(1, 8, 'Use of undefined constant LANGUAGE - assumed &#39;LANGUAGE&#39;', 'C:&#92;xampp&#92;htdocs&#92;themes&#92;Septenary&#92;theme.php', 26, '/news.php', 0, '0000:0000:0000:0000:0000:0000:0000:0001', 6, 0, 1427741103),
(2, 8, 'Use of undefined constant AU_CENTER - assumed &#39;AU_CENTER&#39;', 'C:&#92;xampp&#92;htdocs&#92;themes&#92;Septenary&#92;includes&#92;content.php', 26, '/news.php', 0, '0000:0000:0000:0000:0000:0000:0000:0001', 6, 0, 1427741103),
(3, 8, 'Use of undefined constant BL_CENTER - assumed &#39;BL_CENTER&#39;', 'C:&#92;xampp&#92;htdocs&#92;themes&#92;Septenary&#92;includes&#92;content.php', 34, '/news.php', 0, '0000:0000:0000:0000:0000:0000:0000:0001', 6, 0, 1427741103),
(4, 8, 'Use of undefined constant LANGUAGE - assumed &#39;LANGUAGE&#39;', 'C:&#92;xampp&#92;htdocs&#92;themes&#92;Septenary&#92;includes&#92;footer.php', 26, '/news.php', 0, '0000:0000:0000:0000:0000:0000:0000:0001', 6, 0, 1427741103),
(5, 8, 'Undefined index: err_101', 'C:&#92;xampp&#92;htdocs&#92;themes&#92;templates&#92;footer.php', 95, '/administration/settings_main.php', 103, '0000:0000:0000:0000:0000:0000:0000:0001', 6, 0, 1427741118),
(6, 2, 'include(../infusions/chat_panel/chat_panel.php): failed to open stream: No such file or directory', 'C:&#92;xampp&#92;htdocs&#92;administration&#92;panel_editor.php', 151, '/administration/panel_editor.php', 103, '0000:0000:0000:0000:0000:0000:0000:0001', 6, 0, 1427741844),
(7, 8, 'Undefined index: protean_006', 'C:&#92;xampp&#92;htdocs&#92;themes&#92;Cveu-Cube&#92;footer.php', 108, '/news.php', 103, '0000:0000:0000:0000:0000:0000:0000:0001', 6, 0, 1427816583),
(8, 8, 'Undefined index: protean_007', 'C:&#92;xampp&#92;htdocs&#92;themes&#92;Cveu-Cube&#92;footer.php', 116, '/news.php', 103, '0000:0000:0000:0000:0000:0000:0000:0001', 6, 0, 1427816583),
(9, 8, 'Undefined index: protean_010', 'C:&#92;xampp&#92;htdocs&#92;themes&#92;Cveu-Cube&#92;footer.php', 152, '/news.php', 103, '0000:0000:0000:0000:0000:0000:0000:0001', 6, 0, 1427816583),
(10, 8, 'Undefined index: protean_013', 'C:&#92;xampp&#92;htdocs&#92;themes&#92;Cveu-Cube&#92;footer.php', 153, '/news.php', 103, '0000:0000:0000:0000:0000:0000:0000:0001', 6, 0, 1427816583),
(11, 8, 'Undefined index: protean_006', 'C:&#92;xampp&#92;htdocs&#92;themes&#92;Cveu-Cube&#92;footer.php', 103, '/news.php', 103, '0000:0000:0000:0000:0000:0000:0000:0001', 6, 0, 1427816615),
(12, 8, 'Undefined index: protean_007', 'C:&#92;xampp&#92;htdocs&#92;themes&#92;Cveu-Cube&#92;footer.php', 111, '/news.php', 103, '0000:0000:0000:0000:0000:0000:0000:0001', 6, 0, 1427816615),
(13, 8, 'Undefined index: protean_010', 'C:&#92;xampp&#92;htdocs&#92;themes&#92;Cveu-Cube&#92;footer.php', 147, '/news.php', 103, '0000:0000:0000:0000:0000:0000:0000:0001', 6, 0, 1427816615),
(14, 8, 'Undefined index: protean_013', 'C:&#92;xampp&#92;htdocs&#92;themes&#92;Cveu-Cube&#92;footer.php', 148, '/news.php', 103, '0000:0000:0000:0000:0000:0000:0000:0001', 6, 0, 1427816615),
(15, 8192, 'preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead', 'C:&#92;xampp&#92;htdocs&#92;includes&#92;bbcodes&#92;url_bbcode_include.php', 21, '/administration/forums.php', 103, '0000:0000:0000:0000:0000:0000:0000:0001', 6, 0, 1427817299),
(16, 8192, 'preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead', 'C:&#92;xampp&#92;htdocs&#92;includes&#92;bbcodes&#92;url_bbcode_include.php', 22, '/administration/forums.php', 103, '0000:0000:0000:0000:0000:0000:0000:0001', 6, 0, 1427817299),
(17, 8192, 'preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead', 'C:&#92;xampp&#92;htdocs&#92;includes&#92;bbcodes&#92;mail_bbcode_include.php', 20, '/administration/forums.php', 103, '0000:0000:0000:0000:0000:0000:0000:0001', 6, 0, 1427817299),
(18, 8192, 'preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead', 'C:&#92;xampp&#92;htdocs&#92;includes&#92;bbcodes&#92;mail_bbcode_include.php', 21, '/administration/forums.php', 103, '0000:0000:0000:0000:0000:0000:0000:0001', 6, 0, 1427817299),
(19, 8, 'Undefined index: bb_quote_expand', 'C:&#92;xampp&#92;htdocs&#92;includes&#92;bbcodes&#92;quote_bbcode_include.php', 72, '/administration/forums.php', 103, '0000:0000:0000:0000:0000:0000:0000:0001', 6, 0, 1427817299),
(20, 8, 'Undefined index: bb_quote_expand', 'C:&#92;xampp&#92;htdocs&#92;includes&#92;bbcodes&#92;quote_bbcode_include.php', 86, '/administration/forums.php', 103, '0000:0000:0000:0000:0000:0000:0000:0001', 6, 0, 1427817299),
(21, 8, 'Undefined index: bb_quote_collapse', 'C:&#92;xampp&#92;htdocs&#92;includes&#92;bbcodes&#92;quote_bbcode_include.php', 93, '/administration/forums.php', 103, '0000:0000:0000:0000:0000:0000:0000:0001', 6, 0, 1427817299),
(22, 2, 'include(themes/Cveu-Cube/quicksign_panel/quicksign_panel.php): failed to open stream: No such file or directory', 'C:&#92;xampp&#92;htdocs&#92;themes&#92;Cveu-Cube&#92;header.php', 28, '/news.php', 0, '0000:0000:0000:0000:0000:0000:0000:0001', 6, 0, 1427817861),
(23, 2, 'include(../locale/German/admin/emails.php): failed to open stream: No such file or directory', 'C:&#92;xampp&#92;htdocs&#92;administration&#92;email.php', 23, '/administration/email.php', 103, '0000:0000:0000:0000:0000:0000:0000:0001', 6, 0, 1427824779);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_faqs`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_faqs` (
`faq_id` mediumint(8) unsigned NOT NULL,
  `faq_cat_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `faq_question` varchar(200) NOT NULL DEFAULT '',
  `faq_answer` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_faq_cats`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_faq_cats` (
`faq_cat_id` mediumint(8) unsigned NOT NULL,
  `faq_cat_name` varchar(200) NOT NULL DEFAULT '',
  `faq_cat_description` varchar(250) NOT NULL DEFAULT '',
  `faq_cat_language` varchar(50) NOT NULL DEFAULT 'German'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_flood_control`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_flood_control` (
  `flood_ip` varchar(45) NOT NULL DEFAULT '',
  `flood_ip_type` tinyint(1) unsigned NOT NULL DEFAULT '4',
  `flood_timestamp` int(5) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_forums`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_forums` (
`forum_id` mediumint(8) unsigned NOT NULL,
  `forum_cat` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `forum_name` varchar(50) NOT NULL DEFAULT '',
  `forum_order` smallint(5) unsigned NOT NULL DEFAULT '0',
  `forum_description` text NOT NULL,
  `forum_moderators` text NOT NULL,
  `forum_access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `forum_post` smallint(3) unsigned DEFAULT '101',
  `forum_reply` smallint(3) unsigned DEFAULT '101',
  `forum_poll` smallint(3) unsigned NOT NULL DEFAULT '0',
  `forum_vote` smallint(3) unsigned NOT NULL DEFAULT '0',
  `forum_attach` smallint(3) unsigned NOT NULL DEFAULT '0',
  `forum_attach_download` smallint(3) unsigned NOT NULL DEFAULT '0',
  `forum_lastpost` int(10) unsigned NOT NULL DEFAULT '0',
  `forum_postcount` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `forum_threadcount` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `forum_lastuser` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `forum_merge` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `forum_language` varchar(50) NOT NULL DEFAULT 'German'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fusionu92g5_forums`
--

INSERT INTO `fusionu92g5_forums` (`forum_id`, `forum_cat`, `forum_name`, `forum_order`, `forum_description`, `forum_moderators`, `forum_access`, `forum_post`, `forum_reply`, `forum_poll`, `forum_vote`, `forum_attach`, `forum_attach_download`, `forum_lastpost`, `forum_postcount`, `forum_threadcount`, `forum_lastuser`, `forum_merge`, `forum_language`) VALUES
(1, 0, 'Test', 1, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'German'),
(2, 1, 'Test', 1, 'test', '', 0, 101, 101, 0, 0, 0, 0, 1427817315, 1, 1, 1, 0, 'German');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_forum_attachments`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_forum_attachments` (
`attach_id` mediumint(8) unsigned NOT NULL,
  `thread_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `post_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `attach_name` varchar(100) NOT NULL DEFAULT '',
  `attach_ext` varchar(5) NOT NULL DEFAULT '',
  `attach_size` int(20) unsigned NOT NULL DEFAULT '0',
  `attach_count` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_forum_polls`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_forum_polls` (
  `thread_id` mediumint(8) unsigned NOT NULL,
  `forum_poll_title` varchar(250) NOT NULL,
  `forum_poll_start` int(10) unsigned DEFAULT NULL,
  `forum_poll_length` int(10) unsigned NOT NULL,
  `forum_poll_votes` smallint(5) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_forum_poll_options`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_forum_poll_options` (
  `thread_id` mediumint(8) unsigned NOT NULL,
  `forum_poll_option_id` smallint(5) unsigned NOT NULL,
  `forum_poll_option_text` varchar(150) NOT NULL,
  `forum_poll_option_votes` smallint(5) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_forum_poll_voters`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_forum_poll_voters` (
  `thread_id` mediumint(8) unsigned NOT NULL,
  `forum_vote_user_id` mediumint(8) unsigned NOT NULL,
  `forum_vote_user_ip` varchar(45) NOT NULL,
  `forum_vote_user_ip_type` tinyint(1) unsigned NOT NULL DEFAULT '4'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_forum_ranks`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_forum_ranks` (
`rank_id` mediumint(8) unsigned NOT NULL,
  `rank_title` varchar(100) NOT NULL DEFAULT '',
  `rank_image` varchar(100) NOT NULL DEFAULT '',
  `rank_posts` int(10) unsigned NOT NULL DEFAULT '0',
  `rank_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `rank_apply` smallint(5) unsigned NOT NULL DEFAULT '101',
  `rank_language` varchar(50) NOT NULL DEFAULT 'German'
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fusionu92g5_forum_ranks`
--

INSERT INTO `fusionu92g5_forum_ranks` (`rank_id`, `rank_title`, `rank_image`, `rank_posts`, `rank_type`, `rank_apply`, `rank_language`) VALUES
(1, 'Seiten Administrator', 'rank_super_admin.png', 0, 1, 103, 'German'),
(2, 'Administrator', 'rank_admin.png', 0, 1, 102, 'German'),
(3, 'Moderator', 'rank_mod.png', 0, 1, 104, 'German'),
(4, 'Neuling', 'rank0.png', 0, 0, 101, 'German'),
(5, 'Jung Mitglied', 'rank1.png', 10, 0, 101, 'German'),
(6, 'Mitglied', 'rank2.png', 50, 0, 101, 'German'),
(7, 'Senior Mitglied', 'rank3.png', 200, 0, 101, 'German'),
(8, 'Veteran Mitglied', 'rank4.png', 500, 0, 101, 'German'),
(9, 'Fusioneer', 'rank5.png', 1000, 0, 101, 'German');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_infusions`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_infusions` (
`inf_id` mediumint(8) unsigned NOT NULL,
  `inf_title` varchar(100) NOT NULL DEFAULT '',
  `inf_folder` varchar(100) NOT NULL DEFAULT '',
  `inf_version` varchar(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fusionu92g5_infusions`
--

INSERT INTO `fusionu92g5_infusions` (`inf_id`, `inf_title`, `inf_folder`, `inf_version`) VALUES
(1, 'DF Project Panel', 'df_project_panel', '1.05'),
(2, 'DF Development Infusion', 'df_development_infusion', '1.05');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_language_sessions`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_language_sessions` (
  `user_ip` varchar(20) NOT NULL DEFAULT '0.0.0.0',
  `user_language` varchar(50) NOT NULL DEFAULT 'German',
  `user_datestamp` int(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_messages`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_messages` (
`message_id` mediumint(8) unsigned NOT NULL,
  `message_to` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `message_from` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `message_subject` varchar(100) NOT NULL DEFAULT '',
  `message_message` text NOT NULL,
  `message_smileys` char(1) NOT NULL DEFAULT '',
  `message_read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `message_datestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `message_folder` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_messages_options`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_messages_options` (
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `pm_email_notify` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `pm_save_sent` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `pm_inbox` smallint(5) unsigned NOT NULL DEFAULT '0',
  `pm_savebox` smallint(5) unsigned NOT NULL DEFAULT '0',
  `pm_sentbox` smallint(5) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fusionu92g5_messages_options`
--

INSERT INTO `fusionu92g5_messages_options` (`user_id`, `pm_email_notify`, `pm_save_sent`, `pm_inbox`, `pm_savebox`, `pm_sentbox`) VALUES
(0, 0, 1, 20, 20, 20);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_mlt_tables`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_mlt_tables` (
  `mlt_rights` char(4) NOT NULL DEFAULT '',
  `mlt_title` varchar(50) NOT NULL DEFAULT '',
  `mlt_status` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fusionu92g5_mlt_tables`
--

INSERT INTO `fusionu92g5_mlt_tables` (`mlt_rights`, `mlt_title`, `mlt_status`) VALUES
('AR', 'Articles', '1'),
('CP', 'Custom Pages', '1'),
('DL', 'Downloads', '1'),
('FQ', 'FAQs', '1'),
('FO', 'Forums', '1'),
('FR', 'Forum Ranks', '1'),
('NS', 'News', '1'),
('PG', 'Photogallery', '1'),
('PO', 'Polls', '1'),
('ET', 'Email Templates', '1'),
('WL', 'Weblinks', '1'),
('SL', 'Sitelinks', '1'),
('PN', 'Panels', '1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_news`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_news` (
`news_id` mediumint(8) unsigned NOT NULL,
  `news_subject` varchar(200) NOT NULL DEFAULT '',
  `news_image` varchar(100) NOT NULL DEFAULT '',
  `news_image_t1` varchar(100) NOT NULL DEFAULT '',
  `news_image_t2` varchar(100) NOT NULL DEFAULT '',
  `news_cat` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `news_news` text NOT NULL,
  `news_extended` text NOT NULL,
  `news_breaks` char(1) NOT NULL DEFAULT '',
  `news_name` mediumint(8) unsigned NOT NULL DEFAULT '1',
  `news_datestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `news_start` int(10) unsigned NOT NULL DEFAULT '0',
  `news_end` int(10) unsigned NOT NULL DEFAULT '0',
  `news_visibility` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `news_reads` int(10) unsigned NOT NULL DEFAULT '0',
  `news_draft` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `news_sticky` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `news_allow_comments` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `news_allow_ratings` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `news_language` varchar(50) NOT NULL DEFAULT 'German'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_news_cats`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_news_cats` (
`news_cat_id` mediumint(8) unsigned NOT NULL,
  `news_cat_name` varchar(100) NOT NULL DEFAULT '',
  `news_cat_image` varchar(100) NOT NULL DEFAULT '',
  `news_cat_language` varchar(50) NOT NULL DEFAULT 'German'
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fusionu92g5_news_cats`
--

INSERT INTO `fusionu92g5_news_cats` (`news_cat_id`, `news_cat_name`, `news_cat_image`, `news_cat_language`) VALUES
(1, 'Fehler', 'bugs.gif', 'German'),
(2, 'Downloads', 'downloads.gif', 'German'),
(3, 'Spiele', 'games.gif', 'German'),
(4, 'Grafiken', 'graphics.gif', 'German'),
(5, 'Hardware', 'hardware.gif', 'German'),
(6, 'Magazin', 'journal.gif', 'German'),
(7, 'Mitglieder', 'members.gif', 'German'),
(8, 'Mods', 'mods.gif', 'German'),
(9, 'Filme', 'movies.gif', 'German'),
(10, 'Netzwerk', 'network.gif', 'German'),
(11, 'News', 'news.gif', 'German'),
(12, 'PHP-Fusion', 'php-fusion.gif', 'German'),
(13, 'Sicherheit', 'security.gif', 'German'),
(14, 'Software', 'software.gif', 'German'),
(15, 'Themes', 'themes.gif', 'German'),
(16, 'Windows', 'windows.gif', 'German');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_new_users`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_new_users` (
  `user_code` varchar(40) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_datestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `user_info` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_online`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_online` (
  `online_user` varchar(50) NOT NULL DEFAULT '',
  `online_ip` varchar(45) NOT NULL DEFAULT '',
  `online_ip_type` tinyint(1) unsigned NOT NULL DEFAULT '4',
  `online_lastactive` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fusionu92g5_online`
--

INSERT INTO `fusionu92g5_online` (`online_user`, `online_ip`, `online_ip_type`, `online_lastactive`) VALUES
('0', '0000:0000:0000:0000:0000:0000:0000:0001', 4, 1427825701);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_panels`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_panels` (
`panel_id` mediumint(8) unsigned NOT NULL,
  `panel_name` varchar(100) NOT NULL DEFAULT '',
  `panel_filename` varchar(100) NOT NULL DEFAULT '',
  `panel_content` text NOT NULL,
  `panel_side` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `panel_order` smallint(5) unsigned NOT NULL DEFAULT '0',
  `panel_type` varchar(20) NOT NULL DEFAULT '',
  `panel_access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `panel_display` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `panel_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `panel_url_list` text NOT NULL,
  `panel_restriction` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `panel_languages` varchar(200) NOT NULL DEFAULT 'German'
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fusionu92g5_panels`
--

INSERT INTO `fusionu92g5_panels` (`panel_id`, `panel_name`, `panel_filename`, `panel_content`, `panel_side`, `panel_order`, `panel_type`, `panel_access`, `panel_display`, `panel_status`, `panel_url_list`, `panel_restriction`, `panel_languages`) VALUES
(1, 'Language Panel', 'language_panel', '', 1, 3, 'file', 0, 0, 0, '', 0, 'German'),
(2, 'Seiten Navigation', 'css_navigation_panel', '', 1, 2, 'file', 0, 0, 1, '', 0, 'German'),
(3, 'Benutzer Online', 'online_users_panel', '', 1, 4, 'file', 0, 0, 0, '', 0, 'German'),
(4, 'Foren Themen', 'forum_threads_panel', '', 1, 5, 'file', 0, 0, 0, '', 0, 'German'),
(5, 'Letzte Artikel', 'latest_articles_panel', '', 1, 6, 'file', 0, 0, 0, '', 0, 'German'),
(6, 'Willkommensnachricht', 'welcome_message_panel', '', 2, 3, 'file', 0, 0, 0, '', 0, 'German'),
(7, 'Letzte aktive Foren Themen', 'forum_threads_list_panel', '', 2, 1, 'file', 0, 0, 1, '', 0, 'German'),
(8, 'Benutzer Information', 'user_info_panel', '', 1, 1, 'file', 0, 0, 0, '', 0, 'German'),
(9, 'Mitglieder Umfrage', 'member_poll_panel', '', 1, 7, 'file', 0, 0, 0, '', 0, 'German'),
(10, 'chat Panel', 'chat_panel', '', 2, 4, 'file', 0, 0, 1, '', 1, 'German'),
(11, 'Download', 'latest_downloads_panel', '', 2, 2, 'file', 0, 0, 1, '', 1, 'German'),
(12, 'DF Project Panel', 'df_project_panel', '', 2, 3, 'file', 0, 0, 1, '', 0, 'German'),
(13, 'DF Development Infusion', 'df_development_infusion', '', 2, 3, 'file', 0, 0, 1, '', 0, 'German');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_permalinks_alias`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_permalinks_alias` (
`alias_id` mediumint(8) unsigned NOT NULL,
  `alias_url` varchar(200) NOT NULL DEFAULT '',
  `alias_php_url` varchar(200) NOT NULL DEFAULT '',
  `alias_type` varchar(10) NOT NULL DEFAULT '',
  `alias_item_id` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_permalinks_method`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_permalinks_method` (
`pattern_id` int(8) unsigned NOT NULL,
  `pattern_type` int(5) unsigned NOT NULL,
  `pattern_source` varchar(200) NOT NULL DEFAULT '',
  `pattern_target` varchar(200) NOT NULL DEFAULT '',
  `pattern_cat` varchar(10) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_permalinks_rewrites`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_permalinks_rewrites` (
`rewrite_id` int(8) unsigned NOT NULL,
  `rewrite_name` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_photos`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_photos` (
`photo_id` mediumint(8) unsigned NOT NULL,
  `album_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `photo_title` varchar(100) NOT NULL DEFAULT '',
  `photo_description` text NOT NULL,
  `photo_filename` varchar(100) NOT NULL DEFAULT '',
  `photo_thumb1` varchar(100) NOT NULL DEFAULT '',
  `photo_thumb2` varchar(100) NOT NULL DEFAULT '',
  `photo_datestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `photo_user` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `photo_views` int(10) unsigned NOT NULL DEFAULT '0',
  `photo_order` smallint(5) unsigned NOT NULL DEFAULT '0',
  `photo_allow_comments` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `photo_allow_ratings` tinyint(1) unsigned NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_photo_albums`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_photo_albums` (
`album_id` mediumint(8) unsigned NOT NULL,
  `album_title` varchar(100) NOT NULL DEFAULT '',
  `album_description` text NOT NULL,
  `album_thumb` varchar(100) NOT NULL DEFAULT '',
  `album_user` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `album_access` smallint(5) unsigned NOT NULL DEFAULT '0',
  `album_order` smallint(5) unsigned NOT NULL DEFAULT '0',
  `album_datestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `album_language` varchar(50) NOT NULL DEFAULT 'German'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_polls`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_polls` (
`poll_id` mediumint(8) unsigned NOT NULL,
  `poll_title` varchar(200) NOT NULL DEFAULT '',
  `poll_opt_0` varchar(200) NOT NULL DEFAULT '',
  `poll_opt_1` varchar(200) NOT NULL DEFAULT '',
  `poll_opt_2` varchar(200) NOT NULL DEFAULT '',
  `poll_opt_3` varchar(200) NOT NULL DEFAULT '',
  `poll_opt_4` varchar(200) NOT NULL DEFAULT '',
  `poll_opt_5` varchar(200) NOT NULL DEFAULT '',
  `poll_opt_6` varchar(200) NOT NULL DEFAULT '',
  `poll_opt_7` varchar(200) NOT NULL DEFAULT '',
  `poll_opt_8` varchar(200) NOT NULL DEFAULT '',
  `poll_opt_9` varchar(200) NOT NULL DEFAULT '',
  `poll_started` int(10) unsigned NOT NULL DEFAULT '0',
  `poll_ended` int(10) unsigned NOT NULL DEFAULT '0',
  `poll_language` varchar(50) NOT NULL DEFAULT 'German'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_poll_votes`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_poll_votes` (
`vote_id` mediumint(8) unsigned NOT NULL,
  `vote_user` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vote_opt` smallint(2) unsigned NOT NULL DEFAULT '0',
  `poll_id` mediumint(8) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_posts`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_posts` (
  `forum_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `thread_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
`post_id` mediumint(8) unsigned NOT NULL,
  `post_message` text NOT NULL,
  `post_showsig` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `post_smileys` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `post_author` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `post_datestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `post_ip` varchar(45) NOT NULL DEFAULT '',
  `post_ip_type` tinyint(1) unsigned NOT NULL DEFAULT '4',
  `post_edituser` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `post_edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `post_editreason` text NOT NULL,
  `post_hidden` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `post_locked` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fusionu92g5_posts`
--

INSERT INTO `fusionu92g5_posts` (`forum_id`, `thread_id`, `post_id`, `post_message`, `post_showsig`, `post_smileys`, `post_author`, `post_datestamp`, `post_ip`, `post_ip_type`, `post_edituser`, `post_edittime`, `post_editreason`, `post_hidden`, `post_locked`) VALUES
(2, 1, 1, 'sdlbndf', 0, 1, 1, 1427817315, '0000:0000:0000:0000:0000:0000:0000:0001', 6, 0, 0, '', 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_ratings`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_ratings` (
`rating_id` mediumint(8) unsigned NOT NULL,
  `rating_item_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `rating_type` char(1) NOT NULL DEFAULT '',
  `rating_user` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `rating_vote` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `rating_datestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `rating_ip` varchar(45) NOT NULL DEFAULT '',
  `rating_ip_type` tinyint(1) unsigned NOT NULL DEFAULT '4'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_settings`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_settings` (
  `settings_name` varchar(200) NOT NULL DEFAULT '',
  `settings_value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fusionu92g5_settings`
--

INSERT INTO `fusionu92g5_settings` (`settings_name`, `settings_value`) VALUES
('sitename', 'PHP-Fusion Powered Website'),
('siteurl', 'http://localhost/'),
('site_protocol', 'http'),
('site_host', 'localhost'),
('site_port', ''),
('site_path', '/'),
('site_seo', '0'),
('sitebanner', 'images/php-fusion-logo.png'),
('sitebanner1', ''),
('sitebanner2', ''),
('siteemail', 'test@mail.com'),
('siteusername', 'Sina'),
('siteintro', 'PHP-Fusion Powered Website - v7.02.07 DE'),
('description', ''),
('keywords', ''),
('footer', '<div style=\\''text-align:center\\''>Copyright &copy; 2015</div>'),
('opening_page', 'news.php'),
('news_thumb_ratio', '0'),
('news_image_link', '0'),
('news_thumb_w', '100'),
('news_thumb_h', '100'),
('news_photo_max_w', '1800'),
('news_photo_max_h', '1600'),
('news_photo_max_b', '150000'),
('locale', 'German'),
('bootstrap', '1'),
('theme', 'Cveu-Cube'),
('default_search', 'all'),
('exclude_left', ''),
('exclude_upper', ''),
('exclude_lower', ''),
('exclude_aupper', ''),
('exclude_blower', ''),
('exclude_right', ''),
('shortdate', '%d.%m.%y'),
('longdate', '%d. %B %Y um %H:%M:%S'),
('forumdate', '%d.%m.%Y um %H:%M'),
('newsdate', '%d. %B %Y'),
('subheaderdate', '%d. %B %Y - %H:%M:%S'),
('timeoffset', '0.0'),
('serveroffset', '0.0'),
('numofthreads', '15'),
('forum_ips', '0'),
('attachmax', '150000'),
('attachmax_count', '5'),
('attachtypes', '.gif,.jpg,.png,.zip,.rar,.tar,.7z'),
('thread_notify', '1'),
('forum_ranks', '1'),
('forum_edit_lock', '0'),
('forum_edit_timelimit', '0'),
('forum_editpost_to_lastpost', '1'),
('forum_last_posts_reply', '10'),
('forum_last_post_avatar', '1'),
('enable_registration', '1'),
('email_verification', '1'),
('admin_activation', '0'),
('display_validation', '1'),
('enable_deactivation', '0'),
('deactivation_period', '365'),
('deactivation_response', '14'),
('enable_terms', '0'),
('license_agreement', ''),
('license_lastupdate', '0'),
('thumb_w', '100'),
('thumb_h', '100'),
('photo_w', '400'),
('photo_h', '300'),
('photo_max_w', '1800'),
('photo_max_h', '1600'),
('photo_max_b', '5120000'),
('thumb_compression', 'gd2'),
('thumbs_per_row', '4'),
('thumbs_per_page', '12'),
('photo_watermark', '1'),
('photo_watermark_image', 'images/watermark.png'),
('photo_watermark_text', '0'),
('photo_watermark_text_color1', 'FF6600'),
('photo_watermark_text_color2', 'FFFF00'),
('photo_watermark_text_color3', 'FFFFFF'),
('photo_watermark_save', '0'),
('tinymce_enabled', '0'),
('smtp_host', ''),
('smtp_port', '25'),
('smtp_username', ''),
('smtp_password', ''),
('bad_words_enabled', '1'),
('bad_words', ''),
('bad_word_replace', '****'),
('login_method', '0'),
('guestposts', '0'),
('comments_enabled', '1'),
('ratings_enabled', '1'),
('hide_userprofiles', '0'),
('userthemes', '1'),
('newsperpage', '11'),
('flood_interval', '15'),
('counter', '1'),
('version', '7.02.07 DE'),
('maintenance', '0'),
('maintenance_message', 'dsbhfgndgbndbnd'),
('download_max_b', '512000'),
('download_types', '.pdf,.gif,.jpg,.png,.zip,.rar,.tar,.bz2,.7z'),
('articles_per_page', '15'),
('downloads_per_page', '15'),
('links_per_page', '15'),
('comments_per_page', '10'),
('posts_per_page', '20'),
('threads_per_page', '20'),
('comments_sorting', 'ASC'),
('comments_avatar', '1'),
('avatar_width', '100'),
('avatar_height', '100'),
('avatar_filesize', '15000'),
('avatar_ratio', '0'),
('cronjob_day', '1427741102'),
('cronjob_hour', '1427825520'),
('flood_autoban', '1'),
('visitorcounter_enabled', '1'),
('rendertime_enabled', '0'),
('popular_threads_timeframe', ''),
('maintenance_level', '103'),
('news_photo_w', '400'),
('news_photo_h', '300'),
('news_image_frontpage', '0'),
('news_image_readmore', '0'),
('deactivation_action', '0'),
('captcha', 'securimage2'),
('password_algorithm', 'sha256'),
('default_timezone', 'Europe/London'),
('userNameChange', '1'),
('download_screen_max_b', '150000'),
('download_screen_max_w', '1024'),
('download_screen_max_h', '768'),
('recaptcha_public', ''),
('recaptcha_private', ''),
('recaptcha_theme', 'red'),
('download_screenshot', '1'),
('download_thumb_max_w', '100'),
('download_thumb_max_h', '100'),
('multiple_logins', '0'),
('smtp_auth', '0'),
('mime_check', '0'),
('enabled_languages', 'German');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_settings_inf`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_settings_inf` (
  `settings_name` varchar(200) NOT NULL DEFAULT '',
  `settings_value` text NOT NULL,
  `settings_inf` varchar(200) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_site_links`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_site_links` (
`link_id` mediumint(8) unsigned NOT NULL,
  `link_name` varchar(100) NOT NULL DEFAULT '',
  `link_url` varchar(200) NOT NULL DEFAULT '',
  `link_visibility` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `link_position` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `link_window` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `link_order` smallint(2) unsigned NOT NULL DEFAULT '0',
  `link_language` varchar(50) NOT NULL DEFAULT 'German'
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fusionu92g5_site_links`
--

INSERT INTO `fusionu92g5_site_links` (`link_id`, `link_name`, `link_url`, `link_visibility`, `link_position`, `link_window`, `link_order`, `link_language`) VALUES
(1, 'Startseite', 'index.php', 0, 2, 0, 1, 'German'),
(2, 'Artikel', 'articles.php', 0, 2, 0, 2, 'German'),
(3, 'Downloads', 'downloads.php', 0, 2, 0, 3, 'German'),
(4, 'FAQ', 'faq.php', 0, 1, 0, 4, 'German'),
(5, 'Forum', 'forum/index.php', 0, 2, 0, 5, 'German'),
(6, 'News Kategorien', 'news_cats.php', 0, 2, 0, 7, 'German'),
(7, 'Weblinks', 'weblinks.php', 0, 2, 0, 6, 'German'),
(8, 'Kontakt', 'contact.php', 0, 1, 0, 8, 'German'),
(9, 'Fotogalerie', 'photogallery.php', 0, 1, 0, 9, 'German'),
(10, 'Suche', 'search.php', 0, 1, 0, 10, 'German'),
(11, '---', '---', 101, 1, 0, 11, 'German'),
(12, 'Link einsenden', 'submit.php?stype=l', 101, 1, 0, 12, 'German'),
(13, 'News einsenden', 'submit.php?stype=n', 101, 1, 0, 13, 'German'),
(14, 'Artikel einsenden', 'submit.php?stype=a', 101, 1, 0, 14, 'German'),
(15, 'Foto einsenden', 'submit.php?stype=p', 101, 1, 0, 15, 'German'),
(16, 'Download einsenden', 'submit.php?stype=d', 101, 1, 0, 16, 'German'),
(17, 'Projects', 'infusions/df_project_panel/project.php', 0, 1, 0, 17, 'German'),
(18, 'Development List', 'infusions/df_development_infusion/developments.php', 0, 1, 0, 18, 'German');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_smileys`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_smileys` (
`smiley_id` mediumint(8) unsigned NOT NULL,
  `smiley_code` varchar(50) NOT NULL,
  `smiley_image` varchar(100) NOT NULL,
  `smiley_text` varchar(100) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fusionu92g5_smileys`
--

INSERT INTO `fusionu92g5_smileys` (`smiley_id`, `smiley_code`, `smiley_image`, `smiley_text`) VALUES
(1, ':)', 'smile.gif', 'Smile'),
(2, ';)', 'wink.gif', 'Wink'),
(3, ':(', 'sad.gif', 'Sad'),
(4, ':|', 'frown.gif', 'Frown'),
(5, ':o', 'shock.gif', 'Shock'),
(6, ':P', 'pfft.gif', 'Pfft'),
(7, 'B)', 'cool.gif', 'Cool'),
(8, ':D', 'grin.gif', 'Grin'),
(9, ':@', 'angry.gif', 'Angry');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_submissions`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_submissions` (
`submit_id` mediumint(8) unsigned NOT NULL,
  `submit_type` char(1) NOT NULL,
  `submit_user` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `submit_datestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `submit_criteria` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_suspends`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_suspends` (
`suspend_id` mediumint(8) unsigned NOT NULL,
  `suspended_user` mediumint(8) unsigned NOT NULL,
  `suspending_admin` mediumint(8) unsigned NOT NULL DEFAULT '1',
  `suspend_ip` varchar(45) NOT NULL DEFAULT '',
  `suspend_ip_type` tinyint(1) unsigned NOT NULL DEFAULT '4',
  `suspend_date` int(10) NOT NULL DEFAULT '0',
  `suspend_reason` text NOT NULL,
  `suspend_type` tinyint(1) NOT NULL DEFAULT '0',
  `reinstating_admin` mediumint(8) unsigned NOT NULL DEFAULT '1',
  `reinstate_reason` text NOT NULL,
  `reinstate_date` int(10) NOT NULL DEFAULT '0',
  `reinstate_ip` varchar(45) NOT NULL DEFAULT '',
  `reinstate_ip_type` tinyint(1) unsigned NOT NULL DEFAULT '4'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_threads`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_threads` (
  `forum_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
`thread_id` mediumint(8) unsigned NOT NULL,
  `thread_subject` varchar(100) NOT NULL DEFAULT '',
  `thread_author` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `thread_views` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `thread_lastpost` int(10) unsigned NOT NULL DEFAULT '0',
  `thread_lastpostid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `thread_lastuser` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `thread_postcount` smallint(5) unsigned NOT NULL DEFAULT '0',
  `thread_poll` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `thread_sticky` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `thread_locked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `thread_hidden` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fusionu92g5_threads`
--

INSERT INTO `fusionu92g5_threads` (`forum_id`, `thread_id`, `thread_subject`, `thread_author`, `thread_views`, `thread_lastpost`, `thread_lastpostid`, `thread_lastuser`, `thread_postcount`, `thread_poll`, `thread_sticky`, `thread_locked`, `thread_hidden`) VALUES
(2, 1, 'Test', 1, 6, 1427817315, 1, 1, 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_thread_notify`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_thread_notify` (
  `thread_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `notify_datestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `notify_user` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `notify_status` tinyint(1) unsigned NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_users`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_users` (
`user_id` mediumint(8) unsigned NOT NULL,
  `user_name` varchar(30) NOT NULL DEFAULT '',
  `user_algo` varchar(10) NOT NULL DEFAULT 'sha256',
  `user_salt` varchar(40) NOT NULL DEFAULT '',
  `user_password` varchar(64) NOT NULL DEFAULT '',
  `user_admin_algo` varchar(10) NOT NULL DEFAULT 'sha256',
  `user_admin_salt` varchar(40) NOT NULL DEFAULT '',
  `user_admin_password` varchar(64) NOT NULL DEFAULT '',
  `user_email` varchar(100) NOT NULL DEFAULT '',
  `user_hide_email` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `user_offset` char(5) NOT NULL DEFAULT '0',
  `user_avatar` varchar(100) NOT NULL DEFAULT '',
  `user_posts` smallint(5) unsigned NOT NULL DEFAULT '0',
  `user_threads` text NOT NULL,
  `user_joined` int(10) unsigned NOT NULL DEFAULT '0',
  `user_lastvisit` int(10) unsigned NOT NULL DEFAULT '0',
  `user_ip` varchar(45) NOT NULL DEFAULT '0.0.0.0',
  `user_ip_type` tinyint(1) unsigned NOT NULL DEFAULT '4',
  `user_rights` text NOT NULL,
  `user_groups` text NOT NULL,
  `user_level` tinyint(3) unsigned NOT NULL DEFAULT '101',
  `user_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `user_actiontime` int(10) unsigned NOT NULL DEFAULT '0',
  `user_theme` varchar(100) NOT NULL DEFAULT 'Default',
  `user_location` varchar(50) NOT NULL DEFAULT '',
  `user_birthdate` date NOT NULL DEFAULT '0000-00-00',
  `user_skype` varchar(100) NOT NULL DEFAULT '',
  `user_aim` varchar(16) NOT NULL DEFAULT '',
  `user_icq` varchar(15) NOT NULL DEFAULT '',
  `user_yahoo` varchar(100) NOT NULL DEFAULT '',
  `user_web` varchar(200) NOT NULL DEFAULT '',
  `user_sig` varchar(500) NOT NULL DEFAULT '',
  `user_language` varchar(50) NOT NULL DEFAULT 'German'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fusionu92g5_users`
--

INSERT INTO `fusionu92g5_users` (`user_id`, `user_name`, `user_algo`, `user_salt`, `user_password`, `user_admin_algo`, `user_admin_salt`, `user_admin_password`, `user_email`, `user_hide_email`, `user_offset`, `user_avatar`, `user_posts`, `user_threads`, `user_joined`, `user_lastvisit`, `user_ip`, `user_ip_type`, `user_rights`, `user_groups`, `user_level`, `user_status`, `user_actiontime`, `user_theme`, `user_location`, `user_birthdate`, `user_skype`, `user_aim`, `user_icq`, `user_yahoo`, `user_web`, `user_sig`, `user_language`) VALUES
(1, 'Sina', 'sha256', '7e7ac3d182e8dcaacb6b086629ea5e890f5df0bb', '7efc35020b95975f765fc33aa1f45a21134545e338339662bdb9f7f0f6692340', 'sha256', 'e18e4d38e0772cb448c746751cb83d1cbdb30ce7', 'f14c7264c9acfe9c3c4c219bfcfcc41e426f63acef6b8bc584c8eb41da2117c4', 'test@mail.com', 1, '0', '', 1, '', 1427741102, 1427825652, '0000:0000:0000:0000:0000:0000:0000:0001', 6, 'A.AC.AD.APWR.B.BB.C.CP.DB.DC.D.ERRO.FQ.F.FR.IM.I.IP.M.MAIL.N.NC.P.PH.PI.PL.PO.ROB.SL.S1.S2.S3.S4.S5.S6.S7.S8.S9.S10.S11.S12.SB.SM.SU.UF.UFC.UG.UL.U.W.WC.MAIL.LANG.DPT.DEV', '', 103, 0, 0, 'Default', '', '0000-00-00', '', '', '', '', '', '', 'German');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_user_fields`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_user_fields` (
`field_id` mediumint(8) unsigned NOT NULL,
  `field_name` varchar(50) NOT NULL,
  `field_cat` mediumint(8) unsigned NOT NULL DEFAULT '1',
  `field_required` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `field_log` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `field_registration` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `field_order` smallint(5) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fusionu92g5_user_fields`
--

INSERT INTO `fusionu92g5_user_fields` (`field_id`, `field_name`, `field_cat`, `field_required`, `field_log`, `field_registration`, `field_order`) VALUES
(1, 'user_location', 2, 0, 0, 0, 1),
(2, 'user_birthdate', 2, 0, 0, 0, 2),
(3, 'user_skype', 1, 0, 0, 0, 1),
(4, 'user_aim', 1, 0, 0, 0, 2),
(5, 'user_icq', 1, 0, 0, 0, 3),
(6, 'user_yahoo', 1, 0, 0, 0, 5),
(7, 'user_web', 1, 0, 0, 0, 6),
(8, 'user_offset', 3, 0, 0, 0, 1),
(9, 'user_theme', 3, 0, 0, 0, 2),
(10, 'user_sig', 3, 0, 0, 0, 3),
(11, 'user_blacklist', 5, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_user_field_cats`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_user_field_cats` (
`field_cat_id` mediumint(8) unsigned NOT NULL,
  `field_cat_name` varchar(200) NOT NULL,
  `field_cat_db` varchar(100) NOT NULL,
  `field_cat_index` varchar(200) NOT NULL,
  `field_cat_class` varchar(50) NOT NULL,
  `field_cat_page` smallint(1) unsigned NOT NULL DEFAULT '0',
  `field_cat_order` smallint(5) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fusionu92g5_user_field_cats`
--

INSERT INTO `fusionu92g5_user_field_cats` (`field_cat_id`, `field_cat_name`, `field_cat_db`, `field_cat_index`, `field_cat_class`, `field_cat_page`, `field_cat_order`) VALUES
(1, 'Kontakt Informationen', '', '', '', 0, 1),
(2, 'Sonstige Informationen', '', '', '', 0, 2),
(3, 'Optionen', '', '', '', 0, 3),
(4, 'Statistiken', '', '', '', 0, 4),
(5, 'Privacy', '', '', '', 1, 5);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_user_groups`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_user_groups` (
`group_id` tinyint(3) unsigned NOT NULL,
  `group_name` varchar(100) NOT NULL,
  `group_description` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_user_log`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_user_log` (
`userlog_id` mediumint(8) unsigned NOT NULL,
  `userlog_user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `userlog_field` varchar(50) NOT NULL DEFAULT '',
  `userlog_value_new` text NOT NULL,
  `userlog_value_old` text NOT NULL,
  `userlog_timestamp` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_weblinks`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_weblinks` (
`weblink_id` mediumint(8) unsigned NOT NULL,
  `weblink_name` varchar(100) NOT NULL DEFAULT '',
  `weblink_description` text NOT NULL,
  `weblink_url` varchar(200) NOT NULL DEFAULT '',
  `weblink_cat` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `weblink_datestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `weblink_count` smallint(5) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fusionu92g5_weblink_cats`
--

CREATE TABLE IF NOT EXISTS `fusionu92g5_weblink_cats` (
`weblink_cat_id` mediumint(8) unsigned NOT NULL,
  `weblink_cat_name` varchar(100) NOT NULL DEFAULT '',
  `weblink_cat_description` text NOT NULL,
  `weblink_cat_sorting` varchar(50) NOT NULL DEFAULT 'weblink_name ASC',
  `weblink_cat_access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `weblink_cat_language` varchar(50) NOT NULL DEFAULT 'German'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `arrowchat`
--
ALTER TABLE `arrowchat`
 ADD PRIMARY KEY (`id`), ADD KEY `to` (`to`), ADD KEY `read` (`read`), ADD KEY `user_read` (`user_read`), ADD KEY `from` (`from`);

--
-- Indizes für die Tabelle `arrowchat_admin`
--
ALTER TABLE `arrowchat_admin`
 ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `arrowchat_applications`
--
ALTER TABLE `arrowchat_applications`
 ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `arrowchat_banlist`
--
ALTER TABLE `arrowchat_banlist`
 ADD PRIMARY KEY (`ban_id`);

--
-- Indizes für die Tabelle `arrowchat_chatroom_banlist`
--
ALTER TABLE `arrowchat_chatroom_banlist`
 ADD KEY `user_id` (`user_id`), ADD KEY `chatroom_id` (`chatroom_id`);

--
-- Indizes für die Tabelle `arrowchat_chatroom_messages`
--
ALTER TABLE `arrowchat_chatroom_messages`
 ADD PRIMARY KEY (`id`), ADD KEY `chatroom_id` (`chatroom_id`), ADD KEY `user_id` (`user_id`), ADD KEY `sent` (`sent`);

--
-- Indizes für die Tabelle `arrowchat_chatroom_rooms`
--
ALTER TABLE `arrowchat_chatroom_rooms`
 ADD PRIMARY KEY (`id`), ADD KEY `session_time` (`session_time`), ADD KEY `author_id` (`author_id`);

--
-- Indizes für die Tabelle `arrowchat_chatroom_users`
--
ALTER TABLE `arrowchat_chatroom_users`
 ADD PRIMARY KEY (`user_id`), ADD KEY `chatroom_id` (`chatroom_id`), ADD KEY `is_admin` (`is_admin`), ADD KEY `is_mod` (`is_mod`), ADD KEY `session_time` (`session_time`);

--
-- Indizes für die Tabelle `arrowchat_config`
--
ALTER TABLE `arrowchat_config`
 ADD UNIQUE KEY `config_name` (`config_name`);

--
-- Indizes für die Tabelle `arrowchat_graph_log`
--
ALTER TABLE `arrowchat_graph_log`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `date` (`date`);

--
-- Indizes für die Tabelle `arrowchat_notifications`
--
ALTER TABLE `arrowchat_notifications`
 ADD PRIMARY KEY (`id`), ADD KEY `to_id` (`to_id`), ADD KEY `alert_read` (`alert_read`), ADD KEY `user_read` (`user_read`), ADD KEY `alert_time` (`alert_time`);

--
-- Indizes für die Tabelle `arrowchat_notifications_markup`
--
ALTER TABLE `arrowchat_notifications_markup`
 ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `arrowchat_smilies`
--
ALTER TABLE `arrowchat_smilies`
 ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `arrowchat_status`
--
ALTER TABLE `arrowchat_status`
 ADD PRIMARY KEY (`userid`), ADD KEY `hash_id` (`hash_id`), ADD KEY `session_time` (`session_time`);

--
-- Indizes für die Tabelle `arrowchat_themes`
--
ALTER TABLE `arrowchat_themes`
 ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `arrowchat_trayicons`
--
ALTER TABLE `arrowchat_trayicons`
 ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `fusionu92g5_admin`
--
ALTER TABLE `fusionu92g5_admin`
 ADD PRIMARY KEY (`admin_id`);

--
-- Indizes für die Tabelle `fusionu92g5_admin_resetlog`
--
ALTER TABLE `fusionu92g5_admin_resetlog`
 ADD PRIMARY KEY (`reset_id`);

--
-- Indizes für die Tabelle `fusionu92g5_articles`
--
ALTER TABLE `fusionu92g5_articles`
 ADD PRIMARY KEY (`article_id`), ADD KEY `article_cat` (`article_cat`), ADD KEY `article_datestamp` (`article_datestamp`), ADD KEY `article_reads` (`article_reads`);

--
-- Indizes für die Tabelle `fusionu92g5_article_cats`
--
ALTER TABLE `fusionu92g5_article_cats`
 ADD PRIMARY KEY (`article_cat_id`), ADD KEY `article_cat_access` (`article_cat_access`);

--
-- Indizes für die Tabelle `fusionu92g5_bbcodes`
--
ALTER TABLE `fusionu92g5_bbcodes`
 ADD PRIMARY KEY (`bbcode_id`), ADD KEY `bbcode_order` (`bbcode_order`);

--
-- Indizes für die Tabelle `fusionu92g5_blacklist`
--
ALTER TABLE `fusionu92g5_blacklist`
 ADD PRIMARY KEY (`blacklist_id`), ADD KEY `blacklist_ip_type` (`blacklist_ip_type`);

--
-- Indizes für die Tabelle `fusionu92g5_captcha`
--
ALTER TABLE `fusionu92g5_captcha`
 ADD KEY `captcha_datestamp` (`captcha_datestamp`);

--
-- Indizes für die Tabelle `fusionu92g5_comments`
--
ALTER TABLE `fusionu92g5_comments`
 ADD PRIMARY KEY (`comment_id`), ADD KEY `comment_datestamp` (`comment_datestamp`);

--
-- Indizes für die Tabelle `fusionu92g5_custom_pages`
--
ALTER TABLE `fusionu92g5_custom_pages`
 ADD PRIMARY KEY (`page_id`);

--
-- Indizes für die Tabelle `fusionu92g5_developments`
--
ALTER TABLE `fusionu92g5_developments`
 ADD PRIMARY KEY (`development_id`);

--
-- Indizes für die Tabelle `fusionu92g5_development_cats`
--
ALTER TABLE `fusionu92g5_development_cats`
 ADD PRIMARY KEY (`development_cat_id`), ADD KEY `development_cat_name` (`development_cat_name`);

--
-- Indizes für die Tabelle `fusionu92g5_development_ratings`
--
ALTER TABLE `fusionu92g5_development_ratings`
 ADD PRIMARY KEY (`development_rating_id`);

--
-- Indizes für die Tabelle `fusionu92g5_dfpp_cats`
--
ALTER TABLE `fusionu92g5_dfpp_cats`
 ADD PRIMARY KEY (`project_cat_id`), ADD KEY `project_cat_name` (`project_cat_name`);

--
-- Indizes für die Tabelle `fusionu92g5_dfpp_projects`
--
ALTER TABLE `fusionu92g5_dfpp_projects`
 ADD PRIMARY KEY (`project_id`), ADD KEY `project_name` (`project_name`);

--
-- Indizes für die Tabelle `fusionu92g5_dfpp_proposals`
--
ALTER TABLE `fusionu92g5_dfpp_proposals`
 ADD PRIMARY KEY (`project_proposal_id`), ADD KEY `project_proposal_posted` (`project_proposal_posted`);

--
-- Indizes für die Tabelle `fusionu92g5_dfpp_reports`
--
ALTER TABLE `fusionu92g5_dfpp_reports`
 ADD PRIMARY KEY (`project_report_id`);

--
-- Indizes für die Tabelle `fusionu92g5_downloads`
--
ALTER TABLE `fusionu92g5_downloads`
 ADD PRIMARY KEY (`download_id`), ADD KEY `download_datestamp` (`download_datestamp`);

--
-- Indizes für die Tabelle `fusionu92g5_download_cats`
--
ALTER TABLE `fusionu92g5_download_cats`
 ADD PRIMARY KEY (`download_cat_id`);

--
-- Indizes für die Tabelle `fusionu92g5_email_templates`
--
ALTER TABLE `fusionu92g5_email_templates`
 ADD PRIMARY KEY (`template_id`);

--
-- Indizes für die Tabelle `fusionu92g5_email_verify`
--
ALTER TABLE `fusionu92g5_email_verify`
 ADD KEY `user_datestamp` (`user_datestamp`);

--
-- Indizes für die Tabelle `fusionu92g5_errors`
--
ALTER TABLE `fusionu92g5_errors`
 ADD PRIMARY KEY (`error_id`);

--
-- Indizes für die Tabelle `fusionu92g5_faqs`
--
ALTER TABLE `fusionu92g5_faqs`
 ADD PRIMARY KEY (`faq_id`);

--
-- Indizes für die Tabelle `fusionu92g5_faq_cats`
--
ALTER TABLE `fusionu92g5_faq_cats`
 ADD PRIMARY KEY (`faq_cat_id`);

--
-- Indizes für die Tabelle `fusionu92g5_flood_control`
--
ALTER TABLE `fusionu92g5_flood_control`
 ADD KEY `flood_timestamp` (`flood_timestamp`);

--
-- Indizes für die Tabelle `fusionu92g5_forums`
--
ALTER TABLE `fusionu92g5_forums`
 ADD PRIMARY KEY (`forum_id`), ADD KEY `forum_order` (`forum_order`), ADD KEY `forum_lastpost` (`forum_lastpost`), ADD KEY `forum_postcount` (`forum_postcount`), ADD KEY `forum_threadcount` (`forum_threadcount`);

--
-- Indizes für die Tabelle `fusionu92g5_forum_attachments`
--
ALTER TABLE `fusionu92g5_forum_attachments`
 ADD PRIMARY KEY (`attach_id`);

--
-- Indizes für die Tabelle `fusionu92g5_forum_polls`
--
ALTER TABLE `fusionu92g5_forum_polls`
 ADD KEY `thread_id` (`thread_id`);

--
-- Indizes für die Tabelle `fusionu92g5_forum_poll_options`
--
ALTER TABLE `fusionu92g5_forum_poll_options`
 ADD KEY `thread_id` (`thread_id`);

--
-- Indizes für die Tabelle `fusionu92g5_forum_poll_voters`
--
ALTER TABLE `fusionu92g5_forum_poll_voters`
 ADD KEY `thread_id` (`thread_id`,`forum_vote_user_id`);

--
-- Indizes für die Tabelle `fusionu92g5_forum_ranks`
--
ALTER TABLE `fusionu92g5_forum_ranks`
 ADD PRIMARY KEY (`rank_id`);

--
-- Indizes für die Tabelle `fusionu92g5_infusions`
--
ALTER TABLE `fusionu92g5_infusions`
 ADD PRIMARY KEY (`inf_id`);

--
-- Indizes für die Tabelle `fusionu92g5_messages`
--
ALTER TABLE `fusionu92g5_messages`
 ADD PRIMARY KEY (`message_id`), ADD KEY `message_datestamp` (`message_datestamp`);

--
-- Indizes für die Tabelle `fusionu92g5_messages_options`
--
ALTER TABLE `fusionu92g5_messages_options`
 ADD PRIMARY KEY (`user_id`);

--
-- Indizes für die Tabelle `fusionu92g5_mlt_tables`
--
ALTER TABLE `fusionu92g5_mlt_tables`
 ADD PRIMARY KEY (`mlt_rights`);

--
-- Indizes für die Tabelle `fusionu92g5_news`
--
ALTER TABLE `fusionu92g5_news`
 ADD PRIMARY KEY (`news_id`), ADD KEY `news_datestamp` (`news_datestamp`), ADD KEY `news_reads` (`news_reads`);

--
-- Indizes für die Tabelle `fusionu92g5_news_cats`
--
ALTER TABLE `fusionu92g5_news_cats`
 ADD PRIMARY KEY (`news_cat_id`);

--
-- Indizes für die Tabelle `fusionu92g5_new_users`
--
ALTER TABLE `fusionu92g5_new_users`
 ADD KEY `user_datestamp` (`user_datestamp`);

--
-- Indizes für die Tabelle `fusionu92g5_panels`
--
ALTER TABLE `fusionu92g5_panels`
 ADD PRIMARY KEY (`panel_id`), ADD KEY `panel_order` (`panel_order`);

--
-- Indizes für die Tabelle `fusionu92g5_permalinks_alias`
--
ALTER TABLE `fusionu92g5_permalinks_alias`
 ADD PRIMARY KEY (`alias_id`), ADD KEY `alias_id` (`alias_id`);

--
-- Indizes für die Tabelle `fusionu92g5_permalinks_method`
--
ALTER TABLE `fusionu92g5_permalinks_method`
 ADD PRIMARY KEY (`pattern_id`);

--
-- Indizes für die Tabelle `fusionu92g5_permalinks_rewrites`
--
ALTER TABLE `fusionu92g5_permalinks_rewrites`
 ADD PRIMARY KEY (`rewrite_id`);

--
-- Indizes für die Tabelle `fusionu92g5_photos`
--
ALTER TABLE `fusionu92g5_photos`
 ADD PRIMARY KEY (`photo_id`), ADD KEY `photo_order` (`photo_order`), ADD KEY `photo_datestamp` (`photo_datestamp`);

--
-- Indizes für die Tabelle `fusionu92g5_photo_albums`
--
ALTER TABLE `fusionu92g5_photo_albums`
 ADD PRIMARY KEY (`album_id`), ADD KEY `album_order` (`album_order`), ADD KEY `album_datestamp` (`album_datestamp`);

--
-- Indizes für die Tabelle `fusionu92g5_polls`
--
ALTER TABLE `fusionu92g5_polls`
 ADD PRIMARY KEY (`poll_id`);

--
-- Indizes für die Tabelle `fusionu92g5_poll_votes`
--
ALTER TABLE `fusionu92g5_poll_votes`
 ADD PRIMARY KEY (`vote_id`);

--
-- Indizes für die Tabelle `fusionu92g5_posts`
--
ALTER TABLE `fusionu92g5_posts`
 ADD PRIMARY KEY (`post_id`), ADD KEY `thread_id` (`thread_id`), ADD KEY `post_datestamp` (`post_datestamp`);

--
-- Indizes für die Tabelle `fusionu92g5_ratings`
--
ALTER TABLE `fusionu92g5_ratings`
 ADD PRIMARY KEY (`rating_id`);

--
-- Indizes für die Tabelle `fusionu92g5_settings`
--
ALTER TABLE `fusionu92g5_settings`
 ADD PRIMARY KEY (`settings_name`);

--
-- Indizes für die Tabelle `fusionu92g5_settings_inf`
--
ALTER TABLE `fusionu92g5_settings_inf`
 ADD PRIMARY KEY (`settings_name`);

--
-- Indizes für die Tabelle `fusionu92g5_site_links`
--
ALTER TABLE `fusionu92g5_site_links`
 ADD PRIMARY KEY (`link_id`);

--
-- Indizes für die Tabelle `fusionu92g5_smileys`
--
ALTER TABLE `fusionu92g5_smileys`
 ADD PRIMARY KEY (`smiley_id`);

--
-- Indizes für die Tabelle `fusionu92g5_submissions`
--
ALTER TABLE `fusionu92g5_submissions`
 ADD PRIMARY KEY (`submit_id`);

--
-- Indizes für die Tabelle `fusionu92g5_suspends`
--
ALTER TABLE `fusionu92g5_suspends`
 ADD PRIMARY KEY (`suspend_id`);

--
-- Indizes für die Tabelle `fusionu92g5_threads`
--
ALTER TABLE `fusionu92g5_threads`
 ADD PRIMARY KEY (`thread_id`), ADD KEY `thread_postcount` (`thread_postcount`), ADD KEY `thread_lastpost` (`thread_lastpost`), ADD KEY `thread_views` (`thread_views`);

--
-- Indizes für die Tabelle `fusionu92g5_thread_notify`
--
ALTER TABLE `fusionu92g5_thread_notify`
 ADD KEY `notify_datestamp` (`notify_datestamp`);

--
-- Indizes für die Tabelle `fusionu92g5_users`
--
ALTER TABLE `fusionu92g5_users`
 ADD PRIMARY KEY (`user_id`), ADD KEY `user_name` (`user_name`), ADD KEY `user_joined` (`user_joined`), ADD KEY `user_lastvisit` (`user_lastvisit`);

--
-- Indizes für die Tabelle `fusionu92g5_user_fields`
--
ALTER TABLE `fusionu92g5_user_fields`
 ADD PRIMARY KEY (`field_id`), ADD KEY `field_order` (`field_order`);

--
-- Indizes für die Tabelle `fusionu92g5_user_field_cats`
--
ALTER TABLE `fusionu92g5_user_field_cats`
 ADD PRIMARY KEY (`field_cat_id`);

--
-- Indizes für die Tabelle `fusionu92g5_user_groups`
--
ALTER TABLE `fusionu92g5_user_groups`
 ADD PRIMARY KEY (`group_id`);

--
-- Indizes für die Tabelle `fusionu92g5_user_log`
--
ALTER TABLE `fusionu92g5_user_log`
 ADD PRIMARY KEY (`userlog_id`), ADD KEY `userlog_user_id` (`userlog_user_id`), ADD KEY `userlog_field` (`userlog_field`);

--
-- Indizes für die Tabelle `fusionu92g5_weblinks`
--
ALTER TABLE `fusionu92g5_weblinks`
 ADD PRIMARY KEY (`weblink_id`), ADD KEY `weblink_datestamp` (`weblink_datestamp`), ADD KEY `weblink_count` (`weblink_count`);

--
-- Indizes für die Tabelle `fusionu92g5_weblink_cats`
--
ALTER TABLE `fusionu92g5_weblink_cats`
 ADD PRIMARY KEY (`weblink_cat_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `arrowchat`
--
ALTER TABLE `arrowchat`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `arrowchat_admin`
--
ALTER TABLE `arrowchat_admin`
MODIFY `id` int(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `arrowchat_applications`
--
ALTER TABLE `arrowchat_applications`
MODIFY `id` int(3) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `arrowchat_banlist`
--
ALTER TABLE `arrowchat_banlist`
MODIFY `ban_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `arrowchat_chatroom_messages`
--
ALTER TABLE `arrowchat_chatroom_messages`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `arrowchat_chatroom_rooms`
--
ALTER TABLE `arrowchat_chatroom_rooms`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `arrowchat_graph_log`
--
ALTER TABLE `arrowchat_graph_log`
MODIFY `id` int(6) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `arrowchat_notifications`
--
ALTER TABLE `arrowchat_notifications`
MODIFY `id` int(25) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `arrowchat_notifications_markup`
--
ALTER TABLE `arrowchat_notifications_markup`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT für Tabelle `arrowchat_smilies`
--
ALTER TABLE `arrowchat_smilies`
MODIFY `id` int(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT für Tabelle `arrowchat_themes`
--
ALTER TABLE `arrowchat_themes`
MODIFY `id` int(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `arrowchat_trayicons`
--
ALTER TABLE `arrowchat_trayicons`
MODIFY `id` int(3) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_admin`
--
ALTER TABLE `fusionu92g5_admin`
MODIFY `admin_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_admin_resetlog`
--
ALTER TABLE `fusionu92g5_admin_resetlog`
MODIFY `reset_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_articles`
--
ALTER TABLE `fusionu92g5_articles`
MODIFY `article_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_article_cats`
--
ALTER TABLE `fusionu92g5_article_cats`
MODIFY `article_cat_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_bbcodes`
--
ALTER TABLE `fusionu92g5_bbcodes`
MODIFY `bbcode_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_blacklist`
--
ALTER TABLE `fusionu92g5_blacklist`
MODIFY `blacklist_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_comments`
--
ALTER TABLE `fusionu92g5_comments`
MODIFY `comment_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_custom_pages`
--
ALTER TABLE `fusionu92g5_custom_pages`
MODIFY `page_id` mediumint(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_developments`
--
ALTER TABLE `fusionu92g5_developments`
MODIFY `development_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_development_cats`
--
ALTER TABLE `fusionu92g5_development_cats`
MODIFY `development_cat_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_development_ratings`
--
ALTER TABLE `fusionu92g5_development_ratings`
MODIFY `development_rating_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_dfpp_cats`
--
ALTER TABLE `fusionu92g5_dfpp_cats`
MODIFY `project_cat_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_dfpp_projects`
--
ALTER TABLE `fusionu92g5_dfpp_projects`
MODIFY `project_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_dfpp_proposals`
--
ALTER TABLE `fusionu92g5_dfpp_proposals`
MODIFY `project_proposal_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_dfpp_reports`
--
ALTER TABLE `fusionu92g5_dfpp_reports`
MODIFY `project_report_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_downloads`
--
ALTER TABLE `fusionu92g5_downloads`
MODIFY `download_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_download_cats`
--
ALTER TABLE `fusionu92g5_download_cats`
MODIFY `download_cat_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_email_templates`
--
ALTER TABLE `fusionu92g5_email_templates`
MODIFY `template_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_errors`
--
ALTER TABLE `fusionu92g5_errors`
MODIFY `error_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_faqs`
--
ALTER TABLE `fusionu92g5_faqs`
MODIFY `faq_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_faq_cats`
--
ALTER TABLE `fusionu92g5_faq_cats`
MODIFY `faq_cat_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_forums`
--
ALTER TABLE `fusionu92g5_forums`
MODIFY `forum_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_forum_attachments`
--
ALTER TABLE `fusionu92g5_forum_attachments`
MODIFY `attach_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_forum_ranks`
--
ALTER TABLE `fusionu92g5_forum_ranks`
MODIFY `rank_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_infusions`
--
ALTER TABLE `fusionu92g5_infusions`
MODIFY `inf_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_messages`
--
ALTER TABLE `fusionu92g5_messages`
MODIFY `message_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_news`
--
ALTER TABLE `fusionu92g5_news`
MODIFY `news_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_news_cats`
--
ALTER TABLE `fusionu92g5_news_cats`
MODIFY `news_cat_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_panels`
--
ALTER TABLE `fusionu92g5_panels`
MODIFY `panel_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_permalinks_alias`
--
ALTER TABLE `fusionu92g5_permalinks_alias`
MODIFY `alias_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_permalinks_method`
--
ALTER TABLE `fusionu92g5_permalinks_method`
MODIFY `pattern_id` int(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_permalinks_rewrites`
--
ALTER TABLE `fusionu92g5_permalinks_rewrites`
MODIFY `rewrite_id` int(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_photos`
--
ALTER TABLE `fusionu92g5_photos`
MODIFY `photo_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_photo_albums`
--
ALTER TABLE `fusionu92g5_photo_albums`
MODIFY `album_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_polls`
--
ALTER TABLE `fusionu92g5_polls`
MODIFY `poll_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_poll_votes`
--
ALTER TABLE `fusionu92g5_poll_votes`
MODIFY `vote_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_posts`
--
ALTER TABLE `fusionu92g5_posts`
MODIFY `post_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_ratings`
--
ALTER TABLE `fusionu92g5_ratings`
MODIFY `rating_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_site_links`
--
ALTER TABLE `fusionu92g5_site_links`
MODIFY `link_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_smileys`
--
ALTER TABLE `fusionu92g5_smileys`
MODIFY `smiley_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_submissions`
--
ALTER TABLE `fusionu92g5_submissions`
MODIFY `submit_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_suspends`
--
ALTER TABLE `fusionu92g5_suspends`
MODIFY `suspend_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_threads`
--
ALTER TABLE `fusionu92g5_threads`
MODIFY `thread_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_users`
--
ALTER TABLE `fusionu92g5_users`
MODIFY `user_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_user_fields`
--
ALTER TABLE `fusionu92g5_user_fields`
MODIFY `field_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_user_field_cats`
--
ALTER TABLE `fusionu92g5_user_field_cats`
MODIFY `field_cat_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_user_groups`
--
ALTER TABLE `fusionu92g5_user_groups`
MODIFY `group_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_user_log`
--
ALTER TABLE `fusionu92g5_user_log`
MODIFY `userlog_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_weblinks`
--
ALTER TABLE `fusionu92g5_weblinks`
MODIFY `weblink_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fusionu92g5_weblink_cats`
--
ALTER TABLE `fusionu92g5_weblink_cats`
MODIFY `weblink_cat_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
