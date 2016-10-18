<div id="fotos_view_container">
	<div class="bloque bloque_1" id="fotos_view_1">
		<div class="botones_top">
			<div class="btn_galeria_inactivo"><?php echo $html->link($html->image('btn_galeria_inactivo_fotos_view.png'),'javascript:void(0)',array('escape'=>false,'onclick'=>'cerrarDialog(\'dialogFotosView\')'));?></div>
		</div>
	
		<div class="clear"></div>
		
		<div class="botones_middle">
			<div class="avatar_fb">
				<div class="imagen"></div>
				<?php $nombre = 'Jose Manuel Costello';?>
				<?php $nombre_final = str_replace(' ','<br />',$nombre);?>
				<div class="nombre_completo"><?php echo $nombre_final;?></div>
			</div>
			<div class="btn_crear_foto">
				<?php echo $html->link($html->image('btn_crear_foto_fotos_view.png'),array('controller'=>'fotos','action'=>'crear'),array('escape'=>false));?>
			</div>
		</div>
		
		<div class="clear"></div>
		
		<div class="fotos">
			<div class="principal"><span class="txt_supermama"><?php echo $html->image('txt_supermama.png');?></span></div>
			<div class="restantes">
				<h3>Versiones</h3>
				<ul class="menu_fotos">
					<li class="foto selected" id="foto_1">
						<div class="img"><?php echo $html->image('img_ejemplo_chica.png');?></div>						
					</li>
					<li class="foto" id="foto_2">
						<div class="img"><?php echo $html->image('img_ejemplo_chica.png');?></div>						
					</li>				
				</ul>
			</div>
		</div>

		<div class="votacion">
			<div class="btn_votar_fotos_view">
				<?php echo $html->link($html->image('btn_votar_fotos_view.png'),array('javascript:void(0)'),array('escape'=>false,'onclick'=>'votar()'));?>			
			</div>
			<div class="cant_votos">7.250 votos</div>
		</div>
		
	</div>
	
	<div class="clear"></div>
	
	<div class="bloque bloque_2" id="usuarios_index_2">
		<div class="top_links">
			<div class="enviar_email">
				<input type="text" name="email" id="enviar_email" value="Enviar por email" /><?php echo $html->link($html->image('btn_enviar_email.png'),'javascript:void(0)',array('escape'=>false,'class'=>'btn_enviar_email','onclick'=>'enviar_por_email(this.value)'));?>
			</div>
		</div>
		<div class="clear"></div>
		<div class="bottom_links">
			<div class="facebook"><?php echo $html->link($html->image('btn_fb.png'),'#',array('escape'=>false));?></div>
			<div class="descargar"><?php echo $html->link($html->image('btn_descargar.png'),'#',array('escape'=>false));?></div>
		</div>
	</div>
</div>