<?php

include_once 'General_util.php';
include_once 'NcmirDbUtil.php';
include_once 'DB_util.php';

include_once 'Curl_util.php';

class Ncmir_databrowser extends CI_Controller
{
    public function browse_json($mpid)
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
        
        $cil_meta_auth = $this->config->item('cil_meta_auth');
        $cil_meta_url_prefix = $this->config->item('cil_meta_url_prefix');
        $data['base_url'] = $base_url;
        $username = $data['username'];
        $isNcmir = $this->isNcmirMember($username);
        if($isNcmir)
        { 
            $data['enable_file_tree'] = true;
            $cil_meta_url = $cil_meta_url_prefix."/Ncmir_data_rest/data_jail_dirs/".$mpid;
            $response = $cutil->auth_curl_get($cil_meta_auth, $cil_meta_url);
            
            
            header('Content-Type: application/json');
            echo $response;
            
        }
    }
    
    public function browse($mpid)
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
        
        $cil_meta_auth = $this->config->item('cil_meta_auth');
        $cil_meta_url_prefix = $this->config->item('cil_meta_url_prefix');
        $data['base_url'] = $base_url;
        $username = $data['username'];
        $isNcmir = $this->isNcmirMember($username);
        if($isNcmir)
        { 
            $data['enable_file_tree'] = true;
            $cil_meta_url = $cil_meta_url_prefix."/Ncmir_data_rest/data_jail_dirs/".$mpid;
            $response = $cutil->auth_curl_get($cil_meta_auth, $cil_meta_url);
            $mpjson = json_decode($response);
            //$cjson = json_decode($response);
            //header('Content-Type: application/json');
            //echo $response;
            //echo $response;
            //echo "<br/>".$cil_meta_auth;
            //echo "<br/>".$cil_meta_url_prefix;
            $data['mpjson'] = $mpjson;
            
            if($mpjson->success)
            {
                $data['title'] = "NCMIR Data Browser";
                $this->load->view('templates/tree_header', $data);
                $this->load->view('ncmir_archive/ncmir_file_tree_display', $data);
            }
            else
            {
                echo "<b>Cannot locate your MPID: ".$mpid."</b>";
            }
        }
    }
    
    public function view()
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
        
        
        $data['base_url'] = $base_url;
        $username = $data['username'];
        $isNcmir = $this->isNcmirMember($username);
        if($isNcmir)
        {    
            $ndbutil = new NcmirDbUtil();
            $username = "ccdbuser";
            $mpidArray = $ndbutil->getAllMPIDs($username);
            
            $data['ncmir_user'] = $username;
            $data['mpidArray'] = $mpidArray;
            $data['title'] = "NCMIR Data Browser";
            $this->load->view('templates/header', $data);
            $this->load->view('ncmir_archive/ncmir_databrowser_display', $data);
            $this->load->view('templates/footer', $data);
        }
        else 
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
    }
    
    public function mpidinfo($mpid)
    {
        $ndbutil = new NcmirDbUtil();
        header('Content-Type: application/json');
        $array = $ndbutil->getMpidInfo($mpid);
        
        if(is_null($array))
        {
            $array = array();
            $array['success'] = false;
            
        }
       
        echo json_encode( $array );
        
    }
    private function isNcmirMember($username)
    {
        $isNcmir = false;
        $dbutil = new DB_util();
        $userGroupArray = $dbutil->getUserGroups($username);
        if(!is_null($userGroupArray))
        {
            foreach($userGroupArray as $userGroup)
            {
                if(strcmp($userGroup['group_name'], "ncmir")==0)
                {
                    $isNcmir = true;
                    break;
                }
            }
        }
        
        return $isNcmir;
    }
}


