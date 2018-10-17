<?php

class Image_metadata extends CI_Controller
{
    public function edit($image_id="0")
    {
        if(strcmp($image_id, "0") == 0)
        {
            show_404();
            return;
        }
        
        
    }
}

