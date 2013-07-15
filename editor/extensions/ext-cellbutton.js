/*
 * ext-cellButton.js
 *
 * Licensed under the Apache License, Version 2
 *
 * Copyright(c) 2010 Brett Casbeer
 *
 */
 
methodDraw.addExtension("cellbutton", function() {
        function importImage(url) {
            
            
            var newImage = svgCanvas.addSvgElementFromJson({
        			"element": "image",
        			"attr": {
        				"x": 0,
        				"y": 0,
        				"width": 0,
        				"height": 0,
        				"id": svgCanvas.getNextId(),
        				"style": "pointer-events:none;"
        			}
    		});
    		
    		svgCanvas.clearSelection();
    		svgCanvas.addToSelection([newImage]);
    		svgCanvas.setImageURL(url);
    		
            
            /*
            var insertNewImage = function(width, height) {
                var newImage = svgCanvas.addSvgElementFromJson({
        			"element": "image",
        			"attr": {
        				"x": 0,
        				"y": 0,
        				"width": width,
        				"height": height,
        				"id": svgCanvas.getNextId(),
        				"style": "pointer-events:none;"
        			}
        		});
        		
        		svgCanvas.clearSelection();
        		svgCanvas.addToSelection([newImage]);
        		svgCanvas.setImageURL(url);
        		svgCanvas.alignSelectedElements("m", "page")
      			svgCanvas.alignSelectedElements("c", "page")
      			updateContextPanel();
            }
            
            // put a placeholder img so we know the default dimensions
            var img_width = 100;
            var img_height = 100;
            var img = new Image();
            img.src = url;
            document.body.appendChild(img);
            img.onload = function() {
                img_width = img.offsetWidth;
                img_height = img.offsetHeight;
                insertNewImage(img_width, img_height);
                document.body.removeChild(img);
            }
            */            
            
    		
    	}

		return {
			name: "Animal Cell",
			// For more notes on how to make an icon file, see the source of
			// the hellorworld-icon.xml
			svgicons: "extensions/ext-cellbutton.xml",
			
			// Multiple buttons can be added in this array
			buttons: [{
				// Must match the icon ID in helloworld-icon.xml
				id: "cellbutton", 
				
				// This indicates that the button will be added to the "mode"
				// button panel on the left side
				type: "mode", 
				
				// Tooltip text
				title: "Adds an animal cell", 
				
				// Events
				events: {
					'click': function() {
						// The action taken when the button is clicked on.
						// For "mode" buttons, any other button will 
						// automatically be de-pressed.
						svgCanvas.setMode("animal_cell");
						importImage("extensions/imagelib/animal_cell.svg");
					}
				}
			}],
			// This is triggered when the main mouse button is pressed down 
			// on the editor canvas (not the tool panels)
			mouseDown: function() {
				// Check the mode on mousedown
				if(svgCanvas.getMode() == "animal_cell") {
				
					// The returned object must include "started" with 
					// a value of true in order for mouseUp to be triggered
					return {started: true};
				}
			},
			
			// This is triggered from anywhere, but "started" must have been set
			// to true (see above). Note that "opts" is an object with event info
			mouseUp: function(opts) {
				// Check the mode on mouseup
				if(svgCanvas.getMode() == "animal_cell") {
				    
				}
			},
			
			callback: function() {
			}
		};
});

