{if !isset($target) || $target == "publicdebug"}
<div id="container_publicdebug">

	{if $AUTH.superuser == 1}
	<h4 id="debug">Messaggi amministrativi</h4>
	<div class="ml_panel ml_panel_0" id="ml_debug">
		<div class="ml_msg">
			<p style="color:red;margin:0px;font-weight:normal;line-height:10px;text-align:left;">Query : {$NQUERY}</p>
			{foreach item=err from=$ERROR}
			<p style="color:red;margin:0px;font-weight:normal;line-height:10px;text-align:left;">{$err}</p>
			{/foreach}
			{foreach item=war from=$WARN}
			<p style="color:blue;margin:0px;font-weight:normal;line-height:10px;text-align:left;">{$war}</p>
			{/foreach}
			{foreach item=query from=$QUERY}
			<p style="color:green;margin:0px;font-weight:normal;line-height:10px;text-align:left;">{$query}</p>
			{/foreach}
			{foreach item=slow from=$QUERY_SLOW}
			<p style="color:purple;margin:0px;font-weight:bold;line-height:10px;text-align:left;">{$slow}</p>
			{/foreach}
			{foreach item=qerror from=$QUERY_ERROR}
			<p style="color:red;margin:0px;font-weight:bold;line-height:10px;text-align:left;">{$qerror}</p>
			{/foreach}
		</div>
	</div><!--panel-->
	{/if}
	{if sizeof($INFO)>0}
	<h5>Messaggi</h5>
	<div class="ml_open">
		<div class="ml_msg">
			{foreach item=msg from=$INFO}
				{if $AUTH.role != 0 && $AUTH.role <= $msg.role}
				<p>{$msg.msg}</p>
				{/if}
			{/foreach}
		</div>
	</div><!--panel-->
	{/if}
	
</div><!--container-->
{/if}