<?php
$start = time();
$url = "http://discworld.crbs.ucsd.edu:9249/gen_superpixels/10121?N=500&overwrite=true";
$doneFile = "/export2/temp/super_pixel/SP_10121/overlays/DONE.txt";
unlink($doneFile);
echo "\n".$url;
$data = "";
$auth = "willy:super_pixel";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($doc)));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, $auth);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
$response  = curl_exec($ch);
curl_close($ch);
echo "\n".$response;

/*
while(true)
{
    if(file_exists($doneFile))
        break;
    
    sleep(1);
}

$end = time();
$runtime = $end - $start;
echo "\n Runtime:".$runtime;
*/