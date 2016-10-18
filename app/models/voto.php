<?php
class Voto extends AppModel
{

    var $name = 'Voto';
    var $useTable = 'votos';
    
	var $actsAs = array('Containable');
	
	var $belongsTo = array(
    	'Foto' => array(
			'className'    => 'Foto',
    		'foreignKey'   => 'foto_id',
			'counterCache' => true,
			'counterQuery' => array('deleted'=>null),
		),
    );
	
	public function validateAdd($Obj, &$error) {
	
/*	
		$cant = $this->find('count', array(
			'conditions' => array(
				'Voto.foto_id' => $Obj['Voto']['foto_id'],
				'Voto.fb_id' => $Obj['Voto']['fb_id'],
				// NOTE no lo tengo validado pero el webserver y la base de datos estan sincronizadas?
				// en este caso no es tan grave, pero cuidado
				'Voto.created >' => date('Y-m-d'),
			)
		));
		
		if ($cant > 0) {
			$error = "Sólo puedes votar una vez al día la misma foto.";
			return false;
		}
*/		


		// El usuario solo puede votar cada foto una sola vez durante todo el concurso
		$cant = $this->find('count', array(
			'conditions' => array(
				'Voto.foto_id' => $Obj['Voto']['foto_id'],
				'Voto.fb_id' => $Obj['Voto']['fb_id'],
			)
		));
		
		if ($cant > 0) {
			$error = "No puedes votar esta foto más de una vez.";
			return false;
		}
		
		
		// Parche para evitar la misma ip, foto
		$cant = $this->find('count', array(
			'conditions' => array(
				'Voto.foto_id' => $Obj['Voto']['foto_id'],
				'Voto.ip' => $Obj['Voto']['ip'],
				'Voto.created > DATE_SUB(NOW(), INTERVAL 5 MINUTE)',
			)
		));
		if ($cant > 0) {
			$error = "Ya se ha votado esta foto desde su dirección ip. Por favor intente nuevamente en unos minutos.";
			return false;
		}

		return true;
		
	}
	
	
}
