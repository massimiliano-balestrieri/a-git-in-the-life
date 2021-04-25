//VECCHIE FUNZIONI

//facili.

//vecchia funzione ahah che utilizza tw-sack
function getContent(page,target,str_parameters){
	var ajax = new sack();
	if(!target) 
		idtarget = 'colonnaDestra';
	else
		idtarget = target
		
	if(!str_parameters) str_parameters = '';
	var url = window.location.pathname;
    ajax.setVar("ajax", 1);
    ajax.setVar("page", page);
    if(target) ajax.setVar("target", idtarget.replace("container_",""));
    var param = str_parameters.split("&");
    for(var x=0; x < param.length; x++){
    	var split_param = param[x].split("=");
   	    ajax.setVar(split_param[0], split_param[1]);
    }
    ajax.method = "POST";
	ajax.requestFile = url;
	ajax.element = idtarget;
	ajax.onLoading = onLoading;
	ajax.onLoaded = onLoaded;
    ajax.onCompletion = ajaxOnload;
    ajax.runAJAX();	
}
//inizializza i link ajax
function ajaxLink(){
	var a = document.getElementsByTagName("A");
	for(x=0;a[x];x++) {
		if(a[x].getAttribute("onclick")){
			if(a[x].href.indexOf("#")>0){
				a[x].href = a[x].href.substring(a[x].href.indexOf("#"));
			}else{
				a[x].href = "#";
			}
		}
	}
}
//funzione per eliminare il record via ajax.
function deleteRecAjax(url,idtarget,msg,output) {
	var str_parameters = url.replace("./?","");
	var lsRegExp = /\+/g;
	
	if(!idtarget){
		element = 'colonnaDestra';
		//idtarget = 'colonnaDestra';
	}else{
		element = idtarget;
		idtarget = idtarget.replace("container_","");
	}
	//alert(idtarget);
	if(msg) {
		msg = msg.replace(lsRegExp, " ");
	}else{
		msg = false;
	}
	if(!msg) msg = "Sei sicuro di cancellare questo record?";
	if (confirm(msg)) {
		if(!str_parameters) str_parameters = '';
		var url = window.location.pathname;
	    var ajax = new sack();
		ajax.setVar("output", output);
	    var param = str_parameters.split("&");
	    for(var x=0; x < param.length; x++){
	    	var split_param = param[x].split("=");
	   	    ajax.setVar(split_param[0], split_param[1]);
	    }
	    if(output){
	    	ajax.setVar('target',idtarget);
	    	ajax.setVar('ajax',1);
	    }
	    ajax.method = "GET";
		ajax.requestFile = url;
		ajax.element = element;
		ajax.onLoading = onLoading;
		ajax.onLoaded = onLoaded;
	    ajax.onCompletion = ajaxOnload;
	    ajax.runAJAX();	
	}
}

 function readParameters(element){

	//var num = document.forms[0].elements.length;
	var num = element.elements.length;
	var url = "";
	//radio button 
	var j = 0;
	var a = 0;
	var radio_buttons = new Array();
	var nome_buttons = new Array();

	//var the_form = window.document.forms[0];
	var the_form = element;
	for(var i=0; i< the_form.length; i++){
		var temp = the_form.elements[i].type;
		if ( (temp == "radio") && ( the_form.elements[i].checked) ) { 
			nome_buttons[a] = the_form.elements[i].name;
			radio_buttons[j] = the_form.elements[i].value; 
			j++; 
			a++;
		}
	}
	for(var k = 0; k < radio_buttons.length; k++) {
		url += nome_buttons[k] + "=" + radio_buttons[k] + "&";
	}
	//checkbox
	var j = 0;
	var a = 0;
	var check_buttons = new Array();
	var nome_buttons = new Array();
	
	for(var i=0; i< the_form.length; i++){
		var temp = the_form.elements[i].type;
		if ( (temp == "checkbox") && ( the_form.elements[i].checked) ) { 
			nome_buttons[a] = the_form.elements[i].name;
			check_buttons[j] = the_form.elements[i].value; 
			j++; 
			a++;
		}
	}
	for(var k = 0; k < check_buttons.length; k++) {
		url += nome_buttons[k] + "=" + check_buttons[k] + "&";
	}
	
	for (var i = 0; i < num; i++){
		var chiave = the_form.elements[i].name;
		var valore = the_form.elements[i].value;
		var tipo = the_form.elements[i].type;
		//(tipo == "submit") ||
		if (  (tipo == "radio") || (tipo == "checkbox") || (tipo == "submit") || (tipo == "button") ){}
		else {

			url += chiave + "=" + valore + "&";
		}
	}
	//alert(url);
	return url;	
/*	var parameters = url;
	url = FILE + "?" + url;
	if (METHOD == undefined) { METHOD = "GET"; 	}
	if (METHOD == "GET") { ahah(url, 'target', '', METHOD); }
	else { ahah(FILE, 'target', '', METHOD, parameters); }*/
	
}
function ajaxForm(element,page,target){
	var str_parameters = readParameters(element);
	if(str_parameters == false) return false;
	if(!target) 
		idtarget = 'colonnaDestra';
	else
		idtarget = target
	
	var ajax = new sack();
	var url = window.location.pathname;
    ajax.setVar("ajax", 1);
    if(target) ajax.setVar("target", idtarget.replace("container_",""));
    ajax.setVar("page", page);
    var param = str_parameters.split("&");

    for(var x=0; x < param.length; x++){
    	var split_param = param[x].split("=");
   	    ajax.setVar(split_param[0], split_param[1]);
    }
    ajax.method = "POST";
	ajax.requestFile = url;
	ajax.element = idtarget;
	ajax.onLoading = onLoading;
	ajax.onLoaded = onLoaded;
    ajax.onCompletion = ajaxOnload;
    ajax.runAJAX();
    return false;	
}	

