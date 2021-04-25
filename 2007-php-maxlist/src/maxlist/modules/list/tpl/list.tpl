{include file="$PATH_TPL/inc/head_view.tpl"}
<!-- list.tpl -->
<h4>{tz}list{/tz}</h4> 
<div class="ml_panel ml_panel_1">
{if $errors}
{include file="$PATH_TPL/inc/error.tpl"}
{/if}
<form id="form_list" method="post" action="#">
<table class="ml_tbl_row_med">
	<tr>
		<th scope="row"><label for="list_name">{tz}list_name{/tz}{$errors.name.img}</label> *</th>
		<td><input type="text" name="list[name]"  id="list_name" class="ml_input_medium{$errors.name.classname}" value="{$tpl_list.name}" /></td>
	</tr>
	<!--if $tpl_list.visowner-->
	<tr>
		<th scope="row"><label for="list_owner">{tz}Owner{/tz}</label></th>
		<td>
			<select name="list[owner]" id="list_owner" class="ml_input_medium">
			{foreach from=$tpl_admins item="admin" key="id_admin"}
			{if $id_admin == $tpl_list.owner}
			<option value="{$id_admin}" selected="selected">{$admin}</option>
			{else}
			<option value="{$id_admin}">{$admin}</option>			
			{/if}
			{/foreach}
			</select>
		</td>
	</tr>
	<!--else-->
	<!--<tr>
		<td colspan="0"><input type="hidden" name="list[owner]" value="{$tpl_admin_id}" /></td>
	</tr>-->
	<!--/if-->
	<tr>
		<th scope="row"><label for="list_active">{tz}Active{/tz}</label></th>
		<td><input type="checkbox" name="list[active]" id="list_active" {$checked.active} /></td>
	</tr>
	<tr>
		<th scope="row"><label for="list_description">{tz}List description{/tz}{$errors.description.img}</label> *</th>
		<td><textarea cols="33" rows="10" id="list_description" name="list[description]" class="ml_area {$errors.description.classname}">{$tpl_list.description}</textarea></td>
	</tr>
	{if $ID}
	<tr>
		<th scope="row">{tz}Users count{/tz}</th>
		<td>{$tpl_list.count}</td>
	</tr>
	{/if}
	</table>
	<p class="ml_note">{tz}Fields required{/tz}</p>
	{if $ID}
	<div class="ml_container_buttons">
		<a href="{$BO}members/{$ID}" class="ml_button">{tz}Members list{/tz}</a>
		<input type="reset" name="{tz}reset{/tz}" id="{tz}reset{/tz}" class="ml_button" value="{tz}reset{/tz}" />
	</div>
	{/if}
	<div class="ml_container_buttons">
		<div class="ml_buttons_sx">
			<a href="{$BO}list" class="ml_button">{tz}back{/tz}</a>
		</div>
	
		<div class="ml_buttons_dx">
			<input type="hidden" name="do" class="ml_button" value="{$DO}" />
			<input type="submit" name="confirm" id="confirm" class="ml_button" value="{tz}save{/tz}" />
			<input type="submit" name="confirm" id="confirm_and" class="ml_button" value="{tz}save_and{/tz}" />
		</div>
	</div>
</form>
</div><!--panel-->