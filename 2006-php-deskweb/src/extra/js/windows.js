function addOnloadEvent(fnc){
  if ( typeof window.addEventListener != "undefined" )
    window.addEventListener( "load", fnc, false );
  else if ( typeof window.attachEvent != "undefined" ) {
    window.attachEvent( "onload", fnc );
  }
  else {
    if ( window.onload != null ) {
      var oldOnload = window.onload;
      window.onload = function ( e ) {
        oldOnload( e );
        window[fnc]();
      };
    }
    else
      window.onload = fnc;
  }
}
var fen = new Array();
windowsLoad = function() {
		
		var windows = document.getElementById("desktop").getElementsByTagName("div");
		for (var i=0; i<windows.length; i++) {
			if(windows[i].className == "bordo_window_1"){				
				id= windows[i].id.substring(21);
				var left = windows[i].style.left;
				var top = windows[i].style.top;
				fen[id] = new xFenster('bordo_window_livello_'+id, left, top, 'window_barra_titolo_'+id, 'fenResBtn'+id, 'ingrandisci_win_'+id);
			}
		}
}

addOnloadEvent(windowsLoad);
/*
var fen = new Array(), fen_count = 3;
window.onload = function()
{
  for (var i = 1; i <= fen_count; ++i) {
    fen[i] = new xFenster('fen'+i, i*100, i*100, 'fenBar'+i, 'fenResBtn'+i, 'fenMaxBtn'+i);
  }
}
window.onunload = function()
{
  for (var i = 1; i <= fen_count; ++i) {
    fen[i].onunload();
  }
}
*/
// object-oriented version - see drag1.php for a procedural version

function xFenster(eleId, iniX, iniY, barId, resBtnId, maxBtnId) // object prototype
{
  // Private Properties
  var me = this;
  var ele = xGetElementById(eleId);
  var rBtn = xGetElementById(resBtnId);
  var mBtn = xGetElementById(maxBtnId);
  var x, y, w, h, maximized = false;
  // Public Methods
  this.onunload = function()
  {
    if (xIE4Up) { // clear cir refs
      xDisableDrag(barId);
      xDisableDrag(rBtn);
      mBtn.onclick = ele.onmousedown = null;
      me = ele = rBtn = mBtn = null;
    }
  }
  this.paint = function()
  {
    xMoveTo(rBtn, xWidth(ele) - xWidth(rBtn), xHeight(ele) - xHeight(rBtn));
    xMoveTo(mBtn, xWidth(ele) - xWidth(rBtn), 0);
  }
  // Private Event Listeners
  function barOnDrag(e, mdx, mdy)
  {
    xMoveTo(ele, xLeft(ele) + mdx, xTop(ele) + mdy);
  }
  function resOnDrag(e, mdx, mdy)
  {
    xResizeTo(ele, xWidth(ele) + mdx, xHeight(ele) + mdy);
    me.paint();
  }
  function fenOnMousedown()
  {
    xZIndex(ele, xFenster.z++);
  }
  function maxOnClick()
  {
    if (maximized) {
      maximized = false;
      xResizeTo(ele, w, h);
      xMoveTo(ele, x, y);
    }
    else {
      w = xWidth(ele);
      h = xHeight(ele);
      x = xLeft(ele);
      y = xTop(ele);
      xMoveTo(ele, xScrollLeft(), xScrollTop());
      maximized = true;
      xResizeTo(ele, xClientWidth(), xClientHeight());
    }
    me.paint();
  }
  // Constructor Code
  xFenster.z++;
  xMoveTo(ele, iniX, iniY);
  this.paint();
  xEnableDrag(barId, null, barOnDrag, null);
  xEnableDrag(rBtn, null, resOnDrag, null);
  mBtn.onclick = maxOnClick;
  ele.onmousedown = fenOnMousedown;
  xShow(ele);
} // end xFenster object prototype

xFenster.z = 0; // xFenster static property
