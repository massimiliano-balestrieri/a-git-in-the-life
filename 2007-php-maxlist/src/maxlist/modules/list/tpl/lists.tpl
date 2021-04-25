{include file="$PATH_TPL/inc/head_view.tpl"}
<!-- list.tpl -->
<h4>{tz}Lists{/tz}</h4>
<div class="ml_open">
{if $ACTION == "delete"}
<form id="form_confirm" method="post" action="#">
<div class="ml_msg">
	<p>{tz}sure_delete{/tz}</p>
</div>
		<div class="ml_container_buttons">
			<div class="ml_buttons_sx">			
				<input type="submit" name="confirm" value="{tz}no{/tz}" class="ml_button" />
			</div>
			<div class="ml_buttons_dx">
				<input type="hidden" name="do" value="{$DO}" />
				<input type="hidden" name="delete" value="{$ID}" />
				<input type="submit" name="confirm" value="{tz}yes{/tz}" class="ml_button" />
			</div>
		</div>

</form>
{/if}
<form id="form_list" method="post" action="#">
{if sizeof($tpl_lists)>0}
<table class="ml_col">
	<tr>
		<th scope="col">{tz}No{/tz}</th>
		<!-- if role -->
		<th scope="col" class="radio" colspan="2">{tz}Order{/tz}</th>
		<!-- /if -->
		<th scope="col">{tz}Name{/tz}</th>
		<th scope="col">{tz}Functions{/tz}</th>
		<th scope="col">{tz}Owner{/tz}</th>
		<th scope="col">{tz}Active{/tz}</th>
		<!-- if role -->
		<th scope="col">&nbsp;</th>
		<!-- /if -->
	</tr>


	{foreach from=$tpl_lists item=list}
	<tr>
		<td colspan="8">
			<strong>{$list.desc}</strong>
		</td>
	</tr>
	<tr>
	
		<td>
			{$list.cnt}
		</td>
		<!-- TODO: if role -->
		<td>
			{if $list.cnt > 1}
 			<input name="decrease[{$list.id}]" type="submit" value="-" class="ml_up" title="{tz}decrease position{/tz}" />
			{/if}
		</td>
		<td>
			{if sizeof($tpl_lists) > $list.cnt}	
			<input name="increase[{$list.id}]" type="submit" value="+" class="ml_down" title="{tz}increase position{/tz}" />
			{/if}
		</td>
		<!-- /if -->
		<td>
			{$list.name}
		</td>
		<td>
			{$list.members}
		</td>
		<td>
			{$list.owner}
		</td>
		<td>
		{if $list.isWritable}
			<input id="list_{$list.id}" name="list[{$list.id}]" value="1" type="hidden" />
			<input id="active_{$list.id}" name="active[{$list.id}]" type="checkbox" class="ml_noBorder" {if $list.active} checked="checked"{/if}/>&nbsp;
			<label for="active_{$list.id}">attivo</label><br />
		{else}
			<span>{$list.isActive}</span>
		{/if}
		</td>
		<!-- TODO: if role -->
		<td>
			{if $list.isWritable}
			<a href="{$BO}{$CONTROLLER}/edit/{$list.id}">{tz}edit{/tz}</a>&nbsp;|&nbsp;
			<a href="{$BO}{$CONTROLLER}/delete/{$list.id}">{tz}delete{/tz}</a>&nbsp;|&nbsp;
			<a href="{$BO}members/list/{$list.id}">{tz}members{/tz}</a>
			{/if}
		</td>
		<!-- /if -->
	</tr>
	{/foreach}
</table>
{/if}
<!-- TODO: if role -->
	<div class="ml_container_buttons">
		<a href="{$BO}{$CONTROLLER}/create" class="ml_button">{tz}add{/tz}</a>
	{if sizeof($tpl_lists)>0}
		<input name="do" type="hidden" value="set_active" />
		<input name="confirm" type="submit" value="{tz}update{/tz}" class="ml_button" /><!--do i18n -->
	{/if}
	</div>
<!-- /if -->
</form>
</div><!--panel-->

