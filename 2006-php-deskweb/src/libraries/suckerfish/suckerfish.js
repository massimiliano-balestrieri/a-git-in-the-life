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
sfHover = function() {
	var sfEls = document.getElementById("desktop").getElementsByTagName("LI");
	for (var i=0; i<sfEls.length; i++) {
		sfEls[i].onmouseover=function() {
		this.className+=" sfhover";};
		sfEls[i].onmouseout=function() {
		this.className = this.className.replace(new RegExp(" sfhover\\b"), "");
		}
	}
};
addOnloadEvent(sfHover);
//if (window.attachEvent) {window.attachEvent("onload", sfHover)};
