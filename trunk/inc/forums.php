<?php
/*
    This program is free software; you can redistribute it and/or modify
    it under the terms of the Revised BSD License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    Revised BSD License for more details.

    Copyright 2004-2007 Cool Dude 2k - http://intdb.sourceforge.net/
    Copyright 2004-2007 Game Maker 2k - http://upload.idb.s1.jcink.com/

    $FileInfo: forums.php - Last Update: 08/01/2007 SVN 60 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name=="forums.php"||$File3Name=="/forums.php") {
	require('index.php');
	exit(); }
$prequery = query("select * from `".$Settings['sqltable']."categories` where `ShowCategory`='yes' and `InSubCategory`=0", array());
$preresult=mysql_query($prequery);
$prenum=mysql_num_rows($preresult);
$prei=0;
while ($prei < $prenum) {
$CategoryID=mysql_result($preresult,$prei,"id");
$CategoryName=mysql_result($preresult,$prei,"Name");
$CategoryShow=mysql_result($preresult,$prei,"ShowCategory");
$CategoryType=mysql_result($preresult,$prei,"CategoryType");
$SubShowForums=mysql_result($preresult,$prei,"SubShowForums");
$CategoryDescription=mysql_result($preresult,$prei,"Description");
$CategoryType = strtolower($CategoryType); $SubShowForums = strtolower($SubShowForums);
if(isset($CatPermissionInfo['CanViewCategory'][$CategoryID])&&
	$CatPermissionInfo['CanViewCategory'][$CategoryID]=="yes") {
$query = query("select * from `".$Settings['sqltable']."forums` where `ShowForum`='yes' and `CategoryID`=%i and `InSubForum`=0 ORDER BY `id`", array($CategoryID));
$result=mysql_query($query);
$num=mysql_num_rows($result);
$i=0;
if($num>=1) {
?>
<div class="Table1Border">
<table class="Table1" id="Cat<?php echo $CategoryID; ?>">
<tr class="TableRow1" id="CatStart<?php echo $CategoryID; ?>">
<td class="TableRow1" colspan="5"><span style="float: left;">
<?php echo $ThemeSet['TitleIcon'] ?><a href="<?php echo url_maker($exfile[$CategoryType],$Settings['file_ext'],"act=view&id=".$CategoryID,$Settings['qstr'],$Settings['qsep'],$prexqstr[$CategoryType],$exqstr[$CategoryType]); ?>"><?php echo $CategoryName; ?></a></span>
<?php echo "<span style=\"float: right;\">&nbsp;</span>"; ?></td>
</tr>
<tr id="ForumStatRow<?php echo $CategoryID; ?>" class="TableRow2">
<th class="TableRow2" style="width: 4%;">&nbsp;</th>
<th class="TableRow2" style="width: 58%;">Forum</th>
<th class="TableRow2" style="width: 7%;">Topics</th>
<th class="TableRow2" style="width: 7%;">Posts</th>
<th class="TableRow2" style="width: 24%;">Last Topic</th>
</tr>
<?php }
while ($i < $num) {
$ForumID=mysql_result($result,$i,"id");
$ForumName=mysql_result($result,$i,"Name");
$ForumShow=mysql_result($result,$i,"ShowForum");
$ForumType=mysql_result($result,$i,"ForumType");
$NumTopics=mysql_result($result,$i,"NumTopics");
$NumPosts=mysql_result($result,$i,"NumPosts");
$ForumDescription=mysql_result($result,$i,"Description");
$ForumType = strtolower($ForumType);
$gltf = array(null); $gltf[0] = $ForumID;
if ($ForumType=="subforum") { 
$apcquery = query("select * from `".$Settings['sqltable']."forums` where `ShowForum`='yes' and `InSubForum`=%i ORDER BY `id`", array($ForumID));
$apcresult=mysql_query($apcquery);
$apcnum=mysql_num_rows($apcresult);
$apci=0; if($apcnum>=1) {
while ($apci < $apcnum) {
$apcl = $apci + 1;
$NumsTopics=mysql_result($apcresult,$apci,"NumTopics");
$NumTopics = $NumsTopics + $NumTopics;
$NumsPosts=mysql_result($apcresult,$apci,"NumPosts");
$NumPosts = $NumsPosts + $NumPosts;
$SubsForumID=mysql_result($apcresult,$apci,"id");
$gltf[$apcl] = $SubsForumID;
++$apci; }
@mysql_free_result($apcresult); } }
if(isset($PermissionInfo['CanViewForum'][$ForumID])&&
	$PermissionInfo['CanViewForum'][$ForumID]=="yes") {
unset($LastTopic); if(!isset($LastTopic)) { $LastTopic = null; }
$gltnum = count($gltf); $glti = 0; 
$OldUpdateTime = 0; $UseThisFonum = null;
if ($ForumType=="subforum") { 
while ($glti < $gltnum) {
$gltfoquery = query("select * from `".$Settings['sqltable']."topics` where `CategoryID`=%i and `ForumID`=%i ORDER BY `LastUpdate` DESC", array($CategoryID,$gltf[$glti]));
$gltforesult=mysql_query($gltfoquery);
$gltfonum=mysql_num_rows($gltforesult);
if($gltfonum>0) {
$NewUpdateTime=mysql_result($gltforesult,0,"LastUpdate");
if($NewUpdateTime>$OldUpdateTime) { 
	$UseThisFonum = $gltf[$glti]; 
$OldUpdateTime = $NewUpdateTime; } }
@mysql_free_result($gltforesult);
++$glti; } }
if ($ForumType!="subforum") { $UseThisFonum = $gltf['0']; }
$gltquery = query("select * from `".$Settings['sqltable']."topics` where `CategoryID`=%i and `ForumID`=%i ORDER BY `LastUpdate` DESC", array($CategoryID,$UseThisFonum));
$gltresult=mysql_query($gltquery);
$gltnum=mysql_num_rows($gltresult);
if($gltnum>0){
$TopicID=mysql_result($gltresult,0,"id");
$TopicName=mysql_result($gltresult,0,"TopicName");
$NumReplys=mysql_result($gltresult,0,"NumReply");
$ShowReply = $NumReplys + 1;
$TopicName1 = substr($TopicName,0,12);
if (strlen($TopicName)>12) { $TopicName1 = $TopicName1."..."; }
$UsersID=mysql_result($gltresult,0,"UserID");
$GuestName=mysql_result($gltresult,0,"GuestName");
$UsersName = GetUserName($UsersID,$Settings['sqltable']);
$UsersName1 = substr($UsersName,0,18);
if($UsersName=="Guest") { $UsersName=$GuestName;
if($UsersName==null) { $UsersName="Guest"; } }
if (strlen($UsersName)>15) { $UsersName1 = $UsersName1."...";
$oldtopicname=$TopicName; $oldusername=$UsersName;
$TopicName=$TopicName1; $UsersName=$UsersName1; } $lul = null;
if($UsersID!="-1") {
$lul = url_maker($exfile['member'],$Settings['file_ext'],"act=view&id=".$UsersID,$Settings['qstr'],$Settings['qsep'],$prexqstr['member'],$exqstr['member']);
$LastTopic = "User: <a href=\"".$lul."\" title=\"".$oldusername."\">".$UsersName."</a><br />\nTopic: <a href=\"".url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TopicID,$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic'])."#post".$ShowReply."\" title=\"".$oldtopicname."\">".$TopicName."</a>"; }
if($UsersID=="-1") {
$LastTopic = "User: <span title=\"".$oldusername."\">".$UsersName."</span><br />\nTopic: <a href=\"".url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TopicID,$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic'])."#post".$ShowReply."\" title=\"".$oldtopicname."\">".$TopicName."</a>"; } }
if($LastTopic==null) { $LastTopic="&nbsp;<br />&nbsp;"; }
$PreForum = $ThemeSet['ForumIcon'];
if ($ForumType=="forum") { $PreForum=$ThemeSet['ForumIcon']; }
if ($ForumType=="subforum") { $PreForum=$ThemeSet['SubForumIcon']; }
if ($ForumType=="redirect") { $PreForum=$ThemeSet['RedirectIcon']; }
?>
<tr class="TableRow3" id="Forum<?php echo $ForumID; ?>">
<td class="TableRow3"><div class="forumicon">
<?php echo $PreForum; ?></div></td>
<td class="TableRow3"><div class="forumname"><a href="<?php echo url_maker($exfile[$ForumType],$Settings['file_ext'],"act=view&id=".$ForumID,$Settings['qstr'],$Settings['qsep'],$prexqstr[$ForumType],$exqstr[$ForumType]); ?>"><?php echo $ForumName; ?></a></div>
<div class="forumdescription"><?php echo $ForumDescription; ?></div></td>
<td class="TableRow3" style="text-align: center;"><?php echo $NumTopics; ?></td>
<td class="TableRow3" style="text-align: center;"><?php echo $NumPosts; ?></td>
<td class="TableRow3"><?php echo $LastTopic; ?></td>
</tr>
<?php } ++$i; } @mysql_free_result($result);
if($num>=1) {
?>
<tr id="CatEnd<?php echo $CategoryID; ?>" class="TableRow4">
<td class="TableRow4" colspan="5">&nbsp;</td>
</tr>
</table></div>
<div>&nbsp;</div>
<?php } } ++$prei; }
@mysql_free_result($preresult); ?>
