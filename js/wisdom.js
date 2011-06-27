var Wisdom = new Class({
    alert: function(message){
       alert(message);
    },
    loadContentPanes: function(){
    	$content_panes = $$(".content_pane");
    	$content_panes.each( function(item, index, array){
    		var req = new Request.HTML({
    			url:item.get('href'),
    			evalScripts: true,
    			update: item
    		});
    		req.send();
    	});
    },
    error: function(message){
    	//TODO mostrar un mensaje FANCY
    	alert(message);
    }
    ,rpc: function(controller, action, params){
    	var ajax = new Request();
    }
});

var app;
var catalog;

window.addEvent('domready',function(ev){
	app = new Wisdom();
	app.loadContentPanes();
});
