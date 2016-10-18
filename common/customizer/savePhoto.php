<?php
/*
Este script es un ejemplo
*/
if ($_REQUEST['c'] == 'error') {
	header("HTTP/1.0 404 Not Found");
} else {

	echo "https://apps-lanzallamas.com.ar/supermama/flash/";

	$fp = fopen( 'tmp/var_dump.txt', 'wb' );
	fwrite( $fp, var_export($_REQUEST,true) );
	fclose( $fp );

	//var_dump($_REQUEST['c']);
	$fp = fopen( 'tmp/result.jpg', 'wb' );
	fwrite( $fp, $GLOBALS[ 'HTTP_RAW_POST_DATA' ] );
	fclose( $fp );

}
?>