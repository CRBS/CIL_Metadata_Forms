<?php

class NcmirDbUtil
{
    
    public function getNcmirUsername($username)
    {
        $ncmirUsername = null;
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $sql = "select ncmir_username from ncmir_archive_user_mapping where cdeep3m_username = $1";
        
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return $ncmirUsername;
        }
        
        $input = array();
        array_push($input, $username);
        
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return $ncmirUsername;
        }
        
        if($row = pg_fetch_row($result))
        {
            $ncmirUsername = $row[0];
        }
        
        pg_close($conn);
        return $ncmirUsername;
        
    }
    
    
    public function getArchivedMPIDs($username)
    {
        $mainArray = array();
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('ncmir_db_params');
        
        $sql = "select mpid, archived_date from microscopy_products where archived_date is not null and portal_screenname = $1";
        
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return $mainArray;
        }
        
        $input = array();
        array_push($input, $username);
        
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return $mainArray;
        }
        
        while($row = pg_fetch_row($result))
        {
            $mainArray[$row[0]+""] = $row[1];
        }
        
        pg_close($conn);
        return $mainArray;
        
    }
    
    public function getMpidInfo($mpid)
    {
        if(is_null($mpid) || !is_numeric($mpid))
            return null;
        
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('ncmir_db_params');
        
        $sql= "select p.project_id, p.project_name, e.experiment_id, e.experiment_title, e.experiment_purpose, m.mpid, m.image_basename, m.notes, m.rsync_date, m.archived_date from project p, experiment e, microscopy_products m ". 
              " where p.project_id = e.project_id and e.experiment_id = m.experiment_experiment_id   and mpid = $1";
        
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return null;
        }
        
        $input = array();
        array_push($input, $mpid);
        
        $array = array();
        $result = pg_query_params($conn,$sql,$input);
        if($result) 
        {
           if($row = pg_fetch_row($result))
           {
                $array['success'] = true;
                $array['project_id'] = intval($row[0]);
                $array['project_name'] = $row[1];
                $array['experiment_id'] = intval($row[2]);
                $array['experiment_title'] = $row[3];
                $array['experiment_purpose'] = $row[4];
                $array['mpid'] = intval($row[5]);
                $array['image_basename'] = $row[6];
                $array['notes'] = $row[7];
                $array['rsync_date'] = $row[8];
                $array['archived_date'] = $row[9];
           }
        }
        
        pg_close($conn);
        return $array;
    }
    
    public function getAllMPIDs($username)
    {
        $mainArray = array();
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('ncmir_db_params');
        
        //$sql = "select mpid, notes from ccdb_simpleui_permission_view where portal_screenname = $1 order by mpid desc";
        $sql = "select mpid, notes, archived_date from ccdb_simpleui_permission_ach_view where portal_screenname = $1 order by mpid desc";
        
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            return $mainArray;
        }
        
        $input = array();
        array_push($input, $username);
        
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return $mainArray;
        }
        
        while($row = pg_fetch_row($result))
        {
            $array = array();
            $array['mpid'] = intval($row[0]);
            $array['notes'] = $row[1];
            $array['archived_date'] = $row[2];
            
            array_push($mainArray, $array);
        }
        
        pg_close($conn);
        return $mainArray;
    }
}

