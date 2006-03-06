<?php
/*
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/
$File1Name = dirname($_SERVER['PHP_SELF'])."/";
$File2Name = $_SERVER['PHP_SELF'];
$File3Name=str_replace($File1Name, null, $File2Name);
if ($File3Name=="RSS1.php"||$File3Name=="/RSS1.php") {
	require('index.html');
	exit(); }
require( 'MySQL.php');
$BoardURL = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
$BoardURL = preg_replace("/misc/isxS", "", $BoardURL);
if ($_GET['Validate']=="RSS"||$_GET['validate']=="RSS") {
	$NEW["REQUEST_URI"] = preg_replace("/\?Validate\=RSS/isxS", "?Renee=Awesome", $_SERVER["REQUEST_URI"]);
	$NEW["REQUEST_URI"] = preg_replace("/\&Validate\=RSS/isxS", "", $NEW["REQUEST_URI"]);
	header('Location: http://validator.w3.org/feed/check.cgi?url='.urlencode('http://'.$_SERVER["HTTP_HOST"].$NEW["REQUEST_URI"])); }
header("Content-type: application/xml");
if ($act=="Download") {
header('Content-Disposition: attachment; filename="'.$Settings['board_name'].'.xml"'); }
if ($_GET['id']==null) {
	$_GET['id']=0; }
$safesql =& new SafeSQL_MySQL;
if ($_GET['CatID']==null) {
$query = $safesql->query("select * from ".$Settings['sqltable']."forums where ShowForum='Yes' and InSubForum=%i ORDER BY ID", array($_GET['id'])); }
if ($_GET['CatID']!=null) {
$query = $safesql->query("select * from ".$Settings['sqltable']."forums where ShowForum='Yes' and InSubForum=%i and CategoryID=%i ORDER BY ID", array($_GET['id'],$_GET['CatID'])); }
unset($safesql);
$result=mysql_query($query);
$num=mysql_num_rows($result);
$i=0;
while ($i < $num) {
$ForumID=mysql_result($result,$i,"ID");
$CategoryID=mysql_result($result,$i,"CategoryID");
$ForumName=mysql_result($result,$i,"Name");
$ForumShow=mysql_result($result,$i,"ShowForum");
$ForumType=mysql_result($result,$i,"ForumType");
$ForumDescription=mysql_result($result,$i,"Description");
$One = $One.'<rdf:li rdf:resource="'.$BoardURL.$ForumType.'.php?id='.$ForumID.'&amp;CatID='.$CategoryID.'"/>'."\n\r";
$Two = $Two.'<item>'."\n\r".'<title>'.htmlentities($ForumName).'</title>'."\n\r".'<description>'.htmlentities($ForumDescription).'</description>'."\n\r".'<link>'.$BoardURL.$ForumType.'.php?id='.$ForumID.'&amp;CatID='.$CategoryID.'</link>'."\n\r".'</item>'."\n\r";
++$i; } ?>
<?php xml_doc_start("1.0","iso-8859-15"); ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
  <channel>
   <title><?php echo htmlentities($Settings['board_name']); ?></title>
   <description>RSS Feed of the Forums on Board <?php echo htmlentities($Settings['board_name']); ?></description>
   <link><?php echo $BoardURL; ?></link>
   <language>en-us</language>
   <generator>Edit Plus v2.12</generator>
   <copyright>Game Maker 2k� 2004</copyright>
   <ttl>120</ttl>
   <image>
	<url><?php echo $BoardURL; ?>Pics/xml.gif</url>
	<title><?php echo htmlentities($Settings['board_name']); ?></title>
	<link><?php echo $BoardURL; ?></link>
   </image>
 <?php echo "\n\r".$Two."\n\r"; ?></channel>
</rss>
<?php mysql_close(); ?>