<?php
/*
    This program is free software; you can redistribute it and/or modify
    it under the terms of the Revised BSD License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    Revised BSD License for more details.

    Copyright 2009-2010 iDB Support - http://idb.berlios.de/
    Copyright 2009-2010 Game Maker 2k - http://gamemaker2k.org/

    $FileInfo: index.php - Last Update: 4/27/2009 Ver 2.5 - Author: cooldude2k $
*/
/* Change to your url. */
@ob_start(); 
require_once('inc/killglobals.php');
$site_url = "http://localhost/vercheck/";
if(!isset($_GET['redirect'])) { $_GET['redirect'] = "off"; }
    /**
     * Returns true if $string is valid UTF-8 and false otherwise.
     *
     * @since        1.14
     * @param [mixed] $string     string to be tested
     * @subpackage
     */
    function is_utf8($string) {
      
        // From http://w3.org/International/questions/qa-forms-utf-8.html
        return preg_match('%^(?:
              [\x09\x0A\x0D\x20-\x7E]            # ASCII
            | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
            |  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
            | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
            |  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
            |  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
            | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
            |  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
        )*$%xs', $string);
      
    } 
if(!isset($_SERVER['HTTP_USER_AGENT'])) {
	$_SERVER['HTTP_USER_AGENT'] = null; }
if (stristr($_SERVER["HTTP_USER_AGENT"],"W3C_Validator")) {
	$_SERVER["HTTP_ACCEPT"] = "application/xml"; }
if(!isset($_SERVER['HTTP_ACCEPT'])) {
	$_SERVER['HTTP_ACCEPT'] = null; }
if(!isset($_SERVER['PATH_INFO'])) {
	$_SERVER['PATH_INFO'] = null; }
