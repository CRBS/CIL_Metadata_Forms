<?php
include_once 'Curl_util.php';
include_once 'General_util.php';
include_once 'DB_util.php';
include_once 'Ontology_util.php';
include_once 'Dimension_util.php';
class Image_metadata extends CI_Controller
{
    public function test($image_id)
    {
        $dbutil = new DB_util();
        $json = $dbutil->getMetadata($image_id);
        //$json_str = json_encode($json);
        //echo $json_str;
        $array = array();
        $array['empty'] = true;
        
        header('Content-Type: application/json');
        if(!is_null($json) && isset($json->metadata))
            echo $json->metadata;
        else
            echo json_encode ($array);
    }
    
    public function clean($image_id="0")
    {
        $dbutil = new DB_util();
        $dbutil->submitMetadata($image_id, "");
        $this->load->helper('url');
        $base_url = $this->config->item('base_url');
        redirect ($base_url."/image_metadata/edit/".$image_id);
    }
    
    public function delete_field($image_id="0",$field="0",$input="0")
    {
        $input=str_replace("%20", " ", $input);
        $dbutil = new DB_util();
        $outil = new Ontology_util();
        $test_output_folder = $this->config->item('test_output_folder');
        $mjson = $dbutil->getMetadata($image_id);
        if(!$mjson->success)
        {
            show_404();
            return;
        }
        $this->load->helper('url');
        $base_url = $this->config->item('base_url');
        
        if($mjson->success && isset($mjson->metadata)
                && !is_null($mjson->metadata)
                && strlen(trim($mjson->metadata)) > 0
                )
        {

            $json = json_decode($mjson->metadata);
            $coreJson= $json->CIL_CCDB->CIL->CORE;
            foreach($coreJson as $key => $val) 
            {
                if(strcmp($key,$field) == 0)
                {
                    if(is_array($coreJson->{$key}))
                    {
                        $i = 0;
                        $removeIndex = null;
                        $jsonArray = $coreJson->{$key};
                        foreach($jsonArray as $item)
                        {
                            if(isset($item->onto_name))
                            {
                                if(strcmp($input,$item->onto_name)==0)
                                {
                                    //echo "<br/>".$item->onto_name;
                                    //unset($jsonArray[$i]);
                                    //break;
                                    $removeIndex = $i;
                                }
                            }
                            else if(isset($item->free_text))
                            {
                                if(strcmp($input,$item->free_text)==0)
                                {
                                    //echo "<br/>".$item->free_text;
                                    //unset($jsonArray[$i]);
                                    //break;
                                    $removeIndex = $i;
                                }
                            }
                            $i++;
                        }
                        if(!is_null($removeIndex))
                        {
                            unset($jsonArray[$removeIndex]);
                            $jsonArray=array_values ($jsonArray);
                        }
                        
                        $coreJson->{$key} = $jsonArray;
                        
                    }
                } 
            }
            //header('Content-Type: application/json');
            $json_str = json_encode($json,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            //echo $json_str;
            
             //file_put_contents($test_output_folder."/test.json", $json_str);
        
        
            $dbutil->submitMetadata($image_id, $json_str);
        
            redirect ($base_url."/image_metadata/edit/".$image_id);
        }
        
    }
    
    public function submit($image_id="0")
    {
        $dbutil = new DB_util();
        $outil = new Ontology_util();
        $mjson = $dbutil->getMetadata($image_id);
        
        if(!$mjson->success)
        {
            show_404();
            return;
        }

        $this->load->helper('url');
        $base_url = $this->config->item('base_url');
        $test_output_folder = $this->config->item('test_output_folder');
        $desc = $this->input->post('description', TRUE);
        $tech_details = $this->input->post('tech_details', TRUE);
        $ncbi = $this->input->post('image_search_parms[ncbi]', TRUE);
        $cell_type = $this->input->post('image_search_parms[cell_type]', TRUE);
        $cell_line = $this->input->post('image_search_parms[cell_line]', TRUE);
        $cellular_component = $this->input->post('image_search_parms[cellular_component]', TRUE);
        $biological_process = $this->input->post('image_search_parms[biological_process]', TRUE);
        $molecular_function = $this->input->post('image_search_parms[molecular_function]', TRUE);
        $imageType = $this->input->post('image_search_parms[item_type_bim]', TRUE);
        $imageMode = $this->input->post('image_search_parms[image_mode_bim]', TRUE);
        $visualMethod = $this->input->post('image_search_parms[visualization_methods_bim]', TRUE);
        $sourceContrast = $this->input->post('image_search_parms[source_of_contrast_bim]', TRUE);
        $intactCell = $this->input->post('image_search_parms[relation_to_intact_cell_bim]', TRUE);
        $processHistory = $this->input->post('image_search_parms[processing_history_bim]', TRUE);
        $preparation = $this->input->post('image_search_parms[preparation_bim]', TRUE);
        $imageParameter = $this->input->post('image_search_parms[parameter_imaged_bim]', TRUE);        
        //Dimensions
        $x_image_size = $this->input->post('x_image_size', TRUE);
        $y_image_size = $this->input->post('y_image_size', TRUE);
        $z_image_size = $this->input->post('z_image_size', TRUE);
        //Pixel size 
        $x_pixel_size = $this->input->post('x_pixel_size', TRUE);
        $y_pixel_size = $this->input->post('y_pixel_size', TRUE);
        $z_pixel_size = $this->input->post('z_pixel_size', TRUE);
        //Pixel unit
        $x_pixel_unit = $this->input->post('x_pixel_unit', TRUE);
        $y_pixel_unit = $this->input->post('y_pixel_unit', TRUE);
        $z_pixel_unit = $this->input->post('z_pixel_unit', TRUE);
        
        
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
        
        
        /***********Start NCBI *******************/
        if(!is_null($ncbi) && strlen(trim($ncbi)) > 0)
        {
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
        }
         /***********End NCBI *******************/
        
        
        /***********Start Cell Type *******************/
        if(!is_null($cell_type) && strlen(trim($cell_type)) > 0)
        {
            if(isset($json->CIL_CCDB->CIL->CORE->CELLTYPE))
            {
                $cellTypeJson = $json->CIL_CCDB->CIL->CORE->CELLTYPE;
                $cellTypeJson = $outil->handleExistingOntoJSON($cellTypeJson, "cell_types", $cell_type);
                $json->CIL_CCDB->CIL->CORE->CELLTYPE = $cellTypeJson;

            }
            else 
            {
                $cellTypeJson = $outil->handleNewOntoJson("cell_types", $cell_type);
                if(!is_null($cellTypeJson))
                {
                    $json->CIL_CCDB->CIL->CORE->CELLTYPE=$cellTypeJson;
                }
            }
        }
        /***********End Cell Type *******************/
        
        
        /***********Start Cell Line *******************/
        if(!is_null($cell_line) && strlen(trim($cell_line)) > 0)
        {
            if(isset($json->CIL_CCDB->CIL->CORE->CELLLINE))
            {
                $cellLineJson = $json->CIL_CCDB->CIL->CORE->CELLLINE;
                $cellLineJson = $outil->handleExistingOntoJSON($cellLineJson, "cell_lines", $cell_line);
                $json->CIL_CCDB->CIL->CORE->CELLLINE = $cellLineJson;

            }
            else 
            {
                $cellLineJson = $outil->handleNewOntoJson("cell_lines", $cell_line);
                if(!is_null($cellLineJson))
                {
                    $json->CIL_CCDB->CIL->CORE->CELLLINE=$cellLineJson;
                }
            }
        }
        /***********End Cell Line *******************/
        
        

        
        
        /***********Start CELLULAR COMPONENT *******************/
        if(!is_null($cellular_component) && strlen(trim($cellular_component)) > 0)
        {
            if(isset($json->CIL_CCDB->CIL->CORE->CELLULARCOMPONENT))
            {
                $cellCompJson = $json->CIL_CCDB->CIL->CORE->CELLULARCOMPONENT;
                $cellCompJson = $outil->handleExistingOntoJSON($cellCompJson, "cellular_components", $cellular_component);
                $json->CIL_CCDB->CIL->CORE->CELLULARCOMPONENT = $cellCompJson;

            }
            else 
            {
                $cellCompJson = $outil->handleNewOntoJson("cellular_components", $cellular_component);
                if(!is_null($cellCompJson))
                {
                    $json->CIL_CCDB->CIL->CORE->CELLULARCOMPONENT=$cellCompJson;
                }
            }
        }
        /***********End CELLULAR COMPONENT *******************/
        
        
        /***********Start Biological Process *******************/
        if(!is_null($biological_process) && strlen(trim($biological_process)) > 0)
        {
            if(isset($json->CIL_CCDB->CIL->CORE->BIOLOGICALPROCESS))
            {
                $bioProcessJson = $json->CIL_CCDB->CIL->CORE->BIOLOGICALPROCESS;
                $bioProcessJson = $outil->handleExistingOntoJSON($bioProcessJson, "biological_processes", $biological_process);
                $json->CIL_CCDB->CIL->CORE->BIOLOGICALPROCESS = $bioProcessJson;

            }
            else 
            {
                $bioProcessJson = $outil->handleNewOntoJson("biological_processes", $biological_process);
                if(!is_null($bioProcessJson))
                {
                    $json->CIL_CCDB->CIL->CORE->BIOLOGICALPROCESS=$bioProcessJson;
                }
            }
        }
        /***********End Biological Process *******************/
        
        /***********Start Molecular Function *******************/
        if(!is_null($molecular_function) && strlen(trim($molecular_function)) > 0)
        {
            if(isset($json->CIL_CCDB->CIL->CORE->MOLECULARFUNCTION))
            {
                $molFuncJson = $json->CIL_CCDB->CIL->CORE->MOLECULARFUNCTION;
                $molFuncJson = $outil->handleExistingOntoJSON($molFuncJson, "molecular_functions", $molecular_function);
                $json->CIL_CCDB->CIL->CORE->MOLECULARFUNCTION = $molFuncJson;

            }
            else 
            {
                $molFuncJson = $outil->handleNewOntoJson("molecular_functions", $molecular_function);
                if(!is_null($molFuncJson))
                {
                    $json->CIL_CCDB->CIL->CORE->MOLECULARFUNCTION=$molFuncJson;
                }
            }
        }
        /***********End Molecular Function *******************/
        
        /***********Start Image Type *******************/
        if(!is_null($imageType) && strlen(trim($imageType)) > 0)
        {
            
            if(isset($json->CIL_CCDB->CIL->CORE->ITEMTYPE))
            {
                $imageTypeJson = $json->CIL_CCDB->CIL->CORE->ITEMTYPE;
                $imageTypeJson = $outil->handleExistingOntoJSON($imageTypeJson, "imaging_methods", $imageType);
                $json->CIL_CCDB->CIL->CORE->ITEMTYPE = $imageTypeJson;

            }
            else 
            {
                $imageTypeJson = $outil->handleNewOntoJson("imaging_methods", $imageType);
                if(!is_null($imageTypeJson))
                {
                    $json->CIL_CCDB->CIL->CORE->ITEMTYPE=$imageTypeJson;
                }
            }
        }
        /***********End Image Type *******************/
        
        
        /***********Start Image Mode *******************/
        if(!is_null($imageMode) && strlen(trim($imageMode)) > 0)
        {
            
            if(isset($json->CIL_CCDB->CIL->CORE->IMAGINGMODE))
            {
                $imageModeJson = $json->CIL_CCDB->CIL->CORE->IMAGINGMODE;
                $imageModeJson = $outil->handleExistingOntoJSON($imageModeJson, "imaging_methods", $imageMode);
                $json->CIL_CCDB->CIL->CORE->ITEMTYPE = $imageModeJson;

            }
            else 
            {
                $imageModeJson = $outil->handleNewOntoJson("imaging_methods", $imageMode);
                if(!is_null($imageModeJson))
                {
                    $json->CIL_CCDB->CIL->CORE->IMAGINGMODE=$imageModeJson;
                }
            }
        }
        /***********End Image Mode *******************/
        
        
        /***********Start Visualization Method *******************/
        if(!is_null($visualMethod) && strlen(trim($visualMethod)) > 0)
        {
            
            if(isset($json->CIL_CCDB->CIL->CORE->VISUALIZATIONMETHODS))
            {
                $visualMethodJson = $json->CIL_CCDB->CIL->CORE->VISUALIZATIONMETHODS;
                $visualMethodJson = $outil->handleExistingOntoJSON($visualMethodJson, "imaging_methods", $visualMethod);
                $json->CIL_CCDB->CIL->CORE->VISUALIZATIONMETHODS = $visualMethodJson;

            }
            else 
            {
                $visualMethodJson = $outil->handleNewOntoJson("imaging_methods", $visualMethod);
                if(!is_null($visualMethodJson))
                {
                    $json->CIL_CCDB->CIL->CORE->VISUALIZATIONMETHODS = $visualMethodJson;
                }
            }
        }
        /***********End Visualization Method *******************/
        
        /***********Start Source of Contrast *******************/
        if(!is_null($sourceContrast) && strlen(trim($sourceContrast)) > 0)
        {
            
            if(isset($json->CIL_CCDB->CIL->CORE->SOURCEOFCONTRAST))
            {
                $sourceContrastJson = $json->CIL_CCDB->CIL->CORE->SOURCEOFCONTRAST;
                $sourceContrastJson = $outil->handleExistingOntoJSON($sourceContrastJson, "imaging_methods", $sourceContrast);
                $json->CIL_CCDB->CIL->CORE->SOURCEOFCONTRAST = $sourceContrastJson;

            }
            else 
            {
                $sourceContrastJson = $outil->handleNewOntoJson("imaging_methods", $sourceContrast);
                if(!is_null($sourceContrastJson))
                {
                    $json->CIL_CCDB->CIL->CORE->SOURCEOFCONTRAST = $sourceContrastJson;
                }
            }
        }
        /***********End Source of Contrast *******************/
        
        /***********Start Intact Cell *******************/
        if(!is_null($intactCell) && strlen(trim($intactCell)) > 0)
        {
            
            if(isset($json->CIL_CCDB->CIL->CORE->RELATIONTOINTACTCELL))
            {
                $intactCellJson = $json->CIL_CCDB->CIL->CORE->RELATIONTOINTACTCELL;
                $intactCellJson = $outil->handleExistingOntoJSON($intactCellJson, "imaging_methods", $intactCell);
                $json->CIL_CCDB->CIL->CORE->RELATIONTOINTACTCELL = $intactCellJson;

            }
            else 
            {
                $intactCellJson = $outil->handleNewOntoJson("imaging_methods", $intactCell);
                if(!is_null($intactCellJson))
                {
                    $json->CIL_CCDB->CIL->CORE->RELATIONTOINTACTCELL = $intactCellJson;
                }
            }
        }
        /***********End Intact Cell *******************/
        
        
        /***********Start Processing History *******************/
        if(!is_null($processHistory) && strlen(trim($processHistory)) > 0)
        {
            
            if(isset($json->CIL_CCDB->CIL->CORE->PROCESSINGHISTORY))
            {
                $processHistoryJson = $json->CIL_CCDB->CIL->CORE->PROCESSINGHISTORY;
                $processHistoryJson = $outil->handleExistingOntoJSON($processHistoryJson, "imaging_methods", $processHistory);
                $json->CIL_CCDB->CIL->CORE->PROCESSINGHISTORY = $processHistoryJson;

            }
            else 
            {
                $processHistoryJson = $outil->handleNewOntoJson("imaging_methods", $processHistory);
                if(!is_null($processHistoryJson))
                {
                    $json->CIL_CCDB->CIL->CORE->PROCESSINGHISTORY = $processHistoryJson;
                }
            }
        }
        /***********End Processing History *******************/
        
        
        /***********Start Preparation *******************/
        if(!is_null($preparation) && strlen(trim($preparation)) > 0)
        {
            if(isset($json->CIL_CCDB->CIL->CORE->PREPARATION))
            {
                $preparationJson = $json->CIL_CCDB->CIL->CORE->PREPARATION;
                $preparationJson = $outil->handleExistingOntoJSON($preparationJson, "imaging_methods", $preparation);
                $json->CIL_CCDB->CIL->CORE->PREPARATION = $preparationJson;

            }
            else 
            {
                $preparationJson = $outil->handleNewOntoJson("imaging_methods", $preparation);
                if(!is_null($preparationJson))
                {
                    $json->CIL_CCDB->CIL->CORE->PREPARATION = $preparationJson;
                }
            }
        }
        /***********End Preparation *******************/
        
        
        /***********Start Parameter Imaged *******************/
        if(!is_null($imageParameter) && strlen(trim($imageParameter)) > 0)
        {
            if(isset($json->CIL_CCDB->CIL->CORE->PARAMETERIMAGED))
            {
                $imageParameterJson = $json->CIL_CCDB->CIL->CORE->PARAMETERIMAGED;
                $imageParameterJson = $outil->handleExistingOntoJSON($imageParameterJson, "imaging_methods", $imageParameter);
                $json->CIL_CCDB->CIL->CORE->PARAMETERIMAGED = $imageParameterJson;
            }
            else 
            {
                $imageParameterJson = $outil->handleNewOntoJson("imaging_methods", $imageParameter);
                if(!is_null($imageParameterJson))
                {
                    $json->CIL_CCDB->CIL->CORE->PARAMETERIMAGED = $imageParameterJson;
                }
            }
        }
        /***********End Parameter Imaged *******************/
        
        $dim_util = new Dimension_util();
        /*********Start X size**************************/
        $json = $dim_util->handle_size("X", $json, $x_image_size);
        $json = $dim_util->handle_size("Y", $json, $y_image_size);
        $json = $dim_util->handle_size("Z", $json, $z_image_size);
        
        $json = $dim_util->handle_pixel("X", $json, $x_pixel_size, $x_pixel_unit);
        $json = $dim_util->handle_pixel("Y", $json, $y_pixel_size, $y_pixel_unit);
        $json = $dim_util->handle_pixel("Z", $json, $z_pixel_size, $z_pixel_unit);
        /*********End X size****************************/
        
        $json_str = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        file_put_contents($test_output_folder."/test.json", $json_str);
        
        
        $dbutil->submitMetadata($image_id, $json_str);
        
        redirect ($base_url."/image_metadata/edit/".$image_id);
        
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

