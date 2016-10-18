<?php
//debug($fotos); 
?>
<div class="title" id="title_album"></div>
<?php if (!empty($fotos)) { ?>
<ul class="albums">
	<?php foreach ($fotos as $foto) { ?>
	<li class="foto" id="<?php echo $foto['id']; ?>">
		<div class="image"><img src="<?php echo $foto['images'][6]['source']; ?>" width="150" /></div>
		<span style="display:none;" class="metadata photoUrl"><?php echo $foto['images'][1]['source']; ?></span>
	</li>
	<?php } ?>
</ul>
<?php } ?>
