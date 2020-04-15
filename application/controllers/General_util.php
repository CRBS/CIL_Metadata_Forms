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




