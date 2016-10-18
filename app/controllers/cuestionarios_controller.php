<?php
class CuestionariosController extends AppController {

	var $name = 'Cuestionarios';
	var $uses = array('Cuestionario','Punto'); 


	function view($id) {

		// valida que este online y que el usuario lo pueda responder
		$this->checkLogin();
		$usr = $this->getUsuario();

		$Cuestionario = $this->Cuestionario->get($id);
		if (empty($Cuestionario)) {
			$this->Session->setFlash('El cuestionario que intenta responder no se encuentra disponible. (código de error: 210)');
			$this->redirect(array('controller'=>'usuarios', 'action'=>'error'));
		}
		
		$this->_iniciarCuestionario($Cuestionario);
		
		// o tengo que ver si me devolvio algun error?
		$Puntos = $this->Punto->getSumByCuestionario($usr['id'], $id);
		
		if (isset($Puntos[$id])) {
			$this->Session->setFlash('Ya ha respondido el cuestionario. (código de error: 211)');
			$this->redirect(array('controller'=>'usuarios', 'action'=>'error'));
		}
		
		$this->set('Cuestionario', $Cuestionario);
		
	}
	
	// NOTE tenemos que chequear todo de vuelta para evitar hackeos
	function save() {
	
		$this->checkLogin();
		$usr = $this->getUsuario();
		
		if (empty($this->params['form']['cuestionario_id'])) {
			$this->Session->setFlash('No tiene un cuestionario. (código de error: 220)');
			$this->redirect(array('controller'=>'usuarios', 'action'=>'error'));
		}
		
		$idcuestionario = $this->params['form']['cuestionario_id'];

		// Una validacion extra, vemos que no lo haya respondido
		$Puntos = $this->Punto->getSumByCuestionario($usr['id'], $idcuestionario);
		if (isset($Puntos[$idcuestionario])) {
			$this->Session->setFlash('Ya ha respondido el cuestionario. (código de error: 221)');
			$this->redirect(array('controller'=>'usuarios', 'action'=>'error'));
		}
		
		$resp = $this->Cuestionario->validar($this->params['form']);
		
		if (!isset($resp['result'])) {
			$this->Session->setFlash('No se puede validar el cuestionario. (código de error: 222)');
			$this->redirect(array('controller'=>'usuarios', 'action'=>'error'));
		}
		
		$error = '';
		
		$resp['request_ip'] = $this->getRealIP();
		$extra_data = json_encode($resp);
		
		if (!$this->Punto->saveCuestionario(
			$usr['id'], 
			$idcuestionario,
			($resp['result']['puntos_correctos'] - $resp['result']['puntos_bonus']),
			$extra_data,
			$error
		)) {
			$this->Session->setFlash($error . '(código de error: 223)');
			$this->redirect(array('controller'=>'usuarios', 'action'=>'error'));
		}
		
		if (!$this->Punto->saveBonus(
			$usr['id'], 
			$idcuestionario,
			$resp['result']['puntos_bonus'],
			$extra_data,
			$error
		)) {
			$this->Session->setFlash($error . '(código de error: 224)');
			$this->redirect(array('controller'=>'usuarios', 'action'=>'error'));
		}
		
		$P = $this->Punto->getSumByUsuario($usr['id']);
		$this->Usuario->savePuntos($usr['id'], $P);

		$this->redirect(array('action'=>'result', $idcuestionario));
		
	}
	
	
	function result($idcuestionario = null) {
	
		$this->checkLogin();
		$usr = $this->getUsuario();
		
		if (is_null($idcuestionario)) {
			$this->Session->setFlash('No tiene un cuestionario. (código de error: 230)');
			$this->redirect(array('controller'=>'usuarios', 'action'=>'error'));
		}

		$Puntos = $this->Punto->getByCuestionario($usr['id'], $idcuestionario);
		if (empty($Puntos)) {
			$this->Session->setFlash('No ha respondido este cuestionario. (código de error: 231)');
			$this->redirect(array('controller'=>'usuarios', 'action'=>'error'));
		}
		
		$resp = json_decode($Puntos[$idcuestionario][0]['Punto']['extra_data'], true);
	
		$this->set('Result', $resp['result']);
		$this->set('Usuario', $usr);
		
	
	}
	
	/*
	 * recibe por POST
	 * 
	 */
	function prevalidate($id) {
	
		// NOTE lo sacamos porque demora mucho si hace el checkeo
		//$this->checkLogin();
		
		$this->layout = null;
		Configure::write('debug', '0');		// esto es para que no muestre el debug nunca
		
		$status = 1;
		$error_msg = '';
		$es_correcta = false;
		
		// validamos los parametros
		if ($status > 0) {
			if (!isset($this->params['form']['idpregunta']) || !isset($this->params['form']['idopcion'])) {
				$status = -1;
				$error_msg = 'Faltan parametros';
			}
		}
			
		// validamos la session
		if ($status > 0) {
			if ($SessionCuestionario = $this->Session->read('cuestionario_'.$id)) {
				if ($SessionCuestionario['started'] + 600 < time() ) {
					$status = -11;
					$error_msg = 'Se vencio el tiempo';
				}
			} else {
				$status = -10;
				$error_msg = 'No tiene iniciado el cuestionario';
			}
		}
		
		// validamos la respuesta
		if ($status > 0) {
			if ($preg = $SessionCuestionario['Preguntas'][$this->params['form']['idpregunta']]) {
				$es_correcta = ($preg['opcion_correcta'] == $this->params['form']['idopcion']);
			} else {
				$status = -11;
				$error_msg = 'No tiene esa pregunta';
			}
		}
		
		$data = array(
			'status' => $status,
			'error_msg' => $error_msg,
			'es_correcta' => $es_correcta,
		);
		
		$this->set('data', $data);
		// NOTE aca tuve este problema con el explorer que no manda bien este json
		echo intval($es_correcta);
		exit();
		$this->render('/elements/json');
		
	}
	
	
	function _iniciarCuestionario ($Cuestionario) {
		$SessionCuestionario = array(
			'started' => time(),
		);
		foreach ($Cuestionario['Pregunta'] as &$Pregunta) {
			$opcion_correcta = false;
			foreach ($Pregunta['Preguntaopcion'] as &$Opcion) {
				if ($Opcion['es_correcta'] == 1) {
					$opcion_correcta = $Opcion['id'];
					break;
				}
			}
			$SessionCuestionario['Preguntas'][$Pregunta['id']] = array(
				'opcion_correcta' => $opcion_correcta,
			);
		}
		$this->Session->write('cuestionario_'.$Cuestionario['Cuestionario']['id'], $SessionCuestionario);
	}
	
	
}