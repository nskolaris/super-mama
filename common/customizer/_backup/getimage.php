<?php
/*
@param	$_GET['url']	tiene que ser un jpg
*/
set_time_limit(0);
header('Content-type: image/jpeg');
$url = $_GET['url'];
echo file_get_contents($url);