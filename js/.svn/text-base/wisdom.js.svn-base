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
    loadCatalogDataFrom: function(data_url){
    	var data_req = new Request.JSON({
    		url: data_url
    	});
    	data_req.send();
    }
});

var app;
var catalog;
var Sexy;

window.addEvent('domready',function(ev){
	app = new Wisdom();
	app.loadContentPanes();
	Sexy = new SexyAlertBox();
});