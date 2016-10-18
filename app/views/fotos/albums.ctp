<?php echo $javascript->link('fb.js'); ?>

<script>
$(document).ready(function() {
//	refreshAlbums();
	$('#fotos_albums_1 .nav_left .album').click(function() {
		getAlbum($(this).attr('id'));
	});
});

function getAlbum(id) {
	$('#detalle_album').html('<div class="loading"></div>');
	$('#detalle_album').load("<?php echo $html->url('/fotos/getAlbum/'); ?>"+id, function() {
		$('#loading').hide();
		var titulo = $('.album#'+id).find('.info .nombre').attr('title');
		$('#title_album', $(this)).html(titulo.substr(0,21) + (titulo.length > 21 ? '...' : '')).attr('title', titulo);
		$('.foto', $(this)).click(function() {
			seleccionarFoto($(this).attr('id'));
		});
		
	});
}

function seleccionarFoto(id) {
	$('#detalle_album .foto')
		.find('.img').removeClass('selected').end()
		.filter('#'+id).find('.img').addClass('selected')
	;
	$('#formSiguiente #photoUrl').val($('#'+id+' .photoUrl').html());
	siguiente();
}


function siguiente() {
	$("body").css("cursor", "progress");
	if ($('#formSiguiente #photoUrl').val() != "") {
		$('#formSiguiente').submit();
	}
}
</script>

<div class="bloque bloque_1" id="fotos_albums_1">
	<div class="nav_container">
		<div class="nav nav_left">
			<div class="title">Albums</div>
			<?php if (!empty($albums['data'])) { ?>
			<ul class="albums">
				<?php foreach($albums['data'] as $album) { ?>
					<?php if (isset($album['cover_photo'])) { ?>
					<li class="album" id="<?php echo $album['id']; ?>">
						<div class="image"><img src="https://graph.facebook.com/<?php echo $album['cover_photo']; ?>/picture?type=album&access_token=<?php echo $access_token; ?>" /></div>
						<div class="info">
							<span class="nombre" title="<?php echo $album['name']; ?>"><?php echo (substr($album['name'],0,21) . (strlen($album['name'])>21 ? '...' : '')); ?></span>
							<span class="cant_fotos"><?php echo $album['count']; ?> fotos</span>
						</div>
					</li>
					<?php } ?>
				<?php } ?>
			</ul>
			<?php } ?>
			</ul>
		</div>
		<div class="nav nav_right" id="detalle_album">
		</div>
	</div>

	<div class="actions">
		<div class="btn_volver"><?php echo $html->link($html->image('btn_volver_fotos_album.png'),'/fotos/upload',array('escape'=>false,'onclick'=>''));?></div>
		<div class="btn_siguiente"><?php echo $html->link($html->image('btn_siguiente_fotos_album.png'),'javascript:siguiente()',array('escape'=>false,'onclick'=>''));?></div>
	</div>
	
</div>

<form type="GET" name="formSiguiente" id="formSiguiente" action="<?php echo $html->url('/fotos/add'); ?>">
	<input type="hidden" id="photoUrl" name="photoUrl" value="" />
</form>
	

<div class="bloque bloque_2" id="fotos_albums_2">
	<?php echo $this->element('banner'); ?>
</div>

