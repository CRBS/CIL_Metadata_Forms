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
    
    
    public function do_upload()
    {
        $upload_location = $this->config->item('upload_location');
        $config2 = array(
        'upload_path' => $upload_location,
        'allowed_types' => "gif|jpg|png|jpeg",
        'overwrite' => TRUE,
        'max_size' => "12048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
        'max_height' => "4000",
        'max_width' => "4000"
        );
        $this->load->library('upload', $config2);
        
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
                        $info = pathinfo($full_path);
                        $file_name =  basename($full_path,'.'.$info['extension']);
                        
                        $zip = new ZipArchive;
                        $zipFile = $upload_location."/".$file_name.".zip";
                        
                        echo "<br/>".$zipFile;
                        if(file_exists($zipFile))
                        {
                            unlink($zipFile);
                        }
                        
                        if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) 
                        {
                            $zip->addFile($full_path, basename($full_path));
                            $zip->close();
                            echo '<br/>Zip ok';
                        } 
                        else 
                        {
                            echo '<br/>Zip failed';
                        }
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
}

