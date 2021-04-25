/**
 * 
 * @name TogglePanel
 * @description Create a TogglePanel from a HTML structure
 * @param Hash hash A hash of parameters
 *
 * @type jQuery
 * @cat Plugins/Interface
 * @depend jquery 1.2.1
 * @depend jquery.moreselectors
 * @author Massimiliano Balestrieri
 * @version 1.1
 *
 *
 * CHANGELOG

 * 1.1
 * removed useEffects, effect
 * 
 * forceOpenClass : possibilita di avere una classe che impedisce la chiusura all'avvio
 *                  modificato il metodo offLinksHandler. ora filtra i pannelli e poi cambia
 *                  la classe e il testo al link
 * 1.0
 * onstartHideAll : possibilità di avere tutti i pannelli chusi allo start
 * prehtmlTextLink e posthtmlTextLink : personalizzazione completa del tag link
 * speed anche senza effetti
 * openontitle (BETA) : apre il pannello che matcha l'ancora nell'url - DIPENDE DA MORESELECTORS (Contains)
*/ 

jQuery.iTogglePanel = {
	build : function(options)
	{
		return this.each(
			function(nr)
			{
				var el = this;
				if(!options){options = {};}
				options.headerSelector = options.headerSelector ||'.ui_togglepanel_handle';
				options.panelSelector = options.panelSelector ||'.ui_togglepanel_panel';
				options.onClassLink  = options.onClassLink || 'ui_togglepanel_link_on';
				options.offClassLink  = options.offClassLink || 'ui_togglepanel_link_off';
				var config = {
					id		: nr,
					headerSelector	: options.headerSelector,
					panelSelector	: options.panelSelector,
					usehover	: options.usehover || false,
					useactive	: options.useactive || false,
					hoverClass	: options.hoverClass||'ui_togglepanel_hover',
					activeClass	: options.activeClass||'ui_togglepanel_active',
					modal		: options.modal || false,
					speed		: options.speed || 0,
					uselinks	: options.uselinks || false,
					onClassLink	: options.onClassLink,
					offClassLink	: options.offClassLink,
					prehtmlTextLink	: options.prehtmlTextLink || '<a href="" onclick="return false;" class="' + options.offClassLink + '">',
					posthtmlTextLink: options.posthtmlTextLink|| '</a>',
					onTextLink	: options.onTextLink || 'show',
					offTextLink	: options.offTextLink || 'hide',
					panels 		: jQuery(options.panelSelector, this),
					headers		: jQuery(options.headerSelector, this),
					currentPanel	: options.currentPanel || 0,
					onstartHideAll  : options.onstartHideAll || false,
					openontitle	: options.openontitle || false,
					forceOpenClass	: options.forceOpenClass || false
				};
				//alert(config.panels.size());
				//alert(config.headers.size());
				if(config.uselinks){
					jQuery.iTogglePanel.addLinks(config);
				}
				if(config.modal){
					jQuery.iTogglePanel.closePanels(config);
					if(config.uselinks){
						jQuery.iTogglePanel.offLinksHandler(config);
					}
					jQuery.iTogglePanel.showPanel(config);
					jQuery.iTogglePanel.toggleClassHandler(config);
					if(config.uselinks){
						jQuery.iTogglePanel.toggleLinkHandler(config);
					}
				}else if(config.onstartHideAll){
					if(config.uselinks){
						jQuery.iTogglePanel.offLinksHandler(config);
					}
					jQuery.iTogglePanel.closePanels(config);
					//se tutto chiuso puoi aprire in base ad ancora BETA
					if(config.openontitle){
						jQuery.iTogglePanel.toggleByTitle(config);
					}
				}else{
					jQuery.iTogglePanel.toggleClassHandlers(config);
				}
				jQuery.iTogglePanel.initHandlers(config);
			}
		);
	},
	addLinks : function(params)
	{
		var handleLink = params.prehtmlTextLink+params.offTextLink+params.posthtmlTextLink;
		params.headers
		.each(
			function(){
				$(handleLink).appendTo($(this));
			}
		);
	},
	closePanels : function(params)
	{
		params.panels
		.not(params.forceOpenClass) 
		.hide()
		.end();
	},
	closeOtherPanels : function(params, nr)
	{
		params.panels
		.gt(nr)
		.hide()
		.end();

		params.panels 
		.lt(nr)
		.hide()
		.end();

	},
	showPanel : function(params, nr)
	{
		params.panels 
		.eq(nr)
		.show()
		.end();
	},
	togglePanel : function(params, nr)
	{
		params.panels 
		.eq(nr)
		.toggle(params.speed)
		.end();
	},
	getAnchor: function(){
		if(window.location.href.indexOf("#") != -1){
			var url = window.location.href;
			var uanchor = window.location.href.split("#");
			if(uanchor[1]){
				return uanchor[1];
			}
		}
		
 	},
	toggleByTitle : function(params){
	//BETA
		var myanchor = unescape(jQuery.iTogglePanel.getAnchor()).replace(/_/g, " ");
		var myanchor_id = myanchor.replace(/_/g,"_").toLowerCase();//'ui_anchor_' + 
		//alert(myanchor_id);
		params.headers
		.each(
			function(nr){
				//alert($(this).html());
				//alert($(this).filter(":Contains('"+myanchor+"')").get() != false);
				if($(this).filter(":Contains('"+myanchor+"')").get() != false){
					//alert($(this).get().focus());//.focus();
					//$("#testfocus").focus();
					
					//params.panels.eq(nr).after('<a id="'+myanchor_id+'" name="'+myanchor_id+'">&nbsp;</a>');
					params.panels.eq(nr).toggle();//senza speed se no il focus non funziona
					jQuery.iTogglePanel.toggleLinkHandler(params,nr);
					//$('#'+myanchor_id).focus();
				}
			}
		);
	//BETA	
	},
	toggleClassHandler : function(params, nr)
	{
		params.headers
		.eq(nr)
		.toggleClass(params.activeClass)
		.end();
	},
	toggleLinkHandler : function(params, nr)
	{	
		if(params.headers.eq(nr).find('.' + params.offClassLink).text() == params.offTextLink){
			params.headers
			.eq(nr)
			.find('.' + params.offClassLink)
			.removeClass(params.offClassLink)
			.addClass(params.onClassLink)
			.text(params.onTextLink);
		}else{
			params.headers
			.eq(nr)
			.find('.' + params.onClassLink)
			.removeClass(params.onClassLink)
			.addClass(params.offClassLink)
			.text(params.offTextLink);
		}
	},
	offLinksHandler : function(params)
	{	
		params.panels
		.not(params.forceOpenClass)
		.each(function(nr){
			//alert($(this).text());
			params.headers.eq(nr)
			.find('.' + params.onClassLink)
			.removeClass(params.offClassLink)
			.addClass(params.onClassLink)
			.text(params.onTextLink);
		});
	},
	toggleClassHandlers : function(params)
	{
		params.headers
		.toggleClass(params.activeClass)
		.end();
	},
	initHover : function(params)
	{
		params.headers
		.hover(
			function(){
				jQuery(this).addClass(params.hoverClass);
			},
			function(){
				jQuery(this).removeClass(params.hoverClass);
			}
		);
	},
	initHandlers : function(params)
	{
		if(params.usehover){
			jQuery.iTogglePanel.initHover(params);
		}
		
		params.headers
		.each(
			function(nr){
				this.panelPos = nr;
			}
		)
		.bind(
			'click',
			function(e){
				if(params.modal){
					jQuery.iTogglePanel.closeOtherPanels(params, this.panelPos);
				}
				jQuery.iTogglePanel.togglePanel(params, this.panelPos);
				jQuery.iTogglePanel.toggleClassHandler(params, this.panelPos);
				if(params.uselinks){
					jQuery.iTogglePanel.toggleLinkHandler(params, this.panelPos);
				}
			}
		)
		.end();
	}
};


jQuery.fn.TogglePanel = jQuery.iTogglePanel.build;