<!--if $login.role < 4-->
<!-- send_lists.tpl -->
<h4>{tz}lists{/tz}</h4> 

<div class="ml_panel ml_panel_1">
{if sizeof($lists)==0}
<p>Non sono presenti categorie a cui mandare il messaggio</p>
{else}
<p>
{tz}selectlist{/tz}{$errors.targetlist.img}
</p>
		<dl class="ml_vediSpage">
		<!--if $login.role == 1 ||	$login.role == 2-->
		<dt><input type="checkbox" name="targetlist[all]" id="targetlist_all"  {$tpl_checked.alllists}/>&nbsp;
				<label for="targetlist_all">{tz}alllists{/tz}</label>
		</dt>
		<!--/if-->
			{foreach item=list from=$lists}		
				{if $list.active == 1}
			  	<dt>
			  	<input type="checkbox" name="targetlist[{$list.id}]" id="targetlist_{$list.id}" {if array_key_exists($list.id, $targetlist)} checked="checked"{/if}/>&nbsp;
			  	<label for="targetlist_{$list.id}">
			  	<span>{$list.name}</span>
				</label>&nbsp;
				{if $list.active}
				({tz}listactive{/tz})
				{else}
				({tz}listnotactive{/tz})		
				{/if}
				</dt>
				<dd>{$list.description|nl2br}</dd>
				{/if}
			{/foreach}
		</dl>

{/if}
{if $tpl_config.USE_LIST_EXCLUDE}
<p>
{tz}selectexcludelist{/tz}.<br />
{tz}excludelistexplain{/tz}
</p>
<table class="ml_tbl_row_small" summary="scelta delle liste">
		{foreach item=list from=$tpl_form_lists_exclude}		
		<tr>
		<th scope="row"><label for="MailLists_{$list.id}">{$list.name}</label></th>
		<td>
		<input type="checkbox" name="excludelist[{$list.id}]" id="MailLists_{$list.id}" {$list.checked}/>&nbsp;
		<span>
		<a href="?view=editlist&amp;id={$list.id}" title="modifica la lista di sviluppo">{$list.desc}</a>
		{if $list.active == 1}
		<span class="ml_txtEvidenziato">({tz}listactive{/tz})</span>
		{else}
		<span class="ml_txtEvidenziato">({tz}listnotactive{/tz})</span>
		{/if}
		</span>
		</td>
		</tr>
		{/foreach}
</table>
{/if}
</div><!--panel-->