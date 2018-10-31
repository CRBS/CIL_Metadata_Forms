<?php
include_once 'Curl_util.php';
include_once 'General_util.php';
class Image_metadata extends CI_Controller
{
    
    public function submit()
    {
        $test_output_folder = $this->config->item('test_output_folder');
        $desc = $this->input->post('description', TRUE);
        $tech_details = $this->input->post('tech_details', TRUE);
        $ncbi = $this->input->post('image_search_parms[ncbi]', TRUE);
        $cell_type = $this->input->post('image_search_parms[cell_type]', TRUE);
        $cell_line = $this->input->post('image_search_parms[cell_line]', TRUE);
        $cellular_component = $this->input->post('image_search_parms[cellular_component]', TRUE);
        
        $json_str = "{\"CIL_CCDB\": {\"Status\": {\"Deleted\": false,\"Is_public\": false },\"CIL\":{\"CORE\":{\"IMAGEDESCRIPTION\":{  }}}}}";
        echo $json_str;
        $json = json_decode($json_str);
        if(!is_null($desc) && strlen(trim($desc)) > 0)
        {
            $desc = trim($desc);
            if(isset($json->CIL_CCDB->CIL->CORE->IMAGEDESCRIPTION))
                $json->CIL_CCDB->CIL->CORE->IMAGEDESCRIPTION->free_text = $desc;
        }
        
        if(!is_null($tech_details) && strlen(trim($tech_details)) >0)
        {
            $tech_details = trim($tech_details);
            $darray = array();
            $darray['free_text'] = $tech_details;
            $djson_str = json_encode($darray);
            $djson = json_decode($djson_str);
            $json->CIL_CCDB->CIL->CORE->TECHNICALDETAILS = $djson;
        }
        
        $json_str = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        file_put_contents($test_output_folder."/test.json", $json_str);
        /*echo "<br/>Description:".$desc;
        echo "<br/>Tech_details:".$tech_details;
        echo "<br/>ncbi:".$ncbi;
        echo "<br/>ncbi expansion:".$this->handleOntologyInput("ncbi_organism",$ncbi);
        echo "<br/>cell_types:".$cell_type;
        echo "<br/>cell_types expansion:".$this->handleOntologyInput("cell_types",$cell_type);
        echo "<br/>cell_line:".$cell_line;
        echo "<br/>cell_lines expansion:".$this->handleOntologyInput("cell_lines",$cell_line);
        echo "<br/>cellular_component:".$cellular_component;
        echo "<br/>cellular_components expansion:".$this->handleOntologyInput("cellular_components",$cellular_component);*/
    }
    
    public function edit($image_id="0")
    {
        $gutil = new General_util();
        if(strcmp($image_id, "0") == 0)
        {
            show_404();
            return;
        }
        $esPrefix = $this->config->item('elasticsearch_host');
        $url = $esPrefix."/ccdbv8/data/".$image_id;
        $cutil = new Curl_util();
        $json_str = $cutil->curl_get($url);
        if(is_null($json_str))
        {
            show_404();
            return;
        }
        $json = json_decode($json_str);
        if(!isset($json->found))
        {
            show_404();
            return;
        }
        
        if($json->found)
        {
            if($gutil->startsWith($image_id, "CIL_"))
            {
                $data['numeric_id'] = str_replace("CIL_", "", $image_id);
            }
            $data['title'] = "CIL | Edit ".$image_id;
            $data['data_json'] = $json;
            $this->load->view('templates/header', $data);
            $this->load->view('edit/edit_main', $data);
            $this->load->view('templates/footer', $data);
        }
        else
        {
            show_404();
            return;
        }
    }
    
    
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
        $api_host = $this->config->item('api_host');
        $service_auth = $this->config->item('auth_key');
        
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
}

