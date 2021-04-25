{include file="$PATH_TPL/inc/head_view.tpl"}
<!-- editattributes.tpl -->
<h4>Aggiungi valori</h4> 
<form method="post" action="#">
<div class="ml_panel ml_panel_1">
    <p>Aggiungi un nuovo valore in <strong>{$tpl_data.name}</strong> ({tz}oneperline{/tz})</p>	 
	<table class="ml_tbl_row_small">
		<tr>
			<th scope="row"><label for="itemlist">Inserisci i valori</label></th>
			<td><textarea name="itemlist" id="itemlist" rows="10" cols="50"></textarea></td>
		</tr>
	</table>
	<div class="ml_container_buttons">
			<input type="hidden" name="do" value="add_items" />
			<input type="reset"  name="confirm" value="{tz}reset{/tz}" class="ml_button" />
			<input type="submit" name="confirm" value="{tz}add{/tz}" class="ml_button" />
	</div>
</div><!--container -->
</form>

{if sizeof($tpl_items)>0}
<h4>Modifica valori</h4> 
<div class="ml_panel ml_panel_1">
	{if isset($POST.action)}
	<form id="form_confirm" method="post" action="#">
	<div class="ml_msg">
		<p>Sei sicuro di cancellare l'attributo?</p>
	</div>
			<div class="ml_container_buttons">
				<div class="ml_buttons_sx">			
					<input type="submit" name="confirm" value="{tz}no{/tz}" class="ml_button" />
				</div>
				<div class="ml_buttons_dx">
					{if is_array($POST.action)}
						<input type="hidden" name="do" value="delete_item" />
						{foreach from=$POST.action key="key" item="item"}
						<input type="hidden" name="deleteitem" value="{$key}" />
						{/foreach}
					{else}
						<input type="hidden" name="do" value="delete_all_items" />
					{/if}
					<input type="submit" name="confirm" value="{tz}yes{/tz}" class="ml_button" />
				</div>
			</div>
	</form>
	{/if}
	<form method="post" action="#">
		  <p>Cambia l'ordine dei valori in <strong> {$tpl_data.name}</strong> </p>	 
		  <table class="ml_tbl_row_small">
			{foreach item="item" from=$tpl_items}
			<tr>
				<th scope="row">
				<label for="listorder_{$item.id}">{$item.name}</label>
				{if $tpl_data.default_value == $item.name}&nbsp;(default){/if}</th>
				<td>
				<input name="listorder[{$item.id}]" id="listorder_{$item.id}" value="{$item.listorder}" type="text" class="ml_small" />
				&nbsp;
				<input type="submit"  name="action[{$item.id}]"  value="{tz}delete{/tz}" class="ml_button" />
				</td>
			</tr>
			{/foreach}
		  </table>
		<div class="ml_container_buttons">
				<input type="reset"  name="reset"  value="{tz}reset{/tz}" class="ml_button" />
				<input type="submit" name="do" value="{tz}change order{/tz}" class="ml_button" />
				<input type="submit" name="action" value="{tz}delete all items{/tz}" class="ml_button" />
		</div>
	</form>
</div><!--contenuti -->
{/if}