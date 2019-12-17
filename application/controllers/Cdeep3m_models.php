<?php
include_once 'Curl_util.php';
include_once 'General_util.php';
include_once 'DB_util.php';
include_once 'Ontology_util.php';
include_once 'Dimension_util.php';
include_once 'EZIDUtil.php';
include_once 'CILContentUtil.php';
include_once 'Image_dbutil.php';


class Cdeep3m_models extends CI_Controller
{
    
    
    public function my_models()
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        $data['user_role'] = $dbutil->getUserRole($data['username']);
        $data['title'] = 'Home > My models';
        $mjson = $dbutil->getModelListByUsername($data['username']);
        $data['mjson'] = $mjson;
        $this->load->view('templates/header', $data);
        $this->load->view('cdeep3m/models/model_list_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    
    public function delete_field($model_id,$field, $input)
    {
        $this->load->helper('url');
        $input=str_replace("%20", " ", $input);
        $input = str_replace("%28","(", $input);
        $input = str_replace("%29",")", $input);
        
        $input= str_replace("_single_quote_", "'", $input);
        echo "<br/>Model_id:".$model_id;
        echo "<br/>Type:".$field;
        echo "<br/>Name:".$input;
        
        $dbutil = new DB_util();
        
        
        $json = $dbutil->getModelJson($model_id);
       
        $coreJson= $json->Cdeepdm_model;
        foreach($coreJson as $key => $val) 
        {
            if(strcmp($key,$field) == 0)
            {
                echo "<br/>Match field";
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
                                $removeIndex = $i;
                            }
                        }
                        else if(isset($item->free_text))
                        {
                            if(strcmp($input,$item->free_text)==0)
                            {

                                $removeIndex = $i;
                            }
                        }
                        else 
                        {
                            if(strcmp($input,$item)==0)
                            {
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
        
        
        $json_str = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $dbutil->updateModelJson($model_id, $json_str);
        redirect($base_url."/cdeep3m_models/edit/".$model_id);
         
    }
    
    
    public function add_training($model_id=0, $fileName="Unknown")
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        $cutil = new Curl_util();
        $ezutil = new EZIDUtil();
        if(strcmp($model_id, "0") == 0 || strcmp($fileName, "Unknown") ==0)
        {
            show_404();
            return;
        }
        
        $base_url = $this->config->item('base_url');
        $data['debug'] = $this->input->get('debug', TRUE);
        $login_hash = $this->session->userdata('login_hash');
        if(is_null($login_hash))
        {
            redirect ($base_url."/home");
            return;
        }
        $username = $this->session->userdata('username');
        $data['username'] = $username;
        $data['user_role'] = $dbutil->getUserRole($username);
        
        $db_params = $this->config->item('db_params');
        //echo $db_params;
        
        $upload_location = $this->config->item('model_upload_location');
        $upload_location = $upload_location."/".$model_id;
        $fileSize = 0;
        if(file_exists($upload_location."/".$fileName))
           $fileSize=filesize($upload_location."/".$fileName);
        
        
        
        $model_id = intval($model_id);
        if($dbutil->modelExists($model_id))
        {
            $dbutil->updateTrainingFile($model_id, $fileName,$fileSize);

        }

        
        redirect($base_url."/cdeep3m_models/edit/".$model_id);
   
    }
    
    
    public function release_model_to_website($server_type="stage",$model_id="0")
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        $cutil = new Curl_util();
        if(strcmp($model_id, "0") == 0)
        {
            show_404();
            return;
        }
        
        $base_url = $this->config->item('base_url');
        $data['debug'] = $this->input->get('debug', TRUE);
        $login_hash = $this->session->userdata('login_hash');
        if(is_null($login_hash))
        {
            redirect ($base_url."/home");
            return;
        }
        
        
        $modelJson = $dbutil->getModelJson($model_id);
        
        if(is_null($modelJson))
        {
            show_404();
            return;
        }
        $json_str = json_encode($modelJson,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        //echo $server_type."----".$model_id;
        if(strcmp($server_type, "stage")==0)
        {
            $elasticsearch_host_stage = $this->config->item('elasticsearch_host_stage');  
            $eurl = $elasticsearch_host_stage."/ccdbv8/trained_models/".$model_id;
            echo $eurl;
            
            $response = $cutil->curl_put($eurl, $json_str);
            echo $response;
            
            redirect($base_url."/cdeep3m_models/manage_trained_models/".$model_id);
        }
        else if(strcmp($server_type, "prod")==0)
        {
            $elasticsearch_host_prod = $this->config->item('elasticsearch_host_prod');
            $eurl = $elasticsearch_host_prod."/ccdbv8/trained_models/".$model_id;
            echo $eurl;
            $response = $cutil->curl_put($eurl, $json_str);
            echo $response;
            redirect($base_url."/cdeep3m_models/manage_trained_models/".$model_id);
        }
        else
        {
            show_404();
            return;
        }
    }
    
    public function add($model_id=0, $fileName="Unknown")
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        $cutil = new Curl_util();
        $ezutil = new EZIDUtil();
        if(strcmp($model_id, "0") == 0 || strcmp($fileName, "Unknown") ==0)
        {
            show_404();
            return;
        }
        
        $base_url = $this->config->item('base_url');
        $data['debug'] = $this->input->get('debug', TRUE);
        $login_hash = $this->session->userdata('login_hash');
        if(is_null($login_hash))
        {
            redirect ($base_url."/home");
            return;
        }
        $username = $this->session->userdata('username');
        $data['username'] = $username;
        $data['user_role'] = $dbutil->getUserRole($username);
        
        $db_params = $this->config->item('db_params');
        //echo $db_params;
        
        $upload_location = $this->config->item('model_upload_location');
        $upload_location = $upload_location."/".$model_id;
        $fileSize = 0;
        if(file_exists($upload_location."/".$fileName))
           $fileSize=filesize($upload_location."/".$fileName);
        
        
        
        $model_id = intval($model_id);
        if($dbutil->modelExists($model_id))
        {
            $dbutil->updateModelFile($model_id, $fileName,$fileSize);
            //echo "Update path";
        }
        else
        {
            $dbutil->insertModelFile($model_id, $fileName,$fileSize,$username);
            //echo "Insert path";
        }
        
        //redirect($base_url."/cdeep3m_models/edit/".$model_id);
        redirect($base_url."/cdeep3m_models/upload_training_data/".$model_id);
         
    }
    
    public function delete_model($model_id="0")
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        $cutil = new Curl_util();
        $ezutil = new EZIDUtil();
        $outil = new Ontology_util();
        
        if(strcmp($model_id, "0") == 0 || !is_numeric($model_id))
        {
            show_404();
            return;
        }
        
        $model_id = intval($model_id);
        $dbutil->deleteModel($model_id);
        $base_url = $this->config->item('base_url');
        redirect ($base_url."/cdeep3m_models/list_models");
    }
    
