<?php

class DB_util
{
    private $success = "success";
    private $id = 0;
    private $metadata = "metadata";
    
    public function getStandardTags()
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select tag from cil_tags order by order_number asc";
        $conn = pg_pconnect($db_params);
        $result = pg_query($conn, $sql);
        $tarray = array();
        while($row = pg_fetch_row($result))
        {
            array_push($tarray,$row[0]);
        }
        pg_close($conn);
        return $tarray;
    }
    
    public function getNextID($is_prod=false)
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
        $sql = "select pass_hash from cil_users where username = $1";
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
    
        $sql = "select numeric_id from cil_metadata where finished = false and tags = $1 order by numeric_id asc";
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
            array_push($id_array,$row[0]);
        }
        
        pg_close($conn);
        return $id_array;
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
        $sql = "select numeric_id, metadata from cil_metadata where image_id = $1";
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
