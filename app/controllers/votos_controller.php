<?php
class VotosController extends AppController {

	var $name = 'Votos';
	var $uses = array('Voto', 'Foto');

	function add($idfoto = null) {
	
		if (is_null($idfoto)) {
			$this->salir(
				'Debe especificar una foto.', 
				'/usuarios/'
			);
			return;
		}
		
		$Foto = $this->Foto->get($idfoto);
		if (empty($Foto)) {
			$this->salir(
				'La foto no existe o ya fue borrada.', 
				'/usuarios/'
			);
			return;
		}

		if (!($usr = $this->fbGetVisitorProfile())) {
			$this->salir(
				'No se puede obtener el usuarioro.', 
				'/fotos/view_con_votacion/'.$idfoto
			);
			return;
		}
		
		// validamos que no sea el duenio
		/*
		if ($Foto['Usuario']['fb_id'] == $usr['id']) {
			$this->salir(
				'No puede votar una foto propia.', 
				'/fotos/view_con_votacion/'.$idfoto
			);
			return;
		}
		*/
		
		$Voto = array(
			'Voto' => array(
				'foto_id' => $idfoto,
				'fb_id' => $usr['id'],
				'extra_data' => json_encode($usr),
				'ip' => $this->getRealIP(),
			),
		);
		$error = '';
		if (!$this->Voto->validateAdd($Voto, $error)) {
			$this->salir(
				$error, 
				'/fotos/view_con_votacion/'.$idfoto
			);
			return;
		}
		
		if (!$this->Voto->save($Voto)) {
			$this->salir(
				'No se pudo votar. Intente nuevamente.', 
				'/fotos/view_con_votacion/'.$idfoto
			);
			return;
		}
		
		$extra = array(
			'id' => $idfoto,
		);
		$this->salir('', '/fotos/view_con_votacion/'.$idfoto, $extra);

	}
	
	function salir($message, $url, $extra = array()) {
		configure::write('debug', 0);
		
		$data = array(
			'status' => (!empty($message) ? -1 : 1),
			'message' => $message,
		);
		$data = array_merge($data, $extra);
		$this->set('data', $data);
		$this->render('/elements/json');
		
	}
	
	/*
	function exportar() {
        Configure::write('debug',0);
		
       	$condiciones = array( 
			'Voto.deleted' => null,
		);
		
		$Datos = $this->Voto->find('all', array(
			'conditions' => $condiciones,
			'order' => 'Voto.id',
			'group' => 'Voto.fb_id',
			'recursive' => -1,
		));
		
		$rowheaders = array(
			'fb_userid', 'nombre', 'apellido', 'email',
		);
		$rows = array();
		$i = 0;
		foreach ($Datos as &$D) {
			$Dato = $D['Voto'];
			$ExtraData = json_decode($Dato['extra_data'], true);
			$row = array(
				$Dato['fb_id'],
				$this->_format_xls(@$ExtraData['first_name']),
				$this->_format_xls(@$ExtraData['last_name']),
				$this->_format_xls(@$ExtraData['email']),
			);
			$rows[] = $row;
			
			$i++;
		}
		$this->set(compact('rowheaders', 'rows'));
		$this->layout = null;
		$this->render('/elements/xls');
//		$this->autoRender = false;
	
	}
	*/
	
	function _format_xls($dato) {
		return utf8_decode(str_replace (';', '', $dato));
	}
	
	
}