    public function submit($model_id="0")
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        $cutil = new Curl_util();
        $ezutil = new EZIDUtil();
        $outil = new Ontology_util();
        
        if(strcmp($model_id, "0") == 0 || !is_numeric($model_id))
        {
            show_404();
            return;
        }
        
        $model_id = intval($model_id);
        $mjson = $dbutil->getModelJson($model_id);
        
        
        
        $base_url = $this->config->item('base_url');
        $data['debug'] = $this->input->get('debug', TRUE);
        $login_hash = $this->session->userdata('login_hash');
        if(is_null($login_hash))
        {
            redirect ($base_url."/home");
            return;
        }
        $username = $this->session->userdata('username');
        $data['username'] = $username;
        $data['user_role'] = $dbutil->getUserRole($username);
        
        
        $trained_model_name = $this->input->post('trained_model_name', TRUE);
        $ncbi = $this->input->post('image_search_parms[ncbi]', TRUE);
        $cell_type = $this->input->post('image_search_parms[cell_type]', TRUE);
        $cell_component = $this->input->post('image_search_parms[cellular_component]', TRUE);
        $image_type = $this->input->post('image_search_parms[item_type_bim]', TRUE);
        $magnification = $this->input->post('magnification', TRUE);
        $contributor = $this->input->post('contributor', TRUE);
        $desc = $this->input->post('description', TRUE);
        
        //$voxelsize = $this->input->post('voxelsize', TRUE);
        //$voxelsize_unit = $this->input->post('voxelsize_unit', TRUE);
        
        /********Voxel sizes******************/
        $x_voxelsize = $this->input->post('x_voxelsize', TRUE);
        $x_voxelsize_unit = $this->input->post('x_voxelsize_unit', TRUE);
        
        $y_voxelsize = $this->input->post('y_voxelsize', TRUE);
        $y_voxelsize_unit = $this->input->post('y_voxelsize_unit', TRUE);
        
        $z_voxelsize = $this->input->post('z_voxelsize', TRUE);
        $z_voxelsize_unit = $this->input->post('z_voxelsize_unit', TRUE);
        /********End voxel sizes**************/
        
