{include file="$PATH_TPL/inc/head_view.tpl"}
<!-- bounces.tpl -->

{if sizeof($tpl_list_bounces)>0}
<h4>{tz}Bounces{/tz}</h4> 
<div class="ml_panel ml_panel_1" id="ml_bounces">
	
	{include file="$PATH_TPL/inc/paging.tpl"}
	<table class="ml_col" summary="Utenti effetivamenti presenti nella lista">
		<tr>
			<th scope="col">&nbsp;</th>
			<th scope="col">{tz}email{/tz}</th>
			<th scope="col">{tz}message{/tz}</th>
			<th scope="col">{tz}date{/tz}</th>
		</tr>
		{foreach item=bounce from=$tpl_list_bounces}
		<tr>
			<td><a href="{$BO}bounce/view/{$bounce.id}" class="ml_button">{tz}show{/tz}</a></td>
			{if $bounce.userid == 'unk'}
			<td>{tz}unknown{/tz}</td>
			{else}
			<td><a href="{$BO}user/edit/{$bounce.userid}" title="dettaglio utente">{$bounce.username}</a></td>
			{/if}
			{if $bounce.messageid == 'sys'}
			<td>{tz}system{/tz}</td>
			{/if}
			{if $bounce.messageid == 'unk'}
			<td>{tz}unknown{/tz}</td>
			{/if}
			{if $bounce.messageid != 'sys' && $bounce.messageid != 'unk'}
			<td><a href="{$BO}message/view/{$bounce.messageid}" title="dettaglio messaggio">{$bounce.messagesubject}</a></td>
			{/if}
			<td>{$bounce.date}</td>
		</tr>
		{/foreach}
	</table>
	{include file="$PATH_TPL/inc/paging.tpl"}
</div><!--/panel-->
{/if}