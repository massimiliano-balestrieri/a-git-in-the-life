function jq_test(){
	$(".menu_link").click(
		function(nr){
			//var href = $(this).attr("href");
			$(this).attr("href", "#");
			//come segnare nell'history?
			
			var html = $.get("admin.php",{'view' : 'eventlog'},
				function(data){
					$("#footer").html(data);
				}
			);
		}
	);
}