        echo "<br/>trained_model_name:".$trained_model_name;
        if(!is_null($trained_model_name))
            $mjson->Cdeepdm_model->Name = $trained_model_name;
        
        if(!is_null($desc))
            $mjson->Cdeepdm_model->Description = $desc;
        
        echo "<br/>NCBI:".$ncbi;
        echo "<br/>cell_type:".$cell_type;
        echo "<br/>cell_component:".$cell_component;
        echo "<br/>image_type:".$image_type;
        echo "<br/>magnification:".$magnification;
        echo "<br/>x_voxelsize:".$x_voxelsize;
        echo "<br/>x_voxelsize_unit:".$x_voxelsize_unit;
        echo "<br/>y_voxelsize:".$y_voxelsize;
        echo "<br/>y_voxelsize_unit:".$y_voxelsize_unit;
        echo "<br/>z_voxelsize:".$z_voxelsize;
        echo "<br/>z_voxelsize_unit:".$z_voxelsize_unit;
        $targetDir = $this->config->item('model_upload_location');
        if(!file_exists($targetDir))
           mkdir($targetDir);
                
        $targetDir = $targetDir."/".$model_id;
        if(!file_exists($targetDir))
            mkdir($targetDir);
        
       
          
        if(!is_null($ncbi) && strlen(trim($ncbi)) > 0)
        {   
            $narray = array();
            $ncbiJsonStr = json_encode($narray);
            $ncbiJson = json_decode($ncbiJsonStr);
            if(isset($mjson->Cdeepdm_model->NCBIORGANISMALCLASSIFICATION))
                $ncbiJson = $mjson->Cdeepdm_model->NCBIORGANISMALCLASSIFICATION;
            
            $ncbiJson=$outil->handleExistingOntoJSON($ncbiJson, "ncbi_organism", $ncbi);
            //echo json_encode($ncbiJson,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            $mjson->Cdeepdm_model->NCBIORGANISMALCLASSIFICATION = $ncbiJson;
        }
        
        if(!is_null($cell_type) && strlen(trim($cell_type)) > 0)
        {   
            $narray = array();
            $ncbiJsonStr = json_encode($narray);
            $ncbiJson = json_decode($ncbiJsonStr);
            if(isset($mjson->Cdeepdm_model->CELLTYPE))
                $ncbiJson = $mjson->Cdeepdm_model->CELLTYPE;
            
            $ncbiJson=$outil->handleExistingOntoJSON($ncbiJson, "cell_types", $cell_type);
            //echo json_encode($ncbiJson,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            $mjson->Cdeepdm_model->CELLTYPE = $ncbiJson;
        }
        
        if(!is_null($cell_component) && strlen(trim($cell_component)) > 0)
        {   
            $narray = array();
            $ncbiJsonStr = json_encode($narray);
            $ncbiJson = json_decode($ncbiJsonStr);
            if(isset($mjson->Cdeepdm_model->CELLULARCOMPONENT))
                $ncbiJson = $mjson->Cdeepdm_model->CELLULARCOMPONENT;
            
            $ncbiJson=$outil->handleExistingOntoJSON($ncbiJson, "cellular_components", $cell_component);
            //echo json_encode($ncbiJson,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            $mjson->Cdeepdm_model->CELLULARCOMPONENT = $ncbiJson;
        }
        
        
        if(!is_null($image_type) && strlen(trim($image_type)) > 0)
        {   
            $narray = array();
            $ncbiJsonStr = json_encode($narray);
            $ncbiJson = json_decode($ncbiJsonStr);
            if(isset($mjson->Cdeepdm_model->ITEMTYPE))
                $ncbiJson = $mjson->Cdeepdm_model->ITEMTYPE;
            
            $ncbiJson=$outil->handleExistingOntoJSON($ncbiJson, "imaging_methods", $image_type);
            //echo json_encode($ncbiJson,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            $mjson->Cdeepdm_model->ITEMTYPE = $ncbiJson;
        }
        
