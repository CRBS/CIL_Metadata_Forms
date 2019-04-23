<?php

class Upload_images extends CI_Controller
{
    public function index()
    {
        $data['title'] = "Upload image";
        $this->load->view('templates/header', $data);
        $this->load->view('upload/upload_main_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
}

