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
if ($File3Name=="subforums.php"||$File3Name=="/subforums.php") {
	require('index.html');
	exit(); }
$prequery = $safesql->query("select * from ".$Settings['sqltable']."categorys where ShowCategory='Yes' and ID=%i and InSubForum=0 ORDER BY ID", array($_GET['CatID']));
$preresult=mysql_query($prequery);
$prenum=mysql_num_rows($preresult);
$prei=0;
while ($prei < $prenum) {
$CategoryID=mysql_result($preresult,$prei,"ID");
$CategoryName=mysql_result($preresult,$prei,"Name");
$CategoryShow=mysql_result($preresult,$prei,"ShowCategory");
$CategoryDescription=mysql_result($preresult,$prei,"Description");
/*	Toggle Code	*/
$query2 = $safesql->query("select * from ".$Settings['sqltable']."forums where ShowForum='Yes' and CategoryID=%i and InSubForum=%i ORDER BY ID", array($CategoryID,$_GET['id']));
$result2=mysql_query($query2);
$num2=mysql_num_rows($result2);
$i2=0;
$toggle="";
while ($i2 < $num2) {
$ForumID=mysql_result($result2,$i2,"ID");
$i3=$i2+1;
if ($i3!=$num2) {
$toggle=$toggle."toggletag('Forum".$ForumID."'),"; }
if ($i3==$num2) {
$toggle=$toggle."toggletag('Forum".$ForumID."'),"; }
if ($i3==$num2) {
$toggle=$toggle."toggletag('Cat".$CategoryID."'),toggletag('CatEnd".$CategoryID."');return false;"; }
++$i2; } ?>
<table class="Table1" style="width: 100%;">
<tr class="TableRow1">
<td class="TableRow1" colspan="5"><span class="textright"><a href="#Toggle" onclick="<?php echo $toggle; ?>"><?php echo $SkinSet['Toggle']; ?></a><?php echo $SkinSet['ToggleExt']; ?></span>
<?php echo $SkinSet['TitleIcon'] ?><a href="Category.php?act=View&amp;id=<?php echo $CategoryID; ?>"><?php echo $CategoryName; ?></a></td>
</tr>
<?php
$query="SELECT * FROM ".$Settings['sqltable']."forums WHERE (ShowForum='Yes' and CategoryID='$CategoryID' and InSubForum=".$_GET['id'].") ORDER BY ID";
$result=mysql_query($query);
$num=mysql_num_rows($result);
$i=0;
if($num>=1) {
?>
<tr id="Cat<?php echo $CategoryID; ?>" class="TableRow2">
<th class="TableRow2" style="width: 5%;">&nbsp;</th>
<th class="TableRow2" style="width: 59%;">Forum</th>
<th class="TableRow2" style="width: 8%">Topics</th>
<th class="TableRow2" style="width: 8%">Posts</th>
<th class="TableRow2" style="width: 20%">Last Topic</th>
</tr>
<?php }
while ($i < $num) {
$ForumID=mysql_result($result,$i,"ID");
$ForumName=mysql_result($result,$i,"Name");
$ForumShow=mysql_result($result,$i,"ShowForum");
$ForumType=mysql_result($result,$i,"ForumType");
$NumTopics=mysql_result($result,$i,"NumTopics");
$NumPosts=mysql_result($result,$i,"NumPosts");
$ForumDescription=mysql_result($result,$i,"Description");
unset($LastTopic);
$gltquery = $safesql->query("select * from ".$Settings['sqltable']."topics where CategoryID=%i and ForumID=%i ORDER BY LastUpdate", array($CategoryID,$ForumID));
$gltresult=mysql_query($gltquery);
$gltnum=mysql_num_rows($gltresult);
if($gltnum>0){
$TopicID=mysql_result($gltresult,$gltnum-1,"ID");
$TopicName=mysql_result($gltresult,$gltnum-1,"TopicName");
$TopicName1 = substr($TopicName,0,15);
if (strlen($TopicName)>12) { $TopicName1 = $TopicName1."..."; }
$UsersID=mysql_result($gltresult,$gltnum-1,"UserID");
$GuestName=mysql_result($gltresult,$gltnum-1,"GuestName");
$UsersName = GetUserName($UsersID,$Settings['sqltable']);
$UsersName1 = substr($UsersName,0,18);
if($UsersName=="Guest") { $UsersName=$GuestName;
if($UsersName==null) { $UsersName="Guest"; } }
if (strlen($UsersName)>15) { $UsersName1 = $UsersName1."...";
$oldtopicname=$TopicName; $oldusername=$UsersName;
$TopicName=$TopicName1; $UsersName=$UsersName1; }
$LastTopic = "Made By: <a href=\"#".$UsersID."\" title=\"".$oldusername."\">".$UsersName."</a><br />\nTopic Name: <a href=\"#\" title=\"".$oldtopicname."\">".$TopicName."</a>"; }
?>
<tr class="TableRow3" id="Forum<?php echo $ForumID; ?>">
<td class="TableRow3"><div class="forumicon">
<?php echo $SkinSet['ForumIcon']; ?></div></td>
<td class="TableRow3"><div class="forumname"><a href="Forum.php?act=View&amp;id=<?php echo $ForumID; ?>&amp;CatID=<?php echo $CategoryID; ?>"><?php echo $ForumName; ?></a></div>
<div class="forumdescription"><?php echo $ForumDescription; ?></div></td>
<td class="TableRow3" style="text-align: center;"><?php echo $NumTopics; ?></td>
<td class="TableRow3" style="text-align: center;"><?php echo $NumPosts; ?></td>
<td class="TableRow3"><?php echo $LastTopic; ?></td>
</tr>
<?php
++$i; }
if($num>=1) {
?>
<tr id="CatEnd<?php echo $CategoryID; ?>" class="TableRow4">
<td class="TableRow4" colspan="5">&nbsp;</td>
</tr>
<?php } ?>
</table>
<div>&nbsp;</div>
<?php
++$prei; }
?>
<table style="width: 100%;" class="Table2">
<tr>
 <td style="width: 20%; text-align: left;" nowrap="nowrap">&nbsp;</td>
 <td style="width: 80%; text-align: right;"><a href="#Act/Topic"><?php echo $SkinSet['NewTopic']; ?></a></td>