if(!isset($_GET['vercheck'])) { $_GET['vercheck'] = null; }
if($_GET['redirect']=="js") {
header("Content-Type: application/javascript; charset=UTF-8"); }
if($_GET['redirect']=="xml") {
if (stristr($_SERVER["HTTP_USER_AGENT"],"W3C_Validator")) {
	$_SERVER["HTTP_ACCEPT"] = "application/xml"; }
if(stristr($_SERVER["HTTP_ACCEPT"],"application/xml") ) {
header("Content-Type: application/xml; charset=UTF-8"); }
else { header("Content-Type: text/xml; charset=UTF-8"); } }
if(!isset($_GET['act'])) { $_GET['act'] = "vercheck"; }
if(isset($_GET['act'])&&$_GET['act']!="update") {
if(!isset($_GET['name'])&&!isset($_GET['bid'])) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title> iDB Version checker </title>
<meta http-equiv="content-language" content="en-US">
<meta http-equiv="content-type" content="text/html; charset=iso-8859-15">
<meta name="Generator" content="EditPlus">
<meta name="Author" content="Cool Dude 2k">
<meta name="Keywords" content="iDB Version checker">
<meta name="Description" content="iDB Version checker">
<meta name="ROBOTS" content="Index, FOLLOW">
<meta name="revisit-after" content="1 days">
<meta name="GOOGLEBOT" content="Index, FOLLOW">
<meta name="resource-type" content="document">
<meta name="distribution" content="global">
<link rel="icon" href="favicon.ico" type="image/icon">
<link rel="shortcut icon" href="favicon.ico" type="image/icon">
<!-- Katarzyna O_o -->
</head>

<body>
<!-- Renee Sabonis ^_^ -->
<form method="get" action="?act=vercheck&amp;vercheck=newtype&amp;encoded=false">
<div>
<input type="hidden" id="act" name="act" value="vercheck" />
<label for="bid">Insert board url:</label><br />
<input type="text" id="bid" name="bid" /><br />
<input type="hidden" id="vercheck" name="vercheck" value="newtype" />
<input type="hidden" id="encoded" name="encoded" value="false" />
<input type="submit" />
</div>
</form>

<!-- Stephanie Braun o_O -->
</body>
</html>
<?php exit(); } }
if(isset($_GET['bid'])) {
	if(!isset($_GET['encoded'])) { 
		$_GET['encoded'] = "true"; }
	if($_GET['encoded']=="true") { 
	$_GET['bid'] = @base64_decode($_GET['bid']); }
	$_GET['bid'] = @urldecode($_GET['bid']);
	$_GET['bid'] = @strip_tags($_GET['bid']);
	$ChkURL = parse_url($_GET['bid']);
	$HostIP = gethostbyname($ChkURL['host']);
	if($HostIP=="127.0.0.1") {
	$_GET['bid'] = null; }
	if($HostIP!="127.0.0.1") {
	if($_GET['vercheck']=="newtype") {
	$GetTitle = @file_get_contents($_GET['bid']."?act=versioninfo"); }
	if($_GET['vercheck']!="newtype") {
	$GetTitle = @file_get_contents($_GET['bid']); }
	$_GET['bid'] = htmlspecialchars($_GET['bid']);
	preg_match_all("/<title>(.*?)<\/title>/i", $GetTitle, $GetFullTitle);
	$GetConType = $GetTitle;
	$GetTitle = htmlspecialchars(strip_tags(trim($GetFullTitle[1][0]))); 
	if($_GET['vercheck']=="newtype") {
	$prequote1 = preg_quote("<charset>", '/');
	$prequote2 = preg_quote("</charset>", '/'); }
	if($_GET['vercheck']!="newtype") {
	$prequote1 = preg_quote("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=", '/');
	$prequote2 = preg_quote("\" />", '/'); }
	preg_match_all("/".$prequote1."(.*?)".$prequote2."/i", $GetConType, $GetCType);
	$prequote1 = preg_quote("<name>", '/');
	$prequote2 = preg_quote("</name>", '/');
	preg_match_all("/".$prequote1."(.*?)".$prequote2."/i", $GetConType, $GetVerNum);
	if(!isset($GetVerNum[1][0])) { 
	$prequote1 = preg_quote("<!-- generator=\"", '/');
	$prequote2 = preg_quote("\" -->", '/');
	preg_match_all("/".$prequote1."(.*?)".$prequote2."/i", $GetConType, $GetVerNum); }
	if(!isset($GetVerNum[1][0])) { 
	$prequote1 = preg_quote("<meta name=\"Generator\" content=\"", '/');
	$prequote2 = preg_quote("\" />", '/');
	preg_match_all("/".$prequote1."(.*?)".$prequote2."/i", $GetConType, $GetVerNum); }
	if(!isset($GetVerNum[1][0])) { 
	$prequote1 = preg_quote("<a href=\"http://idb.berlios.de/\" title=\"", '/');
	$prequote2 = preg_quote("\" onclick=\"window.open(this.href);return false;\">", '/');
	preg_match_all("/".$prequote1."(.*?)".$prequote2."/i", $GetConType, $GetVerNum); }
	if(!isset($GetVerNum[1][0])) { $GetVerNum[1][0] = null; }
	$GetVerNum = $GetVerNum[1][0];
	$GetVerNum = preg_replace("/iDB EH Mod/i", "iDBEH-Mod", $GetVerNum);
	$GetVerNum = preg_replace("/iDB EH/i", "iDB-Host", $GetVerNum);
	$GetVerNum = preg_replace("/\s/i", "|", $GetVerNum);
	if(!isset($_GET['name'])) { $_GET['name'] = $GetVerNum; }
	if(!isset($GetCType[1][0])) {
	if(is_utf8($GetTitle)==true) { $GetCType[1][0] = "UTF-8"; }
	if(is_utf8($GetTitle)==false) { $GetCType[1][0] = "UTF-8"; 
	$GetTitle = utf8_encode($GetTitle); } }
	$preq1 = preg_quote("&amp;#", '/');
	$GetTitle = preg_replace("/".$preq1."(.*?);/isU","&#\\1;",$GetTitle);
	$preq2 = preg_quote("&amp;#x", '/');
	$GetTitle = preg_replace("/".$preq2."(.*?);/isU","&#x\\1;",$GetTitle);
	if(!isset($GetCType[1][0])) { $GetCType[1][0] = null; }
	$BoardLang = $GetCType[1][0];
	if(isset($BoardLang)) {
	if($BoardLang!="ISO-8859-15"&&$BoardLang!="ISO-8859-1"&&
	$BoardLang!="UTF-8"&&$BoardLang!="CP866"&&
	$BoardLang!="Windows-1251"&&$BoardLang!="Windows-1252"&&
	$BoardLang!="KOI8-R"&&$BoardLang!="BIG5"&&
	$BoardLang!="GB2312"&&$BoardLang!="BIG5-HKSCS"&&
	$BoardLang!="Shift_JIS"&&$BoardLang!="EUC-JP") {
	$BoardLang = "ISO-8859-15"; } }
	$GetFullTitle = $GetTitle; } }
