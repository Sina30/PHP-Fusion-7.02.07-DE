# PHP-Fusion-7.02.07-DE
Before installing PHP-Fusion you need to check the requirements for this version:
- PHP 5.1.2 or higher
- MySQL 4.1 or higher

You have to create a MySQL database. You can do this via your web-hosting control panel or phpMyAdmin. Make sure you have your mysql access details at hand including the hostname, username, password and database name as you will need to specify these during setup.

1. Before you upload the files, rename the file _config.php (located in the files folder) to config.php.

2. Upload the contents of the files folder to your web server.

3. Unless you run PHP-Fusion on a local server, in most cases you will need to CHMOD the following files and folders to 777:

administration/db_backups/
downloads/
downloads/images/
downloads/submissions/
downloads/submissions/images/
forum/attachments/
ftp_upload/
images/
images/imagelist.js
images/articles/
images/avatars/
images/news/
images/news/thumbs/
images/news_cats/
images/photoalbum/
images/photoalbum/submissions/
config.php
Note: Some hosts doesn't allow CHMOD 777, in that case you can use CHMOD 755 if CHMOD 777 fails.

4. Go to your website where setup.php should start automatically. If not, you should run setup.php manually by entering your full site url followed by /setup.php. Example: http://www.yourdomain.com/setup.php.

5. Complete the setup process by following all on-screen prompts.

6. Immediately after completing the installation of PHP-Fusion you must CHMOD config.php back to 644 AND delete setup.php from your web server. Failure to do so could lead to someone else taking control of your site.

UPGRADE FROM V7.00.XX OR V7.01.XX
Before you upgrade we strongly recommend that you backup your files and your database as PHP-Fusion 7.02 is a major update from PHP-Fusion 7.01. You need to follow these instructions precisely. We also recommend that you do the upgrade from 7.00.xx to 7.01.xx first before you upgrade to 7.02.00.
Before the upgrade you need to check the requirements for this version:

- PHP 5.1.2 or higher
- MySQL 4.1 or higher

1. Version 7.02 code is mostly compatible with version 7.01, however since there are a lot of changes to the core, some addons (mods, infusions, panels or themes) may not work properly.

2. You must first upload the upgrade script from the folder named 'upgrade v7' (or 'upgrade v701' if you already have v7.01 running) to the administration folder of your site and upload the folder named 'locale' to the root of your site. Without the locale files, some names may not be added to the database.

3. Login to your site as the Super Administrator. Under the System Admin tab of the Admin Panel, click on Upgrade then click the button marked Upgrade. YOU MUST perform the upgrade first! The upgrade process will complete only when you see 'Database upgrade complete'.

4. VERY IMPORTANT: Since this release contains a number of structural changes, some elements of your site will not work properly until you have updated all of your files. YOU MUST upload ALL of the files from the /files-folder, EXCEPT:

_config.php
setup.php
CHMOD the following files and folders to 777:
downloads/
downloads/images/
downloads/submissions/
downloads/submissions/images/
ftp_upload/
If at all you are any doubt please feel free to ask one of our support sites for help, there are plenty of knowledgeable users in our community who can help or advise you regarding the upgrade process.

MINOR FIX FOR NON-CORE THEMES
If you are using a non-core theme for your site, you will need to edit theme.php and styles.css in order for your theme to display this options.

News category images:
Open themes/your_theme/theme.php
In the function render_news function
Find ".$news."
Replace with ".$info['cat_image'].$news."
Avatar comments:
Open themes/your_theme/theme.php
In the function render_comments function
Add if ($settings['comments_avatar'] == "1") { echo "".$data['user_avatar']."\n"; }
Don't forget to add in your styles.css the .comments_avatar { } class and personalized as you like.
Save and reload the file.
