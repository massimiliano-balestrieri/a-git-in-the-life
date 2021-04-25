{include file="$PATH_TPL/inc/head_view.tpl"}
<!-- spage.tpl -->


<h4>Invia messaggi</h4>
	<div class="ml_panel ml_panel_1">
	{if sizeof($tpl_list_messages)==0}
	<div class="ml_msg">
		<p>{tz}no_messages_in_queue{/tz}</p>
	</div>

	{else}
	<form id="form_batch" method="post" action="#">
	<div class="ml_msg">
		<p>{tz}sure_send{/tz}</p>
	</div>
	<div class="ml_container_buttons">
		<div class="ml_buttons_sx">
			<input type="submit" name="confirm" value="{tz}no{/tz}" class="ml_button" />
		</div>
		<div class="ml_buttons_dx">
			<input type="hidden" name="do" value="batch" />
			<input type="submit" name="confirm" value="{tz}yes{/tz}" class="ml_button" />
		</div>
		
	</div>
	</form>
	{/if}

</div><!--/panel-->

{if sizeof($tpl_list_messages)>0}
{if !isset($tpl_POST.confirm)}
<h4>{tz}messages_in_queue{/tz}</h4> 
	
<div class="ml_panel ml_panel_1">
	{include file="$PATH_TPL/inc/paging.tpl"}
	<table class="ml_col">
		<tr>
			<th>{tz}subject{/tz}</th>
			<th>{tz}lists{/tz}</th>
			<th>{tz}status{/tz}</th>
			<th>{tz}send{/tz}</th>			
		</tr>
	{foreach item=message from=$tpl_list_messages}
		<tr>
			<td>{$message.subject}</td>
			<td>{$message.lists}</td>
			<td>{$message.status}</td>
			<td>{$message.embargo}</td>
		</tr>	
	{/foreach}
	</table>
	{include file="$PATH_TPL/inc/paging.tpl"}
</div><!--/panel-->
{/if}	
{/if}	

<div class="wrap_debug">
<h4>Debug</h4> 
<div class="ml_panel ml_panel_1">

	<form id="form_tests" method="post" action="#">
	<div class="ml_msg">
		<p>Lastsend : <span id="lastsend"></span></p>
		<p>Reload : <span id="reload"></span></p>
	</div>
	<div class="ml_container_buttons">
		<div class="ml_buttons_dx">
			<input type="submit" name="post" value="locka" class="ml_button" />
			<input type="submit" name="post" value="unlock" class="ml_button" />
			<input type="submit" name="post" value="polling" class="ml_button" />
			<input type="submit" name="post" value="reset_polling" class="ml_button" />
			<input type="submit" name="post" value="step" class="ml_button" />
			<input type="submit" name="post" value="queue" class="ml_button" />
			<input type="submit" name="post" value="reset" class="ml_button" />
			<input type="submit" name="post" value="truncate" class="ml_button" />
		</div>
		
	</div>
	</form>

<div class="debug">

</div>
</div>
</div>