</tr>
</table>
<div>&nbsp;</div>
<table class="Table1" style="width: 100%;">
<?php
$prequery = $safesql->query("select * from ".$Settings['sqltable']."forums where CategoryID=%i and ID=%i", array($_GET['CatID'],$_GET['id']));
$preresult=mysql_query($prequery);
$prenum=mysql_num_rows($preresult);
$prei=0;
while ($prei < $prenum) {
$ForumID=mysql_result($preresult,$prei,"ID");
$ForumName=mysql_result($preresult,$prei,"Name");
/*	Toggle Code	*/
$query2 = $safesql->query("select * from ".$Settings['sqltable']."topics where ForumID=%i and CategoryID=%i ORDER BY ID", array($_GET['id'],$_GET['CatID']));
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
?>
<tr class="TableRow1">
<td class="TableRow1" colspan="6"><span class="textright"><a href="#Toggle" onclick="<?php echo $toggle; ?>"><?php echo $SkinSet['Toggle']; ?></a><?php echo $SkinSet['ToggleExt']; ?></span>
&nbsp;<a href="Forum.php?act=View&amp;id=<?php echo $ForumID; ?>&amp;CatID=<?php echo $_GET['CatID']; ?>#<?php echo $ForumID; ?>"><?php echo $ForumName; ?></a></td>
</tr>
<?php ++$prei; } ?>
<tr id="Forum<?php echo $ForumID; ?>" class="TableRow2">
<th class="TableRow2" style="width: 5%">State</th>
<th class="TableRow2" style="width: 33%">Topic Name</th>
<th class="TableRow2" style="width: 15%">Author</th>
<th class="TableRow2" style="width: 19%">Time</th>
<th class="TableRow2" style="width: 5%">Replys</th>
<th class="TableRow2" style="width: 23%">Last Reply</th>
</tr>
<?php
$query = $safesql->query("select * from ".$Settings['sqltable']."topics where ForumID=%i and CategoryID=%i ORDER BY Pinned DESC, LastUpdate DESC", array($_GET['id'],$_GET['CatID']));
$result=mysql_query($query);
$num=mysql_num_rows($result);
$i=0;
while ($i < $num) {
$TopicID=mysql_result($result,$i,"ID");
$UsersID=mysql_result($result,$i,"UserID");
$GuestName=mysql_result($result,$i,"GuestName");
$TheTime=mysql_result($result,$i,"TimeStamp");
$TheTime=GMTimeChange("F j, Y, g:i a",$TheTime,$YourOffSet);
$NumReply=mysql_result($result,$i,"NumReply");
$TopicName=mysql_result($result,$i,"TopicName");
$TopicDescription=mysql_result($result,$i,"Description");
$PinnedTopic=mysql_result($result,$i,"Pinned");
$TopicStat=mysql_result($result,$i,"Closed");
$UsersName = GetUserName($UsersID,$Settings['sqltable']);
if($UsersName=="Guest") { $UsersName=$GuestName; }
$glrquery="SELECT * FROM ".$Settings['sqltable']."Posts WHERE (CategoryID=".$_GET['CatID']." and ForumID=".$_GET['id']." and TopicID=".$TopicID.") ORDER BY TimeStamp";
$glrresult=mysql_query($glrquery);
$glrnum=mysql_num_rows($glrresult);
if($glrnum>0){
$ReplyID1=mysql_result($glrresult,$glrnum-1,"ID");
$UsersID1=mysql_result($glrresult,$glrnum-1,"UserID");
$GuestName1=mysql_result($glrresult,$glrnum-1,"GuestName");
$TimeStamp1=mysql_result($glrresult,$glrnum-1,"TimeStamp");
$TimeStamp1=GMTimeChange("M j, Y, g:i a",$TimeStamp1,$YourOffSet);
$UsersName1 = GetUserName($UsersID1,$Settings['sqltable']); }
if($UsersName1=="Guest") { $UsersName1=$GuestName1; }
if($TimeStamp1!=null) {
$LastReply = "By: <a href=\"#".$UsersID1."\">".$UsersName1."</a><br />\nTime: ".$TimeStamp1; }
if($TimeStamp1==null) { $LastReply = "<br />\n<br />"; }
if ($PinnedTopic==1) {
	$PreTopic=$SkinSet['PinTopic']; }
if ($TopicStat==1) {
	$PreTopic=$SkinSet['ClosedTopic']; }
if ($PinnedTopic==0) {
	if ($TopicStat==0) {
		$PreTopic=$SkinSet['TopicIcon']; } }
if ($PinnedTopic==1) {
	if ($TopicStat==1) {
		$PreTopic=$SkinSet['PinClosedTopic']; } }
?>
<tr class="TableRow3" id="Topic<?php echo $TopicID; ?>">
<td class="TableRow3"><div class="topicstate">
<?php echo $PreTopic; ?></div></td>
<td class="TableRow3"><div class="topicname">
<a href="Topic.php?act=View&amp;id=<?php echo $TopicID ?>&amp;ForumID=<?php echo $_GET['id']; ?>&amp;CatID=<?php echo $_GET['CatID']; ?>"><?php echo $TopicName; ?></a></div>
<div class="topicdescription"><?php echo $TopicDescription; ?></div></td>
<td class="TableRow3" style="text-align: center;"><a href="#<?php echo $UsersID; ?>"><?php echo $UsersName; ?></a></td>
<td class="TableRow3" style="text-align: center;"><?php echo $TheTime; ?></td>
<td class="TableRow3" style="text-align: center;"><?php echo $NumReply; ?></td>
<td class="TableRow3"><?php echo $LastReply; ?></td>
</tr>
<?php ++$i; } ?>
<tr id="ForumEnd" class="TableRow4">
<td class="TableRow4" colspan="6">&nbsp;</td>
</tr>
</table>
<div>&nbsp;</div>
<table class="Table2" style="width: 100%;">
<tr>
 <td style="width: 20%; text-align: left;" nowrap="nowrap">&nbsp;</td>
 <td style="width: 80%; text-align: right;"><a href="#Act/Topic"><?php echo $SkinSet['NewTopic']; ?></a></td>
</tr>
</table>
<div>&nbsp;</div>