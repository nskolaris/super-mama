<?php echo $javascript->link('fb.js'); ?>
<?php echo $html->css('jquery-ui-1.8.21.custom_usuarios_add');?>
<?php echo $html->css('jquery-ui-1.8.21.custom_fotos_gallery');?>
<script>
	$(document).ready(function(){
	
		$( "#dialogFotosView" ).dialog({
			'dialogClass':'dialogFotosView',
			'autoOpen':false,
			'modal':true,
			'width':830,
			'draggable':false,
			'resizable':false,
			'position':'top',
		});
		
		$( "#dialogFlash" ).dialog({
			'autoOpen': false,
			'modal':true,
			'width':400,
			'resizable':false
		});

		<?php if (isset($idfoto) && !empty($idfoto)) { ?>
			abrirDialogFoto(<?php echo $idfoto; ?>);
		<?php } else { ?>
			traerFotos();
		<?php } ?>
		
	});
	
	function traerFotos() {
		url = "<?php echo Router::url(array('controller'=>'fotos','action'=>'gallery_page'));?>";
		params = {
			offset: $('#fotos li.foto:last').attr('data-id'),
			ranking: '<?php echo $param_ranking; ?>'
		};
		
		$.post(url, params, function(data) {
			if (data != '') {
				$('#fotos').append(data)
					.find('li.foto.nuevo')
						.find('img').click(function() {
							abrirDialogFoto($(this).parent().attr('data-id'));
						}).end()
						.find('.voto_inline').click(function() {
							validateVisitor(votarFoto, $(this).parent().attr('data-id'));
//							votarFoto($(this).parent().attr('data-id'));
						}).end()
						
						.mouseover(function() {
							$(this).find('.voto_inline').show();
						})
						.mouseout(function() {
							$(this).find('.voto_inline').hide();
						})
						
					.removeClass('nuevo')
					;
//					$('.fotos').animate({scrollTop:'+=808px'}, 'slow');
			} else {
				$('#btn_ver_mas').hide();
			}
		}, 'html');
	}
		
	
	function abrirDialogFoto(id){
		url = '<?php echo Router::url('/fotos/view_con_votacion/');?>'+id;
		params = {};
		abrirDialog('dialogFotosView');
		$.post(url, params, function(data){
			$('#dialogFotosView').html(data);
			$('#dialogFotosView #btn_close_dialog').click(function() {
				cerrarDialog('dialogFotosView');
				$('#dialogFotosView').html('');
			});
		},'html');
	}

	
	function abrirDialog(name){		
		$('#'+name).dialog('open');
	}
	
	function cerrarDialog(name){		
		$('#'+name).dialog('close');
	}
	
	function submitForm(){
		$('#UsuarioAddForm').submit();
	}
	
	
function votarFoto(id) {
/*
	if (!validateVisitor()) {
		return;
	}
*/

	$('body').css('cursor', 'progress');
	var $foto = $('#fotos li.foto[data-id='+id+']');
	$foto.find('.voto_inline')
		.unbind('click')
		.addClass('voting')
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
			var $foto = $('#fotos li.foto[data-id='+data.id+']');
			var $votos = $foto.find('.cant_votos .cant');
			$votos.html (parseInt($votos.html()) + 1);
			$foto.find('.voto_inline')
				.removeClass('voting')
				.addClass('voted')
			;
		}
	});
}
	
	
</script>
<div class="bloque bloque_1" id="fotos_gallery_1">
	<div class="botones_top">
		<?php if (true || isset($fbusr['id'])) { ?>
			<div class="btn_misupermama_inactivo" style="display:none;"><?php echo $html->link($html->image('btn_misupermama_inactivo.png'),array('controller'=>'usuarios','action'=>'index'),array('escape'=>false));?></div>
			<div class="btn_galeria_activo"><?php echo $html->image('btn_galeria_activo.png'); ?></div>
		<?php } else { ?>
			<div class="btn_crear_foto"><?php echo $html->link($html->image('btn_crear_foto_fotos_view.png'),'/',array('escape'=>false));?></div>
		<?php } ?>

	</div>
	
	<div class="clear"></div>
	<?php
	/*
	<div class="destacados">
	</div>
	*/
	?>
	
	<div class="fotos">
		<ul id="fotos"></ul>
	</div>
	<div class="btn_ver_mas" id="btn_ver_mas"><?php echo $html->link($html->image('btn_ver_mas_fotos_gallery.png'),'javascript:traerFotos()',array('escape'=>false));?></div>
</div>

<div class="bloque bloque_2" id="fotos_gallery_2">
	<?php echo $this->element('banner'); ?>
</div>

<div id="dialogFotosView" title=""></div>

<div id="dialogFlash" title="" style="display:none;">
	<h3>Error</h3>
	<div class="msg"></div>
</div>