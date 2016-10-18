<?php
class InvitacionesController extends AppController {

	var $name = 'Invitaciones';
	var $uses = array('Invitacion'); 
	
	function index() {
	
		// muestra el estado de las invitaciones, etc
		$this->checkLogin();
		$usr = $this->getUsuario();
		
		$Invitaciones = $this->Invitacion->getAll($usr['fb_userid']);
		$this->set('Invitaciones', $Invitaciones);
		$this->set('Usuario', $usr);
		
	}
	
	
	function invite() {
	
		$this->checkLogin();

		//$facebook = $this->fbConnect();
		
		// TODO aca le muestra el listado de amigos
		// filtrado por los que ya invite? o estados de las invitaciones?
		//$Friends = $facebook ->api('/me/friends');
		//$this->set('Friends', $Friends['data']);
		

	}
	
	// este es el callback del dialog de facebook
	// recibe por GET
	// algo tipo https://k-dreams.com/fb_apps/compumundo_olimpiadas/?request=328713347213415&to[0]=100002280499749&to[1]=100002227184445#_=_
	// esta tiene que ser robusta porque estoy muy expuesto a ataques
	function add() {
	
		$this->checkLogin();
		$usr = $this->getUsuario();

		$idrequest = $this->params['url']['request'];
		if (empty($idrequest)) {
			$this->Session->setFlash('No tiene invitacion. (código de error: 320)');
			$this->redirect(array('controller'=>'usuarios', 'action'=>'error'));
		}
		
		$facebook = $this->fbConnect();
		$req = $facebook->api('/'.$idrequest);
		
		if (empty($req)) {
			$this->Session->setFlash('La invitacion no es valida. (código de error: 321)');
			$this->redirect(array('controller'=>'usuarios', 'action'=>'error'));
		}
		
		if ($req['from']['id'] != $usr['fb_userid']) {
			$this->Session->setFlash('La invitacion no es valida. (código de error: 322)');
			$this->redirect(array('controller'=>'usuarios', 'action'=>'error'));
		}
		
		// ahora si, grabamos las invitaciones
		$extra_data = array(
			'usuario_id' => $usr['id'], 
			'from_fb_name' => $req['from']['name'], 
			'fb_requestid' => $req['id'], 
		);
		
		// TODO aca podria validar que en to no me viene el id del usuario
		// porque se podria llegar a sumar unos puntos
		// y aca deberia ir a buscar los nombres?
		$cant_grabados = $this->Invitacion->crearByUsuario(
			$this->params['url']['to'], 
			$usr['fb_userid'], 
			json_encode($extra_data)
		);
		
		$this->layout = null;
	
	}

	// NOTE tenemos que chequear todo de vuelta para evitar hackeos
	function accept ($from_fb_userid = null) {
	
		$this->checkLogin();
		$usr = $this->getUsuario();
		
		// por si acaso verificamos que efectivamente tenga pendings
		// no alcanza con getPendientes, porque esta hasPendings tambien se fija que no tenga ninguna aceptada
		if (!$this->Invitacion->hasPendientes($usr['fb_userid'])) {
			$this->Session->setFlash('No tiene invitaciones pendientes. (código de error: 330)');
			$this->redirect(array('controller'=>'usuarios', 'action'=>'error'));
		}

		if (is_null($from_fb_userid)) {

			$Invitaciones = $this->Invitacion->getPendientes($usr['fb_userid']);
			if (empty($Invitaciones)) {
				$this->Session->setFlash('No tiene invitaciones pendientes. (código de error: 331)');
				$this->redirect(array('controller'=>'usuarios', 'action'=>'error'));
			}
			
			$this->set('Invitaciones', $Invitaciones);
				
		} else {
		
			// buscamos esa invitacion
			$Invitacion = $this->Invitacion->getByFromUser($usr['fb_userid'], $from_fb_userid);
			if (empty($Invitacion)) {
				$this->Session->setFlash('No tiene invitaciones pendientes de ese usuario. (código de error: 332)');
				$this->redirect(array('controller'=>'usuarios', 'action'=>'error'));
			}

			$ret = $this->Invitacion->accept($Invitacion['Invitacion']['id'], $usr['fb_userid']);
			if (!$ret) {
				$this->Session->setFlash('No se pudo aceptar la invitación. (código de error: 333)');
				$this->redirect(array('controller'=>'usuarios', 'action'=>'error'));
			}
			
			// busco el usuario destino
			$extra_data = json_decode($Invitacion['Invitacion']['extra_data']);
			if (isset($extra_data->usuario_id)) {
				$usuario_id = $extra_data->usuario_id;
			} else {
				$this->loadModel('Usuario');
				$Usuario = $this->Usuario->findByFbUserid($from_fb_userid);
				if (!empty($Usuario)) {
					$usuario_id = $Usuario['Usuario']['id'];
				}
			}
			if (!$usuario_id) {
				$this->Session->setFlash('No se puede determinar el beneficiario. (código de error: 334)');
				$this->redirect(array('controller'=>'usuarios', 'action'=>'error'));
			}
			
			$this->loadModel('Punto');
			
			$error = '';
			if (!$this->Punto->saveAmigo(
				$usuario_id, 
				$Invitacion['Invitacion']['id'],
				$this->Punto->getPuntajeAmigo(),
				'',
				$error
			)) {
				$this->Session->setFlash($error . '(código de error: 335)');
				$this->redirect(array('controller'=>'usuarios', 'action'=>'error'));
			}
			
			$P = $this->Punto->getSumByUsuario($usuario_id);
			$this->Usuario->savePuntos($usuario_id, $P);
			
			// TODO hay que borrar los requests del facebook
			$this->redirect(array('controller'=>'usuarios', 'action'=>'dashboard'));

		}
	
	}
	

	
}