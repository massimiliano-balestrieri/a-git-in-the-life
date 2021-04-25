jQuery.iMaxlist_AjaxBatch = {
	
	build : function(options)
	{
		return this.each(
			function(nr)
			{
				$(this)
				.submit(
					function(){
						$.post('/maxlist/default/process/queue',{'do' : 'batch', 'confirm' : 'conferma'}, function(data){
							$('.wrap_debug',this).show(100);
							$('.debug',this).html(data);
						});//TODO:
						return false;
					}

				);
			}
		);
	}
}
jQuery.fn.Maxlist_AjaxBatch = jQuery.iMaxlist_AjaxBatch.build;

jQuery.iMaxlist_BatchTests = {
	
	id : false,
	reload : 0,
	lastsend : 0,
	
	build : function(options)
	{
		return this.each(
			function(nr)
			{
				jQuery.iMaxlist_BatchTests.set_reload();
				jQuery.iMaxlist_BatchTests.id = this;
				$(this).submit(function(){return false;});
				jQuery.iMaxlist_BatchTests.init_submits();
			}
		);
	},
	set_reload : function(){
		jQuery.iMaxlist_BatchTests.reload++;
		//$('#reload').text(jQuery.iMaxlist_BatchTests.reload);
	},
	init_submits : function(){
		$(":submit",jQuery.iMaxlist_BatchTests.id).click(function(){
			var action = $(this).val();
			//alert(action);
			jQuery.iMaxlist_BatchTests.set_reload();
			$.post('/maxlist/default/process/ajaxbatch',{'do' : action, 'confirm' : 'conferma'}, function(data){
					$('.debug',this).html(data);
			});//TODO:
		});
	}
}
jQuery.fn.Maxlist_BatchTests = jQuery.iMaxlist_BatchTests.build;