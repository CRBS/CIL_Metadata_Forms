<?php

require_once 'Curl_util.php';
require_once 'General_util.php';

class Autocomplete_public extends CI_Controller
{
    public function cell_types($prefix="") 
    {
        $query = "{\n".
                    "\"term_suggest\":{"."\n".
                        "\"text\":\"".$prefix."\","."\n".
                        "\"completion\": {"."\n".
                        "\"field\" : \"Cell_type_suggest\""."\n".
                        "}".
                    "}\n".
                "}";
        $resultArray = $this->handleAutoComplete($prefix, $query);
        header('Content-Type: application/json');
        echo json_encode( $resultArray );
    }
    
   public function cellular_components($prefix="")
   {
       $query = "{\n".
                    "\"term_suggest\":{"."\n".
                        "\"text\":\"".$prefix."\","."\n".
                        "\"completion\": {"."\n".
                        "\"field\" : \"Cellular_component_suggest\""."\n".
                        "}".
                    "}\n".
                "}";
        $resultArray = $this->handleAutoComplete($prefix, $query);
        header('Content-Type: application/json');
        echo json_encode( $resultArray );
   }
   
   public function biological_processes($prefix="")
   {
       $query = "{\n".
                    "\"term_suggest\":{"."\n".
                        "\"text\":\"".$prefix."\","."\n".
                        "\"completion\": {"."\n".
                        "\"field\" : \"Biological_processes_suggest\""."\n".
                        "}".
                    "}\n".
                "}";
        $resultArray = $this->handleAutoComplete($prefix, $query);
        header('Content-Type: application/json');
        echo json_encode( $resultArray );
   }
   
   public function anatomical_entities($prefix="")
   {
       $query = "{\n".
                    "\"term_suggest\":{"."\n".
                        "\"text\":\"".$prefix."\","."\n".
                        "\"completion\": {"."\n".
                        "\"field\" : \"Anatomical_entities_suggest\""."\n".
                        "}".
                    "}\n".
                "}";
        $resultArray = $this->handleAutoComplete($prefix, $query);
        header('Content-Type: application/json');
        echo json_encode( $resultArray );
   }
    
   public function ncbi_organism($prefix="")
   {
       $query = "{\n".
                    "\"term_suggest\":{"."\n".
                        "\"text\":\"".$prefix."\","."\n".
                        "\"completion\": {"."\n".
                        "\"field\" : \"NCBI_organism_suggest\""."\n".
                        "}".
                    "}\n".
                "}";
        $resultArray = $this->handleAutoComplete($prefix, $query);
        header('Content-Type: application/json');
        echo json_encode( $resultArray );
   }
   
   public function molecular_functions($prefix="")
   {
       $query = "{\n".
                    "\"term_suggest\":{"."\n".
                        "\"text\":\"".$prefix."\","."\n".
                        "\"completion\": {"."\n".
                        "\"field\" : \"Molecular_function_suggest\""."\n".
                        "}".
                    "}\n".
                "}";
        $resultArray = $this->handleAutoComplete($prefix, $query);
        header('Content-Type: application/json');
        echo json_encode( $resultArray );
   }
   
   public function cell_lines($prefix="")
   {
       $query = "{\n".
                    "\"term_suggest\":{"."\n".
                        "\"text\":\"".$prefix."\","."\n".
                        "\"completion\": {"."\n".
                        "\"field\" : \"Cell_line_suggest\""."\n".
                        "}".
                    "}\n".
                "}";
        $resultArray = $this->handleAutoComplete($prefix, $query);
        header('Content-Type: application/json');
        echo json_encode( $resultArray );
   }
   
   public function imaging_methods($prefix="")
   {
       $query = "{\n".
                    "\"term_suggest\":{"."\n".
                        "\"text\":\"".$prefix."\","."\n".
                        "\"completion\": {"."\n".
                        "\"field\" : \"Imaging_method_suggest\""."\n".
                        "}".
                    "}\n".
                "}";
        $resultArray = $this->handleAutoComplete($prefix, $query);
        header('Content-Type: application/json');
        echo json_encode( $resultArray );
   }
   
   public function human_development_anatomies($prefix="")
   {
       $query = "{\n".
                    "\"term_suggest\":{"."\n".
                        "\"text\":\"".$prefix."\","."\n".
                        "\"completion\": {"."\n".
                        "\"field\" : \"Human_development_anatomy_suggest\""."\n".
                        "}".
                    "}\n".
                "}";
        $resultArray = $this->handleAutoComplete($prefix, $query);
        header('Content-Type: application/json');
        echo json_encode( $resultArray );
   }
   
