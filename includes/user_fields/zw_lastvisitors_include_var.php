<?php
/*-----------------------------------------------------------
|   zWar Clan-Infusion	Last-Profile-Visitors Add-on		|
|															|
|	Copyright (C) 2006-2008 Christoph Schreck				|
|	zezoar@gmx.net											|
|	http://www.zoffclan.de/zoffdev/							|
|															|
|   This program is free software; 							|
|	you can redistribute it and/or modify it under 			|
|	the terms of the GNU General Public License 			|
|	as published by the Free Software Foundation; 			|
|	either version 3 of the License, 						|
|	or (at your option) any later version.					|
|															|
|   This program is distributed in the hope that 			|
|	it will be useful, but WITHOUT ANY WARRANTY; 			|
|	without even the implied warranty of MERCHANTABILITY 	|
|	or FITNESS FOR A PARTICULAR PURPOSE. 					|
|	See the GNU General Public License for more details.	|
|															|
|   You should have received a copy of the 					|
|	GNU General Public License along with this program; 	|
|	if not, see <http://www.gnu.org/licenses/>.				|
-----------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

$user_field_name = $locale['uf_zw_lastvis_01'].":";
$user_field_desc = $locale['uf_zw_lastvis_02'];
$user_field_dbname = "zw_lastvisitors";
$user_field_group = 2;
$user_field_dbinfo = "VARCHAR(200) NOT NULL DEFAULT ''";
?>