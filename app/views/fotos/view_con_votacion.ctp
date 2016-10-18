<?php echo $html->css('jquery-ui-1.8.21.custom_usuarios_add');?>
<?php echo $javascript->link('fb.js'); ?>
<script>
$(document).ready(function(){						
		
	$(function() {
		$( "#dialogFlash" ).dialog({
			'autoOpen': false,
			'modal':true,
			'width':400,
			'resizable':false
		});
	});
});

$(document).ready(function(){
	
	$('#enviar_email').focusin(function(){
//		console.log('focusin');
		$('#enviar_email').val('');
	});
	
	$('#enviar_email').focusout(function(){
		//$('#enviar_email').val('enviar por email');
	});
	  	
	
	$('li.foto img').click(function() {
		$('li.foto').removeClass('selected');
		$(this).parents('.foto').addClass('selected');
		$('#photo').attr('src',$(this).attr('src'));
		$('#votacion #btn_votar_fotos_view')
			.removeClass('voted').removeClass('voting')
			.click(function() {
				validateVisitor(votar, {});
			});
		$('#votacion #cant_votos').html(getShareMetadata('cantVotos'));
	});
	
	$('#fotos_view_1 #btn_votar_fotos_view').click(function() {
		validateVisitor(votar, {});
	});
	
	
})
function getShareMetadata(param) {
	return $.trim($('li.foto.selected .'+param).html());
}

function compartirFotoOwner() {
	sharePhotoOwner(getShareMetadata('sharePhotoUrl'), getShareMetadata('sharePhotoPicture'));
}
function compartirFoto() {
	sharePhoto(getShareMetadata('sharePhotoUrl'), getShareMetadata('sharePhotoPicture'));
}
function descargar() {
	var id = $('li.foto.selected .idPhoto').html();
	if (id != '') {
		window.location.href = '<?php echo $html->url('/fotos/download/'); ?>' + id;
	}
}

function votar() {
/*
	if (!validateVisitor()) {
		return;
	}
*/	

	var id = $('li.foto.selected .idPhoto').html();
	if (id != '') {
		$('body').css('cursor', 'progress');
		$('#fotos_view_1 #btn_votar_fotos_view')
			.unbind('click')
			.addClass('voting')
//			.css('opacity', '.3')
		;
		
		$.post('<?php echo $html->url('/votos/add/'); ?>' + id, {}, function(data) {
			$('body').css('cursor', 'auto');
			data = $.parseJSON(data);
			if (data.status < 0) {
				if (data.message != '') {
					$("#dialogFlash .msg").html(data.message);
					$("#dialogFlash").dialog('open');
				}
			} else if (data.status > 0) {
//				var $foto = $('#fotos li.foto[data-id='+data.id+']');
				var $foto = $('#fotos_view_1');
				var $votos = $foto.find('#cant_votos');
				$votos.html (parseInt($votos.html()) + 1);
				$('#btn_votar_fotos_view')
					.unbind('click')
					.removeClass('voting')
					.addClass('voted')
				;
			}
		});
//		window.location.href = '<?php echo $html->url('/votos/add/'); ?>' + id;
	}
}

