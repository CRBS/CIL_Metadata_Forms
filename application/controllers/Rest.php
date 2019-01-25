<?php
require_once './application/libraries/REST_Controller.php';
require_once 'Curl_util.php';
require_once 'General_util.php';
require_once 'DB_util.php';

class Rest extends REST_Controller
{
     public function metadata_json_get($id)
     {
         $dbutil = new DB_util();
         $json = $dbutil->getMetadata($id);
         if(isset($json->metadata))
         {
             $json_str = $json->metadata;
             $mjson = json_decode($json_str);
             $this->response($mjson);
             
         }
         else
         {
             $array = array();
             $array['Error'] = "Cannot find the result";
             $this->response($array);
         }
     }
}

