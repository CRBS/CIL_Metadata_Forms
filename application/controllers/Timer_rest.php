<?php
require_once './application/libraries/REST_Controller.php';
require_once 'Curl_util.php';
require_once 'General_util.php';
require_once 'DB_util.php';
require_once 'MailUtil.php';

class Timer_rest extends REST_Controller
{
    private $success = "success";
    
    public function pod_start_post($crop_id)
    {
        $dbutil = new DB_util();
        $success = $dbutil->timerUpdatePodStartTime($crop_id);
        
        $array = array();
        $array[$this->success] = $success;
        $json_str = json_encode($array);
        $json = json_decode($json_str);
        $this->response($json);
        return;
    }
    
    public function pod_end_post($crop_id)
    {
        $dbutil = new DB_util();
        $success = $dbutil->timerUpdatePodEndTime($crop_id);
        
        $array = array();
        $array[$this->success] = $success;
        $json_str = json_encode($array);
        $json = json_decode($json_str);
        $this->response($json);
        return;
    }
    
    public function download_start_post($crop_id)
    {
        $dbutil = new DB_util();
        $success = $dbutil->timerUpdateDownloadStartTime($crop_id);
        
        $array = array();
        $array[$this->success] = $success;
        $json_str = json_encode($array);
        $json = json_decode($json_str);
        $this->response($json);
        return;
    }
    
    public function download_end_post($crop_id)
    {
        $dbutil = new DB_util();
        $success = $dbutil->timerUpdateDownloadEndTime($crop_id);
        
        $array = array();
        $array[$this->success] = $success;
        $json_str = json_encode($array);
        $json = json_decode($json_str);
        $this->response($json);
        return;
    }
    
    public function predict_start_post($crop_id)
    {
        $dbutil = new DB_util();
        $success = $dbutil->timerUpdatePredictStartTime($crop_id);
        
        $array = array();
        $array[$this->success] = $success;
        $json_str = json_encode($array);
        $json = json_decode($json_str);
        $this->response($json);
        return;
    }
    
    public function predict_end_post($crop_id)
    {
        $dbutil = new DB_util();
        $success = $dbutil->timerUpdatePredictEndTime($crop_id);
        
        $array = array();
        $array[$this->success] = $success;
        $json_str = json_encode($array);
        $json = json_decode($json_str);
        $this->response($json);
        return;
    }
    
    
}