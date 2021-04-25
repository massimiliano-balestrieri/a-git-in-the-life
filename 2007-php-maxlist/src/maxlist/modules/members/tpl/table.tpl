<h4>{tz}Members_of{/tz} <strong class="ml_oggetto">{$list_name}</strong></h4>
<div class="ml_panel ml_panel_1">
	
	{include file="$PATH_TPL_MOD/members/tpl/confirm.tpl"}
	
	{if sizeof($tpl_list_users)>0}
	{include file="$PATH_TPL/inc/paging.tpl"}
	<table class="ml_col">
		<tr>
			<th scope="col">&nbsp;</th>
			<th scope="col">{tz}members{/tz}</th>
			<th scope="col">{tz}confirmed{/tz}</th>
			<th scope="col">{tz}htmlemail{/tz}</th>
			<th scope="col">{tz}msgs{/tz}</th>
			{if $tpl_isWritableList}
			<th scope="col">&nbsp;</th>
			{/if}
		</tr>
		{foreach from=$tpl_list_users item=user}
		<tr>
			<td><input type="checkbox" name="user[{$user.id}]" id="user_{$user.id}" value="1" /></td>
			<td><a href="{$BO}user/edit/{$user.id}">{$user.email}</a></td>
			<td><img src="{if $user.confirmed}{$tpl_config.URL_IMG_YES}{else}{$tpl_config.URL_IMG_NO}{/if}" alt="" title=""  /></td>
			<td><img src="{if $user.htmlemail}{$tpl_config.URL_IMG_YES}{else}{$tpl_config.URL_IMG_NO}{/if}" alt="" title=""  /></td>
			<td>{$members[$user.id]}</td>
			{if $tpl_isWritableList}
			<td><a href="?{$qstring}&amp;id={$tpl_idlist}&amp;delete={$user.id}">{tz}del{/tz}</a></td>
			{/if}
		</tr>
		{/foreach}
	</table>
	{include file="$PATH_TPL/inc/paging.tpl"}
	{/if}
	{include file="$PATH_TPL_MOD/members/tpl/buttons.tpl"}
</div><!-- /panel -->