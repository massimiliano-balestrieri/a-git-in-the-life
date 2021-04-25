{include file="$PATH_TPL/inc/head_view.tpl"}
{include file="$PATH_TPL/inc/debug.tpl"}
<!-- adminattributes.tpl -->
{if !isset($target) || $target == "help"}
<div id="container_help">
	<h4>Help</h4> 
	
	<div class="ml_open"  id="ml_help">
	{$tpl_info}
	</div><!--contenuti -->
</div><!--container -->
{/if}


{foreach from=$tpl_lists_attributes item="attr"}
{if !isset($target) || $target == $attr.container}
<div id="container_attribute_{$attr.id}">
	<h4 class="oneByone" id="attribute_{$attr.id}">{$attr.name}</h4> 
	
	{if isset($tpl_POST.tag[$attr.id])}
	<div class="ml_panel ml_panel_1" id="ml_attribute_{$attr.id}">
	{else}
	<div class="ml_panel ml_panel_0" id="ml_attribute_{$attr.id}">
	{/if}
	<form method="post" id="form_attribute_{$attr.id}" action="#"{if $AJAX}{$tpl_ajax_form2}{$attr.id}{$tpl_ajax_form3}{/if}>
	{if isset($tpl_POST.delete[$attr.id])}
	<div class="ml_msg">
		<p>Sei sicuro di cancellare questo attributo?</p>
		<div class="ml_container_buttons">
			<div class="ml_buttons_sx">			
				<input type="submit" name="confirm" value="{$tpl_lbl_action.no}" class="ml_button" />
			</div>
			<div class="ml_buttons_dx">
				<input type="hidden" name="delete[{$attr.id}]" value="1" />
				<input type="submit" name="confirm" value="{$tpl_lbl_action.yes}" class="ml_button" />
			</div>
		</div>
	</div>
	{/if}
	<table class="ml_tbl_row_small">
		<tr>
			<th scope="row"><label for="name_{$attr.id}">{$tpl_lbl_messages.name}</label></th>
			<td><input type="text" name="name[{$attr.id}]"  id="name_{$attr.id}" class="ml_input_medium" value="{$attr.name}" /></td>
		</tr>
		<tr>
			<th scope="row">{$tpl_lbl_messages.type}</th>
			<td>
				{foreach item="typev" from=$tpl_lists_types}
					{if $typev == $attr.type}
					{$typev}
					{/if}
				{/foreach}	
			</td>
		</tr>	
		<tr>
			<th scope="row"><label for="default_{$attr.id}">{$tpl_lbl_messages.defaultvalue}</label></th>
			<td><input type="text" name="default[{$attr.id}]"  id="default_{$attr.id}" class="ml_input_medium" value="{$attr.default}" /></td>
		</tr>	
		
		<tr>
			<th scope="row"><label for="listorder_{$attr.id}">{$tpl_lbl_messages.orderoflisting}</label></th>
			<td><input type="text" name="listorder[{$attr.id}]"  id="listorder_{$attr.id}" class="ml_input_medium" value="{$attr.listorder}" /></td>
		</tr>	
		<tr>
			<th scope="row"><label for="required_{$attr.id}">{$tpl_lbl_messages.isrequired}</label></th>
			<td><input type="checkbox" name="required[{$attr.id}]"  id="required_{$attr.id}" {if $attr.required == 1}checked="checked"{/if}/></td>
		</tr>
	</table>		
		
	{if $attr.type == "select" || $attr.type == "checkboxgroup" || $attr.type == "radio" }
	<div class="ml_container_buttons">
	<a href="?view=editattributes&amp;id={$attr.id}" class="ml_button">{$tpl_lbl_action.editattributes}</a>
	</div>
	{/if}

	<div class="ml_container_buttons">
			<input type="hidden" name="tag[{$attr.id}]" value="{$attr.id}" />
			<input type="hidden" name="view" value="adminattributes" />
			<input type="submit" name="save[{$attr.id}]" id="inp_save" class="ml_button" value="{$tpl_lbl_action.savechanges}" />
			<input type="submit" name="delete[{$attr.id}]" id="pulsCancella" class="ml_button" value="{$tpl_lbl_action.delete}" />
	</div>
	
	</form>
	</div><!--contenuti -->
</div><!--container -->
{/if}
{/foreach}

{if !isset($target) || $target == "attribute_0"}
<div id="container_attribute_0">
	<h4 class="oneByone" id="attribute_0">{$tpl_lbl_messages.addnew}</h4> 
	
	<div class="ml_panel ml_panel_1" id="ml_attribute_0">
	<form method="post" id="form_attribute_0" action="#"{$tpl_ajax_form1}>
	<table class="ml_tbl_row_small">
		<tr>
			<th scope="row"><label for="name_0">{$tpl_lbl_messages.name}</label></th>
			<td><input type="text" name="name[0]"  id="name_0" class="ml_input_medium" value="" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="type_0">{$tpl_lbl_messages.type}</label></th>
			<td>
				<select name="type[0]" id="type_0"  class="ml_input_medium">
				{foreach item="typev" from=$tpl_lists_types}
					<option>{$typev}</option>				
				{/foreach}	
				</select>
			</td>
		</tr>	
		<tr>
			<th scope="row"><label for="default_0">{$tpl_lbl_messages.defaultvalue}</label></th>
			<td><input type="text" name="default[0]"  id="default_0" class="ml_input_medium" value="" /></td>
		</tr>	
		<tr>
			<th scope="row"><label for="listorder_0">{$tpl_lbl_messages.orderoflisting}</label></th>
			<td><input type="text" name="listorder[0]"  id="listorder_0" class="ml_input_medium" value="" /></td>
		</tr>	
		<tr>
			<th scope="row"><label for="required_0">{$tpl_lbl_messages.isrequired}</label></th>
			<td><input type="checkbox" name="required[0]"  id="required_0" /></td>
		</tr>
	</table>

	<div class="ml_container_buttons">
		<input type="submit" name="save" id="inp_save" class="ml_button" value="{$tpl_lbl_action.savechanges}" />
	</div>
	</form>
	</div><!--contenuti -->
</div><!--container -->
{/if}