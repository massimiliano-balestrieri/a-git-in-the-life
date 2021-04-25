<!-- send_criteria.tpl -->
<h4  class="oneByone" id="criteriaSend">{$tpl_form_tabs.Criteria}</h4> 

<div class="ml_panel ml_panel_0" id="ml_criteriaSend">
{if $tpl_config.STACKED_ATTRIBUTE_SELECTION == 0}
{tz}criteriaexplanation{/tz}
{section name=loop start=1 loop=$tpl_config.NUMCRITERIAS}
<div class="ml_boxSend">
	<div class="ml_titolo">
	<input type="checkbox" name="use[{$smarty.section.loop.index}]" id="use_{$smarty.section.loop.index}" />&nbsp;<label for="">{tz}criterion{/tz} {$smarty.section.loop.index} ({tz}usethisone{/tz})</label> 
	</div>
	
	{foreach item=criteria from=$tpl_form_lists_criteria}
	{if $criteria.index == $smarty.section.loop.index}
	<div class="ml_content">
	{$criteria.xhtml}
	</div><!--fine div ml_content-->
	{/if}
	{/foreach}

</div><!--fine div ml_boxSend-->
{/section}
{else}
{$tpl_form_stacked_js}
<p>
<label for="criteria_match_any">{tz}matchallrules{/tz}</label><input type="radio" name="criteria_match" id="criteria_match_all" value="all" {$tpl_checked.criteria_match_all}/>
<label for="criteria_match_all">{tz}matchanyrules{/tz}</label><input type="radio" name="criteria_match" id="criteria_match_any" value="any" {$tpl_checked.criteria_match_any}/>
</p>
<table class="ml_col" summary="Lista attributi">
	<tr>
		<th scope="col">{$tpl_th_stacked.test}</th>
		<th scope="col">{$tpl_th_stacked.operators}</th>				
		<th scope="col">{$tpl_th_stacked.values}</th>
		<th scope="col">&nbsp;</th>
	</tr>
	{foreach item=attr from=$tpl_list_stacked_attrs}
	<tr>
		<td>{$attr.name}</td>
		<td>{$attr.operator}</td>
		<td>{$attr.value}</td>
		<td><a href="javascript:deleteRec('./?{$qstring}&amp;deleterule={$attr.id}');" class="ml_button">{tz}del{/tz}</a><span class="hidden">La cancellazione rimuover&agrave; solo questo utente da questa lista</span></td>
	</tr>
	{/foreach}
</table>
<div>
	<div>{$tpl_form_stacked_attrs_drop}</div>
	<div>{$tpl_form_stacked_operator_drop}</div>
	<div>{$tpl_form_stacked_values_drop}</div>
</div>
{/if}
</div><!--panel-->