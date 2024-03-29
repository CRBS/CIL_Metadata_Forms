<?php
include_once 'Curl_util.php';
include_once 'General_util.php';
include_once 'DB_util.php';
include_once 'Ontology_util.php';
include_once 'Dimension_util.php';
include_once 'EZIDUtil.php';
include_once 'CILContentUtil.php';
class Image_metadata extends CI_Controller
{
    
    public function upload_cil_image($image_id)
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $base_url = $this->config->item('base_url');
        /***********Checking login****************/
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        /***********End Checking login****************/
        
        /***********Checking Permission************/
        $username = $data['username'];
        if(!$dbutil->isAdmin($username))
        {
            redirect ($base_url."/home");
            return;
        }
        /***********End Checking Permission************/
 
        
        
        $data['user_role'] = $dbutil->getUserRole($data['username']);
        
        
        $cutil= new Curl_util();
        $metadata_service_prefix = $this->config->item('metadata_service_prefix');
        $metadata_auth = $this->config->item('metadata_auth');
        $upload_location = $this->config->item('upload_location');
        $config2 = array(
        'upload_path' => $upload_location,
        'allowed_types' => "gif|jpg|png|jpeg",
        'overwrite' => TRUE,
        'max_size' => "12048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
        'max_height' => "4000",
        'max_width' => "4000"
        );
        $this->load->library('upload', $config2);
        $url = $metadata_service_prefix."/upload_image/".$image_id;
        
