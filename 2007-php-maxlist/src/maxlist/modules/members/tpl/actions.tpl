{if sizeof($tpl_list_users)>0}
<!-- if $login.role == 1 || $login.role == 2 -->
<h4>{tz}taggeduser{/tz}</h4>
<div class="ml_panel ml_panel_0">
	<p class="ml_note">
	{tz}taggedexplain{/tz}
	</p>
	<table class="ml_tbl_row_small">
	<tr>
		<td>
		
		<input type="radio" name="tagaction" id="tagaction_move" value="move" />
		<label for="tagaction_move">{tz}move{/tz}</label>
		<label for="movedestination">{tz}to{/tz}</label>
		<select name="movedestination" id="movedestination" class="ml_input_medium">
			{foreach from=$tpl_list_lists item=list key=idlist}
			<option value="{$idlist}">{$list}</option>
			{/foreach}
		</select><br />
		
		<input type="radio" name="tagaction" id="tagaction_copy" value="copy" />
		<label for="tagaction_copy">{tz}copy{/tz}</label>

		<label for="copydestination">{tz}to{/tz}</label>
		<select name="copydestination" id="copydestination" class="ml_input_medium">
			{foreach from=$tpl_list_lists item=list key=idlist}
			<option value="{$idlist}">{$list}</option>
			{/foreach}
		</select><br />
		
		<input type="radio" name="tagaction" id="tagaction_delete" value="delete" />
		<label for="tagaction_delete">{tz}delete{/tz}({tz}fromlist{/tz})</label><br />
		
		<input type="radio" name="tagaction" id="tagaction_html"  value="html"  />
		<label for="tagaction_html">{tz}Send_html{/tz}</label><br />
		
		<input type="radio" name="tagaction" id="tagaction_nothing"  value="nothing" checked="checked" />
		<label for="tagaction_nothing">{tz}nothing{/tz}</label><br />
		</td>
	</tr>
	</table>
	<div class="ml_container_buttons">
		<input type="hidden" name="view" value="members" />
		<input type="hidden" name="id" value="{$tpl_idlist}" />			
		<input name="processtags" type="submit" value="{tz}save{/tz}" class="ml_button" />	
	</div>
</div><!-- /panel -->


<h4>{tz}alluser{/tz}</h4>
<div class="ml_panel ml_panel_0">

	<p class="ml_note">
	{tz}alluserexplain{/tz}
	</p>
	
	<table class="ml_tbl_row_small">
	<tr>
		<td><input type="radio" name="tagaction_all" id="tagaction_move_all" value="move" />
		<label for="tagaction_move_all">{tz}move{/tz}</label>
		<label for="movedestination_all">{tz}to{/tz}</label>
		<select name="movedestination_all" id="movedestination_all" class="ml_input_medium">
			{foreach from=$tpl_list_lists item=list key=idlist}
			<option value="{$idlist}">{$list}</option>
			{/foreach}
		</select><br />
		<input type="radio" name="tagaction_all" id="tagaction_copy_all" value="copy" />
		<label for="tagaction_copy_all">{tz}copy{/tz}</label>
		<label for="copydestination_all">{tz}to{/tz}</label>
		<select name="copydestination_all" id="copydestination_all" class="ml_input_medium">
			{foreach from=$tpl_list_lists item=list key=idlist}
			<option value="{$idlist}">{$list}</option>
			{/foreach}
		</select><br />

		<input type="radio" name="tagaction_all" id="tagaction_delete_all" value="delete" />
		<label for="tagaction_delete_all">{tz}delete{/tz}({tz}fromlist{/tz})</label><br />

		<input type="radio" name="tagaction_all" id="tagaction_html_all"  value="html"  />
		<label for="tagaction_html_all">{tz}Send_html{/tz}</label><br />

		<input type="radio" name="tagaction_all" id="tagaction_nothing_all"  value="nothing" checked="checked" />
		<label for="tagaction_nothing">{tz}nothing{/tz}</label>
		</td>
	</tr>
	
	</table>
	<div class="ml_container_buttons">
		<input type="hidden" name="do" value="processtags" />			
		<input name="confirm" type="submit" value="{tz}save{/tz}" class="ml_button" />	
	</div>
</div><!--/panel-->
{/if}