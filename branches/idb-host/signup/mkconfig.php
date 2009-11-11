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
    iDB Installer made by Game Maker 2k - http://idb.berlios.net/

    $FileInfo: mkconfig.php - Last Update: 11/10/2009 SVN 335 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name=="mkconfig.php"||$File3Name=="/mkconfig.php") {
	require('index.php');
	exit(); }
require_once('settings.php');
if($Settings['fixbasedir']==null) { $Settings['fixbasedir'] = "off"; }
if($Settings['fixbasedir']!=null&&$Settings['fixbasedir']!="off") {
		$this_dir = $Settings['fixbasedir']; }
if($Settings['fixcookiedir']==null) { $Settings['fixcookiedir'] = "off"; }
if($Settings['fixcookiedir']!=null&&$Settings['fixcookiedir']!="off") {
		$cookie_dir = $Settings['fixcookiedir']; }
if($Settings['fixcookiedir']!="on"||$Settings['fixcookiedir']=="off") {
		$cookie_dir = $this_dir; }
if(!isset($Settings['sqldb'])) { echo "Sorry you can not signup yet."; $Error="Yes"; die(); }
if(!isset($SetupDir['setup'])) { $SetupDir['setup'] = "signup/"; }
if(!isset($SetupDir['convert'])) { $SetupDir['convert'] = null; }
$_POST['DatabaseHost'] = $Settings['sqlhost'];
$_POST['DatabaseUserName'] = $Settings['sqluser'];
$_POST['DatabasePassword'] = $Settings['sqlpass'];
//if($_POST['unlink']=="true") { $_POST['unlink'] = true; }
?>
<tr class="TableRow3" style="text-align: center;">
<td class="TableColumn3" colspan="2">
<?php
$dayconv = array('second' => 1, 'minute' => 60, 'hour' => 3600, 'day' => 86400, 'week' => 604800, 'month' => 2630880, 'year' => 31570560, 'decade' => 15705600);
$_POST['unixname'] = strtolower($_POST['unixname']);
if($_POST['unixname']==null) { $_POST['unixname'] = null; }
$_POST['tableprefix'] = $_POST['unixname']."_";
$_POST['unixname'] = preg_replace("/[^A-Za-z0-9_$]/", "", $_POST['unixname']);
$_POST['tableprefix'] = preg_replace("/[^A-Za-z0-9_$]/", "", $_POST['tableprefix']);
if($_POST['tableprefix']==null||$_POST['tableprefix']=="_") { $_POST['tableprefix']="idb_"; }
if($_POST['sessprefix']==null||$_POST['sessprefix']=="_") { $_POST['sessprefix']="idb_"; }
$checkfile="settings.php";
if (!is_writable($checkfile)) {
   echo "<br />Settings is not writable.";
   @chmod("settings.php",0755); $Error="Yes";
   @chmod("settingsbak.php",0755);
} else { /* settings.php is writable install iDB. ^_^ */ }
@session_name($_POST['tableprefix']."sess");
$HTTPsTest = parse_url($Settings['idburl']);
@session_set_cookie_params(0, $cookie_dir, $URLsTest['host']);
@session_cache_limiter("private, must-revalidate");
@header("Cache-Control: private, must-revalidate"); // IE 6 Fix
@header("Pragma: private, must-revalidate");
@header("Date: ".gmdate("D, d M Y H:i:s")." GMT");
@header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
@header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
@session_start();
if (pre_strlen($_POST['AdminPasswords'])<"3") { $Error="Yes";
echo "<br />Your password is too small."; }
if (!isset($_POST['unixname'])) { $Error="Yes";
echo "<br />You need a URL SubFix Name."; }
if (pre_strlen($_POST['AdminUser'])<"3") { $Error="Yes";
echo "<br />Your user name is too small."; }
if (pre_strlen($_POST['AdminPasswords'])>"60") { $Error="Yes";
echo "<br />Your password is too big."; }
if (pre_strlen($_POST['AdminUser'])>"30") { $Error="Yes";
echo "<br />Your user name is too big."; }
if(file_exists($_POST['tableprefix']."_settings.php")) { $Error="Yes";
echo "<br />Sorry board exists pick a new board url prefix."; }
if ($_POST['AdminPasswords']!=$_POST['ReaPassword']) { $Error="Yes";
echo "<br />Your passwords did not match."; }
if($_POST['HTMLType']=="xhtml11") { $_POST['HTMLLevel']="Strict"; }
$_POST['BoardURL'] = addslashes($_POST['BoardURL']);
$YourDate = GMTimeStamp();
$YourEditDate = $YourDate + $dayconv['minute'];
$GSalt = salt_hmac(); $YourSalt = salt_hmac();
/* Fix The User Info for iDB */
$_POST['NewBoardName'] = stripcslashes(htmlspecialchars($_POST['NewBoardName'], ENT_QUOTES, $Settings['charset']));
//$_POST['NewBoardName'] = preg_replace("/&amp;#(x[a-f0-9]+|[0-9]+);/i", "&#$1;", $_POST['NewBoardName']);
$_POST['NewBoardName'] = @remove_spaces($_POST['NewBoardName']);
//$_POST['AdminPassword'] = stripcslashes(htmlspecialchars($_POST['AdminPassword'], ENT_QUOTES, $Settings['charset']));
//$_POST['AdminPassword'] = preg_replace("/\&amp;#(.*?);/is", "&#$1;", $_POST['AdminPassword']);
$_POST['AdminUser'] = stripcslashes(htmlspecialchars($_POST['AdminUser'], ENT_QUOTES, $Settings['charset']));
//$_POST['AdminUser'] = preg_replace("/&amp;#(x[a-f0-9]+|[0-9]+);/i", "&#$1;", $_POST['AdminUser']);
$_POST['AdminUser'] = @remove_spaces($_POST['AdminUser']);
if(!function_exists('hash')||!function_exists('hash_algos')) {
if($_POST['usehashtype']!="md5"&&
   $_POST['usehashtype']!="sha1"&&
   $_POST['usehashtype']!="sha256") {
	$_POST['usehashtype'] = "sha256"; } }
