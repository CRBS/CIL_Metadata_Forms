<?php

class Image_dbutil
{
    public function insertTrainedModel($name, $doi)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('image_viewer_db_params');
        $sql = "insert into trained_models(id,model_name, doi) ".
               " values(nextval('general_sequence'), $1, $2)";
    
        $conn = pg_pconnect($db_params);
        if (!$conn) 
        {   
            return false;
        }
        $input = array();
        array_push($input, $name);
        array_push($input, $doi);
        $result = pg_query_params($conn,$sql,$input);
        if(!$result) 
        {
            pg_close($conn);
            return false;
        }
        pg_close($conn);
        return true;
    }
    
}
