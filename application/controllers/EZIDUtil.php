<?php

class EZIDUtil
{
    private $success = "success";
    private $error_message = "error_message";
    private $doi  = "doi";
    private $ark = "ark";
    
    

    
    public function updateDOI($input,$shoulder,$id, $doiAuth)
    {
        error_log($input, 3, "C:/Test2/doi_input.txt");
        /*echo "<br/>updateDOI";
        $ch = curl_init();
        $url = "https://ezid.cdlib.org/id/".$shoulder.$id;
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_USERPWD, $doiAuth);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
          array('Content-Type: text/plain; charset=UTF-8',
                'Content-Length: ' . strlen($input)));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $input);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);
        $scode = curl_getinfo($ch, CURLINFO_HTTP_CODE)."";
        $code = $this->convertStatusCode($scode);
        curl_close($ch);
        //echo "CODE:".$code;
        //echo  "\n".$output;
        
        if($code === 400)
        {
            $array = array();
            $array[$this->success] = false;
            $array[$this->error_message] = htmlspecialchars($output."");
            //echo "\n".$array[$this->error_message];
            $json_str = json_encode($array);
            $json = json_decode($json_str);
            return $json;
        }
        
        if($code === 201)
        {
            //echo "CODE:".$code;
            //echo  "\n".$output;
            
            $resultArray = explode(" ",$output);
            $doi = $this->getDoiFromArray($resultArray);
            $ark = $this->getArkFromArray($resultArray);
            $array = array();
            $array[$this->success] = true;
            if(!is_null($doi))
                $array[$this->doi] = $doi;
            if(!is_null($ark))
                $array[$this->ark] = $ark;
            
            $json_str = json_encode($array);
            $json = json_decode($json_str);
            return $json;
        }
        else 
        {
            $array = array();
            $array[$this->success] = false;
            $array[$this->error_message] = "Unkown:".$output;
            $json_str = json_encode($array);
            $json = json_decode($json_str);
            return $json;
            
        }
        */
        
       $array = array();
       $array[$this->success] = true;
            
            $json_str = json_encode($array);
            $json = json_decode($json_str);
            return $json;
    }
    
    public function createDOI($input,$shoulder,$id, $doiAuth)
    {
        $ch = curl_init();
        $url = "https://ezid.cdlib.org/id/".$shoulder.$id;
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_USERPWD, $doiAuth);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER,
          array('Content-Type: text/plain; charset=UTF-8',
                'Content-Length: ' . strlen($input)));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $input);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);
        $scode = curl_getinfo($ch, CURLINFO_HTTP_CODE)."";
        $code = $this->convertStatusCode($scode);
        curl_close($ch);
        //echo "CODE:".$code;
        //echo  "\n".$output;
        
        if($code === 400)
        {
            $array = array();
            $array[$this->success] = false;
            $array[$this->error_message] = htmlspecialchars($output."");
            //echo "\n".$array[$this->error_message];
            $json_str = json_encode($array);
            $json = json_decode($json_str);
            return $json;
        }
        
        if($code === 201)
        {
            //echo "CODE:".$code;
            //echo  "\n".$output;
            
            $resultArray = explode(" ",$output);
            $doi = $this->getDoiFromArray($resultArray);
            $ark = $this->getArkFromArray($resultArray);
            $array = array();
            $array[$this->success] = true;
            if(!is_null($doi))
                $array[$this->doi] = $doi;
            if(!is_null($ark))
                $array[$this->ark] = $ark;
            
            $json_str = json_encode($array);
            $json = json_decode($json_str);
            return $json;
        }
        else 
        {
            $array = array();
            $array[$this->success] = false;
            $array[$this->error_message] = "Unkown";
            $json_str = json_encode($array);
            $json = json_decode($json_str);
            return $json;
            
        }
        
        
       $array = array();
       $array[$this->success] = true;
            
            $json_str = json_encode($array);
            $json = json_decode($json_str);
            return $json;
    }
    
    
    /*
    public function updateDOI($input, $doi, $doiAuth)
    {
        $url = "https://ezid.cdlib.org/id/".$doi;
        echo "\n".$url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $doiAuth);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
          array('Content-Type: text/plain; charset=UTF-8',
                'Content-Length: ' . strlen($input)));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $input);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);
        echo "\n".curl_getinfo($ch, CURLINFO_HTTP_CODE) . "\n";
        echo $output . "\n";
        curl_close($ch);
    }
    */
    public function getDoiInfo($doi)
    {
        $ch = curl_init();
        $url = "https://ezid.cdlib.org/id/".$doi;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);
        //echo  "\n".curl_getinfo($ch, CURLINFO_HTTP_CODE) . "\n";
        //echo  "\n".$output . "\n";
        curl_close($ch);
        return $output;
    }
    
    
    /***********Helper functions********************/
    private function convertStatusCode($sinput)
    {
        if(is_null($sinput))
            return 400;
        if(!is_numeric($sinput))
            return 400;
        
        $code = intval($sinput);
        return $code;
    }
    
    private function getDoiFromArray($array)
    {
        foreach($array as $item)
        {
            //echo "\nItem:".$item;
            if($this->startsWith($item,"doi:" ))
            {
               //echo "\nMatch!!";
               return $item;
            }
        }
        return null;
    }
    
    private function getArkFromArray($array)
    {
        foreach($array as $item)
        {
            if($this->startsWith($item,"ark:"))
               return $item;
        }
        return null;
    }
    
    
    private function startsWith($haystack, $needle)
    {
         $length = strlen($needle);
         return (substr($haystack, 0, $length) === $needle);
    }

    private function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }
        return (substr($haystack, -$length) === $needle);
    }
    
}

