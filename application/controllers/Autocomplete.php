<?php

require_once './application/libraries/REST_Controller.php';
require_once 'Curl_util.php';
require_once 'General_util.php';

class Autocomplete extends REST_Controller
{
   public function ncbi_organism_get($prefix="")
   {
       $query = "{\n".
                    "\"term_suggest\":{"."\n".
                        "\"text\":\"".$prefix."\","."\n".
                        "\"completion\": {"."\n".
                        "\"field\" : \"NCBI_organism_suggest\""."\n".
                        "}".
                    "}\n".
                "}";
        $this->handleAutoComplete($prefix, $query);
   }
   
   
   private function handleAutoComplete($prefix, $query)
   {
       $sutil = new Curl_util();
       $gutil = new General_util();
       
       $array = array();
       if(strlen($prefix) < 2)
       {
           $this->response($array);
           return;
       }
       $raw = false;
       $advanced = false;
       $temp = $this->input->get('raw',TRUE);
       if(!is_null($temp))
       {
            if(strcmp($temp, strtolower("true"))==0)
            {
                $raw = true;
            }
       }
       
       
       $temp = $this->input->get('advanced',TRUE);
       if(!is_null($temp))
       {
            if(strcmp($temp, strtolower("true"))==0)
            {
                $advanced = true;
            }
       }
       
       //$array = array();
       //$array[0] = "tern_suggest";

       //$input = json_decode($query);
       
       
       $esOntoSuggestURL = $this->config->item('elasticsearch_host')."/ontology2/_suggest";
       //echo $esOntoSuggestURL."<br/>";
       //echo $query."<br/>";
       $response = $sutil->just_curl_get_data($esOntoSuggestURL,$query);
       
       
       
       $array = json_decode($response);
       
       if($raw)
       {
         $this->response($array);
         return;
       }
       
       $results = $array->term_suggest;
       $result = $results[0];
      
       $options = $result->options;
       if(count($options)==0)
       {
         //$this->response($array);
         $emptyResult = array();
         $this->response($emptyResult);
         return;  
       }
       else
       {
         $auto_results = array();
         $uniqueKeys = array();
         foreach($options as $option)
         {
             if(isset($option->text))
             {
                if($advanced)
                   array_push($auto_results, $option->text." [".$option->_source->Onto_id."]");
                else if(!array_key_exists($option->text,$uniqueKeys))
                {
                   array_push($auto_results, $option->text);
                   $uniqueKeys[$option->text] = $option->text;
                           
                           
                }
                    
                
             }
         }
         $this->response($auto_results);
       }
   }
}
