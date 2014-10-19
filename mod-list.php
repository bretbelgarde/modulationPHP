<?php
/**
 *  1. scan list of files
 *  2. get file md5, and search db for it
 *  3. if file is in db return extended information for listing
 *  4. else use default listing and add a highlight to the entry to indicate unknown entries
 *  5. smush this all up into a JSON string and pass it off to ajax request
 *  6. profit
 */

  require("config.php");
  require('lib/rb.php');
  
  R::setup('sqlite:data/mods.db');

  function getFileList($path) {

      $fileList = scandir($path);

      foreach ($fileList as $idx => $file) {
          if (!is_file($path.'/'.$file)) {
              unset($fileList[$idx]);
          }
      }

      $fileList = array_values($fileList);

      return $fileList;
  }

  function calculateMD5($filepath) {
     return md5_file($filepath);
  }

  function isNewMod($md5) {
    
    $mod = R::find('mod', ' md5 = ? ', [$md5]);
    
    if (empty($mod)) return true;
    
    return false;
  }

  function getModName($md5) {

    $mod = R::find('mod', ' md5 = ? ', [$md5]);

    if (empty($mod)) return false;
    $mod = array_values($mod);
    return $mod[0]->name;
  }

$extendedFileList = array();
$response = array();

$fileList = getFileList(MODPATH);

if (count($fileList) > 0) {
  foreach ($fileList as $file) {
    $md5 = calculateMD5(MODPATH.'/'.$file);
    $modEntry['filename'] = urlencode($file);
    $modEntry['md5'] = $md5;
    if (!isNewMod($md5)) {
      $modEntry['new'] = false;
      $modEntry['name'] = getModName($md5);
    } else {
      $modEntry['new'] = true;
      $modEntry['name'] = $file;
    }
    $extendedFileList[] = $modEntry;
  }

  $response['success'] = true;
  $response['data'] = $extendedFileList;

} else {

  $response['success'] = false;
  $response['error'] = 'Directory Empty. Please check path.';

}

echo json_encode($response);
