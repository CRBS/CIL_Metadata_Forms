<?php

include_once 'Curl_util.php';
$filePath = "C:/Users/wawong/Desktop/HANDRA/a1_40.jpg";
$id = 50590;


$curl = new Curl_util();
$response = $curl->remote_upload_file_post($id, $filePath);
echo $response;