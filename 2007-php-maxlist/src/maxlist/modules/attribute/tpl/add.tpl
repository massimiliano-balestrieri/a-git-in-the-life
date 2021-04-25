{include file="$PATH_TPL/inc/head_view.tpl"}
<h4>{tz}add{/tz}</h4> 
<form method="post" id="form_attribute_0" action="#">
<div class="ml_panel ml_panel_1">
	{if $errors}
	{include file="$PATH_TPL/inc/error.tpl"}
	{/if}
	<table class="ml_tbl_row_small">
		<tr>
			<th scope="row"><label for="name_0">{tz}Name:{/tz}{$errors.name.img}</label></th>
			<td><input type="text" name="attribute[name]"  id="name_0" class="ml_input_medium{$errors.name.classname}" value="{if $POST.do == 'new'}{$POST.attribute.name}{/if}" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="type_0">{tz}Type:{/tz}{$errors.type.img}</label></th>
			<td>
				<select name="attribute[type]" id="type_0"  class="ml_input_medium{$errors.type.classname}">
					<option>Seleziona...</option>
				{foreach item="typev" from=$tpl_lists_types}
					<option{if $POST.do == 'new' && $POST.attribute.type == $typev} selected="selected"{/if}>{$typev}</option>				
				{/foreach}	
				</select>
			</td>
		</tr>	
		<tr>
			<th scope="row"><label for="default_0">{tz}DValue:{/tz}{$errors.default.img}</label></th>
			<td><input type="text" name="attribute[default]"  id="default_0" class="ml_input_medium{$errors.default.classname}" value="{if $POST.do == 'new'}{$POST.attribute.default}{/if}" /></td>
		</tr>	
		<tr>
			<th scope="row"><label for="listorder_0">{tz}OrderListing:{/tz}</label></th>
			<td><input type="text" name="attribute[listorder]"  id="listorder_0" value="{if $POST.do == 'new'}{$POST.attribute.listorder}{/if}" /></td>
		</tr>	
		<tr>
			<th scope="row"><label for="required_0">{tz}IsAttrRequired:{/tz}{$errors.required.img}</label></th>
			<td><input type="checkbox" name="attribute[required]"  id="required_0" /></td>
		</tr>
	</table>
	<div class="ml_container_buttons">
		<div class="ml_buttons_sx">			
		</div>
		<div class="ml_buttons_dx">			
			<input type="hidden" name="do" value="new" />
			<input type="reset" name="reset" id="reset" class="ml_button" value="{tz}reset{/tz}" />
			<input type="submit" name="confirm" id="inp_save" class="ml_button" value="{tz}save{/tz}" />
		</div>
	</div>
</div><!--contenuti -->
</form>