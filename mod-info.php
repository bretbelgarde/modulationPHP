<?php
require("config.php");
require('lib/rb.php');

R::setup('sqlite:data/mods.db');

function readInfo(ZipArchive $archive, $fileName) {
	$jsonData = '';
	$file = $archive->getStream($fileName);

	if (!$file) return false;

	while (!feof($file)) {
		$jsonData .= fread($file, 2);
	}

	return json_decode($jsonData, true);
}

function getInfoFiles(ZipArchive $archive) {
	$fileList = array();

	for($i=0;$i<$archive->numFiles;$i++) {
		$fileData = $archive->statIndex($i);
		if (strpos($fileData['name'], '.info') !== false) {
			$fileList[] = $fileData['name'];
		}
	}

	return $fileList;

}

function isNewMod($md5) {
    
    $mod = R::find('mod', ' md5 = ? ', [$md5]);
    
    if (empty($mod)) return true;
    
    return false;
}

function getMod($md5) {

    $mod = R::find('mod', ' md5 = ? ', [$md5]);

    if (empty($mod)) return false;

    $mod = array_values($mod);
    return $mod[0];
}

$path = MODPATH . '/';
$urlParamRaw = $_GET['file'];
$fileName = urldecode($urlParamRaw);
$fullPath = $path.$fileName;
$md5Hash = md5_file($fullPath);

# Do if the mod is new
if (isNewMod($md5Hash)) {
	$jarFile = new ZipArchive();

	if($jarFile->open($fullPath)) {
		$modinfo = array();

		foreach (getInfoFiles($jarFile) as $file) {
			$modinfo[] = readInfo($jarFile, $file);
		}
	}

	if ($modinfo) {

		$storage = new RecursiveIteratorIterator(new RecursiveArrayIterator($modinfo), RecursiveIteratorIterator::SELF_FIRST);

		foreach ($storage as $key => $value) {
			if ($key === 'modid'        && !isset($flattened['modid']))       $flattened['modid'] = $value;
			if ($key === 'name'         && !isset($flattened['name']))        $flattened['name'] = $value;
			if ($key === 'description'  && !isset($flattened['description'])) $flattened['description'] = $value;
			if ($key === 'version'      && !isset($flattened['version']))     $flattened['version'] = $value;
			if ($key === 'url'          && !isset($flattened['website']))     $flattened['website'] = $value;
			if (($key === 'authorList') && !isset($flattened['authors']) ||
				($key === 'authors'     && !isset($flattened['authors'])))    $flattened['authors'] = implode(", ", $value);
		}

		$response['success'] = true;

	} else {
		$flattened['error'] = "Unable to find mod info file for {$fileName}";
		$response['success'] = false;
	}

	$flattened['filename'] = $fileName;
	$flattened['md5'] = $md5Hash;
	$flattened['packurl'] = SERVERPATH;

} else {
	if ($mod = getMod($md5Hash)) {
		$flattened = array(
            'filename'    => htmlentities($mod->filename),
            'md5'         => htmlentities($mod->md5),
            'name'        => htmlentities($mod->name),
            'modid'       => htmlentities($mod->modid),
            'version'     => htmlentities($mod->version),
            'packurl'     => htmlentities($mod->packurl),
            'type'        => htmlentities($mod->type),
            'download'    => htmlentities($mod->download),
            'website'     => htmlentities($mod->website),
            'authors'     => htmlentities($mod->authors),
            'donation'    => htmlentities($mod->donation),
            'description' => htmlentities($mod->description)
        );

		$response['success'] = true;

	} else {
		$flattened['error'] = "You should not be here! If you get this response something weird has happend, like a nonexistant entry in the database!";
		$response['success'] = false;
	}
}

$response['data'] = $flattened;

echo json_encode($response);
