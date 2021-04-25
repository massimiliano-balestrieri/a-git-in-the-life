{include file="$PATH_TPL/inc/head_view.tpl"}
<!-- eventlog.tpl -->

{if sizeof($tpl_list_events)>0 || isset($REQUEST.filter)}
{include file="$PATH_TPL/inc/simple_search.tpl"}
{/if}

{if sizeof($tpl_list_events)>0}
<div id="container_log">
<h4>{tz}events{/tz}</h4>

<div class="ml_panel ml_panel_1"> 
{if $ACTION == "delete"}
<form id="form_confirm" method="post" action="#">
<div class="ml_msg">
	<p>{tz}delete_record{/tz}</p>
	<div class="ml_container_buttons">
		<div class="ml_buttons_sx">			
			<input type="submit" name="confirm" value="{tz}no{/tz}"  class="ml_button" />
		</div>
		<div class="ml_buttons_dx">
			<input type="hidden" name="block" value="{$GET.block}" />
			<input type="hidden" name="pg" value="{$GET.pg}" />
			<input type="hidden" name="do" value="do_delete" />
			<input type="hidden" name="delete" value="{$ID}" />
			<input type="submit" name="confirm" value="{tz}yes{/tz}" class="ml_button" />
		</div>
	</div>
</div>
</form>
{/if}

{if $ACTION == "deleteall" || $ACTION == "deleteold"}
<form id="form_confirm" method="post" action="#">
<div class="ml_msg">
	<p>{tz}delete_records{/tz}</p>
	<div class="ml_container_buttons">
		<div class="ml_buttons_sx">			
			<input type="submit" name="confirm" value="{tz}no{/tz}" class="ml_button" />
		</div>
		<div class="ml_buttons_dx">
			{if $ACTION == "deleteall"}
			<input type="hidden" name="do" value="do_{$ACTION}" />
			{/if}
			{if $ACTION == "deleteold"}
			<input type="hidden" name="do" value="do_{$ACTION}" />
			{/if}
			<input type="submit" name="confirm" value="{tz}yes{/tz}" class="ml_button" />
		</div>
	</div>
</div>
</form>
{/if}

{include file="$PATH_TPL/inc/paging.tpl"}
<table class="ml_col">
	<tr>
		<th scope="col">{tz}events{/tz}</th>
		<th scope="col">{tz}page{/tz}</th>
		<th scope="col">username</th>
		<th scope="col">{tz}date{/tz}</th>
		<th scope="col">{tz}message{/tz}</th>
		<th scope="col">&nbsp;</th>
		
	</tr>
	
	{foreach item=event from=$tpl_list_events}
	<tr id="row_{$event.id}">
		<td>{$event.id}</td>
		<td>{$event.page}</td>
		<td>{$event.admin}</td>
		<td>{$event.entered|date_format:"%d/%m/%y"}</td>
		<td>{$event.entry|truncate:45:"---"}</td>
		<td>
		<a href="{$BO}{$CONTROLLER}/delete/{$event.id}{$QS}" class="ml_button">{tz}del{/tz}</a>
		<a href="#" onclick="$('#stack_{$event.id}').toggle();" class="ml_button">toggle</a>
		</td>
	</tr>
	<tr>
		<td colspan="6" style="height:0px;display: none;" id="stack_{$event.id}"><strong>{$event.entry}</strong><pre>Stack: {$event.stack}</pre></td>
	</tr>
	{/foreach}
	
	
</table>
{include file="$PATH_TPL/inc/paging.tpl"}

	<div class="ml_container_buttons">
		<a href="{$BO}{$CONTROLLER}/deleteall" class="ml_button">{tz}Delete all{/tz}</a>
		<a href="{$BO}{$CONTROLLER}/deleteold"  class="ml_button">{tz}Delete all (> 2 months old){/tz}</a>
	</div>

</div><!-- panel -->
</div><!--container-->
{/if}