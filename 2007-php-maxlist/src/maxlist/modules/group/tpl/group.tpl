{include file="$PATH_TPL/inc/head_view.tpl"}
<!-- list.tpl -->
<h4>{tz}Group{/tz}</h4> 
<div class="ml_panel ml_panel_1">
{if $errors}
{include file="$PATH_TPL/inc/error.tpl"}
{/if}
<form id="form_list" method="post" action="#">
<table class="ml_tbl_row_med">
	<tr>
		<th scope="row"><label for="group_name">{tz}groupname{/tz}{$errors.name.img}</label> *</th>
		<td><input type="text" name="group[name]"  id="name" class="ml_input_medium{$errors.name.classname}" value="{$tpl_group.name}" /></td>
	</tr>
	</table>
	<p class="ml_note">{tz}fields_required{/tz}</p>
	<div class="ml_container_buttons">
		<div class="ml_buttons_sx">
			<a href="{$BO}group" class="ml_button">{tz}back{/tz}</a>
			<input type="reset" name="{tz}reset{/tz}" id="{tz}reset{/tz}" class="ml_button" value="{tz}reset{/tz}" />
		</div>
	
		<div class="ml_buttons_dx">
			<input type="hidden" name="do" class="ml_button" value="{$DO}" />
			<input type="submit" name="confirm" id="confirm" class="ml_button" value="{tz}save{/tz}" />
			<input type="submit" name="confirm" id="confirm_and" class="ml_button" value="{tz}save_and{/tz}" />
		</div>
	</div>
</form>
</div><!--panel-->