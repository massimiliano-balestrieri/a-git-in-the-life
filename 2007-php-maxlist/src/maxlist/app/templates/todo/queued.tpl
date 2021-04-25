{include file="$PATH_TPL/inc/head_view.tpl"}
{include file="$PATH_TPL/inc/debug.tpl"}
<!-- messages.tpl -->
{if !isset($target) || $target == "messages"}
<div id="container_messages">
	<h4 id="drafts">{$tpl_tbl_title}</h4> 
	
	<div class="ml_panel ml_panel_1" id="ml_drafts">
	{if isset($tpl_GET.delete)}
	<form id="form_confirm" method="post" action="#">
	<div class="ml_messaggio">
		{if $tpl_GET.delete eq 'draft'}
		<p>Sei sicuro di cancellare tutti i messaggi senza oggetto?</p>		
		{else}
		<p>Sei sicuro di cancellare il messaggio?</p>
		{/if}
		<p>
		<input type="hidden" name="delete" value="{$tpl_GET.delete}" />
		<input type="submit" name="confirm" value="{$tpl_lbl_action.yes}" />
		<input type="submit" name="confirm" value="{$tpl_lbl_action.no}" />
		</p>
	</div>
	</form>
	{/if}
	{if isset($tpl_GET.resend)}
	<form id="form_confirm" method="post" action="#">
	<div class="ml_messaggio">
		<p>Sei sicuro di riaccodare il messaggio?</p>
		<p>
		<input type="hidden" name="delete" value="{$tpl_GET.delete}" />
		<input type="submit" name="confirm" value="{$tpl_lbl_action.yes}" />
		<input type="submit" name="confirm" value="{$tpl_lbl_action.no}" />
		</p>
	</div>
	</form>
	{/if}
	<form id="form_messages" method="post" action="#">
	{include file="$PATH_TPL/inc/paging.tpl"}
	<table class="ml_col" summary="informazioni messaggio">
		<tr>
			<th>&nbsp;</th>
			<th>{$tpl_th.subject} </th>
			<th>{$tpl_th.lists}</th>
		</tr>
	{foreach item=message from=$tpl_list_messages}
		<tr>
			<td><input type="radio" name="id" value="{$message.id}" /></td>
			<td><strong class="ml_oggetto">{$message.subject}</strong></td>
			<td>{$message.lists}</td>
		</tr>	
	{/foreach}
	</table>
	{include file="$PATH_TPL/inc/paging.tpl"}
	<div class="ml_container_buttons">
		<input type="hidden" name="view" value="queued" />
		<input type="submit" name="action" value="{$tpl_lbl_action.view}" class="puls" />
		<input type="submit" name="action" value="{$tpl_lbl_action.delete}" class="puls" />
		{if $login.role == 1}
		<input type="submit" name="action" value="{$tpl_lbl_action.requeue}" class="puls" />
		{/if}
		<input type="submit" name="action" value="{$tpl_lbl_action.edit}" class="puls" />
		{if $tpl_type == 'draft'}
		<input type="submit" name="action" value="{$tpl_lbl_action.deldrafts}" class="ml_p155" onmouseover="javascript:overOutHandler(this, 'ml_p155Hover');" onmouseout="javascript:overOutHandler(this, 'ml_p155');" />
		{/if}
	</div>
	</form>
	</div><!--/contenuti-->
</div><!--/container-->
{/if}