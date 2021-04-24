

/*
	Gnome theme - Menu 
*/
function displayMenu(element,id)
{
	for(x=1;x<=3;x++)
	{
		if(x!=id)document.getElementById(element+x).style.display = "none";	
	}
	if(document.getElementById(element+id).style.display == "none" || document.getElementById(element+id).style.display == ""){
		document.getElementById(element+id).style.display = "block";
	}else{
		document.getElementById(element+id).style.display = "none";
	}
	
}

/*
	Gnome theme - Menu 
*/
function hideMenu(element)
{
	for(x=1;x<=3;x++)
	{
		document.getElementById(element+x).style.display = "none";	
	}
}

/*
Dom function
*/
function dom(element,id_element){
  if(id_element != null){
  element += "_";
	element += id_element;
  }
  if(document.getElementById){
		if(!document.getElementById(element))
		{
			var e = document.getElementById('replaceme'); 
			//e.innerHTML = Elemento non trovato:"+element;
			return false;
		}
    return document.getElementById(element);
  }else if(document.all){
    return document.all(element);
  }else if(document.layers){
    return document.layers(element);
  }else{
    return alert("browser non compatibile.");
  }
}
/*
write debug
*/
function debugLog(msg){
		var e = document.getElementById('replaceme'); 
		e.innerHTML = msg;
}
/*
Colore attivo
*/

function color_active(element,elementi,tipo_tasto)
{
  //if(element != 0){
  //x=14;
  //alert(element);
  my_el = elementi.split("@");
  //alert(my_el[1]);
  num_elementi = my_el.length-1;
  for(var x=0;x<=my_el.length-1;x++)
  {
  	  //alert(my_el[x]);
  	  id = dom("window_barra_titolo",my_el[x]);
	  if(id){
		  id.style.backgroundColor="#EAE8E3";
		  id = dom("bordo_window_livello",my_el[x]);
		  id.style.border="1px solid black";
		  id.style.borderRight="1px solid #EAE8E3";
		  id.style.zIndex=x;
		  if(id.style.visibility=="hidden")
		  {
		  	id = dom("tasto_panel_nav_livello",my_el[x]);
		  	if(id)id.style.backgroundColor="#999999";
		  	
		  }else{
		  	id = dom("tasto_panel_nav_livello",my_el[x]);
		  	if(id)id.style.backgroundColor="#EAE8E3";
		  }
		  id = dom("bordo_tasto_panel_nav_livello",my_el[x]);
		  if(id)id.style.border="1px solid #999999";
		  
		  
		  id = dom("window_barra_titolo", element);
		  if(id)id.style.backgroundColor="#9999CC";
		  
		  id = dom("bordo_window_livello",element);
		  if(id){
		  id.style.border="1px solid #9999CC";
		  id.style.zIndex=num_elementi+1;
		  }
		  
		  if(tipo_tasto)
		  {
		    id.style.visibility="visible";
		    if(id.style.width=="100%")
		    {
		      id = dom("riduci_win",element);
		      if(id)id.style.visibility="visible";
		    }else{
		      id = dom("ingrandisci_win",element);
		      if(id)id.style.visibility="visible";
		    }
		  }
	  }

  }
  
  id = dom("bordo_window_livello",element);
  if(id.style.visibility=="hidden")
  {
  	id = dom("tasto_panel_nav_livello",element);
  	if(id)id.style.backgroundColor="#999999";
  }else{
  	id = dom("tasto_panel_nav_livello",element);
  	if(id)id.style.backgroundColor="#9999CC";
  }
  	id = dom("bordo_tasto_panel_nav_livello",element);
  	if(id)id.style.border="1px solid #FFFFFF";
  
  var ajax = new sack();
    
    function FAjdebug()
	{
		var ajaxDebug = new sack();
		ajaxDebug.onLoaded = whenLoaded;
		ajaxDebug.onLoading = whenLoading;
		ajaxDebug.requestFile = "http://" +  document.domain + "/ajax/debug.php";
		ajaxDebug.method = "GET";
		ajaxDebug.element = 'dmesg';
		ajaxDebug.runAJAX();
		
	}
	function doit(){
	
		ajax.setVar("z", element);
		ajax.onLoaded = whenLoaded;
		ajax.onLoading = whenLoading;
		ajax.method = "GET";
		ajax.requestFile = "http://" +  document.domain + "/ajax/session.php";
		ajax.element = 'sackdata';
		ajax.runAJAX();
	}

    doit();
    FAjdebug();
  
}
var largh_bordo_window_livello_1;
largh_bordo_window_livello_1 = 200;

