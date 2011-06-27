window.addEvent("domready",function(){
$('form_login').addEvent('submit', function(e) {
			e.stop();
			$('ajax_loading').setStyle('display','block');
			$('login_form').setStyle('display','none');
			$('submit').setStyle('display','none');
			this.set('send', { 
				 onComplete: function(response) {
					if(typeof response == 'undefined'){
						response = '<div id="error_notification">Error al tratar de iniciar sesi&oacute;n</div>';
					}
				        $('ajax_loading').setStyle('display','none');
		                        if(response.trim() == 'OK'){
                                     window.location.reload();
		                        }else{ 
			                         var myShake=new Shake('logindiv',{distance:15,duration:80});
                                     $('login_response').set('html', response);			  
                                     $('submit').setStyle('display','block');
                                     $(pass_field).value="";
                                     myShake.shake();
                                     $('login_form').setStyle('display','block');
		                      }
		                    }
				,onError: function(response){
					$('login_form').setStyle('display','block');
				}
			});
			this.send();
		});
});
