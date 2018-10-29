<?php

class Curl_util
{
    public function curl_get($url)
    {
        $CI = CI_Controller::get_instance();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        $response  = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
    
    public function just_curl_get_data($url,$data)
    {
        $CI = CI_Controller::get_instance();
        $service_auth = $CI->config->item('service_auth');
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        $response  = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
    public function curl_post($url, $data)
    {
        
        $CI = CI_Controller::get_instance();
        $service_auth = $CI->config->item('service_auth');
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($doc)));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $service_auth);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //On dev server only
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        $response  = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
    
    public function curl_put($url, $data)
    {
        
        $CI = CI_Controller::get_instance();
        $service_auth = $CI->config->item('service_auth');
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($doc)));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $service_auth);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //On dev server only
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        $response  = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
    
}
    
?>
