<style type="text/css">
#botones {
	display: none;
}
</style>

<script>
function enviar_datos() {

	$('.input_error').removeClass('input_error');
	var enviar = true;
	if ($.trim($('#nombre').val()) == '') {
		$('#nombre').addClass('input_error');
		enviar = false;;
	}
	if ($.trim($('#apellido').val()) == '') {
		$('#apellido').addClass('input_error');
		enviar = false;;
	}
	if ($.trim($('#email').val()) == '') {
		$('#email').addClass('input_error');
		enviar = false;;
	}
	if ($.trim($('#dni').val()) == '') {
		$('#dni').addClass('input_error');
		enviar = false;;
	}
	if ($.trim($('#telefono').val()) == '') {
		$('#telefono').addClass('input_error');
		enviar = false;;
	}
	
	if (enviar) {
		$('#formu').submit();
	}

}

</script>

<!---- Empieza Cuerpo, wuhuuuu :o ---->
<div id="cuerpo">
	<!-- InstanceBeginEditable name="Cuerpo" -->
	<div id="formulario">
	<form method="POST" action="<?php echo $html->url('/usuarios/datos'); ?>" id="formu">
	  <p>
	  <input type="text" name="nombre" id="nombre" class="fondinput" value="<?php echo (isset($fb_user['first_name']) ? $fb_user['first_name'] : '') ?>" />
	  <input type="text" name="apellido" id="apellido" class="fondinput" value="<?php echo (isset($fb_user['last_name']) ? $fb_user['last_name'] : '') ?>" />
	  <input type="text" name="email" id="email" class="fondinput" value="<?php echo (isset($fb_user['email']) ? $fb_user['email'] : '') ?>" />
	  <input type="text" name="dni" id="dni" class="fondinput" />
	  <input type="text" name="telefono" id="telefono" class="fondinput" />
		H <input name="sexo" type="radio" class="sexoerror" value="hombre" <?php echo ($fb_user['gender'] == 'male' ? 'checked' : '') ?>>
		M <input name="sexo" type="radio" class="sexoerror" value="mujer" <?php echo ($fb_user['gender'] == 'female' ? 'checked' : '') ?>> 
	  </p>
	  <p><a href="javascript:enviar_datos()"><img src="<?php echo $html->url('/img/'); ?>btn_participar.png" width="122" height="28" border="0" /></a></p>
	</form>
	</div>
	<!-- InstanceEndEditable -->
</div>
<!---- Se acabó el cuerpo :/ ---->


