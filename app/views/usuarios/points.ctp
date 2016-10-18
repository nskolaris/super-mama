<!---- Empieza Cuerpo, wuhuuuu :o ---->
<div id="cuerpo">
<!-- InstanceBeginEditable name="Cuerpo" -->
<div id="puntytorneos">
<div id="titulo">Puntaje</div>
<div id="tiras">

	<?php 
	$i = 1;
	foreach ($Cuestionarios as $idcuestionario => $Cuestionario) { 
		$class = "jugado";
		if (!isset($CuestionariosVigentes[$idcuestionario])) {
			$class = "nodisponible";
		}
		if (isset($CuestionariosVigentes[$idcuestionario]) && !isset($Puntos[$idcuestionario])) {
			$class = "disponible";
		}
		?>
		<div class="<?php echo $class; ?>">
			<div class="tit"><img src="<?php echo $html->url('/img/'); ?>titulo_<?php echo $Cuestionario['dashboard_class']; ?>.gif" width="144" height="11" /></div>
			<?php if (!isset($CuestionariosVigentes[$idcuestionario])) { ?>
			
			<?php } else if (isset($Puntos[$idcuestionario])) { ?>
				<div class="puntosxtorneo"><div class="leyenda">Por Respuestas Correctas</div><?php echo $Puntos[$idcuestionario]['cuestionario']; ?></div>
				<div class="puntosxbonus"><div class="leyendabonus"><p>Compu</p><p>Bonus<br /></p></div><?php echo $Puntos[$idcuestionario]['bonus']; ?></div>
				<div class="puntosxtotal"><div class="leyendatotal"><p>TOTAL<br />  </p></div><?php echo $Puntos[$idcuestionario]['total']; ?> </div>  
				<div class="estado1punt"></div>
				<?php //echo $idcuestionario . " ya esta respondido y tenes estos puntos: " . var_export($Puntos[$idcuestionario],true); ?>
			<?php } else { ?>
				<div class="puntosxtorneo"><div class="leyenda">Por Respuestas Correctas</div>0</div>
				<div class="puntosxbonus"><div class="leyendabonus"><p>Compu</p><p>Bonus<br /></p></div> 0 </div>
				<div class="estado1"><a href="<?php echo $html->url('/cuestionarios/view/'.$idcuestionario); ?>"><img src="<?php echo $html->url('/img/'); ?>accion_jugar.png" width="125" height="50" border="0" /></a></div>
			<?php } ?>
		</div>
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
<?php echo $this->element('puntaje', $usr); ?>
<!---- Adios Contenedor Inferior ---->




