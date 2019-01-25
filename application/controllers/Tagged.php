<?php

include_once 'DB_util.php';

class Tagged extends CI_Controller
{

    public function images($tag)
    {
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