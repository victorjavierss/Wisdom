/*
JS_Growl Mootools based notifier
Version 0.2
Developed and maintained by Carlos Ouro
http://techtrouts.com
*/
JS_Growl={
	//user callable properties / funcionalities
	notify:function(str){
		if(!this._v.initiated) this._a.init();
		var el=new Element('div',{
			'class':(Browser.Engine.name=='trident' && Browser.Engine.version<5)?'JS_Growl_notify_IE6':'JS_Growl_notify',
			'html':str
		});
		el.inject(this._o.container);
		var fx= new Fx.Morph(el, {
			'duration': 'short'
		});
		fx.set({
			'opacity':0,
			'display':'block'
		});
		fx.start({
			'opacity':[0,1]
		});
		setTimeout(function(){
			fx.start({
				'opacity':[1,0]
			}).chain(function(){
				this.options.durtion='long';
				this.start({
					'height':0,
					'padding-top':0,
					'padding-bottom':0,
					'margin-top':0,
					'margin-bottom':0
				}).chain(function(){
					el.destroy();
				});
			});
		}, 2500);
	},
	
	//internal structure "à la fallforward ( http://fallforwardgame.com )"
	_v:{
		initiated:false
	},
	_a:{
		init:function(){
			JS_Growl._o.container=new Element('div', {'id':'JS_Growl_container'});
			JS_Growl._o.container.inject(document.body);
			JS_Growl._v.initiated=true;
			if(Browser.Engine.name=='trident' && Browser.Engine.version<5){							
				//position "fixed"
				JS_Growl._o.container.setStyle({'position':'absolute'});
				JS_Growl._a.ie6_pos();
				window['addEvent']('scroll', JS_Growl._a.ie6_pos);
				window['addEvent']('resize', JS_Growl._a.ie6_pos);
			}
		},
		ie6_pos:function(){
			JS_Growl._o.container.setStyles({'top':Window.getScrollTop()+'px', 'left':Window.getWidth()+'px'});
		}
	},
	_o:{
		"container":null
	}
}