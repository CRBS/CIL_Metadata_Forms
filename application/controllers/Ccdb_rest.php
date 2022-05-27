<?php

require_once './application/libraries/REST_Controller.php';
require_once 'General_util.php';
class Ccdb_rest extends REST_Controller
{
    public function microscopy_info_get($mpid)
    {
        $rArray =$this->getMicroscopyInfo($mpid);
        $this->response($rArray);
    }
    
    public function is_archive_completed_get($mpid)
    {
        $isCompleted = $this->isArchiveDone($mpid);
        $rArray = array();
        $rArray['is_completed'] = $isCompleted;
        $this->response($rArray);
    }
    
    
    public function is_rsync_completed_get($mpid)
    {
        $isCompleted = $this->isRyncDone($mpid);
        $rArray = array();
        $rArray['is_completed'] = $isCompleted;
        $this->response($rArray);
    }
    
    public function test_max_get()
    {
        $rArray = array();
        $rArray['max'] = PHP_INT_MAX;
        $this->response($rArray);
    }
    
    public function set_rsync_completed_post($mpid, $status="true")       
    {
        $rArray = array();
        
        if(strcmp($status, "true") != 0 && strcmp($status, "false") != 0)
        {
            $rArray['success'] = false;
            $rArray['error_message'] = "Invalid status input";
            $this->response($rArray);
            exit();
        }
        
        if(!is_numeric($mpid))
        {
            $rArray['success'] = false;
            $rArray['error_message'] = "Invalid MPID";
            $this->response($rArray);
            exit();
        }
        
        if(intval($mpid) > 2147483647)
        {
            $rArray['success'] = false;
            $rArray['error_message'] = "MPID exceed the DB integer value";
            $this->response($rArray);
            exit();
        }
        
        if(!$this->mpidExists($mpid))
        {
            $rArray['success'] = false;
            $rArray['error_message'] = "MPID does not exist";
            $this->response($rArray);
            exit();
        }
        
        $this->setRsync($mpid, $status);
        $rArray['success'] = true;
        $this->response($rArray);
    }
    
    
    public function set_archive_completed_post($mpid, $status="true")       
    {
        $rArray = array();
        if(strcmp($status, "true") != 0 && strcmp($status, "false") != 0)
        {
            $rArray['success'] = false;
            $rArray['error_message'] = "Invalid status input";
            $this->response($rArray);
            exit();
        }
        
        if(!is_numeric($mpid))
        {
            $rArray['success'] = false;
            $rArray['error_message'] = "Invalid MPID";
            $this->response($rArray);
            exit();
        }
        
        if(intval($mpid) > 2147483647)
        {
            $rArray['success'] = false;
            $rArray['error_message'] = "MPID exceed the DB integer value";
            $this->response($rArray);
            exit();
        }
        
        
        if(!$this->mpidExists($mpid))
        {
            $rArray['success'] = false;
            $rArray['error_message'] = "MPID does not exist";
            $this->response($rArray);
            exit();
        }
        
        $this->setArchive($mpid, $status);
        $rArray['success'] = true;
        $this->response($rArray);
    }
    
    /***************Private functions *************************************/
    private function isArchiveDone($mpid)
    {
        $mpExists = false;
        $sql = "select mpid from microscopy_products where mpid = $1 and archived_date is not NULL";
        $ncmir_db_params = $this->config->item('ncmir_db_params');
        $conn = pg_pconnect($ncmir_db_params);
        if (!$conn)
        {
            return false;
        }
        
        $input = array();
        array_push($input, $mpid);
        
        $result = pg_query_params($conn,$sql,$input);
        
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        
        if($row = pg_fetch_row($result))
        {
            $mpExists = true;
        }
        pg_close($conn);
        return $mpExists;
    }
    
    
    
