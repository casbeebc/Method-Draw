<?php
    
    if(empty($_GET)) {
        header("Location: index.php?id=".bin2hex(openssl_random_pseudo_bytes(4)));
    } else {
?>
        <script type="text/javascript">
            var NAPKIN_ID = "<? echo $_GET["id"]; ?>";
        </script>
<?
    }
?>

<!DOCTYPE html>
<html>
<!-- removed for now, causes problems in Firefox: manifest="svg-editor.manifest" -->
<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="chrome=1"/>
<link rel="icon" type="image/png" href="images/logo.png"/>

<!--{if svg_edit_release}>
  <link rel="stylesheet" href="css/method-draw.compiled.css" type="text/css"/>
<!{else}-->
  <link rel="stylesheet" href="lib/jgraduate/css/jPicker.css" type="text/css"/>
  <link rel="stylesheet" href="lib/jgraduate/css/jgraduate.css" type="text/css"/>
  <link rel="stylesheet" href="css/method-draw.css" type="text/css"/>
  <link rel="stylesheet" href="css/fonts.css" type="text/css"/>
  <link rel="stylesheet" href="lib/dropzone/css/basic.css" type="text/css"/>
  <link rel="stylesheet" href="lib/dropzone/css/dropzone.css" type="text/css"/>
<!--{endif}-->
  <meta name="apple-mobile-web-app-capable" content="yes"/>


  <script type="text/javascript" src="lib/jquery.js"></script>


<!--{if svg_edit_release}>
  <script type="text/javascript" src="method-draw.compiled.js"></script>
<!{else}-->
  <script type="text/javascript" src="lib/touch.js"></script>
  <script type="text/javascript" src="lib/js-hotkeys/jquery.hotkeys.min.js"></script>
  <script type="text/javascript" src="lib/jquerybbq/jquery.bbq.min.js"></script>
  <script type="text/javascript" src="lib/jquery.svgicons.js"></script>
  <script type="text/javascript" src="lib/jgraduate/jquery.jgraduate.js"></script>
  <script type="text/javascript" src="lib/contextmenu/jquery.contextMenu.js"></script>
  <script type="text/javascript" src="lib/jquery-ui/jquery-ui-1.8.17.custom.min.js"></script>
  <script type="text/javascript" src="lib/dropzone/dropzone.js"></script>
  <script type="text/javascript" src="src/browser.js"></script>
  <script type="text/javascript" src="src/svgtransformlist.js"></script>
  <script type="text/javascript" src="src/math.js"></script>
  <script type="text/javascript" src="src/units.js"></script>
  <script type="text/javascript" src="src/svgutils.js"></script>
  <script type="text/javascript" src="src/sanitize.js"></script>
  <script type="text/javascript" src="src/history.js"></script>
  <script type="text/javascript" src="src/select.js"></script>
  <script type="text/javascript" src="src/draw.js"></script>
  <script type="text/javascript" src="src/path.js"></script>
  <script type="text/javascript" src="src/dialog.js"></script>
  <script type="text/javascript" src="src/svgcanvas.js"></script>
  <script type="text/javascript" src="src/method-draw.js"></script>
  <script type="text/javascript" src="lib/jquery-draginput.js"></script>
  <script type="text/javascript" src="lib/contextmenu.js"></script>
  <script type="text/javascript" src="lib/jgraduate/jpicker.min.js"></script>
  <script type="text/javascript" src="lib/mousewheel.js"></script>
  <script type="text/javascript" src="extensions/ext-grid.js"></script>
  <script type="text/javascript" src="extensions/ext-add_document.js"></script>

  
  <!-- bio buttons -->
  <script type="text/javascript" src="extensions/ext-biobutton-cell.js"></script>
  <script type="text/javascript" src="extensions/ext-biobutton-neuron.js"></script>
  <script type="text/javascript" src="extensions/ext-biobutton-bacteria.js"></script>
  
  <script type="text/javascript" src="extensions/ext-mathjax.js"></script>
  <script type="text/javascript" src="lib/requestanimationframe.js"></script>
  
  <script type="text/javascript" src="lib/taphold.js"></script>
