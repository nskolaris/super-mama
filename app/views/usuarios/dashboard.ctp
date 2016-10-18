<!---- Empieza Cuerpo, wuhuuuu :o ---->
<div id="cuerpo">
<!-- InstanceBeginEditable name="Cuerpo" -->
<div id="puntytorneos">
<div id="titulo">Torneos</div>
<div id="tiras">

	<?php 
	$i = 1;
	foreach ($Cuestionarios as $idcuestionario => $Cuestionario) { 
		$class = "";
		if (!isset($CuestionariosVigentes[$idcuestionario]) || !isset($Puntos[$idcuestionario])) {
			$class = "not_played";
		}
		?>
			<?php if (!isset($CuestionariosVigentes[$idcuestionario])) { ?>
				<div class="nodisponible">
					<div class="tit"><img src="<?php echo $html->url('/img/'); ?>titulo_<?php echo $Cuestionario['dashboard_class']; ?>.gif" width="144" height="11" /></div>
				</div>
			<?php } else if (isset($Puntos[$idcuestionario])) { ?>
				<div class="jugado">
					<div class="tit"><img src="<?php echo $html->url('/img/'); ?>titulo_<?php echo $Cuestionario['dashboard_class']; ?>.gif" width="144" height="11" /></div>
					<div class="puntosxtorneo"><?php echo $Puntos[$idcuestionario]['total']; ?> pts</div>
					<div class="estado1"><img src="<?php echo $html->url('/img/'); ?>accion_jugado.png" width="125" height="50" /></div>
				</div>
			<!--
				<div class="puntos puntos_cuestionario"><?php echo $Puntos[$idcuestionario]['cuestionario']; ?></div>
				<div class="puntos puntos_bonus"><?php echo $Puntos[$idcuestionario]['bonus']; ?></div>
				<div class="puntos puntos_total"><?php echo $Puntos[$idcuestionario]['total']; ?></div>
			-->
				<?php //echo $idcuestionario . " ya esta respondido y tenes estos puntos: " . var_export($Puntos[$idcuestionario],true); ?>
			<?php } else { ?>
				<div class="disponible">
					<div class="tit"><img src="<?php echo $html->url('/img/'); ?>titulo_<?php echo $Cuestionario['dashboard_class']; ?>.gif" width="144" height="11" /></div>
					<div class="puntosxtorneo">0 pts</div>
					<div class="estado1"><a href="<?php echo $html->url('/cuestionarios/view/'.$idcuestionario); ?>"><img src="<?php echo $html->url('/img/'); ?>accion_jugar.png" width="125" height="50" border="0" /></a></div>
				</div>
			<!--
				<div class="pnoplay">
					<p>Aún no Jugaste este Nivel.</p>
					<p><strong><?php echo $html->link('JUGAR AHORA', '/cuestionarios/view/'.$idcuestionario); ?></strong></p>
				</div>
			-->
			<?php } ?>
		<?php 
		$i++;
	}
	?>

</div>

</div>
<!-- InstanceEndEditable -->
</div>
<!---- Se acabó el cuerpo :/ ---->


<!---- Hola Contenedor inferior ---->
<div id="contresultinferior">
<!-- InstanceBeginEditable name="EditRegion4" -->
<img src="<?php echo $html->url('/img/'); ?>escala.jpg" width="666" height="119" />
<!-- InstanceEndEditable -->
</div>
<!---- Adios Contenedor Inferior ---->

