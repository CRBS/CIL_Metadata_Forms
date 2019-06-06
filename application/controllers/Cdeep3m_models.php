<?php

class Cdeep3m_models extends CI_Controller
{
    public function upload()
    {
        $data['title'] = 'CDeep3M Upload';
        $this->load->view('templates/header', $data);
        $this->load->view('cdeep3m/fine_upload_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    
    public function process_model_upload()
    {
        
        for($i=0;$i<10;$i++)
        {
            
            sleep(1);
        }
    }
    
}