if(!isset($_GET['bid'])) { $_GET['bid'] = null; }
// Make the Query String if we are not useing &=
function qstring($qstr=";",$qsep="=")
{ $_GET = null; $_GET = array();
if (!isset($_SERVER['QUERY_STRING'])) {
$_SERVER['QUERY_STRING'] = getenv('QUERY_STRING'); }
@ini_get("arg_separator.input", $qstr);
$_SERVER['QUERY_STRING'] = urldecode($_SERVER['QUERY_STRING']);
$preqs = explode($qstr,$_SERVER["QUERY_STRING"]);
$qsnum = count($preqs); $qsi = 0;
while ($qsi < $qsnum) {
$preqst = explode($qsep,$preqs[$qsi],2);
$fix1 = array(" ",'$'); $fix2  = array("_","_");
$preqst[0] = str_replace($fix1, $fix2, $preqst[0]);
$preqst[0] = killbadvars($preqst[0]);
if($preqst[0]!=null) {
$_GET[$preqst[0]] = $preqst[1]; }
++$qsi; } return true; }
if($_SERVER['PATH_INFO']==null) {
	if(@getenv('PATH_INFO')!=null&&@getenv('PATH_INFO')!="1") {
$_SERVER['PATH_INFO'] = @getenv('PATH_INFO'); }
if(@getenv('PATH_INFO')==null) {
$myscript = $_SERVER["SCRIPT_NAME"];
$myphpath = $_SERVER["PHP_SELF"];
$mypathinfo = str_replace($myscript, "", $myphpath);
@putenv("PATH_INFO=".$mypathinfo); } }
// Change Path info to Get Vars :
function mrstring() {
$urlvar = explode('/',$_SERVER['PATH_INFO']);
$num=count($urlvar); $i=1;
while ($i < $num) {
//$urlvar[$i] = urldecode($urlvar[$i]);
if(!isset($_GET[$urlvar[$i]])) { $_GET[$urlvar[$i]] = null; }
if(!isset($urlvar[$i])) { $urlvar[$i] = null; }
if($_GET[$urlvar[$i]]==null&&$urlvar[$i]!=null) {
$fix1 = array(" ",'$'); $fix2  = array("_","_");
$urlvar[$i] = str_replace($fix1, $fix2, $urlvar[$i]);
$urlvar[$i] = killbadvars($urlvar[$i]);
	$_GET[$urlvar[$i]] = $urlvar[$i+1]; }
++$i; ++$i; } return true; }
// Redirect to another file with ether timed or nontimed redirect
function redirect($type,$file,$time=0,$url=null,$dbsr=true) {
if($type!="location"&&$type!="refresh") { $type=="location"; }
if($url!=null) { $file = $url.$file; }
if($dbsr===true) { $file = str_replace("//", "/", $file); }
if($type=="refresh") { header("Refresh: ".$time."; URL=".$file); }
if($type=="location") { @session_write_close(); 
header("Location: ".$file); } return true; }
function redirects($type,$url,$time=0) {
if($type!="location"&&$type!="refresh") { $type=="location"; }
if($type=="refresh") { header("Refresh: ".$time."; URL=".$url); }
if($type=="location") { header("Location: ".$url); } return true; }
// Make xhtml tags
function html_tag_make($name="br",$emptytag=true,$attbvar=null,$attbval=null,$extratest=null) {
	$var_num = count($attbvar); $value_num = count($attbval);
	if($var_num!=$value_num) { 
		echo "Erorr Number of Var and Values dont match!";
	return false; } $i = 0;
	while ($i < $var_num) {
	if($i==0) { $mytag = "<".$name." ".$attbvar[$i]."=\"".$attbval[$i]."\""; }
	if($i>=1) { $mytag = $mytag." ".$attbvar[$i]."=\"".$attbval[$i]."\""; }
	if($i==$var_num-1) { 
	if($emptytag===false) { $mytag = $mytag.">"; }
	if($emptytag===true) { $mytag = $mytag." />"; } }	++$i; }
	if($attbvar==null&&$attbval==null) { $mytag = "<".$name;
	if($emptytag===true) { $mytag = $mytag." />"; }
	if($emptytag===false) { $mytag = $mytag.">"; } }
	if($emptytag===false&&$extratest!=null) { 
	$mytag = $mytag.$extratest; $mytag = $mytag."</".$name.">"; } 
	return $mytag; }
// Start a xml document
function xml_tag_make($type,$attbs,$retval=false) {
	$renee1 = explode("&",$attbs);
	$reneenum=count($renee1);
	$reneei=0; $attblist = null;
	while ($reneei < $reneenum) {
	$renee2 = explode("=",$renee1[$reneei]);
	if($renee2[0]!=null||$renee2[1]!=null) {
	$attblist = $attblist.' '.$renee2[0].'="'.$renee2[1].'"'; }
	++$reneei; }
	if($retval!==false&&$retval!==true) { $retval=false; }
	if($retval===false) {
	echo '<?'.$type.$attblist.'?>'."\n"; }
	if($retval===true) {
	return '<?'.$type.$attblist.'?>'."\n"; } }
// Start a xml document (old version)
function xml_doc_start($ver,$encode,$retval=false) {
	if($retval===false) {
	echo xml_tag_make('xml','version='.$ver.'&encoding='.$encode,true); }
	if($retval===true) {
	return xml_tag_make('xml','version='.$ver.'&encoding='.$encode,true); } }
