<?php

class Dimension_util
{
    public function handle_size($axis,$json, $size)
    {
        if(!is_null($size) && strlen(trim($size)) > 0)
        {
            $is_set = false;
            if(is_numeric($size))
            {   
                //echo "<br/>Is numeric:".$size;
                $size = intval($size);
                if(!isset($json->CIL_CCDB->CIL->CORE->DIMENSION))
                {
                    $json->CIL_CCDB->CIL->CORE->DIMENSION = array();
                }

                    
                    $dimensions = $json->CIL_CCDB->CIL->CORE->DIMENSION;
                    foreach($dimensions as $dim)
                    {
                        if(isset($dim->Space->axis)&&
                                strcmp($dim->Space->axis,$axis)==0)
                        {
                            $dim->Space->Image_size = $size;
                            $is_set =true;
                        }
                    }
                    
                    if(!$is_set)
                    {
                        //echo "<br/>Is NOT SET";
                        
                        $item_json_str  = "{\"Space\":{}}";
                        $item_json = json_decode($item_json_str);
                        $item_json->Space->axis = $axis;
                        $item_json->Space->Image_size = $size;
                        array_push($json->CIL_CCDB->CIL->CORE->DIMENSION, $item_json);
                    }
                    else
                    {
                       //echo "<br/>Is SET"; 
                    }
                
                
            }
            
        }
         return $json;
    }
   
}