        if(!is_null($magnification) && strlen(trim($magnification)) > 0)
        { 
            $mjson->Cdeepdm_model->Magnification = $magnification;
        }
        
        
        /*        
        if(!is_null($voxelsize) && strlen(trim($voxelsize)) > 0)
        { 
            $varray = array();
            $varray['Value'] = doubleval($voxelsize);
            $varray['Unit'] = $voxelsize_unit;
            $vjson_str = json_encode($varray);
            $vjson = json_decode($vjson_str);
            $mjson->Cdeepdm_model->Voxelsize = $vjson;
        }
        */
        if(!is_null($x_voxelsize) && strlen(trim($x_voxelsize)) > 0 && is_numeric($x_voxelsize))
        { 
            $varray = array();
            $varray['Value'] = doubleval($x_voxelsize);
            $varray['Unit'] = $x_voxelsize_unit;
            $vjson_str = json_encode($varray);
            $vjson = json_decode($vjson_str);
            $mjson->Cdeepdm_model->X_voxelsize = $vjson;
        }
        if(!is_null($y_voxelsize) && strlen(trim($y_voxelsize)) > 0 && is_numeric($y_voxelsize))
        { 
            $varray = array();
            $varray['Value'] = doubleval($y_voxelsize);
            $varray['Unit'] = $y_voxelsize_unit;
            $vjson_str = json_encode($varray);
            $vjson = json_decode($vjson_str);
            $mjson->Cdeepdm_model->Y_voxelsize = $vjson;
        }
        if(!is_null($z_voxelsize) && strlen(trim($z_voxelsize)) > 0 && is_numeric($z_voxelsize))
        { 
            $varray = array();
            $varray['Value'] = doubleval($z_voxelsize);
            $varray['Unit'] = $z_voxelsize_unit;
            $vjson_str = json_encode($varray);
            $vjson = json_decode($vjson_str);
            $mjson->Cdeepdm_model->Z_voxelsize = $vjson;
        }
        else
        {
            
            if(isset($mjson->Cdeepdm_model->Z_voxelsize))
                //unset($mjson['Cdeepdm_model']['Z_voxelsize']);
                unset($mjson->Cdeepdm_model->Z_voxelsize);
        }

        
        if(!is_null($contributor)&& strlen(trim($contributor)) > 0)
        {
            
            if(isset($mjson->Cdeepdm_model->Contributors))
            {
                array_push($mjson->Cdeepdm_model->Contributors, $contributor);
            }
            else
            {
                $carray = array();
                array_push($carray, $contributor);
                $cjson_str = json_encode($carray, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                $cjson = json_decode($cjson_str);
                $mjson->Cdeepdm_model->Contributors = $cjson;
            }
        }
        
        
        if(!is_null($mjson))
        {
            $json_str = json_encode($mjson, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            $dbutil->updateModelJson($model_id,$json_str);
        }
        
        //if(file_exists($targetDir."/model.json"))
        //   unlink($targetDir."/model.json");
        //error_log(json_encode($mjson,  JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), 3, $targetDir."/model.json");
        
        redirect($base_url."/cdeep3m_models/edit/".$model_id);
        
    }
    public function upload_model_image($model_id)
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect ($base_url."/home");
            return;
        }
        $data['user_role'] = $dbutil->getUserRole($data['username']);
        
        
        $cutil= new Curl_util();
        $metadata_service_prefix = $this->config->item('metadata_service_prefix');
        $metadata_auth = $this->config->item('metadata_auth');
        $upload_location = $this->config->item('model_upload_location');
        $upload_location = $upload_location."/".$model_id;
        mkdir($upload_location);
        
        $config2 = array(
        'upload_path' => $upload_location,
        'allowed_types' => "gif|jpg|png|jpeg",
        'overwrite' => TRUE,
        'max_size' => "12048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
        'max_height' => "4000",
        'max_width' => "4000"
        );
        $this->load->library('upload', $config2);
        $url = $metadata_service_prefix."/model_image/".$model_id;
        
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
                        echo "<br/>".$response;
                        $dbutil->updateModelDisplayImageStatus($model_id);
                        redirect($base_url."/cdeep3m_models/edit/".$model_id);
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
    
    
    public function new_model()
    {
        $this->load->helper('url');
        
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect ($base_url."/home");
            return;
        }
        $data['user_role'] = $dbutil->getUserRole($data['username']);
        $is_prod = $this->session->userdata('is_production'); 
        $model_id = $dbutil->getNextID($is_prod);
        
