<?php
include_once 'EZIDUtil.php';
include_once 'DBUtil.php';
include_once 'CILContentUtil.php';

$image_id = "CIL_50639";
$ejson_str = file_get_contents("C:/data/cil_metadata_config.json");
$ejson = json_decode($ejson_str);
$ezutil = new EZIDUtil();
$dbutil = new DBUtil();
$cilUtil = new CILContentUtil();
$mjson = $dbutil->getMetadata($image_id, $ejson->cil_pgsql_db);
//echo json_encode($mjson, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
$json = json_decode($mjson->metadata);
$metadata =  $cilUtil->getEzIdMetadata($json,50639,2019);
$citation = $cilUtil->getCitationInfo($json, 50639, 2019);
//echo $metadata;
echo $citation;