if(function_exists('hash')&&function_exists('hash_algos')) {
if(!in_array($_POST['usehashtype'],hash_algos())) {
	$_POST['usehashtype'] = "sha256"; }
if($_POST['usehashtype']!="md2"&&
   $_POST['usehashtype']!="md4"&&
   $_POST['usehashtype']!="md5"&&
   $_POST['usehashtype']!="sha1"&&
   $_POST['usehashtype']!="sha256"&&
   $_POST['usehashtype']!="sha386"&&
   $_POST['usehashtype']!="sha512") {
	$_POST['usehashtype'] = "sha256"; } }
if($_POST['usehashtype']=="md2") { $iDBHashType = "iDBH2"; }
if($_POST['usehashtype']=="md4") { $iDBHashType = "iDBH4"; }
if($_POST['usehashtype']=="md5") { $iDBHashType = "iDBH5"; }
if($_POST['usehashtype']=="sha1") { $iDBHashType = "iDBH"; }
if($_POST['usehashtype']=="sha256") { $iDBHashType = "iDBH256"; }
if($_POST['usehashtype']=="sha386") { $iDBHashType = "iDBH386"; }
if($_POST['usehashtype']=="sha512") { $iDBHashType = "iDBH512"; }
if ($_POST['AdminUser']=="Guest") { $Error="Yes";
echo "<br />You can not use Guest as your name."; }
/* We are done now with fixing the info. ^_^ */
$mydbtest = @ConnectMysql($Settings['sqlhost'],$Settings['sqluser'],$Settings['sqlpass'],$Settings['sqldb']);
$SQLCharset = "latin1"; 
if($Settings['charset']=="ISO-8859-1") {
	$SQLCharset = "latin1"; }
if($Settings['charset']=="ISO-8859-15") {
	$SQLCharset = "latin1"; }
if($Settings['charset']=="UTF-8") {
	$SQLCharset = "utf8"; }
