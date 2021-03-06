<?
$imagen_formato='png'; // Case sensitive

$imagenes[0]='ficha-01';
$imagenes[1]='ficha-02';
$imagenes[2]='ficha-03';
$imagenes[3]='ficha-04';
$imagenes[4]='ficha-05';
$imagenes[5]='ficha-06';
$imagenes[6]='ficha-07';
$imagenes[7]='ficha-08';
$imagenes[8]='ficha-09';
$imagenes[9]='ficha-10';
$imagenes[10]='ficha-11';
$imagenes[11]='ficha-12';

$imagenes2=$imagenes;
$imagenes= array_merge($imagenes, $imagenes2);
shuffle($imagenes);
?>


<script type="text/javascript">

var segundos = 0;
var minutos = 0;

var currentpromo = 0;

var fichas_seleccionadas = 0;

function gamelogic(state)
			{
				switch(state)
				{
					case 0: //acaba de entrar
							$('#instrucciones').css('display','block');
							break;
					case 1: //leyo instrucciones
							$('#instrucciones').css('display','none');
							reloj();
							break;
					case 2: //termino juego
							finalizar_juego();
							break;
				}
				
			}			
			
			function finalizar_juego()
			{
				url = '<?php echo Router::url(array('controller'=>'front','action'=>'grabar_juego'));?>';
				if (segundos<10){var xsegundos = '0'+segundos;}
				else{var xsegundos = segundos;}
				if (minutos<10){var xminutos ='0'+minutos;}
				else{var xminutos = minutos;}
				
				
				params = {
				'data[Juego][tiempo]' : xminutos+':'+xsegundos,
					}
					$.post(url, params, function(data){
					if (data){
							window.location.href='resultado/'+data;
						}
					});
				}	

			
			function reloj()
			{
						$.timer(1000, function (timer) {					
						segundos ++;
						if (segundos>59)
						{
						segundos = 0;
						minutos++;						
						}

						if (segundos<10){$('#segundos').html('0'+segundos);}
						else{$('#segundos').html(segundos);}
						if (minutos<10){$('#minutos').html('0'+minutos);}
						else{$('#minutos').html(minutos);}
						
						reloj();
						timer.stop();
						});
			}
			
			
	$(window).ready(function(){
	
			gamelogic(0);
	
			function memotest(i, imagen){ 

			if( $(".s-"+imagen).hasClass('seleccionada')){
				if (!$("#s-"+i).hasClass("seleccionada"))
				{
					fichas_seleccionadas = 0;
					// Si ya hay una imagen del par ya seleccionada (o sea, elige la 2da correctamente)
					$(".c-"+imagen).removeClass("abierto"); // Quitamos el cover del Bg, para mostrar la ficha
					
					$(".c-"+imagen).stop().animate({width:'0px',height:''+height+'px',marginLeft:''+margin+'px',opacity:'0'},{duration:400});
					window.setTimeout(function() {
					$(".s-"+imagen).stop().animate({width:''+width+'px',height:''+height+'px',marginLeft:'0px',opacity:'1'},{duration:400});
					},500);
					
					$("#p-"+currentpromo).css('display','none');
					$("#p-"+i).css('display','block');
					currentpromo = i;
					
					$(".s-"+imagen).addClass("encontrada"); // se marca el div de la ficha como encontrada
					$(".c-"+imagen).addClass("trabado"); 
					var w = $(".encontrada");
	
					// Congratulation message / Mensaje de felicitacion.
					if(w.length == 24){
						$.timer(600, function (timer) {					
						    gamelogic(2);	
						    timer.stop();
						});
					}
				}
			}else if( $(".ficha-cover").hasClass("abierto") ){
				// Si no hay coincidencia, y hay alguna abierta:
				fichas_seleccionadas++;
				
				$("#c-"+i).stop().animate({width:'0px',height:''+height+'px',marginLeft:''+margin+'px',opacity:'0'},{duration:400});
				window.setTimeout(function() {
				$("#s-"+i).stop().animate({width:''+width+'px',height:''+height+'px',marginLeft:'0px',opacity:'1'},{duration:400});
				},500);
				
				$("#s-"+i).addClass("seleccionada"); // for the record... / lo grabamos.
				$("#c-"+i).addClass("abierto"); // display:none;

				// if no coincidence, hide items after 400ms / Si no acierta, espera 400ms para ocultar la ficha
				$.timer(1200, function (timer) {				
				
				<?php foreach($imagenes as $j => $imagen){	?>
				if ($("#c-<?=$j?>").hasClass("abierto"))
				{	
							$("#s-"+<?=$j?>).stop().animate({width:'0px',height:''+height+'px',marginLeft:''+margin+'px',opacity:'0'},{duration:400});
							window.setTimeout(function() {
							$("#c-"+<?=$j?>).stop().animate({width:''+width+'px',height:''+height+'px',marginLeft:'0px',opacity:'1'},{duration:400});
							},500);
				}
				<? }?>

					$(".ficha").removeClass("seleccionada"); // not selected anymore / ya no esta seleccionada.
					$(".ficha-cover").removeClass("abierto"); // chau display:none;
					$.timer(500, function (timer) {fichas_seleccionadas = 0;timer.stop();});
				    timer.stop();
				});
			}else{
				// Si elige la primer ficha (de dos)
				fichas_seleccionadas++;
				$("#c-"+i).stop().animate({width:'0px',height:''+height+'px',marginLeft:''+margin+'px',opacity:'0'},{duration:400});
				window.setTimeout(function() {
				$("#s-"+i).stop().animate({width:''+width+'px',height:''+height+'px',marginLeft:'0px',opacity:'1'},{duration:400});
				},500);
				$("#s-"+i).addClass("seleccionada"); // for the record... / lo grabamos.
				$("#c-"+i).addClass("abierto"); // display:none;
			}
		 }
		// Assign onClick to items / Asigna onClick a las fichas ('.ficha-cover').
		
		<? foreach($imagenes as $i => $imagen){	?>
		
			var margin =$("#c-<?=$i?>").width()/2;
			var width=$("#c-<?=$i?>").width();
			var height=$("#c-<?=$i?>").height();
			
			$("#s-<?=$i?>").stop().css({width:'0px',height:''+height+'px',marginLeft:''+margin+'px',opacity:'0'});
			$("#reflection2").stop().css({width:'0px',height:''+height+'px',marginLeft:''+margin+'px'});
			
			
			
			$("#c-<?=$i?>").click(function(){
			if (fichas_seleccionadas<2)
			{
				memotest('<?=$i?>', '<?=$imagen?>');
			}
			
			});
			
		<? }?>
		
	});




