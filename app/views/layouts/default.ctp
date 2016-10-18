<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en"  xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>Superfamilia Awafrut</title>
<link rel="stylesheet" type="text/css" href="<?php echo $html->url('/css/style.css?v20121030'); ?>" />
<?php
//	echo $html->css('style');
	echo $html->css('fonts');
	echo $html->css('jquery-ui-1.8.21.custom');
?>
<!--[if IE 8]>
	<?php echo $html->css('style-ie8'); ?>
<![endif]-->
<?php	
	echo $javascript->link('jquery-1.7.1.min.js');
	echo $javascript->link('jquery-ui-1.8.21.custom.min.js');
	echo $javascript->link('fb.js'); 
	
	if (isset($hazteFan) && $hazteFan) { ?>
		<script>
		$(function() {
			hazteFan();
		});
		</script>
	<?php 
	}
?>
<script>
var hazteFan_timeout;
function hazteFan() {
	$('#modalFan')
		.height($('body').height())
		.show()
	;
	$('#dialogFan').show();
	// por si acaso se queda colgado, ponemos un refresh automatico
	window.hazteFan_timeout = window.setTimeout(function() {window.location.reload()}, 20000);
}

function deshazteFan() {
	window.clearInterval(window.hazteFan_timeout);
	$('#dialogFan').hide();
	$('#modalFan').hide();
}
</script>
</head>

<body scroll="no" class="<?php echo $this->params['controller'].'_'.$this->params['action'];?>">
	<?php
	if (APP_DEBUGMODE) {
		echo $this->Session->flash();
	}
	?>
	<div id="container">
		<div id="nav">
			<div id="header">
				<div id="logo"><?php echo $html->link('',array('controller'=>'pages','action'=>'display','home'),array('alt'=>'Supervielle','title'=>'Supervielle','escape'=>false));?></div>
			</div>
			
			<div id="content">
				<?php echo $content_for_layout; echo $this->element('sql_dump');?>
			</div>

			<div id="footer">
				<div class="top">
					<div class="linea negra"><a href="<?php echo $html->url('/common/BASESYCONDICIONES.pdf'); ?>" target="_blank">Bases y Condiciones.</a></div> 
					<div id="logo"><?php echo $html->link('',array('controller'=>'pages','action'=>'display','home'),array('alt'=>'Supervielle','title'=>'Supervielle','escape'=>false));?></div>
					<div class="texto bases_condiciones">
						Promoción sin obligación de compra. Válida en la República Argentina a excepción de la Pcia. de Córdoba, entre las 12:00  hs  del  día 18 de Octubre de 2012 y  las 12:00  hs  del día 06 de Noviembre de 2012.  Consultar bases y condiciones en www.supervielle.com.ar y en las sucursales de Banco Supervielle S.A. No participa de la Promoción personal de Banco Supervielle  S.A., ni del Grupo Supervielle S.A., sus agencias de publicidad y/o promoción, ni tampoco sus familiares directos hasta el segundo grado de consaguinidad de los nombrados. Los premios consistirán en (3) MP3 IPOD 8 GB MC540 y (10) cuadros de 40 x 30 cm. de la fotografía de la Supermamá publicada por el Ganador. Facebook no patrocina, avala ni administra de modo alguno esta Promoción, ni tampoco está asociada a ella
					</div>
				</div>				
			</div>		
		<div class="clear"></div>
		<?php echo $this->element('sql_dump'); ?>
		</div><!-- #nav -->
	</div><!-- #container -->

<div id="modalFan" style="display: none;"></div>
<div id="dialogFan" style="display: none;">
	<center>
		<?php echo $html->image('hazteFan.png'); ?><Br />
		<div class="fb-like" data-href="http://http://www.facebook.com/pages/Drublus-Factory" data-send="true" data-width="450" data-show-faces="true" data-colorscheme="dark"></div>
	</center>
</div>

<div id="fb-root"></div>
<script type="text/javascript">

  window.fbAsyncInit = function() {
  		FB.init({appId: '211645485590601', status: true, cookie: true, xfbml: true, oauth: true});

			FB.Event.subscribe('edge.create', function(response) {
				console.log('user just clicked Liked on your page');
			});
			
			FB.Event.subscribe('auth.authResponseChange', function(response) {
				console.log('cambia la sessiokn');
			}); 
	};

 (function() { var e = document.createElement('script');
  e.async = true;
  e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
  document.getElementById('fb-root').appendChild(e); }());


  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-35682909-1']);
  _gaq.push(['_trackPageview']);


  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
  
  window.onload = function() {
  		FB.Canvas.setAutoGrow(100); //Run the timer every 100 milliseconds, you can increase this if you want to save CPU cycles
		}
</script>
</body>
</html>