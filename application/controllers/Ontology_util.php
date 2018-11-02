<?php

include_once 'Curl_util.php';

class Ontology_util
{
    private function handleOntologyInput($type, $keywords)
    {
        if(is_null($keywords))
            return null;
        else
        {
            $keywords = trim($keywords);
            if(strlen($keywords)==0)
                return null;
            
            $keywords=str_replace(" ", "%20", $keywords);
        }
        $CI = CI_Controller::get_instance();
        $api_host = $CI->config->item('api_host');
        $service_auth = $CI->config->item('auth_key');
        
        $url = $api_host."/rest/simple_ontology_expansion/".$type."/Name/".
            htmlspecialchars($keywords);
       //echo "<br/>".$url;
       //echo "<br/>auth:".$service_auth;
       $cutil = new Curl_util();
       $response = $cutil->auth_curl_get($service_auth, $url);
       //echo $response;
       $json = json_decode($response);
       if(isset($json->hits->total) && $json->hits->total == 0)
           return null;
       else 
       {
          if(isset($json->hits->hits[0]->_source->Expansion->Onto_id))
            return $json->hits->hits[0]->_source->Expansion->Onto_id;
          else
            return null;
       }
    }
    
    public function handleNewOntoJson($type_name, $input)
    {
        //echo "<br/>Does not have NCBI";
            if(!is_null($input) && strlen(trim($input)))
            {
                $ncbiArray = array();
                $onto_id = $this->handleOntologyInput($type_name,$input);
                if(is_null($onto_id))
                {
                    $item = array();
                    $item['free_text'] = $input;
                    array_push($ncbiArray, $item);
                }
                else 
                {
                    $item = array();
                    $item['onto_id'] = $onto_id;
                    $item['onto_name'] = $input;
                    array_push($ncbiArray, $item);
                }
                $ncbi_jstr = json_encode($ncbiArray);
                return json_decode($ncbi_jstr);
            }
            return null;
    }
    
    public function handleExistingOntoJSON($catgegoryJson, $type_name, $input)
    {

            
            if(is_array($catgegoryJson))
            {
                //echo "<br/>Is Array";
                if(!is_null($input) && strlen(trim($input)))
                {
                    
                    $onto_id = $this->handleOntologyInput($type_name,$input);
                    if(is_null($onto_id))
                    {
                        $item = array();
                        $item['free_text'] = $input;
                        $item_jstr = json_encode($item);
                        $itemJson = json_decode($item_jstr);
                        array_push($catgegoryJson, $itemJson);
                    }
                    else 
                    {
                        $item = array();
                        $item['onto_id'] = $onto_id;
                        $item['onto_name'] = $input;
                        $item_jstr = json_encode($item);
                        $itemJson = json_decode($item_jstr);
                        array_push($catgegoryJson, $itemJson);
                    }
                    
                    return $catgegoryJson;
                }
            }
            return $catgegoryJson;
        
    }
    
}

