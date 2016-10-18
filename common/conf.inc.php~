<?php
define('HOST', 'https://apps-lanzallamas.com.ar');	// se usa cuando se quieren poner urls absolutas

define('PATH_COMMON', ROOT . '/common');
define('URL_ROOT', '/supermama2');	// sin la barra al final
define('URL_FOTOS', URL_ROOT.'/common/img/fotos');	// sin la barra al final

define('URL_FRONT', URL_ROOT.'/app');
define('URL_IMG', URL_ROOT.'/app/img');

define('APP_DEBUGMODE', false);
define('APP_FB_APPID', '211645485590601');
define('APP_FB_APPSECRET', '6acae9ee8ccb4aca04e87ffaef362443');
define('APP_PAGE', '159428650749212');
define('APP_FB_TAB', 'http://www.facebook.com/Drublus-Factory/app_211645485590601');
define('APP_URL', 'http://apps.facebook.com/211645485590601');
define('APP_FB_DEBUGTOKEN', 'AAABoW7WjLN4BAKzIKiNGCIrv5JLtcIbwSatkrTgoHKAG83d0UeydCaWs9sBcYMsOYy0ojRcjDMSWuoNeUnHgqzGaKVcAppdgyEQeJPRiITzRQnJ3');


// mas textos en Models/Facebook_m.php
// tambien hay links


function getShareUrlPhoto($Foto) {
	if (isset($Foto['id']) && !empty($Foto['id'])) {
		return APP_URL . '/mi-supermama-' . $Foto['id'];
//		return 'http://apps.facebook.com/114743098682590/ver_supermama_' . $Foto['id'];
	} else {
		return '';
	}
}
	
