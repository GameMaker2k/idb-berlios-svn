<?php
/*
    This program is free software; you can redistribute it and/or modify
    it under the terms of the Revised BSD License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    Revised BSD License for more details.

    Copyright 2004-2007 Cool Dude 2k - http://idb.berlios.de/
    Copyright 2004-2007 Game Maker 2k - http://upload.idb.s1.jcink.com/
*/
$File1Name = dirname($_SERVER['SCRIPT_NAME'])."/";
$File2Name = $_SERVER['SCRIPT_NAME'];
$File3Name=str_replace($File1Name, null, $File2Name);
if ($File3Name=="topics.php"||$File3Name=="/topics.php") {
	require('index.php');
	exit(); }
?>
<table style="width: 100%;" class="Table2">
<tr>
 <td style="width: 20%; text-align: left;">&nbsp;</td>
 <td style="width: 80%; text-align: right;"><a href="#Act/Topic"><?php echo $ThemeSet['NewTopic']; ?></a></td>
</tr>
</table>
<div>&nbsp;</div>
<div class="Table1Border">
<table class="Table1">
<?php
$prequery = query("select * from ".$Settings['sqltable']."forums where ID=%s", array($_GET['id']));
$preresult=mysql_query($prequery);
$prenum=mysql_num_rows($preresult);
$prei=0;
if($prenum==0) { redirect("location",$basedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); }
while ($prei < $prenum) {
$ForumID=mysql_result($preresult,$prei,"ID");
$ForumName=mysql_result($preresult,$prei,"Name");
$ForumType=mysql_result($preresult,$prei,"ForumType");
$RedirectURL=mysql_result($preresult,$prei,"RedirectURL");
$RedirectTimes=mysql_result($preresult,$prei,"Redirects");
$NumberViews=mysql_result($preresult,$prei,"NumViews");
$ForumType = strtolower($ForumType);
if($ForumType!="redirect") {
if($NumberViews==0||$NumberViews==null) { $NewNumberViews = 1; }
if($NumberViews!=0&&$NumberViews!=null) { $NewNumberViews = $NumberViews + 1; }
$viewup = query("update ".$Settings['sqltable']."forums set NumViews='%s' WHERE id=%i", array($NewNumberViews,$_GET['id']));
mysql_query($viewup); }
if($ForumType=="redirect") {
if($RedirectTimes==0||$RedirectTimes==null) { $NewRedirTime = 1; }
if($RedirectTimes!=0&&$RedirectTimes!=null) { $NewRedirTime = $RedirectTimes + 1; }
$redirup = query("update ".$Settings['sqltable']."forums set Redirects='%s' WHERE id=%i", array($NewRedirTime,$_GET['id']));
mysql_query($redirup);
if($RedirectURL!="http://"&&$RedirectURL!="") {
redirect("location",$RedirectURL,0,null,false); }
if($RedirectURL=="http://"||$RedirectURL=="") {
redirect("location",$basedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); } }
if($ForumCheck!="skip") {
if($ForumType=="subforum") {
redirect("location",$basedir.url_maker($exfile['subforum'],$Settings['file_ext'],"act=".$_GET['act']."&id=".$_GET['id'],$Settings['qstr'],$Settings['qsep'],$prexqstr['subforum'],$exqstr['subforum'],FALSE)); } }
/*	Toggle Code	*/
$query2 = query("select * from ".$Settings['sqltable']."topics where ForumID=%s ORDER BY ID", array($_GET['id']));
$result2=mysql_query($query2);
$num2=mysql_num_rows($result2);
$i2=0;
$toggle="";
while ($i2 < $num2) {
$TopicID=mysql_result($result2,$i2,"ID");
$i3=$i2+1;
if ($i3!=$num2) {
$toggle=$toggle."toggletag('Topic".$TopicID."'),"; }
if ($i3==$num2) {
$toggle=$toggle."toggletag('Topic".$TopicID."'),"; }
if ($i3==$num2) {
$toggle=$toggle."toggletag('Forum".$_GET['id']."'),toggletag('ForumEnd');return false;"; }
++$i2; }
if($toggle==null) { $toggle="toggletag('Forum".$_GET['id']."'),toggletag('ForumEnd');return false;"; }
@mysql_free_result($result2);
?>
<tr class="TableRow1">
<td class="TableRow1" colspan="6"><span style="float: left;">
<?php echo $ThemeSet['TitleIcon'] ?><a href="<?php echo url_maker($exfile['forum'],$Settings['file_ext'],"act=view&id=".$ForumID,$Settings['qstr'],$Settings['qsep'],$prexqstr['forum'],$exqstr['forum']); ?>#<?php echo $ForumID; ?>" id="Toggle<?php echo $ForumID; ?>"><?php echo $ForumName; ?></a></span>
<span style="float: right;"><a href="<?php echo $filewpath; ?>#Toggle<?php echo $ForumID; ?>" onclick="<?php echo $toggle; ?>"><?php echo $ThemeSet['Toggle']; ?></a><?php echo $ThemeSet['ToggleExt']; ?></span></td>
</tr>
<?php ++$prei; } @mysql_free_result($preresult); ?>
<tr id="Forum<?php echo $ForumID; ?>" class="TableRow2">
<th class="TableRow2" style="width: 4%;">State</th>
<th class="TableRow2" style="width: 36%;">Topic Name</th>
<th class="TableRow2" style="width: 15%;">Author</th>
<th class="TableRow2" style="width: 15%;">Time</th>
<th class="TableRow2" style="width: 5%;">Replys</th>
<th class="TableRow2" style="width: 25%;">Last Reply</th>
</tr>
<?php
$query = query("select * from ".$Settings['sqltable']."topics where ForumID=%i ORDER BY Pinned DESC, LastUpdate DESC", array($_GET['id']));
$result=mysql_query($query);
$num=mysql_num_rows($result);
$i=0;
while ($i < $num) {
$TopicID=mysql_result($result,$i,"ID");
$UsersID=mysql_result($result,$i,"UserID");
$GuestName=mysql_result($result,$i,"GuestName");
$TheTime=mysql_result($result,$i,"TimeStamp");
$TheTime=GMTimeChange("F j, Y",$TheTime,$_SESSION['UserTimeZone'],0,$_SESSION['UserDST']);
$NumReply=mysql_result($result,$i,"NumReply");
$TopicName=mysql_result($result,$i,"TopicName");
$TopicDescription=mysql_result($result,$i,"Description");
$PinnedTopic=mysql_result($result,$i,"Pinned");
$TopicStat=mysql_result($result,$i,"Closed");
$UsersName = GetUserName($UsersID,$Settings['sqltable']);
if($UsersName=="Guest") { $UsersName=$GuestName;
if($UsersName==null) { $UsersName="Guest"; } }
$glrquery = query("select * from ".$Settings['sqltable']."posts where ForumID=%i and TopicID=%i ORDER BY TimeStamp DESC", array($_GET['id'],$TopicID));
$glrresult=mysql_query($glrquery);
$glrnum=mysql_num_rows($glrresult);
if($glrnum>0){
$ReplyID1=mysql_result($glrresult,0,"ID");
$UsersID1=mysql_result($glrresult,0,"UserID");
$GuestName1=mysql_result($glrresult,0,"GuestName");
$TimeStamp1=mysql_result($glrresult,0,"TimeStamp");
$TimeStamp1=GMTimeChange("F j, Y",$TimeStamp1,$_SESSION['UserTimeZone'],0,$_SESSION['UserDST']);
$UsersName1 = GetUserName($UsersID1,$Settings['sqltable']); }
if($UsersName1=="Guest") { $UsersName1=$GuestName1;
if($UsersName1==null) { $UsersName1="Guest"; } }
if($TimeStamp1!=null) {
$LastReply = "User: <a href=\"".url_maker($exfile['member'],$Settings['file_ext'],"act=view&id=".$UsersID1,$Settings['qstr'],$Settings['qsep'],$prexqstr['member'],$exqstr['member'])."\">".$UsersName1."</a><br />\nTime: ".$TimeStamp1; }
@mysql_free_result($glrresult);
if($TimeStamp1==null) { $LastReply = "&nbsp;<br />&nbsp;"; }
$PreTopic = $ThemeSet['TopicIcon'];
if ($PinnedTopic==1) {
	if($NumReply>=$Settings['hot_topic_num']) {
		$PreTopic=$ThemeSet['HotPinTopic']; }
	if($NumReply<$Settings['hot_topic_num']) {
		$PreTopic=$ThemeSet['PinTopic']; } }
if ($TopicStat==1) {
	if($NumReply>=$Settings['hot_topic_num']) {
		$PreTopic=$ThemeSet['HotClosedTopic']; }
	if($NumReply<$Settings['hot_topic_num']) {
		$PreTopic=$ThemeSet['ClosedTopic']; } }
if ($PinnedTopic==0) {
	if ($TopicStat==0) {
		if($NumReply>=$Settings['hot_topic_num']) {
			$PreTopic=$ThemeSet['HotTopic']; }
		if($NumReply<$Settings['hot_topic_num']) {
			$PreTopic=$ThemeSet['TopicIcon']; } } }
if ($PinnedTopic==1) {
	if ($TopicStat==1) {
		if($NumReply>=$Settings['hot_topic_num']) {
			$PreTopic=$ThemeSet['HotPinClosedTopic']; }
		if($NumReply<$Settings['hot_topic_num']) {
			$PreTopic=$ThemeSet['PinClosedTopic']; } } }
?>
<tr class="TableRow3" id="Topic<?php echo $TopicID; ?>">
<td class="TableRow3"><div class="topicstate">
<?php echo $PreTopic; ?></div></td>
<td class="TableRow3"><div class="topicname">
<a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TopicID,$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>"><?php echo $TopicName; ?></a></div>
<div class="topicdescription"><?php echo $TopicDescription; ?></div></td>
<td class="TableRow3" style="text-align: center;"><a href="<?php echo url_maker($exfile['member'],$Settings['file_ext'],"act=view&id=".$UsersID,$Settings['qstr'],$Settings['qsep'],$prexqstr['member'],$exqstr['member']); ?>"><?php echo $UsersName; ?></a></td>
<td class="TableRow3" style="text-align: center;"><?php echo $TheTime; ?></td>
<td class="TableRow3" style="text-align: center;"><?php echo $NumReply; ?></td>
<td class="TableRow3"><?php echo $LastReply; ?></td>
</tr>
<?php ++$i; } @mysql_free_result($result); ?>
<tr id="ForumEnd" class="TableRow4">
<td class="TableRow4" colspan="6">&nbsp;</td>
</tr>
</table></div>
<div>&nbsp;</div>
<table class="Table2" style="width: 100%;">
<tr>
 <td style="width: 20%; text-align: left;">&nbsp;</td>
 <td style="width: 80%; text-align: right;"><a href="#Act/Topic"><?php echo $ThemeSet['NewTopic']; ?></a></td>
</tr>
</table>
<div>&nbsp;</div>