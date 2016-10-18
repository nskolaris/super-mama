<?php
class FacebookM extends AppModel
{

	var $useTable = false;

	function participando($facebook) {
		$params = array(
			'name' => "Concurso SuperMamá - Banco Supervielle",
			'description' => 'Estoy participando del concurso "SuperMamá" del Banco Supervielle. ¡Hacé click acá y creá la tuya! Podés ganar reproductores MP3 y cuadros con tu ilustración!',
			// TODO
//			'picture' => 'http://k-dreams.com/fb_apps/compumundo_olimpiadas/img/img_publish_feed.gif',
//							'link' => 'http://www.facebook.com/CompumundoArg/app_255006517878823',
			// TODO confirmar
			'link' => APP_FB_TAB,
		);
		$facebook->api('/me/feed', 'post', $params);
	}
	
	// comentario, id, url, filename
	function crearFoto($facebook, $Foto) {
	
		try {
			$facebook->setFileUploadSupport(true);
			$params = array(
				'url' => HOST . URL_FOTOS . '/' . $Foto['filename'],
			);
			$params['message'] = $Foto['comentario'] . 
								 "\n\n" . 
								 "Concurso SuperMamá - Banco Superviellle\n
Estoy participando del concurso \"SuperMamá\" del Banco Supervielle. ¡Hacé click acá y creá la tuya! Podés ganar reproductores MP3 y cuadros con tu ilustración!.\n" . APP_URL;
			
			if (APP_DEBUGMODE) {
				$params['url'] = 'http://sphotos-f.ak.fbcdn.net/hphotos-ak-prn1/77154_138016976249930_3265789_n.jpg';
			}

			$upload_photo = $facebook->api('/me/photos', 'post', $params);
        
			return $upload_photo;
			
		} catch (Exception $e) {
			//debug($e);
			return false;
		}
	}
	
	function publicarFoto($facebook, $Foto) {

		$params = array(
			'name' => "Concurso SuperMamá - Banco Supervielle",
			'picture' => HOST . URL_FOTOS . '/' . $Foto['filename'],
			'link' => getShareUrlPhoto($Foto),
		);
		$params['description'] = 'Acabo de crear una SuperMamá para el Concurso del Banco Supervielle. Hacé click acá y creá las tuyas. Participás por reproductores mp3 y cuadros con tus ilustraciones.';
		if (APP_DEBUGMODE) {
			$params['url'] = 'http://sphotos-f.ak.fbcdn.net/hphotos-ak-prn1/77154_138016976249930_3265789_n.jpg';
		}

		$facebook->api('/me/feed', 'post', $params);
	}
	
	
}