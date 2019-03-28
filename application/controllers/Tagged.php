<?php

include_once 'Curl_util.php';
include_once 'General_util.php';
include_once 'DB_util.php';
include_once 'Ontology_util.php';
include_once 'Dimension_util.php';
class Tagged extends CI_Controller
{

    public function images($tag)
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        if(strcmp($tag, "0") == 0)
        {
            show_404();
            return;
        }
        
        $base_url = $this->config->item('base_url');
        $login_hash = $this->session->userdata('login_hash');
        
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_tag/".$tag);
            return;
        }
        
        $dbutil = new DB_util();
        $idArray = $dbutil->findIdsByTag($tag);
        $data['tag'] = $tag;
        $data['title'] = "Image from ".$tag;
        $data['id_array'] = $idArray;
        $this->load->view('templates/header', $data);
        $this->load->view('tags/display_summary', $data);
        $this->load->view('templates/footer', $data);
         
    }
    

}