<?php
include_once 'Curl_util.php';
include_once 'General_util.php';
include_once 'DB_util.php';
include_once 'Ontology_util.php';
class Image_metadata extends CI_Controller
{
    public function test($image_id)
    {
        $dbutil = new DB_util();
        $json = $dbutil->getMetadata($image_id);
        //$json_str = json_encode($json);
        //echo $json_str;
        var_dump($json);
    }
    
    public function submit($image_id="0")
    {
        $dbutil = new DB_util();
        $outil = new Ontology_util();
        $mjson = $dbutil->getMetadata($image_id);
        
        
        $this->load->helper('url');
        $base_url = $this->config->item('base_url');
        $test_output_folder = $this->config->item('test_output_folder');
        $desc = $this->input->post('description', TRUE);
        $tech_details = $this->input->post('tech_details', TRUE);
        $ncbi = $this->input->post('image_search_parms[ncbi]', TRUE);
        $cell_type = $this->input->post('image_search_parms[cell_type]', TRUE);
        $cell_line = $this->input->post('image_search_parms[cell_line]', TRUE);
        $cellular_component = $this->input->post('image_search_parms[cellular_component]', TRUE);
        
        $json_str = "{\"CIL_CCDB\": {\"Status\": {\"Deleted\": false,\"Is_public\": false },\"CIL\":{\"CORE\":{\"IMAGEDESCRIPTION\":{  }}}}}";
        
        if($mjson->success && isset($mjson->metadata)
                && !is_null($mjson->metadata)
                && strlen(trim($mjson->metadata)) > 0
                )
        {
            //echo "<br/>Loading the previous json sucessfully";
            //echo "<br/><br/>---".$mjson->metadata."????<br/>";
            $json = json_decode($mjson->metadata);
        }
        else
        {
            $json = json_decode($json_str);
            //echo "<br/>Loading the previous json NOT sucessfully";
        }
        
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
        
        if(isset($json->CIL_CCDB->CIL->CORE->NCBIORGANISMALCLASSIFICATION))
        {
            $ncbiJson = $json->CIL_CCDB->CIL->CORE->NCBIORGANISMALCLASSIFICATION;
            $ncbiJson=$outil->handleExistingOntoJSON($ncbiJson, "ncbi_organism", $ncbi);
            $json->CIL_CCDB->CIL->CORE->NCBIORGANISMALCLASSIFICATION=$ncbiJson;
            
        }
        else 
        {
            $ncbiJson = $outil->handleNewOntoJson("ncbi_organism", $ncbi);
            if(!is_null($ncbiJson))
            {
                $json->CIL_CCDB->CIL->CORE->NCBIORGANISMALCLASSIFICATION=$ncbiJson;
            }
        }
        
        
        $json_str = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        file_put_contents($test_output_folder."/test.json", $json_str);
        
        //$dbutil = new DB_util();
        //$dbutil->submitMetadata($image_id, $json_str);
        
        //redirect ($base_url."/image_metadata/edit/".$image_id);
        
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
        $dbutil = new DB_util();
        $gutil = new General_util();
        if(strcmp($image_id, "0") == 0)
        {
            show_404();
            return;
        }
        
        $json = $dbutil->getMetadata($image_id);
        if(!$json->success)
        {
            show_404();
            return;
        }
        else
        {
            if($gutil->startsWith($image_id, "CIL_"))
            {
                $data['numeric_id'] = str_replace("CIL_", "", $image_id);
            }
            $data['title'] = "CIL | Edit ".$image_id;
            //$data['data_json'] = $json;
            $data['image_id'] = $image_id;
            $mjson = json_decode($json->metadata);
            $data['json'] = $mjson;
            $this->load->view('templates/header', $data);
            $this->load->view('edit/edit_main', $data);
            $this->load->view('templates/footer', $data);
        }
    }
    
    /*
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
    */
    
}

