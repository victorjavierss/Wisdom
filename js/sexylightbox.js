/**
 * Sexy LightBox - for mootools 1.2
 * @name sexylightbox.v2.2.js
 * @author Eduardo D. Sada - http://www.coders.me/web-html-js-css/javascript/sexy-lightbox-2
 * @version 2.2
 * @date 1-Jun-2009
 * @copyright (c) 2009 Eduardo D. Sada (www.coders.me)
 * @license MIT - http://es.wikipedia.org/wiki/Licencia_MIT
 * @example http://www.coders.me/ejemplos/sexy-lightbox-2/
*/

Element.implement({
	css: function(params){ return this.setStyles(params);} // costumbre jQuery
});

var SexyLightBox = new Class({
  Implements: [Options, Events],
	getOptions: {
			name          : 'SLB',
			zIndex        : 65555,
			color         : 'black',
			find          : '../css/sexylightbox',
			imagesdir     : '../images/sexyimages',
			background    : 'bgSexy.png',
			backgroundIE  : 'bgSexy.gif',
			closeButton   : 'SexyClose.png',
			displayed     : 0,
			modal         : 0,
			showDuration  : 200,
			showEffect    : Fx.Transitions.linear,
      closeDuration : 400,
			closeEffect   : Fx.Transitions.linear,
			moveDuration  : 800,
			moveEffect    : Fx.Transitions.Back.easeInOut,
			resizeDuration: 800,
			resizeEffect  : Fx.Transitions.Back.easeInOut,
			shake         : { distance: 10,
                        duration: 100,
                        transition: Fx.Transitions.Sine.easeInOut,
                        loops: 2
                      },
			BoxStyles     : { 'width' : 486, 'height': 320 },
			Skin          : { 'white' : { 'hexcolor': '#FFFFFF', 'captionColor': '#000000', 'background-color': '#000', 'opacity': 0.6 },
                        'black' : { 'hexcolor': '#000000', 'captionColor': '#FFFFFF', 'background-color': '#fff', 'opacity': 0.6 }}
	},
  
	initialize: function(options){
      this.setOptions(this.getOptions, options);

      this.options.OverlayStyles = $extend(this.options.Skin[this.options.color], this.options.OverlayStyles || {});
            
      var strBG = this.options.imagesdir+'/'+this.options.color+'/'+((Browser.Engine.trident4)?this.options.backgroundIE:this.options.background);
      var name  = this.options.name;

      /**
        <div id="SLB-Overlay" style="display:none; position:absolute; top:0; left:0; opacity:0; height:?; width:?; z-index:?; background-color:?;"></div>
        <div id="SLB-Wrapper" style="display:none; z-index:?; top:?; left:?; ">
            <div id="SLB-Background" style="">
            </div>
            
            <div id="SLB-Contenedor" style="position:absolute;">
                <div id="SLB-Top" style="background-image:?;">
                    <a href="#"><img src="?" alt="Close"></a>
                    <div id="SLB-TopLeft" style="background-image:?"></div>
                </div>
                
                <div id="SLB-Contenido" style="height:?; border-left-color:?; border-right-color:?;">
                </div>

                <div id="SLB-Bottom" style="background-image:?">
                    <div id="SLB-BottomRight">
                        <div id="SLB-Navegador">

                          <a id="SLBLeft"  rel="sexylightbox[?]" href="?" >
                            <img class="btLeft" src="sexyimages/black/SexyBtLeft.png">
                          </a>
                          <a id="SLBRight" rel="sexylightbox[?]" href="?" >
                            <img class="btRight" src="sexyimages/black/SexyBtRight.png">
                          </a>

                          <strong id="SLB-Caption">?</strong>
                        </div>
                    </div>
                </div>
            
          </div>
        </div>
      **/

      this.Overlay = new Element('div', {
        'id'    : name + '-Overlay',
        'styles': {
          'display'   : 'none',
          'position'  : 'absolute',
          'top'       : 0,
          'left'      : 0,
          'opacity'   : 0,
          'height'    : window.getScrollHeight() + 'px',
          'width'     : window.getScrollWidth()  + 'px',
          'z-index'   : this.options.zIndex,
          'background-color': this.options.OverlayStyles['background-color']
        }
      });
      
      this.Wrapper = new Element('div', {
        'id'      : name + '-Wrapper',
        'styles'  : {
          'z-index'   : this.options.zIndex,
          'display'   : 'none',
          'top'       : (-this.options.BoxStyles['height']-280)+'px',
          'left'      : (window.getScroll().x + (window.getSize().x - this.options.BoxStyles['width']) / 2).toInt()+'px'
        }
      });
      
      this.Background = new Element('div', {
        'id'      : name + '-Background',
        'styles': { 'z-index'   : this.options.zIndex + 1 }
      }).injectInside(this.Wrapper);
      
      this.Contenedor = new Element('div', {
        'id'      : name + '-Contenedor',
        'styles'  : {
          'position'  : 'absolute',
          'width'     : this.options.BoxStyles['width'] + 'px',
          'z-index'   : this.options.zIndex + 2
        }
      }).injectInside(this.Wrapper);

      
      this.Top = new Element('div', {'id': name+'-Top', 'styles':{'background-image':'url('+strBG+')'}}).injectInside(this.Contenedor);
      
      this.CloseButton = new Element('a', {'href':'#'}).injectInside(this.Top);
      new Element('img', {'alt': "Close", 'src' : this.options.imagesdir+'/'+this.options.color+'/'+this.options.closeButton}).injectInside(this.CloseButton);
      new Element('div', {'id': name+'-TopLeft', 'styles': {'background-image':'url('+strBG+')'}}).injectInside(this.Top);
      
      this.Contenido = new Element('div', {
        'id'      : name + '-Contenido',
        'styles'  : {
          'height'            : this.options.BoxStyles['height'] + 'px',
          'border-left-color' : this.options.Skin[this.options.color].hexcolor,
          'border-right-color': this.options.Skin[this.options.color].hexcolor
        }
      }).injectInside(this.Contenedor);

      this.bb          = new Element('div', {'id': name + '-Bottom'      , 'styles':{'background-image':'url('+strBG+')'}}).injectInside(this.Contenedor);
      this.innerbb     = new Element('div', {'id': name + '-BottomRight' , 'styles':{'background-image':'url('+strBG+')'}}).injectInside(this.bb);
      this.Nav         = new Element('div', {'id': name + '-Navegador'   , 'styles':{'color':this.options.Skin[this.options.color].captionColor}});
      this.Descripcion = new Element('strong',{'id': name + '-Caption'   , 'styles':{'color':this.options.Skin[this.options.color].captionColor}});

      this.Overlay.injectInside(document.body);
      this.Wrapper.injectInside(document.body);
    
      /**
       * AGREGAMOS LOS EVENTOS
       ************************/

      this.CloseButton.addEvent('click', function() {
        this.close();
        return false;
      }.bind(this));

      this.Overlay.addEvent('click', function() {
        if (!this.options.modal) {
          this.close();
        }
      }.bind(this));

      document.addEvent('keydown', function(event) {
        if (this.options.displayed == 1) {
          if (event.key == 'esc'){
            this.close();
          }

          if (event.key == 'left'){
            if (this.prev) {
              this.prev.fireEvent('click', event);
            }
          }

          if (event.key == 'right'){
            if (this.next) {
              this.next.fireEvent('click', event);
            }
          }
        }
      }.bind(this));


      window.addEvents({
          'resize': function(){
              if(this.options.displayed == 1) {
                this.replaceBox();
              } else {
                this.Overlay.css({ 'height': '0px', 'width': '0px' });
              }
          }.bind(this),
          
          'scroll': function(){
              if(this.options.displayed == 1) {
                this.replaceBox();
              }          
          }.bind(this)
      });
      
      this.refresh();
	
      this.MoveBox = $empty();
	
  },

  hook: function(enlace) {
    enlace.blur();
    this.show((enlace.title || enlace.name || ""), enlace.href, (enlace.getProperty('rel') || false));
  },

  close: function() {
    this.display(0);
    this.modal = 0;
  },
  
  refresh: function() {
    this.anchors = [];
    $$("a", "area").each(function(el) {
      if (el.getProperty('rel') && el.getProperty('rel').test("^"+this.options.find)){
        el.addEvent('click', function() {
          this.hook(el);
          return false;
        }.bind(this));
        if (!(el.getProperty('id')==this.options.name+"Left" || el.getProperty('id')==this.options.name+"Right")) {
          this.anchors.push(el);
        }
      }
    }.bind(this));
  },

	/*
	Property: display
		Show or close box
		
	Argument:
		option - integer, 1 to Show box and 0 to close box (with a transition).
	*/	
  display: function(option) {
      if(this.Transition)
        this.Transition.cancel();				

      // Mostrar lo sexy que es LightBox
      if(this.options.displayed == 0 && option != 0 || option == 1) {

        $$('select', 'object', 'embed').each(function(node){  node.style.visibility = 'hidden' });

        if (this.options.displayed == 0) {
          this.Wrapper.css({
            'display' : 'none',
            'top'     : (-this.options.BoxStyles['height']-280)+'px',
            'height'  : (this.options.BoxStyles['height']-80)+'px',
            'width'   : this.options.BoxStyles['width']+'px'
          });
        }

        this.Overlay.css({'display': 'block'});
        this.options.displayed = 1;

        this.Transition = new Fx.Tween(this.Overlay,
          {
            property: 'opacity',
            duration: this.options.showDuration,
            transition: this.options.showEffect
          }
        ).start(this.options.OverlayStyles['opacity']);
        
        this.Wrapper.css({'display': 'block'});

      }
      // Cerrar el Lightbox
      else
      {

        $$('select', 'object', 'embed').each(function(node){ node.style.visibility = 'visible' });

        this.Wrapper.css({
          'display' : 'none',
          'top'     : (-this.options.BoxStyles['height']-280)+'px',
          'height'  : (this.options.BoxStyles['height']-80)+'px',
          'width'   : this.options.BoxStyles['width']+'px'
        });
        
        this.options.displayed = 0;

        this.Transition = new Fx.Tween(this.Overlay,
          {
            property: 'opacity',
            duration: this.options.closeDuration,
            transition: this.options.closeEffect,
            onComplete: function() {
                this.Image.dispose();
                this.Overlay.css({ 'height': 0, 'width': 0 });
            }.bind(this)
          }
        ).start(0);
      }			
    
  },
  
  
	/*
	Property: replaceBox
    Cambiar de tamaño y posicionar el lightbox en el centro de la pantalla
	*/
	replaceBox: function(data) {
      sizes = window.getSize();
      scrollito = window.getScroll();
      
      data = $extend({
        'width'  : this.ajustarWidth,
        'height' : this.ajustarHeight,
        'resize' : 0
      }, data || {});

      if(this.MoveBox)
        this.MoveBox.cancel();
        
      this.MoveBox = new Fx.Morph(this.Wrapper, {
        duration: this.options.moveDuration,
        transition: this.options.moveEffect
      }).start({
        'left': (scrollito.x + ((sizes.x - data.width) / 2)).toInt(),
        'top' : (scrollito.y + (sizes.y - (data.height+((this.MostrarNav)?80:48))) / 2).toInt()
      });

      if (data.resize) {
        if(this.ResizeBox2)
          this.ResizeBox2.cancel();
        this.ResizeBox2 = new Fx.Morph(this.Contenido, {
          duration: this.options.resizeDuration,
          transition: this.options.resizeEffect
        }).start({
          'height': data.height+ 'px'
        });

        if(this.ResizeBox)
          this.ResizeBox.cancel();

        this.ResizeBox = new Fx.Morph(this.Contenedor, {
          duration: this.options.resizeDuration,
          transition: this.options.resizeEffect,
          onComplete: function() {
            this.Wrapper.css({'width': data.width + 'px'});
          }.bind(this)
        }).start({
          'width': data.width + 'px'
        });
      }
      
      if (Browser.Engine.presto) { //Opera Bug :(
        this.Overlay.css({ 'height': 0, 'width': 0 });
      }

      this.Overlay.css({
        'height': window.getScrollHeight() + 'px',
        'width': window.getScrollWidth() + 'px'
      });
      
	},
	
	/*
	Function: getInfo
		Devolver los botones de navegacion
	*/	
  getInfo: function (image, id) {
      return new Element('a', {
        'id'    : this.options.name+id,
        'title' : image.title,
        'href'  : image.href,
        'rel'   : image.getProperty('rel')
        }).adopt(new Element('img', {
          'src'   : this.options.imagesdir+'/'+this.options.color+'/SexyBt'+id+'.png',
          'class' : 'bt'+id
        }));
  },

	/*
	Function: show
		Verificar que el enlace apunte hacia una imagen, y preparar el lightbox.
	*/
  show: function(caption, url, rel) {
      this.MostrarNav = false;
      this.showLoading();
      
      // check if a query string is involved
      var baseURL = url.match(/(.+)?/)[1] || url;

      // regex to check if a href refers to an image
      var imageURL = /\.(jpe?g|png|gif|bmp)/gi;

      if (caption) {
        this.MostrarNav = true;
      }

      // check for images
      if ( baseURL.match(imageURL) ) {

          /**
           * Cargar Imagen.
           *****************/
          this.imgPreloader = new Image();
          this.imgPreloader.onload = function() {
              this.imgPreloader.onload=function(){};

              // Resizing large images
              var x = window.getWidth() - 100;
              var y = window.getHeight() - 100;

              var imageWidth = this.imgPreloader.width;
              var imageHeight = this.imgPreloader.height;

              if (imageWidth > x)
              {
                imageHeight = imageHeight * (x / imageWidth);
                imageWidth = x;
                if (imageHeight > y)
                {
                  imageWidth = imageWidth * (y / imageHeight);
                  imageHeight = y;
                }
              }
              else if (imageHeight > y)
              {
                imageWidth = imageWidth * (y / imageHeight);
                imageHeight = y;
                if (imageWidth > x)
                {
                  imageHeight = imageHeight * (x / imageWidth);
                  imageWidth = x;
                }
              }
              // End Resizing

              
              // Ajustar el tamaño del lightbox
              if (this.MostrarNav || caption){
                this.ajustarHeight = (imageHeight-21);
              }else{
                this.ajustarHeight = (imageHeight-35);
              };

              this.ajustarWidth = (imageWidth+14);

              this.replaceBox({
                'width'  :this.ajustarWidth,
                'height' :this.ajustarHeight,
                'resize' : 1
              });
              
              // Mostrar la imagen, solo cuando la animacion de resizado se ha completado
              this.ResizeBox.addEvent('onComplete', function() {
                this.showImage(this.imgPreloader.src, {'width':imageWidth, 'height': imageHeight});
              }.bind(this));
          }.bind(this);
          
          this.imgPreloader.onerror = function() {
            this.show('', this.options.imagesdir+'/'+this.options.color+'/404.png', this.options.find);
          }.bind(this);

          this.imgPreloader.src = url;

      } else { //code to show html pages
        

        var queryString = url.match(/\?(.+)/)[1];
        var params = this.parseQuery( queryString );
        params['width']   = params['width'].toInt();
        params['height']  = params['height'].toInt();
        params['modal']   = params['modal'];
        
        this.options.modal = params['modal'];
        
        this.ajustarHeight = params['height'].toInt()+(Browser.Engine.presto?2:0);
        this.ajustarWidth  = params['width'].toInt()+14;

        this.replaceBox({
          'width'  : this.ajustarWidth,
          'height' : this.ajustarHeight,
          'resize' : 1
        });
        
        
        if (url.indexOf('TB_inline') != -1) //INLINE ID
        {
          this.ResizeBox.addEvent('onComplete', function() {
            this.showContent($(params['inlineId']).get('html'), {'width': params['width']+14, 'height': params['height']+(Browser.Engine.presto?2:0)}, params['background']);
          }.bind(this));
        }
        else if(url.indexOf('TB_iframe') != -1) //IFRAME
        {
          var urlNoQuery = url.split('TB_');
          this.ResizeBox.addEvent('onComplete', function() {
            this.showIframe(urlNoQuery[0], {'width': params['width']+14, 'height': params['height']}, params['background']);
          }.bind(this));
        }
        else //AJAX
        {
          this.ResizeBox.addEvent('onComplete', function() {
            var myRequest = new Request.HTML({
              url         : url,
              method      : 'get',
              evalScripts : false,
              onFailure   : function (xhr) {if(xhr.status==404){this.show('', this.options.imagesdir+'/'+this.options.color+'/404html.png', this.options.find)}}.bind(this),
              onSuccess   : this.handlerFunc.bind(this)
            }).send();
          }.bind(this));
        }
      }

      this.next       = false;
      this.prev       = false;
      // Si la imagen pertenece a un grupo
      if (rel.length > this.options.find.length)
      {
          this.MostrarNav = true;
          var foundSelf   = false;
          var exit        = false;

          this.anchors.each(function(image, index){
            if (image.getProperty('rel') == rel && !exit) {
              if (image.href == url) {
                  foundSelf = true;
              } else {
                  if (foundSelf) {
                      this.next = this.getInfo(image, "Right");
                      // stop searching
                      exit = true;
                  }
                  else {
                      this.prev = this.getInfo(image, "Left");
                  }
              }
            }
          }.bind(this));
      }

      this.addButtons();
      this.showNav(caption);
      this.display(1);
  },
  
  handlerFunc: function(tree, elements, html, script) {
    this.showContent(html, {'width':this.ajustarWidth, 'height': this.ajustarHeight});
    $exec(script);
  },

  addButtons: function(){
      if(this.prev) this.prev.addEvent('click', function(event) {event.stop();this.hook(this.prev);}.bind(this));
      if(this.next) this.next.addEvent('click', function(event) {event.stop();this.hook(this.next);}.bind(this));
  },
  
 /**
  * Mostrar navegacion.
  *****************/
  showNav: function(caption) {
      if (this.MostrarNav || caption) {
        this.bb.addClass("SLB-bbnav");
        this.Nav.empty();
        this.Nav.injectInside(this.innerbb);
        this.Descripcion.set('html', caption);
        this.Nav.adopt(this.prev);
        this.Nav.adopt(this.next);
        this.Descripcion.injectInside(this.Nav);
      }
      else
      {
        this.bb.removeClass("SLB-bbnav");
        this.innerbb.empty();
      }
  },
  
  showImage: function(image, size) {
    this.Image = new Element('img', { 'src' : image, 'styles': {
        'width'  : size['width'],
        'height' : size['height']
    }}).injectInside(this.Background.empty().erase('style').css({width:'auto', height:'auto'}));

    this.Contenedor.css({
      'background' : 'none'
    });

    this.Contenido.empty().css({
        'background-color': 'transparent',
        'padding'         : '0px',
        'width'           : 'auto'
    });

  },
  
  showContent: function(html, size, bg) {
    this.Background.css({
      'width'            : size['width']-14,
      'height'           : size['height']+35,
      'background-color' : bg || '#ffffff'
    });
  
    this.Image = new Element('div', { 'styles': {
      'width'       : size['width']-14,
      'height'      : size['height'],
      'overflow'    : 'auto',
      'background'  : bg || '#ffffff'
    }}).set('html',html).injectInside(this.Contenido.empty().css({
      'width'             : size['width']-14,
      'background-color'  : bg || '#ffffff'
    }));
    this.Contenedor.css({
      'background': 'none'
    });

    $$('#'+this.Wrapper.get('id')+' select', '#'+this.Wrapper.get('id')+' object', '#'+this.Wrapper.get('id')+' embed').each(function(node){ node.style.visibility = 'visible' });
  },

  showIframe: function(src, size, bg) {
    this.Background.css({
      'width'           : size['width']-14,
      'height'          : size['height']+35,
      'background-color': bg || '#ffffff'
    });
  
    this.Image = new Element('iframe', {
      'frameborder' : 0,
      'id'          : "IF_"+new Date().getTime(),
      'styles'      : {
        'width'       : size['width']-14,
        'height'      : size['height'],
        'background'  : bg || '#ffffff'
      }
    }).set('src',src).injectInside(this.Contenido.empty().css({
      'width'             : size['width']-14,
      'background-color'  : bg || '#ffffff',
      'padding'           : '0px'
    }));
    this.Contenedor.css({
      'background' : 'none'
    });
  },

  showLoading: function() {
      this.Background.empty().erase('style').css({width:'auto', height:'auto'});

      this.Contenido.empty().css({
        'background-color'  : 'transparent',
        'padding'           : '0px',
        'width'             : 'auto'
      });

      this.Contenedor.css({
        'background' : 'url('+this.options.imagesdir+'/'+this.options.color+'/loading.gif) no-repeat 50% 50%'
      });

      this.replaceBox({
        'width'  : this.options.BoxStyles['width'],
        'height' : this.options.BoxStyles['height'],
        'resize' : 1
      });

  },

  parseQuery: function (query) {
    if( !query )
      return {};
    var params = {};

    var pairs = query.split(/[;&]/);
    for ( var i = 0; i < pairs.length; i++ ) {
      var pair = pairs[i].split('=');
      if ( !pair || pair.length != 2 )
        continue;
      params[unescape(pair[0])] = unescape(pair[1]).replace(/\+/g, ' ');
     }
     return params;
  },
  
  shake: function() {
		var d=this.options.shake.distance;
		var l=this.Wrapper.getCoordinates();
		l = l.left;
		if (!this.tween) {
      this.tween = new Fx.Tween(this.Wrapper,{ 
        link       : 'chain', 
        duration   : this.options.shake.duration,
        transition : this.options.shake.transition
      });
		}
		for(x=0;x<this.options.shake.loops;x++) {
		 this.tween.start('left',l+d).start('left',l-d);
		}
		this.tween.start('left',l+d).start('left',l);
  }
  
});