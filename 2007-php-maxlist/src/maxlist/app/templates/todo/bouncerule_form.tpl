{if !isset($target) || $target == "bouncerule"}
<div id="container_bouncerule">
	<h4 id="bouncerule">{$tpl_form_title_br}</h4>
	
	{if $tpl_flag_bounceruleform}
	<div class="ml_panel ml_panel_1" id="ml_bouncerule">
	{else}
	<div class="ml_panel ml_panel_0" id="ml_bouncerule">
	{/if}
		<form id="form_bouncerule" action="#" method="post">
		<table summary="azioni correlate" class="ml_tabRowMed">
		<tr>
			<th scope="row"><label for="regex">{$tpl_th_bouncerule.regex}</label></th>
			<td>
				<input type="text" name="regex" id="regex" class="ml_input_medium" value="{$tpl_bouncerule.regex}" />
			</td>
			</tr>
		<tr>
			<th scope="row">{$tpl_th_bouncerule.created}</th>
			<td>
				 {$tpl_bouncerule.created}
			</td>
			</tr>
		<tr>
			<th scope="row"><label for="action">{$tpl_th_bouncerule.action}</label></th>
			<td>
				<select name="action" id="action" class="ml_input_medium" >
					{foreach item="actionv" key="actionk" from=$tpl_select_bounceruleactions}
					{if $actionk == $tpl_bouncerule.action}
					<option value="{$actionk}" selected="selected">{$actionv}</option>
					{else}
					<option value="{$actionk}">{$actionv}</option>
					{/if}
					{/foreach}
				</select>
			</td>
		</tr>
			<tr>
			<th scope="row"><label for="status">{$tpl_th_bouncerule.status}</label></th>
			<td>
				<select name="status" id="status" class="ml_input_medium" >
					<option value="">{$tpl_th.selstatus}</option>
					{foreach item="statusv" key="statusk" from=$tpl_select_type}
					{if $statusk == $tpl_bouncerule.status}
					<option value="{$statusk}" selected="selected">{$statusv}</option>
					{else}
					<option value="{$statusk}">{$statusv}</option>
					{/if}
					{/foreach}
				</select>
			</td>
		</tr>
			<tr>
			<th scope="row"><label for="comment">{$tpl_th_bouncerule.memo}</label></th>
			<td>
				<textarea name="comment" id="comment" cols="40" rows="15">{$tpl_bouncerule.memo}</textarea>
			</td>
		</tr>
		</table>
		{if $tpl_related}
			<p>{$tpl_lbl_messages_br.bounces_rel}:<br />
				{foreach from=$tpl_arr_related item=related}
				<a href="" onclick="" class="">{$related}</a>&nbsp;|
				{/foreach}
				{if $tpl_relatedmore}
				<span>{$tpl_lbl_messages_br.more}</span>
				{/if}
			</p>
		{else}
			{if $tpl_ID > 0}
			<p>{$tpl_lbl_messages_br.nobounce_rel}</p>
			{/if}
		{/if}
		<div class="ml_pulsNav">
				<div class="ml_pulsNavSx">
				<input type="submit" name="back" id="indietro" class="puls" value="indietro" />
		</div>
		<div class="ml_pulsNavDx">
			<input type="submit" name="salva" value="{$tpl_lbl_action_br.save}" class="puls" /></div>
		</div>
		</form>
	</div><!--/contenuti-->
</div><!--/container-->
{/if}