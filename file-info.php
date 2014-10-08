<?php
	
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

	

	$path = '/home/bret/games/minecraft/ATLauncher/Instances/SouthCraftv10x/mods/';
	$urlParamRaw = $_GET['file'];
	$fileName = urldecode($urlParamRaw);
	$fullPath = $path.$fileName;
	$md5Hash = md5_file($fullPath);
	
	$jarFile = new ZipArchive();

	if($jarFile->open($fullPath)) {
		$modinfo = array();

		foreach (getInfoFiles($jarFile) as $file) {
			$modinfo[] = readInfo($jarFile, $file);
		}
	}

	if ($modinfo) {
		
		$flattened['filename'] = $fileName;
		$flattened['md5'] = $md5Hash;

		$storage = new RecursiveIteratorIterator(new RecursiveArrayIterator($modinfo), RecursiveIteratorIterator::SELF_FIRST);
		
		foreach ($storage as $key => $value) {
			if ($key === 'modid'        && !isset($flattened['modid']))       $flattened['modid'] = $value;
			if ($key === 'name'         && !isset($flattened['name']))        $flattened['name'] = $value;
			if ($key === 'description'  && !isset($flattened['description'])) $flattened['description'] = $value;
			if ($key === 'version'      && !isset($flattened['version']))     $flattened['version'] = $value;
			if ($key === 'url'          && !isset($flattened['website']))     $flattened['website'] = $value;
			if (($key === 'authorList') && !isset($flattened['authors']) || 
				($key === 'authors'     && !isset($flattened['authors'])))    $flattened['authors'] = $value;
		}

		$response['success'] = true;

	} else {
		$flattened['error'] = "Unable to read mcmod info file";
		$response['success'] = false;
	}

	$response['data'] = $flattened;

	echo json_encode($response);
	
	
	