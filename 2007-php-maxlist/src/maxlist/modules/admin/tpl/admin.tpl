<!-- user.tpl -->

<h4>{tz}Edit_Administrator{/tz}</h4> 
<div class="ml_panel ml_panel_1">
{if $errors}
{include file="$PATH_TPL/inc/error.tpl"}
{/if}
		<!-- form user -->
		<table class="ml_tab_row_small">
		<tr>
			<th scope="row"><label for="admin_loginname">{tz}loginname{/tz}&nbsp;&nbsp;&nbsp;<span>*</span>{$errors.loginname.img}</label></th>
			<td><input id="admin_loginname" type="text" name="admin[loginname]" size="10" value="{$admin.loginname}" class="ml_input_medium{$errors.loginname.classname}" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="admin_email">Email&nbsp;&nbsp;&nbsp;<span>*</span>{$errors.email.img}</label></th>
			<td><input id="admin_email" type="text" name="admin[email]" size="10" value="{$admin.email}" class="ml_input_medium{$errors.email.classname}" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="admin_password">{tz}change_password{/tz}</label></th>
			<td><input id="admin_password" type="text" name="admin[password]" size="10" value="" class="ml_input_medium" /></td>
		</tr>
		<tr>
			<th scope="row">{tz}password{/tz}</th>
			<td>{$admin.password}</td>
		</tr>
		<tr>
			<th scope="row">{tz}Password_changed_desc{/tz}</th>
			<td>{$admin.password_changhed}</td>
		</tr>
		<tr>
			<th scope="row"><label for="admin_superuser">{tz}superuser{/tz}</label></th>
			<td><input id="admin_superuser" type="checkbox" name="admin[superuser]" size="10" {if $admin.superuser} checked="checked"{/if} /></td>
		</tr>
		<tr>
			<th scope="row"><label for="admin_disabled">{tz}admin_disabled{/tz}</label></th>
			<td><input id="admin_disabled" type="checkbox" name="admin[disabled]" size="10" {if $admin.disabled} checked="checked"{/if} /></td>
		</tr>
		<tr>
			<th scope="row">{tz}Time_Created{/tz}</th>
			<td>{$admin.entered}</td>
		</tr>
		<tr>
			<th scope="row">{tz}Time_modified{/tz}</th>
			<td>{$admin.modified}</td>
		</tr>
		<tr>
			<th scope="row">{tz}modifiedby{/tz}</th>
			<td>{$admin.modifiedby}</td>
		</tr>
		
		
		</table>
		<p class="ml_note">{tz}field_required{/tz}</p>
</div><!-- /panel-->
	
<h4>{tz}groups{/tz}</h4> 
<div class="ml_panel ml_panel_1">
		{if sizeof($POST) && (sizeof($groups) == 0 || sizeof($admingroups)==0 || $admin.disabled)}
		<div class="ml_msg_ko">
		{if !$groups}
		{tz}No_usergroups{/tz}
		{/if}
		{if sizeof($groupnames)==0}
		{tz}No_Groups{/tz}
		{/if}
		{if $user.disabled}
		{tz}is_disabled{/tz}
		{/if}
		</div>
		{/if}
		
		{if is_array($groups)}
		{tz}selectgroups{/tz} &nbsp; {$errors.admingroups.img}:
		<dl>		
			{foreach from=$groups item=group}
			<dt><input type="checkbox" name="admingroups[{$group.id}]" id="admingroups_{$group.id}" value="{$group.id}" {if in_array($group.id,$admingroups)} checked="checked"{/if}/>&nbsp;
			<label for="admingroups_{$group.id}">
				<span>{$group.name}</span>
			</label></dt>
			{/foreach}
		</dl>
		{/if}
</div><!--/panel-->
