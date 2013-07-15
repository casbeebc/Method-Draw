/*
 * svg-editor.js
 *
 * Licensed under the MIT License
 *
 * Copyright(c) 2010 Alexis Deveria
 * Copyright(c) 2010 Pavol Rusnak
 * Copyright(c) 2010 Jeff Schiller
 * Copyright(c) 2010 Narendra Sisodiya
* Copyright(c)  2012 Mark MacKay
 *
 */

// Dependencies:
// 1) units.js
// 2) browser.js
// 3) svgcanvas.js

(function() { 
  
  document.addEventListener("touchstart", touchHandler, true);
  document.addEventListener("touchmove", touchHandler, true);
  document.addEventListener("touchend", touchHandler, true);
  document.addEventListener("touchcancel", touchHandler, true);
  
    if(!window.methodDraw) window.methodDraw = function($) {
		var svgCanvas;
		var Editor = {};
		var is_ready = false;
		curConfig = {
		  canvas_expansion: 1, 
		  dimensions: [740,520],
		  initFill: {color: 'fff', opacity: 1},
		  initStroke: {width: 1.5, color: '000', opacity: 1},
			initOpacity: 1,
			imgPath: 'images/',
			extPath: 'extensions/',
			jGraduatePath: 'jgraduate/images/',
			extensions: [],
			initTool: 'select',
			wireframe: false,
			colorPickerCSS: false,
			gridSnapping: false,
			gridColor: "#000",
			baseUnit: 'px',
			snappingStep: 10,
			showRulers: (svgedit.browser.isTouch()) ? false : true,
			show_outside_canvas: false,
			no_save_warning: true,
			initFont: 'Helvetica, Arial, sans-serif'
		},
			uiStrings = Editor.uiStrings = {
				common: {
					"ok":"OK",
					"cancel":"Cancel",
					"key_up":"Up",
					"key_down":"Down",
					"key_backspace":"Backspace",
					"key_del":"Del"
	
				},
				// This is needed if the locale is English, since the locale strings are not read in that instance.
				layers: {
					"layer":"Layer"
				},
				notification: {
					"invalidAttrValGiven":"Invalid value given",
					"noContentToFitTo":"No content to fit to",
					"dupeLayerName":"There is already a layer named that!",
					"enterUniqueLayerName":"Please enter a unique layer name",
					"enterNewLayerName":"Please enter the new layer name",
					"layerHasThatName":"Layer already has that name",
					"QmoveElemsToLayer":"Move selected elements to layer \"%s\"?",
					"QwantToClear":"<strong>Do you want to clear the drawing?</strong>\nThis will also erase your undo history",
					"QwantToOpen":"Do you want to open a new file?\nThis will also erase your undo history",
					"QerrorsRevertToSource":"There were parsing errors in your SVG source.\nRevert back to original SVG source?",
					"QignoreSourceChanges":"Ignore changes made to SVG source?",
					"featNotSupported":"Feature not supported",
					"enterNewImgURL":"Enter the new image URL",
					"defsFailOnSave": "NOTE: Due to a bug in your browser, this image may appear wrong (missing gradients or elements). It will however appear correct once actually saved.",
					"loadingImage":"Loading image, please wait...",
					"saveFromBrowser": "Select \"Save As...\" in your browser to save this image as a %s file.",
					"noteTheseIssues": "Also note the following issues: ",
					"unsavedChanges": "There are unsaved changes.",
					"enterNewLinkURL": "Enter the new hyperlink URL",
					"errorLoadingSVG": "Error: Unable to load SVG data",
					"URLloadFail": "Unable to load from URL",
					"retrieving": 'Retrieving "%s" ...'
				}
			};
		

		var curPrefs = {}; //$.extend({}, defaultPrefs);
		var customHandlers = {};
		Editor.curConfig = curConfig;
		Editor.tool_scale = 1;
		
		Editor.setConfig = function(opts) {
			$.extend(true, curConfig, opts);
			if(opts.extensions) {
				curConfig.extensions = opts.extensions;
			}
		}
		
		// Extension mechanisms must call setCustomHandlers with two functions: opts.open and opts.save
		// opts.open's responsibilities are:
		// 	- invoke a file chooser dialog in 'open' mode
		//	- let user pick a SVG file
		//	- calls setCanvas.setSvgString() with the string contents of that file
		// opts.save's responsibilities are:
		//	- accept the string contents of the current document 
		//	- invoke a file chooser dialog in 'save' mode
		// 	- save the file to location chosen by the user
		Editor.setCustomHandlers = function(opts) {
			Editor.ready(function() {
				if(opts.open) {
					$('#tool_open > input[type="file"]').remove();
					$('#tool_open').show();
					svgCanvas.open = opts.open;
				}
				if(opts.save) {
					Editor.show_save_warning = false;
					svgCanvas.bind("saved", opts.save);
				}
				if(opts.pngsave) {
					svgCanvas.bind("exported", opts.pngsave);
				}
				customHandlers = opts;
			});
		}
		
		Editor.randomizeIds = function() {
			svgCanvas.randomizeIds(arguments)
		}

		var callbacks = [];
		
		function loadSvgString(str, callback) {
			var success = svgCanvas.setSvgString(str) !== false;
			callback = callback || $.noop;
			if(success) {
				callback(true);
			} else {
				$.alert(uiStrings.notification.errorLoadingSVG, function() {
					callback(false);
				});
			}
		}
		
		Editor.ready = function(cb) {
			if(!is_ready) {
				callbacks.push(cb);
			} else {
				cb();
			}
		};

		Editor.runCallbacks = function() {
			$.each(callbacks, function() {
				this();
			});
			is_ready = true;
		};
		
		Editor.loadFromString = function(str) {
			Editor.ready(function() {
				loadSvgString(str);
			});
		};
		
		Editor.loadFromURL = function(url, opts) {
			if(!opts) opts = {};

			var cache = opts.cache;
			var cb = opts.callback;
		
			Editor.ready(function() {
				$.ajax({
					'url': url,
					'dataType': 'text',
					cache: !!cache,
					success: function(str) {
						loadSvgString(str, cb);
					},
					error: function(xhr, stat, err) {
						if(xhr.status != 404 && xhr.responseText) {
							loadSvgString(xhr.responseText, cb);
						} else {
							$.alert(uiStrings.notification.URLloadFail + ": \n"+err+'', cb);
						}
					}
				});
			});
		};
		
		Editor.loadFromDataURI = function(str) {
			Editor.ready(function() {
				var pre = 'data:image/svg+xml;base64,';
				var src = str.substring(pre.length);
				loadSvgString(svgedit.utilities.decode64(src));
			});
		};
		
		Editor.addExtension = function() {
			var args = arguments;
			
			// Note that we don't want this on Editor.ready since some extensions
			// may want to run before then (like server_opensave).
			$(function() {
				if(svgCanvas) svgCanvas.addExtension.apply(this, args);
			});
		};

		return Editor;
	}(jQuery);
	
	// Run init once DOM is loaded
	$(methodDraw.init);
	

})();
