<?php
include 'Curl_util.php';
$cutil = new Curl_util();
$json_str = file_get_contents("C:/data/cil_metadata_config.json");
$json = json_decode($json_str);
$metadata_service_prefix = $json->metadata_service_prefix;
$url = str_replace("metadata_service", "rest/file_size", $metadata_service_prefix);
echo "\n".$url;
$filePath = "/var/www/html/media/images/50639/50639.zip";
$response = $cutil->auth_curl_get_with_data($json->metadata_auth, $url, $filePath);
echo "\n".$response;

