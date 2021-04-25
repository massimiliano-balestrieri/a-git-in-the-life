{include file="$PATH_TPL/inc/head_view.tpl"}
<h4>{tz}attributes{/tz}</h4> 
<div class="ml_panel ml_panel_1">
	{if $errors}
	{include file="$PATH_TPL/inc/error.tpl"}
	{/if}
	<form method="post" id="form_attribute" action="#">
	<table class="ml_tbl_row_small">
		<tr>
			<th scope="row"><label for="name_{$attr.id}">{tz}Name{/tz}{$errors.name.img}</label></th>
			<td><input type="text" name="attribute[name]"  id="name_{$attr.id}" class="ml_input_medium{$errors.name.classname}" value="{$attr.name}" /></td>
		</tr>
		<tr>
			<th scope="row">{tz}Type{/tz}</th>
			<td>
				{foreach item="typev" from=$tpl_lists_types}
					{if $typev == $attr.type}
					{$typev}
					{/if}
				{/foreach}	
			</td>
		</tr>	
		<tr>
			<th scope="row"><label for="default_{$attr.id}">{tz}DValue{/tz}{$errors.default.img}</label></th>
			<td><input type="text" name="attribute[default]"  id="default_{$attr.id}" class="ml_input_medium{$errors.default.classname}" value="{$attr.default_value}" /></td>
		</tr>	
		
		<tr>
			<th scope="row"><label for="listorder_{$attr.id}">{tz}OrderListing{/tz}</label></th>
			<td><input type="text" name="attribute[listorder]"  id="listorder_{$attr.id}" class="ml_input_medium" value="{$attr.listorder}" /></td>
		</tr>	
		<tr>
			<th scope="row"><label for="required_{$attr.id}">{tz}IsAttrRequired{/tz}{$errors.required.img}</label></th>
			<td><input type="checkbox" name="attribute[required]"  id="required_{$attr.id}" {if $attr.required == 1}checked="checked"{/if}/></td>
		</tr>	
	</table>
	{if $attr.type == "select" || $attr.type == "checkboxgroup" || $attr.type == "radio" }
	<div class="ml_container_buttons">
			<a href="{$BO}{$ENTITY}/items/{$attr.id}" class="ml_button">{tz}editattributes{/tz}</a>
	</div>
	{/if}

	<div class="ml_container_buttons">
		<div class="ml_buttons_sx">			
		</div>
		<div class="ml_buttons_dx">			
			<input type="hidden" name="do" value="update" />
			<input type="hidden" name="attribute[id]" value="{$attr.id}" />
			<input type="submit" name="confirm" class="ml_button" value="{tz}save{/tz}" />
			<input type="submit" name="confirm" id="confirm_and" class="ml_button" value="{tz}save_and{/tz}" />
		</div>
	</div>
	</form>
</div><!--panel-->