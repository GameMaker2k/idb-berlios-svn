<?php
/*
    This program is free software; you can redistribute it and/or modify
    it under the terms of the Revised BSD License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    Revised BSD License for more details.

    Copyright 2004-2009 iDB Support - http://idb.berlios.de/
    Copyright 2004-2009 Game Maker 2k - http://gamemaker2k.org/
    $ThemeInfo - Name: iDB Gray - Author: cooldude2k $
    $FileInfo: settings.php - Last Update: 09/08/2010 SVN 531 - Author: cooldude2k $
*/
$ThemeSet = array();
$ThemeSet['ThemeName'] = "iDB Gray Theme";
$ThemeSet['ThemeMaker'] = "Kazuki";
$ThemeSet['ThemeVersion'] = "0.4.0";
$ThemeSet['ThemeVersionType'] = "Alpha";
$ThemeSet['ThemeSubVersion'] = "SVN 531";
$ThemeSet['MakerURL'] = "http://upload.idb.s1.jcink.com/";
$ThemeSet['CopyRight'] = $ThemeSet['ThemeName']." was made by <a href=\"".$ThemeSet['MakerURL']."\" title=\"".$ThemeSet['ThemeMaker']."\">".$ThemeSet['ThemeMaker']."</a>";
$ThemeSet['CSS'] = "themes/Gray/css.css";
$ThemeSet['CSSType'] = "include";
$ThemeSet['FavIcon'] = "themes/Gray/favicon.ico";
$ThemeSet['TableStyle'] = "table";
$ThemeSet['MiniPageAltStyle'] = "off";
$ThemeSet['PreLogo'] = "<div style=\"text-align: center;\">";
$ThemeSet['Logo'] = $Settings['board_name'];
$ThemeSet['LogoStyle'] = "font-size: 40px; font-family: verdana, arial, sans-serif; color: black;";
$ThemeSet['SubLogo'] = "</div>";
$ThemeSet['TopicIcon'] = "<div style=\"text-align: center; font-size: 11px;\" title=\"Topic!\"> (T) </div>";
$ThemeSet['HotTopic'] = "<div style=\"text-align: center; font-size: 11px; font-weight: bold;\" title=\"Hot Topic!\"> (T) </div>";
$ThemeSet['PinTopic'] = "<div style=\"text-align: center; font-size: 11px;\" title=\"Pinned Topic!\"> {P} </div>";
$ThemeSet['HotPinTopic'] = "<div style=\"text-align: center; font-size: 11px; font-weight: bold;\" title=\"Hot Pinned Topic!\"> {P} </div>";
$ThemeSet['ClosedTopic'] = "<div style=\"text-align: center; font-size: 11px; text-decoration: line-through;\" title=\"Closed Topic!\"> [T] </div>";
$ThemeSet['HotClosedTopic'] = "<div style=\"text-align: center; font-size: 11px; text-decoration: line-through; font-weight: bold;\" title=\"Hot Closed Topic!\"> [T] </div>";
$ThemeSet['PinClosedTopic'] = "<div style=\"text-align: center; font-size: 11px; text-decoration: line-through;\" title=\"Closed Pinned Topic!\"> [P] </div>";
$ThemeSet['HotPinClosedTopic'] = "<div style=\"text-align: center; font-size: 11px; text-decoration: line-through; font-weight: bold;\" title=\"Hot Closed Pinned Topic!\"> [P] </div>";
$ThemeSet['MovedTopicIcon'] = "<div style=\"text-align: center; font-size: 11px;\" title=\"Topic!\"> (~T) </div>";
$ThemeSet['MovedHotTopic'] = "<div style=\"text-align: center; font-size: 11px; font-weight: bold;\" title=\"Hot Topic!\"> (~T) </div>";
$ThemeSet['MovedPinTopic'] = "<div style=\"text-align: center; font-size: 11px;\" title=\"Pinned Topic!\"> {~P} </div>";
$ThemeSet['MovedHotPinTopic'] = "<div style=\"text-align: center; font-size: 11px; font-weight: bold;\" title=\"Hot Pinned Topic!\"> {~P} </div>";
$ThemeSet['MovedClosedTopic'] = "<div style=\"text-align: center; font-size: 11px; text-decoration: line-through;\" title=\"Closed Topic!\"> [~T] </div>";
$ThemeSet['MovedHotClosedTopic'] = "<div style=\"text-align: center; font-size: 11px; text-decoration: line-through; font-weight: bold;\" title=\"Hot Closed Topic!\"> [~T] </div>";
$ThemeSet['MovedPinClosedTopic'] = "<div style=\"text-align: center; font-size: 11px; text-decoration: line-through;\" title=\"Closed Pinned Topic!\"> [~P] </div>";
$ThemeSet['MovedHotPinClosedTopic'] = "<div style=\"text-align: center; font-size: 11px; text-decoration: line-through; font-weight: bold;\" title=\"Hot Closed Pinned Topic!\"> [~P] </div>";
$ThemeSet['MessageRead'] = "<div style=\"text-align: center; font-size: 11px;\" title=\"Message!\"> [M] </div>";
$ThemeSet['MessageUnread'] = "<div style=\"text-align: center; font-size: 11px; font-weight: bold;\" title=\"New Message!\"> (M) </div>";
$ThemeSet['Profile'] = "Profile";
$ThemeSet['WWW'] = "WWW";
$ThemeSet['PM'] = "PM";
$ThemeSet['TopicLayout'] = "Type 1";
$ThemeSet['AddReply'] = "<span style=\"color: white; font-size: 25px;\" title=\"Add Reply\">Add Reply</span>";
$ThemeSet['FastReply'] = "<span style=\"color: white; font-size: 25px;\" title=\"Fast Reply\">Fast Reply</span>";
$ThemeSet['NewTopic'] = "<span style=\"color: white; font-size: 25px;\" title=\"New Topic\">New Topic</span>";
$ThemeSet['QuoteReply'] = "Quote";
$ThemeSet['EditReply'] = "Edit";
$ThemeSet['DeleteReply'] = "Delete";
$ThemeSet['Report'] = "Report";
$ThemeSet['LineDivider'] = "&nbsp;|&nbsp;";
$ThemeSet['ButtonDivider'] = "&nbsp;";
$ThemeSet['LineDividerTopic'] = "&nbsp;|&nbsp;";
$ThemeSet['TitleDivider'] = "-&gt;";
$ThemeSet['ForumStyle'] = 1;
$ThemeSet['ForumIcon'] = "<div style=\"text-align: center; font-size: 11px;\" title=\"Forum\"> (F) </div>";
$ThemeSet['SubForumIcon'] = "<div style=\"text-align: center; font-size: 11px;\" title=\"SubForum\"> {SF} </div>";
$ThemeSet['RedirectIcon'] = "<div style=\"text-align: center; font-size: 11px;\" title=\"Redirect Forum\"> [RF] </div>";
$ThemeSet['TitleIcon'] = null;
$ThemeSet['NavLinkIcon'] = null;
$ThemeSet['NavLinkDivider'] = " -&gt; ";
$ThemeSet['StatsIcon'] = "<div style=\"text-align: center; font-size: 11px;\" title=\"Board Stats\">(S)</div> ";
$ThemeSet['NoAvatar'] = "themes/Gray/noavatar.png";
$ThemeSet['NoAvatarSize'] = "100x100";
?>