function enviar_por_email(email,foto){
	console.log(foto);
	console.log(email);
}
</script>
<div id="fotos_view_container">
	<div class="bloque bloque_1 <?php echo ($this->params['isAjax'] ? 'popup' : ''); ?>" id="fotos_view_1">
		<div class="botones_top">
			<?php if ($this->params['isAjax']) { ?>
				<div id="btn_close_dialog"><?php echo $html->image('close_dialog.png'); ?></div>
			<?php } else { ?>
				<div class="btn_galeria_inactivo"><?php echo $html->link($html->image('btn_galeria_inactivo_fotos_view.png'),'/fotos/gallery',array('escape'=>false));?></div>
			<?php } ?>
		</div>
	
		<div class="clear"></div>
		
		<div class="botones_middle">
			<div class="avatar_fb">
				<div class="imagen"><img src="http://graph.facebook.com/<?php echo $usr['fb_id']; ?>/picture?type=large" /></div>
				<?php $nombre = $usr['nombre_completo'];?>
				<?php $nombre_final = str_replace(' ','<br />',$nombre);?>
				<div class="nombre_completo"><?php echo $nombre_final;?></div>
			</div>
			<?php if (false && !isset($fbusr['id'])) { ?>
				<div class="btn_crear_foto">
					<?php echo $html->link($html->image('btn_crear_foto_fotos_view.png'),'/',array('escape'=>false));?>
				</div>
			<?php } ?>
		</div>
		
		<div class="clear"></div>
		
		<div class="fotos">
			<div class="principal">
				<span class="txt_supermama"></span>
				<img id="photo" src="<?php echo URL_FOTOS.'/'.$Foto['Foto']['filename']; ?>" width="500" height="500" />
			</div>
			<div class="restantes">
				<h3>Versiones</h3>
				<ul class="menu_fotos">
					<?php for ($i=0 ; $i<sizeof($Fotos) ; $i++) { ?>
						<li class="foto <?php echo ($Fotos[$i]['Foto']['id']==$Foto['Foto']['id'] ? 'selected' : ''); ?>" id="foto_<?php echo $i; ?>">
							<div class="img"><img src="<?php echo URL_FOTOS.'/'.$Fotos[$i]['Foto']['filename']; ?>" /></div>
							<span class="eliminar_icon" id="foto_<?php echo $i; ?>"><?php echo $html->link('','javascript:borrar('.$Fotos[$i]['Foto']['id'].')');?></span>
							<span style="display:none;" class="metadata sharePhotoUrl"><?php echo getShareUrlPhoto($Fotos[$i]['Foto']); ?></span>
							<span style="display:none;" class="metadata sharePhotoPicture">
								<?php echo HOST.URL_FOTOS.'/'.substr($Fotos[$i]['Foto']['filename'],0,-4); ?>_250_250.jpg
							</span>
							<span style="display:none;" class="metadata idPhoto"><?php echo $Fotos[$i]['Foto']['id']; ?></span>
							<span style="display:none;" class="metadata cantVotos"><?php echo (int)$Fotos[$i]['Foto']['voto_count']; ?></span>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>

			
		<div class="votacion" id="votacion">
			<div class="btn_votar_fotos_view" id="btn_votar_fotos_view">
				<?php echo $html->image('btn_votar_fotos_view.png'); ?>
			</div>
			<div class="votos"><div id="cant_votos"><?php echo (int)$Foto['Foto']['voto_count']; ?></div>&nbsp;votos</div>
		</div>
			
		
	</div>
	
	<div class="clear"></div>
	
	<div class="bloque bloque_2" id="usuarios_index_2">
		<div class="top_links">
			<div class="enviar_email" style="margin-top:66px;">
				<!--<?php echo $form->create('Foto',array('action'=>'enviar'));?>
				<input type="text" name="data[Foto][email]" id="enviar_email" value="Enviar por email" /><?php echo $html->link($html->image('btn_enviar_email.png'),'javascript:void(0)',array('escape'=>false,'class'=>'btn_enviar_email','onclick'=>'enviar_por_email('.$Fotos[0]['Foto']['id'].')'));?>
				<input type="hidden" name="data[Foto][id]" id="fotoId" />-->
			</div>
		</div>
		<div class="clear"></div>
		<div class="bottom_links">
			<?php
				if (isset($fbusr) && ($usr['fb_id'] == $fbusr['id'])) {
					$share_function = 'javascript:compartirFotoOwner()';
				} else {
					$share_function = 'javascript:compartirFoto()';
				}
			?>
			<div class="facebook"><?php echo $html->link($html->image('btn_fb.png'),$share_function,array('escape'=>false));?></div>
			<div class="descargar"><?php echo $html->link($html->image('btn_descargar.png'),'javascript:descargar()',array('escape'=>false));?></div>
		</div>
	</div>
</div>

<div id="dialogFlash" title="" style="display:none;">
	<h3>Error</h3>
	<div class="msg"></div>
</div>
