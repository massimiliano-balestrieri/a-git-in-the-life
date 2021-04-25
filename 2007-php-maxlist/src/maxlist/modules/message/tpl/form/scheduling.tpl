<!--if $login.role < 4-->
<!-- send_scheduling.tpl -->
<h4>Schedulazione</h4> 

<div class="ml_panel ml_panel_0">
	<p>{tz}embargoeduntil{/tz}</p>
		<table class="ml_tbl_row_small">	
		<tr>
			<th scope="row">Data:</th>
			<td>
			{$tpl_form_cal_embargo}
			</td>
		</tr>		
		<tr>
			<th scope="row">Ora:</th>
			<td>
			<select name="msg[hour_embargo]" id="msg_hour_embargo">
				{section name=loop start=0 loop=24}
				{if $smarty.section.loop.index == $tpl_form_cal_embargo_h}
				<option value="{$smarty.section.loop.index}" selected="selected">{if $smarty.section.loop.index lt 10}0{/if}{$smarty.section.loop.index}</option> 				
				{else}
				<option value="{$smarty.section.loop.index}">{if $smarty.section.loop.index lt 10}0{/if}{$smarty.section.loop.index}</option> 
				{/if}
				{/section}
			</select>
			<select name="msg[minute_embargo]" id="msg_minute_embargo">
				{section name=loop start=0 loop=60 step=15}
				{if $smarty.section.loop.index == $tpl_form_cal_embargo_m}
				<option value="{$smarty.section.loop.index}" selected="selected">{if $smarty.section.loop.index lt 10}0{/if}{$smarty.section.loop.index}</option> 				
				{else}
				<option value="{$smarty.section.loop.index}">{if $smarty.section.loop.index lt 10}0{/if}{$smarty.section.loop.index}</option> 
				{/if}
				{/section}
			</select>
			</td>
		</tr>
		{if $tpl_config.USE_REPETITION == 1}
		<tr>
			<th scope="row">{tz}repeatevery{/tz}</th>
			<td>
			<select name="repeatinterval" id="repeatinterval">
			{foreach from=$tpl_form_select_repeat item=repeatv key=repeatk}
			{if $repeatk == $tpl_POST.repeatinterval}
			<option value="{$repeatk}" selected="selected">{$repeatv}</option> 	
			{else}
			<option value="{$repeatk}">{$repeatv}</option> 	
			{/if}
			{/foreach}
			</select>
			</td>
		</tr>
		<tr>
			<th scope="row">Data:</th>
			<td>
			{$tpl_form_cal_repeatuntil}
			</td>
		</tr>		
		<tr>
			<th scope="row">Ora:</th>
			<td>
			<select name="hour[repeatuntil]" id="hour_repeatuntil">
				{section name=loop start=0 loop=24}
				{if $smarty.section.loop.index == $tpl_form_cal_repeatuntil_h}
				<option value="{$smarty.section.loop.index}" selected="selected">{if $smarty.section.loop.index lt 10}0{/if}{$smarty.section.loop.index}</option> 				
				{else}
				<option value="{$smarty.section.loop.index}">{if $smarty.section.loop.index lt 10}0{/if}{$smarty.section.loop.index}</option> 
				{/if}
				{/section}
			</select>
			<select name="minute[repeatuntil]" id="minute_repeatuntil">
				{section name=loop start=0 loop=60 step=15}
				{if $smarty.section.loop.index == $tpl_form_cal_repeatuntil_m}
				<option value="{$smarty.section.loop.index}" selected="selected">{if $smarty.section.loop.index lt 10}0{/if}{$smarty.section.loop.index}</option> 				
				{else}
				<option value="{$smarty.section.loop.index}">{if $smarty.section.loop.index lt 10}0{/if}{$smarty.section.loop.index}</option> 
				{/if}
				{/section}
			</select>
			</td>
		</tr>
		{/if}		
		</table>
</div><!--panel-->
<!--/if-->