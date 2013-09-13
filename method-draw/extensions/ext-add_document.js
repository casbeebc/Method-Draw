/*
 * ext-biobutton-bacteria.js
 *
 * Licensed under the Apache License, Version 2
 *
 * Copyright(c) 2010 Brett Casbeer
 *
 */
 
methodDraw.addExtension("add-document", {

    callback: function(params) {
        //console.log("callback");
        //console.log(params);
        /*
        methodDraw.canvas.addDocument = function() {
            console.log("GOT HERE");
            console.log(methodDraw.canvas.getSelectedElems());
        }
        */
    },
    addDocument: function(opts) {
        
        /*
        console.log("Napkin ID");
        console.log(NAPKIN_ID);
        
        console.log("addDocument");
        console.log(opts);
        
		//var str = orig_source = methodDraw.canvas.getSvgString();
		*/
		$('#add_document_window').click(function(event){
            if(event.target.id == "add_document_overlay") {
              $('#add_document_window').fadeOut();	  
            }
		});		
        $('#add_document_window').fadeIn();
        $('#add_document_container').focus().select();
    }
     
});