/*
Richiesta ajax per l'aggiornamento dei tasti
*/

function TastiWindowAjax(element,metodo)
{
  switch(metodo)
  {
    case 'minimize':
    break;
    case 'chiudi':
    var desktop = document.getElementById("content_window");
    var num_element = dom("content_window",element);
    alert(num_element);
    desktop.removeChild(num_element);
    //var tasti = document.getElementById("tasti_panel_nav");
    //var tasto = dom("bordo_tasto_panel_nav_livello",element);
    //tasti.removeChild(tasto); 
    break;
    case 'maximize':
    break;
    case 'riduci':
    break;
  }
  
	function aggiorna_tasti()
	{
			var ajaxTasto = new sack();
			ajaxTasto.onLoaded = whenLoaded;
			ajaxTasto.onLoading = whenLoading;
			ajaxTasto.requestFile = "http://" +  document.domain + "/ajax/tasti_server.php";
			ajaxTasto.method = "GET";
			ajaxTasto.element = 'tasti_panel_nav';
			ajaxTasto.runAJAX();
	}
	
    
	function FAjdebug()
	{
		var ajaxDebug = new sack();
		ajaxDebug.requestFile = "http://" +  document.domain + "/ajax/debug.php";
		ajaxDebug.onLoaded = whenLoaded;
		ajaxDebug.onLoading = whenLoading;
		ajaxDebug.method = "GET";
		ajaxDebug.element = 'dmesg';
		ajaxDebug.runAJAX();
		
	}
	function aggiorna_sessione()
	{
		var ajax = new sack();
		ajax.setVar("remove_id", element);
		ajax.onLoaded = whenLoaded;
		ajax.onLoading = whenLoading;
		ajax.method = "GET";
		ajax.requestFile = "http://" +  document.domain + "/ajax/session.php";
		//ajax.element = 'sackdata';
		ajax.runAJAX();
	}
	aggiorna_sessione();
	aggiorna_tasti();
	FAjdebug();
}
/*
Drag e resize window
*/
function dragAndResize(DragOrResize,elementToDrag, event,top,right,bottom,left,w,h,z,idwin,desktop){
    

    element = dom("bordo_window_livello_"+elementToDrag);
    
    var x = parseInt(element.style.left);
    var y = parseInt(element.style.top);
    var w = parseInt(w);
    var h = parseInt(h);
    
    /*
    if(!parseInt(element.style.height)){
      element.style.height = h + "px";
    }
    if(!parseInt(element.style.width)){
      element.style.width = w + "px";
    }
    if(!parseInt(element.style.top)){
      element.style.top = top + "px";
    }
    if(!parseInt(element.style.left)){
      element.style.left = left + "px";
    }
	
    */
    if(!parseInt(element.style.zIndex)){
      element.style.zIndex = 0;
    }
    if(x==null){x=0}
    if(y==null){y=0}
    
    if(DragOrResize == "Drag")
    {
    	var deltaX = event.clientX - x;
    	var deltaY = event.clientY - y;
    }else{
    	var deltaX = event.clientX -w;
    	var deltaY = event.clientY -h;
    }
    
    
    if(document.addEventListener) //DOM2
    {
    	document.addEventListener("mousemove", moveHandler, true);
    	document.addEventListener("mouseup", upHandler, true);
    }else if(document.attachEvent)
    { //ie5+
    	document.attachEvent("onmousemove", moveHandler);
    	document.attachEvent("onmouseup", upHandler);
    }
    if(event.stopPropagation)event.stopPropagation();
    else event.cancelBubble = true;
    
    if(event.preventDefault) event.preventDefault();
    else event.returnValue = false;
    
    
    function moveHandler(event)
    {
      if(!event) event = window.event; //IE
      debug = true;
      
      
      if(DragOrResize == "Drag")
      {
	      distanzaX = parseInt(element.style.width.replace("px","")) + parseInt(element.style.left.replace("px","")); 
	      distanzaY = parseInt(element.style.height.replace("px","")) + parseInt(element.style.top.replace("px",""));
	      staTornandoX = (event.clientX - deltaX)<parseInt(element.style.left.replace("px",""));
	      staTornandoY = (event.clientY - deltaY)<parseInt(element.style.top.replace("px",""));
	      //sblocco
	      //alert((element.style.width));
	      if(staTornandoX ||  (screen.width - distanzaX)>=40)
	      {
	      element.style.left = (event.clientX - deltaX) + "px";
	      }
	      
	      if(staTornandoY ||  (screen.height - distanzaY)>=220)
	      {
	      element.style.top = (event.clientY - deltaY) + "px";
	      }
      }else{
      	
      	  if((event.clientX - deltaX)>250 && (event.clientY - deltaY)>250)
      	  {
      	  	element.style.width = (event.clientX - deltaX) + "px";
      	  	element.style.height = (event.clientY - deltaY) + "px";
      	  }
      }
      if(event.stopPropagation)event.stopPropagation();
      else event.cancelBubble = true;
    
    }
    
    function upHandler(event){
      if(!event) event = window.event; //IE
      
      if(document.removeEventListener)
      {
      document.removeEventListener("mouseup", upHandler, true);
      document.removeEventListener("mousemove", moveHandler, true);
      }
      else if(document.detachEvent)
      {
      document.detachEvent("onmouseup", upHandler);
      document.detachEvent("onmousemove", moveHandler);
      }
      
      if(event.stopPropagation)event.stopPropagation();
      else event.cancelBubble = true;
      
      doit();      
      FAjdebug();
    }
    
    
    
	function FAjdebug()
	{
		var ajaxDebug = new sack();
		ajaxDebug.requestFile = "http://" +  document.domain + "/ajax/debug.php";
		ajaxDebug.method = "GET";
		ajaxDebug.onLoaded = whenLoaded;
		ajaxDebug.onLoading = whenLoading;
		ajaxDebug.element = 'dmesg';
		ajaxDebug.runAJAX();
		
	}
	function doit(){
		//debug
		//?desktop=1&win_id=4&ajax=1&action=REGISTER_WIN&win_top=100&win_left=300&win_width=500&win_height=400&win_z=2&debug=1
		var ajax = new sack();
		ajax.setVar("win_top", element.style.top);
		ajax.setVar("win_left", element.style.left);
		ajax.setVar("win_width", element.style.width);
		ajax.setVar("win_height", element.style.height);
		ajax.setVar("win_z", element.style.zIndex);
		ajax.setVar("win_id", idwin);
		ajax.setVar("desktop", desktop);
		ajax.setVar("ajax", 1);
		ajax.setVar("action", 'REGISTER_WIN');
		ajax.onLoaded = whenLoaded;
		ajax.onLoading = whenLoading;
		ajax.method = "GET";
		ajax.requestFile = "http://" +  document.domain + "/ajax/session.php";
		//ajax.element = 'replaceme';
		ajax.runAJAX();
	}
	
}
/**
request window by ajax
*/

