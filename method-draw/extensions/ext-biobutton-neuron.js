/*
 * ext-biobutton-neuron.js
 *
 * Licensed under the Apache License, Version 2
 *
 * Copyright(c) 2010 Brett Casbeer
 *
 */
 
methodDraw.addExtension("biobutton-neuron", function() {
        function importImage(url, rank) {
            
            var newImage = svgCanvas.addSvgElementFromJson({
        			"element": "image",
        			"attr": {
        				"x": rank*110,
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
    		
    	}

		return {
			name: "Neuron",
			// For more notes on how to make an icon file, see the source of
			// the hellorworld-icon.xml
			svgicons: "extensions/ext-biobutton-neuron.xml",
			
			// Multiple buttons can be added in this array
			buttons: [{
				// Must match the icon ID in helloworld-icon.xml
				id: "biobutton-neuron", 
				
				// This indicates that the button will be added to the "mode"
				// button panel on the left side
				type: "mode", 
				
				// Tooltip text
				title: "Add a neuron", 
				
				// Events
				events: {
					'click': function() {
						// The action taken when the button is clicked on.
						// For "mode" buttons, any other button will 
						// automatically be de-pressed.
						
						methodDraw.canvas.setMode("select");
						importImage("extensions/imagelib/neuron_bipolar.svg", 0);
						importImage("extensions/imagelib/neuron_multipolares.svg", 1);
						importImage("extensions/imagelib/neuron_pseudounipolares.svg", 2);
						importImage("extensions/imagelib/neuron_unipolar.svg", 3);
						
					}
				}
			}],
			// This is triggered when the main mouse button is pressed down 
			// on the editor canvas (not the tool panels)
			mouseDown: function() {},
			
			// This is triggered from anywhere, but "started" must have been set
			// to true (see above). Note that "opts" is an object with event info
			mouseUp: function(opts) {},
			
			callback: function() {}
		};
});

