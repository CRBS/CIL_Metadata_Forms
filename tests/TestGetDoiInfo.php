<?php
include_once 'EZIDUtil.php';
include_once 'DBUtil.php';
include_once 'CILContentUtil.php';
include_once 'General_util.php';

$image_id = "CIL_50639";
$id = 50639;
$outputJsonFile = "C:/Users/wawong/Desktop/".$id.".json";
$ejson_str = file_get_contents("C:/data/cil_metadata_config.json");
$ejson = json_decode($ejson_str);
$ezutil = new EZIDUtil();
$dbutil = new DBUtil();
$cilUtil = new CILContentUtil();
$gutil = new General_util();

$doi0 = "doi:10.7295/W9CIL419331";
$doi = "doi:10.7295/W9CIL41933";
$message = $ezutil->getDoiInfo($doi);
//echo $message;
if($gutil->startsWith($message,"error:"))
    echo "Error";
else 
{
    echo "No error";    
}