function WindowAjax(id)
{
	
	var idmenu = id;
	function debug()
	{
		var ajaxDebug = new sack();
		ajaxDebug.requestFile = "http://" +  document.domain + "/ajax/debug.php";
		ajaxDebug.method = "GET";
		ajaxDebug.element = 'dmesg';
		ajaxDebug.runAJAX();
		
	}
	function whenCompleted(){
		if(navigator.appName.indexOf("Microsoft") != -1) sfHover();
	}

	function get_window(id)
	{
		if(document.getElementById("content_window_"+id))
		{
			
		}else{
			var ajax = new sack();
			var e = document.getElementById('content_window');
			var newElem =document.createElement("div"); 
			newElem.id = "content_window_" + id ;
			e.appendChild(newElem);
			ajax.setVar("id", id);
			ajax.setVar("ajax",1); // recomended method of setting data to be parsed.
			ajax.requestFile = "http://" +  document.domain + "/ajax/window_server.php";
			ajax.method = "GET";
			ajax.element = 'content_window_'+ id;
			ajax.onLoaded = whenLoaded;
			ajax.onLoading = whenLoading;
			ajax.onCompletion = whenCompleted;
			ajax.runAJAX();
		}
	}
	
	function get_tasto(id)
	{
		element = "bordo_tasto_panel_nav_livello";
		if(!document.getElementById('bordo_tasto_panel_nav_livello_'+id))
		{
			var ajaxTasto = new sack();
			ajaxTasto.onLoaded = whenLoaded;
			ajaxTasto.onLoading = whenLoading;
			ajaxTasto.setVar("id", id); 
			ajaxTasto.requestFile = "http://" + document.domain + "/ajax/tasti_server.php";
			ajaxTasto.method = "GET";
			ajaxTasto.element = 'tasti_panel_nav';
			ajaxTasto.runAJAX();
					
		}
	}
	
	get_window(id);
	get_tasto(id);
	debug();

}
function whenLoaded()
{
	if(dom("loading")) dom("loading").style.display = "inline";
	if(dom("loaded")) dom("loaded").style.display = "none";
}
function whenLoading()
{
	if(dom("loading")) dom("loading").style.display = "none";
	if(dom("loaded")) dom("loaded").style.display = "inline";
}
	