<?php
include_once 'Curl_util.php';
include_once 'General_util.php';
include_once 'DB_util.php';
include_once 'Ontology_util.php';
include_once 'Dimension_util.php';
include_once 'EZIDUtil.php';
include_once 'CILContentUtil.php';
class Cdeep3m_models extends CI_Controller
{
    
    public function delete_field($model_id,$field, $input)
    {
        $this->load->helper('url');
        $input=str_replace("%20", " ", $input);
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
            $dbutil->insertModelFile($model_id, $fileName,$fileSize);
            //echo "Insert path";
        }
        
        redirect($base_url."/cdeep3m_models/edit/".$model_id);
         
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
        $voxelsize = $this->input->post('voxelsize', TRUE);
        $voxelsize_unit = $this->input->post('voxelsize_unit', TRUE);
        
        echo "<br/>trained_model_name:".$trained_model_name;
        if(!is_null($trained_model_name))
            $mjson->Cdeepdm_model->Name = $trained_model_name;
        echo "<br/>cell_type:".$cell_type;
        echo "<br/>cell_component:".$cell_component;
        echo "<br/>image_type:".$image_type;
        echo "<br/>magnification:".$magnification;
        echo "<br/>voxelsize:".$voxelsize;
        echo "<br/>voxelsize_unit:".$voxelsize_unit;
        
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
        
        
                
        if(!is_null($voxelsize) && strlen(trim($voxelsize)) > 0)
        { 
            $varray = array();
            $varray['Value'] = doubleval($voxelsize);
            $varray['Unit'] = $voxelsize_unit;
            $vjson_str = json_encode($varray);
            $vjson = json_decode($vjson_str);
            $mjson->Cdeepdm_model->Voxelsize = $vjson;
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
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        $data['user_role'] = $dbutil->getUserRole($data['username']);
        $is_prod = $this->session->userdata('is_production'); 
        $model_id = $dbutil->getNextID($is_prod);
        
        $base_url = $this->config->item('base_url');
        redirect ($base_url."/cdeep3m_models/upload/".$model_id);
    }
    
    public function edit($model_id=0)
    {
        $this->load->helper('url');
        $remote_service_prefix =  $this->config->item('remote_service_prefix');
        $dbutil = new DB_util();
        $cutil = new Curl_util();
        
        $mjson = $dbutil->getModelJson($model_id);
        $data['mjson'] = $mjson;
        
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
        
        $data['title'] = 'CDeep3M Metadata Edit';
        $data['base_url'] = $this->config->item('base_url');
        $data['model_id'] = intval($model_id);
        
        $hasImage = false;
        if(!is_null($sjson) && isset($sjson->Size) && $sjson->Size > 0)
            $hasImage = true;
        
        $data['hasDisplayImage'] = $hasImage;
        $this->load->view('templates/header', $data);
        $this->load->view('cdeep3m/edit/metadata_edit_display', $data);
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
        $data['user_role'] = $dbutil->getUserRole($data['username']);
        
        $data['base_url'] = $this->config->item('base_url');
        $data['model_id'] = intval($model_id);
        
        $data['title'] = 'CDeep3M Upload';
        $this->load->view('templates/header', $data);
        $this->load->view('cdeep3m/model_upload_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    
    /*
    public function process_model_upload()
    {
        
        for($i=0;$i<10;$i++)
        {
            
            sleep(1);
        }
    }
    */
}