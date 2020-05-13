<?php
require_once './application/libraries/REST_Controller.php';
require_once 'Curl_util.php';
require_once 'General_util.php';
require_once 'DB_util.php';
require_once 'MailUtil.php';

class Rest extends REST_Controller
{
    
    public function report_finished_retrain_model_post($retrain_id)
    {
        $base_url = $this->config->item('base_url');
        $mutil = new MailUtil();
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
        
        $email = $dbutil->getEmailByRetrainId($retrain_id);
        
        /***************Send Gmail*******************/
        $log_location = $this->config->item('log_location');
        $email_log_file = $log_location."/email_error.log";
        
        $subject = "Your CDeep3M retrain process is finished:".$retrain_id;
        $message = $base_url."/cdeep3m_retrain/result/".$retrain_id;;
            
        $gmail_sender = $this->config->item('gmail_sender');
        $gmail_sender_name = $this->config->item('gmail_sender_name');
        $gmail_sender_pwd = $this->config->item('gmail_sender_pwd');
        $gmail_reply_to = $this->config->item('gmail_reply_to');
        $gmail_reply_to_name = $this->config->item('gmail_reply_to_name');
            
        $mutil->sendGmail($gmail_sender, $gmail_sender_name, $gmail_sender_pwd,$email, $gmail_reply_to, $gmail_reply_to_name, $subject, $message, $email_log_file);
        /***************End send Gmail***************/
        
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

