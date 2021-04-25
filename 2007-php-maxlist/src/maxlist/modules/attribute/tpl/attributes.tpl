{include file="$PATH_TPL/inc/head_view.tpl"}
<h4>{tz}Attributes{/tz}</h4> 
<div class="ml_open">
	
	{if $ACTION == "delete"}
	<form id="form_confirm" method="post" action="#">
	<div class="ml_msg">
		<p>{tz}sure_delete_attribute{/tz}</p>
	</div>
			<div class="ml_container_buttons">
				<div class="ml_buttons_sx">			
					<input type="submit" name="confirm" value="{tz}no{/tz}" class="ml_button" />
				</div>
				<div class="ml_buttons_dx">
					<input type="hidden" name="do" value="delete_attribute" />
					<input type="hidden" name="delete" value="{$ID}" />
					<input type="submit" name="confirm" value="{tz}yes{/tz}" class="ml_button" />
				</div>
			</div>
	
	</form>
	{/if}
	
	<form id="form_attributes" method="post" action="#">
	{if sizeof($tpl_lists_attributes)>0}
	<table class="ml_col">
		<tr>
			<th scope="col">{tz}Name{/tz}</th>
			<th scope="col">{tz}Type{/tz}</th>
			<th scope="col">{tz}Default{/tz}</th>
			<th scope="col">{tz}Order{/tz}</th>
			<th scope="col">{tz}Required{/tz}</th>
			<th scope="col">&nbsp;</th>
		</tr>
		{foreach from=$tpl_lists_attributes item="attr"}
		<tr>
		
			<td>{$attr.name}</td>
			<td>{$attr.type}</td>
			<td>{$attr.default_value}</td>
			<td>{$attr.listorder}</td>
			<td><img src="{if $attr.required == 1}{$tpl_config.URL_IMG_YES}{else}{$tpl_config.URL_IMG_NO}{/if}" alt="" /></td>
			<td>
				<a href="{$BO}{$CONTROLLER}/edit/{$attr.id}">{tz}edit{/tz}</a>&nbsp;|&nbsp; 
				<a href="{$BO}{$CONTROLLER}/delete/{$attr.id}">{tz}delete{/tz}</a>
			    {if $attr.type == "select" || $attr.type == "checkboxgroup" || $attr.type == "radio" }
				&nbsp;|&nbsp; <a href="{$BO}{$CONTROLLER}/items/{$attr.id}">{tz}editattributes{/tz}</a>
				{/if}
			</td>
			<!-- /if -->
		</tr>
		{/foreach}
	</table>
	{/if}
	<div class="ml_container_buttons">
		<a href="{$BO}{$CONTROLLER}/create" class="ml_button">{tz}add{/tz}</a>
	</div>
	</form>
</div><!--panel-->



