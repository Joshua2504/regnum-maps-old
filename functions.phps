<?php

/* Map functions */
function getpic($label,$prefix = '',$type = 'png') 
{
	$wd = '/home/kiirani/www/public_html/stuff/regnum/images/';
	chdir($wd);
	$name = $label->shortname;
	$dir = $label->realm;
	if(is_dir($dir.'/'.$name))
		$dir = $dir.'/'.$name;
	$files = scandir($dir);	
	$pattern = '/^'.$prefix.$name.'(-[\d]*)?\.'.$type.'$/i';

	$imgs = array_filter($files,create_function('$subj','return preg_match(\''.$pattern.'\',$subj);'));
	sort($imgs);
	$min = 0;
	$max = count($imgs);

	if($max > 0 ) {
		$max--;
		$file = $imgs[rand($min,$max)];
		return $dir.'/'.$file;
	}
	return false;
}

