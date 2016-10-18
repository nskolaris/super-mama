<?php for ($i=0 ; $i < sizeof($Fotos) ; $i++) { ?>
	<li class="foto nuevo" data-id="<?php echo $Fotos[$i]['Foto']['id']; ?>">
		<img src="<?php echo URL_FOTOS.'/'.substr($Fotos[$i]['Foto']['filename'],0,-4); ?>_150_150.jpg" width="150" height="150" />
		<div class="info" title="<?php echo $Fotos[$i]['Usuario']['nombre_completo']; ?>">POR <br /><?php echo $Fotos[$i]['Usuario']['nombre_completo']; ?></div>
		<div class="voto_inline_closed" style="diplay:none;">
			<div class="bg"></div>
			<div class="votar"></div>
			<div class="cant_votos" style="display:none;"><span class="cant"><?php echo (int)$Fotos[$i]['Foto']['voto_count']; ?></span> votos</div>
		</div>
	</li>
<?php } ?>
