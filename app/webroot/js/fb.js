/*
  window.fbAsyncInit = function() {
    FB.init({
	  appId      : '211645485590601',
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });
	FB.Canvas.setAutoGrow();
  };
  // Load the SDK Asynchronously
  (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));
*/   
function shareApp() {
  ret = FB.ui({method: 'apprequests',
	filters: ['app_non_users'],
	//redirect_uri: 'http://apps-lanzallamas.com.ar/supermama/',
	// NOTE aca no podia poner salto de linea en el mensaje
    message: "¡Creá tu SuperMamá y sorprendela! Hay 3 reproductores mp3 y 10 cuadros con las ilustraciones como premios. La votación por las mejores fotos comienza el 29/10.",
	max_recipients: 5
  });
}

function share_callback() {
}

function sharePhotoOwner(link, picture) {
	if (link != '') {
		ret = FB.ui({method: 'feed',
//			redirect_uri: 'http://apps-lanzallamas.com.ar/supermama/',
			name: "Concurso SuperMamá - Banco Supervielle",
			to: '',
			link: link,
			picture: picture,
			description: 'Estoy participando del concurso "SuperMamá" del Banco Supervielle. ¡Hacé click acá y creá la tuya! Podés ganar reproductores MP3 y cuadros con tu ilustración!'
		}, share_callback);
	}
}

function sharePhoto(link, picture) {
	if (link != '') {
		ret = FB.ui({method: 'feed',
			//redirect_uri: 'http://apps-lanzallamas.com.ar/supermama/',
			name: "Concurso SuperMamá - Banco Supervielle",
			link: link,
			picture: picture,
			description: 'Me encantan las fotos del concurso "SuperMamá" del Banco Supervielle. ¡Hacé click acá y creá la tuya! Podés ganar reproductores MP3 y cuadros con tu ilustración!'
		}, share_callback);
	}
}


function validateVisitor(callback_ok, params) {

	FB.getLoginStatus(function(response) {
		if (response.status === 'connected') {
//			console.log('deberia ver si es fan');
			callback_ok(params);
			return true;
		} else {
			FB.login(function(response) {
				if (response.authResponse) {
					// TODO aca tengo que validar que sea fan
//					console.log('es fan?');
					callback_ok(params);
					return true;
				} else {
					return false;
//					console.log('no es fan?');
		//			window.location.href = '<?php echo $html->url('/usuarios/haztefan'); ?>';
				}
			}, {
				'scope': ''
				// DEBUG
		//		, 'redirect_uri': 'http://apps-lanzallamas.com.ar/supermama/'
			});
		}
	});
}

/*
function sendRequestToRecipients(to) {
	FB.ui({method: 'apprequests',
		redirect_uri: 'https://k-dreams.com/fb_apps/compumundo_olimpiadas/invitaciones/add',
		message: 'Trivia Compumundo',
		to: to
    }, requestCallback);
}
*/