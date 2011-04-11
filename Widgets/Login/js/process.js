window.addEvent("domready",function(){
$('login').addEvent('submit', function(e) {
			e.stop();
			$('ajax_loading').setStyle('display','block');
			$('login_form').setStyle('display','none');
			$('submit').setStyle('display','none');
			
			$(pass_field).value=SHA1($(pass_field).value);
			
			this.set('send', { 
				 onComplete: function(response) {
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