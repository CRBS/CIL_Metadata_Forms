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
        
        /**********Sending email***************************/
        $minfo = $this->getMicroscopyInfo2($mpid);
        if(!is_null($minfo))
        {
           $username =  $minfo['portal_screenname'];
           $email = $this->getEmail($username);
           
           if(!is_null($email))
           {
                $message = $this->getEmailMessage($minfo);

                $to = $email;
                $from = "ccdbuser@reba.crbs.ucsd.edu";
                $subject = "Your data (CCDBID: ".$mpid.") is ready for archival";
                
                $this->sendEmail($to, $from, $subject, $message);
                $this->updateRsyncEmailTime($mpid);
           }
        }
        /**********End Sending email***************************/
        
        
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

    
    
    /**************Sending email***************************************/
    private function formatString($line)
    {
        if(is_null($line))
            return "";

        return str_replace("'", " ", $line);
    }

    private function sendEmail($to, $from, $subject, $message)
    {
         $cmd = "sendEmail -t ".$to." -f ".$from." -s reba.ncmir.ucsd.edu:25 -u '".$subject."' -m '".$message."'";
         $response = shell_exec($cmd);
         echo $response;
    }
    
    private function updateRsyncEmailTime($mpid)
    {
        $ncmir_db_params = $this->config->item('ncmir_db_params');
        $conn = pg_pconnect($ncmir_db_params);

        if (!$conn) 
        {
            return null;
        }

        $sql = "update microscopy_products set rsync_email_time = now() where mpid = $1";
        $input = array();
        array_push($input, $mpid);

        $result = pg_query_params($conn, $sql, $input);
        pg_close($conn);

        return true;
    }
    
    
    private function getEmail($username)
    {
        $email = null;
        $ncmir_db_params = $this->config->item('ncmir_db_params');             
        $conn = pg_pconnect($ncmir_db_params);
        
        if (!$conn) 
        {
            return null;
        }
        
        $sql = "select emailaddress from user_ where screenname = $1";
        
        $input = array();
        array_push($input, $username);
        $result = pg_query_params($conn, $sql, $input);
        if($row = pg_fetch_row($result))
        {
            $email = $row[0];
        }
        pg_close($conn);
        
        return $email;
        
    }
    
    private function getMicroscopyInfo2($mpid)
    {
        $rarray = array();
        $ncmir_db_params = $this->config->item('ncmir_db_params'); 
        $conn = pg_pconnect($ncmir_db_params);
        
        if (!$conn) 
        {
            return null;
        
        }
        
        $sql = "select p.project_id, p.project_name, e.experiment_id, e.experiment_title, e.experiment_purpose, ".
               " m.mpid, m.image_basename, m.notes, m.portal_screenname ".
               " from project p, experiment e, microscopy_products m ".
               " where p.project_id = e.project_id and e.experiment_id = m.experiment_experiment_id and m.mpid = $1";
        
        $input = array();
        array_push($input, $mpid);
        $result = pg_query_params($conn, $sql, $input);
        if($row = pg_fetch_row($result))
        {
            
            $rarray['project_id'] = $row[0];
            $rarray['project_name'] = $this->formatString($row[1]) ;
            $rarray['experiment_id'] = $row[2];
            $rarray['experiment_title'] = $this->formatString($row[3]);
            $rarray['experiment_purpose'] = $this->formatString($row[4]);
            $rarray['mpid'] = $row[5];
            $rarray['image_basename'] = $this->formatString($row[6]);
            $rarray['notes'] = $this->formatString($row[7]);
            $rarray['portal_screenname'] = $this->formatString($row[8]);
        }
        else 
        {
            return null;
        }
        pg_close($conn);
        
        return $rarray;
    }
    
    public function getEmailMessage($minfo)
    {
        $message = "<html><body>";
        $message = $message."Project ID:".$minfo['project_id']."<br/>";
        $message = $message."Project name:".$minfo['project_name']."<br/>";
        $message = $message."Experiment ID:".$minfo['experiment_id']."<br/>";
        $message = $message."Experiment title:".$minfo['experiment_title']."<br/>";
        $message = $message."Experiment purpose:".$minfo['experiment_purpose']."<br/>";
        $message = $message."Microscopy ID:".$minfo['mpid']."<br/>";
        $message = $message."Microscopy basename:".$minfo['image_basename']."<br/>";
        $message = $message."</body></html>";
        
        return $message;
    }
    
    /**************End sending email *********************************/
}
