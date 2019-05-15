<?php
include_once 'EZIDUtil.php';
include_once 'DBUtil.php';
include_once 'CILContentUtil.php';

$image_id = "CIL_50639";
$id = 50639;
$doiPostfixId = "CIL50639";
$outputJsonFile = "C:/Users/wawong/Desktop/".$id.".json";
$ejson_str = file_get_contents("C:/data/cil_metadata_config.json");
$ejson = json_decode($ejson_str);
$ezutil = new EZIDUtil();
$dbutil = new DBUtil();
$cilUtil = new CILContentUtil();
$mjson = $dbutil->getMetadata($image_id, $ejson->cil_pgsql_db);
//echo json_encode($mjson, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
$json = json_decode($mjson->metadata);
$metadata =  $cilUtil->getEzIdMetadata($json,$id,date("Y"));
$citation = $cilUtil->getCitationInfo($json, $id, date("Y"));

$ezutil->createDOI($metadata, $ejson->ezid_production_shoulder, $doiPostfixId, $ejson->ezid_auth);


/*
$array = array();
$array['DOI'] = $ejson->ezid_production_shoulder."CIL".$id;
$array['ARK'] = $ejson->ezid_production_ark_shoulder."cil".$id;
$array['Title'] = $citation;
$citation_json_str = json_encode($array);
$citation_json = json_decode($citation_json_str);

$json->CIL_CCDB->Citation = $citation_json;
$json_str = json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
file_put_contents($outputJsonFile, $json_str);
//echo $metadata;
echo $citation;
 * *
 */