        if($this->upload->do_upload())
        {
            $img = array('upload_data' => $this->upload->data());
            if(!is_null($img))
            {
                //echo "<br/>".$img->upload_data->full_path;
                if(array_key_exists('upload_data',$img))
                {
                    $upload_metadata = $img['upload_data'];
                    if(array_key_exists('full_path',$upload_metadata))
                    {
                        $full_path = $upload_metadata['full_path'];
                        echo "<br/>". $full_path;
                        $bin = file_get_contents($full_path);
                        $hex = bin2hex($bin);
                        $response = $cutil->auth_curl_post($url, $metadata_auth, $hex);
                        echo "<br/>2nd upload URL:".$url;
                        echo "<br/>Response".$response;
                        
                    }
                   
                }
            }
        }
        else
        {
            $error = array('error' => $this->upload->display_errors());
            var_dump($error);
        }
    }
    
    public function test($image_id)
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $base_url = $this->config->item('base_url');
        /***********Checking login****************/
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        /***********End Checking login****************/
        
        /***********Checking Permission************/
        $username = $data['username'];
        if(!$dbutil->isAdmin($username))
        {
            redirect ($base_url."/home");
            return;
        }
        /***********End Checking Permission************/
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
        
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $base_url = $this->config->item('base_url');
        /***********Checking login****************/
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        /***********End Checking login****************/
        
        /***********Checking Permission************/
        $username = $data['username'];
        if(!$dbutil->isAdmin($username))
        {
            redirect ($base_url."/home");
            return;
        }
        /***********End Checking Permission************/
        $dbutil->submitMetadata($image_id, "");
        $this->load->helper('url');
        
        redirect ($base_url."/image_metadata/edit/".$image_id);
    }
    
    
    
    public function delete_attribution_by_index($image_id="0",$field="0",$removeIndex="0")
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $base_url = $this->config->item('base_url');
        /***********Checking login****************/
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        /***********End Checking login****************/
        
        /***********Checking Permission************/
        $username = $data['username'];
        if(!$dbutil->isAdmin($username))
        {
            redirect ($base_url."/home");
            return;
        }
        /***********End Checking Permission************/
        
        
        //$input=str_replace("%20", " ", $input);
        $dbutil = new DB_util();
        $test_output_folder = $this->config->item('test_output_folder');
        $mjson = $dbutil->getMetadata($image_id);
        
        $mjson_str = json_encode($mjson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        error_log($mjson_str, 3, $test_output_folder."/metadata.json");
        
        
        /*$tempArray=array();
        $tempArray['input']=$input;
        $tempJsonStr = json_encode($tempArray, JSON_UNESCAPED_SLASHES);
        $tempJson = json_decode($tempJsonStr);
        $input = $tempJson->input;*/
        
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
            
            $json_str = json_encode($json,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            if(file_exists($test_output_folder."/metadata.json"))
                unlink($test_output_folder."/metadata.json");
            error_log($json_str, 3, $test_output_folder."/metadata.json");
            
            
            
            $coreJson= $json->CIL_CCDB->CIL->CORE;
            //$json_str = json_encode($coreJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            //echo $json_str;
            //return;
            if(strcmp($field, "Contributors") == 0)
            {
                //error_log('In Contributors', 3, $test_output_folder."/delete.json");
                if(isset($coreJson->ATTRIBUTION->Contributors))
                {
                    $contributors = $coreJson->ATTRIBUTION->Contributors;
                    /*$removeIndex = null;
                    $i = 0;
                    foreach($contributors as $contributor)
                    {
                        if(strcmp($contributor, $input) == 0)
                        {
                            $removeIndex = $i;
                        }
                        
                        $i++;
                    }*/
                    
                    if(!is_null($removeIndex))
                    {
                        unset($contributors[$removeIndex]);
                        $coreJson->ATTRIBUTION->Contributors=array_values($contributors);
                    }
                }
            }
            else if(strcmp($field, "OTHER") == 0)
            {
                //echo '<br/>OTHER';
                //return;
           
                if(file_exists($test_output_folder."/delete.json"))
                    unlink ($test_output_folder."/delete.json");
                error_log("OTHER\n", 3, $test_output_folder."/delete.json");
                    
                    
                if(isset($coreJson->ATTRIBUTION->OTHER))
                {
                    error_log("OTHER2\n", 3, $test_output_folder."/delete.json");
                    $others = $coreJson->ATTRIBUTION->OTHER;
                    
                    $other_json_str = json_encode($others, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
                    //echo "<br/>".$other_json_str;
                    //return;
                    

                    /*foreach($others as $other)
                    {
                        
                        
                        error_log("OTHER:".$other."\n", 3, $test_output_folder."/delete.json");
                        error_log("Input:".$input."\n", 3, $test_output_folder."/delete.json");
                        //if(strcmp($other, $input) == 0)
                        if(true)
                        {
                            $removeIndex = $i;
                            
                        }
                        
                        $i++;
                    }*/
                    
                    if(!is_null($removeIndex))
                    {
                        //echo "<br/>RemoveIndex";
                        //return;
                        unset($others[$removeIndex]);
                        $coreJson->ATTRIBUTION->OTHER=array_values($others);
                    }
                }
            }
            else if(strcmp($field, "Attribution_url") == 0)
            {
                echo "<br/>Remove Attribution_url";
                $urls = $coreJson->ATTRIBUTION->URLs;
                if(is_null($urls))
                    $urls = array();
                //$removeIndex = null;
                $i = 0;
                
                /*foreach($urls as $url)
                {
                    if(strcmp($url->Label, $input) == 0)
                    {
                        $removeIndex = $i;
                    }
                    $i++;
                }*/
                echo "<br/>Remove index:".$removeIndex;
                if(!is_null($removeIndex))
                {
                    unset($urls[$removeIndex]);
                    $coreJson->ATTRIBUTION->URLs=array_values($urls);
                }
            }
            
            $json_str = json_encode($json,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            
            $dbutil->submitMetadata($image_id, $json_str);
            redirect ($base_url."/image_metadata/edit/".$image_id);
            
            //file_put_contents($test_output_folder."/".$image_id.".json", $json_str);
        }
    }
    
    
    public function delete_attribution($image_id="0",$field="0",$input="0")
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $base_url = $this->config->item('base_url');
        /***********Checking login****************/
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        /***********End Checking login****************/
        
        /***********Checking Permission************/
        $username = $data['username'];
        if(!$dbutil->isAdmin($username))
        {
            redirect ($base_url."/home");
            return;
        }
        /***********End Checking Permission************/
        
        
        $input=str_replace("%20", " ", $input);
        $dbutil = new DB_util();
        $test_output_folder = $this->config->item('test_output_folder');
        $mjson = $dbutil->getMetadata($image_id);
        
        
        error_log($mjson_str, 3, $test_output_folder."/metadata.json");
        
        
        /*$tempArray=array();
        $tempArray['input']=$input;
        $tempJsonStr = json_encode($tempArray, JSON_UNESCAPED_SLASHES);
        $tempJson = json_decode($tempJsonStr);
        $input = $tempJson->input;*/
        
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
            
            $json_str = json_encode($json,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            if(file_exists($test_output_folder."/metadata.json"))
                unlink($test_output_folder."/metadata.json");
            error_log($json_str, 3, $test_output_folder."/metadata.json");
            
            
            $coreJson= $json->CIL_CCDB->CIL->CORE;
            
            if(strcmp($field, "Contributors") == 0)
            {
                //error_log('In Contributors', 3, $test_output_folder."/delete.json");
                if(isset($coreJson->ATTRIBUTION->Contributors))
                {
                    $contributors = $coreJson->ATTRIBUTION->Contributors;
                    $removeIndex = null;
                    $i = 0;
                    foreach($contributors as $contributor)
                    {
                        if(strcmp($contributor, $input) == 0)
                        {
                            $removeIndex = $i;
                        }
                        
                        $i++;
                    }
                    
                    if(!is_null($removeIndex))
                    {
                        unset($contributors[$removeIndex]);
                        $coreJson->ATTRIBUTION->Contributors=array_values($contributors);
                    }
                }
            }
            else if(strcmp($field, "OTHER") == 0)
            {
                if(file_exists($test_output_folder."/delete.json"))
                    unlink ($test_output_folder."/delete.json");
                error_log("OTHER\n", 3, $test_output_folder."/delete.json");
                    
                    
                if(isset($coreJson->ATTRIBUTION->OTHER))
                {
                    error_log("OTHER2\n", 3, $test_output_folder."/delete.json");
                    $others = $coreJson->ATTRIBUTION->OTHER;
                    $removeIndex = null;
                    $i = 0;
                    foreach($others as $other)
                    {
                        
                        
                        error_log("OTHER:".$other."\n", 3, $test_output_folder."/delete.json");
                        error_log("Input:".$input."\n", 3, $test_output_folder."/delete.json");
                        //if(strcmp($other, $input) == 0)
                        if(true)
                        {
                            $removeIndex = $i;
                            
                        }
                        
                        $i++;
                    }
                    
                    if(!is_null($removeIndex))
                    {
                        unset($others[$removeIndex]);
                        $coreJson->ATTRIBUTION->OTHER=array_values($others);
                    }
                }
            }
            else if(strcmp($field, "Attribution_url") == 0)
            {
                $urls = $coreJson->ATTRIBUTION->URLs;
                if(is_null($urls))
                    $urls = array();
                $removeIndex = null;
                $i = 0;
                
                foreach($urls as $url)
                {
                    if(strcmp($url->Label, $input) == 0)
                    {
                        $removeIndex = $i;
                    }
                    $i++;
                }
                
                if(!is_null($removeIndex))
                {
                    unset($urls[$removeIndex]);
                    $coreJson->ATTRIBUTION->URLs=array_values($urls);
                }
            }
            
            $json_str = json_encode($json,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            //file_put_contents($test_output_folder."/".$image_id.".json", $json_str);
            $dbutil->submitMetadata($image_id, $json_str);
            redirect ($base_url."/image_metadata/edit/".$image_id);
        }
    }
    
    public function delete_field($image_id="0",$field="0",$input="0")
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $base_url = $this->config->item('base_url');
        /***********Checking login****************/
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        /***********End Checking login****************/
        
        /***********Checking Permission************/
        $username = $data['username'];
        if(!$dbutil->isAdmin($username))
        {
            redirect ($base_url."/home");
            return;
        }
        /***********End Checking Permission************/
        $input=str_replace("%20", " ", $input);
        $input= str_replace("_single_quote_", "'", $input);
        $input= str_replace("_COMMA_", ",", $input);
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
                        //$removeIndex = 0;
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
            
            //file_put_contents($test_output_folder."/".$image_id.".json", $json_str);
        
        
            $dbutil->submitMetadata($image_id, $json_str);
        
            redirect ($base_url."/image_metadata/edit/".$image_id);
        }
        
    }
    
    
    
    public function delete_field_by_index($image_id="0",$field="0",$index="0")
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $base_url = $this->config->item('base_url');
        
        $index = intval($index);
        /***********Checking login****************/
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        /***********End Checking login****************/
        
        /***********Checking Permission************/
        $username = $data['username'];
        if(!$dbutil->isAdmin($username))
        {
            redirect ($base_url."/home");
            return;
        }
        /***********End Checking Permission************/

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
                        
                        $removeIndex = $index;
                        $jsonArray = $coreJson->{$key};
                        
                        //$removeIndex = 0;
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
            
            //file_put_contents($test_output_folder."/".$image_id.".json", $json_str);
        
        
            $dbutil->submitMetadata($image_id, $json_str);
        
            redirect ($base_url."/image_metadata/edit/".$image_id);
        }
        
    }

    
    private function updateJpegZipSize($image_id, $json, $jpeg_size, $zip_size)
    {
        //echo "in updateJpegZipSize";
        $id = str_replace("CIL_", "", $image_id);
        if(is_numeric($id))
            $id = intval($id);
        
        $itemArray = array();
        $itemArray['Mime_type'] = "image/jpeg; charset=utf-8";
        $itemArray['File_type'] = "Jpeg";
        $itemArray['File_path'] = $id.".jpg";
        $itemArray['Size'] = intval($jpeg_size);
        $ijson_str = json_encode($itemArray, JSON_UNESCAPED_SLASHES);
        //echo "<br/>".$ijson_str;
        $ijson = json_decode($ijson_str);
        array_push($json->CIL_CCDB->CIL->Image_files,$ijson);
        
        
        $itemArray = array();
        $itemArray['Mime_type'] = "application/zip";
        $itemArray['File_type'] = "Zip";
        $itemArray['File_path'] = $id.".zip";
        $itemArray['Size'] = intval($zip_size);
        //echo "<br/>".intval($zip_size);
        $ijson_str = json_encode($itemArray, JSON_UNESCAPED_SLASHES);
        $ijson = json_decode($ijson_str);
        array_push($json->CIL_CCDB->CIL->Image_files,$ijson);
        //echo "<br/>after updateJpegZipSize";
        //echo json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        
        return $json;
    }
    
    public function submit($image_id="0")
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $cutil = new Curl_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $base_url = $this->config->item('base_url');
        /***********Checking login****************/
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        /***********End Checking login****************/
        
        /***********Checking Permission************/
        $username = $data['username'];
        if(!$dbutil->isAdmin($username))
        {
            redirect ($base_url."/home");
            return;
        }
        /***********End Checking Permission************/
        $outil = new Ontology_util();
        $mjson = $dbutil->getMetadata($image_id);
        
        if(!$mjson->success)
        {
            show_404();
            return;
        }

        
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
        
        $jpeg_size = $this->input->post('jpeg_size', TRUE); 
        $zip_size = $this->input->post('zip_size', TRUE); 
        $tiff_size = $this->input->post('tiff_size', TRUE); 
        /**************Biological Context**************************************************/
        $human_disease = $this->input->post('image_search_parms[human_disease]', TRUE); 
        
        /**************End Biological Context*********************************************/
        $alz_neuropathologist = $this->input->post('alz_neuropathologist', TRUE); 
        $alz_embedded_sample = $this->input->post('alz_embedded_sample', TRUE);
        
        if(!is_null($alz_neuropathologist))
        {
            $alz_neuropathologist = trim($alz_neuropathologist);
            //echo "<br/>".$alz_neuropathologist;
        }
        
        if(!is_null($alz_embedded_sample))
        {
            $alz_embedded_sample = trim($alz_embedded_sample);
            //echo "<br/>".$alz_embedded_sample;
        }
        
        
        
        /**************Alz metadata *****************************************************/
        
        
        /**************End Alz metadata ************************************************/
        
        
        
        $still_image = $this->input->post('still_image', TRUE);
        $z_stack = $this->input->post('z_stack', TRUE);
        $time_series = $this->input->post('time_series', TRUE);
        $video = $this->input->post('video', TRUE);
        
        /*
        if(!is_null($time_series))
            echo "Time series is NOT NULL";
        else
            echo "Time series is  NULL";
        echo "<br/>Video:".$video;
        return;
         */
        
        /*************Attribution*******************************************/
        $attribution_name = $this->input->post('attribution_name', TRUE);
        $attribution_url_label = $this->input->post('attribution_url_label', TRUE);
        $attribution_url = $this->input->post('attribution_url', TRUE);
        $attribution_other = $this->input->post('attribution_other', TRUE);
        //$attribution_other=str_replace("'", "&#8217;", $attribution_other);
        
        //echo "Other:".$attribution_other;
        //return;
        /*************End Attribution**************************************/
        
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
        
        
        $citation_title = $this->input->post('citation_title', TRUE);
        
        $group_check = $this->input->post('group_check', TRUE);
        
        //echo $tech_details;
        //return;
        
        
        $data_type_str = "\"Data_type\": {".
                        "\"Time_series\": false, ".
                        "\"Still_image\": false, ".
                        "\"Z_stack\": false, ".
                        "\"Video\": false ".
                        "}";
        
        $json = NULL;
        //$json_str = "{\"CIL_CCDB\": {\"Status\": {\"Deleted\": false,\"Is_public\": true }, \"Data_type\":{},   \"CIL\":{\"CORE\":{\"IMAGEDESCRIPTION\":{  }}}}}";
        $json_str = "{\"CIL_CCDB\": {\"Status\": {\"Deleted\": false,\"Is_public\": true }, ".$data_type_str.",   \"CIL\":{\"CORE\":{\"IMAGEDESCRIPTION\":{  }}}}}";
        if($mjson->success && isset($mjson->metadata)
                && !is_null($mjson->metadata)
                && strlen(trim($mjson->metadata)) > 0
                )
        {
            //echo "<br/>Loading the previous json sucessfully";
            //echo "<br/><br/>---".$mjson->metadata."????<br/>";
            $json = json_decode($mjson->metadata);
            
            //if(is_null($json))
            //{
            //    echo "<br/>JSON is NULL";
            //}
        }
        else
        {
            $json = json_decode($json_str);
            //echo "<br/>Loading the previous json NOT sucessfully";

        }
        
        
        
        //$json_str = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        //echo $json_str;
        //return;
        
        $json->CIL_CCDB->CIL->Image_files = array();
        $json = $this->updateJpegZipSize($image_id, $json, $jpeg_size,$zip_size);
        
        

        
        
        //if(!is_null($zip_size))
          //  $json = $this->updateZipSize($image_id, $json, $zip_size);
        
        if(!is_null($desc) && strlen(trim($desc)) > 0)
        {
            $desc = trim($desc);
            if(isset($json->CIL_CCDB->CIL->CORE->IMAGEDESCRIPTION))
                $json->CIL_CCDB->CIL->CORE->IMAGEDESCRIPTION->free_text = $desc;
        }
        
        if(!is_null($tech_details) && strlen(trim($tech_details)) >0)
        {
            $tech_details = trim($tech_details);
            //$tech_details = str_replace("%", "&#37;", $tech_details);
            //echo $tech_details;
            //return;
            $darray = array();
            $darray['free_text'] =  ($tech_details);
            //echo "<br/>".$tech_details;
            $djson_str = json_encode($darray );
           
            //header('Content-Type: application/json');
            //echo $djson_str;
            //return;
            
            
            $djson = json_decode($djson_str);
            $json->CIL_CCDB->CIL->CORE->TECHNICALDETAILS = $djson;
        }
        
        /*
        //Debug
        header('Content-Type: application/json');
        $json_str = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        echo $json_str;
        return;
         * 
         */
        
        /***************GROUP************/
     
        if(!is_null($group_check))
        {
            $group_id = $dbutil->getGroupId($image_id);
            if(!is_null($group_id))
            {
                $json->CIL_CCDB->CIL->CORE->GROUP_ID = $group_id;
            }
            //echo "GROUP checked:".$group_id."---";
        
            //return;
        }
        else
        {
            unset($json->CIL_CCDB->CIL->CORE->GROUP_ID);
            //echo "GROUP not checked";
            //return;
            
        }
        //return;
        /***************End group**********/
        
        
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
        
        /************Attribution URL**************************************/
        if(!is_null($attribution_url_label) && strlen($attribution_url_label) > 0 
                && !is_null($attribution_url) && strlen($attribution_url))
        {
            if(!isset($json->CIL_CCDB->CIL->CORE->ATTRIBUTION->URLs) ||  !is_array($json->CIL_CCDB->CIL->CORE->ATTRIBUTION->URLs))
            {
                $json->CIL_CCDB->CIL->CORE->ATTRIBUTION->URLs = array();
            }

            $attr_url = array();
            $attr_url['Label'] = $attribution_url_label;
            $attr_url['Href'] = $attribution_url;
            $url_json_str = json_encode($attr_url);
            $url_json = json_decode($url_json_str);
            array_push($json->CIL_CCDB->CIL->CORE->ATTRIBUTION->URLs, $url_json);
        }
        /************End Attribution URL*********************************/
        
        /************Human Disease**************************/
        if(!is_null($human_disease) && strlen(trim($human_disease)) > 0)
        {
            if(isset($json->CIL_CCDB->CIL->CORE->HUMAN_DISEASE))
            {
                $humanDiseaseJson = $json->CIL_CCDB->CIL->CORE->HUMAN_DISEASE;
                $humanDiseaseJson = $outil->handleExistingOntoJSON($humanDiseaseJson,"human_diseases",$human_disease);
                $json->CIL_CCDB->CIL->CORE->HUMAN_DISEASE = $humanDiseaseJson;
            }
            else
            {
                $humanDiseaseJson = $outil->handleNewOntoJson("human_diseases", $human_disease);
                if(!is_null($humanDiseaseJson))
                {
                    $json->CIL_CCDB->CIL->CORE->HUMAN_DISEASE=$humanDiseaseJson;
                }
            }
        }
        /************End Human Disease**********************/
        
        
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
                $json->CIL_CCDB->CIL->CORE->IMAGINGMODE = $imageModeJson;

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
        
        /***********Alz metadata **************************/
        $alzArray = array();
        $hasAlzData = false;
        if(!is_null($alz_neuropathologist) && strlen($alz_neuropathologist) > 0)
        {
            $alzArray['NEUROPATHOLOGIST'] = $alz_neuropathologist;
            $hasAlzData = true;
        }
        
        if(!is_null($alz_embedded_sample) && strlen($alz_embedded_sample) > 0)
        {
            $alzArray['EMBEDDED_SAMPLE'] = $alz_embedded_sample;
            $hasAlzData = true;
        }
        
        if($hasAlzData)
        {
            $alz_json_str = json_encode($alzArray);
            $alz_json = json_decode($alz_json_str); 
            
            $json->CIL_CCDB->CIL->ALZHEIMER_METADATA = $alz_json;
        }
        else 
        {
            unset($json->CIL_CCDB->CIL->ALZHEIMER_METADATA);
        }
        
        /***********End Alz metadata **************************/
        
        /***********Attribution name***************************/
        if(!is_null($attribution_name) && strlen(trim($attribution_name))>0)
        {
            //echo "<br/>Attribution:".$attribution_name;
            $name_array = array();
            if(isset($json->CIL_CCDB->CIL->CORE->ATTRIBUTION->Contributors))
            {
                $name_array = $json->CIL_CCDB->CIL->CORE->ATTRIBUTION->Contributors;      
            }
            array_push($name_array, $attribution_name);
            $json->CIL_CCDB->CIL->CORE->ATTRIBUTION->Contributors = $name_array;
            
        }
        /***********End Attribution name**********************/
        
        
        /***********Attribution other***************************/
        if(!is_null($attribution_other) && strlen(trim($attribution_other))>0)
        {
            
            $other_array = array();
            if(isset($json->CIL_CCDB->CIL->CORE->ATTRIBUTION->OTHER))
            {
                $other_array = $json->CIL_CCDB->CIL->CORE->ATTRIBUTION->OTHER;      
            }
            array_push($other_array, $attribution_other);
            $json->CIL_CCDB->CIL->CORE->ATTRIBUTION->OTHER = $other_array;
            
        }
        /***********End Attribution name**********************/
        
        
        /**********Data type*********************************/
        if(!is_null($still_image))
            $json->CIL_CCDB->Data_type->Still_image = true;
        else 
            $json->CIL_CCDB->Data_type->Still_image = false;
        
       if(!is_null($z_stack))
            $json->CIL_CCDB->Data_type->Z_stack = true;
       else 
            $json->CIL_CCDB->Data_type->Z_stack = false;
       
       if(!is_null($time_series))
           $json->CIL_CCDB->Data_type->Time_series = true;
       else 
           $json->CIL_CCDB->Data_type->Time_series = false;
       
       if(!is_null($video))
           $json->CIL_CCDB->Data_type->Video = true;
       else
           $json->CIL_CCDB->Data_type->Video = false;
       /**********End Data type*********************************/
       
       /***********Image files****************************/
       
       //$json = $this->updateJpegZipSize($image_id, $json, $jpeg_size,$zip_size);
        if(isset($json->CIL_CCDB->Data_type->Video) && $json->CIL_CCDB->Data_type->Video)
        {
            $json->CIL_CCDB->CIL->Image_files = array();
            $numeric_id = str_replace("CIL_", "", $image_id);
            $i_item1_str = "{".
                    "\"Mime_type\": \"application/zip\",".
                    "\"File_type\": \"Zip\",".
                    "\"File_path\": \"".$numeric_id.".zip\",".
                    //"\"Size\": 15659136"
                    "\"Size\": ".$zip_size.
                    "}";
            
            $i_item2_str = "{".
                    "\"Mime_type\": \"image/jpeg; charset=utf-8\",".
                    "\"File_type\": \"Jpeg\",".
                    "\"File_path\": \"".$numeric_id.".jpg\",".
                    //"\"Size\": 116024".
                    "\"Size\": ".$jpeg_size.
                    "}";
            
            /* $i_item3_str = "{".
                    "\"Mime_type\": \"video/x-flv\",".
                    "\"File_type\": \"Flv\",".
                    "\"File_path\": \"".$numeric_id.".flv\",".
                    "\"Size\": 1392086".
                    "}"; */
            
            $filePath = "/var/www/html/media/videos/".$numeric_id."/".$numeric_id."_web.mp4"; //Remote file path
            $metadata_service_prefix = $this->config->item('metadata_service_prefix');
            $metadata_auth = $this->config->item('metadata_auth');
            $size_url = str_replace("metadata_service", "rest/file_size", $metadata_service_prefix);
            $sresponse = $cutil->auth_curl_get_with_data($metadata_auth, $size_url, $filePath);
            $sjson = json_decode($sresponse);
            //echo    $sjson->Size;
            //return;
            
            $i_item3_str = "{".
                    "\"Mime_type\": \"video/mp4\",".
                    "\"File_type\": \"Mp4\",".
                    "\"File_path\": \"".$numeric_id."_web.mp4\",".
                    //"\"Size\": 1392086".
                    "\"Size\": ".$sjson->Size.
                    "}";
            
            
            
            $i_item1 = json_decode($i_item1_str);
            $i_item2 = json_decode($i_item2_str);
            $i_item3 = json_decode($i_item3_str);
            
            $i_array = array();
            array_push($i_array, $i_item1);
            array_push($i_array, $i_item2);
            array_push($i_array, $i_item3);
            
            $json->CIL_CCDB->CIL->Image_files = $i_array;
        }
        

        /*
        if(isset($json->CIL_CCDB->Data_type->Still_image) && $json->CIL_CCDB->Data_type->Still_image)
        {
            $json->CIL_CCDB->CIL->Image_files = array();
            $numeric_id = str_replace("CIL_", "", $image_id);
            $i_item1_str = NULL;
            $i_item2_str = NULL;
            $i_item3_str = NULL;
            if(!is_null($zip_size) && is_numeric($zip_size))
            {
                $i_item1_str = "{".
                        "\"Mime_type\": \"application/zip\",".
                        "\"File_type\": \"Zip\",".
                        "\"File_path\": \"".$numeric_id.".zip\",".
                        "\"Size\": ".$zip_size.
                        "}";
            }
            
            if(!is_null($jpeg_size) && is_numeric($jpeg_size))
            {
                $i_item2_str = "{".
                        "\"Mime_type\": \"image/jpeg; charset=utf-8\",".
                        "\"File_type\": \"Jpeg\",".
                        "\"File_path\": \"".$numeric_id.".jpg\",".
                        "\"Size\": ".$jpeg_size.
                        "}";
            }
            
            if(!is_null($tiff_size) && is_numeric($tiff_size))
            {
                $i_item3_str = "{".
                        "\"Mime_type\": \"image/tif\",".
                        "\"File_type\": \"OME_tif\",".
                        "\"File_path\": \"".$numeric_id.".tif\",".
                        "\"Size\": ".$tiff_size.
                        "}";
            }
            $i_array = array();
            if(!is_null($i_item1_str))
            {
                $i_item1 = json_decode($i_item1_str);
                 array_push($i_array, $i_item1);
            }
            if(!is_null($i_item2_str))
            {
                $i_item2 = json_decode($i_item2_str);
                array_push($i_array, $i_item2);
            }
            if(!is_null($i_item3_str))
            {
                $i_item3 = json_decode($i_item3_str);
                array_push($i_array, $i_item3);
            }
            
            
           
            
            
            
            $json->CIL_CCDB->CIL->Image_files = $i_array;
        }*/
        /***********End Image files****************************/

        
        /***********Licensing*********************************/
        $public_domain = $this->input->post('public_domain', TRUE);
        $attribution_cc = $this->input->post('attribution_cc', TRUE);
        $attribution_nc_sa = $this->input->post('attribution_nc_sa', TRUE);
        $copyright = $this->input->post('copyright', TRUE);
        
        if(!is_null($public_domain))
           $json->CIL_CCDB->CIL->CORE->TERMSANDCONDITIONS->free_text = "public_domain";
        if(!is_null($attribution_cc))
           $json->CIL_CCDB->CIL->CORE->TERMSANDCONDITIONS->free_text = "attribution_cc_by";
        if(!is_null($attribution_nc_sa))
           $json->CIL_CCDB->CIL->CORE->TERMSANDCONDITIONS->free_text = "attribution_nc_sa";
        if(!is_null($copyright))
           $json->CIL_CCDB->CIL->CORE->TERMSANDCONDITIONS->free_text = "copyright";
       /************End licensing*********************************/
        
        
       $json->CIL_CCDB->Status->Is_public = true;
        
        $dim_util = new Dimension_util();
        /*********Start X size**************************/
        $json = $dim_util->handle_size("X", $json, $x_image_size);
        $json = $dim_util->handle_size("Y", $json, $y_image_size);
        $json = $dim_util->handle_size("Z", $json, $z_image_size);
        
        $json = $dim_util->handle_pixel("X", $json, $x_pixel_size, $x_pixel_unit);
        $json = $dim_util->handle_pixel("Y", $json, $y_pixel_size, $y_pixel_unit);
        $json = $dim_util->handle_pixel("Z", $json, $z_pixel_size, $z_pixel_unit);
        /*********End X size****************************/
        
        
        /*********Citation title************************/
        if(!is_null($citation_title) && isset($json->CIL_CCDB->Citation->Title))
        {
            $citation_title = trim($citation_title);
            $json->CIL_CCDB->Citation->Title = $citation_title;
            //echo "<br/>Setting";
            //echo $json->CIL_CCDB->Citation->Title;
            //return;
        }
        else
        {
            //echo "Not setting";
            //return;
        }
        
        /*********End Citation title************************/
        
        $json_str = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES  );
        //file_put_contents($test_output_folder."/".$image_id.".json", $json_str);
        //echo $json_str;
        //return;
        
        $dbutil->submitMetadata($image_id, $json_str);
        redirect ($base_url."/image_metadata/edit/".$image_id);
        //header('Content-Type: application/json');
        //echo $json_str;
        
        
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
    
    
    public function delete_db_image($image_id="0")
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $base_url = $this->config->item('base_url');
        /***********Checking login****************/
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        /***********End Checking login****************/
        
        /***********Checking Permission************/
        $username = $data['username'];
        if(!$dbutil->isAdmin($username))
        {
            redirect ($base_url."/home");
            return;
        }
        /***********End Checking Permission************/
        $gutil = new General_util();
        $cutil = new Curl_util();
        if(strcmp($image_id, "0") == 0)
        {
            show_404();
            return;
        }

        
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
            redirect ($base_url."/login/auth_image/".$image_id);
        
        $json = $dbutil->getMetadata($image_id);
        if(!$json->success)
        {
            show_404();
            return;
        }
        
        $dbutil->updateImageDeleteTime($image_id);
        
        $elasticsearch_host_stage = $this->config->item('elasticsearch_host_stage');    
        $esUrl = $elasticsearch_host_stage."/ccdbv8/data/".$image_id;
        $ejson_str = $cutil->curl_get($esUrl);
        $ejson = json_decode($ejson_str);
        if(!is_null($ejson) && isset($ejson->found) && $ejson->found)
        {
            $this->delete_es_image($image_id);
                
        }
        
        redirect ($base_url."/home");

    }
    
    
    public function delete_es_image_prod($image_id='0')
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $base_url = $this->config->item('base_url');
        /***********Checking login****************/
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        /***********End Checking login****************/
        
        /***********Checking Permission************/
        $username = $data['username'];
        if(!$dbutil->isAdmin($username))
        {
            redirect ($base_url."/home");
            return;
        }
        /***********End Checking Permission************/
        $gutil = new General_util();
        $cutil = new Curl_util();
        if(strcmp($image_id, "0") == 0)
        {
            show_404();
            return;
        }
        
        
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
            redirect ($base_url."/login/auth_image/".$image_id);
        
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
            $data['staging_website_prefix'] = $this->config->item('staging_website_prefix');
            $data['elasticsearch_host_prod'] = $this->config->item('elasticsearch_host_prod');
            $esUrl = $data['elasticsearch_host_prod']."/ccdbv8/data/".$image_id;
            $ejson_str = $cutil->curl_get($esUrl);
            $ejson = json_decode($ejson_str);
            
            //echo $esUrl;
            if(!is_null($ejson) && isset($ejson->found) && $ejson->found)
            {
               $cutil->just_curl_delete($esUrl);
               $dbutil->unpublish($image_id);
            }
        }
        
        redirect($base_url."/image_metadata/edit/".$image_id);
    }
    
    public function delete_es_image($image_id="0")
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $base_url = $this->config->item('base_url');
        /***********Checking login****************/
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        /***********End Checking login****************/
        
        /***********Checking Permission************/
        $username = $data['username'];
        if(!$dbutil->isAdmin($username))
        {
            redirect ($base_url."/home");
            return;
        }
        /***********End Checking Permission************/
        $gutil = new General_util();
        $cutil = new Curl_util();
        if(strcmp($image_id, "0") == 0)
        {
            show_404();
            return;
        }

        
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
            redirect ($base_url."/login/auth_image/".$image_id);
        
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
            $data['staging_website_prefix'] = $this->config->item('staging_website_prefix');
            $data['elasticsearch_host_stage'] = $this->config->item('elasticsearch_host_stage');
            $esUrl = $data['elasticsearch_host_stage']."/ccdbv8/data/".$image_id;
            $ejson_str = $cutil->curl_get($esUrl);
            $ejson = json_decode($ejson_str);
            
            //echo $esUrl;
            if(!is_null($ejson) && isset($ejson->found) && $ejson->found)
            {
               $cutil->just_curl_delete($esUrl);
               $dbutil->unpublish($image_id);
            }
        }
        
        redirect($base_url."/image_metadata/edit/".$image_id);
    }
    
    
    public function publish_data_prod($image_id="0")
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $base_url = $this->config->item('base_url');
        /***********Checking login****************/
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        /***********End Checking login****************/
        
        /***********Checking Permission************/
        $username = $data['username'];
        if(!$dbutil->isAdmin($username))
        {
            redirect ($base_url."/home");
            return;
        }
        /***********End Checking Permission************/
        $gutil = new General_util();
        $cutil = new Curl_util();
        if(strcmp($image_id, "0") == 0)
        {
            show_404();
            return;
        }
        
        
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
            redirect ($base_url."/login/auth_image/".$image_id);
        
        $json = $dbutil->getMetadata($image_id);
        if(!$json->success)
        {
            show_404();
            return;
        }
        else if(isset($json->metadata))
        {
            
            $json_str = $json->metadata;
            $mjson = json_decode($json_str);
            $mjson->CIL_CCDB->Status->Publish_time = time();
            $json_str = json_encode($mjson, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
           
            if($gutil->startsWith($image_id, "CIL_"))
            {
                $data['numeric_id'] = str_replace("CIL_", "", $image_id);
            }
            $data['title'] = "CIL | Edit ".$image_id;
            $data['staging_website_prefix'] = $this->config->item('staging_website_prefix');
            $data['elasticsearch_host_prod'] = $this->config->item('elasticsearch_host_prod');
            $esUrl = $data['elasticsearch_host_prod']."/ccdbv8/data/".$image_id;
            //echo $esUrl."<br/><br/>";
            //echo $json_str;

            $response = $cutil->just_curl_put($esUrl, $json_str);
            //echo $response;
            //redirect($data['staging_website_prefix']."/images/".$image_id);
            redirect($base_url."/image_metadata/edit/".$image_id);
        }
        else
        {
            redirect($base_url."/image_metadata/edit/".$image_id);
        }
    }
    
    
    public function view_doi($image_id="0")
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $base_url = $this->config->item('base_url');
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $base_url = $this->config->item('base_url');
        /***********Checking login****************/
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        /***********End Checking login****************/
        
        /***********Checking Permission************/
        $username = $data['username'];
        if(!$dbutil->isAdmin($username))
        {

            redirect ($base_url."/home");
            return;
        }
        /***********End Checking Permission************/
        $gutil = new General_util();
        $cutil = new Curl_util();
        $ezutil = new EZIDUtil();
        if(strcmp($image_id, "0") == 0)
        {
            show_404();
            return;
        }
        
        
        
        $data['debug'] = $this->input->get('debug', TRUE);
        
        $login_hash = $this->session->userdata('login_hash');
        $username = $this->session->userdata('username');
        $data['username'] = $username;
        $data['user_role'] = $dbutil->getUserRole($username);
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        $data['numeric_id'] = str_replace("CIL_", "", $image_id);
        $cilUtil = new CILContentUtil();
        $ezid_production_shoulder = $this->config->item('ezid_production_shoulder');
        $ezid_production_ark_shoulder = $this->config->item('ezid_production_ark_shoulder');
        $targetDoi = $ezid_production_shoulder."CIL".$data['numeric_id'];
        $ezMessage = $ezutil->getDoiInfo($targetDoi);
        
        $data['title'] = "View the DOI information";
        $data['targetDoi'] = $targetDoi;
        $data['ezMessage'] = $ezMessage;
        $this->load->view('templates/header', $data);
        $this->load->view('edit/view_doi_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function create_doi($image_id="0")
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $base_url = $this->config->item('base_url');
        /***********Checking login****************/
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        /***********End Checking login****************/
        
        /***********Checking Permission************/
        $username = $data['username'];
        if(!$dbutil->isAdmin($username))
        {
            redirect ($base_url."/home");
            return;
        }
        /***********End Checking Permission************/
        $data['numeric_id'] = str_replace("CIL_", "", $image_id);
        $dbutil = new DB_util();
        $gutil = new General_util();
        $cutil = new Curl_util();
        $ezutil = new EZIDUtil();
        if(strcmp($image_id, "0") == 0)
        {
            show_404();
            return;
        }
        
        
        
        $data['debug'] = $this->input->get('debug', TRUE);
        
        $login_hash = $this->session->userdata('login_hash');
        $username = $this->session->userdata('username');
        $data['username'] = $username;
        $data['user_role'] = $dbutil->getUserRole($username);
        
        
        $json = $dbutil->getMetadata($image_id);
        $mjson = json_decode($json->metadata);
        
        /****************Saving the DOI Info*************************************/
        
            
        $doiPostfixId = str_replace("_", "", $image_id);
        //$filePath = "C:/Users/wawong/Desktop/".$data['numeric_id']."_log.txt";
        //error_log("\n".$doiPostfixId,3,$filePath);
        $cilUtil = new CILContentUtil();
        $ezid_production_shoulder = $this->config->item('ezid_production_shoulder');
        $ezid_production_ark_shoulder = $this->config->item('ezid_production_ark_shoulder');
        $ezid_auth = $this->config->item('ezid_auth');
        $targetDoi = $ezid_production_shoulder."CIL".$data['numeric_id'];
        $ezMessage = $ezutil->getDoiInfo($targetDoi);

        
        //echo "Message:-----".$ezMessage;
        //return;
        
        
        $citation = $cilUtil->getCitationInfo($mjson, $data['numeric_id'], date("Y"));
            $ezMetadata =  $cilUtil->getEzIdMetadata($mjson,$data['numeric_id'],date("Y"));
            echo "<br/>".$ezMetadata;
            $ezJson = $ezutil->createDOI($ezMetadata, $ezid_production_shoulder, $doiPostfixId, $ezid_auth);
            //$ezJson = $ezutil->updateDOI($ezMetadata, $ezid_production_shoulder, $doiPostfixId, $ezid_auth);
            /*$ezJsonStr = json_encode($ezJson, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            echo $ezJsonStr;
            return;*/
        
        
        if($gutil->startsWith($ezMessage,"error:"))
        {   
            
            
            $array = array();
            $array['DOI'] = $targetDoi;
            $array['ARK'] = $ezid_production_ark_shoulder."cil".$data['numeric_id'];
            $array['Title'] = $citation;
            $citation_json_str = json_encode($array);
            $citation_json = json_decode($citation_json_str);
            $mjson->CIL_CCDB->Citation = $citation_json;
            $mjson_str = json_encode($mjson, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
                
            $dbutil->submitMetadata($image_id, $mjson_str);
         }
         /****************End Saving the DOI Info*************************************/
         
         redirect($base_url."/image_metadata/edit/".$image_id);
    }
    
    
    public function publish_group($stage_prod, $image_id)
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $cutil = new Curl_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $base_url = $this->config->item('base_url');
        $group_data_location = $this->config->item('group_data_location');
        /***********Checking login****************/
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        /***********End Checking login****************/
        
        /***********Checking Permission************/
        $username = $data['username'];
        if(!$dbutil->isAdmin($username))
        {
            redirect ($base_url."/home");
            return;
        }
        /***********End Checking Permission************/
        
        
        echo "<br/>".$stage_prod;
        echo "<br/>".$image_id;
        $groupInfo = $dbutil->getGroupInfo($image_id);
        if(!is_null($groupInfo))
        {
            echo "<br/>".$groupInfo->tag;
            echo "<br/>".$groupInfo->group_id;
            
            $idArray = $dbutil->getGroupMemebers($groupInfo->tag);
            foreach($idArray as $id)
            {
                echo "<br/>".$id;
            }
            
            $group_template = "{\"Group\": { ".
            "\"Name\": \"pubgroup\",".
            "\"Description\": \"".$groupInfo->tag."\",".
            "\"Group_members\": [".
            " ]}}";
            
            $json = json_decode($group_template);
            
            if(!is_null($json) && isset($json->Group->Group_members))
            {
                foreach($idArray as $id)
                {
                    $id = str_replace("CIL_", "", $id."");
                    array_push($json->Group->Group_members, $id."");
                }
            
                $json_str = json_encode($json,JSON_PRETTY_PRINT);
                $file_path = $group_data_location."/".$groupInfo->group_id.".json";
                
                if(file_exists($file_path))
                    unlink ($file_path);
                
                file_put_contents($file_path, $json_str);
                
                if(strcmp($stage_prod, "stage") == 0)
                {
                    $data['elasticsearch_host_stage'] = $this->config->item('elasticsearch_host_stage');
                    $esUrl = $data['elasticsearch_host_stage']."/ccdbv8/groups/".$groupInfo->group_id;
                    $response = $cutil->just_curl_put($esUrl, $json_str);
                    echo "<br/>".$response;
                }
                else if(strcmp($stage_prod, "prod") == 0)
                {
                    $data['elasticsearch_host_prod'] = $this->config->item('elasticsearch_host_prod');
                    $esUrl = $data['elasticsearch_host_prod']."/ccdbv8/groups/".$groupInfo->group_id;
                    $response = $cutil->just_curl_put($esUrl, $json_str);
                    echo "<br/>".$response;
                }
            }

        }

        redirect($base_url."/image_metadata/edit/".$image_id);
        
        
    }
    
    public function publish_data($image_id="0")
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $base_url = $this->config->item('base_url');
        /***********Checking login****************/
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        /***********End Checking login****************/
        
        /***********Checking Permission************/
        $username = $data['username'];
        if(!$dbutil->isAdmin($username))
        {
            redirect ($base_url."/home");
            return;
        }
        /***********End Checking Permission************/
        $gutil = new General_util();
        $cutil = new Curl_util();
        if(strcmp($image_id, "0") == 0)
        {
            show_404();
            return;
        }
        
        
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
            redirect ($base_url."/login/auth_image/".$image_id);
        
        $json = $dbutil->getMetadata($image_id);
        if(!$json->success)
        {
            show_404();
            return;
        }
        else if(isset($json->metadata))
        {
            
            $json_str = $json->metadata;
            $mjson = json_decode($json_str);
            $mjson->CIL_CCDB->Status->Publish_time = time();
            $json_str = json_encode($mjson, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
           
            if($gutil->startsWith($image_id, "CIL_"))
            {
                $data['numeric_id'] = str_replace("CIL_", "", $image_id);
            }
            $data['title'] = "CIL | Edit ".$image_id;
            $data['staging_website_prefix'] = $this->config->item('staging_website_prefix');
            $data['elasticsearch_host_stage'] = $this->config->item('elasticsearch_host_stage');
            $esUrl = $data['elasticsearch_host_stage']."/ccdbv8/data/".$image_id;
            //echo $esUrl."<br/><br/>";
            //echo $json_str;

            $response = $cutil->just_curl_put($esUrl, $json_str);
            //echo $response;
            //redirect($data['staging_website_prefix']."/images/".$image_id);
            redirect($base_url."/image_metadata/edit/".$image_id);
        }
        else
        {
            redirect($base_url."/image_metadata/edit/".$image_id);
        }
    }
    
    public function edit($image_id="0")
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $base_url = $this->config->item('base_url');
        /***********Checking login****************/
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        /***********End Checking login****************/
        
        /***********Checking Permission************/
        $username = $data['username'];
        if(!$dbutil->isAdmin($username))
        {
            redirect ($base_url."/home");
            return;
        }
        /***********End Checking Permission************/
        $gutil = new General_util();
        $cutil = new Curl_util();
        $ezutil = new EZIDUtil();
        if(strcmp($image_id, "0") == 0)
        {
            show_404();
            return;
        }
        
        $test_output_folder = $this->config->item('test_output_folder');
        $data['debug'] = $this->input->get('debug', TRUE);
        
        $login_hash = $this->session->userdata('login_hash');
        $username = $this->session->userdata('username');
        $data['username'] = $username;
        $data['user_role'] = $dbutil->getUserRole($username);
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        
        if(!file_exists($test_output_folder))
            mkdir ($test_output_folder);
        
        $log_path = $test_output_folder."/edit_".$image_id.".txt";
        if(file_exists($log_path))
            unlink ($log_path);
        $json = $dbutil->getMetadata($image_id);
        $mjson = json_decode($json->metadata);
        
        error_log($json->metadata, 3, $log_path);
        
        
        $data['image_name'] = $json->image_name;
        $data['json'] = $mjson;
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
            
            $image_size_json = $dbutil->getImageSizes($image_id);
            
            /****************Updating image size**********************************/
            $jpeg_size = 0;
            $zip_size = 0;
            $metadata_service_prefix = $this->config->item('metadata_service_prefix');
            $metadata_auth = $this->config->item('metadata_auth');
            $size_url = str_replace("metadata_service", "rest/file_size", $metadata_service_prefix);
            
            //echo "<br/>".$size_url;
            clearstatcache();
            //if(!is_null($image_size_json) && isset($image_size_json->jpeg_size))
            if(!is_null($image_size_json))
            {
                $filePath = "/var/www/html/media/images/".$data['numeric_id']."/".$data['numeric_id'].".jpg"; //Remote file path
                $response = $cutil->auth_curl_get_with_data($metadata_auth, $size_url, $filePath);
                $sjson = json_decode($response);
                $jpeg_size = $sjson->Size;
                $image_size_json->jpeg_size = $sjson->Size;
            }
            
            //if(!is_null($image_size_json) && isset($image_size_json->zip_size))
            if(isset($mjson->CIL_CCDB->Data_type->Video) && $mjson->CIL_CCDB->Data_type->Video)
            {
                //echo "<br/>Video";
                if(!is_null($image_size_json))
                {
                    $filePath = "/var/www/html/media/videos/".$data['numeric_id']."/".$data['numeric_id'].".zip"; //Remote file path
                    //echo "<br/>File Path:".$filePath;
                    $response = $cutil->auth_curl_get_with_data($metadata_auth, $size_url, $filePath);
                    $sjson = json_decode($response);
                    $zip_size = $sjson->Size;
                    //echo "<br/>Size:".$zip_size;
                    $image_size_json->zip_size = $sjson->Size;
                }
            }
            else 
            {
                //echo "<br/>Image";
                if(!is_null($image_size_json))
                {
                    $filePath = "/var/www/html/media/images/".$data['numeric_id']."/".$data['numeric_id'].".zip"; //Remote file path
                    $response = $cutil->auth_curl_get_with_data($metadata_auth, $size_url, $filePath);
                    $sjson = json_decode($response);
                    $zip_size = $sjson->Size;
                    $image_size_json->zip_size = $sjson->Size;
                }
            }
            
            if($jpeg_size > 0 && $zip_size > 0)
            {
                $dbutil->updateJpegZipSize($image_id, $jpeg_size, $zip_size);
                
            }
            /****************End Updating image size**********************************/
            
            
            /*****************************Updating *******************************************/
            
            
            /****************Saving the DOI Info*************************************/
            
            $cilUtil = new CILContentUtil();
            $ezid_production_shoulder = $this->config->item('ezid_production_shoulder');
            $ezid_production_ark_shoulder = $this->config->item('ezid_production_ark_shoulder');
            $targetDoi = $ezid_production_shoulder."CIL".$data['numeric_id'];
            $ezMessage = $ezutil->getDoiInfo($targetDoi);
            
            
            //$filePath = "C:/Users/wawong/Desktop/doi_exists.txt";
             //error_log("\n".$ezMessage, 3,$filePath);
            
            if(!$gutil->startsWith($ezMessage,"error:"))
            {
                $data['doi_exists'] = true;
                
               
                /*
                if(true)
                {
                    //$ezMetadata =  $cilUtil->getEzIdMetadata($mjson,$data['numeric_id'],date("Y"));
                    $citation = $cilUtil->getCitationInfo($mjson, $data['numeric_id'], date("Y"));

                    $array = array();
                    $array['DOI'] = $targetDoi;
                    $array['ARK'] = $ezid_production_ark_shoulder."cil".$data['numeric_id'];
                    $array['Title'] = $citation;
                    $citation_json_str = json_encode($array);
                    $citation_json = json_decode($citation_json_str);
                    $mjson->CIL_CCDB->Citation = $citation_json;
                    $mjson_str = json_encode($mjson, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

                    $dbutil->submitMetadata($image_id, $mjson_str);
                }
                */
            }
            else 
            {
                //error_log( "\n".$image_id.":NOT doi_exists", 3,$filePath);
            }
            /****************End Saving the DOI Info*************************************/
            
            
            $data['title'] = "CIL | Edit ".$image_id;
            $data['staging_website_prefix'] = $this->config->item('staging_website_prefix');
            $data['prod_website_prefix'] = $this->config->item('prod_website_prefix');
            $data['elasticsearch_host_stage'] = $this->config->item('elasticsearch_host_stage');
            $data['elasticsearch_host_prod'] = $this->config->item('elasticsearch_host_prod');
            $data['image_size_json'] = $image_size_json;
            
            /*************Staging Elasticsearch****************************/
            $esUrl = $data['elasticsearch_host_stage']."/ccdbv8/data/".$image_id;
            $ejson_str = $cutil->curl_get($esUrl);
            $ejson = json_decode($ejson_str);
            $data['enable_unpublish_button'] = false;
            if(!is_null($ejson) && isset($ejson->found) && $ejson->found)
                $data['enable_unpublish_button'] = true;
             $data['esUrl'] = $esUrl;
             /*************End Staging Elasticsearch****************************/
            
            /*************Production Elasticsearch****************************/
             
            
            $esProdUrl = $data['elasticsearch_host_prod']."/ccdbv8/data/".$image_id;
            $epjson_str = $cutil->curl_get($esProdUrl);

            $epjson = json_decode($epjson_str);
            if(!is_null($epjson) && isset($epjson->found) && $epjson->found)
                $data['enable_unpublish_button_prod'] = true;
            $data['esProdUrl'] = $esProdUrl;
            /*************End Production Elasticsearch****************************/
            
            //$data['data_json'] = $json;
           
            $data['image_id'] = $image_id;
            
            $this->load->view('templates/header', $data);
            $this->load->view('edit/edit_main', $data);
            $this->load->view('templates/footer', $data);
        }
    }
    
    
    public function copy_attribution_names($image_id="0")
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $base_url = $this->config->item('base_url');
        /***********Checking login****************/
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        /***********End Checking login****************/
        
        /***********Checking Permission************/
        $username = $data['username'];
        if(!$dbutil->isAdmin($username))
        {
            redirect ($base_url."/home");
            return;
        }
        /***********End Checking Permission************/
        
        
        $gutil = new General_util();
        $cutil = new Curl_util();
        $ezutil = new EZIDUtil();
        if(strcmp($image_id, "0") == 0)
        {
            show_404();
            return;
        }
        
        
        $test_output_folder = $this->config->item('test_output_folder');
        $data['debug'] = $this->input->get('debug', TRUE);
        
        
        $username = $this->session->userdata('username');
        $data['username'] = $username;
        $data['user_role'] = $dbutil->getUserRole($username);

        
        $copy_attribution_names_id = $this->input->post('copy_attribution_names_id', TRUE);
        
        echo "<br/>".$copy_attribution_names_id;
        
        if(!$gutil->startsWith($copy_attribution_names_id, "CIL_"))
            $copy_attribution_names_id = "CIL_".$copy_attribution_names_id;
        
        
        
        $result = $dbutil->getMetadata($copy_attribution_names_id);
        if(is_null($result))
        {
            redirect ($base_url."/image_metadata/edit/".$image_id);
            return;
        }
     
        if(is_null($result->metadata) || strlen($result->metadata) == 0)
        {
            redirect ($base_url."/image_metadata/edit/".$image_id);
            return;
        }
        
        //echo "<br/>".$result->metadata;
        $copy_json = json_decode($result->metadata);
        if(is_null($copy_json))
        {
            redirect ($base_url."/image_metadata/edit/".$image_id);
            return;
        }    
        
        
        $copy_attr_cont_json = NULL;
        if(isset($copy_json->CIL_CCDB->CIL->CORE->ATTRIBUTION->Contributors))
            $copy_attr_cont_json = $copy_json->CIL_CCDB->CIL->CORE->ATTRIBUTION->Contributors;
        
        
        $result0 = $dbutil->getMetadata($image_id);
        if(is_null($result0))
        {
            redirect ($base_url."/image_metadata/edit/".$image_id);
            return;
        }
     
        if(is_null($result0->metadata) || strlen($result0->metadata) == 0)
        {
            redirect ($base_url."/image_metadata/edit/".$image_id);
            return;
        }
        
        $json = json_decode($result0->metadata);
        if(!is_null($copy_attr_cont_json))
            $json->CIL_CCDB->CIL->CORE->ATTRIBUTION->Contributors = $copy_attr_cont_json;


        $json_str = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        
        $dbutil->updateMetadata($json_str, $image_id);
        redirect ($base_url."/image_metadata/edit/".$image_id);
        return;
    }
    
    public function copy_imaging_methods($image_id="0")
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $base_url = $this->config->item('base_url');
        /***********Checking login****************/
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        /***********End Checking login****************/
        
        /***********Checking Permission************/
        $username = $data['username'];
        if(!$dbutil->isAdmin($username))
        {
            redirect ($base_url."/home");
            return;
        }
        /***********End Checking Permission************/
        
        
        $gutil = new General_util();
        $cutil = new Curl_util();
        $ezutil = new EZIDUtil();
        if(strcmp($image_id, "0") == 0)
        {
            show_404();
            return;
        }
        
        
        $test_output_folder = $this->config->item('test_output_folder');
        $data['debug'] = $this->input->get('debug', TRUE);
        
        
        $username = $this->session->userdata('username');
        $data['username'] = $username;
        $data['user_role'] = $dbutil->getUserRole($username);

        
        $copy_imaging_methods_id = $this->input->post('copy_imaging_methods_id', TRUE);
        
        echo "<br/>".$copy_imaging_methods_id;
        
        if(!$gutil->startsWith($copy_imaging_methods_id, "CIL_"))
            $copy_imaging_methods_id = "CIL_".$copy_imaging_methods_id;
        
        
        
        $result = $dbutil->getMetadata($copy_imaging_methods_id);
        if(is_null($result))
        {
            redirect ($base_url."/image_metadata/edit/".$image_id);
            return;
        }
     
        if(is_null($result->metadata) || strlen($result->metadata) == 0)
        {
            redirect ($base_url."/image_metadata/edit/".$image_id);
            return;
        }
        
        //echo "<br/>".$result->metadata;
        $copy_json = json_decode($result->metadata);
        $copy_im_json = $copy_json->CIL_CCDB->CIL->CORE->IMAGINGMODE;
        $copy_vm_json = $copy_json->CIL_CCDB->CIL->CORE->VISUALIZATIONMETHODS;
        
        $result0 = $dbutil->getMetadata($image_id);
        if(is_null($result0))
        {
            redirect ($base_url."/image_metadata/edit/".$image_id);
            return;
        }
     
        if(is_null($result0->metadata) || strlen($result0->metadata) == 0)
        {
            redirect ($base_url."/image_metadata/edit/".$image_id);
            return;
        }
        
        $json = json_decode($result0->metadata);
        $json->CIL_CCDB->CIL->CORE->IMAGINGMODE = $copy_im_json;
        $json->CIL_CCDB->CIL->CORE->VISUALIZATIONMETHODS = $copy_vm_json;

        $json_str = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        
        $dbutil->updateMetadata($json_str, $image_id);
        redirect ($base_url."/image_metadata/edit/".$image_id);
        return;
        
        
        
        
    }
    public function copy_biological_sources($image_id="0")
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $base_url = $this->config->item('base_url');
        /***********Checking login****************/
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        /***********End Checking login****************/
        
        /***********Checking Permission************/
        $username = $data['username'];
        if(!$dbutil->isAdmin($username))
        {
            redirect ($base_url."/home");
            return;
        }
        /***********End Checking Permission************/
        
        
        $gutil = new General_util();
        $cutil = new Curl_util();
        $ezutil = new EZIDUtil();
        if(strcmp($image_id, "0") == 0)
        {
            show_404();
            return;
        }
        
        
        $test_output_folder = $this->config->item('test_output_folder');
        $data['debug'] = $this->input->get('debug', TRUE);
        
        
        $username = $this->session->userdata('username');
        $data['username'] = $username;
        $data['user_role'] = $dbutil->getUserRole($username);

        
        $copy_cell_component_id = $this->input->post('copy_cell_component_id', TRUE);
        
        echo "<br/>".$copy_cell_component_id;
        
        
        if(!$gutil->startsWith($copy_cell_component_id, "CIL_"))
            $copy_cell_component_id = "CIL_".$copy_cell_component_id;
        
        
        
        $result = $dbutil->getMetadata($copy_cell_component_id);
        if(is_null($result))
        {
            redirect ($base_url."/image_metadata/edit/".$image_id);
            return;
        }
     
        if(is_null($result->metadata) || strlen($result->metadata) == 0)
        {
            redirect ($base_url."/image_metadata/edit/".$image_id);
            return;
        }
        
        //echo "<br/>".$result->metadata;
        $copy_json = json_decode($result->metadata);
        $copy_cc_json = $copy_json->CIL_CCDB->CIL->CORE->CELLULARCOMPONENT;
        $copy_ct_json = $copy_json->CIL_CCDB->CIL->CORE->CELLTYPE;
        $copy_noc_json = $copy_json->CIL_CCDB->CIL->CORE->NCBIORGANISMALCLASSIFICATION;
        $result0 = $dbutil->getMetadata($image_id);
        if(is_null($result0))
        {
            redirect ($base_url."/image_metadata/edit/".$image_id);
            return;
        }
     
        if(is_null($result0->metadata) || strlen($result0->metadata) == 0)
        {
            redirect ($base_url."/image_metadata/edit/".$image_id);
            return;
        }
        
        $json = json_decode($result0->metadata);
        $json->CIL_CCDB->CIL->CORE->CELLULARCOMPONENT = $copy_cc_json;
        $json->CIL_CCDB->CIL->CORE->CELLTYPE = $copy_ct_json;
        $json->CIL_CCDB->CIL->CORE->NCBIORGANISMALCLASSIFICATION = $copy_noc_json;
        $json_str = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        
        $dbutil->updateMetadata($json_str, $image_id);
        redirect ($base_url."/image_metadata/edit/".$image_id);
        return;
        
        
    }
    
    public function copy_metadata($image_id="0")
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $base_url = $this->config->item('base_url');
        /***********Checking login****************/
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        /***********End Checking login****************/
        
        /***********Checking Permission************/
        $username = $data['username'];
        if(!$dbutil->isAdmin($username))
        {
            redirect ($base_url."/home");
            return;
        }
        /***********End Checking Permission************/
        
        
        $gutil = new General_util();
        $cutil = new Curl_util();
        $ezutil = new EZIDUtil();
        if(strcmp($image_id, "0") == 0)
        {
            show_404();
            return;
        }
        
        
        $test_output_folder = $this->config->item('test_output_folder');
        $data['debug'] = $this->input->get('debug', TRUE);
        
        
        $username = $this->session->userdata('username');
        $data['username'] = $username;
        $data['user_role'] = $dbutil->getUserRole($username);

        
        $copy_id = $this->input->post('copy_metadata_from_id', TRUE);
        
        
        if(!$gutil->startsWith($copy_id, "CIL_"))
            $copy_id = "CIL_".$copy_id;
        
        
        
        $result = $dbutil->getMetadata($copy_id);
        if(is_null($result))
        {
            redirect ($base_url."/image_metadata/edit/".$image_id);
            return;
        }
     
        if(is_null($result->metadata) || strlen($result->metadata) == 0)
        {
            redirect ($base_url."/image_metadata/edit/".$image_id);
            return;
        }
        
        $dbutil->updateMetadata($result->metadata, $image_id);
        redirect ($base_url."/image_metadata/edit/".$image_id);
        return;
    }
    
    public function upload_zipped_image($image_id)
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $base_url = $this->config->item('base_url');
        /***********Checking login****************/
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        /***********End Checking login****************/
        
        /***********Checking Permission************/
        $username = $data['username'];
        if(!$dbutil->isAdmin($username))
        {
            redirect ($base_url."/home");
            return;
        }
        
        $data['base_url'] = $this->config->item('base_url');
        $data['image_id'] = $image_id;
        /***********End Checking Permission************/
        $data['title'] = "CIL | Upload the main image ".$image_id;
        $this->load->view('templates/header', $data);
        $this->load->view('edit/upload_main_image_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    
    public function upload_jpeg_image($image_id)
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $base_url = $this->config->item('base_url');
        /***********Checking login****************/
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        /***********End Checking login****************/
        
        /***********Checking Permission************/
        $username = $data['username'];
        if(!$dbutil->isAdmin($username))
        {
            redirect ($base_url."/home");
            return;
        }
        
        $data['base_url'] = $this->config->item('base_url');
        $data['image_id'] = $image_id;
        /***********End Checking Permission************/
        $data['title'] = "CIL | Upload the display image ".$image_id;
        $this->load->view('templates/header', $data);
        $this->load->view('edit/upload_jpeg_image_display', $data);
        $this->load->view('templates/footer', $data);
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