if($_GET['redirect']!="on"&&$_GET['redirect']!="xml"&&$_GET['redirect']!="js") {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<?php if(isset($GetFullTitle)) { ?>
<title> iDB Version checker - Checking <?php echo $GetFullTitle; ?> </title>
<?php } if(!isset($GetFullTitle)) { ?>
<title> iDB Version checker </title>
<?php } ?>
<meta http-equiv="content-language" content="en-US">
<?php if(isset($BoardLang)) { ?>
<meta http-equiv="content-type" content="text/html; charset=<?php echo $BoardLang; ?>">
<?php } if(!isset($BoardLang)) { ?>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-15">
<?php } ?>
<meta name="Generator" content="EditPlus">
<meta name="Author" content="Cool Dude 2k">
<meta name="Keywords" content="iDB Version checker">
<meta name="Description" content="iDB Version checker">
<meta name="ROBOTS" content="Index, FOLLOW">
<meta name="revisit-after" content="1 days">
<meta name="GOOGLEBOT" content="Index, FOLLOW">
<meta name="resource-type" content="document">
<meta name="distribution" content="global">
<link rel="icon" href="favicon.ico" type="image/icon">
<link rel="shortcut icon" href="favicon.ico" type="image/icon">
<!-- Katarzyna O_o -->
</head>

<body>
<!-- Renee Sabonis ^_^ -->
<?php }
if(!isset($_GET['act'])) { $_GET['act'] = null; }
if(!isset($_GET['redirect'])) { $_GET['redirect'] = null; }
if(isset($_GET['act'])&&$_GET['act']=="update") {
$GetNewVersion = file_get_contents("http://developer.berlios.de/project/showfiles.php?group_id=6135");
$prepreg1 = preg_quote("<TD colspan=\"3\"><h3>iDB</h3></TD>","/"); 
$prepreg2 = preg_quote("</A></B></TD>","/");
preg_match_all("/".$prepreg1."(.*)".$prepreg2."{1}/isU", $GetNewVersion, $NewVersionPart);
$prepreg1 = preg_quote("SVN ","/"); 
$prepreg2 = preg_quote("</A>","/");
preg_match_all("/".$prepreg1."(.*)".$prepreg2."{1}/isU", $NewVersionPart[0][0], $NewVersionPart);
$NewSVNPart = $NewVersionPart[1][0];
$GetSVNVersion = file_get_contents("http://intdb.svn.sourceforge.net/viewvc/intdb/trunk/inc/versioninfo.php?revision=".$NewSVNPart); 
$newver['subver'] = $NewSVNPart;
$prepreg1 = preg_quote("\$VER1[0] = ","/"); 
$prepreg2 = preg_quote(";","/");
preg_match_all("/".$prepreg1."(.*)".$prepreg2."{1}/isU", $GetSVNVersion, $GetVer0);
$GetVer0 = $GetVer0[1][0];
$prepreg1 = preg_quote("\$VER1[1] = ","/"); 
$prepreg2 = preg_quote(";","/");
preg_match_all("/".$prepreg1."(.*)".$prepreg2."{1}/isU", $GetSVNVersion, $GetVer1);
$GetVer1 = $GetVer1[1][0];
$prepreg1 = preg_quote("\$VER1[2] = ","/"); 
$prepreg2 = preg_quote(";","/");
preg_match_all("/".$prepreg1."(.*)".$prepreg2."{1}/isU", $GetSVNVersion, $GetVer2);
$GetVer2 = $GetVer2[1][0];
$newver['ver'] = $GetVer0.".".$GetVer1.".".$GetVer2;
$prepreg1 = preg_quote("\$VER2[0] = \"","/"); 
$prepreg2 = preg_quote("\";","/");
preg_match_all("/".$prepreg1."(.*)".$prepreg2."{1}/isU", $GetSVNVersion, $GetFullVerType);
$newver['fullreltype'] = $GetFullVerType[1][0];
$prepreg1 = preg_quote("\$VER2[1] = \"","/"); 
$prepreg2 = preg_quote("\";","/");
preg_match_all("/".$prepreg1."(.*)".$prepreg2."{1}/isU", $GetSVNVersion, $GetVerType);
$newver['reltype'] = $GetVerType[1][0];
$prepreg1 = preg_quote("\$VER2[2] = \"","/"); 
$prepreg2 = preg_quote("\";","/");
preg_match_all("/".$prepreg1."(.*)".$prepreg2."{1}/isU", $GetSVNVersion, $GetVerSubType);
$newver['subtype'] = $GetVerSubType[1][0];
echo "Sorry need more info to check version.";
$VersionXML = xml_doc_start("1.0","UTF-8",true);
$VersionXML .= xml_tag_make("xml-stylesheet","type=text/xsl&href=version.xsl",true)."\n";
$VersionXML .= "<!DOCTYPE versioninfo [\n";
$VersionXML .= "<!ELEMENT versioninfo (version*)>\n";
$VersionXML .= "<!ELEMENT version (relname,reltype,reltypename,relnum,subtype,relsvnum,fullrel,fullname)>\n";
$VersionXML .= "<!ELEMENT relname (#PCDATA)>\n";
$VersionXML .= "<!ELEMENT reltype (#PCDATA)>\n";
$VersionXML .= "<!ELEMENT reltypename (#PCDATA)>\n";
$VersionXML .= "<!ELEMENT relnum (#PCDATA)>\n";
$VersionXML .= "<!ELEMENT subtype (#PCDATA)>\n";
$VersionXML .= "<!ELEMENT relsvnum (#PCDATA)>\n";
$VersionXML .= "<!ELEMENT fullrel (#PCDATA)>\n";
$VersionXML .= "<!ELEMENT fullname (#PCDATA)>\n";
$VersionXML .= "]>\n\n";
$VersionXML .= "<versioninfo>\n\n";
$VersionXML .= "<version>\n";
$VersionXML .= "<relname>iDB</relname>\n";
$VersionXML .= "<reltype>".$newver['reltype']."</reltype>\n";
$VersionXML .= "<reltypename>".$newver['fullreltype']."</reltypename>\n";
$VersionXML .= "<relnum>".$newver['ver']."</relnum>\n";
$VersionXML .= "<subtype>".$newver['subtype']."</subtype>\n";
$VersionXML .= "<relsvnum>".$newver['subver']."</relsvnum>\n";
$VersionXML .= "<fullrel>iDB ".$newver['reltype']." ".$newver['ver']."</fullrel>\n";
$VersionXML .= "<fullname>iDB ".$newver['reltype']." ".$newver['ver']." ".$newver['subtype']." ".$newver['subver']."</fullname>\n";
$VersionXML .= "</version>\n\n";
$VersionXML .= "<version>\n";
$VersionXML .= "<relname>iDB-Host</relname>\n";
$VersionXML .= "<reltype>".$newver['reltype']."</reltype>\n";
$VersionXML .= "<reltypename>".$newver['fullreltype']."</reltypename>\n";
$VersionXML .= "<relnum>".$newver['ver']."</relnum>\n";
$VersionXML .= "<subtype>".$newver['subtype']."</subtype>\n";
$VersionXML .= "<relsvnum>".$newver['subver']."</relsvnum>\n";
$VersionXML .= "<fullrel>iDB-Host ".$newver['reltype']." ".$newver['ver']."</fullrel>\n";
$VersionXML .= "<fullname>iDB-Host ".$newver['reltype']." ".$newver['ver']." ".$newver['subtype']." ".$newver['subver']."</fullname>\n";
$VersionXML .= "</version>\n\n";
$VersionXML .= "<version>\n";
$VersionXML .= "<relname>iDBEH-Mod</relname>\n";
$VersionXML .= "<reltype>".$newver['reltype']."</reltype>\n";
$VersionXML .= "<reltypename>".$newver['fullreltype']."</reltypename>\n";
$VersionXML .= "<relnum>".$newver['ver']."</relnum>\n";
$VersionXML .= "<subtype>".$newver['subtype']."</subtype>\n";
$VersionXML .= "<relsvnum>".$newver['subver']."</relsvnum>\n";
$VersionXML .= "<fullrel>iDBEH-Mod ".$newver['reltype']." ".$newver['ver']."</fullrel>\n";
$VersionXML .= "<fullname>iDBEH-Mod ".$newver['reltype']." ".$newver['ver']." ".$newver['subtype']." ".$newver['subver']."</fullname>\n";
$VersionXML .= "</version>\n\n";
$VersionXML .= "</versioninfo>";
$fp = fopen("./inc/version.xml","w+");
fwrite($fp, $VersionXML);
fclose($fp); }

