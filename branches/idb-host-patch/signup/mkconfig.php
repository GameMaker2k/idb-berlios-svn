<?php
/*
    This program is free software; you can redistribute it and/or modify
    it under the terms of the Revised BSD License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    Revised BSD License for more details.

    Copyright 2004-2008 Cool Dude 2k - http://idb.berlios.de/
    Copyright 2004-2008 Game Maker 2k - http://intdb.sourceforge.net/
    iDB Installer made by Game Maker 2k - http://idb.berlios.net/

    $FileInfo: mkconfig.php - Last Update: 01/01/2008 SVN 144 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name=="mkconfig.php"||$File3Name=="/mkconfig.php") {
	require('index.php');
	exit(); }
require_once('settings.php');
if($Settings['fixbasedir']==null) { $Settings['fixbasedir'] = false; }
if($Settings['fixbasedir']!=null&&$Settings['fixbasedir']!=false) {
		$this_dir = $Settings['fixbasedir']; }
if($Settings['fixcookiedir']==null) { $Settings['fixcookiedir'] = false; }
if($Settings['fixcookiedir']!=null&&$Settings['fixcookiedir']!=false) {
		$cookie_dir = $Settings['fixcookiedir']; }
if($Settings['fixcookiedir']!=true||$Settings['fixcookiedir']==false) {
		$cookie_dir = $this_dir; }
if(!isset($Settings['sqldb'])) { echo "Sorry you can not signup yet."; $Error="Yes"; die(); }
if(!isset($SetupDir['setup'])) { $SetupDir['setup'] = "signup/"; }
if(!isset($SetupDir['convert'])) { $SetupDir['convert'] = null; }
$_POST['DatabaseHost'] = $Settings['sqlhost'];
$_POST['DatabaseUserName'] = $Settings['sqluser'];
$_POST['DatabasePassword'] = $Settings['sqlpass'];
?>
<tr class="TableRow3" style="text-align: center;">
<td class="TableRow3" colspan="2">
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
@session_set_cookie_params(0, "/".$_POST['unixname']."/");
@session_cache_limiter("private, must-revalidate");
@header("Cache-Control: private, must-revalidate"); // IE 6 Fix
@header("Pragma: private, must-revalidate");
@header("Date: ".gmdate("D, d M Y H:i:s")." GMT");
@header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
@header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
@session_start();
if (strlen($_POST['AdminPasswords'])<="3") { $Error="Yes";
echo "<br />Your password is too small."; }
if (!isset($_POST['unixname'])) { $Error="Yes";
echo "<br />You need a URL SubFix Name."; }
if (strlen($_POST['AdminUser'])<="3") { $Error="Yes";
echo "<br />Your user name is too small."; }
if (strlen($_POST['AdminPasswords'])>="30") { $Error="Yes";
echo "<br />Your password is too big."; }
if (strlen($_POST['AdminUser'])>="20") { $Error="Yes";
echo "<br />Your user name is too big."; }
if(file_exists($_POST['tableprefix']."_settings.php")) { $Error="Yes";
echo "<br />Sorry board exists pick a new board url prefix."; }
if ($_POST['AdminPasswords']!=$_POST['ReaPassword']) { $Error="Yes";
echo "<br />Your passwords did not match."; }
if($_POST['HTMLType']=="xhtml11") { $_POST['HTMLLevel']="Strict"; }
if($_POST['WebURL']=="http://localhost/"||$_POST['WebURL']=="http://localhost") {
	$_POST['WebURL'] = "localhost"; }
if($_POST['WebURL']=="https://localhost/"||$_POST['WebURL']=="https://localhost") {
	$_POST['WebURL'] = "localhost"; }
$_POST['BoardURL'] = addslashes($_POST['BoardURL']);
$YourDate = GMTimeStamp();
$YourEditDate = $YourDate + $dayconv['minute'];
$GSalt = salt_hmac(); $YourSalt = salt_hmac();
/* Fix The User Info for iDB */
$_POST['NewBoardName'] = htmlspecialchars($_POST['NewBoardName'], ENT_QUOTES, $Settings['charset']);
$_POST['NewBoardName'] = fixbamps($_POST['NewBoardName']);
$_POST['NewBoardName'] = @remove_spaces($_POST['NewBoardName']);
$_POST['NewBoardName'] = str_replace("\'", "'", $_POST['NewBoardName']);
//$_POST['AdminPassword'] = stripcslashes(htmlspecialchars($_POST['AdminPassword'], ENT_QUOTES, $Settings['charset']));
//$_POST['AdminPassword'] = preg_replace("/\&amp;#(.*?);/is", "&#$1;", $_POST['AdminPassword']);
$_POST['AdminUser'] = stripcslashes(htmlspecialchars($_POST['AdminUser'], ENT_QUOTES, $Settings['charset']));
//$_POST['AdminUser'] = preg_replace("/&amp;#(x[a-f0-9]+|[0-9]+);/i", "&#$1;", $_POST['AdminUser']);
$_POST['AdminUser'] = @remove_spaces($_POST['AdminUser']);
if ($_POST['AdminUser']=="Guest") { $Error="Yes";
echo "<br />You can not use Guest as your name."; }
/* We are done now with fixing the info. ^_^ */
$mydbtest = @ConnectMysql($Settings['sqlhost'],$Settings['sqluser'],$Settings['sqlpass'],$Settings['sqldb']);
if($mydbtest!=true) { $Error="Yes";
echo "<br />".mysql_errno().": ".mysql_error()."\n"; }
if ($Error!="Yes") {
require($SetupDir['setup'].'mktable.php');
/*
$query = query("INSERT INTO `".$_POST['tableprefix']."tagboard` VALUES (1,-1,'Cool Dude 2k',".$YourDate.",'Welcome to Your New Tag Board. ^_^','127.0.0.1'), array(null)); 
*/
$query = query("INSERT INTO `".$_POST['tableprefix']."categories` VALUES (1,1,'Main','yes','category','yes',0,'The Main Category.')", array(null));
mysql_query($query);
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
$query = query("INSERT INTO `".$_POST['tableprefix']."events` VALUES (1, -1, 'Cool Dude 2k', 'Opening', 'This is the day the Board was made. ^_^', %i, %i, %i, %i, %i, %i, %i, %i)", array($YourDate,$YourDateEnd,$EventMonth,$EventMonthEnd,$EventDay,$EventDayEnd,$EventYear,$EventYearEnd));
mysql_query($query);
$query = query("INSERT INTO `".$_POST['tableprefix']."forums` VALUES (1,1,1,'Test/Spam','yes','forum',0,'http://',0,0,'A Test Board.','off','yes',1,1)", array(null));
mysql_query($query);
$query = query("INSERT INTO `".$_POST['tableprefix']."topics` VALUES (1,1,1,-1,'Cool Dude 2k',%i,%i,'Welcome','Install was successful',0,0,1,1)", array($YourDate,$YourDate));
mysql_query($query);
$query = query("INSERT INTO `".$_POST['tableprefix']."posts` VALUES (1,1,1,1,-1,'Cool Dude 2k',%i,%i,1,'Welcome to Your Message Board. :) ','Install was successful','127.0.0.1','127.0.0.1')", array($YourDate,$YourEditDate)); 
mysql_query($query);
$NewPassword = b64e_hmac($_POST['AdminPasswords'],$YourDate,$YourSalt,"sha1");
//$Name = stripcslashes(htmlspecialchars($AdminUser, ENT_QUOTES, $Settings['charset']));
//$YourWebsite = "http://".$_SERVER['HTTP_HOST']."/".$_POST['unixname']."/"."index.php?act=view";
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
++$i; } $GuestPassword = b64e_hmac($gpass,$YourDate,$GSalt,"sha1");
$url_this_dir = "http://".$_SERVER['HTTP_HOST']."/".$_POST['unixname']."/"."index.php?act=view";
$YourIP = $_SERVER['REMOTE_ADDR'];
$query = query("INSERT INTO `".$_POST['tableprefix']."members` VALUES (-1,'Guest','%s','iDBH','%s',4,'no',0,'Guest Account','Guest',%i,%i,'0','0','0','0','[B]Test[/B] :)','Your Notes','http://','100x100','%s','UnKnow',1,'%s','%s','iDB','127.0.0.1','%s')", array($GuestPassword,$GEmail,$YourDate,$YourDate,$YourWebsite,$AdminTime,$AdminDST,$GSalt));
mysql_query($query);
$query = query("INSERT INTO `".$_POST['tableprefix']."members` VALUES (1,'%s','%s','iDBH','%s',1,'yes',0,'%s','Admin',%i,%i,'0','0','0','0','%s','Your Notes','%s','100x100','%s','UnKnow',0,'%s','%s','iDB','%s','%s')", array($_POST['AdminUser'],$NewPassword,$Email,$Interests,$YourDate,$YourDate,$NewSignature,$Avatar,$YourWebsite,$AdminTime,$AdminDST,$UserIP,$YourSalt));
mysql_query($query);
$query = query("INSERT INTO `".$_POST['tableprefix']."messenger` VALUES (1,-1,1,'Cool Dude 2k','Test','Hello Welcome to your board.\r\nThis is a Test PM. :P ','Hello Welcome',%i,0)", array($YourDate));
mysql_query($query);
$CHMOD = $_SERVER['PHP_SELF'];
$pretext = "<?php\n/*\n    This program is free software; you can redistribute it and/or modify\n    it under the terms of the GNU General Public License as published by\n    the Free Software Foundation; either version 2 of the License, or\n    (at your option) any later version.\n\n    This program is distributed in the hope that it will be useful,\n    but WITHOUT ANY WARRANTY; without even the implied warranty of\n    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the\n    Revised BSD License for more details.\n\n    Copyright 2004-2008 Cool Dude 2k - http://idb.berlios.de/\n    Copyright 2004-2008 Game Maker 2k - http://intdb.sourceforge.net/\n    iDB Installer made by Game Maker 2k - http://idb.berlios.net/\n\n    \$FileInfo: settings.php & settingsbak.php - Last Update: ".$SVNDay[0]."/".$SVNDay[1]."/".$SVNDay[2]." SVN ".$SubVerN." - Author: cooldude2k \$\n*/\n";
$pretext2 = array("/*   Board Setting Section Begins   */\n\$Settings = array();","/*   Board Setting Section Ends  \n     Board Info Section Begins   */\n\$SettInfo = array();","/*   Board Setting Section Ends   \n     Board Dir Section Begins   */\n\$SettDir = array();","/*   Board Dir Section Ends   */");
$settcheck = "\$File3Name = basename(\$_SERVER['SCRIPT_NAME']);\nif (\$File3Name==\"".$_POST['tableprefix']."settings.php\"||\$File3Name==\"/".$_POST['tableprefix']."settings.php\") {\n    @header('Location: index.php');\n    exit(); }\n";
$BoardSettings=$pretext2[0]."\nrequire('settings.php');\n\$Settings['sqltable'] = '".$_POST['tableprefix']."';\n\$Settings['board_name'] = '".$_POST['NewBoardName']."';\n\$Settings['weburl'] = '".$_POST['WebURL']."';\n\$Settings['GuestGroup'] = 'Guest';\n\$Settings['MemberGroup'] = 'Member';\n\$Settings['ValidateGroup'] = 'Validate';\n\$Settings['AdminValidate'] = false;\n\$Settings['TestReferer'] = ".$_POST['TestReferer'].";\n\$Settings['DefaultTheme'] = 'iDB';\n\$Settings['DefaultTimeZone'] = '".$AdminTime."';\n\$Settings['DefaultDST'] = '".$AdminDST."';\n\$Settings['charset'] = 'iso-8859-15';\n\$Settings['add_power_by'] = false;\n\$Settings['send_pagesize'] = false;\n\$Settings['max_posts'] = '10';\n\$Settings['max_topics'] = '10';\n\$Settings['max_memlist'] = '10';\n\$Settings['max_pmlist'] = '10';\n\$Settings['hot_topic_num'] = '15';\n\$Settings['enable_rss'] = true;\n\$Settings['enable_search'] = true;\n\$Settings['board_offline'] = false;\n".$pretext2[1]."\n\$SettInfo['board_name'] = '".$_POST['NewBoardName']."';\n\$SettInfo['Author'] = '".$_POST['AdminUser']."';\n\$SettInfo['Keywords'] = '".$_POST['NewBoardName'].",".$_POST['AdminUser']."';\n\$SettInfo['Description'] = '".$_POST['NewBoardName'].",".$_POST['AdminUser']."';\n?>";
$BoardSettingsBak = $pretext.$settcheck.$BoardSettings;
$BoardSettings = $pretext.$settcheck.$BoardSettings;
$fp = fopen($_POST['tableprefix']."settings.php","w+");
fwrite($fp, $BoardSettings);
fclose($fp);
$fp = fopen($_POST['tableprefix']."settingsbak.php","w+");
fwrite($fp, $BoardSettingsBak);
fclose($fp);
$_SESSION['Theme']="iDB";
$_SESSION['MemberName']=$_POST['AdminUser'];
$_SESSION['UserID']=1;
$_SESSION['UserTimeZone']=$AdminTime;
$_SESSION['UserGroup']="Admin";
$_SESSION['UserDST'] = $AdminDST;
$_SESSION['UserPass']=$NewPassword;
$_SESSION['DBName'] = $Settings['sqldb'];
if($_POST['storecookie']==true) {
@setcookie("MemberName", $_POST['AdminUser'], time() + (7 * 86400), "/".$_POST['unixname']."/");
@setcookie("UserID", 1, time() + (7 * 86400), "/".$_POST['unixname']."/");
@setcookie("SessPass", $NewPassword, time() + (7 * 86400), "/".$_POST['unixname']."/"); }
@mysql_close(); $chdel = true;
?><span class="TableMessage">
<br />Install Finish <a href="/<?php echo $_POST['unixname']; ?>/index.php?act=view">Click here</a> to goto board. ^_^</span>
<?php if($chdel==false) { ?><span class="TableMessage">
<br />Error: Cound not delete installer. Read readme.txt for more info.</span>
<?php } ?><br /><br />
</td>
</tr>
<?php } ?>