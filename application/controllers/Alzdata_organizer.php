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
        $section_id = $this->input->post('section_id', TRUE);
        
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
        $dbutil->adUpdateSectionId($image_id, $section_id);
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
        $image_viewer_prefix = $this->config->item('image_viewer_prefix');
        $token = $dbutil->getAuthToken($data['username']);
        $imageViewerParams = array();
        $imageViewerParams['username'] = $username;
        $imageViewerParams['image_viewer_prefix'] = $image_viewer_prefix;
        $imageViewerParams['token'] = $token;
        
        
        $allImageInfoArray = $dbutil->adGetAllImageInfo();
        $blockArray = $dbutil->adGetAllBlocks();
        $sectionArray = $dbutil->getAdSerialSections();
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
                    $blockItem['name'] = "Block".$block['block_name'];
                    $blockItem['is_url'] = false;
                   
                    
                    $negateArray = array();
                    //array_push($negateArray, "roi_id");
                    //$blockItem = $this->handleGraphImages("block_id",$negateArray, $blockItem, $imageViewerParams);
                    //$blockItem = $this->handleROIs($blockItem,$imageViewerParams);
                    $blockItem = $this->handleSections($blockItem, $imageViewerParams);
                    array_push($tempArray,$blockItem );
                }
            }
            if(count($tempArray) > 0)
            {
                //echo "<br/>Temp array count:".count($tempArray);
                $item['children'] = $tempArray;
                
            }
            
            array_push($biopsyArray['children'], $item);
        }
        
        $data['graph_json_str'] = json_encode($biopsyArray, JSON_UNESCAPED_SLASHES);
        //echo "<br/>".$data['graph_json_str'];
        $this->load->view('templates/header2', $data);
        $this->load->view('alzdata/graph_relations_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    private function handleSections($blockItem,$imageViewerParams)
    {
        $dbutil = new DB_util();
        $sectionArray = $dbutil->getAdSerialSections();
        $hasChildren = false;
        foreach($sectionArray as $section)
        {
            if(intval($section['block_id']) == intval($blockItem['id']))
            {
                $hasChildren = true;
            }
        }
        
        
        if($hasChildren)
        {
            if(!array_key_exists("children", $blockItem))
                $blockItem['children'] = array();
            foreach($sectionArray as $section)
            {
                $sItem = array();
                $sItem['id'] = intval($section['id']);
                $sItem['name'] = "Section:".$section['serial_section_name'];
                $sItem['is_url'] = false;
                $sItem = $this->handleROIs($sItem, $imageViewerParams);
                $negateArray = array();
                array_push($negateArray, "roi_id");
                $sItem = $this->handleGraphImages("section_id",$negateArray, $sItem, $imageViewerParams);
                array_push($blockItem['children'], $sItem);
            }
            
        }
        return $blockItem;
    }
    
    private function handleROIs($sItem,$imageViewerParams)
    {
        $dbutil = new DB_util();
        
        
        $roiArray = $dbutil->getROIs();
        $hasChildren = false;
        foreach($roiArray as $roi)
        {
            if(intval($roi['serial_section_id']) == intval($sItem['id']))
            {
                $hasChildren = true;
            }
        }
        
        if($hasChildren)
        {
            if(!array_key_exists("children", $sItem))
                $sItem['children'] = array();
            foreach($roiArray as $roi)
            {
                if(intval($roi['serial_section_id']) == intval($sItem['id']))
                {
                    $roiItem = array();
                    $roiItem['id'] = intval($roi['id']);
                    $roiItem['name'] = "ROI:".$roi['roi_name'];
                    $roiItem['is_url'] = false;
                    $negateArray = array();
                    $roiItem = $this->handleGraphImages("roi_id",$negateArray, $roiItem, $imageViewerParams);
                    array_push($sItem['children'], $roiItem);
                }
            }
            
        }
        return $sItem;
    }
    
    private function handleGraphImages($id_type,$negateArray, $parentItem, $imageViewerParams)
    {
        //echo "<br/>handleGraphImages";
        $dbutil = new DB_util();
        $allImageInfoArray = $dbutil->adGetAllImageInfo();
        $hasChildren = false;
        if(count($negateArray)==0)
            $hasChildren = true;
        else
        {
            foreach($allImageInfoArray as $imageInfo)
            {
                if(intval($imageInfo[$id_type]) == intval($parentItem['id']))
                {
                    $hasChildren = false;

                    $isEmpty = true;
                    foreach($negateArray as $negateKey)
                    {
                        //echo "<br/>NegateKey:".$negateKey."---data:".$imageInfo[$negateKey];
                        if(!is_null($imageInfo[$negateKey]))
                        {
                            $isEmpty = false;
                        }
                    }

                    if($isEmpty)
                    {
                        $hasChildren = true;
                        break;
                    }
                    //else if(count($negateArray)==0)
                    //{
                    //    $hasChildren = true;
                    //    break;
                    //}
                }
            }
        }
        
        
        
        if($hasChildren)
        {
            //echo "<br/>hasChildren";
            if(!array_key_exists("children", $parentItem))
                $parentItem['children'] = array();
            foreach($allImageInfoArray as $imageInfo)
            {
                //echo "<br/>".intval($imageInfo[$id_type])."----".intval($parentItem['id']);
                if(intval($imageInfo[$id_type]) == intval($parentItem['id']))
                {
                    if(count($negateArray)==0)
                    {
                        $imageItem = array();
                            $imageItem['id'] = $imageInfo['id'];
                            $imageItem['name'] = "Image:".$imageInfo['image_id'].", ".$imageInfo['image_type'];
                            $imageItem['is_url'] = true;
                            $imageItem['url'] = $imageViewerParams['image_viewer_prefix']."/internal_data/".$imageInfo['image_id'].
                                    "?username=".$imageViewerParams['username']."&token=".$imageViewerParams['token'];
                            array_push($parentItem['children'], $imageItem);
                    }
                    
                    $isEmpty = true;
                    foreach($negateArray as $negateKey)
                    {
                    //echo "<br/>NegateKey:".$negateKey."---data:".$imageInfo[$negateKey];
                        
                        if(!is_null($imageInfo[$negateKey]))
                        {
                            $isEmpty =false;
                        }
                    }
                    if(count($negateArray) > 0 && $isEmpty)
                    {
                        $imageItem = array();
                            $imageItem['id'] = $imageInfo['id'];
                            $imageItem['name'] = "Image:".$imageInfo['image_id'].", ".$imageInfo['image_type'];
                            $imageItem['is_url'] = true;
                            $imageItem['url'] = $imageViewerParams['image_viewer_prefix']."/internal_data/".$imageInfo['image_id'].
                                    "?username=".$imageViewerParams['username']."&token=".$imageViewerParams['token'];
                            array_push($parentItem['children'], $imageItem);
                    }
                    
                }
            }
        }
        //else 
        //{
        //    echo "<br/>No children";
        //}
        return $parentItem;
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
            
            
            $sectionArray  = $dbutil->getAdSerialSections();
            $data['section_str'] = json_encode($sectionArray,  JSON_UNESCAPED_SLASHES);
            
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
