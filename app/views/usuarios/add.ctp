<?php echo $html->css('jquery-ui-1.8.21.custom_usuarios_add');?>
<script>
	$(document).ready(function(){						
		
		$(function() {
			$( "#dialogBases" ).dialog({
				'autoOpen':false,
				'modal':true,
				'width':600,
				'draggable':false,
				'resizable':false
			});
		});
		
		$(function() {
			$( "#dialogErrores" ).dialog({
				'autoOpen':<?php echo (!empty($errores) ? 'true' : 'false');?> ,
				'modal':true,
				'width':400,
				'resizable':false
			});
		});
				
		
	})
	
	function abrirDialog(name){		
		$('#'+name).dialog('open');
	}
	
	function submitForm(){
		$('#UsuarioAddForm').submit();
	}
</script>
<div class="bloque bloque_1">
	<?php echo $html->image('home-1.png');?>
</div>

<div class="bloque bloque_2" id="usuarios_add_form">
	<div class="formulario-container">
	<?php echo $form->create('Usuario');?>
	<?php echo $form->hidden('tipodocumento',array('value'=>'dni'));?>
	<table border=0 class="datos">
		<tr>
			<td class="text">Nombre y Apellido</td>
			<td class="value"><?php echo $form->input('nombre_completo',array('label'=>'','div'=>''));?></td>
		</tr>
		<tr>
			<td class="text">Teléfono</td>
			<td class="value"><?php echo $form->input('telefono',array('label'=>'','div'=>''));?></td>
		</tr>
		<tr>
			<td class="text">Email</td>
			<td class="value"><?php echo $form->input('email',array('label'=>'','div'=>''));?></td>
		</tr>
		<tr>
			<td class="text">DNI <?php //echo $html->image('flechita_combo.png');?></td>
			<td class="value dni"><?php echo $form->input('nrodocumento',array('label'=>'','div'=>''));?></td>
		</tr>
		<tr>
			<td class="text">Cliente</td>
			<td class="value">
				<input type="radio" name="data[Usuario][es_cliente]" value="1" class="radio" <?php echo ($this->data['Usuario']['es_cliente'] == 1 ? 'checked' : '');?>/><label>SI</label>
				<input type="radio" name="data[Usuario][es_cliente]" value="0" class="radio" <?php echo (empty($this->data['Usuario']['es_cliente']) || $this->data['Usuario']['es_cliente'] == 0 ? 'checked' : '');?>/><label>NO</label>
			</td>
		</tr>
		<tr><td class="text" colspan="2"><div class="disclaimer">Por la presente declaro que soy titular  de la información aquí suministrada y que la misma  es verídica, eximiendo a Banco Supervielle S.A. de toda responsabilidad al respecto.</div></td></tr>
		<tr>
			<td class="text"><?php echo $html->link('Acepto que he leído las <br /> bases y condiciones','javascript:void(0)',array('onclick'=>'abrirDialog(\'dialogBases\')','escape'=>false));?></td>
			<td class="value"><input type="checkbox" name="data[Usuario][bases]" class="checkbox" <?php echo (isset($this->data['Usuario']['bases']) ? ($this->data['Usuario']['bases'] == 'on' || $this->data['Usuario']['bases'] == 1 ? 'checked' : '') : '');?>/></td>
		</tr>
	</table>
	</div>
	<div class="botones btn_crear_foto">
		<?php echo $html->link($html->image('btn_enviar_form.png'),'javascript:void(0)',array('alt'=>'','title'=>'','onclick'=>'submitForm()','escape'=>false));?> 
	</div>
</div>

<div class="bloque bloque_3">
	<?php echo $this->element('banner', array('zona'=>'fangate')); ?>
</div>

