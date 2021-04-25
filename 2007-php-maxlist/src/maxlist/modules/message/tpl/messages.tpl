{include file="$PATH_TPL/inc/head_view.tpl"}
<!-- messages.tpl -->

<h4>{tz}Search{/tz}</h4>
<div class="ml_panel ml_panel_0">
<form id="form_search" method="post" action="#">
	<table class="ml_tbl_row_small">
		<tr>
			<th scope="row">
			<label for="find">{tz}subject_find{/tz}</label>
			</th>
			<td>
			<input type="text" name="find" id="find" class="ml_input_medium" value="{$REQUEST.find}" />
			</td>
		</tr>
		<tr>
			<th scope="row">
			<label for="type">{tz}Status{/tz}</label>
			</th>
			<td>
			<select class="ml_small" name="type" id="type">
			<option value="">{tz}select_status{/tz}</option>
			{foreach item=typev key=typek from=$tpl_select_findby}
			{if $tpl_REQUEST.type == $typek}
			<option value="{$typek}" selected="selected">{$typev}</option>
			{else}
			<option value="{$typek}">{$typev}</option>
			{/if}
			{/foreach} 
			</select>
			</td>
		</tr>
	</table>
	<div>
			<input type="hidden" name="pg" value="{$REQUEST.pg}" />
			<input type="hidden" name="block" value="{$REQUEST.block}" />
	</div>
	<div class="ml_container_buttons">
		<div class="ml_buttons_sx">
			<input name="reset" type="reset" value="{tz}reset{/tz}" class="ml_button" />
		</div>
		<div class="ml_buttons_dx">
			<input name="do" type="hidden" value="filter" />
			<input name="confirm" type="submit" value="{tz}go{/tz}" class="ml_button" />
		</div>
	</div>
</form>
</div>
<!--contenuto-->




{if sizeof($tpl_list_messages)>0}
<h4>{tz}Messages{/tz}</h4> 
<div class="ml_open">
	{if $ACTION == "delete"}
		<form id="form_confirm" method="post" action="#">
		<div class="ml_msg">
			{if $REQUEST.delete eq 'draft'}
			<p>{tz}sure_deleted_nosubject{/tz}</p>		
			{else}
			<p>{tz}sure_delete_msg{/tz}</p>
			{/if}
		</div>
			<div class="ml_container_buttons">
				<div class="ml_buttons_sx">			
					<input type="submit" name="confirm" value="{tz}no{/tz}" class="ml_button" />
				</div>
				<div class="ml_buttons_dx">
					<input type="hidden" name="delete" value="{$ID}" />
					<input type="hidden" name="do" value="{$DO}" />
					<input type="submit" name="confirm" value="{tz}yes{/tz}" class="ml_button" />
				</div>
			</div>
		</form>
	{/if}

	{if isset($GET.resend)}
	<form id="form_confirm" method="post" action="#">
		<div class="ml_msg">
			<p>{tz}sure_requeue{/tz}</p>
		</div>
		<div class="ml_container_buttons">
			<div class="ml_buttons_sx">			
				<input type="submit" name="confirm" value="{$tpl_lbl_action.no}" class="ml_button" />
			</div>
			<div class="ml_buttons_dx">
				<input type="hidden" name="delete" value="{$tpl_GET.delete}" />
				<input type="submit" name="confirm" value="{$tpl_lbl_action.yes}" class="ml_button" />
			</div>
		</div>
	</form>
	{/if}


<form id="form_messages" method="post" action="#">
{include file="$PATH_TPL/inc/paging.tpl"}
<div class="ml_scroll">
<table class="ml_col" summary="{tz}info_message{/tz}">
	<tr>
		<th>&nbsp;</th>
		<th>{tz}subject{/tz} </th>
		<th>{tz}lists{/tz}</th>
		<th>{tz}status{/tz}</th>
	</tr>
{foreach item=message from=$tpl_list_messages}
	<tr>
		<td><input type="radio" name="id" value="{$message.id}" /></td>
		<td>{$message.subject|truncate:30:"---"}</td>
		<td>{$message.lists}</td>
		<td>{tz}{$message.status}{/tz}</td>
	</tr>	
{/foreach}
</table>
</div>
{include file="$PATH_TPL/inc/paging.tpl"}

	<div class="ml_container_buttons">
		<input type="submit" name="do" value="{tz}view{/tz}" class="ml_button" />
		<!--if $login.role < 4-->
		<input type="submit" name="do" value="{tz}delete{/tz}" class="ml_button" />
		<!--if-->
		<!--if $login.role == 1-->
		<input type="submit" name="do" value="{tz}requeue{/tz}" class="ml_button" />
		<!--if-->
		<input type="submit" name="do" value="{tz}edit{/tz}" class="ml_button" />
	</div>
</form>
</div><!--/contenuti-->
{/if}
