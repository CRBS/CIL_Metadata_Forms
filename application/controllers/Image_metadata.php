<?php
include_once 'Curl_util.php';
class Image_metadata extends CI_Controller
{
    public function edit($image_id="0")
    {
        if(strcmp($image_id, "0") == 0)
        {
            show_404();
            return;
        }
        $esPrefix = $this->config->item('elasticsearch_host');
        $url = $esPrefix."/ccdbv8/data/".$image_id;
        $cutil = new Curl_util();
        $json_str = $cutil->curl_get($url);
        if(is_null($json_str))
        {
            show_404();
            return;
        }
        $json = json_decode($json_str);
        if(!isset($json->found))
        {
            show_404();
            return;
        }
        
        if($json->found)
        {
            $data['title'] = "CIL | Edit ".$image_id;
            $data['data_json'] = $json;
            $this->load->view('templates/header', $data);
            $this->load->view('edit/edit_main', $data);
            $this->load->view('templates/footer', $data);
        }
        else
        {
            show_404();
            return;
        }
    }
}