if($_GET['act']!="update") {
$VersionFile = file_get_contents("inc/version.xml");
$iDBArray = array("iDB", "iDB-Host", "iDBEH-Mod");
$NamePart = explode("|", $_GET['name']);
if(count($NamePart)>=5) { 
$_GET['name'] = $NamePart[0];
if(!isset($_GET['reltype'])&&isset($NamePart[1])) {
	$_GET['reltype'] = $NamePart[1]; }
if(!isset($_GET['ver'])&&isset($NamePart[2])) {
	$_GET['ver'] = $NamePart[2]; }
if(!isset($_GET['subtype'])&&isset($NamePart[3])) {
	$_GET['subtype'] = $NamePart[3]; }
if(!isset($_GET['subver'])&&isset($NamePart[4])) {
	$_GET['subver'] = $NamePart[4]; } }
if(count($NamePart)<5&&count($NamePart)!=1) { 
if(!isset($_GET['name'])||!isset($_GET['reltype'])||!isset($_GET['ver'])||
	!isset($_GET['subtype'])||!isset($_GET['subver'])) {
	echo "Sorry need more info to check version."; ?>
<!-- Stephanie Braun o_O -->
</body>
</html>
<?php exit(); } }
if(!isset($_GET['name'])||!isset($_GET['reltype'])||!isset($_GET['ver'])||
	!isset($_GET['subtype'])||!isset($_GET['subver'])) {
	echo "Sorry need more info to check version."; ?>
<?php exit(); }
if(count($NamePart)==1) { $_GET['name'] = $NamePart[0]; }
if(!in_array($_GET['name'],$iDBArray)) { echo "Sorry cound not find ".$_GET['name']."."; ?>
</body>
</html>
<?php exit(); }
$VerSplit = explode(".", $_GET['ver']);
if(count($VerSplit)>3||count($VerSplit)<3) { 
echo "Sorry version number is not formated right"; exit(); }
preg_match_all("/([a-zA-Z]+)([0-9]+)/i", $_GET['reltype'], $reltypeChCk);
if(isset($reltypeChCk[0][0])) {
$_GET['reltype'] = $reltypeChCk[1][0];
$uvercheck['reltypex'] = $reltypeChCk[2][0]; }
if(!isset($reltypeChCk[0][0])) {
preg_match_all("/([a-zA-Z]+)/i", $_GET['reltype'], $reltypeChCk); 
$_GET['reltype'] = $reltypeChCk[1][0];
$uvercheck['reltypex'] = "0"; }
/*
PA (Pre-Alpha) = 100
A - Al (Alpha) = 200
PB (Pre-Beta) = 300
B - Be (Beta) = 400
G - Ga (Gamma) = 500
D - De (Delta) = 600
O - Om (Omega) = 700
Z - Ze (Zenith) = 800
R - RC (Release Candidate) = 900
F - FR (Final Release) = 950
*/
// Pre-Alpha
if($_GET['reltype']=="PA") {
	$uvercheck['reltypenum'] = 100 + $uvercheck['reltypex']; }
// Alpha
if($_GET['reltype']=="A"||
	$_GET['reltype']=="Al") {
	$uvercheck['reltypenum'] = 200 + $uvercheck['reltypex']; }
// Pre-Beta
if($_GET['reltype']=="PB") {
	$uvercheck['reltypenum'] = 300 + $uvercheck['reltypex']; }
// Beta
if($_GET['reltype']=="B"||
	$_GET['reltype']=="Be") {
	$uvercheck['reltypenum'] = 400 + $uvercheck['reltypex']; }
// Gamma
if($_GET['reltype']=="G"||
	$_GET['reltype']=="Ga") {
	$uvercheck['reltypenum'] = 500 + $uvercheck['reltypex']; }
// Delta
if($_GET['reltype']=="D"||
	$_GET['reltype']=="De") {
	$uvercheck['reltypenum'] = 600 + $uvercheck['reltypex']; }
// Omega
if($_GET['reltype']=="O"||
	$_GET['reltype']=="Om") {
	$uvercheck['reltypenum'] = 700 + $uvercheck['reltypex']; }
// Zenith
if($_GET['reltype']=="Z"||
	$_GET['reltype']=="Ze") {
	$uvercheck['reltypenum'] = 800 + $uvercheck['reltypex']; }
// Release Candidate
if($_GET['reltype']=="R"||
	$_GET['reltype']=="RC") {
	$uvercheck['reltypenum'] = 900 + $uvercheck['reltypex']; }
// Final Release
if($_GET['reltype']=="F"||
	$_GET['reltype']=="FR") {
	$uvercheck['reltypenum'] = 950 + $uvercheck['reltypex']; }
if($uvercheck['reltypex']!=0) {
	$_GET['reltype'] = $_GET['reltype'].$uvercheck['reltypex']; }
$FullRelNum = $VerSplit[0].$VerSplit[1].$VerSplit[2].".".$uvercheck['reltypenum'].$_GET['subver'];
$prepreg1 = preg_quote("<version>\n<relname>".$_GET['name']."</relname>","/"); 
$prepreg2 = preg_quote("</version>","/");
preg_match_all("/".$prepreg1."(.*)".$prepreg2."{1}/isU", $VersionFile, $VersionPart);
$VersionPart = $VersionPart[0][0];
$prepreg1 = preg_quote("<relname>","/"); 
$prepreg2 = preg_quote("</relname>","/");
preg_match_all("/".$prepreg1."(.*)".$prepreg2."{1}/isU", $VersionPart, $NamePart);
$vercheck['name'] = $NamePart[1][0];
$prepreg1 = preg_quote("<reltype>","/"); 
$prepreg2 = preg_quote("</reltype>","/");
preg_match_all("/".$prepreg1."(.*)".$prepreg2."{1}/isU", $VersionPart, $RelTypePart);
$vercheck['reltype'] = $RelTypePart[1][0];
preg_match_all("/([a-zA-Z]+)([0-9]+)/i", $vercheck['reltype'], $reltypeChCk);
if(isset($reltypeChCk[0][0])) {
$vercheck['reltype'] = $reltypeChCk[1][0];
$vercheck['reltypex'] = $reltypeChCk[2][0]; }
if(!isset($reltypeChCk[0][0])) {
preg_match_all("/([a-zA-Z]+)/i", $vercheck['reltype'], $reltypeChCk); 
$vercheck['reltype'] = $reltypeChCk[1][0];
$vercheck['reltypex'] = "0"; }
/*
PA (Pre-Alpha) = 100
A - Al (Alpha) = 200
PB (Pre-Beta) = 300
B - Be (Beta) = 400
G - Ga (Gamma) = 500
D - De (Delta) = 600
O - Om (Omega) = 700
Z - Ze (Zenith) = 800
R - RC (Release Candidate) = 900
F - FR (Final Release) = 950
*/
// Pre-Alpha
if($vercheck['reltype']=="PA") {
	$vercheck['reltypenum'] = 100 + $vercheck['reltypex']; }
// Alpha
if($vercheck['reltype']=="A"||
	$vercheck['reltype']=="Al") {
	$vercheck['reltypenum'] = 200 + $vercheck['reltypex']; }
// Pre-Beta
if($vercheck['reltype']=="PB") {
	$vercheck['reltypenum'] = 300 + $vercheck['reltypex']; }
// Beta
if($vercheck['reltype']=="B"||
	$vercheck['reltype']=="Be") {
	$vercheck['reltypenum'] = 400 + $vercheck['reltypex']; }
// Gamma
if($vercheck['reltype']=="G"||
	$vercheck['reltype']=="Ga") {
	$vercheck['reltypenum'] = 500 + $vercheck['reltypex']; }
// Delta
if($vercheck['reltype']=="D"||
	$vercheck['reltype']=="De") {
	$vercheck['reltypenum'] = 600 + $vercheck['reltypex']; }
// Omega
if($vercheck['reltype']=="O"||
	$vercheck['reltype']=="Om") {
	$vercheck['reltypenum'] = 700 + $vercheck['reltypex']; }
// Zenith
if($vercheck['reltype']=="Z"||
	$vercheck['reltype']=="Ze") {
	$vercheck['reltypenum'] = 800 + $vercheck['reltypex']; }
// Release Candidate
if($vercheck['reltype']=="R"||
	$vercheck['reltype']=="RC") {
	$vercheck['reltypenum'] = 900 + $vercheck['reltypex']; }
// Final Release
if($vercheck['reltype']=="F"||
	$vercheck['reltype']=="FR") {
	$vercheck['reltypenum'] = 950 + $vercheck['reltypex']; }
if($vercheck['reltypex']!=0) {
	$vercheck['reltype'] = $vercheck['reltype'].$vercheck['reltypex']; }
$prepreg1 = preg_quote("<relnum>","/"); 
$prepreg2 = preg_quote("</relnum>","/");
preg_match_all("/".$prepreg1."(.*)".$prepreg2."{1}/isU", $VersionPart, $RelNumPart);
$vercheck['ver'] = $RelNumPart[1][0];
$MyVerSplit = explode(".", $vercheck['ver']);
$prepreg1 = preg_quote("<subtype>","/"); 
$prepreg2 = preg_quote("</subtype>","/");
preg_match_all("/".$prepreg1."(.*)".$prepreg2."{1}/isU", $VersionPart, $SubTypePart);
$vercheck['subtype'] = $SubTypePart[1][0];
$prepreg1 = preg_quote("<relsvnum>","/"); 
$prepreg2 = preg_quote("</relsvnum>","/");
preg_match_all("/".$prepreg1."(.*)".$prepreg2."{1}/isU", $VersionPart, $RelSVNumPart);
$vercheck['subver'] = $RelSVNumPart[1][0];
$MyFullRelNum = $MyVerSplit[0].$MyVerSplit[1].$MyVerSplit[2].".".$vercheck['reltypenum'].$vercheck['subver'];
$DownloadLink = "<a href=\"http://idb.gamemaker2k.org/?act=download\">http://idb.gamemaker2k.org/?act=download</a>";
if($_GET['redirect']!="on"&&$_GET['redirect']!="xml"&&$_GET['redirect']!="js") {
echo "<div>"; }
if($_GET['redirect']=="xml") {
$VersionXML = xml_doc_start("1.0","UTF-8",true);
$VersionXML .= "<!DOCTYPE versioninfo [\n";
$VersionXML .= "<!ELEMENT versioninfo (version*)>\n";
$VersionXML .= "<!ELEMENT version (reltype,relnum,subtype,relsvnum,results)>\n";
$VersionXML .= "<!ELEMENT reltype (#PCDATA)>\n";
$VersionXML .= "<!ELEMENT relnum (#PCDATA)>\n";
$VersionXML .= "<!ELEMENT subtype (#PCDATA)>\n";
$VersionXML .= "<!ELEMENT relsvnum (#PCDATA)>\n";
$VersionXML .= "<!ELEMENT results (#PCDATA)>\n";
$VersionXML .= "<!ENTITY nbsp \" \">\n";
$VersionXML .= "]>\n\n";
$VersionXML .= "<versioninfo>\n\n";
$VersionXML .= "<version>\n";
$VersionXML .= "<reltype>".$vercheck['reltype']."</reltype>\n";
$VersionXML .= "<relnum>".$vercheck['ver']."</relnum>\n";
$VersionXML .= "<subtype>".$vercheck['subtype']."</subtype>\n";
$VersionXML .= "<relsvnum>".$vercheck['subver']."</relsvnum>\n";
if($FullRelNum<$MyFullRelNum) {
$VersionXML .= "<results><![CDATA[\n<img src=\"".$site_url."inc/pics/old.png\" alt=\"You seem to be using a old version.\" title=\"You seem to be using a old version.\" />&nbsp;Warning: A new version is available. <a href=\"http://idb.berlios.de/?act=download\">Click Here</a>\n]]></results>\n"; }
if($FullRelNum==$MyFullRelNum) {
$VersionXML .= "<results><![CDATA[\n<img src=\"".$site_url."inc/pics/new.png\" alt=\"Congratulations you have the newest version. ^_^ \" title=\"Congratulations you have the newest version. ^_^ \" />&nbsp;Congratulates: You have the latest version.\n]]></results>\n"; }
if($FullRelNum>$MyFullRelNum) {
$VersionXML .= "<results><![CDATA[\n<img src=\"".$site_url."inc/pics/beta.png\" alt=\"You seem to be using a nightly version.\" title=\"You seem to be using a nightly version.\" />&nbsp;Warning: You seem to be using a nightly version. <a href=\"http://idb.berlios.de/?act=download\">Click Here</a> for latest version.\n]]></results>\n"; }
$VersionXML .= "</version>\n\n";
$VersionXML .= "</versioninfo>"; 
echo $VersionXML; }
if($_GET['redirect']=="js") {
$VersionJS = "function idbvercheck() \n{ \n";
$VersionJS .= "document.getElementById('iverinfo').style.display = '';\n";
$VersionJS .= "var vercheckinfo = 'Version Check info below: <br />';\n";
$VersionJS .= "var yourverinfo = 'Your Version: ".$_GET['name']." ".$_GET['reltype']." ".$_GET['ver']." ".$_GET['subtype']." ".$_GET['subver']."';\n";
$VersionJS .= "var myverinfo = 'Current Version: ".$vercheck['name']." ".$vercheck['reltype']." ".$vercheck['ver']." ".$vercheck['subtype']." ".$vercheck['subver']."<br />';\n";
$VersionJS .= "var ourverinfo = yourverinfo+'<br />'+myverinfo;\n";
if($FullRelNum<$MyFullRelNum) {
$VersionJS .= "document.getElementById('iverinfo').innerHTML = vercheckinfo+'<img src=\"".$site_url."inc/pics/old.png\" alt=\"You seem to be using a old version.\" title=\"You seem to be using a old version.\" />&#160;Warning: A new version is available. <a href=\"http://idb.berlios.de/?act=download\">Click Here</a><br />'+ourverinfo+'<br />';"; }
if($FullRelNum==$MyFullRelNum) {
$VersionJS .= "document.getElementById('iverinfo').innerHTML = vercheckinfo+'<img src=\"".$site_url."inc/pics/new.png\" alt=\"Congratulations you have the newest version. ^_^ \" title=\"Congratulations you have the newest version. ^_^ \" />&#160;Congratulates: You have the latest version.<br />'+ourverinfo+'<br />';"; }
if($FullRelNum>$MyFullRelNum) {
$VersionJS .= "document.getElementById('iverinfo').innerHTML = vercheckinfo+'<img src=\"".$site_url."inc/pics/beta.png\" alt=\"You seem to be using a nightly version.\" title=\"You seem to be using a nightly version.\" />&#160;Warning: You seem to be using a nightly version. <br /><a href=\"http://idb.berlios.de/?act=download\">Click Here</a> for latest version.<br />'+ourverinfo+'<br />';"; }
$VersionJS .= "\n} ";
echo $VersionJS; }
if($_GET['redirect']=="on") { 
if($FullRelNum<$MyFullRelNum) {
redirect("location","old.png",FALSE,$site_url."inc/pics/",FALSE); }
if($FullRelNum==$MyFullRelNum) {
redirect("location","new.png",FALSE,$site_url."inc/pics/",FALSE); }
if($FullRelNum>$MyFullRelNum) {
redirect("location","beta.png",FALSE,$site_url."inc/pics/",FALSE); } }
if($_GET['redirect']!="on"&&$_GET['redirect']!="xml"&&$_GET['redirect']!="js") {
if($FullRelNum<$MyFullRelNum) { echo "You seem to be using a old version.\n<br />Goto link below to download new version.\n<br />".$DownloadLink; }
if($FullRelNum==$MyFullRelNum) { echo "Congratulations you have the newest version. ^_^ \n<br />You dont need to do anything for now."; }
if($FullRelNum>$MyFullRelNum) { echo "You seem to be using a nightly version.\n<br />Rember these version are not as stable as the Current Version.\n<br />"; 
echo "Goto link below to download latest version.\n<br />".$DownloadLink; }
echo "\n<br />\n<br />";
echo "Your Version: ".$_GET['name']." ".$_GET['reltype']." ".$_GET['ver']." ".$_GET['subtype']." ".$_GET['subver'];
echo "\n<br />";
echo "Current Version: ".$vercheck['name']." ".$vercheck['reltype']." ".$vercheck['ver']." ".$vercheck['subtype']." ".$vercheck['subver'];
if($_GET['bid']!=null) {
echo "\n<br />Checking board: <a href=\"".$_GET['bid']."\" title=\"".$GetTitle."\">".$GetTitle."</a>"; }
echo "</div>"; } }
if($_GET['redirect']!="on"&&$_GET['redirect']!="xml"&&$_GET['redirect']!="js") {
?>

<!-- Stephanie Braun o_O -->
</body>
</html>
<?php } ?>