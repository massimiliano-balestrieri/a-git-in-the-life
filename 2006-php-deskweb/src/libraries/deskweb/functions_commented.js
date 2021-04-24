function dom(element,id_element){
  if(id_element != null){
  element += "_";
	element += id_element;
  }
  if(document.getElementById){
		if(!document.getElementById(element))alert("Elemento non trovato:"+element);
    return document.getElementById(element);
  }else if(document.all){
    return document.all(element);
  }else if(document.layers){
    return document.layers(element);
  }else{
    return alert("browser non compatibile.");
  }
}
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
	  id.style.backgroundColor="#EAE8E3";
	  id = dom("bordo_window_livello",my_el[x]);
	  id.style.border="1px solid black";
	  id.style.borderRight="1px solid #EAE8E3";
	  id.style.zIndex=x;
	  if(id.style.visibility=="hidden")
	  {
	  id = dom("tasto_panel_nav_livello",my_el[x]);
	  id.style.backgroundColor="#999999";
	  }else{
	  id = dom("tasto_panel_nav_livello",my_el[x]);
	  id.style.backgroundColor="#EAE8E3";
	  }
	  id = dom("bordo_tasto_panel_nav_livello",my_el[x]);
	  id.style.border="1px solid #999999";
	  
	  
	  id = dom("window_barra_titolo", element);
	  id.style.backgroundColor="#9999CC";
	  id = dom("bordo_window_livello",element);
	  id.style.border="1px solid #9999CC";
	  id.style.zIndex=num_elementi+1;
	  if(tipo_tasto)
	  {
	    id.style.visibility="visible";
	    if(id.style.width=="100%")
	    {
	      id = dom("riduci_win",element);
	      id.style.visibility="visible";
	    }else{
	      id = dom("ingrandisci_win",element);
	      id.style.visibility="visible";
	    }
	  }

  }
  
  id = dom("bordo_window_livello",element);
  if(id.style.visibility=="hidden")
  {
  id = dom("tasto_panel_nav_livello",element);
  id.style.backgroundColor="#999999";
  }else{
  id = dom("tasto_panel_nav_livello",element);
  id.style.backgroundColor="#9999CC";
  }
  id = dom("bordo_tasto_panel_nav_livello",element);
  id.style.border="1px solid #FFFFFF";
  
}
var largh_bordo_window_livello_1;
largh_bordo_window_livello_1 = 200;
    

function settaWin(element,metodo)
{
  switch(metodo){
    case 'minimize':
    num_element = document.getElementById("tasto_panel_nav_livello_"+element);
    num_element.style.backgroundColor="#999999";
    num_element = document.getElementById("bordo_window_livello_"+element);
    num_element.style.visibility="hidden";
    if(num_element.style.width=="100%"){
      document.getElementById("riduci_win_"+element).style.visibility="hidden";
    }else{
      document.getElementById("ingrandisci_win_"+element).style.visibility="hidden";
    }
    break;
    case 'close':
    num_element = document.getElementById("bordo_tasto_panel_nav_livello_"+element);
    num_element.style.width="0px";
    num_element.style.visibility="hidden";
    num_element = document.getElementById("bordo_window_livello_"+element);
    num_element.style.visibility="hidden";
    num_element = document.getElementById("ingrandisci_win_"+element);
    num_element.style.visibility = "hidden";
    num_element = document.getElementById("riduci_win_"+element);
    num_element.style.visibility = "hidden";

    break;
    case 'maximize':
    num_element = document.getElementById("tasto_panel_nav_livello_"+element);
    num_element.style.backgroundColor="#9999cc";
    num_element = document.getElementById("bordo_window_livello_"+element);
    num_element.style.width="100%";
    num_element.style.height="100%";
    num_element.style.top = "0px";
    num_element.style.left = "0px";
    num_element = document.getElementById("ingrandisci_win_"+element);
    num_element.style.visibility = "hidden";
    num_element = document.getElementById("riduci_win_"+element);
    num_element.style.visibility = "visible";
    break;
    case 'riduci':
    num_element = document.getElementById("tasto_panel_nav_livello_"+element);
    num_element.style.backgroundColor="#9999cc";
    num_element = document.getElementById("bordo_window_livello_"+element);
    num_element.style.width="";
    num_element.style.height="";
    num_element.style.top = "";
    num_element.style.left = "";
    num_element = document.getElementById("ingrandisci_win_"+element);
    num_element.style.visibility = "visible";
    num_element = document.getElementById("riduci_win_"+element);
    num_element.style.visibility = "hidden";
    break;
  }
}
function dragAndResize(DragOrResize,elementToDrag, event,top,right,bottom,left,w,h,idwin){
    
    element = dom("bordo_window_livello_"+elementToDrag);
    
    var x = parseInt(element.style.left);
    var y = parseInt(element.style.top);
    var w = parseInt(w);
    var h = parseInt(h);
    
    if(!parseInt(element.style.height)){
      element.style.height = h + "px";//400 + "px";
      //h = 400;
    }
    if(!parseInt(element.style.width)){
      element.style.width = w + "px";//379 + "px";
      //w = 379;
    }
    if(!parseInt(element.style.top)){
      element.style.top = top + "px";//0 + "px";
      //y = 0;
    }
    if(!parseInt(element.style.left)){
      element.style.left = left + "px";//0 + "px";
      //x = 0;
    }

    if(parseInt(element.style.bottom)>0){
      element.style.bottom = null;
      element.style.top = top + "px";//270 + "px";
      //y = 270;
    }
    if(parseInt(element.style.right)>0){
      element.style.right = null;
      element.style.left = left + "px";//400 + "px";
      //x = 400;
    }

	

    
    
    if(x==null){x=0}
    if(y==null){y=0}
    
    if(DragOrResize == "Drag")
    {
    	var deltaX = event.clientX -x;
    	var deltaY = event.clientY -y;
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
    }
    
    var ajax = new sack();
    
	
	function doit(){
	
		ajax.setVar("win_top", element.style.top);
		ajax.setVar("win_left", element.style.left);
		ajax.setVar("win_width", element.style.width);
		ajax.setVar("win_height", element.style.height);
		ajax.setVar("win_id", idwin);
		ajax.method = "GET";
		ajax.requestFile = "server.php";
		ajax.element = 'sackdata';
		ajax.runAJAX();
	}
	
}