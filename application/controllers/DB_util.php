<?php

class DB_util
{
    private $success = "success";
    private $id = 0;
    private $metadata = "metadata";
    private $image_name = "image_name";
    
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
        $sql = "select tag from cil_tags order by order_number asc";
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
        $sql = "insert into cil_tags(tag,order_number) ".
                    " values($1 , (select max(order_number)+1 from cil_tags))";
        
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
