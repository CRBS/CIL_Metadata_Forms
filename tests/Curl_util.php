<?php

class Curl_util
{
    
    public function remote_upload_file_post($id,$filePath)
    {
        $configFile = "C:/data/cil_metadata_config.json";
        $json_str = file_get_contents($configFile);
        $json = json_decode($json_str);
        $remote_upload_prefix = $json->remote_upload_prefix;
        $auth = $json->metadata_auth;
        $fileName = basename($filePath);
        $fields = [
            'data' => new \CurlFile($filePath, 'image/jpeg', $fileName)
        ];
        
        $url = $remote_upload_prefix."/upload_image/".$id;
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
        return $response;
    }
    public function auth_curl_get_with_data($service_auth,$url,$data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $service_auth);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        $response  = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
    
?>
