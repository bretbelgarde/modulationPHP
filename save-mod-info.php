<?php
/**
 * Save mod data to database
 **/

require('lib/rb.php');
R::setup('sqlite:data/mods.db');

function getMod($md5) {

    $mod = R::find('mod', ' md5 = ? ', [$md5]);

    if (empty($mod)) return false;

    $mod = array_values($mod);
    return $mod[0];
}

if (!isset($_POST)) die('No direct script access');

$md5 = $_POST['md5'];

$mod = getMod($md5);

if (!$mod) {
	$mod = R::dispense('mod');
}

foreach ($_POST as $key => $value) {
	if ($_POST != 'save') {
		$mod[$key] = htmlentities($value);
	}
}

$id = R::store($mod);

$response = array();

if ($id != 0) {
	$response['success'] = true;
	$response['data'] = 'Changes successfully saved.';
} else {
	$response['success'] = false;
	$response['data'] = 'Unable to save changes.';
}

echo json_encode($response);
R::close();