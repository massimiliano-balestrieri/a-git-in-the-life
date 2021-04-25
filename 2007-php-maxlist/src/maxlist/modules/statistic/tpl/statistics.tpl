{include file="$PATH_TPL/inc/head_view.tpl"}
<!-- messages.tpl -->
{if sizeof($tpl_list_messages)>0}
<h4 id="statistics">{tz}Statistics{/tz}</h4> 
<div class="ml_panel ml_panel_1" id="ml_statistics">
	{include file="$PATH_TPL/inc/paging.tpl"}
	{foreach item=message from=$tpl_list_messages}
	<table class="ml_col" summary="informazioni messaggio">
		<tr>
			<th colspan="2">{tz}subject{/tz} 
			<strong><a href="{$BO}message/view/{$message.id}">{$message.subject}</a></strong></th>
		</tr>
		<tr>
			<th>{tz}from{/tz}</th>
			<th>{$I18N[$message.status]}</th>
		</tr>
		<tr>
			<td>{$message.fromfield}</td>
			<td>{$message.sent}</td>
		</tr>	
	</table>
	{if $message.sent}
	<table class="ml_col">
			<tr>
				<th>{tz}total{/tz}</th>
				<th>{tz}text{/tz}</th>
				<th>{tz}html{/tz}</th>
				<th>{tz}both{/tz}</th>
				<th>{tz}viewed{/tz}</th>
				<th>{tz}unique{/tz}</th>
				<th>{tz}bounced{/tz}</th>
			</tr>
			<tr>
				<td>{$message.processed}</td>
				<td>{$message.astext}</td>
				<td>{$message.ashtml}</td>
				<td>{$message.astextandhtml}</td>
				<td>{$message.viewed}</td>
				<td>{$message.unique}</td>
				<td>{$message.bounced}</td>
			</tr>	
	</table><br />
	{/if}
	{/foreach}
	{include file="$PATH_TPL/inc/paging.tpl"}
</div><!--/panel-->
{/if}