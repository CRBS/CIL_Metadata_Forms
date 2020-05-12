<?php
require_once './application/libraries/REST_Controller.php';
require_once 'Curl_util.php';
require_once 'General_util.php';
require_once 'DB_util.php';

class Rest extends REST_Controller
{
    
    public function report_finished_retrain_model($retrain_id)
    {
        $dbutil = new DB_util();
        if(is_null($retrain_id) || !is_numeric($retrain_id))
        {
            $array = array();
            $array['success'] = false;
            $array['Error'] = "Invalid input ID:".$retrain_id;
            $this->response($array);
            return;
        }
        
        $success = $dbutil->updateRetrainProcessFinished($retrain_id);
        if(!$success)
        {
            $array = array();
            $array['success'] = false;
            $array['Error'] = "DB connection error.";
            $this->response($array);
            return;
        }
        
        $array = array();
        $array['success'] = true;
        $this->response($array);
    }
            
    
    
    public function all_model_json_get()
    {
        $dbutil = new DB_util();
        $mjsonList = $dbutil->getAllModelJsonList();
        if(!is_null($mjsonList))
        {
            $this->response($mjsonList);
        }
        else
        {
            $array = array();
            $array['Error'] = "Cannot find the result";
            $this->response($array);   
        }
    }
    
    public function model_json_get($model_id)
    {
        $dbutil = new DB_util();
        
        $model_upload_location = $this->config->item('model_upload_location');
        
        $mjson = $dbutil->getModelJson($model_id);
        
        
        
        /************Outputing to a file *****************/
        $folder = $model_upload_location."/model_json_files";
        if(!file_exists($folder))
            mkdir($folder);
        
        $filePath = $folder."/".$model_id.".json";
        $json_str = json_encode($mjson,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        if(file_exists($filePath))
            unlink($filePath);
        
        file_put_contents($filePath, $json_str);
        /***********************************************/
        
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

