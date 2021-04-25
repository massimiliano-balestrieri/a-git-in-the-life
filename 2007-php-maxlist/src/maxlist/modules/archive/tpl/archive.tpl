{include file="$PATH_TPL/inc/head_fo.tpl"}
<!-- archive.tpl -->
<h4>Archivio Newsletter</h4> 
	
	
<div class="ml_panel ml_panel_1">
	<p>Visualizza l'archivio delle newsletter precedenti</p>
	{if sizeof($tpl_messages)>0}
	<ul>
	{foreach item="message" from=$tpl_messages}
		<li><a class="apri" href="{$BO}view/message/{$message.id}">{$message.subject}</a>  - {$message.sent|date_format:"%d/%m/%Y"}</li>
	{/foreach}
	</ul>
	{else}
	<p>Non sono presenti messaggi in archivio</p>
	{/if}
</div>
