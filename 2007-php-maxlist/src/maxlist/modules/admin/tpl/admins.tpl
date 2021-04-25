{include file="$PATH_TPL/inc/head_view.tpl"}
{if sizeof($tpl_list_admins)>0 || isset($REQUEST.filter)}
{include file="$PATH_TPL/inc/simple_search.tpl"}
{/if}

{if sizeof($tpl_list_admins)>0}
<h4>{tz}Administrators{/tz}</h4>
<div class="ml_panel ml_panel_1">
	{if $ACTION == "delete"}
	<form id="form_confirm" method="post" action="#">
	<div class="ml_msg">
		<p>{tz}delete_records{/tz}</p>
	</div>

		<div class="ml_container_buttons">
			<div class="ml_buttons_sx">			
				<input type="submit" name="confirm" value="{tz}no{/tz}" class="ml_button" />
			</div>
			<div class="ml_buttons_dx">
				<input type="hidden" name="id" value="{$GET.id}" />
							<input type="hidden" name="action" value="delete" />
							<input type="hidden" name="delete" value="{$ID}" />
				<input type="submit" name="confirm" value="{tz}yes{/tz}" class="ml_button" />
			</div>
		</div>
	</form>
	{/if}
	{include file="$PATH_TPL/inc/paging.tpl"}
	<table class="ml_col">
		<tr>
			<th scope="col">{tz}Administrators{/tz}</th>
			<th scope="col">&nbsp;</th>
		</tr>
		{foreach item=admin from=$tpl_list_admins}
		<tr>
			<td><a href="{$BO}{$CONTROLLER}/edit/{$admin.id}">{$admin.loginname}</a></td>
			<td><a href="{$BO}{$CONTROLLER}/delete/{$admin.id}">{tz}delete{/tz}</a></td>
		</tr>
		{/foreach}	
	</table>
	{include file="$PATH_TPL/inc/paging.tpl"}
	<div class="ml_container_buttons">
		<a href="{$BO}{$CONTROLLER}/create" class="ml_button">{tz}add{/tz}</a>
		{if $login.role == 1}
		<a href="{$BO}{$CONTROLLER}/importadmin" class="ml_button">{tz}import{/tz}</a>
		{/if}
	</div>
</div><!-- panel -->
{/if}