<?php

$configFile = "C:/data/cil_metadata_config.json";
$json_str = file_get_contents($configFile);
$json = json_decode($json_str);

$auth = $json->metadata_auth;
$filePath = "C:/Users/wawong/Desktop/HANDRA/a1_40.jpg";
$fileName = "a1_40.jpg";
$fields = [
    'data' => new \CurlFile($filePath, 'image/jpeg', $fileName)
];
$url = $json->remote_upload_prefix."/upload_image/50590";



$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, $auth);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
$response  = curl_exec($ch);
curl_close($ch);
echo $response;


