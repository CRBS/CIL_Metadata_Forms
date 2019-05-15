<?php

class DBUtil
{
    private $success = "success";
    private $id = 0;
    private $metadata = "metadata";
    private $image_name = "image_name";
    public function getMetadata($image_id,$db_params)
    {
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