        $base_url = $this->config->item('base_url');
        redirect ($base_url."/cdeep3m_models/upload/".$model_id);
    }
    
    private  function formatBytes($size) 
    { 
        $base = log($size) / log(1024);
        $suffix = array("", "KB", "MB", "GB", "TB");
        $f_base = floor($base);
        return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
    } 
    
    public function edit($model_id=0)
    {
        $this->load->helper('url');
        $remote_service_prefix =  $this->config->item('remote_service_prefix');
        $dbutil = new DB_util();
        $cutil = new Curl_util();
        
        $mjson = $dbutil->getModelJson($model_id);
        $data['mjson'] = $mjson;
        
        $trainingDataJson = $dbutil->getTrainingInfo($model_id);
        if(!is_null($trainingDataJson) && isset($trainingDataJson->file_name))
        {
            if(isset($trainingDataJson->file_size) && $trainingDataJson->file_size > 0)
                $trainingDataJson->file_size = $this->formatBytes ($trainingDataJson->file_size);
            $data['training_data_json'] = $trainingDataJson;
        }
        
        $jpg_path = "/export2/media/model_display/".$model_id."/".$model_id."_thumbnailx512.jpg";
        $metadata_auth = $this->config->item('metadata_auth');
        $filezize_str = $cutil->auth_curl_get_with_data($metadata_auth,$remote_service_prefix."/rest/file_size", $jpg_path);
        //echo "<br/>File JSON STR:".$filezize_str;
        $sjson = json_decode($filezize_str);

        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        $data['user_role'] = $dbutil->getUserRole($data['username']);
        
        
        $model_info = $dbutil->getModelInfo($model_id);
        if(!is_null($model_info))
        {
            if(isset($model_info->file_size) && !is_null($model_info->file_size))
                $model_info->file_size = $this->formatBytes ($model_info->file_size);
            $data['model_info'] = $model_info;
            //var_dump($model_info);   
            
            if(isset($model_info->publish_date) && !is_null($model_info->publish_date))
                $data['publish_date']= $model_info->publish_date;
        }
        
        $data['title'] = 'CDeep3M Metadata Edit';
        $data['base_url'] = $this->config->item('base_url');
        $data['model_id'] = intval($model_id);
        $data['step'] = 3;
        
        $hasImage = false;
        if(!is_null($sjson) && isset($sjson->Size) && $sjson->Size > 0)
            $hasImage = true;
        
        $data['hasDisplayImage'] = $hasImage;
        $this->load->view('templates/header', $data);
        $this->load->view('cdeep3m/edit/metadata_edit_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    
    public function list_models()
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        $data['user_role'] = $dbutil->getUserRole($data['username']);
        $data['title'] = 'All trained models';
        $mjson = $dbutil->getModelList();
        $data['mjson'] = $mjson;
        $this->load->view('templates/header', $data);
        $this->load->view('cdeep3m/models/model_list_display', $data);
        $this->load->view('templates/footer', $data);
        
    }
    
    public function upload($model_id=0)
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        
        $miJson = $dbutil->getModelInfo($model_id);
        if(!is_null($miJson) && isset($miJson->file_name))
        {
            $data['model_info_json'] = $miJson;
            
            if(isset($miJson->file_size) && $miJson->file_size > 0)
               $miJson->file_size= $this->formatBytes($miJson->file_size);
        }
        
        $data['step'] = 1;
        $data['user_role'] = $dbutil->getUserRole($data['username']);
        
        $data['base_url'] = $this->config->item('base_url');
        $data['model_id'] = intval($model_id);
        
        $data['title'] = 'CDeep3M Upload';
        $this->load->view('templates/header', $data);
        $this->load->view('cdeep3m/model_upload_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    
    public function upload_training_data($model_id=0)
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        $data['user_role'] = $dbutil->getUserRole($data['username']);
        
        $data['step'] = 2;
        
        $data['base_url'] = $this->config->item('base_url');
        $data['model_id'] = intval($model_id);
        
        $data['title'] = 'CDeep3M Upload';
        $trainingInfoJson = $dbutil->getTrainingInfo($model_id);
        if(!is_null($trainingInfoJson) && isset($trainingInfoJson->file_name))
        {
            if(isset($trainingInfoJson->file_size) && $trainingInfoJson->file_size > 0)
                $trainingInfoJson->file_size = $this->formatBytes ($trainingInfoJson->file_size);
            $data['training_data_json'] = $trainingInfoJson;
            
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('cdeep3m/training_data_upload_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function manage_trained_models($model_id="0")
    {
        $base_url = $this->config->item('base_url');
        $dbutil = new DB_util();
        $data['debug'] = $this->input->get('debug', TRUE);
        
        $login_hash = $this->session->userdata('login_hash');
        $username = $this->session->userdata('username');
        $data['username'] = $username;
        $data['user_role'] = $dbutil->getUserRole($username);
        if(is_null($login_hash))
        {
            redirect ($base_url);
            return;
        }
        
        if(strcmp($model_id, "0")==0)
        {
            $data['title'] = 'Home > Manage trained models';
            $mjson = $dbutil->getModelList();
            $data['mjson'] = $mjson;
            $this->load->view('templates/header', $data);
            $this->load->view('cdeep3m/models/manage_model_list_display', $data);
            $this->load->view('templates/footer', $data);
        }
        else if(is_numeric($model_id))
        {
            $model_info = $dbutil->getModelInfo($model_id);
            $modelJson = $dbutil->getModelJson($model_id);
            if(is_null($model_info) || is_null($modelJson))
            {
                //echo $model_id."===getModelInfo is NULL";
                show_404();
                return;
            }
            
            
            
            //$json_str = json_encode($model_info, JSON_PRETTY_PRINT);
            //echo $json_str;
            //echo "<br/><br/>";
            $data['model_id'] = $model_id;
            $data['model_info'] = $model_info;
            $json_str = json_encode($modelJson, JSON_PRETTY_PRINT);
            $data['model_json'] = $json_str;
            
            $data['title'] = 'Home > Manage model '.$model_id;
            $this->load->view('templates/header', $data);
            $this->load->view('cdeep3m/models/manage_model_display', $data);
            $this->load->view('templates/footer', $data);
        }
        else 
        {
            show_404();
            return;
        }
        
    }
    
    public function create_doi($model_id="0")
    {
        $this->load->helper('url');
        
        $dbutil = new DB_util();
        $gutil = new General_util();
        $cutil = new Curl_util();
        $ezutil = new EZIDUtil();
        if(strcmp($model_id, "0") == 0)
        {
            show_404();
            return;
        }
        
        $base_url = $this->config->item('base_url');
        
        $data['debug'] = $this->input->get('debug', TRUE);
        
        $login_hash = $this->session->userdata('login_hash');
        $username = $this->session->userdata('username');
        $data['username'] = $username;
        $data['user_role'] = $dbutil->getUserRole($username);
        if(is_null($login_hash))
        {
            redirect ($base_url);
            return;
        }
        
        $json = $dbutil->getModelJson($model_id);
        $json_str = json_encode($json, JSON_PRETTY_PRINT  |JSON_UNESCAPED_SLASHES);
        
        
        $doiPostfixId = str_replace("_", "", $model_id);
        $filePath = "C:/Users/wawong/Desktop/Test/".$doiPostfixId."_log.txt";
        if(file_exists($filePath))
            unlink ($filePath);
        //error_log($json_str,3,$filePath);
        
        /****************Saving the DOI Info*************************************/
        
   
        $cilUtil = new CILContentUtil();
        $ezid_production_shoulder = $this->config->item('ezid_production_shoulder');
        $ezid_production_ark_shoulder = $this->config->item('ezid_production_ark_shoulder');
        $ezid_auth = $this->config->item('ezid_auth');
        $targetDoi = $ezid_production_shoulder."CDEEP3M".$model_id;
        
        
        $ezMessage = $ezutil->getDoiInfo($targetDoi);

        
        $modelInfoJson = $dbutil->getModelInfo($model_id);
        if($gutil->startsWith($ezMessage,"error:"))
        {   
           //error_log("\n\n".$targetDoi,3,$filePath);
            $ezMetadata =  $cilUtil->getEzIdMetadataForTrainedModel($json,$model_id,$modelInfoJson->file_name);
            
            //error_log("\n\n".$ezMetadata,3,$filePath);
            $doiPostfixId = "CDEEP3M".$model_id;
            $ezutil->createDOI($ezMetadata, $ezid_production_shoulder, $doiPostfixId, $ezid_auth);
            $dbutil->updateModelPublishDate($model_id);
            
            $idbutil = new Image_dbutil();
            
            if(isset($json->Cdeepdm_model->Name))
            {
                $doi = "https://doi.org/10.7295/W9CDEEP3M".$model_id;
                $idbutil->insertTrainedModel($json->Cdeepdm_model->Name, $doi);
            }
            /*$array = array();
            $array['DOI'] = $targetDoi;
            $array['ARK'] = $ezid_production_ark_shoulder."cdeep3m".$model_id;
            $array['Title'] = $citation;
            $citation_json_str = json_encode($array);
            $citation_json = json_decode($citation_json_str);
            $mjson->CIL_CCDB->Citation = $citation_json;
            $mjson_str = json_encode($mjson, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);*/
                
            
         }
         /****************End Saving the DOI Info*************************************/
         
         redirect($base_url."/cdeep3m_models/edit/".$model_id);
    }
}