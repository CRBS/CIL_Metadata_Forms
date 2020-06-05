<?php

class General_util
{
    public function startsWith($haystack, $needle)
    {
         $length = strlen($needle);
         return (substr($haystack, 0, $length) === $needle);
    }

    public function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }
    
    
    public function deleteCdeep3mPredictionResult($cropID, $cdeep3m_prediction_location, $images_upload_location)
    {
        date_default_timezone_set( 'America/Los_Angeles' );
        
        if(!is_numeric($cropID))
            return;
        
        $deleteUploadLog = $images_upload_location."/".$cropID."_delete.log";
        $deleteLog = $cdeep3m_prediction_location."/".$cropID."_delete.log";
        
        $predictionFolder = $cdeep3m_prediction_location."/".$cropID;
        $cmd = "rm -rf ".$predictionFolder;
        error_log("\n".date("Y-m-d h:i:sa")."----Cmd:".$cmd,3,$deleteLog);
        $result = shell_exec($cmd);
        error_log("\n".date("Y-m-d h:i:sa")."----Result:".$result,3,$deleteLog);
        
        $imageFolder = $images_upload_location."/".$cropID;
        $cmd = "rm -rf ".$imageFolder;
        error_log("\n".date("Y-m-d h:i:sa")."----Cmd:".$cmd,3,$deleteUploadLog);
        $result = shell_exec($cmd);
        error_log("\n".date("Y-m-d h:i:sa")."----Result:".$result,3,$deleteUploadLog);
        
        if(!file_exists($predictionFolder) && !file_exists($predictionFolder))
        {
            $array = array();
            $array['success'] = true;
            return $array;
        }
        else
        {
            $message = "";
            if(file_exists($predictionFolder))
            {
                $message = $message."<br/>Folder (".$predictionFolder.") cannot be deleted";
            }
            if(file_exists($imageFolder))
            {
                $message = $message."<br/>Folder (".$imageFolder.") cannot be deleted";
            }
            
            $array = array();
            $array['success'] = false;
            $array['error_message'] = $message;
            return $array;
        }
       
    }

    public function convertZip2Tar($folder,$zipFile)
    {
        if($this->endsWith($zipFile, ".zip"))
        {
            $name = str_replace(".zip","",$zipFile);
            $tempFolder = $folder."/temp";
            mkdir($tempFolder);
            $unzip_cmd = "cd ".$folder."; unzip ".$zipFile." -d ".$tempFolder;
            $uresult = shell_exec($unzip_cmd);

            $tar_cmd = "cd ".$tempFolder."; tar -cvf ".$name.".tar *";
            $tresult = shell_exec($tar_cmd);

            $tarPath = $tempFolder."/".$name.".tar";
            if(file_exists($tarPath))
            {
               $move_cmd = shell_exec("mv ".$tarPath." ".$folder);
               shell_exec($move_cmd);

               $tarPath = $folder."/".$name.".tar";
               if(file_exists($tarPath))
               {
                    return $name.".tar";
               }

            }
        }

        return $zipFile;
            
    }
    
    public function createRetrainImageTar($retrainID, $parentFolder, $retrainImageFolder)
    {
        if(is_null($retrainID) || !is_numeric($retrainID))
            return NULL;
        
        if(!file_exists($parentFolder))
            return NULL;
        
        if(!file_exists($retrainImageFolder))
            return NULL;
        
        //$tar_cmd = "cd ".$parentFolder."; tar -cvf retrain_images.tar ".$retrainImageFolder;
        $tar_cmd = "cd ".$retrainImageFolder."; tar -cvf retrain_images.tar *.png *.tif *.jpg";
        error_log($tar_cmd,3,$parentFolder."/tar.log");
        $tresult = shell_exec($tar_cmd);
        
        $file_path = $retrainImageFolder."/retrain_images.tar";
        return $file_path;
    }
    
    public function createRetrainLabelTar($retrainID, $parentFolder, $retrainLabelFolder)
    {
        if(is_null($retrainID) || !is_numeric($retrainID))
            return NULL;
        
        if(!file_exists($parentFolder))
            return NULL;
        
        if(!file_exists($retrainLabelFolder))
            return NULL;
        
        //$tar_cmd = "cd ".$parentFolder."; tar -cvf retrain_labels.tar ".$retrainLabelFolder;
        $tar_cmd = "cd ".$retrainLabelFolder."; tar -cvf retrain_labels.tar *.png *.tif *.jpg";
        error_log($tar_cmd,3,$parentFolder."/tar.log");
        $tresult = shell_exec($tar_cmd);
        
        $file_path = $parentFolder."/retrain_labels.tar";
        return $file_path;
    }
}




