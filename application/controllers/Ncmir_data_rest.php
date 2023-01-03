<?php

require_once './application/libraries/REST_Controller.php';
require_once 'General_util.php';

class Ncmir_data_rest extends REST_Controller
{
    
    private $success = "success";
    
    public function data_jail_dirs_get($mpid)
    {
        $array=array();
        //$cmd = "ls /ccdbprod/ccdbproddj0"; 
        $cmd = "find   /ccdbprod/ccdbproddj0  -name \"CCDBID_".$mpid."*\"   -type d -maxdepth 3";
        $result = shell_exec($cmd);
        //echo $result;
        
        if(is_null($result))
        {
            $array[$this->success] = false;
        }
        else 
        {
            $array[$this->success] = true;
            $result = trim($result);
            $array['Path'] = $result;
            
            $dirArray = array();
            $fileArray = array();
            
            $files = scandir($result);
            foreach($files as $file)
            {
                if(strcmp($file, ".") != 0 && strcmp($file, "..") != 0)
                {
                    if(is_dir($array['Path']."/".$file))
                    {
                        array_push($dirArray, $file);
                    }
                }
            }
            
            foreach($files as $file)
            {
                if(strcmp($file, ".") != 0 && strcmp($file, "..") != 0)
                {
                    if(is_file($array['Path']."/".$file))
                    {
                        array_push($fileArray, $file);
                    }
                }
            }
            
            $array['Sub_dirs'] = $dirArray;
            $array['Files'] = $fileArray;
        }
        
        //$array['cmd'] = $cmd;
        //$array['message'] = $result;
        $this->response($array); 
    }
}