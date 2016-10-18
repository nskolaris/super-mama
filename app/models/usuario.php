<?php
class Usuario extends AppModel
{
    var $name = 'Usuario';
    
	var $validate = array(
   		'nombre_completo' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'allowEmpty' => false,
				'message' => 'El Nombre y el Apellido no pueden estar vacios.'
			)		
   		),   		   		
		'email' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'allowEmpty' => false,
				'message' => 'La direccion de E-mail no puede estar vacia.'
			),
			'email' => array(
				'rule' => array('email',true),
				'required' => true,
				'allowEmpty' => true,
				'message' => 'La direccion de E-mail no es valida.'
			)
		),
		'telefono' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => false,
				'allowEmpty' => false,
				'message' => 'El Teléfono no puede estar vacio.'
			)			
		),
		'nrodocumento'=> array(
			
			'numeric' => array(
				'rule' => 'numeric',
				'required' => true,	
				'allowEmpty' => false,
				'message' => 'El DNI no es válido.'			
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'allowEmpty' => false,
				'message' => 'El DNI no puede estar vacio.'
			),
		),
		'bases' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Debe aceptar las Bases y Condiciones.'
			)
		)
	);
	
	// devuelve Usuario o false
	function login($fb_user, &$error) {
	
		$usr = $this->find('first', array(
			'conditions' => array(
				'Usuario.fb_id' => $fb_user['id'],
			),
			'recursive' => -1,
		));
		
		if (empty($usr)) {
			// aca lo registro
			if (intval($fb_user['id']) == 0) {
				$error = 'No se puede obtener el usuario de facebook';
				return false;
			}
			
			$Datos = array(
				'fb_id' => $fb_user['id'],
				'email' => $fb_user['email'],
				'extra_data' => json_encode($fb_user),
			);
			if ($this->save($Datos, false)) {
				$Datos['id'] = $this->id;
				return $this->read(null,$this->id);
			} else {
				// TODO que hacemos aca?
				$error = 'No se pudo registrar el usuario';
				return false;
			}
		}
		return $usr;
	
	}

}