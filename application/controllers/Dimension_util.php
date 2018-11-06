<?php

class Dimension_util
{
    public function handle_size($axis_name, $axis_json, $size_value)
    {
        if(is_null($size_value))
            return null;
        
        if(is_null($axis_json))
        {
            $array = array();
            $array['Space'] = array();
            $json_str = json_encode($array);
            $axis_json = json_decode($json_str);
            $axis_json->Space->axis = $axis_name;
        }
        
        $axis_json->Space->Image_size = $size_value;
    }
    
}

