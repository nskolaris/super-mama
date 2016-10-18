<?php echo $this->Html->link('crea tu foto',array('controller'=>'usuarios', 'action'=>'index'),array('class'=>'boton-participar')); ?>
<table><tr>
			<td class="text"><?php echo $html->link('Acepto que he leído las <br /> bases y condiciones','javascript:void(0)',array('onclick'=>'abrirDialog(\'dialogBases\')','escape'=>false));?></td>
			<td class="value"><input type="checkbox" name="data[Usuario][bases]" class="checkbox" <?php echo (isset($this->data['Usuario']['bases']) ? ($this->data['Usuario']['bases'] == 'on' || $this->data['Usuario']['bases'] == 1 ? 'checked' : '') : '');?>/></td>
</tr></table>
<br><?php echo $this->Html->link('mira la galeria',array('controller'=>'fotos', 'action'=>'gallery'),array('class'=>'boton-participar')); ?>
<br><?php echo $this->Html->link('mira la galeria de tus amiguitos sos',array('controller'=>'fotos', 'action'=>'galleryAmigos'),array('class'=>'boton-participar')); ?>