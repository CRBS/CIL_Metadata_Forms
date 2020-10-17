<?php
$start = time();
$url = "http://discworld.crbs.ucsd.edu:9249/gen_superpixels/10121?N=500&overwrite=true";
$doneFile = "/export2/temp/super_pixel/SP_10121/overlays/DONE.txt";
$mainDir = "/export2/temp/super_pixel/SP_10121";
$dir = "/export2/temp/super_pixel/SP_10121/overlays/";
error_reporting(0);
$done = false;
$index = 0;
while(true)
{
    /*if(stat($doneFile) !== false)
        break;*/
    
    
    /*if(is_readable ($doneFile))
        break;*/
    /*if(file_exists($doneFile))
        break;*/
    /*$f = fopen($doneFile, "r");
    if($f !== false)
        break;*/
    $response =  exec("ls ".$mainDir);
    echo "---------Response:".$index."---".$response;
    $files = scandir($dir);
     echo "\nScan";
     foreach($files as $file)
     {
         
         echo "\nFile:".$file;
         if(strcmp($file, "DONE.txt") == 0)
             $done = true;
     }
     
     echo "\n--------------";
     if($done)
         break;
    /*if(file_exists($doneFile))
        break;
    
    clearstatcache();*/
    sleep(1);
    $index++;
}

$end = time();
$runtime = $end - $start;
echo "\n Runtime:".$runtime;
