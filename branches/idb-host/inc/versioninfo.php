<?php
/*
    This program is free software; you can redistribute it and/or modify
    it under the terms of the Revised BSD License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    Revised BSD License for more details.

    Copyright 2004-2011 iDB Support - http://idb.berlios.de/
    Copyright 2004-2011 Game Maker 2k - http://gamemaker2k.org/

    $FileInfo: versioninfo.php - Last Update: 01/01/2010 SVN 608 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name=="versioninfo.php"||$File3Name=="/versioninfo.php") {
	require('index.php');
	exit(); }
	$rssurlon = "off";
// Version info stuff. :P 
function version_info($proname,$subver,$ver,$supver,$reltype,$svnver,$showsvn) {
	$return_var = $proname." ".$reltype." ".$subver.".".$ver.".".$supver;
	if($showsvn===false) { $showsvn = null; }
	if($showsvn===true) { $return_var .= " SVN ".$svnver; }
	if($showsvn!==true&&$showsvn!==null) { $return_var .= " ".$showsvn." ".$svnver; }
	return $return_var; }
// Version number and date stuff. :P
$VER1[0] = 0; $VER1[1] = 4; $VER1[2] = 2; $VERFull[1] = $VER1[0].".".$VER1[1].".".$VER1[2];
$VER2[0] = "Alpha"; $VER2[1] = "Al"; $VER2[2] = "SVN"; $SubVerN = 608; $RName = "iDB EH"; $SFName = "IntDB Easy Host";
$SVNDay[0] = 01; $SVNDay[1] = 01; $SVNDay[2] = 2010; $SVNDay[3] = $SVNDay[0]."/".$SVNDay[1]."/".$SVNDay[2];
$VerInfo['iDB_Ver'] = version_info($RName,$VER1[0],$VER1[1],$VER1[2],$VER2[1],$SubVerN,false);
$VerInfo['iDB_Ver_SVN'] = version_info($RName,$VER1[0],$VER1[1],$VER1[2],$VER2[1],$SubVerN,true);
$VerInfo['iDB_Full_Ver'] = version_info($RName,$VER1[0],$VER1[1],$VER1[2],$VER2[0],$SubVerN,false);
$VerInfo['iDB_Full_Ver_SVN'] = version_info($RName,$VER1[0],$VER1[1],$VER1[2],$VER2[0],$SubVerN,true);
$VerInfo['iDB_Ver_Show'] = $VerInfo['iDB_Ver_SVN']; $VerInfo['iDB_Full_Ver_Show'] = $VerInfo['iDB_Full_Ver_SVN'];
define("_iDB_Ver_", $VerInfo['iDB_Ver']); define("_iDB_Ver_SVN_", $VerInfo['iDB_Ver_SVN']);
define("_iDB_Full_Ver_", $VerInfo['iDB_Full_Ver']); define("_iDB_Full_Ver_SVN_", $VerInfo['iDB_Full_Ver_SVN']);
define("_iDB_Ver_Show_", $VerInfo['iDB_Ver_Show']); define("_iDB_Full_Ver_Show_", $VerInfo['iDB_Full_Ver_Show']);
// URLs and names and stuff. :P $KSP = "Kazuki Sabonis Przyborowski";
$iDBHome = "http://idb.berlios.de/"; $DF2kHome = "http://df2k.berlios.de/"; $OrgName = "iDB";
if(!isset($Settings['VerCheckURL'])) {
$VerCheckURL = $iDBHome."?act=vercheck"; }
if(isset($Settings['VerCheckURL'])) {
$VerCheckURL = $Settings['VerCheckURL']; }
$VerCheckQuery = parse_url($VerCheckURL);
$VerCheckQuery = $VerCheckQuery['query'];
if($VerCheckQuery=="") { $VerCheckURL = $VerCheckURL."?"; }
if(!isset($Settings['IPCheckURL'])) {
$IPCheckURL = 'http://cqcounter.com/whois/?query=%s'; }
if(isset($Settings['IPCheckURL'])) {
$IPCheckURL = $Settings['IPCheckURL']; }
$CD2k = "Kazuki Przyborowski"; $GM2k = "Game Maker 2k"; $iDB_Author = "Kazuki"; 
$iDB = "iDB Easy Host"; $iTB = "Internet Tag Boards"; $DF2k = "Discussion Forums 2k"; $TB2k = "Tag Boards 2k";
$iDBURL1 = "<a href=\"".$iDBHome."\" onclick=\"window.open(this.href);return false;\">"; $iDBURL2 = $iDBURL1.$iDB."</a>";
$DF2kURL1 = "<a href=\"".$DF2kHome."\" onclick=\"window.open(this.href);return false;\">"; $DF2kURL2 = $DF2kURL1.$DF2k."</a>";
$GM2kURL = "<a href=\"".$iDBHome."support/category.php?act=view&amp;id=2\" title=\"".$GM2k."\" onclick=\"window.open(this.href);return false;\">".$GM2k."</a>";
$iDBURL3 = "<a href=\"".$iDBHome."\" title=\"".$iDB."\" onclick=\"window.open(this.href);return false;\">".$iDB."</a>";
$PHPQA = "PHP-Quick-Arcade|http://quickarcade.jcink.com/"; $TFBB = "TextFileBB|https://launchpad.net/tfbb";
$PHPQA = explode("|",$PHPQA); $TFBB = explode("|",$TFBB);
$PHPQA = "<a href=\"".$PHPQA[1]."\" title=\"".$PHPQA[0]."\" onclick=\"window.open(this.href);return false;\">".$PHPQA[0]."</a>";
$TFBB = "<a href=\"".$TFBB[1]."\" title=\"".$TFBB[0]."\" onclick=\"window.open(this.href);return false;\">".$TFBB[0]."</a>";
$PHPV1 = phpversion(); $PHPV2 = "PHP ".$PHPV1; $OSType = @php_uname("s"); $OSType .= " ".@php_uname("r");
$OSType .= " ".@php_uname("m"); if($OSType==""||!isset($OSType)) { $OSType = PHP_OS; } // Check OS Name
if($OSType=="WINNT") { $OSType="Windows NT"; } if($OSType=="WIN32") { $OSType="Windows 9x"; }
$OSType2 = $PHPV2." / ".$OSType; $ZENDV1 = zend_version(); $ZENDV2 = "Zend engine ".$ZENDV1;
// Show or hide the version number
if($Settings['showverinfo']=="on") {
//header("X-".$RName."-Powered-By: ".$VerInfo['iDB_Ver_Show']);
header("Generator: ".$VerInfo['iDB_Ver_Show']); }
if($Settings['showverinfo']!="on") {
//header("X-".$RName."-Powered-By: ".$RName);
//header("X-Powered-By: PHP");
header("Generator: ".$RName); }
if(!isset($Settings['hideverinfohttp'])) {
	$Settings['hideverinfohttp'] = "off"; }
if($Settings['hideverinfohttp']=="on") {
header("X-Powered-By: ");
header("Generator: "); }
?>
