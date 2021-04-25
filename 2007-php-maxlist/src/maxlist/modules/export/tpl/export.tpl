{include file="$PATH_TPL/inc/head_view.tpl"}
<!-- export.tpl -->
<form id="form_export" method="post" action="#">
<h4>{tz}export{/tz}</h4>

<div class="ml_panel ml_panel_1"> 
{if sizeof($usrmsg)>0}
<div class="ml_msg">
	{foreach item=err from=$usrmsg}
	{$err}<br /> 
	{/foreach}
</div>
{/if}
<table class="ml_tab_row_small">
<tr> 
			<th scope="row">
				<label for="gg_agg1">{tz}DateFrom{/tz}<span class="formato">(gg/mm/aaaa)</span></label>
			</th>
			<td>
				{$tpl_form_calfrom}<br />
			</td>
</tr>
<tr> 
			<th scope="row">
				<label for="gg_agg1">{tz}DateTo{/tz}<span class="formato">(gg/mm/aaaa)</span></label>
			</th>
			<td>
				{$tpl_form_calto}<br />
			</td>
</tr>

<tr>
	<th scope="row"><label for="dataUse">{tz}DateToUsed{/tz}</label></th>
	<td>
		<input type="radio" id="entered" name="column" value="entered" {$tpl_checked.column_entered}/>&nbsp;
		<span><label for="entered">{tz}WhenSignedUp{/tz}</label></span><br />
		<input type="radio" id="modified" name="column" value="modified" {$tpl_checked.column_modified}/>&nbsp;
		<span><label for="modified">{tz}WhenRecordChanged{/tz}</label></span><br />
		<input type="radio" id="listentered" name="column" value="listentered" {$tpl_checked.column_listentered}/>&nbsp;
		<span><label for="listentered">{tz}WhenSubscribed{/tz}</label></span>&nbsp;
		<select name="list" id="list"  class="ml_Med">
		{foreach item=list from=$tpl_select_lists}
		{if $REQUEST.list == $list}
		<option value="{$list.id}" selected="selected">{$list.name}</option>
		{else}
		<option value="{$list.id}">{$list.name}</option>
		{/if}
		{/foreach} 
		</select>
	</td>
</tr>
			
<tr>
	<th scope="row"><label for="Id">{tz}SelectColToIn{/tz}</label></th>
	<td>
		{foreach key=sortk item=sortv from=$tpl_checkbox_cols}
		<input type="checkbox" id="cols_{$sortk}" name="cols[]" value="{$sortk}" {$tpl_checked.$sortk}/>&nbsp;
		<span><label for="cols_{$sortk}">{$sortv}</label></span><br />
		{/foreach}
		{foreach key=sortk item=sortv from=$tpl_checkbox_attributes}
		<input type="checkbox" id="attrs_{$sortk}" name="attrs[]" value="{$sortk}" {$tpl_checked.$sortk}/>&nbsp;
		<span><label for="attrs_{$sortk}">{$sortv}</label></span><br />
		{/foreach}
	</td>
	
</tr>

</table>
	<div class="ml_container_buttons">
		<div class="ml_buttons_sx">
		</div>
		<div class="ml_buttons_dx">
			<input type="hidden" name="do" value="export" />
			<input type="submit" name="confirm" value="{tz}Exportcsv{/tz}" class="ml_button" />
		</div>
	</div>
</div><!--/contenuti-->
</form>