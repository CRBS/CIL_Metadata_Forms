<?php

class NcmirDbUtil
{
    public function getAllMPIDs($username)
    {
        $mainArray = array();
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('ncmir_db_params');
        
        $sql = "select mpid, notes from ccdb_simpleui_permission_view where portal_screenname = $1";
        
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
            
            array_push($mainArray, $array);
        }
        
        pg_close($conn);
        return $mainArray;
    }
}

