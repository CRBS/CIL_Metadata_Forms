<?php

class DB_util
{
    private $success = "success";
    private $id = 0;
    private $metadata = "metadata";
    private $image_name = "image_name";
    
    public function getRetrainIdFromModelId($model_id)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select id from retrain_models where published_model_id = $1";
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return NUL;
        }
        
        $model_id = intval($model_id);
        $input = array();
        array_push($input, $model_id);
        
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return NULL;
        }
        $retrainID = NULL;
        if($row = pg_fetch_row($result))
        {
            $retrainID = intval($row[0]);
        }
        pg_close($conn);
        return $retrainID;
    }
    
    public function updateRetrainModelPublishId($id, $publish_id)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "update retrain_models set published_model_id = $1  where id = $2";
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return false;
        }
        $id = intval($id);
        $publish_id = intval($publish_id);
        $input = array();
        array_push($input, $publish_id);
        array_push($input, $id);
        
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        pg_close($conn);
        return true;
    }
    
    public function updateModelFileSize($model_id, $filesize)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "update models set file_size = $1 where id = $2";
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return false;
        }
        
        if(!is_numeric($model_id) || !is_numeric($filesize))
        {
            pg_close($conn);
            return false;
        }
        
        $model_id = intval($model_id);
        $filesize = intval($filesize);
        
        $input = array();
        array_push($input, $filesize);
        array_push($input, $model_id);
        
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        pg_close($conn);
        return true;
    }
    
    public function getRetrainInfo($retrainID)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select id, num_iterations, second_aug, tertiary_aug, model_doi, process_start_time, process_finish_time,published_model_id,username from retrain_models where id = $1";
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return NULL;
        }
        $retrainID = intval($retrainID);
        $input = array();
        array_push($input, $retrainID);
        
        $array = array();
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return NULL;
        }
        
        if($row = pg_fetch_row($result))
        {
            $array['id'] = intval($row[0]);
            $array['num_iterations'] = intval($row[1]);
            $array['second_aug'] = intval($row[2]);
            $array['tertiary_aug'] = intval($row[3]);
            $array['model_doi'] = $row[4];
            $array['process_start_time'] = $row[5];
            $array['process_finish_time'] = $row[6];
            
            if(!is_null($row[7]))
                $array['published_model_id'] = intval($row[7]);
            else
                $array['published_model_id'] = NULL;
            
            $array['owner'] = $row[8];
        }
        pg_close($conn);
        $json_str = json_encode($array);
        $json = json_decode($json_str);
        
        return $json;
    }
    
    
    public function getGroupImagesByID($id)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select gi.id, gi.group_name, gi.image_id from cil_groups g, group_images gi where g.group_name = gi.group_name and g.id = $1";
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return NULL;
        }
        
        $input = array();
        array_push($input, $id);
        
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return NULL;
        }
        
        $mainArray = array();
        while($row = pg_fetch_row($result))
        {
            $array = array();
            $array['id'] = intval($row[0]);
            $array['group_name'] = ($row[1]);
            $array['image_id'] = ($row[2]);
            array_push($mainArray,$array);
        }
        pg_close($conn);
        return $mainArray;
    }
    
    
    public function getUserGroupsByType($username, $group_type)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        //$sql = "select id,username, group_name, group_type, group_type from cil_user_groups where username = $1 and group_type = $2";
        $sql = "select distinct g.id, ug.username, g.group_name, ug.group_type from cil_user_groups ug, cil_groups g where ug.group_name = g.group_name and  ug.username = $1 and ug.group_type = $2 order by g.id asc";
        //echo $sql;
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return NULL;
        }
        
        $input = array();
        array_push($input, $username);
        array_push($input, $group_type);
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return NULL;
        }
        
        $mainArray = array();
        while($row = pg_fetch_row($result))
        {
            $array = array();
            $array['id'] = intval($row[0]);
            $array['username'] = $row[1];
            $array['group_name'] = $row[2];
            $array['group_type'] = $row[3];
            array_push($mainArray, $array);
        }
        pg_close($conn);
        return $mainArray;
    }
    
    
    public function getUserGroups($username)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select id, username, group_name from cil_user_groups where username=$1";
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return NULL;
        }
        
        $input = array();
        array_push($input, $username);
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return NULL;
        }
        
        $mainArray = array();
        while($row = pg_fetch_row($result))
        {
            $array = array();
            $array['id'] = intval($row[0]);
            $array['username'] = $row[1];
            $array['group_name'] = $row[2];
            array_push($mainArray, $array);
        }
        
        pg_close($conn);
        return $mainArray;
    }
    
    
    
    public function searchProcesssHistoryByTime($start_time, $end_time)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('image_viewer_db_params');
        $sql="select id, image_id, contact_email, submit_time, finish_time from  cropping_processes where submit_time >= '".$start_time."'::timestamp and submit_time <= '".$end_time."'::timestamp";
    
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return NULL;
        }
        $result = pg_query($conn, $sql);
        if(!$result) 
        {
            pg_close($conn);
            return NULL;
        }
        
        $mainArray = array();
        while($row = pg_fetch_row($result))
        {
            $array = array();
            $array['id'] = intval($row[0]);
            $array['image_id'] = $row[1];
            $array['contact_email'] = $row[2];
            $array['submit_time'] = $row[3];
            $array['finish_time'] = $row[4];
            
            array_push($mainArray, $array);
        }
        
        pg_close($conn);
        return $mainArray;
    }
    
    public function getOldestProcessTimestamp()
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('image_viewer_db_params');
        $sql = "select max(submit_time) from cropping_processes";
        
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return "NA";
        }

        $result = pg_query($conn, $sql);
        if(!$result) 
        {
            pg_close($conn);
            return "NA";
        }
        
        $timestamp = "NA";
        if($row = pg_fetch_row($result))
        {
            $timestamp = $row[0];
        }
        
        pg_close($conn);
        return $timestamp;
    }
    
    
    public function getEarliestProcessTimestamp()
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('image_viewer_db_params');
        $sql = "select min(submit_time) from cropping_processes";
        
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return "NA";
        }

        $result = pg_query($conn, $sql);
        if(!$result) 
        {
            pg_close($conn);
            return "NA";
        }
        
        $timestamp = "NA";
        if($row = pg_fetch_row($result))
        {
            $timestamp = $row[0];
        }
        
        pg_close($conn);
        return $timestamp;
    }        
            
    
    public function getNumOfUnfinishedResults()
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('image_viewer_db_params');
        $sql = "select count(id) from cropping_processes where finish_time is  NULL";
        
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return 0;
        }

        $result = pg_query($conn, $sql);
        if(!$result) 
        {
            pg_close($conn);
            return 0;
        }
        
        $count = 0;
        if($row = pg_fetch_row($result))
        {
            $count = $row[0];
        }
        
        pg_close($conn);
        return $count;
    }
    
    public function getNumOfFinishedResults()
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('image_viewer_db_params');
        $sql = "select count(id) from cropping_processes where finish_time is not NULL";
        
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return 0;
        }

        $result = pg_query($conn, $sql);
        if(!$result) 
        {
            pg_close($conn);
            return 0;
        }
        
        $count = 0;
        if($row = pg_fetch_row($result))
        {
            $count = $row[0];
        }
        
        pg_close($conn);
        return $count;
    }
    
    public function getUserInfoByEmail($email)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select id, username, full_name, user_role, create_time, activated_time from cil_users where email = $1";
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return NULL;
        }
        
        $input = array();
        array_push($input,$email);
        
        $result = pg_query_params($conn, $sql, $input);
        if(!$result) 
        {
            pg_close($conn);
            return NULL;
        }
        
        $array = NULL;
        if($row = pg_fetch_row($result))
        {
            $array = array();
            $array['id'] = intval($row[0]);
            $array['username'] = $row[1];
            $array['full_name'] = $row[2];
            $array['user_role'] =intval($row[3]);
            $array['create_time'] = $row[4];
            $array['activated_time'] = $row[5];
        }
        
        pg_close($conn);
        $json_str = json_encode($array, JSON_UNESCAPED_SLASHES);
        $json = json_decode($json_str);
        return $json;
    }
    
    public function isModelOwner($id,$username)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select id from models where delete_time is NULL and username = $1 and id = $2";
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return false;
        }
        
        $input = array();
        array_push($input,$username);
        array_push($input,$id);
        $result = pg_query_params($conn, $sql, $input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        $isOwner = false;
        
        if($row = pg_fetch_row($result))
        {
            $isOwner = true;
        }
        pg_close($conn);
        return $isOwner;
        
    }
    
    public function getPublishedModelList()
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select id, metadata_json, file_size from models where publish_date is not NULL and delete_time is NULL order by id desc";
        $conn = pg_pconnect($db_params);
        $mainArray = array();
        
        if(!$conn)
        {
             $json_str = json_encode($mainArray);
             $json = json_decode($json_str);
             return json;
        }
        
        $result = pg_query($conn,$sql);
        while($row = pg_fetch_row($result))
        {
            $array = array();
            $array['model_id'] =intval($row[0]);
            $array['metadata_json'] = $row[1];
            $file_size = 0;
            $temp = $row[2];
            if(!is_null($temp) && is_numeric($temp))
                $file_size=intval($temp);
            $array['file_size'] = $file_size;
            array_push($mainArray, $array);
        }
        pg_close($conn);
        return $mainArray;
        
    }
    
    
    public function getModelListByUsername($username)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select id, file_name, file_size,has_display_image,publish_date from models where delete_time is NULL and username = $1 order by id desc";
        $conn = pg_pconnect($db_params);
        $mainArray = array();
        
         if(!$conn)
         {
             $json_str = json_encode($mainArray);
             $json = json_decode($json_str);
             return json;
         }
         
        $input = array();
        array_push($input, $username);
        $result = pg_query_params($conn,$sql,$input);
        while($row = pg_fetch_row($result))
        {
            $array = array();
            $array['model_id'] =intval($row[0]);
            $array['file_name'] = $row[1];
            $file_size = 0;
            $temp = $row[2];
            if(!is_null($temp) && is_numeric($temp))
                $file_size=intval($temp);
            
            $array['file_size'] = $file_size;
            
            $has_display_image = false;
            $temp = $row[3];
            if(!is_null($temp) && strcmp($temp, "t") ==0)
               $has_display_image = true; 
            $array['has_display_image'] = $has_display_image;
            $array['publish_date'] = $row[4];
            
            array_push($mainArray, $array);
        }
        pg_close($conn);
        $json_str = json_encode($mainArray);
        $json = json_decode($json_str);
        return $json;
    }
    
    public function getAllUsersJson()
    {
        
        $sql = "select id, email, user_role, full_name, username from cil_users order by full_name asc";
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');

        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return NULL;
        }

        $result = pg_query($conn, $sql);
        if(!$result) 
        {
            pg_close($conn);
            return NULL;
        }
        
        $mainArray = array();
        while($row = pg_fetch_row($result))
        {
            $userInfo = array();
            $userInfo['id'] = intval($row[0]);
            $userInfo['email'] = $row[1];
            $userInfo['user_role'] = intval($row[2]);
            $userInfo['full_name'] = $row[3];
            $userInfo['username'] = $row[4];
            array_push($mainArray, $userInfo);
        }
        
        $json_str = json_encode($mainArray);
        $json = json_decode($json_str);
        
        pg_close($conn);
        return $json;
    }

    public function isRetrainProcessFinished($retrainID)
    {
        $sql = "select process_finish_time from retrain_models where id = $1";
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $done = false;
        
        if(!is_numeric($retrainID))
            return false;
        $retrainID = intval($retrainID);
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return false;
        }
        
        $input = array();
        array_push($input,$retrainID);
        $result = pg_query_params($conn, $sql, $input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        
        if($row = pg_fetch_row($result))
        {
            $timestamp = $row[0];
            if(!is_null($timestamp))
                $done = true;
        }
        
        pg_close($conn);
        return $done; 
    }
    
    public function getEmailByRetrainId($retrainID)
    {
        $sql = "select email from retrain_models where id = $1";
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $email = NULL;
        
        if(!is_numeric($retrainID))
            return NULL;
        
        $retrainID = intval($retrainID);
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return NULL;
        }
        
        $input = array();
        array_push($input,$retrainID);
        $result = pg_query_params($conn, $sql, $input);
        if(!$result) 
        {
            pg_close($conn);
            return NULL;
        }
        
        if($row = pg_fetch_row($result))
        {
            $email = $row[0];
        }
        
        pg_close($conn);
        return $email;
        
    }

    public function getUserInfoByID($id)
    {
        $sql = "select email, user_role, full_name from cil_users where id = $1";
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        
        if(!is_numeric($id))
            return NULL;
        
        $id = intval($id);
 
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return NULL;
        }
        
        $input = array();
        array_push($input,$id);
        $result = pg_query_params($conn, $sql, $input);
        if(!$result) 
        {
            pg_close($conn);
            return NULL;
        }
        
        $userInfo = NULL;
        if($row = pg_fetch_row($result))
        {
            $userInfo = array();
            $userInfo['email'] = $row[0];
            $userInfo['user_role'] = intval($row[1]);
            $userInfo['full_name'] = $row[2];
        }
        
        pg_close($conn);
        return $userInfo;
    }
    
    public function getRetrainHistory($username)
    {
        $sql = "select id,  process_start_time, process_finish_time  from retrain_models where username = $1 order by id desc";
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return NULL;
        }
        
        $input = array();
        array_push($input,$username);
        $result = pg_query_params($conn, $sql, $input);
        if(!$result) 
        {
            pg_close($conn);
            return NULL;
        }
        
        $mainArray = array();
        while($row = pg_fetch_row($result))
        {
            $array = array();
            $array['id'] = intval($row[0]);
            $array['image_id'] = "Custom images";
            $array['submit_time'] = $row[1];
            $array['finish_time'] = $row[2];
            
            array_push($mainArray, $array);
        }
        pg_close($conn);
        return $mainArray;
    }
    
    
    public function getProcessHistory($email)
    {
        $sql = "select id,image_id, submit_time, finish_time from cropping_processes where contact_email = $1 and delete_time is NULL order by id desc";
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('image_viewer_db_params');
        
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return NULL;
        }
        
        $input = array();
        array_push($input,$email);
        $result = pg_query_params($conn, $sql, $input);
        if(!$result) 
        {
            pg_close($conn);
            return NULL;
        }
        
        $mainArray = array();
        while($row = pg_fetch_row($result))
        {
            $array = array();
            $array['id'] = intval($row[0]);
            $array['image_id'] = $row[1];
            $array['submit_time'] = $row[2];
            $array['finish_time'] = $row[3];
            
            array_push($mainArray, $array);
        }
        pg_close($conn);
        return $mainArray;
    }
    
    public function getUserInfo($username)
    {
        $sql = "select email, user_role, full_name from cil_users where username = $1";
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return NULL;
        }
        
        $input = array();
        array_push($input,$username);
        $result = pg_query_params($conn, $sql, $input);
        if(!$result) 
        {
            pg_close($conn);
            return NULL;
        }
        
        $userInfo = NULL;
        if($row = pg_fetch_row($result))
        {
            $userInfo = array();
            $userInfo['email'] = $row[0];
            $userInfo['user_role'] = intval($row[1]);
            $userInfo['full_name'] = $row[2];
        }
        
        pg_close($conn);
        return $userInfo;
    }
    
    private function generateRandomString($length = 10) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    
    public function deleteAuthToken($username)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        
        $conn = pg_pconnect($db_params);
        if (!$conn) 
            return false;
        $sql = "delete from cil_auth_tokens where username = $1";
        $input = array();
        array_push($input, $username);
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        
        pg_close($conn);
        return true;
    }
    
    public function insertAuthToken($username)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        
        
        $conn = pg_pconnect($db_params);
        if (!$conn) 
            return false;
        $sql = "insert into cil_auth_tokens(id,username,token,token_create_time) ".
               " values(nextval('general_seq'),$1,$2, now())";
        
        $random_str = $this->generateRandomString(15);
        $input = array();
        array_push($input, $username);
        array_push($input,$random_str);
        
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        
        pg_close($conn);
        return true;
        
    }
    
    
    public function deleteCropProcess($id)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('image_viewer_db_params');
        $sql = "update cropping_processes set delete_time = now() where id = $1";
        
        $conn = pg_pconnect($db_params);
        if (!$conn) 
            return false;
        
        $input = array();
        array_push($input,$id);  //1
        
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        pg_close($conn);
        return true; 
    }
    
    public function getCropOwnerEmail($id)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('image_viewer_db_params');
        $sql = "select contact_email from cropping_processes where id = $1";
        
        $conn = pg_pconnect($db_params);
        if (!$conn) 
            return NULL;
        
        $input = array();
        array_push($input,$id);  //1
        
        $email = NULL;
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return NULL;
        }
        
        if($row = pg_fetch_row($result))
        {
            $email = $row[0];
        }
        
        pg_close($conn);
        return $email;
        
    }
    
    public function insertCroppingInfoWithTraining($id,$contact_email, $training_model_url, $augspeed, $frame)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('image_viewer_db_params');
        
        
        $conn = pg_pconnect($db_params);
        if (!$conn) 
            return false;

        $contrast_enhancement = 'true';
        $is_cdeep3m_preview = 'true';
        $is_cdeep3m_run = 'false';
        
        $sql = "insert into cropping_processes(id,image_id,upper_left_x, upper_left_y,width,height, ".
               "\n contact_email,original_file_location,submit_time,starting_z,ending_z,contrast_enhancement, ".
               "\n is_cdeep3m_preview,is_cdeep3m_run,training_model_url,augspeed,frame,use_prp, crop_finish_time) ".
               "\n values(".$id.",$1,$2,$3,$4,$5, ".
               "\n $6, $7, now(), $8, $9, ".$contrast_enhancement.", ".
               "\n ".$is_cdeep3m_preview.", ".$is_cdeep3m_run.", $10,$11, $12, $13, now())";
        
        $input = array();
        array_push($input,"CIL_0");  //1
        array_push($input,0); //2
        array_push($input,0); //3
        array_push($input,1000); //4
        array_push($input,1000); //5
        array_push($input,$contact_email); //6
        array_push($input,"NA"); //7
        array_push($input,intval(0)); //8
        array_push($input,intval(10)); //9
        array_push($input,$training_model_url); //10
        array_push($input,$augspeed); //11
        array_push($input,$frame); //12
        array_push($input,"true"); //13
        
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        
        pg_close($conn);
        return $id;
    }
    
    public function emailExists($email)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select * from cil_users where email = $1";
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return false;
        }
        
        $input = array();
        array_push($input,$email);
        $result = pg_query_params($conn, $sql, $input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        
        $userExist = false;
        if($row = pg_fetch_row($result))
        {
            $userExist = true;
        }
        pg_close($conn);
        return $userExist;
    }
    
    public function userExists($username)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select * from cil_users where username = $1";
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return false;
        }
        
        $input = array();
        array_push($input,$username);
        $result = pg_query_params($conn, $sql, $input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        
        $userExist = false;
        if($row = pg_fetch_row($result))
        {
            $userExist = true;
        }
        pg_close($conn);
        return $userExist;
    }
    
    
    public function isNotActivated($username)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select * from cil_users where username = $1 and activated_time is NULL";
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return false;
        }
        
        $input = array();
        array_push($input,$username);
        $result = pg_query_params($conn, $sql, $input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        
        $userExist = false;
        if($row = pg_fetch_row($result))
        {
            $userExist = true;
        }
        pg_close($conn);
        return $userExist;
    }
    
    public function isAdmin($username)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select role from cil_users u, cil_roles r where u.user_role = r.id and username = $1 and role = 'admin'";
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return false;
        }
        
        $input = array();
        array_push($input,$username);
        $result = pg_query_params($conn, $sql, $input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        $isAdmin = false;
        
        if($row = pg_fetch_row($result))
        {
            $isAdmin = true;
        }
        pg_close($conn);
        return $isAdmin;
        
    }
    
    
    public function getGroupId($image_id)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select group_id from cil_metadata m, cil_tags t where m.tags = t.tag and image_id = $1";
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return NULL;
        }
        $input = array();
        array_push($input,$image_id);
        $result = pg_query_params($conn, $sql, $input);
        if(!$result) 
        {
            pg_close($conn);
            return NULL;
        }
        $group_id = NULL;
        if($row = pg_fetch_row($result))
        {
            $group_id = $row[0];
        }
        
        pg_close($conn);
        return $group_id;
    }
    
    public function getGroupMemebers($tag)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select image_id from cil_metadata where tags = $1 order by create_time";
       
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return NULL;
        }
        $input = array();
        array_push($input,$tag);
        $result = pg_query_params($conn, $sql, $input);
        if(!$result) 
        {
            
            pg_close($conn);
            return NULL;
        }
        $array = array();

        while($row = pg_fetch_row($result))
        {
           
           $image_id = $row[0];
           array_push($array, $image_id);
        }

        pg_close($conn);
        return $array;
    }
    
    public function getGroupInfo($image_id)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select tag,group_id from cil_metadata m, cil_tags t where m.tags = t.tag and image_id = $1";
       
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return NULL;
        }
        $input = array();
        array_push($input,$image_id);
        $result = pg_query_params($conn, $sql, $input);
        if(!$result) 
        {
            
            pg_close($conn);
            return NULL;
        }
        $array = NULL;
        
        
        if($row = pg_fetch_row($result))
        {
           $array = array();
           $array['tag'] = $row[0];
           $array['group_id'] = $row[1];
           
           
        }

        
        $json = NULL;
        if(!is_null($array))
        {
            $json_str = json_encode($array);
            if(!is_null($json_str))
                $json = json_decode ($json_str);
        }
        
        
        pg_close($conn);
        return $json;
    }
    
    
    
    public function getModelList()
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select id, file_name, file_size,has_display_image,publish_date from models where delete_time is NULL order by id desc";
        $conn = pg_pconnect($db_params);
        $mainArray = array();
        
         if(!$conn)
         {
             $json_str = json_encode($mainArray);
             $json = json_decode($json_str);
             return json;
         }
         
        $result = pg_query($conn, $sql);
        
        while($row = pg_fetch_row($result))
        {
            $array = array();
            $array['model_id'] =intval($row[0]);
            $array['file_name'] = $row[1];
            $file_size = 0;
            $temp = $row[2];
            if(!is_null($temp) && is_numeric($temp))
                $file_size=intval($temp);
            
            $array['file_size'] = $file_size;
            
            $has_display_image = false;
            $temp = $row[3];
            if(!is_null($temp) && strcmp($temp, "t") ==0)
               $has_display_image = true; 
            $array['has_display_image'] = $has_display_image;
            $array['publish_date'] = $row[4];
            
            array_push($mainArray, $array);
        }
        pg_close($conn);
        $json_str = json_encode($mainArray);
        $json = json_decode($json_str);
        return $json;
    }
    
    public function getStandardTags()
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select tag from cil_tags order by order_number desc";
        $conn = pg_pconnect($db_params);
        $tarray = array();
        if(!$conn)
            return $tarray;
        $result = pg_query($conn, $sql);
        
        while($row = pg_fetch_row($result))
        {
            array_push($tarray,$row[0]);
        }
        pg_close($conn);
        return $tarray;
    }
    
    public function updateModelJson($model_id,$json_str)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "update models set metadata_json = $1 where id = $2";
        $conn = pg_pconnect($db_params);
        
        $input = array();
        array_push($input,$json_str);
        array_push($input,$model_id);
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        pg_close($conn);
        return true;
        
    }
    
    public function updateMetadata($metadata, $image_id)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "update cil_metadata set metadata = $1 where image_id = $2";
        $conn = pg_pconnect($db_params);
        
        $input = array();
        array_push($input,$metadata);
        array_push($input,$image_id);
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        pg_close($conn);
        return true;
    }
    
    
    public function updateModelDisplayImageStatus($model_id)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "update models has_display_image set has_display_image = true where id = $1";
        $conn = pg_pconnect($db_params);
        
        $input = array();
        array_push($input,$model_id);
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        pg_close($conn);
        return true;
    }
    
    public function updateTrainingFile($model_id,$fileName,$fileSize)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "update models set training_data_filename = $1, training_data_filesize = $2 where id = $3";
        $conn = pg_pconnect($db_params);
        
        $input = array();
        array_push($input,$fileName);
        array_push($input,$fileSize);
        array_push($input,$model_id);
        
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        pg_close($conn);
        return true;
    }
    
    public function updateModelFile($model_id=0,$fileName="Unknown", $fileSize=0)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "update models set file_name = $1, file_size =$2 where id = $3";
        $conn = pg_pconnect($db_params);
        if(!$conn)
            return false;
        
        $input = array();
        array_push($input,$fileName);
        array_push($input,$fileSize);
        array_push($input,$model_id);
        
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        pg_close($conn);
        return true;
    }
    
    public function updateUserPassword($username,$pass_hash)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "update cil_users set pass_hash  = $1 where username = $2";
        $conn = pg_pconnect($db_params);
        if(!$conn)
            return false;
        $input = array();
        array_push($input, $pass_hash);
        array_push($input, $username);
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        pg_close($conn);
        return true;        
    }
    
    
    public function insertRetrainedModel($retrain_id=0)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        
        $sql = "insert into retrain_models(id) values($1)";
        $conn = pg_pconnect($db_params);
        if(!$conn)
            return false;
        $input = array();
        array_push($input,$retrain_id);
        
        
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        pg_close($conn);
        return true;
    }
    
    public function updateRetrainLabelFolder($retrainID,$retrainLabelFolder)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "update retrain_models set retrain_label_folder = $1 where id = $2";
        
        $conn = pg_pconnect($db_params);
        if(!$conn)
            return false;
        $input = array();
        array_push($input,$retrainLabelFolder);
        array_push($input,$retrainID);
        
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        pg_close($conn);
        return true;
    }
    
    
    public function updateRetrainParameters($retrainID, $model_doi, $second_aug, $tertiary_aug, $num_iterations, $username, $email)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "update retrain_models set model_doi=$1, second_aug=$2, tertiary_aug=$3, num_iterations=$4, username=$5, email=$6, process_start_time=now() where id=$7";
        
        $conn = pg_pconnect($db_params);
        if(!$conn)
            return false;
        $input = array();
        array_push($input, $model_doi);
        array_push($input, $second_aug);
        array_push($input, $tertiary_aug);
        array_push($input, $num_iterations);
        array_push($input, $username);
        array_push($input, $email);
        array_push($input, $retrainID);
        
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        pg_close($conn);
        return true;
        
        
    }
    
    public function updateRetrainImageFolder($retrainID,$retrainImageFolder)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "update retrain_models set retrain_image_folder = $1 where id = $2";
        
        $conn = pg_pconnect($db_params);
        if(!$conn)
            return false;
        $input = array();
        array_push($input,$retrainImageFolder);
        array_push($input,$retrainID);
        
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        pg_close($conn);
        return true;
    }
    
    /*
    public function insertRetrainedModel($retrain_id=0)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        
        $sql = "insert into retrain_models(id,retrain_images_upload) values(1,now())";
        $conn = pg_pconnect($db_params);
        if(!$conn)
            return false;
        $input = array();
        array_push($input,$retrain_id);
        
        
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        pg_close($conn);
        return true;
    }
    */
    
    public function insertModelFile($model_id=0,$fileName="Unknown",$fileSize=0,$username)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        
        $sql = "insert into models(id, file_name,file_size, username, create_time) values($1, $2, $3, $4, now())";
        $conn = pg_pconnect($db_params);
        
        $input = array();
        array_push($input,$model_id);
        array_push($input,$fileName);
        array_push($input,$fileSize);
        array_push($input, $username);
        
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        pg_close($conn);
        return true;
    }
    
    
    public function modelExists($model_id=0)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select id from models where id = $1";
        $conn = pg_pconnect($db_params);
        $input = array();
        array_push($input,$model_id);
        
        $result =  pg_query_params($conn,$sql,$input);
        if($row = pg_fetch_row($result))
        {
             pg_close($conn);
             return true;
        }
        pg_close($conn);
        return false;
    }
    
    public function getNextID($is_prod)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "";
        if(!$is_prod)
           $sql = "select nextval('test_id_sequence')";
        else 
           $sql = "select nextval('cil_id_sequence')";
       
        $conn = pg_pconnect($db_params);
        $result = pg_query($conn, $sql);
        $id = 0;
        if($row = pg_fetch_row($result))
        {
            $id = intval($row[0]);
        }
        pg_close($conn);
        return $id;
    }
    
    public function isCropIdExist($crop_id)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('image_viewer_db_params');
        $sql = "select id  from cropping_processes where id = $1";
        $conn = pg_pconnect($db_params);
        if (!$conn) 
            return false;
        
        $input = array();
        array_push($input,$crop_id);  //1
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        
        $existed = false;
        if($row = pg_fetch_row($result))
        {
            $existed = true;
        }
        
        pg_close($conn);
        return $existed;
    }
    
    
    public function getDockerImageType($crop_id)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('image_viewer_db_params');
        $defaultType = "stable";
        $conn = pg_pconnect($db_params);
        if (!$conn) 
            return $defaultType;
        $sql = "select docker_image_type from cropping_processes where id = $1";
        $input = array();
        array_push($input,$crop_id);  //1
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return $defaultType;
        }
        
        if($row = pg_fetch_row($result))
        {
            $defaultType = $row[0];
        }
        pg_close($conn);
        return $defaultType;
        
    }
    
    
    public function updateRetrainProcessFinished($retrain_id)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $conn = pg_pconnect($db_params);
        if (!$conn) 
        {
            return false;
        }
        $sql = "update retrain_models set process_finish_time = now() where id = $1";
        $input = array();
        array_push($input, $retrain_id);
        $result = pg_query_params($conn,$sql,$input);
        if (!$result) 
        {
            pg_close($conn);
            return false;
        }
        pg_close($conn);
        
        return true;  
    }
    
    
    public function updateDockerImageType($imageType, $crop_id)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('image_viewer_db_params');
        $conn = pg_pconnect($db_params);
        if (!$conn) 
        {
            return false;
        }
        $input = array();
        array_push($input, $imageType);
        array_push($input, $crop_id);
        $sql = "update cropping_processes set docker_image_type = $1 where id = $2";
        $result = pg_query_params($conn,$sql,$input);
        if (!$result) 
        {
            pg_close($conn);
            return false;
        }
        pg_close($conn);
        
        return true;  
        
    }
    
    
    public function getNextCropID()
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('image_viewer_db_params');
        $conn = pg_pconnect($db_params);
        if (!$conn) 
            return null;
        $sql = "select nextval('general_sequence')";
        $result = pg_query($conn,$sql);
        if(!$result) 
        {
            pg_close($conn);
            return null;
        }
        $id = null;
        if($row = pg_fetch_row($result))
        {
            $id = $row[0];
        }
        pg_close($conn);
        return $id;
    }
    
    public function getTags()
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select distinct tags from cil_metadata where tags is not null order by tags";
        $conn = pg_pconnect($db_params);
        $result = pg_query($conn, $sql);
        $tarray = array();
        while($row = pg_fetch_row($result))
        {
            $tag = $row[0];
            array_push($tarray, $tag);
        }
        pg_close($conn);
        return $tarray;
    }
    
    public function getUserRole($username)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select role from cil_users u, cil_roles r where u.user_role = r.id and u.username = $1";
        $conn = pg_pconnect($db_params);
        $input = array();
        array_push($input, $username);
        $result = pg_query_params($conn,$sql,$input);
        $role = "member";
        if($row = pg_fetch_row($result))
        {
            $role = $row[0];
        }
        pg_close($conn);
        return $role;
    }
    
    public function getImageSizes($image_id="0")
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select jpeg_size, zip_size from cil_metadata where image_id = $1";
        $conn = pg_pconnect($db_params);
        $input = array();
        array_push($input, $image_id);
        $result = pg_query_params($conn,$sql,$input);
        
        $iarray = array();
        if($row = pg_fetch_row($result))
        {
            $temp = intval('jpeg_size');
            if(!is_null($temp))
                $iarray['jpeg_size'] = $row[0];
            
            $temp = intval('zip_size');
            if(!is_null($temp))
                $iarray['zip_size'] = $row[1];
        }
        pg_close($conn);
        $json_str = json_encode($iarray);
        $json = json_decode($json_str);
        return $json;
    }
    
    public function getAllModelJsonList()
    {
        $array = array();
        //$array['Name'] = 'Test';
        $json = null;
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $conn = pg_pconnect($db_params);
        $sql = "select id, metadata_json from models where publish_date is not null and delete_time is null order by  display_order desc";
        $result = pg_query($conn,$sql);
        if(!$result) 
        {
            pg_close($conn);
            $json_str = json_encode($array);
            $json = json_decode($json_str);
            return $json;
        }
        
        while(($row = pg_fetch_row($result)))
        {
            $id = $row[0];
            $json = null;
            $json_str = $row[1];
            if(!is_null($json_str))
            {
                $json = json_decode($json_str);
                $json->id = intval($id);
                array_push($array, $json);
            }
            
        }
        pg_close($conn);
        return $array;
    }
    
    
    public function getModelJson($model_id=0)
    {
        $array = array();
        //$array['Name'] = 'Test';
        $json = null;
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select metadata_json from models where id = $1";
        $conn = pg_pconnect($db_params);
        $input = array();
        array_push($input, $model_id);
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            $json_str = json_encode($array);
            $json = json_decode($json_str);
            return $json;
        }
        
        if(($row = pg_fetch_row($result)))
        {
            $json_str = $row[0];
            if(is_null($json_str))
            {
                $json_str = "{ \"Cdeepdm_model\":{ \"Name\":\"\" } }";
                $json = json_decode($json_str); 
            }
            $json = json_decode($json_str);
        }
        
        
        pg_close($conn);
        if(is_null($json))
        {
            
            $json_str = "{ \"Cdeepdm_model\":{ \"Name\":\"\" } }";
            $json = json_decode($json_str);
        }

        return $json;
    }
    
    
    public function tagExist($tag)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select tag from cil_tags where tag = $1";
        $conn = pg_pconnect($db_params);
        if(!$conn)
            return false;
        $input = array();
        array_push($input, $tag);
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
             pg_close($conn);
             return false;
        }
        
        if($row = pg_fetch_row($result))
        {
            pg_close($conn);
            return true;
        }
        
        pg_close($conn);
        return false;
    }
    
    
    public function getAuthToken($username)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select token from cil_auth_tokens where username = $1";
        $conn = pg_pconnect($db_params);
        $input = array();
        array_push($input,$username);
        
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return NULL;
        }
        $token = NULL;
        if($row = pg_fetch_row($result))
        {
            $token = $row[0];
        }
        pg_close($conn);
        return $token;
        
    }
    
    public function getAllAvailableImages()
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select numeric_id from cil_metadata where publish_date is NULL order by numeric_id desc";
        $conn = pg_pconnect($db_params);
        $idArray = array();
        
        $result = pg_query($conn,$sql);
        if(!$result) 
        {
            pg_close($conn);
            return $idArray;
        }
        
        while($row = pg_fetch_row($result))
        {
            array_push($idArray, intval($row[0]));
        }
        pg_close($conn);
        
        return $idArray;
    }
    
    
    public function getPassHash($user="0")
    {
        $hash = NULL;
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $array = array();
        $conn = pg_pconnect($db_params);
        if (!$conn) 
        {   
            return NULL;
        }
        $sql = "select pass_hash from cil_users where username = $1 and activated_time is NOT NULL";
        $input = array();
        array_push($input, $user);
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return NULL;
        }
        if($row = pg_fetch_row($result))
        {
            $hash = $row[0];
        }
        pg_close($conn);
        return $hash;
    }
    
    
    public function deleteModel($model_id)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "update models set delete_time = now() where id = $1";
        $conn = pg_pconnect($db_params);
        if (!$conn) 
        {   
            return false;
        }
        
        $input = array();
        array_push($input, $model_id);
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        
        pg_close($conn);
        return true;
    }
    
    public function updateModelPublishDate($model_id)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $array = array();
        $conn = pg_pconnect($db_params);
        if (!$conn) 
        {   
            return false;
        }
        $sql = "update models set publish_date = now() where id = $1";
        $input = array();
        array_push($input, $model_id);
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        
        pg_close($conn);
        return true;
    }
    
    
    public function createNewWebUser($username, $pass_hash,$email,$full_name)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $array = array();
        $conn = pg_pconnect($db_params);
        if (!$conn) 
        {   
            return false;
        }
        $sql = "insert into cil_users(id, username, pass_hash, email, create_time, user_role, full_name) ".
               " values(nextval('general_seq'), $1,$2,$3,now(),2, $4)";
        $input = array();
        array_push($input, $username);
        array_push($input, $pass_hash);
        array_push($input, $email);
        array_push($input, $full_name);
        
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        
        pg_close($conn);
        return true;
    }
    
    public function updateImageDeleteTime($image_id="0")
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $array = array();
        $conn = pg_pconnect($db_params);
        if (!$conn) 
        {   
            return false;
        }
        $sql = "update cil_metadata set delete_date = now() where image_id = $1";
        $input = array();
        array_push($input, $image_id);
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        
        pg_close($conn);
        return true;
    }
    
    public function addTag($tag)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $array = array();
        $conn = pg_pconnect($db_params);
        if (!$conn) 
        {   
            return false;
        }
        $sql = "insert into cil_tags(tag,order_number,group_id) ".
                    " values($1 , (select max(order_number)+1 from cil_tags), nextval('group_id'))";
        
        $input = array();
        array_push($input, $tag);
        
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        
        pg_close($conn);
        return true;
        
    }
    
    
    public function unpublish($image_id="0")
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $array = array();
        $conn = pg_pconnect($db_params);
        if (!$conn) 
        {   
            return false;
        }
        $sql = "update cil_metadata set publish_date = null where  image_id = $1";
        $input = array();
        array_push($input, $image_id);
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        
        pg_close($conn);
        return true;
    }
    
    public function updatePublishTime($image_id="0")
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $array = array();
        $conn = pg_pconnect($db_params);
        if (!$conn) 
        {   
            return false;
        }
        $sql = "update cil_metadata set publish_date = now() where  image_id = $1";
        $input = array();
        array_push($input, $image_id);
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        
        pg_close($conn);
        return true;
    }
    
    public function insertImageEntry($image_id,$image_name, $numeric_id, $metadata,$tag,$jpeg_size, $zip_size)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $conn = pg_pconnect($db_params);
        if (!$conn) 
        {   
            return false;
        }
        $sql = "insert into cil_metadata(image_id, image_name, create_time, numeric_id, metadata, external_id, ".
               " tags, finished, jpeg_size, zip_size) ".
               " values($1, $2,now(),$3, $4, $5, $6,false,$7,$8)";
        $input = array();
        array_push($input, $image_id); //1
        array_push($input, $image_name); //2
        array_push($input, $numeric_id); //3
        array_push($input, $metadata); //4
        array_push($input, $image_id); //5
        array_push($input, $tag); //6
        array_push($input, $jpeg_size); //7
        array_push($input, $zip_size); //8
        
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        
        pg_close($conn);
        return true;
    }
    
    public function updateUserActivatedTime($id)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $array = array();
        $conn = pg_pconnect($db_params);
        if (!$conn) 
        {   
            return false;
        }
        $sql = "update cil_users set activated_time = now() where id = $1";
        $input = array();
        array_push($input, $id);
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        
        pg_close($conn);
        return true;
        
    }
    
    public function updateJpegZipSize($image_id, $jpeg_size, $zip_size)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $array = array();
        $conn = pg_pconnect($db_params);
        if (!$conn) 
        {   
            return false;
        }
        $sql = "update cil_metadata set jpeg_size = $1, zip_size = $2 where image_id = $3";
        $input = array();
        array_push($input, $jpeg_size);
        array_push($input, $zip_size);
        array_push($input, $image_id);
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        
        pg_close($conn);
        return true;
    }
    
    public function submitMetadata($image_id,$metadata)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $array = array();
        $conn = pg_pconnect($db_params);
        if (!$conn) 
        {   
            return false;
        }
        $sql = "update cil_metadata set metadata = $1 where image_id = $2";
        $input = array();
        array_push($input, $metadata);
        array_push($input, $image_id);
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        
        pg_close($conn);
        return true;
    }
    
    public function findIdsByTag($tag)
    {
        $id_array = array();
    
        $sql = "select numeric_id, image_name from cil_metadata where finished = false and tags = $1 and delete_date is NULL order by numeric_id asc";
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $array = array();
        $conn = pg_pconnect($db_params);
        if (!$conn) 
        {   
            return $id_array;
        }
        
        $input = array();
        array_push($input, $tag);
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return $id_array;
        }
            
        while($row = pg_fetch_row($result))
        {
            $item = array();
            array_push($item,$row[0]);
            array_push($item,$row[1]);
            array_push($id_array,$item);
        }
        
        pg_close($conn);
        return $id_array;
    }
    
    
    public function getTrainingInfo($model_id)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $conn = pg_pconnect($db_params);
        if (!$conn) 
            return NULL;
        $sql = "select training_data_filename, training_data_filesize from models where id = $1 and training_data_filename is not NULL ".
               " and training_data_filesize is not NULL";
        $input = array();
        array_push($input, $model_id);
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
            return NULL;
        
        $array = array();
        $hasResult = false;
        if($row = pg_fetch_row($result))
        {
            if(!is_null($row[0]) && !is_null($row[1]) && is_numeric($row[1]))
            {
                $hasResult = true;
                $array['file_name'] = $row[0];
                $array['file_size'] = intval($row[1]);
            }
        }
        
        pg_close($conn);
        if(!$hasResult)
            return NULL;
       
        $json_str = json_encode($array, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $json = json_decode($json_str);
        return $json;
    }
    
    public function listInactivatedAccounts()
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $conn = pg_pconnect($db_params);
        if (!$conn) 
            return NULL;
        
        $sql = "select id, username, full_name, email, create_time from cil_users where activated_time is NULL order by id asc";
        $result = pg_query($conn,$sql);
        
        if(!$result) 
            return NULL;
        
        $mainArray = array();
        $hasResult = false;
        while($row = pg_fetch_row($result))
        {
            $hasResult = true;
            $array = array();
            $array['id'] = intval($row[0]);
            $array['username'] = $row[1];
            $array['full_name'] = $row[2];
            $array['email'] = $row[3];
            $array['create_time'] = $row[4];
        
            array_push($mainArray, $array);
        }
        pg_close($conn);
        
        if(!$hasResult)
            return NULL;
       
        $json_str = json_encode($mainArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $json = json_decode($json_str);
        return $json;
    }
    
    public function getModelInfo($model_id)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $conn = pg_pconnect($db_params);
        if (!$conn) 
            return NULL;
        
        $sql = "select file_name, file_size, publish_date from models where id = $1";
        $input = array();
        array_push($input, $model_id);
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
            return NULL;
        
        $array = array();
        $hasResult = false;
        if($row = pg_fetch_row($result))
        {
            if(!is_null($row[0]) && !is_null($row[1]) && is_numeric($row[1]))
            {
                $hasResult = true;
                $array['file_name'] = $row[0];
                $array['file_size'] = intval($row[1]);
                $array['publish_date'] = $row[2];
            }
        }
        
        pg_close($conn);
        if(!$hasResult)
            return NULL;
       
        $json_str = json_encode($array, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $json = json_decode($json_str);
        return $json;
        
    }
    
    
    public function getMetadata($image_id)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $array = array();
        $conn = pg_pconnect($db_params);
        if (!$conn) 
        {   
            $array[$this->success] = false;
            $json_str = json_encode($array);
            $json = json_decode($json_str);
            return $json;
        }
        $sql = "select numeric_id, metadata, image_name from cil_metadata where image_id = $1";
        $input = array();
        array_push($input, $image_id);
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            $array[$this->success] = false;
            $json_str = json_encode($array);
            $json = json_decode($json_str);
            return $json;
        }
        
        if($row = pg_fetch_row($result))
        {
            
            $array[$this->success] = true;
            $array[$this->id] = intval($row[0]);
            if(is_null($row[1]))
                $array[$this->metadata] = "";
            else
                $array[$this->metadata] = $row[1];
            
            if(is_null($row[2]))
                $array[$this->image_name] = "";
            else
                $array[$this->image_name] = $row[2];
            
        }
        else
        {
            $array[$this->success] = false;
            $json_str = json_encode($array);
            $json = json_decode($json_str);
            return $json;
        }

        pg_close($conn);
        $json_str = json_encode($array);
        $json = json_decode($json_str);
        return $json; 
    }
}
