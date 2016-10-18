<div class="logo-supercole-datos"></div>
<div class="logo-supervielle-datos"></div>
<div class="mesa-fondo">
<div class="fondo-resultado">
<div class="utiles-resultados-1"></div>
<div class="utiles-resultados-2"></div>
<div class="ahorro-utiles-resultados"></div>
<div class="texto-resultados"></div>
<div class="tiempo-resultados"><p><?php echo $juego['Juego']['tiempo']; ?></p></div>
<?php echo $this->Html->link('',array('controller'=>'front', 'action'=>'memotest'),array('class'=>'boton-volver-a-jugar')); ?>
<?php echo $this->Html->link('','http://todoslosdias.supervielle.com.ar',array('target'=>'_blank','class'=>'boton-conoce-todas-las-promos')); ?>
<?php echo $this->Html->link('','javascript:sendRequestViaMultiFriendSelector();',array('class'=>'boton-invitar')); ?>
</div>
</div>