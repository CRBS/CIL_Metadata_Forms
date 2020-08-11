<?php
include_once 'Curl_util.php';
include_once 'General_util.php';
include_once 'DB_util.php';

class Alzdata_organizer extends CI_Controller
{
    public function tag_image()
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        
        $data['title'] = "NCMIR | Organize Alz data";
        $base_url = $this->config->item('base_url');
        $data['base_url'] = $base_url;
        $login_hash = $this->session->userdata('login_hash');
        
        $data['username'] = $this->session->userdata('username');
        $username = $data['username'];
        
    
        $data['step1_text'] ='Step 1. Tag image';
        $data['is_step1_active'] = true;
        
        
        if(is_null($login_hash))
        {
            redirect($base_url."/home");
            return;
        }
        
        if(!$this->isUserNcmir($username))
        {
            redirect($base_url."/home");
        }
        
        $image_id = $this->input->post('image_name_id', TRUE);
        $image_type = $this->input->post('image_type_id', TRUE);
        $biopsy_id = $this->input->post('biopsy_source_id', TRUE);
        $block_id = $this->input->post('block_id', TRUE);
        $roi_id = $this->input->post('roi_id', TRUE);
        
        echo "<br/>".$image_id;
        echo "<br/>".$image_type;
        echo "<br/>Biopsy ID:".$biopsy_id;
        echo "<br/>Block ID:".$block_id;
        
        $exist = $dbutil->adImageExist($image_id);
        if(!$exist)
        {
            $dbutil->adInsertImageType($image_id, $image_type);
        }
        else
        {
            $dbutil->adUpdateImageType($image_id, $image_type);
        }
        
        $dbutil->adUpdateBiopsyNblock($image_id, $biopsy_id, $block_id);
        $dbutil->adUpdateRoi($image_id, $roi_id);
        
        redirect($base_url."/alzdata_organizer/start");
        
    }
            
    public function tag()
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        
        $data['title'] = "NCMIR | Organize Alz data";
        $base_url = $this->config->item('base_url');
        $data['base_url'] = $base_url;
        $login_hash = $this->session->userdata('login_hash');
        
        $data['username'] = $this->session->userdata('username');
        $username = $data['username'];
        
    
        $data['step1_text'] ='Step 1. Tag image';
        $data['is_step1_active'] = true;
        
        
        if(is_null($login_hash))
        {
            redirect($base_url."/home");
            return;
        }
        
        if($this->isUserNcmir($username))
        {
            
            $this->load->view('templates/header2', $data);
            $this->load->view('alzdata/tag_display', $data);
            $this->load->view('templates/footer', $data);
        }
        else  
        {
            redirect($base_url."/home");
            return;
        }
    }
    
    public function graph_relations()
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        
        $data['title'] = "NCMIR | Organize Alz data";
        $base_url = $this->config->item('base_url');
        $data['base_url'] = $base_url;
        $login_hash = $this->session->userdata('login_hash');
        
        $data['username'] = $this->session->userdata('username');
        $username = $data['username'];
        
    
        $data['step1_text'] ='Step 1. Select image to tag';
        $data['is_step1_active'] = true;
        
        
        if(is_null($login_hash))
        {
            redirect($base_url."/home");
            return;
        }
        
        $allImageInfoArray = $dbutil->adGetAllImageInfo();
        $blockArray = $dbutil->adGetAllBlocks();
        
        $biopsyJson = $dbutil->getBiopsyInfo();
        
        
        $biopsyArray = array();
        $biopsyArray['name'] = "Biopsy";
        $biopsyArray['is_url'] = false;
        $biopsyArray['children'] = array();
        foreach($biopsyJson as $biopsy)
        {
            $item = array();
            $item['id'] = $biopsy->id;
            $item['name']  = $biopsy->biopsy_name;
            $item['is_url'] = false;
            
            
            //$item['children'] = array();
            $tempArray = array();
            foreach($blockArray as $block)
            {
                if(intval($biopsy->id) == intval($block['biopsy_id']))
                {
                    //echo "<br/>In if block";
                    $blockItem = array();
                    $blockItem['id'] = $block['id'];
                    $blockItem['name'] = $block['block_name'];
                    $blockItem['is_url'] = false;
                    
                    array_push($tempArray,$blockItem );
                }
            }
            if(count($tempArray) > 0)
            {
                echo "<br/>Temp array count:".count($tempArray);
                $item['children'] = $tempArray;
                
            }
            array_push($biopsyArray['children'], $item);
        }
        
        $data['graph_json_str'] = json_encode($biopsyArray, JSON_UNESCAPED_SLASHES);
        echo "<br/>".$data['graph_json_str'];
        $this->load->view('templates/header2', $data);
        $this->load->view('alzdata/graph_relations_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    
    public function start()
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        
        $data['title'] = "NCMIR | Organize Alz data";
        $base_url = $this->config->item('base_url');
        $data['base_url'] = $base_url;
        $login_hash = $this->session->userdata('login_hash');
        
        $data['username'] = $this->session->userdata('username');
        $username = $data['username'];
        
    
        $data['step1_text'] ='Step 1. Select image to tag';
        $data['is_step1_active'] = true;
        
        
        if(is_null($login_hash))
        {
            redirect($base_url."/home");
            return;
        }
        
        if($this->isUserNcmir($username))
        {
            $data['alzDataJson'] = $dbutil->getImagesByDataCategory($username, 'alzheimer');
            
            $data['biopsy_info'] = $dbutil->getBiopsyInfo();
            
            $data['biopsyIdBlockStr'] = $dbutil->getBiopsyIdBlocks();
            
            $data['allImageInfoArray'] = $dbutil->adGetAllImageInfo();
            
            $roiArray = $dbutil->getROIs();
            $data['roi_str'] = json_encode($roiArray,  JSON_UNESCAPED_SLASHES);
            
            $this->load->view('templates/header2', $data);
            $this->load->view('alzdata/start_organize_display', $data);
            $this->load->view('templates/footer', $data);
        }
        else  
        {
            redirect($base_url."/home");
            return;
        }
    }
    
    
    private function isUserNcmir($username)
    {
        $dbutil = new DB_util();
        $userGroupArray = $dbutil->getUserGroups($username);
        if(!is_null($userGroupArray))
        {
            foreach($userGroupArray as $userGroup)
            {
                if(strcmp($userGroup['group_name'], "ncmir")==0)
                {
                    return true;
                }
            }
        }
        return false;
    }
    
}
