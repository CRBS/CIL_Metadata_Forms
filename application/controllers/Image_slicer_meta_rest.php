<?php

require_once './application/libraries/REST_Controller.php';
require_once 'General_util.php';
class Image_slicer_meta_rest extends REST_Controller
{
    
    private $success = "success";
    
    public function next_slicer_id_get()
    {
        $array = array();
        $array[$this->success] = false;
        $rid = $this->getNextId();
        if(!is_null($rid))
        {
           $array[$this->success] = true;
           $array['id'] = intval($rid);
        } 
        $this->response($array);     
    }
    
    public function image_slice_params_get($image_id)
    {
        $array = array();
        $array[$this->success] = false;
        
        $array = $this->getImageSliceParams($image_id);
        if(!is_null($array))
        {
            $array[$this->success] = true;
        }
        $this->response($array); 
    }
    
    
    public function image_slice_process_post($image_id, $processId)
    {
        $array = array();
        $array[$this->success] = false;
        
        if(is_numeric($processId))
        {
            $success = $this->insertImageSliceProcess($processId, $image_id);
            $array[$this->success] = $success;
        }
        $this->response($array);
    }
    
    ////////////////////////DB////////////////////////////////////////////////
    private function insertImageSliceProcess($processId, $image_id)
    {
        $cil_pgsql_db = $this->config->item('db_params');
        $conn = pg_pconnect($cil_pgsql_db);
        $sql = "insert into extract_image_processes(id, image_id, request_time) ".
               " values($1, $2, now())";
        
        $input = array();
        array_push($input,intval($processId));
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
    
    
    private function getImageSliceParams($image_id)
    {
        $cil_pgsql_db = $this->config->item('db_params');
        $conn = pg_pconnect($cil_pgsql_db);
        
        $sql = "select id, image_id, file_type, inner_dir, image_prefix, zindex_width, orig_file_path, file_ext from extract_zimage_method  where image_id = $1";
        $conn = pg_pconnect($cil_pgsql_db);
        if (!$conn) 
        {
            return null;
        }
        
        $input = array();
        array_push($input, $image_id);
        
        $result = pg_query_params($conn, $sql, $input);
        
        if(!$result) 
        {
            pg_close($conn);
            return null;
        }

        $array = array();

        if($row = pg_fetch_row($result))
        {
            $array['id'] = intval($row[0]);
            $array['image_id'] = $row[1];
            $array['file_type'] = $row[2];
            $array['inner_dir'] = $row[3];
            $array['image_prefix'] = $row[4];
            $array['zindex_width'] = $row[5];
            $array['orig_file_path'] = $row[6];
            $array['file_ext']= $row[7];
        }
        pg_close($conn);
        
        return $array;
        
    }
    
    private function getNextId()
    {
        $CI = CI_Controller::get_instance();
        $cil_pgsql_db = $CI->config->item('db_params');
        $conn = pg_pconnect($cil_pgsql_db);
        
        if (!$conn) 
            return null;
        $sql = "select nextval('general_seq')";
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
}