   public function human_diseases($prefix="")
   {
       $query = "{\n".
                    "\"term_suggest\":{"."\n".
                        "\"text\":\"".$prefix."\","."\n".
                        "\"completion\": {"."\n".
                        "\"field\" : \"Human_disease_suggest\""."\n".
                        "}".
                    "}\n".
                "}";
        $resultArray = $this->handleAutoComplete($prefix, $query);
        header('Content-Type: application/json');
        echo json_encode( $resultArray );
   }
   
   public function mouse_gross_anatomies($prefix="")
   {
       $query = "{\n".
                    "\"term_suggest\":{"."\n".
                        "\"text\":\"".$prefix."\","."\n".
                        "\"completion\": {"."\n".
                        "\"field\" : \"Mouse_gross_anatomy_suggest\""."\n".
                        "}".
                    "}\n".
                "}";
        $resultArray = $this->handleAutoComplete($prefix, $query);
        header('Content-Type: application/json');
        echo json_encode( $resultArray );
   }
   
   public function mouse_pathologies($prefix="")
   {
       $query = "{\n".
                    "\"term_suggest\":{"."\n".
                        "\"text\":\"".$prefix."\","."\n".
                        "\"completion\": {"."\n".
                        "\"field\" : \"Mouse_pathology_suggest\""."\n".
                        "}".
                    "}\n".
                "}";
        $resultArray = $this->handleAutoComplete($prefix, $query);
        header('Content-Type: application/json');
        echo json_encode( $resultArray );
   }
   
   public function plant_growths($prefix="")
   {
       $query = "{\n".
                    "\"term_suggest\":{"."\n".
                        "\"text\":\"".$prefix."\","."\n".
                        "\"completion\": {"."\n".
                        "\"field\" : \"Plant_growth_suggest\""."\n".
                        "}".
                    "}\n".
                "}";
        $resultArray = $this->handleAutoComplete($prefix, $query);
        header('Content-Type: application/json');
        echo json_encode( $resultArray );
   }
   
   public function teleost_anatomies($prefix="")
   {
       $query = "{\n".
                    "\"term_suggest\":{"."\n".
                        "\"text\":\"".$prefix."\","."\n".
                        "\"completion\": {"."\n".
                        "\"field\" : \"Teleost_anatomy_suggest\""."\n".
                        "}".
                    "}\n".
                "}";
        $resultArray = $this->handleAutoComplete($prefix, $query);
        header('Content-Type: application/json');
        echo json_encode( $resultArray );
   }
   
   public function Xenopus_anatomies($prefix="")
   {
       $query = "{\n".
                    "\"term_suggest\":{"."\n".
                        "\"text\":\"".$prefix."\","."\n".
                        "\"completion\": {"."\n".
                        "\"field\" : \"Xenopus_anatomy_suggest\""."\n".
                        "}".
                    "}\n".
                "}";
        $resultArray = $this->handleAutoComplete($prefix, $query);
        header('Content-Type: application/json');
        echo json_encode( $resultArray );
   }
   
   public function Zebrafish_anatomies($prefix="")
   {
       $query = "{\n".
                    "\"term_suggest\":{"."\n".
                        "\"text\":\"".$prefix."\","."\n".
                        "\"completion\": {"."\n".
                        "\"field\" : \"Zebrafish_anatomy_suggest\""."\n".
                        "}".
                    "}\n".
                "}";
        $resultArray = $this->handleAutoComplete($prefix, $query);
        header('Content-Type: application/json');
        echo json_encode( $resultArray );
   }
   
   
   public function general_terms($prefix="")
   {
       $query = "{\n".
                    "\"term_suggest\":{"."\n".
                        "\"text\":\"".$prefix."\","."\n".
                        "\"completion\": {"."\n".
                        "\"field\" : \"General_term_suggest\""."\n".
                        "}".
                    "}\n".
                "}";
        $resultArray = $this->handleAutoComplete($prefix, $query);
        header('Content-Type: application/json');
        echo json_encode( $resultArray );
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
         //$this->response($array);
         //return;
         return $array;
       }
       
       $results = $array->term_suggest;
       $result = $results[0];
      
       $options = $result->options;
       if(count($options)==0)
       {
         $emptyResult = array();
         //$this->response($emptyResult);
         //return;
         return $emptyResult;
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
         //$this->response($auto_results);
       
          return $auto_results;
        }
   }

}