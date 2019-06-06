<?php
 
if (empty($FILES) || $FILES['file']['error']) 
{
  die('{"OK": 0, "info": "Failed to move uploaded file."}');
}
 
$chunk = isset($REQUEST["chunk"]) ? intval($REQUEST["chunk"]) : 0;
$chunks = isset($REQUEST["chunks"]) ? intval($REQUEST["chunks"]) : 0;
 
$fileName = isset($REQUEST["name"]) ? $REQUEST["name"] : $FILES["file"]["name"];
$filePath = "C:/Test2/$fileName";
 
 
// Open temp file
$out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
if ($out) {
  // Read binary input stream and append it to temp file
  $in = @fopen($FILES['file']['tmp_name'], "rb");
 
  if ($in) {
    while ($buff = fread($in, 4096))
      fwrite($out, $buff);
  } else
    die('{"OK": 0, "info": "Failed to open input stream."}');
 
  @fclose($in);
  @fclose($out);
 
  @unlink($FILES['file']['tmp_name']);
} else
  die('{"OK": 0, "info": "Failed to open output stream."}');
 
 
// Check if file has been uploaded
if (!$chunks || $chunk == $chunks - 1) {
  // Strip the temp .part suffix off
  rename("{$filePath}.part", $filePath);
}
 
die('{"OK": 1, "info": "Upload successful."}');
