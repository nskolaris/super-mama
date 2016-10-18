<script>
function enviar_datos(){
	
	if($('#bases').attr('checked')=='checked'){
		document.forms["FormDatos"].submit();
	}else{
		alert('Debe estar de acuerdo con las bases y condiciones');
	}

}

</script>

<div class="logo-supercole-datos"></div>
<div class="logo-supervielle-datos"></div>
<div class="detalles-datos"></div>
<div class="input-datos">
<div class="utiles-datos"></div>
<div class="form-datos">

			<?php 
			echo $this->Form->create('Contacto',array('id'=>'FormDatos','url'=>array('controller'=>'front','action'=>'datos')));

				echo '<p>Nombre:</p>';
				echo $this->Form->input('Usuario.nombre', array('label'=>false,'value'=>$datosfb['first_name'],'required'=>true,'id'=>'nombre'));
				echo '<p>Apellido:</p>';
				echo $this->Form->input('Usuario.apellido', array('label'=>false,'value'=>$datosfb['last_name'],'required'=>true,'id'=>'apellido'));
				echo '<p>DNI:</p>';
				echo $this->Form->input('Usuario.dni', array('label'=>false,'required'=>true,'id'=>'dni'));
				echo '<p>E-mail:</p>';
				if (isset($datosfb['email'])){$fbemail=$datosfb['email'];}else{$fbemail='';}
				echo $this->Form->input('Usuario.email', array('label'=>false,'value'=>$fbemail, 'type'=>'email','required'=>true,'id'=>'email'));
				echo '<p>Teléfono:</p>';
				echo $this->Form->input('Usuario.telefono', array('label'=>false,'required'=>true,'id'=>'telefono'));
				echo '<p>Provincia:</p>';
				echo $this->Form->input('Usuario.provincia', array('type'=>'select','options'=>$provincias,'label'=>false,'id'=>'provincia','required'=>true));
				echo '<p>Es cliente de banco Supervielle:</p>';
				echo $this->Form->input('Usuario.es_cliente', array('label'=>'','type' => 'checkbox','id'=>'cliente','class'=>'checkcliente'));
				echo '<p>Acepto las '.$this->Html->link('Bases y condiciones', '/files/basesycondiciones.pdf',array('target'=>'_blank'));


				echo $this->Form->input('bases', array('label'=>'','type' => 'checkbox','id'=>'bases','class'=>'checkcondiciones'));


			echo $this->Form->end(); ?>
			
</div>
<?php echo $this->Html->link('','javascript:enviar_datos();',array('class'=>'boton-continuar-datos')); ?>


</div>