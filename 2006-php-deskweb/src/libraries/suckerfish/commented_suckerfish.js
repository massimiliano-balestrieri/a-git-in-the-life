sfHover = function() {
		var sfEls = document.getElementById("desktop").getElementsByTagName("LI");
		var tmp;
		for (var i=0; i<sfEls.length; i++) {
			sfEls[i].onmouseover=function() {
				tmp = this.className;
				this.className+=" sfhover";
			}
			sfEls[i].onmouseout=function() {
				//this.className = tmp;
				this.className = this.className.replace(new RegExp(" sfhover\\b"), "");
			}
		}
}
if (window.attachEvent) window.attachEvent("onload", sfHover);