<?php
require_once './application/libraries/REST_Controller.php';
require_once 'Curl_util.php';
require_once 'General_util.php';
require_once 'DB_util.php';

class Rest extends REST_Controller
{
    public function model_json_get($model_id)
    {
        $dbutil = new DB_util();
        $mjson = $dbutil->getModelJson($model_id);
        
        if(!is_null($mjson))
        {
            $this->response($mjson);
        }
        else
        {
            $array = array();
            $array['Error'] = "Cannot find the result";
            $this->response($array);   
        }
    }
    
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

