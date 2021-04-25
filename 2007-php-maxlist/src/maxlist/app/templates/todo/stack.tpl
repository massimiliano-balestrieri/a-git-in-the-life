{if !isset($target) || $target == "publicdebug"}
<div id="container_publicdebug">
{if sizeof($PUBLIC_INFO)>0}
	<h4 class="open">Messaggi</h4>
	<div class="ml_open">
	<div class="ml_messaggio">
		{foreach item=msg from=$PUBLIC_INFO}
			<p>{$msg.msg}</p>
		{/foreach}
	</div>
	</div><!--panel-->
{/if}
</div><!--container-->
{/if}