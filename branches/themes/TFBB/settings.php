<?php
/*
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    Revised BSD License for more details.

    Copyright 2004-2008 Jcink - https://launchpad.net/tfbb
    Copyright 2004-2008 Jcink - http://jcink.com/
    $ThemeInfo - Name: TFBB Theme - Author: jcink $
    $FileInfo: settings.php - Last Update: 09/08/2010 SVN 531 - Author: jcink $
*/
$ThemeSet = array();
$ThemeSet['ThemeName'] = "TFBB Theme";
$ThemeSet['ThemeMaker'] = "Jcink";
$ThemeSet['ThemeVersion'] = "0.4.0";
$ThemeSet['ThemeVersionType'] = "Alpha";
$ThemeSet['ThemeSubVersion'] = "SVN 531";
$ThemeSet['MakerURL'] = "http://Jcink.com/";
$ThemeSet['CopyRight'] = $ThemeSet['ThemeName']." was made by <a href=\"".$ThemeSet['MakerURL']."\" title=\"".$ThemeSet['ThemeMaker']."\">".$ThemeSet['ThemeMaker']."</a>";
$ThemeSet['CSS'] = "themes/TFBB/css.css";
$ThemeSet['CSSType'] = "include";
$ThemeSet['FavIcon'] = "themes/TFBB/favicon.ico";
$ThemeSet['TableStyle'] = "div";
$ThemeSet['MiniPageAltStyle'] = "off";
$ThemeSet['PreLogo'] = null;
$ThemeSet['Logo'] = $Settings['board_name'];
$ThemeSet['LogoStyle'] = "font-size: 40px; font-family: verdana, arial, sans-serif; color: white;";
$ThemeSet['SubLogo'] = null;
$ThemeSet['TopicIcon'] = "<div style=\"text-align: center;\"><img src=\"themes/TFBB/topic.png\" alt=\"Topic\" title=\"Topic\" /></div>";
$ThemeSet['HotTopic'] = "<div style=\"text-align: center;\"><img src=\"themes/TFBB/topic.png\" alt=\"Topic\" title=\"Topic\" /></div>";
$ThemeSet['PinTopic'] = "<div style=\"text-align: center;\"><img src=\"themes/TFBB/pin.png\" alt=\"Pinned!\" title=\"Pinned Topic!\" /></div>";
$ThemeSet['HotPinTopic'] = "<div style=\"text-align: center;\"><img src=\"themes/TFBB/pin.png\" alt=\"Pinned!\" title=\"Pinned Topic!\" /></div>";
$ThemeSet['ClosedTopic'] = "<div style=\"text-align: center;\"><img src=\"themes/TFBB/lock.png\" alt=\"Closed!\" title=\"Closed Topic!\" /></div>";
$ThemeSet['HotClosedTopic'] = "<div style=\"text-align: center;\"><img src=\"themes/TFBB/lock.png\" alt=\"Closed!\" title=\"Closed Topic!\" /></div>";
$ThemeSet['PinClosedTopic'] = "<div style=\"text-align: center;\"><img src=\"themes/TFBB/pinlock.png\" alt=\"Closed!\" title=\"Closed!\" /></div>";
$ThemeSet['HotPinClosedTopic'] = "<div style=\"text-align: center;\"><img src=\"themes/TFBB/pinlock.png\" alt=\"Closed!\" title=\"Closed!\" /></div>";
$ThemeSet['MovedTopicIcon'] = "<div style=\"text-align: center;\"><img src=\"themes/TFBB/moved.png\" alt=\"Moved Topic\" title=\"Moved Topic\" /></div>";
$ThemeSet['MovedHotTopic'] = "<div style=\"text-align: center;\"><img src=\"themes/TFBB/moved.png\" alt=\"Moved Topic\" title=\"Moved Topic\" /></div>";
$ThemeSet['MovedPinTopic'] = "<div style=\"text-align: center;\"><img src=\"themes/TFBB/moved.png\" alt=\"Moved Pinned!\" title=\"Moved Pinned Topic!\" /></div>";
$ThemeSet['MovedHotPinTopic'] = "<div style=\"text-align: center;\"><img src=\"themes/TFBB/moved.png\" alt=\"Moved Pinned!\" title=\"Moved Pinned Topic!\" /></div>";
$ThemeSet['MovedClosedTopic'] = "<div style=\"text-align: center;\"><img src=\"themes/TFBB/moved.png\" alt=\"Moved Closed!\" title=\"Moved Closed Topic!\" /></div>";
$ThemeSet['MovedHotClosedTopic'] = "<div style=\"text-align: center;\"><img src=\"themes/TFBB/moved.png\" alt=\"Moved Closed!\" title=\"Moved Closed Topic!\" /></div>";
$ThemeSet['MovedPinClosedTopic'] = "<div style=\"text-align: center;\"><img src=\"themes/TFBB/moved.png\" alt=\"Moved Closed!\" title=\"Moved Closed!\" /></div>";
$ThemeSet['MovedHotPinClosedTopic'] = "<div style=\"text-align: center;\"><img src=\"themes/TFBB/moved.png\" alt=\"Moved Closed!\" title=\"Moved Closed!\" /></div>";
$ThemeSet['MessageRead'] = "<div style=\"text-align: center;\"><img src=\"themes/TFBB/topic.png\" alt=\"Message\" title=\"Message!\" /></div>";
$ThemeSet['MessageUnread'] = "<div style=\"text-align: center;\"><img src=\"themes/TFBB/pin.png\" alt=\"New Message\" title=\"New Message!\" /></div>";
$ThemeSet['Profile'] = "Profile";
$ThemeSet['WWW'] = "WWW";
$ThemeSet['PM'] = "PM";
$ThemeSet['TopicLayout'] = "Type 1";
$ThemeSet['AddReply'] = "<span style=\"color: white; font-size: 25px;\" title=\"Add Reply\">Add Reply</span>";
$ThemeSet['FastReply'] = "<span style=\"color: white; font-size: 25px;\" title=\"Fast Reply\">Fast Reply</span>";
$ThemeSet['NewTopic'] = "<span style=\"color: white; font-size: 25px;\" title=\"New Topic\">New Topic</span>";
$ThemeSet['QuoteReply'] = "( Quote )";
$ThemeSet['Report'] = "( Report )";
$ThemeSet['EditReply'] = "( Edit )";
$ThemeSet['DeleteReply'] = "( Delete )";
$ThemeSet['LineDivider'] = "&nbsp;|&nbsp;";
$ThemeSet['ButtonDivider'] = "&nbsp;|&nbsp;";
$ThemeSet['LineDividerTopic'] = "&nbsp;|&nbsp;";
$ThemeSet['TitleDivider'] = "-&gt;";
$ThemeSet['ForumStyle'] = 1;
$ThemeSet['ForumIcon'] = "<div style=\"text-align: center;\"><img src=\"themes/TFBB/forum.gif\" alt=\"Forum\" title=\"Forum\" /></div>";
$ThemeSet['SubForumIcon'] = "<div style=\"text-align: center;\"><img src=\"themes/TFBB/forum.gif\" alt=\"SubForum\" title=\"SubForum\" /></div>";
$ThemeSet['RedirectIcon'] = "<div style=\"text-align: center;\"><img src=\"themes/TFBB/forum.gif\" alt=\"Redirect\" title=\"Redirect\" /></div>";
$ThemeSet['TitleIcon'] = "<img src=\"themes/TFBB/nav.gif\" alt=\"-&gt;\" title=\"-&gt;\" /> ";
$ThemeSet['NavLinkIcon'] = "&gt;&gt; ";
$ThemeSet['NavLinkDivider'] = " -&gt; ";
$ThemeSet['StatsIcon'] = "<img src=\"themes/TFBB/stats.gif\" alt=\"Board Stats\" title=\"Board Stats\" />";
$ThemeSet['NoAvatar'] = "themes/TFBB/noavatar.png";
$ThemeSet['NoAvatarSize'] = "100x100";
?>