<!--{endif}-->

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-1944083-9']);
  _gaq.push(['_setDomainName', 'datamingle.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<title>Method Draw</title>
</head>
<body>
<div id="svg_editor">

<div id="rulers">
	<div id="ruler_corner"></div>
	<div id="ruler_x">
	  <div id="ruler_x_cursor"></div>
		<div>
			<canvas height="15"></canvas>
		</div>
	</div>
	<div id="ruler_y">
	  <div id="ruler_y_cursor"></div>
		<div>
			<canvas width="15"></canvas>
		</div>
	</div>
</div>

<div id="workarea">
<div id="svgcanvas" style="position:relative">

</div>
</div>

<div id="menu_bar">
  <a class="menu">
    <div class="menu_title" id="logo"></div>
    <div class="menu_list">
      <div id="tool_about" class="menu_item">About this Editor...</div>
      <div class="separator"></div>
      <div id="tool_about" class="menu_item">Keyboard Shortcus...</div>
    </div>
  </a>
  
  <div class="menu">
  	<div class="menu_title">File</div>
  	<div class="menu_list" id="file_menu"> 
  		<div id="tool_clear" class="menu_item">New Document</div>
  		<div id="tool_open" class="menu_item" style="display: none;"><div id="fileinputs"></div>Open SVG...</div>
  		<div id="tool_import" class="menu_item" style="display: none;"><div id="fileinputs_import"></div>Import Image...</div>
  		<div id="tool_save" class="menu_item">Save Image... <span class="shortcut">⌘S</span></div>
  		<div id="tool_export" class="menu_item">Export as PNG</div>
  	</div>
  </div>

  <div class="menu">
    <div class="menu_title">Edit</div>
  	<div class="menu_list" id="edit_menu">
  		<div class="menu_item" id="tool_undo">Undo <span class="shortcut">⌘Z</span></div>
  		<div class="menu_item" id="tool_redo">Redo <span class="shortcut">⌘Y</span></div>
  		<div class="separator"></div>
  		<div class="menu_item action_selected disabled" id="tool_cut">Cut <span class="shortcut">⌘X</span></div>
  		<div class="menu_item action_selected disabled" id="tool_copy">Copy <span class="shortcut">⌘C</span></div>
			<div class="menu_item action_selected disabled" id="tool_paste">Paste <span class="shortcut">⌘V</span></div>
  		<div class="menu_item action_selected disabled" id="tool_clone">Duplicate <span class="shortcut">⌘D</span></div>
			<div class="menu_item action_selected disabled" id="tool_delete">Delete <span>⌫</span></div>
    </div>
  </div>
  
  <div class="menu">
    <div class="menu_title">Object</div>
  	<div class="menu_list"  id="object_menu">
			<div class="menu_item action_selected disabled" id="tool_move_top">Bring to Front <span class="shortcut">⌘⇧↑</span></div>
			<div class="menu_item action_selected disabled" id="tool_move_up">Bring Forward <span class="shortcut">⌘↑</span></div>
			<div class="menu_item action_selected disabled" id="tool_move_down">Send Backward <span class="shortcut">⌘↓</span></div>
			<div class="menu_item action_selected disabled" id="tool_move_bottom">Send to Back <span class="shortcut">⌘⇧↓</span></div>
			<div class="separator"></div>
			<div class="menu_item action_multi_selected disabled" id="tool_group">Group Elements <span class="shortcut">⌘G</span></div>
			<div class="menu_item action_group_selected disabled" id="tool_ungroup">Ungroup Elements <span class="shortcut">⌘⇧G</span></div>
			<div class="separator"></div>
			<div class="menu_item action_path_convert_selected disabled" id="tool_topath">Convert to Path</div>
			<div class="menu_item action_path_selected disabled" id="tool_reorient">Reorient path</div>
    </div>
  </div>

  <div class="menu">
    <div class="menu_title">View</div>
  	<div class="menu_list" id="view_menu">
  	    <div class="menu_item push_button_pressed" id="tool_rulers">View Rulers</div>
  	    <div class="menu_item" id="tool_wireframe">View Wireframe</div>
  	    <div class="menu_item" id="tool_snap">Snap to Grid</div>
  	    <div class="separator"></div>
    		<div class="menu_item" id="tool_source">Source... <span class="shortcut">⌘U</span></div>
    </div>
  </div>
  
</div>

<!------------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------>
<!----------------------------------------     REMOVED    ---------------------------------------------------->
<!------------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------>

<div id="tools_top" class="tools_panel" style="width:0px;height:0px;">

	<div id="canvas_panel" class="context_panel">
	  
	  <h4 class="clearfix">Canvas</h4>
	  
		<label data-title="Change canvas width">
			<input size="3" id="canvas_width" type="text" pattern="[0-9]*" />
			<span class="icon_label">Width</span>
		</label>
		<label data-title="Change canvas height">
			<input id="canvas_height" size="3" type="text" pattern="[0-9]*" />
			<span class="icon_label">Height</span>
		</label>
		  	
  	
  	<label data-title="Change canvas color" class="draginput">
    	<span>Color</span>
  		<div id="color_canvas_tools">
  		  <div class="color_tool active" id="tool_canvas">
    		  <div class="color_block">
    			  <div id="canvas_bg"></div>
    			  <div id="canvas_color"></div>
    		  </div>
    		</div>
    	</div>
  	</label>

	  <div class="draginput">
	    <span>Sizes</span>
  		<select id="resolution">
  			<option id="selectedPredefined" selected="selected">Custom</option>
  			<option>640x480</option>
  			<option>800x600</option>
  			<option>1024x768</option>
  			<option>1280x960</option>
  			<option>1600x1200</option>
  			<option id="fitToContent" value="content">Fit to Content</option>
  		</select>
  		<div class="caret"></div>
  		<label id="resolution_label">Custom</label>
		</div>

	</div>
	
	<div id="rect_panel" class="context_panel">
	  <h4 class="clearfix">Rectangle</h4>
	  <label>
			<input id="rect_x" class="attr_changer" data-title="Change X coordinate" size="3" data-attr="x" pattern="[0-9]*" />
			<span>X</span> 
		</label>
		<label>
		  <input id="rect_y" class="attr_changer" data-title="Change Y coordinate" size="3" data-attr="y" pattern="[0-9]*" />
			<span>Y</span> 
		</label>
		<label id="rect_width_tool attr_changer" data-title="Change rectangle width">
			<input id="rect_width" class="attr_changer" size="3" data-attr="width" type="text" pattern="[0-9]*" />
			<span class="icon_label">Width</span>
		</label>
		<label id="rect_height_tool" data-title="Change rectangle height">
			<input id="rect_height" class="attr_changer" size="3" data-attr="height" type="text" pattern="[0-9]*" />
			<span class="icon_label">Height</span>
		</label>
	</div>
	
	<div id="path_panel" class="context_panel clearfix">
	  <h4 class="clearfix">Path</h4>
	  <label>
		  <input id="path_x" class="attr_changer" data-title="Change ellipse's cx coordinate" size="3" data-attr="x" pattern="[0-9]*" />
		  <span>X</span>
		</label>
		<label>
		  <input id="path_y" class="attr_changer" data-title="Change ellipse's cy coordinate" size="3" data-attr="y" pattern="[0-9]*" />
		  <span>Y</span>
		</label>
	</div>

	<div id="image_panel" class="context_panel clearfix">
	<h4>Image</h4>
		<label>
			<input id="image_x" class="attr_changer" data-title="Change X coordinate" size="3" data-attr="x"  pattern="[0-9]*"/>
		  <span>X</span> 
		</label>
		<label>
		  <input id="image_y" class="attr_changer" data-title="Change Y coordinate" size="3" data-attr="y"  pattern="[0-9]*"/>
		  <span>Y</span> 
		</label>
		<label>
		  <input id="image_width" class="attr_changer" data-title="Change image width" size="3" data-attr="width" pattern="[0-9]*" />
		  <span class="icon_label">Width</span>
		</label>
		<label>
		  <input id="image_height" class="attr_changer" data-title="Change image height" size="3" data-attr="height" pattern="[0-9]*" />
		  <span class="icon_label">Height</span>
		</label>
  </div>
  
  <div id="circle_panel" class="context_panel">
    <h4>Circle</h4>
		<label id="tool_circle_cx">
		  <span>Center X</span>
		  <input id="circle_cx" class="attr_changer" title="Change circle's cx coordinate" size="3" data-attr="cx"/>
		</label>
		<label id="tool_circle_cy">
		  <span>Center Y</span>
		  <input id="circle_cy" class="attr_changer" title="Change circle's cy coordinate" size="3" data-attr="cy"/>
		</label>
		<label id="tool_circle_r">
		  <span>Radius</span>
		  <input id="circle_r" class="attr_changer" title="Change circle's radius" size="3" data-attr="r"/>
		</label>
	</div>

	<div id="ellipse_panel" class="context_panel clearfix">
	  <h4>Ellipse</h4>
		<label id="tool_ellipse_cx">
		  <input id="ellipse_cx" class="attr_changer" data-title="Change ellipse's cx coordinate" size="3" data-attr="cx" pattern="[0-9]*" />
		  <span>X</span>
		</label>
		<label id="tool_ellipse_cy">
		  <input id="ellipse_cy" class="attr_changer" data-title="Change ellipse's cy coordinate" size="3" data-attr="cy" pattern="[0-9]*" />
		  <span>Y</span>
		</label>
		<label id="tool_ellipse_rx">
		  <input id="ellipse_rx" class="attr_changer" data-title="Change ellipse's x radius" size="3" data-attr="rx" pattern="[0-9]*" />
	    <span>Radius X</span>
		</label>
		<label id="tool_ellipse_ry">
		  <input id="ellipse_ry" class="attr_changer" data-title="Change ellipse's y radius" size="3" data-attr="ry" pattern="[0-9]*" />
		  <span>Radius Y</span>
		</label>
	</div>

	<div id="line_panel" class="context_panel clearfix">
	  <h4>Line</h4>
		<label id="tool_line_x1">
		  <input id="line_x1" class="attr_changer" data-title="Change line's starting x coordinate" size="3" data-attr="x1" pattern="[0-9]*" />
		  <span>Start X</span>
		</label>
		<label id="tool_line_y1">
		  <input id="line_y1" class="attr_changer" data-title="Change line's starting y coordinate" size="3" data-attr="y1" pattern="[0-9]*" />
		  <span>Start Y</span>
		</label>
		<label id="tool_line_x2">
		  <input id="line_x2" class="attr_changer" data-title="Change line's ending x coordinate" size="3" data-attr="x2"   pattern="[0-9]*" />
		  <span>End X</span>
		</label>
		<label id="tool_line_y2">
		  <input id="line_y2" class="attr_changer" data-title="Change line's ending y coordinate" size="3" data-attr="y2"   pattern="[0-9]*" />
		  <span>End Y</span>
		</label>
	</div>

	<div id="text_panel" class="context_panel">
	  <h4>Text</h4>
		<label>
		  <input id="text_x" class="attr_changer" data-title="Change text x coordinate" size="3" data-attr="x" pattern="[0-9]*" />
		  <span>X</span>
		</label>
		<label>
		  <input id="text_y" class="attr_changer" data-title="Change text y coordinate" size="3" data-attr="y" pattern="[0-9]*" />
		  <span>Y</span>
		</label>
		
		<div class="toolset draginput select twocol" id="tool_font_family">
				<!-- Font family -->
			<span>Font</span>
		  <div id="preview_font" style="font-family: Helvetica, Arial, sans-serif;">Helvetica</div>
		  <div class="caret"></div>
			<input id="font_family" data-title="Change Font Family" size="12" type="hidden" />
			<select id="font_family_dropdown">
				  <option value="Helvetica, Arial, sans-serif" selected="selected">Helvetica</option>
					<!--<option value="Arvo, sans-serif">Arvo</option>
					<option value="Euphoria, sans-serif">Euphoria</option>
					<option value="Oswald, sans-serif">Oswald</option>
					<option value="'Shadows Into Light', serif">Shadows Into Light</option>
					<option value="'Simonetta', serif">Simonetta</option>-->
					<option value="'Trebuchet MS', Gadget, sans-serif">Trebuchet</option>
					<option value="Georgia, Times, 'Times New Roman', serif">Georgia</option>
					<option value="'Palatino Linotype', 'Book Antiqua', Palatino, serif">Palatino</option>
					<option value="'Times New Roman', Times, serif">Times</option>
					<option value="'Courier New', Courier, monospace">Courier</option>
			</select>
      <div class="tool_button" id="tool_bold" data-title="Bold Text [B]">B</div>
      <div class="tool_button" id="tool_italic" data-title="Italic Text [I]">i</div>
		</div>

		<label id="tool_font_size" data-title="Change Font Size">
			<input id="font_size" size="3" value="0" />
			<span id="font_sizeLabel" class="icon_label">Font Size</span>
		</label>
		<!-- Not visible, but still used -->
		<input id="text" type="text" size="35"/>
	</div>

	<!-- formerly gsvg_panel -->
	<div id="container_panel" class="context_panel clearfix">
	</div>
	
	<div id="use_panel" class="context_panel clearfix">
		<div class="tool_button clearfix" id="tool_unlink_use" data-title="Break link to reference element (make unique)">Break link reference</div>
	</div>
	
	<div id="g_panel" class="context_panel clearfix">
		<h4>Group</h4>
		<label>
		  <input id="g_x" class="attr_changer" data-title="Change groups's x coordinate" size="3" data-attr="x" pattern="[0-9]*" />
		  <span>X</span>
		</label>
		<label>
		  <input id="g_y" class="attr_changer" data-title="Change groups's y coordinate" size="3" data-attr="y" pattern="[0-9]*" />
		  <span>Y</span>
		</label>
	</div>
	
	<div id="path_node_panel" class="context_panel clearfix">
	  <h4>Edit Path</h4>

		<label id="tool_node_x">
			<input id="path_node_x" class="attr_changer" data-title="Change node's x coordinate" size="3" data-attr="x" />
		  <span>X</span>
		</label>
		<label id="tool_node_y">
			<input id="path_node_y" class="attr_changer" data-title="Change node's y coordinate" size="3" data-attr="y" />
		  <span>Y</span>
		</label>
		
		<div id="segment_type" class="draginput label">
		  <span>Segment Type</span>
  		<select id="seg_type" data-title="Change Segment type">
  			<option id="straight_segments" selected="selected" value="4">Straight</option>
  			<option id="curve_segments" value="6">Curve</option>
  		</select>
  		<div class="caret"></div>
  		<label id="seg_type_label">Straight</label>
		</div>
		
		<!--
		<label class="draginput checkbox" data-title="Link Control Points">
		  <span>Linked Control Points</span>
		  <div class="push_bottom"><input type="checkbox" id="tool_node_link" checked="checked" /></div>
		</label>
	-->
		
		<div class="clearfix"></div>
		<div class="tool_button" id="tool_node_clone" title="Adds a node">Add Node</div>
		<div class="tool_button" id="tool_node_delete" title="Delete Node">Delete Node</div>
		<div class="tool_button" id="tool_openclose_path" title="Open/close sub-path">Open Path</div>
		<!--<div class="tool_button" id="tool_add_subpath" title="Add sub-path"></div>-->
	</div>
	
	<!-- Buttons when a single element is selected -->
	<div id="selected_panel" class="context_panel">

		<label id="tool_angle" data-title="Change rotation angle" class="draginput">
			<input id="angle" class="attr_changer" size="2" value="0" data-attr="transform" data-min="-180" data-max="180" type="text"/>
			<span class="icon_label">Rotation</span>
			<div id="tool_angle_indicator">
			  <div id="tool_angle_indicator_cursor"></div>
			</div>
		</label>
		
			<label class="toolset" id="tool_opacity" data-title="Change selected item opacity">
  			<input id="group_opacity" class="attr_changer" data-attr="opacity" data-multiplier="0.01" size="3" value="100" step="5" min="0" max="100" />
  		  <span id="group_opacityLabel" class="icon_label">Opacity</span>
  		</label>
		
		<div class="toolset" id="tool_blur" data-title="Change gaussian blur value">
			<label>
				<input id="blur" size="2" value="0" step=".1"  min="0" max="10" />
			  <span class="icon_label">Blur</span>
			</label>
		</div>
		
		<label id="cornerRadiusLabel" data-title="Change Rectangle Corner Radius">
			<input id="rect_rx" size="3" value="0" data-attr="rx" class="attr_changer" type="text" pattern="[0-9]*" />
		  <span class="icon_label">Roundness</span>
		</label>
		
		<div class="clearfix"></div>
		<div id="align_tools">
  		<h4>Align</h4>
  		<div class="toolset align_buttons" id="tool_position">
  				<label>
  				  <div class="col last clear" id="position_opts">
    				  <div class="draginput_cell" id="tool_posleft" title="Align Left"></div>
          		<div class="draginput_cell" id="tool_poscenter" title="Align Center"></div>
          		<div class="draginput_cell" id="tool_posright" title="Align Right"></div>
          		<div class="draginput_cell" id="tool_postop" title="Align Top"></div>
          		<div class="draginput_cell" id="tool_posmiddle" title="Align Middle"></div>
          		<div class="draginput_cell" id="tool_posbottom" title="Align Bottom"></div>
    				</div>
  				</label>
  		</div>		
  	</div>
	</div>
	
	<!-- Buttons when multiple elements are selected -->
	<div id="multiselected_panel" class="context_panel clearfix">
	  <h4 class="hidable">Multiple Elements</h4>
	  
		<div class="toolset align_buttons" style="position: relative">
		  <label id="tool_align_relative" style="margin-top: 10px;"> 
  			<select id="align_relative_to" title="Align relative to ...">
  			<option id="selected_objects" value="selected">Align to objects</option>
  			<option id="page" value="page">Align to page</option>
  			</select>
  		</label>
		  <h4>.</h4>
    		<div class="col last clear">
      		<div class="draginput_cell" id="tool_alignleft" title="Align Left"></div>
      		<div class="draginput_cell" id="tool_aligncenter" title="Align Center"></div>
      		<div class="draginput_cell" id="tool_alignright" title="Align Right"></div>
      		<div class="draginput_cell" id="tool_aligntop" title="Align Top"></div>
      		<div class="draginput_cell" id="tool_alignmiddle" title="Align Middle"></div>
      		<div class="draginput_cell" id="tool_alignbottom" title="Align Bottom"></div>
    		</div>
		</div>
		<div class="clearfix"></div>

	</div>
	
	<div id="stroke_panel" class="context_panel clearfix">
  	<div class="clearfix"></div>
  	<h4>Stroke</h4>
  	<div class="toolset" data-title="Change stroke">
  		<label>
  			<input id="stroke_width" size="2" value="5" data-attr="stroke-width" min="0" max="99" step="1" />
  		  <span class="icon_label">Stroke Width</span>
  		</label>
  	</div>
  	<div class="stroke_tool draginput"> 
  	  <span>Stroke Dash</span>
  		<select id="stroke_style" data-title="Change stroke dash style">
  			<option selected="selected" value="none">—</option>
  			<option value="2,2">···</option>
  			<option value="5,5">- -</option>
  			<option value="5,2,2,2">-·-</option>
  			<option value="5,2,2,2,2,2">-··-</option>
  		</select>
  		<div class="caret"></div>
  		<label id="stroke_style_label">—</label>
  	</div>
		
    <label style="display: none;">
      <span class="icon_label">Stroke Join</span>
    </label>
    
    <label  style="display: none;">
      <span class="icon_label">Stroke Cap</span>
  	</label>
	</div>

</div> <!-- tools_top -->


<!------------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------>
<!---------------------------------------- END OF REMOVED ---------------------------------------------------->
<!------------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------>




	<div id="cur_context_panel">
		
	</div>


<div id="tools_left" class="tools_panel">
	<div class="tool_button" id="tool_select" title="Select Tool [V]"></div>
	<div class="tool_button" id="tool_fhpath" title="Pencil Tool [P]"></div>
	<div class="tool_button" id="tool_line" title="Line Tool [L]"></div>
	
	<div class="tool_button" id="tool_rect" title="Square/Rect Tool [R]" style="display:none;"></div>
	<div class="tool_button" id="tool_ellipse" title="Ellipse/Circle Tool [C]" style="display:none;"></div>
	<div class="tool_button" id="tool_path" title="Path Tool [P]" style="display:none;"></div>
	
	<div class="tool_button" id="tool_text" title="Text Tool [T]"></div>
	<div class="tool_button" id="tool_zoom" title="Zoom Tool [Z]"></div>
	
  <div id="color_tools" style="display:none;">
        <div id="tool_switch" title="Switch stroke and fill colors [X]" style="display:none;"></div>
  			<div class="color_tool active" id="tool_fill" style="display:none;">
  				<label class="icon_label" title="Change fill color"></label>
				  <div class="color_block">
					  <div id="fill_bg"></div>
					  <div id="fill_color" class="color_block"></div>
				  </div>
  			</div>

  			<div class="color_tool" id="tool_stroke" style="display:none;">
  					<label class="icon_label" title="Change stroke color"></label>
  				<div class="color_block">
  					<div id="stroke_bg"></div>
  					<div id="stroke_color" class="color_block" title="Change stroke color"></div>
  				</div>
  			</div>
	</div>
</div> <!-- tools_left -->

<div id="tools_bottom" class="tools_panel">

    <!-- Zoom buttons -->
	<div id="zoom_panel" class="toolset" title="Change zoom level">
		<div class="draginput select" id="zoom_label">
  		<span  id="zoomLabel" class="zoom_tool icon_label"></span>
  		<select id="zoom_select">
  		  <option value="6">6%</option>
  		  <option value="12">12%</option>
  		  <option value="16">16%</option>
  		  <option value="25">25%</option>
  		  <option value="50">50%</option>
  		  <option value="75">75%</option>
  		  <option value="100"  selected="selected">100%</option>
  		  <option value="150">150%</option>
  		  <option value="200">200%</option>
  		  <option value="300">300%</option>
  		  <option value="400">400%</option>
  		  <option value="600">600%</option>
  		  <option value="800">800%</option>
  		  <option value="1600">1600%</option>
  		</select>
  		<div class="caret"></div>
  		<input id="zoom" size="3" value="100%" type="text" readonly="readonly" />
		</div>
	</div>

	<div id="tools_bottom_3">
		<div id="palette" title="Click to change fill color, shift-click to change stroke color"></div>
	</div>
</div>

<!-- hidden divs -->
<div id="color_picker"></div>

</div> <!-- svg_editor -->

<div id="svg_source_editor">
    <div id="svg_source_overlay"></div>
    <div id="svg_source_container">
        <!-- <form action="/file-upload"
      class="dropzone"
      id="my-awesome-dropzone"></form>
        -->
    </div>
</div>

<div id="add_document_window">
    <div id="add_document_overlay"></div>
    <div id="add_document_container">
        <form action="upload.php"
            class="dropzone"
            id="my-awesome-dropzone">
        </form>
    </div>
</div>


<!--
<div id="svg_source_editor">
	<div id="svg_source_overlay"></div>
	<div id="svg_source_container">
		<div id="save_output_btns">
			<p id="copy_save_note">Copy the contents of this box into a text editor, then save the file with a .svg extension.</p>
			<button id="copy_save_done">Done</button>
		</div>
		<form>
			<textarea id="svg_source_textarea" spellcheck="false"></textarea>
		</form>
		<div id="tool_source_back" class="toolbar_button">
			<button id="tool_source_cancel" class="cancel">Cancel</button>
			<button id="tool_source_save" class="ok">Apply Changes</button>
		</div>
	</div>
</div>
-->

<div id="base_unit_container">
  <select id="base_unit">
  	<option value="px">Pixels</option>
  	<option value="cm">Centimeters</option>
  	<option value="mm">Millimeters</option>
  	<option value="in">Inches</option>
  	<option value="pt">Points</option>
  	<option value="pc">Picas</option>
  	<option value="em">Ems</option>
  	<option value="ex">Exs</option>
  </select>
</div>

<div id="dialog_box">
	<div id="dialog_box_overlay"></div>
	<div id="dialog_container">
		<div id="dialog_content"></div>
		<div id="dialog_buttons"></div>
	</div>
</div>

<ul id="cmenu_canvas" class="contextMenu">
	<li><a href="#cut">Cut <span class="shortcut">⌘X;</span></a></li>
	<li><a href="#copy">Copy<span class="shortcut">⌘C</span></a></li>
	<li><a href="#paste">Paste<span class="shortcut">⌘V</span></a></li>
	<li class="separator"><a href="#delete">Delete<span class="shortcut">⌫</span></a></li>
	<li class="separator"><a href="#group">Group<span class="shortcut">⌘G</span></a></li>
	<li><a href="#ungroup">Ungroup<span class="shortcut">⌘⇧G</span></a></li>
  <li class="separator"><a href="#move_front">Bring to Front<span class="shortcut">⌘⇧↑</span></a></li>
	<li><a href="#move_up">Bring Forward<span class="shortcut">⌘↑</span></a></li>
	<li><a href="#move_down">Send Backward<span class="shortcut">⌘↓</span></a></li>
  <li><a href="#move_back">Send to Back<span class="shortcut">⌘⇧↓</span></a></li>
  <li><a href="#add_document">Associate with document(s)...<span class="shortcut">⌘⇧A</span></li>
</ul>

</body>
</html>