    private function isRyncDone($mpid)
    {
        $mpExists = false;
        $sql = "select mpid from microscopy_products where mpid = $1 and rsync_date is not NULL";
        $ncmir_db_params = $this->config->item('ncmir_db_params');
        $conn = pg_pconnect($ncmir_db_params);
        if (!$conn)
        {
            return false;
        }
        
        $input = array();
        array_push($input, $mpid);
        
        $result = pg_query_params($conn,$sql,$input);
        
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        
        if($row = pg_fetch_row($result))
        {
            $mpExists = true;
        }
        pg_close($conn);
        return $mpExists;
    }
    
    
    private function mpidExists($mpid)
    {
        $mpExists = false;
        $sql = "select mpid from microscopy_products where mpid = $1";
        $ncmir_db_params = $this->config->item('ncmir_db_params');
        $conn = pg_pconnect($ncmir_db_params);
        if (!$conn)
        {
            return false;
        }
        
        $input = array();
        array_push($input, $mpid);
        
        $result = pg_query_params($conn,$sql,$input);
        
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        
        if($row = pg_fetch_row($result))
        {
            $mpExists = true;
        }
        pg_close($conn);
        return $mpExists;
    }
    
    
    private function setArchive($mpid, $status)
    {
        $sql = "";
        
        if(strcmp($status, "true") == 0)
           $sql = "update microscopy_products set archived_date = now() where mpid = $1";
        else
           $sql = "update microscopy_products set archived_date = NULL where mpid = $1";
        
        $rArray = array();
        $ncmir_db_params = $this->config->item('ncmir_db_params');
        $conn = pg_pconnect($ncmir_db_params);
        if (!$conn)
        {
            
            $rArray['success'] = false;
            $rArray['error_message'] = "Cannot create the DB connection";
            return $rArray;
        }
        $input = array();
        array_push($input, $mpid);
        
        $result = pg_query_params($conn,$sql,$input);
        
        if(!$result) 
        {
            pg_close($conn);
            
            $rArray['success'] = false;
            $rArray['error_message'] = "No such record";
            return $rArray;
        }
        
        $rArray['success'] = true;
        pg_close($conn);
        return $rArray;
    }
    
    
    private function setRsync($mpid, $status)
    {
        $sql = "";
        
        if(strcmp($status, "true") == 0)
           $sql = "update microscopy_products set rsync_date = now() where mpid = $1";
        else
           $sql = "update microscopy_products set rsync_date = NULL where mpid = $1";
        
        $rArray = array();
        $ncmir_db_params = $this->config->item('ncmir_db_params');
        $conn = pg_pconnect($ncmir_db_params);
        if (!$conn)
        {
            
            $rArray['success'] = false;
            $rArray['error_message'] = "Cannot create the DB connection";
            return $rArray;
        }
        $input = array();
        array_push($input, $mpid);
        
        $result = pg_query_params($conn,$sql,$input);
        
        if(!$result) 
        {
            pg_close($conn);
            
            $rArray['success'] = false;
            $rArray['error_message'] = "No such record";
            return $rArray;
        }
        
        $rArray['success'] = true;
        pg_close($conn);
        return $rArray;
    }
    
    
    private function getMicroscopyInfo($mpid)
    {
        $sql = "select p.project_id, p.project_name, e.experiment_id, e.experiment_title, e.experiment_purpose, ".
               " m.mpid, m.image_basename, m.notes ".
               " from project p, experiment e, microscopy_products m ".
               " where p.project_id = e.project_id and e.experiment_id = m.experiment_experiment_id and m.mpid = $1";
        $rArray = array();
        $ncmir_db_params = $this->config->item('ncmir_db_params');
        $conn = pg_pconnect($ncmir_db_params);
        if (!$conn)
        {
            
            $rArray['success'] = false;
            $rArray['error_message'] = "Cannot create the DB connection";
            return $rArray;
        }
        
        $input = array();
        array_push($input, $mpid);
        
        $result = pg_query_params($conn,$sql,$input);
        
        if(!$result) 
        {
            pg_close($conn);
            
            $rArray['success'] = false;
            $rArray['error_message'] = "No such record";
            return $rArray;
        }
        
        if($row = pg_fetch_row($result))
        {
            $rArray = array();
            $rArray['success'] = true;
            $rArray['project_id'] = $row[0];
            $rArray['project_name'] = $row[1];
            $rArray['experiment_id'] = $row[2];
            $rArray['experiment_title'] = $row[3];
            $rArray['experiment_purpose'] = $row[4];
            $rArray['mpid'] = $row[5];
            $rArray['image_basename'] = $row[6];
            $rArray['desc'] = $row[7];
        }
        pg_close($conn);
        return $rArray;
        
    }    

}
