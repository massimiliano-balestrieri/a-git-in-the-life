<div id="container_search">
<h4>{tz}Search{/tz}</h4>

	{if  isset($REQUEST.filter)}
	<div class="ml_panel ml_panel_1"> 
	{else}
	<div class="ml_panel ml_panel_0"> 
	{/if}
	<form id="form_simple_search" method="post" action="#">
	<table class="ml_tbl_row_small" summary="{$tpl_lbl_messages.filter}">
		<tr>
			<th scope="row"><label for="ml_inp_filter">{tz}Filter{/tz}</label></th>
			<td><input type="text" name="filter" id="ml_inp_filter" class="ml_input_medium" value="{$REQUEST.filter}" />
			</td>
		</tr>
	</table>
		<div class="ml_container_buttons">
			<input name="go" type="submit" value="{tz}go{/tz}" class="ml_button" />
			<input name="reset" type="reset" value="{tz}reset{/tz}" class="ml_button" />
		</div>
		<div>
			<input type="hidden" name="view" value="{$VIEW}" />
			<input type="hidden" name="pg" value="{$REQUEST.pg}" />
			<input type="hidden" name="block" value="{$REQUEST.block}" />
		</div>
	</form>
	</div><!--panel-->
</div><!--container-->