@mysql_set_charset($SQLCharset);
if($mydbtest!==true) { $Error="Yes";
echo "<br />".mysql_errno().": ".mysql_error()."\n"; }
if ($Error!="Yes") {
$query=query("CREATE TABLE `".$_POST['tableprefix']."sessions` ( `session_id` varchar(150) NOT NULL default '', `session_data` text NOT NULL, `expires` int(15) NOT NULL default '0', PRIMARY KEY  (`session_id`)) TYPE=`MyISAM` DEFAULT CHARSET=`".$SQLCharset."`;", array(null));
mysql_query($query);
require($SetupDir['setup'].'mktable.php');
/*
$query = query("INSERT INTO `".$_POST['tableprefix']."tagboard` VALUES (1,-1,'".$iDB_Author."',".$YourDate.",'Welcome to Your New Tag Board. ^_^','127.0.0.1'), array(null)); 
*/
$query = query("INSERT INTO `".$_POST['tableprefix']."categories` VALUES (1,1,'A Test Category','yes','category','yes',0,0,0,'The Main Category.')", array(null));
mysql_query($query);
$ServerUUID = uuid(false,true,false,$_POST['usehashtype'],null);
if(!is_numeric($_POST['YourOffSet'])) { $_POST['YourOffSet'] = "0"; }
if($_POST['YourOffSet']>12) { $_POST['YourOffSet'] = "12"; }
if($_POST['YourOffSet']<-12) { $_POST['YourOffSet'] = "-12"; }
if(!is_numeric($_POST['MinOffSet'])) { $_POST['MinOffSet'] = "00"; }
if($_POST['MinOffSet']>59) { $_POST['MinOffSet'] = "59"; }
if($_POST['MinOffSet']<0) { $_POST['MinOffSet'] = "00"; }
$YourOffSet = $_POST['YourOffSet'].":".$_POST['MinOffSet'];
$AdminDST = $_POST['DST'];
$MyDay = GMTimeGet("d",$YourOffSet,0,$AdminDST);
$MyMonth = GMTimeGet("m",$YourOffSet,0,$AdminDST);
$MyYear = GMTimeGet("Y",$YourOffSet,0,$AdminDST);
$MyYear10 = $MyYear+10;
$YourDateEnd = $YourDate + $dayconv['month'];
$EventMonth = GMTimeChange("m",$YourDate,0,0,"off");
$EventMonthEnd = GMTimeChange("m",$YourDateEnd,0,0,"off");
$EventDay = GMTimeChange("d",$YourDate,0,0,"off");
$EventDayEnd = GMTimeChange("d",$YourDateEnd,0,0,"off");
$EventYear = GMTimeChange("Y",$YourDate,0,0,"off");
$EventYearEnd = GMTimeChange("Y",$YourDateEnd,0,0,"off");
$KarmaBoostDay = $EventMonth.$EventDay;
$query = query("INSERT INTO `".$_POST['tableprefix']."events` VALUES (1, -1, '".$iDB_Author."', 'Opening', 'This is the day the Board was made. ^_^', %i, %i, %i, %i, %i, %i, %i, %i)", array($YourDate,$YourDateEnd,$EventMonth,$EventMonthEnd,$EventDay,$EventDayEnd,$EventYear,$EventYearEnd));
mysql_query($query);
$query = query("INSERT INTO `".$_POST['tableprefix']."forums` VALUES (1,1,1,'A Test Forum','yes','forum',0,'http://',0,0,'&nbsp;','off',0,0,'yes',15,1,1)", array(null));
mysql_query($query);
$query = query("INSERT INTO `".$_POST['tableprefix']."topics` VALUES (1,1,1,1,1,-1,'".$iDB_Author."',%i,%i,'Welcome','Install was successful',0,0,1,1)", array($YourDate,$YourDate));
mysql_query($query);
$query = query("INSERT INTO `".$_POST['tableprefix']."posts` VALUES (1,1,1,1,-1,'".$iDB_Author."',%i,%i,1,'".$_POST['AdminUser']."','Welcome to Your Message Board. :) ','Install was successful','127.0.0.1','127.0.0.1')", array($YourDate,$YourEditDate)); 
mysql_query($query);
$NewPassword = b64e_hmac($_POST['AdminPasswords'],$YourDate,$YourSalt,$_POST['usehashtype']);
//$Name = stripcslashes(htmlspecialchars($AdminUser, ENT_QUOTES, $Settings['charset']));
//$YourWebsite = "http://".$_SERVER['HTTP_HOST'].$this_dir."index.php?act=view";
$YourWebsite = $_POST['WebURL'];
$UserIP = $_SERVER['REMOTE_ADDR'];
$PostCount = 2;
$Email = "admin@".$_SERVER['HTTP_HOST'];
$AdminTime = $_POST['YourOffSet'].":".$_POST['MinOffSet'];
$GEmail = "guest@".$_SERVER['HTTP_HOST'];
$grand = rand(6,16); $i = 0; $gpass = "";
while ($i < $grand) {
$csrand = rand(1,3);
if($csrand!=1&&$csrand!=2&&$csrand!=3) { $csrand=1; }
if($csrand==1) { $gpass .= chr(rand(48,57)); }
if($csrand==2) { $gpass .= chr(rand(65,90)); }
if($csrand==3) { $gpass .= chr(rand(97,122)); }
++$i; } $GuestPassword = b64e_hmac($gpass,$YourDate,$GSalt,$_POST['usehashtype']);
$url_this_dir = "http://".$_SERVER['HTTP_HOST'].$this_dir."index.php?act=view";
$YourIP = $_SERVER['REMOTE_ADDR'];
$query = query("INSERT INTO `".$_POST['tableprefix']."members` VALUES (-1,'Guest','%s','".$iDBHashType."','%s',4,'no','yes',0,'Guest Account','Guest',%i,%i,'0','0','0','0','0','[B]Test[/B] :)','Your Notes','http://','100x100','%s','UnKnow',1,0,0,10,10,10,'%s','%s','iDB','127.0.0.1','%s')", array($GuestPassword,$GEmail,$YourDate,$YourDate,$YourWebsite,$AdminTime,$AdminDST,$GSalt));
mysql_query($query);
$query = query("INSERT INTO `".$_POST['tableprefix']."members` VALUES (1,'%s','%s','".$iDBHashType."','%s',1,'yes','no',0,'%s','Admin',%i,%i,'0','0','0','0','0','%s','Your Notes','%s','100x100','%s','UnKnow',0,0,0,10,10,10,'%s','%s','iDB','%s','%s')", array($_POST['AdminUser'],$NewPassword,$Email,$Interests,$YourDate,$YourDate,$NewSignature,$Avatar,$YourWebsite,$AdminTime,$AdminDST,$UserIP,$YourSalt));
mysql_query($query);
$query = query("INSERT INTO `".$_POST['tableprefix']."messenger` VALUES (1,-1,1,'".$iDB_Author."','Test','Hello Welcome to your board.\r\nThis is a Test PM. :P ','Hello Welcome',%i,0)", array($YourDate));
mysql_query($query);
$CHMOD = $_SERVER['PHP_SELF'];
$iDBRDate = $SVNDay[0]."/".$SVNDay[1]."/".$SVNDay[2];
$iDBRSVN = $VER2[2]." ".$SubVerN;
$LastUpdateS = "Last Update: ".$iDBRDate." ".$iDBRSVN;
$pretext = "<?php\n/*\n    This program is free software; you can redistribute it and/or modify\n    it under the terms of the GNU General Public License as published by\n    the Free Software Foundation; either version 2 of the License, or\n    (at your option) any later version.\n\n    This program is distributed in the hope that it will be useful,\n    but WITHOUT ANY WARRANTY; without even the implied warranty of\n    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the\n    Revised BSD License for more details.\n\n    Copyright 2004-".$SVNDay[2]." iDB Support - http://idb.berlios.de/\n    Copyright 2004-".$SVNDay[2]." Game Maker 2k - http://gamemaker2k.org/\n    iDB Installer made by Game Maker 2k - http://idb.berlios.net/\n\n    \$FileInfo: settings.php & settingsbak.php - ".$LastUpdateS." - Author: cooldude2k \$\n*/\n";
$pretext2 = array("/*   Board Setting Section Begins   */\n\$Settings = array();","/*   Board Setting Section Ends  \n     Board Info Section Begins   */\n\$SettInfo = array();","/*   Board Setting Section Ends   \n     Board Dir Section Begins   */\n\$SettDir = array();","/*   Board Dir Section Ends   */");
$settcheck = "\$File3Name = basename(\$_SERVER['SCRIPT_NAME']);\nif (\$File3Name==\"".$_POST['tableprefix']."settings.php\"||\$File3Name==\"/".$_POST['tableprefix']."settings.php\") {\n    @header('Location: index.php');\n    exit(); }\n";
$BoardSettings=$pretext2[0]."\nrequire('settings.php');\n\$Settings['sqltable'] = '".$_POST['tableprefix']."';\n\$Settings['board_name'] = '".$_POST['NewBoardName']."';\n\$Settings['weburl'] = '".$_POST['WebURL']."';\n\$Settings['GuestGroup'] = 'Guest';\n\$Settings['MemberGroup'] = 'Member';\n\$Settings['ValidateGroup'] = 'Validate';\n\$Settings['AdminValidate'] = 'off';\n\$Settings['TestReferer'] = '".$_POST['TestReferer']."';\n\$Settings['DefaultTheme'] = 'iDB';\n\$Settings['DefaultTimeZone'] = '".$AdminTime."';\n\$Settings['DefaultDST'] = '".$AdminDST."';\n\$Settings['use_hashtype'] = '".$_POST['usehashtype']."';\n\$Settings['max_posts'] = '10';\n\$Settings['max_topics'] = '10';\n\$Settings['max_memlist'] = '10';\n\$Settings['max_pmlist'] = '10';\n\$Settings['hot_topic_num'] = '15';\n\$Settings['enable_rss'] = 'on';\n\$Settings['enable_search'] = 'on';\n\$Settings['board_offline'] = 'off';\n\$Settings['BoardUUID'] = '".$ServerUUID."';\n\$Settings['KarmaBoostDays'] = '".$KarmaBoostDay."';\n\$Settings['KBoostPercent'] = '6|10';\n".$pretext2[1]."\n\$SettInfo['board_name'] = '".$_POST['NewBoardName']."';\n\$SettInfo['Author'] = '".$_POST['AdminUser']."';\n\$SettInfo['Keywords'] = '".$_POST['NewBoardName'].",".$_POST['AdminUser']."';\n\$SettInfo['Description'] = '".$_POST['NewBoardName'].",".$_POST['AdminUser']."';\n?>";
$BoardSettingsBak = $pretext.$settcheck.$BoardSettings;
$BoardSettings = $pretext.$settcheck.$BoardSettings;
$fp = fopen($_POST['tableprefix']."settings.php","w+");
fwrite($fp, $BoardSettings);
fclose($fp);
$fp = fopen($_POST['tableprefix']."settingsbak.php","w+");
fwrite($fp, $BoardSettingsBak);
fclose($fp);
if($_POST['storecookie']=="true") {
@setcookie("MemberName", $_POST['AdminUser'], time() + (7 * 86400), $cookie_dir, $URLsTest['host']);
@setcookie("UserID", 1, time() + (7 * 86400), $cookie_dir, $URLsTest['host']);
@setcookie("SessPass", $NewPassword, time() + (7 * 86400), $cookie_dir, $URLsTest['host']); }
@mysql_close(); $chdel = true;
?><span class="TableMessage">
<br />Install Finish <a href="index.php?act=view&amp;board=<?php echo $_POST['unixname']; ?>">Click here</a> to goto board. ^_^</span>
<?php if($chdel===false) { ?><span class="TableMessage">
<br />Error: Cound not delete installer. Read readme.txt for more info.</span>
<?php } ?><br /><br />
</td>
</tr>
<?php } ?>
