<?php

require_once './application/libraries/REST_Controller.php';
require_once 'General_util.php';
class Ncmir_metadata_rest extends REST_Controller
{
    
    private $success = "success";
    
    public function microscopy_info_get($mpid)
    {
        $array = array();
        $array[$this->success] = false;
        
        $array['mpid'] = $mpid;
        if(is_numeric($mpid))
        {
            $rarray = $this->getMicroscopyInfo($mpid);
            if(!is_null($rarray))
                $array = $rarray;
        }
        else
        {
            $array['error_message'] = "Input ID is not a number";
        }

        
        $this->response($array);     
    }
    
    
    public function username_to_email_get($username="Test")
    {
        $array = array();
        $array[$this->success] = false;
        
        $email = $this->getEmail($username);
        if(!is_null($email))
        {
            $array[$this->success] = true;
            $array['email'] = $email;
        }
        else
        {
            $array['error_message'] = "Cannot locate this user";
        }
        
        $this->response($array);     
    }
    
    public function set_rsync_done_post($mpid)
    {
        $array = array();
        $array[$this->success] = false;
        
        if(is_numeric($mpid))
        {
            $setSuccess = $this->updateRsync($mpid);
            if($setSuccess)
            {
                
                $subject = "Your data (CCDBID: ".$mpid.") is ready for archival";
                
                $info = $this->getMicroscopyInfo($mpid);
                $username = $info['portal_screenname'];
                
                if(!is_null($username))
                {
                    $email = $this->getEmail($username);
                    if(!is_null($email))
                    {
                        $message = "Project ID:".$info['project_id']."<br/>\n";
                        $message = $message."Project name:".$info['project_name']."<br/>\n";
                        $message = $message."Experiment ID:".$info['experiment_id']."<br/>\n";
                        $message = $message."Experiment title:".$info['experiment_title']."<br/>\n";
                        $message = $message."Experiment purpose:".$info['experiment_purpose']."<br/>\n";
                        $message = $message."MPID:".$info['mpid']."<br/>\n";
                        $message = $message."Image basename:".$info['image_basename']."<br/>\n";
                        
                        $headers[] = 'MIME-Version: 1.0';
                        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
                        $headers[] = 'From: ccdb@iruka.crbs.ucsd.edu';
                        
                        mail($email, $subject, $message, implode("\r\n", $headers));
                        
                        $array[$this->success] = true;
                    }
                    else 
                    {
                        $array['error_message'] = "Cannot locate the user email in the database";
                    }
                }
                else 
                {
                    $array['error_message'] = "Cannot locate the username in the database";
                }
            }
            else 
            {
                $array['error_message'] = "Cannot set the rsync date in the database";
            }
        }
        else
        {
            $array['error_message'] = "Input ID is not a number";
        }
        
        $this->response($array);
    }
    //////////////////////////DB connection/////////////////////////////////////////////////////
    private function updateRsync($mpid)
    {
        
        $CI = CI_Controller::get_instance();
        $cil_pgsql_db = $this->config->item('ncmir_db_params'); 
                    
        $conn = pg_pconnect($cil_pgsql_db);
        
        if (!$conn) 
        {
            return false;
        }
        
        $sql = "update microscopy_products set rsync_date = now() where mpid = $1";
        
        $input = array();
        array_push($input, $mpid);
        $result = pg_query_params($conn, $sql, $input);
        
        pg_close($conn);
        
        return true;
        
    }
    
    
    private function getEmail($username)
    {
        $email = null;
        $CI = CI_Controller::get_instance();
        $cil_pgsql_db = $this->config->item('ncmir_db_params'); 
                    
        $conn = pg_pconnect($cil_pgsql_db);
        
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
    
    
    private function getMicroscopyInfo($mpid)
    {
        $rarray = null;
        $CI = CI_Controller::get_instance();
        $cil_pgsql_db = $this->config->item('ncmir_db_params'); 
                    
        $conn = pg_pconnect($cil_pgsql_db);
        
        if (!$conn) 
        {
            $rarray[$this->success] = false;
            $rarray['message'] = "Cannot establish the DB connection";
            return $rarray;
        
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
            
            $rarray[$this->success] = true;
            $rarray['project_id'] = $row[0];
            $rarray['project_name'] = $row[1];
            $rarray['experiment_id'] = $row[2];
            $rarray['experiment_title'] = $row[3];
            $rarray['experiment_purpose'] = $row[4];
            $rarray['mpid'] = $row[5];
            $rarray['image_basename'] = $row[6];
            $rarray['notes'] = $row[7];
            $rarray['portal_screenname'] = $row[8];
        }
        else 
        {
            $rarray[$this->success] = false;
            $rarray['mpid'] = $mpid;
            $rarray['message'] = "Cannot find any record";
        }
        pg_close($conn);
        
        return $rarray;
    }
    
    

}