//piccolo hack... per i form che inviano tramite ajax. il button all'onclick esegue totext
function submitToButton(){
	var submit = document.getElementsByTagName("INPUT");
	for(i=0;submit[i];i++) {
		if(submit[i].getAttribute("type") == "submit"){
			//alert(submit[i].form.getAttribute("id"));
	        //trasformo in button
	        submit[i].setAttribute("type","button");
	        //attacco l'onclick
	        submit[i].setAttribute("onclick","toText(this,'"+submit[i].form.getAttribute("id")+"');");
		}
	}
}
function toText(element,formid){
	var inputText;
	inputText = document.createElement("input");
	inputText.setAttribute("type","hidden");
	inputText.setAttribute("name",element.getAttribute("name"));
	inputText.setAttribute("value",element.getAttribute("value"));
	inputText.setAttribute("id","button_" + document.getElementById(formid));
	document.getElementById(formid).appendChild(inputText);
	if(document.getElementById(formid).getAttribute("onsubmit")){
		var onSubmit = document.getElementById(formid).getAttribute("onsubmit").replace("return ","");
		onSubmit = onSubmit.replace("this","document.getElementById('"+formid+"')");
		eval(onSubmit);
	}else{
		document.getElementById(formid).submit();
	}
}

//BANALI
function checkAll() {
	var cb = document.getElementsByTagName("INPUT");
    for (i=0;i<cb.length;i++) {
       if(cb[i].type == 'checkbox'){	
       		cb[i].checked = "checked";
       }
    }
}
function uncheckAll() {
	var cb = document.getElementsByTagName("INPUT");
    for (i=0;i<cb.length;i++) {
       if(cb[i].type == 'checkbox'){	
       		cb[i].checked = "";
       }
    }
}

//tinymce...
tinyMCE.init({
		mode : "exact",
		elements : "message",
		theme : "csilist",
		language : "it",
		plugins : "advimage,advlink,preview,searchreplace,contextmenu,paste,directionality,fullscreen",
		theme_csilist_buttons1_add : "cut,copy,paste,pastetext,pasteword,separator,fontselect,fontsizeselect",
		theme_csilist_buttons2_add : "separator,preview,separator,forecolor,backcolor",
		theme_csilist_buttons2_add_before: "search,replace,separator",
		theme_csilist_buttons3_add_before : "newdocument",
		theme_csilist_buttons3_add : "fullscreen",
		theme_csilist_toolbar_location : "top",
		theme_csilist_toolbar_align : "left",
		theme_csilist_statusbar_location : "bottom",
		paste_use_dialog : false,
		theme_csilist_resizing : true,
		theme_csilist_resize_horizontal : false,
		paste_auto_cleanup_on_paste : true,
		paste_convert_headers_to_strong : false,
		paste_strip_class_attributes : "all",
		paste_remove_spans : false,
		paste_remove_styles : false	
});

// VECCHIE FUNZIONI DA REIMPLEMENTARE.
// la prima legge i valori da un form. jquery.form penso faccia ampiamente meglio
// la seconda invia tramite tw-sack


//VECCHIO ONLOAD
window.onload = function(){
		noajaxLink();
		add_onClick("*","h4","cahImpl(this,'clickAndHide');");
		add_onClick("oneByone","h4","cahImpl(this,'clickAndHideAll');");		
		add_H4Link();
		myAutoHide("csilist_contenuti","div");	
		//smussa("input#a","pulsante");
		//csi
		apri_new();
		enableTooltips();
}
//AJAX
function ajaxOnload(){
		submitToButton();
		ajaxLink();
		add_onClick("*","h4","cahImpl(this,'clickAndHide');");
		add_onClick("oneByone","h4","cahImpl(this,'clickAndHideAll');");		
		myAutoHide("csilist_contenuti","div");	
		add_H4Link();
		//smussa("input#a","pulsante");
		//csi
		apri_new();
		enableTooltips();
}
window.onload = function(){
		InitLoading();
		submitToButton();
		ajaxLink();
		add_onClick("*","h4","cahImpl(this,'clickAndHide');");
		add_onClick("oneByone","h4","cahImpl(this,'clickAndHideAll');");		
		myAutoHide("csilist_contenuti","div");	
		add_H4Link();
		//smussa("input#a","pulsante");
		//csi
		apri_new();
		enableTooltips();
}