</script>



<div class="logo-supercole-datos"></div>
<div class="logo-supervielle-datos"></div>

<div id="instrucciones" class="instrucciones">
<div class="tabla-instrucciones">

<div class="tabla-instrucciones-inside">
<div class="texto-como-jugar"></div>
</div>

<div class="utiles-instrucciones-1"></div>
<div class="utiles-instrucciones-2"></div>
<?php echo $this->Html->link('','javascript:gamelogic(1);',array('class'=>'boton-comenzar-a-jugar')); ?>

</div>
</div>


<div class="mesa-fondo-juego">

	<div class="timer">
	<div id="minutos" class="timer-field">00</div> :
	<div id="segundos" class="timer-field">00</div>
	</div>
	
	<div class="memotest" onmousedown="event.preventDefault ? event.preventDefault() : event.returnValue = false">
			<? foreach($imagenes as $i => $imagen){ ?>
			<div class="fichaflip">
			<div class="ficha-cover c-<?=$imagen?>" id="c-<?=$i?>"><img src="../img/supercole/fichas/ficha-atras.png" /></div>
			<div class="ficha s-<?=$imagen?>" id="s-<?=$i?>"><img src="../img/supercole/fichas/<?=$imagen?>.<?=$imagen_formato?>"/></div>
			</div>
			<div class="promo-prueba" id="p-<?=$i?>">
			<img src="../img/supercole/banners-promociones/banner-<?=$imagen?>.png"/>			
			</div>
			<? }?>
	</div>
</div>

    

<?php echo $this->Html->link('','javascript:sendRequestViaMultiFriendSelector();',array('class'=>'boton-invita-a-tus-amigos')); ?>
<?//php echo $this->Html->link('test-finalizar','javascript:gamelogic(2);');?>