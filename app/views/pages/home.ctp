<script>
   
function go_to(dest) {
	FB.login(function(response) {
		if (response.authResponse) {
			window.location.href = dest;
		} else {
			window.location.href = '<?php echo $html->url("/usuarios/haztefan"); ?>';
		}
	}, {
		'scope': 'email,publish_stream,user_photos'
		// DEBUG
		//, 'redirect_uri': 'http://apps-lanzallamas.com.ar/supermama2'
	});
}	

function comenzar() {
//window.location.href = '<?php echo $html->url('/usuarios/haztefan'); ?>';

	go_to('<?php echo $html->url('/usuarios/'); ?>');
	/*
	if (validar_click()) {
		window.location.href = '<?php echo $html->url('/usuarios/home'); ?>';
	}
	*/
}
  
function isEmpty(obj) {
	for(var prop in obj) {
		if(obj.hasOwnProperty(prop))
			return false;
	}

	return true;
}
</script>

<div class="bloque bloque_1">
	<?php echo $html->image('home-1.png');?>
</div>

<div class="bloque bloque_2">
	<?php echo $html->image('home_2.jpg');?>
	<div class="botones btn_crear_foto">
		<?php echo $html->link($html->image('btn_crear_foto.png'),'javascript:comenzar()',array('alt'=>'Crea tu foto','title'=>'Crea tu foto','escape'=>false));?> 
	</div>
</div>

<div class="bloque bloque_3">
	<?php echo $this->element('banner', array('zona'=>'fangate')); ?>
</div>