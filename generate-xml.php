<?php
	require("config.php");
	require('lib/rb.php');	

	R::setup('sqlite:data/mods.db');




	$xml = "<mod name=\"{$name}\" version=\"{$version}\" url=\"{$url}\" file=\"{$filename}\" md5=\"{$md5}\" download=\"{$download}\" type=\"{$type}\" website=\"{$website}\" donation=\"{$donation}\" authors=\"$authors\" description=\"{$description}\" />";