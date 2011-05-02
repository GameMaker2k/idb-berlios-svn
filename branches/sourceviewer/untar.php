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

    $FileInfo: untar.php - Last Update: 01/16/2011 Ver 4.6 - Author: cooldude2k $
*/

// PHP iUnTAR Version 4.6
// license: Revised BSD license
function untar($tarfile,$outdir="./",$chmod=null,$extract=true,$lsonly=false,$findfile=null) {
$TarSize = filesize($tarfile);
$TarSizeEnd = $TarSize - 1024;
if($extract!==true&&$extract!==false) {
	$extract = false; }
if($lsonly!==true&&$lsonly!==false) {
	$lsonly = false; }
if($extract===true) { 
	$lsonly = false; }
if($outdir!=""&&!file_exists($outdir)&&$extract===true) {
	mkdir($outdir,0777); }
$thandle = fopen($tarfile, "r");
if($extract===false) {
	$FileArray = null; $i = 0; }
$outdir = preg_replace('{/$}', '', $outdir)."/";
if(isset($findfile)) {
$qfindfile = preg_quote($findfile,"/"); }
if(!isset($findfile)) {
$qfindfile = null; }
while (ftell($thandle)<$TarSizeEnd) {
	$FileName = $outdir.trim(fread($thandle,100));
	if($findfile!==null&&!preg_match("/".$qfindfile."/",$FileName)) {
		fseek($thandle,8,SEEK_CUR);
		fseek($thandle,8,SEEK_CUR);
		fseek($thandle,8,SEEK_CUR);
		$FileSize = octdec(trim(fread($thandle,12)));
		fseek($thandle,12,SEEK_CUR);
		fseek($thandle,8,SEEK_CUR);
		$FileType = trim(fread($thandle,1));
		fseek($thandle,100,SEEK_CUR);
		fseek($thandle,255,SEEK_CUR); 
		if($FileType=="0"||$FileType=="7") {
			fseek($thandle,$FileSize,SEEK_CUR); } }
	if($findfile===null||preg_match("/".$qfindfile."/",$FileName)) {
	$FileMode = trim(fread($thandle,8));
	if($chmod===null) {
		$FileCHMOD = octdec("0".substr($FileMode,-3)); }
	if($chmod!==null) {
		$FileCHMOD = $chmod; }
		$OwnerID = trim(fread($thandle,8));
		$GroupID = trim(fread($thandle,8));
		$FileSize = octdec(trim(fread($thandle,12)));
		$LastEdit = octdec(trim(fread($thandle,12)));
		$Checksum = octdec(trim(fread($thandle,8)));
		$FileType = trim(fread($thandle,1));
		$LinkedFile = trim(fread($thandle,100));
		fseek($thandle,255,SEEK_CUR); }
		if($findfile===null||preg_match("/".$qfindfile."/",$FileName)) {
		if($FileType=="0"||$FileType=="7") {
			if($lsonly===true) {
			fseek($thandle,$FileSize,SEEK_CUR); }
			if($lsonly===false) {
			$FileContent = fread($thandle,$FileSize); } }
		if($FileType=="1") {
			$FileContent = null; }
		if($FileType=="2") {
			$FileContent = null; }
		if($FileType=="5") {
			$FileContent = null; }
		if($FileType=="0"||$FileType=="7") {
			if($extract===true) {
				$subhandle = fopen($FileName, "a+");
				fwrite($subhandle,$FileContent,$FileSize);
				fclose($subhandle);
				chmod($FileName,$FileCHMOD); } }
		if($FileType=="1") {
			if($extract===true) {
				link($FileName,$LinkedFile); } }
		if($FileType=="2") {
			if($extract===true) {
				symlink($LinkedFile,$FileName); } }
		if($FileType=="5") {
			if($extract===true) {
				mkdir($FileName,$FileCHMOD); } }
		if($FileType=="0"||$FileType=="1"||$FileType=="2"||$FileType=="5"||$FileType=="7") {
			if($extract===false) { 
				$FileArray[$i]['FileName'] = $FileName;
				$FileArray[$i]['FileMode'] = $FileMode;
				$FileArray[$i]['OwnerID'] = $OwnerID;
				$FileArray[$i]['GroupID'] = $GroupID;
				$FileArray[$i]['FileSize'] = $FileSize;
				$FileArray[$i]['LastEdit'] = $LastEdit;
				$FileArray[$i]['Checksum'] = $Checksum;
				$FileArray[$i]['FileType'] = $FileType;
				$FileArray[$i]['LinkedFile'] = $LinkedFile;
				if($lsonly===false) {
				$FileArray[$i]['FileContent'] = $FileContent; } } } }
		//touch($FileName,$LastEdit);
		if($extract===false&&$findfile===null) { ++$i; }
		if($findfile!==null&&preg_match("/".$qfindfile."/",$FileName)) { ++$i; }
		if($FileType=="0"||$FileType=="7") {
			$CheckSize = 512;
			while ($CheckSize<$FileSize) {
				if($CheckSize<$FileSize) {
					$CheckSize = $CheckSize + 512; } }
					$SeekSize = $CheckSize - $FileSize;
					fseek($thandle,$SeekSize,SEEK_CUR); } }
		fclose($thandle);
		if($extract===true) {
			return true; }
		if($extract===false) {
			return $FileArray; } }
function iuntar($tarfile,$outdir="./",$chmod=null,$extract=true,$lsonly=false,$findfile=null) {
	return untar($tarfile,$outdir,$chmod,$extract,$lsonly,$findfile); }
?>