<div id="dialogBases" title="">
	<h3>BASES PROMOCION</h3>
	<h4>“Promoción Supermamá”</h4>
	<div class="texto-contenido">
		<p>1)Banco Supervielle S.A. (en adelante, el “Banco”) organiza la promoción “Supermamá” (en adelante, la “Promoción”), con arreglo a las siguientes
		Bases y Condiciones (en adelante, las “Bases”).</p>
		<p>2)La forma de participación en la presente promoción, de acceder al Premio – conforme se define este términos más adelante - y restantes
		condiciones se encuentran contenidas en las presentes Bases las cuales se encuentran disponibles en todas las Sucursales del Banco ubicadas en
		la República Argentina a excepción de las ubicadas en la provincia de Córdoba y en el sitio web www.supervielle.com.ar</p>
		<p>3)La Promoción tendrá vigencia entre las 12:00 hs del día 18 de Octubre de 2012 y las 12:00 hs del día 06 de Noviembre de 2012 y será válida
		en todo el territorio de la República Argentina a excepción de la provincia de Córdoba.</p>
		<p>4)Podrán participar en la Promoción cualquier persona física mayor de 18 años sin obligación de compra alguna (en adelante el/os Participante/
		s), y en la medida que cumplan con las condiciones estipuladas en las presentes Bases. Para participar los Participantes deberán adquirir
		previamente el carácter de “Fan” de la Página oficial de Banco Supervielle S.A., correspondiente al sitio web de la red social en donde el
		Banco administra la Promoción (el Sitio) y registrarse en la aplicación de la Promoción disponible en el Sitio denominada “Supermamá” (la
		Aplicación).En caso que los Participantes sean clientes del Banco no deberán registrar embargos, inhibiciones, ni deudas en cualquiera de los
		productos que tuvieran contratados o contrataren con el Banco durante la vigencia de la Promoción.</p>
		<p>5)La Promoción incluye un entretenimiento en virtud del cual los Participantes deberán ingresar en la en la pantalla habilitada a tal efecto
		(denominada, el “Muro”) en la Página oficial de Banco Supervielle S.A., correspondiente al Sitio e ingresar en la Aplicación, y luego de
		completar la grilla de datos personales y aceptar los términos y condiciones de las Bases, subir una fotografía de su madre o de la madre de
		otra persona (la/s Fotografía/s). Las Fotografías ingresadas en la Aplicación deberán estar en formato jpg, png o gif. La Aplicación permite que
		el Participante decore la Fotografía incorporándole objetos o figuras de colores. Luego de decorada; la Fotografía será remitida a la dirección
		de mail que sea indicada e informada por el Participante en la Aplicación, y contendrá un mensaje que el Participante incluirá en la misma.
		Posteriormente la Fotografía será publicada en el “Muro” del Participante. Cada Participante podrá subir hasta tres Fotografías. Asimismo si
		los Participantes podrán guardar las Fotografías en su computadora. Las Fotografías serán publicadas en la galería de fotos de la Aplicación,
		donde podrán ser votadas por otros usuarios del Sitio a través de un click sobre el botón “Votá a la Supermamá” de cada Fotografía. Tanto el
		Participante, como cada usuario de la red social sólo podrán colocar un solo “Votá a la Supermamá” por Fotografía.</p>
		<p>6)El Participante asume exclusiva responsabilidad, sobre todos los actos que ejecute en virtud de su participación en la Promoción, ya sea en lo
		que a él respecta o en lo que respecta a terceros. El Banco, asume en virtud de la Promoción, exclusivamente las obligaciones expresamente
		contenidas en estas Bases. El sólo hecho de subir las Fotografías en la Aplicación y en el Sito, implicará una declaración jurada de los
		Participantes en el sentido que: (i) son los únicos propietarios de las mismas o que cuentan con autorización suficiente de sus titulares para su
		uso e ingreso en la Aplicación y que no han sido obtenidas ilegalmente; (ii) ni el titular intelectual de las Fotografías, ni el Participante, ni las
		personas que aparecen en las Fotografías han cedido a otros terceros los derechos de publicación, utilización o reproducción de las mismas y
		(iii) que las personas que aparecen en las Fotografías han autorizado al Participante a la utilización de su imagen para esta Promoción.</p>
		<p>7)Los 10 (diez) Participantes que obtengan la mayor cantidad de “Votá a la Supermamá” sobre la Fotografía, resultarán potenciales ganadores
		(el/os Potencial/es Ganador/es). Para el caso que un mismo Participante tuviera más de una Fotografía dentro de las 10 (diez) más votadas,
		sólo resultará Potencial Ganador, de aquella de las tres (3) que tenga más votos. A fin de determinar quienes resultarán Potenciales Ganadores,
		dentro de las 24 (veinticuatro) hs. posteriores a la finalización de vigencia de la Promoción, electrónicamente el sistema registrará la cantidad
		de “Votá a la Supermamá” que posea cada Fotografía subida por los Participantes y generará un listado. Se premiarán las 10 (diez) primeras
		Fotografías que obtengan mayor cantidad de “Votá a la Supermamá”. Para el caso de empate de dos o más Participantes en virtud de la
		cantidad de “Votá a la Supermamá” que posea cada Fotografía, y a fin de determinar el Potencial Ganador, se realizará un sorteo entre los
		Participantes que hubieran empatado. El sorteo se realizará ante Escribano Público a las 16:00 hs. del día 7 de Noviembre de 2012, en las
		oficinas del Banco sitas en la calle Mitre 434 Piso 2° Ala Este – Ciudad de Buenos Aires -. El sorteo se llevará a cabo de la siguiente manera:
		En forma electrónica se asignará a los datos cargados por los Participantes que hubieran empatado un número secuencial correlativo de
		participación. En forma electrónica se seleccionará un número al azar, que se corresponderá con el nombre del Participante quien se constituirá
		en el Potencial Ganador.</p>
		<p>8)De acuerdo la cantidad de “Votá a la Supermamá” que obtengan las Fotografías, los premios (el/os Premio/s) consistirán en: (i) Para cada
		una las primeras 3 (tres) Fotografías con mayor cantidad de “Votá a la Supermamá”: un IPOD 8 GB MC540 y un cuadro de 40 x 30 cm. con la
		Fotografía publicada por el Potencial Ganador y (ii) las restantes 7 (siete) Fotografías con más “Votá a la Supermamá”: un cuadro de 40 x 30 cm.
		con la Fotografía publicada por el Potencial Ganador.</p>
		<p>9)Los Potenciales Ganadores, se constituirán en Ganadores al momento del otorgamiento de los Premios. Procedimiento para la entrega de los
		Premios: Para la asignación del Premio, se notificará a los Potenciales Ganadores a la dirección de mail que hubieran informado al momento
		de participar de la Promoción, dentro de los 7 (siete) días posteriores de haberse generado el listado designando los Potenciales Ganadores
		conforme los términos de la cláusula 7) o de haberse realizado el sorteo de acuerdo a lo establecido en la misma cláusula. Los Potenciales
		Ganadores deberán presentarse con su documento de identidad en la sucursal del Banco más cercana a su domicilio dentro de los 30 (treinta)
		días posteriores de habérsele notificado su carácter de Potenciales Ganadores. El Premio es personal e intransferible, sólo podrá ser entregado
		al Participante que se haya constituido en Ganador y no podrá sustituirse por dinero en efectivo</p>
		<p>10)La probabilidad matemática de adjudicación del Premio dependerá de la cantidad de Participantes. Tomando en consideración si participaran
		1200 (un mil doscientas) personas, la probabilidad de ganar sería de 0.05 por cada Participante. Cabe destacar que la probabilidad matemática
		informada es meramente ilustrativa y estimativa debido a que no se pueden conocer que cantidad exacta de Participantes.</p>
		<p>11)El Banco no se hará responsable de gastos de traslados ni de ningún gasto en que deba incurrirse para retirar el Premio ni de los gastos que se
		generen con posterioridad a la entrega del mismo.</p>
		<p>12)La responsabilidad del Banco por todo concepto finaliza con la puesta a disposición del Ganador del Premio.</p>
		<p>13)La participación en la Promoción, está sujeta a términos, condiciones, reglamentos, disposiciones, políticas y procedimientos establecidos por el
		Banco. Todo abuso de los derechos del mismo, toda conducta contraria de los participantes -en forma individual o colectiva- en detrimento de
		los intereses del Banco Supervielle S.A. podrá resultar en la anulación del Premio.</p>
		<p>14)Todo acto u operación ejecutado por el Participante en el Sitio a través de cualquier dispositivo, que resulte contrario a los términos y
		condiciones de éstas Bases, aún cuando el Sitio hubiere admitido tal acto u operación, podrá ser anulado por el Banco, sin necesidad de
		preaviso alguno, ni derecho resarcitorio ni compensatorio a favor del Participante.</p>
		<p>15)Toda divergencia que pudiera surgir con relación a la Promoción y a todos los efectos de la misma, las partes (Banco Supervielle S.A. y los
		Participantes), se someten a la jurisdicción y competencia de los Tribunales Ordinarios en lo Comercial de la Ciudad Autónoma de Buenos Aires,
		renunciando a cualquier otro fuero que les pudiera corresponder.</p>
		<p>16) El hecho de aceptar el Premio implica para el Ganador la autorización tácita a Banco Supervielle S.A. para difundir o publicar sus nombres
		y/o divulgar sus imágenes, y/o divulgar sus fotografías y/o divulgar su voz con fines publicitarios en los medios y en las formas que considere
		correctas, sin derecho de compensación alguna durante el transcurso de la promoción y hasta un año después del inicio de la Promoción.</p>
		<p>17) El Participante presta su consentimiento, conforme los términos de la Ley 25.326 de Protección de Datos Personales, para que el Banco pueda
		utilizar y/o disponer y/o ceder la información que le ha suministrado, manteniendo la confidencialidad y seguridad de los datos – a sus afiliadas,
		subsidirias y/o terceros incluidas, ya sea con fines comerciales como estadísticos. Asimismo el Participante manifiesta expresamente conocer
		que puede ejercer los derechos de acceso, rectificación y supresión de la información, conforme la legislación aplicable.</p>
		<p>18) No podrán participar en la Promoción: personal de Banco Supervielle S.A., ni del Grupo Supervielle S.A., sus agencias de publicidad y/o
		promoción, ni tampoco sus familiares directos hasta el segundo grado de consaguinidad de los nombrados.</p>
		<p>19) La Bolsa de Premios para el presente sorteo ha sido fijada en la suma de $ 5459,24 (Pesos cinco mil cuatrocientos cincuenta y nueve con
		veinticuatro centavos).</p>
		<p>20) Se deja constancia que Facebook no patrocina, avala ni administra de modo alguno esta Promoción, ni tampoco está asociada a ella. La
		información brindada es proporcionada a Banco Supervielle S.A. y no a Facebook. Banco Supervielle S.A. es el único responsable de la
		Promoción, no existiendo responsabilidad alguna frente a los Participantes por parte de Facebook.</p>
	</div>
</div>

<div id="dialogErrores" title="">
	<h3>Errores.</h3>
	<p>Hay errores en los siguientes campos:</p>
	<?php 
	if(!empty($errores)){?>	
		<ul>
			<?php 
			foreach($errores as $key =>$mensaje){?>			
				<li>- <?php echo $mensaje;?></li>
			<?php }?>													
		</ul>
	<?php }?>
</div>