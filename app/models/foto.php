<?php
class Foto extends AppModel
{

    var $name = 'Foto';
    var $useTable = 'fotos';
    
	var $actsAs = array('Containable');
	
	var $belongsTo = array(
    	'Usuario' => array(
			'className'    => 'Usuario',
    		'foreignKey'   => 'usuario_id',
			'counterCache' => true,
		),
    );
	
	function get($id) {
		return $this->find('first', array(
			'conditions' => array(
				'Foto.deleted' => null,
				'Foto.id' => $id,
			),
		));
	}
	
	function getUnaValida($id) {
		$Foto = $this->find('first', array(
			'conditions' => array(
				'Foto.id' => $id,
			),
		));
	
		if (empty($Foto)) {
			return false;
		}
		
		// vamos a buscar una de ese usuario
		return $this->find('first', array(
			'conditions' => array(
				'Foto.deleted' => null,
				'Foto.usuario_id' => $Foto['Foto']['usuario_id'],
			),
			'order' => 'Foto.id',
		));
		
	}

	function getByUsuario($idusuario) {
		return $this->find('all', array(
			'conditions' => array(
				'Foto.deleted' => null,
				'Foto.usuario_id' => $idusuario,
			),
			'order' => 'Foto.orden',
			'limit' => 3,
		));
	}
	
	
	function validateAdd($Datos) {
		$Foto = $this->find('first', array(
			'conditions' => array(
				'Foto.deleted' => null,
				'Foto.usuario_id' => $Datos['usuario_id'],
				'Foto.comentario' => $Datos['comentario'],
			),
		));
		return empty($Foto);
	}

	/*
	 * Reordena las fotos despues de borrar $Foto
	 * le resta una a todas las fotos que son mayores (en orden) que la borrada
	 * 
	 * @param	appModel	$Foto
	 * 
	 */
	function deprecate_setOrdenPostBorrado( $Foto ) {
	
		$idusuario = intval($Foto['usuario_id']);
		$orden_del_borrado = intval($Foto['orden']);
		
		if( !$idusuario || !$orden_del_borrado ) {
			return false;
		}
			
		$this->updateAll(
					array('Foto.orden' => 'Foto.orden - 1'),
					array('Foto.orden >' => $orden_del_borrado,
							'Foto.usuario_id' => $idusuario )	);

	}
	
	
	function getNextOrden( $Foto ) {
		if( $Orden = $this->find('first', array('fields' => 'Max(orden) as max', 
												'conditions'=>array('usuario_id' => $Foto['usuario_id']),
												'recursive' => -1)) ) {
			return intval($Orden[0]['max']) + 1;
		} else {
			return 1;
		}
	}	
}
