$(document).ready(
	function()
	{
		$('#form_batch').Maxlist_AjaxBatch();
		$('#form_tests').Maxlist_BatchTests();
	
		$('#contentcolumn').TogglePanel(
			{
			headerSelector	: 'h4,h3',
			panelSelector	: 'div.ml_panel',
			speed		: 0,
			uselinks	: true,
			onTextLink	: 'apri',
			offTextLink	: 'chiudi',
			onClassLink	: 'ml_visualizza',
			offClassLink	: 'ml_visualizza',
			prehtmlTextLink :'',
			posthtmlTextLink:'',
			onstartHideAll	: true,
			forceOpenClass : '.ml_panel_1'
			//useEffects	: true,
			//effect	: 'dropleft'
			}
		);
		
		
	}
);
if(typeof(tinyMCE) == 'object')
tinyMCE.init({
		mode : "exact",
		elements : "msg_message",
		theme : "maxlist",
		language : "it",
		plugins : "advimage,advlink,preview,searchreplace,contextmenu,paste,directionality,fullscreen",
		theme_maxlist_buttons1_add : "cut,copy,paste,pastetext,pasteword,separator,fontselect,fontsizeselect",
		theme_maxlist_buttons2_add : "separator,preview,separator,forecolor,backcolor",
		theme_maxlist_buttons2_add_before: "search,replace,separator",
		theme_maxlist_buttons3_add_before : "newdocument",
		theme_maxlist_buttons3_add : "fullscreen",
		theme_maxlist_toolbar_location : "top",
		theme_maxlist_toolbar_align : "left",
		theme_maxlist_statusbar_location : "bottom",
		paste_use_dialog : false,
		theme_maxlist_resizing : true,
		theme_maxlist_resize_horizontal : true,
		paste_auto_cleanup_on_paste : true,
		paste_convert_headers_to_strong : false,
		paste_strip_class_attributes : "all",
		paste_remove_spans : false,
		paste_remove_styles : false	
});