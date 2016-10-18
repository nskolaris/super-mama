<?php
class AppController extends Controller
{


	var $helpers = array('Html', 'Form', 'Time', 'Javascript','Text','Session', 'Conversions');
	// Javascript es necesario porque puse el jquery en el layout
	var $components = array('RequestHandler','Session');
	var $uses = array('Usuario','FacebookM','Foto');

	var $SessionUsuario;
	
	
	function checkLogin() {
		// busca el usuario de la base de datos
		$fb_user = $this->fbGetUserProfile();
		$error = '';

		//CakeLog::write('debug', var_export($fb_user));
		
		if ($usr = $this->Usuario->login($fb_user, $error)) {
			if (empty($usr['Usuario']['nrodocumento']) || ($usr['Usuario']['nrodocumento']==0)) {
				$this->redirect('/usuarios/add');
			} else {
				$this->SessionUsuario = $usr['Usuario'];
			}
		} else {
			$this->setFlash($error);
			$this->redirect('/usuarios/error');
		}
	
	}
	
	function _loginSession($usr) {
		$this->SessionUsuario = $usr;
	}
	
	function _logoutSession() {
        $this->SessionUsuario = null;
	}

	
	function getUsuario() {
		return $this->SessionUsuario;
	}
	
	function fbGetUserProfile() {
	
		$facebook = $this->fbConnect();
		$user = $facebook->getUser();
 
		
		if ($user) {
			try {
				$user_profile = $facebook->api('/me');
				$token = $facebook->getAccessToken();
				$this->Session->write('atoken',$token);
				// Vemos si le tenemos que pedir que se haga fan
				
				$likeInfo = $facebook->api('/me/likes/'.APP_PAGE);
				if (empty($likeInfo['data'])) {
					$this->set('hazteFan', true);
				}
				
			} catch(Exception $e) {
				debug($e);
			}
			return $user_profile;
		} else {
			// le pedimos que se registre
			
			if (APP_DEBUGMODE) {
				$this->Session->setFlash('No se puede obtener el token de facebook');
				$this->redirect('/usuarios/error');
			} else {
				$params = array('scope'=>'email,publish_stream,user_photos');
				// DEBUG
				// $params['redirect_uri'] = 'http://apps-lanzallamas.com.ar/supermama/cake/';
				$loginUrl = $facebook->getLoginUrl($params); 
				// echo "pide registracion $loginUrl";
				echo "<script type='text/javascript'>top.location.href = '$loginUrl';</script>";
				exit; 
			}
			
		}
	}
	
	function fbGetVisitorProfile() {
		$facebook = $this->fbConnect();
		$user = $facebook->getUser();
		
		if ($user) {
			try {
				$user_profile = $facebook->api('/me');
			} catch(Exception $e) {
				//debug($e);
				return false;
			}
			return $user_profile;
		} else {
			return false;
		}
	}

function fbgetSignedRequest(){
		$facebook = $this->fbConnect();
		$signed_request = $facebook->getSignedRequest();
		return $signed_request;
	
	}


	function fbConnect() {
	
		// traeme el idfacebook
		App::import('Vendor', 'facebook/facebook');
		
		$config = array();
		$config['appId'] = APP_FB_APPID;
		$config['secret'] = APP_FB_APPSECRET;
		$config['cookie'] = true;
		$config['fileUpload'] = true;

		$facebook = new Facebook($config);
		
		$token = $this->Session->read('atoken');
		if ($token!=NULL)
		{
			$facebook->setAccessToken($token);
			
		}
		
		
		
		
		if (APP_DEBUGMODE) {
			$facebook->setAccessToken(APP_FB_DEBUGTOKEN);
		}
		
		return $facebook;

	}

	
	/*
	 * se encarga de administrar el tema de la pagina actual
	 * la guarda en la session y despues la recupera si fuera necesaria
	 * sirve para los casos en que estando en la pagina 3 se borra un registro y se vuelve al listado
	 * (para que vuelva automaticamente a la pagina 3)
	 * 
	 * @return	int	pagina
	 */
	function _getPagina() {
	
		if( isset($this->params['named']['page']) ) {
			$pagina = intval($this->params['named']['page']);
			$this->Session->write($this->name.'.page', $pagina);
		} else {
			if( $this->Session->check($this->name.'.page') ) {
				$pagina = $this->Session->read($this->name.'.page');
			} else {
				$pagina = 1;
			}
		}
		return $pagina;
		
	}
		
	function _getFormat() {
		$this->config_format	= isset ($this->form['format']) ? $this->form['format'] : 
								(isset($this->params['named']['format']) ? $this->params['named']['format'] : '');
	}
	
	function renderFormat() {
		if ($this->config_format == 'json') {
			$this->layout = null;
			$this->render('/elements/json');
		}
	}
	
	function getRealIP() {
        if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
		
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
       
        return $_SERVER['REMOTE_ADDR'];
    }
	
}
