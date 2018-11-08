<?php

    function auth_curl_post($url,$auth, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $auth);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        $response  = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
    $file = "C:/Users/wawong/Desktop/40499.jpg";
    $bin = file_get_contents($file);
    $hex = bin2hex($bin);
    //echo $hex;
    $json_str = file_get_contents("C:/data/cil_metadata_config.json");
    $json = json_decode($json_str);
    $url = $json->metadata_service_prefix."/upload_image/7777";
    $response = auth_curl_post($url,$json->metadata_auth,$hex);
    echo "\nOUTPUT:".$response;