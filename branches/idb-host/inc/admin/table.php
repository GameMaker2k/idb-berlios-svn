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

    $FileInfo: table.php - Last Update: 6/16/2009 SVN 264 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name=="table.php"||$File3Name=="/table.php") {
	require('index.php');
	exit(); }
?><div class="TableSMenuBorder">
<?php if($ThemeSet['TableStyle']=="div") { ?>
<div class="TableSMenuRow1">
<?php echo $ThemeSet['TitleIcon']; ?>Main Settings</div>
<?php } ?>
<table id="AdminLinks" class="TableSMenu" style="width: 100%; text-align: left; vertical-align: top;">
<?php if($ThemeSet['TableStyle']=="table") { ?>
<tr class="TableSMenuRow1">
<td class="TableSMenuColumn1"><?php echo $ThemeSet['TitleIcon']; ?>Main Settings</td>
</tr><?php } ?>
<tr class="TableSMenuRow2">
<td class="TableSMenuColumn2">&nbsp;</td>
</tr><tr class="TableSMenuRow3">
<td class="TableSMenuColumn3"><a href="<?php echo url_maker($exfile['admin'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['admin'],$exqstr['admin']); ?>">Main Page</a></td>
</tr><tr class="TableSMenuRow3">
<td class="TableSMenuColumn3"><a href="<?php echo url_maker($exfile['admin'],$Settings['file_ext'],"act=settings",$Settings['qstr'],$Settings['qsep'],$prexqstr['admin'],$exqstr['admin']); ?>">Edit Settings</a></td>
<?php if($GroupInfo['ViewDBInfo']=="yes"&&$_GET['board']==$Settings['root_board']) { ?>
</tr><tr class="TableSMenuRow3">
<td class="TableSMenuColumn3"><a href="<?php echo url_maker($exfile['admin'],$Settings['file_ext'],"act=mysql",$Settings['qstr'],$Settings['qsep'],$prexqstr['admin'],$exqstr['admin']); ?>">MySQL Settings</a></td>
<?php } if($GroupInfo['ViewDBInfo']=="yes") { ?>
</tr><tr class="TableSMenuRow3">
<td class="TableSMenuColumn3"><a href="<?php echo url_maker($exfile['admin'],$Settings['file_ext'],"act=sqldumper",$Settings['qstr'],$Settings['qsep'],$prexqstr['admin'],$exqstr['admin']); ?>">SQL Dumper</a></td>
<?php } ?>
</tr><tr class="TableSMenuRow3">
<td class="TableSMenuColumn3"><a href="<?php echo url_maker($exfile['admin'],$Settings['file_ext'],"act=info",$Settings['qstr'],$Settings['qsep'],$prexqstr['admin'],$exqstr['admin']); ?>">Edit Board Info</a></td>
<?php if($GroupInfo['ViewDBInfo']=="yes"&&$_GET['board']!=$Settings['root_board']) { ?>
</tr><tr class="TableSMenuRow3">
<td class="TableSMenuColumn3"><a href="<?php echo url_maker($exfile['admin'],$Settings['file_ext'],"act=delete",$Settings['qstr'],$Settings['qsep'],$prexqstr['admin'],$exqstr['admin']); ?>">Delete Board</a></td>
<?php } ?>
</tr><tr class="TableSMenuRow4">
<td class="TableSMenuColumn4">&nbsp;</td>
</tr></table></div>
<div>&nbsp;</div>
<div class="TableSMenuBorder">
<?php if($ThemeSet['TableStyle']=="div") { ?>
<div class="TableSMenuRow1">
<?php echo $ThemeSet['TitleIcon']; ?>Forum Tool</div>
<?php } ?>
<table id="ForumTool" class="TableSMenu" style="width: 100%; text-align: left; vertical-align: top;">
<?php if($ThemeSet['TableStyle']=="table") { ?>
<tr class="TableSMenuRow1">
<td class="TableSMenuColumn1"><?php echo $ThemeSet['TitleIcon']; ?>Forum Tool</td>
</tr><?php } ?><tr class="TableSMenuRow2">
<td class="TableSMenuColumn2">&nbsp;</td>
</tr><tr class="TableSMenuRow3">
<td class="TableSMenuColumn3"><a href="<?php echo url_maker($exfile['admin'],$Settings['file_ext'],"act=addforum",$Settings['qstr'],$Settings['qsep'],$prexqstr['admin'],$exqstr['admin']); ?>">Add Forums</a></td>
</tr><tr class="TableSMenuRow3">
<td class="TableSMenuColumn3"><a href="<?php echo url_maker($exfile['admin'],$Settings['file_ext'],"act=editforum",$Settings['qstr'],$Settings['qsep'],$prexqstr['admin'],$exqstr['admin']); ?>">Edit Forums</a></td>
</tr><tr class="TableSMenuRow3">
<td class="TableSMenuColumn3"><a href="<?php echo url_maker($exfile['admin'],$Settings['file_ext'],"act=deleteforum",$Settings['qstr'],$Settings['qsep'],$prexqstr['admin'],$exqstr['admin']); ?>">Delete Forums</a></td>
</tr><tr class="TableSMenuRow3">
<td class="TableSMenuColumn3"><a href="<?php echo url_maker($exfile['admin'],$Settings['file_ext'],"act=fpermissions",$Settings['qstr'],$Settings['qsep'],$prexqstr['admin'],$exqstr['admin']); ?>">Forum Permissions</a></td>
</tr><tr class="TableSMenuRow4">
<td class="TableSMenuColumn4">&nbsp;</td>
</tr></table></div>