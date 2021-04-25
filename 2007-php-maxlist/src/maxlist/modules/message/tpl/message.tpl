{include file="$PATH_TPL/inc/head_view.tpl"}
<!-- message.tpl -->
<h4>{tz}resend{/tz}</h4> 
<div class="ml_panel ml_panel_0">
{if is_array($tpl_resend)}
	<dl>
		
		{foreach from=$tpl_resend key="listk" item="listv"}
		<dt><input type="checkbox" name="list[{$listk}]" id="list_{$listk}" />&nbsp;<label for="list_{$listk}">{$listv}</label></dt>
		{/foreach}
		
	</dl>
	<div class="ml_container_buttons">
		<div class="ml_buttons_sx">
			<input type="submit" name="resend" value="{tz}resend{/tz}" class="ml_button" />
		</div>
	</div>
{else}
	<p>{$tpl_lbl_messages.alllist}</p>
{/if}
</div><!--/panel-->

<h4>{tz}message{/tz}</h4> 
<div class="ml_panel ml_panel_1">
	<table class="ml_tbl_row_small">
		{foreach from=$tpl_msg item="msgv" key="msgk"}
		<tr>
			<th scope="row">{$msgk}</th>
			<td>{$msgv}</td>
		</tr>
		{/foreach}
	</table>
	{if $tpl_config.ALLOW_ATTACHMENTS}
	{if is_array($tpl_attach)}
	<table class="ml_col"><tr><th class="intesta">{$tpl_lbl_messages.attach}</th></tr></table>
	<table class="ml_col" summary="">
			<tr>
				<th scope="row">{$tpl_lbl_messages.filename}</th>
				<th scope="row">{$tpl_lbl_messages.size}</th>
				<th scope="row">{$tpl_lbl_messages.mime}</th>
				<th scope="row">{$tpl_lbl_messages.desc}</th>
			</tr>
	{foreach from=$tpl_attach item="attach"}
			<tr>
				<td>{$attach.remotefile}</td>
				<td>{$attach.size}</td>
				<td>{$attach.mimetype}</td>
				<td>{$attach.description}</td>
			</tr>
	{/foreach}
	</table>		
	{else}
	<table class="ml_col"><tr><th class="intesta">{tz}attach{/tz}</th></tr></table>
	<p>{tz}noattach{/tz}</p>
	{/if}
	{/if}
		<table class="ml_col"><tr><th class="intesta">{tz}listsend{/tz}</th></tr></table>
	{if sizeof($tpl_listdone)>0}
	<ul>		
			{foreach from=$tpl_listdone key="listdonek" item="listdonev"}
			<li>{$listdonek} - {$listdonev} </li>
			{/foreach}
	</ul>
	{else}
	<p>{tz}nosend{/tz}</p>
	{/if}
	<form method="post" action="#">
	<div class="ml_container_buttons">
		{if $tpl_msg.stato == 'draft'}
		<div class="ml_buttons_dx">
			<input type="hidden" name="id" value="{$tpl_ID}" />
			<input type="submit" name="edit" value="modifica" class="ml_button" />
		</div>
		{/if}
		<div class="ml_buttons_sx">
				<input type="submit" name="back" value="indietro" class="ml_button" />
		</div>
	</div>
	</form>
</div><!-- /panel-->