<?php

include_once 'Curl_util.php';
include_once 'General_util.php';
include_once 'DB_util.php';
include_once 'Ontology_util.php';
include_once 'Dimension_util.php';
include_once 'PasswordHash.php';
include_once 'MailUtil.php';
class Internal_data_viewer extends CI_Controller
{
    public function index($image_id)
    {
        $zindex = $this->input->get('zindex', TRUE);
        $lat = $this->input->get('lat', TRUE);
        $lng = $this->input->get('lng', TRUE);
        $zoom = $this->input->get('zoom', TRUE);
        
    }
            
    
}
