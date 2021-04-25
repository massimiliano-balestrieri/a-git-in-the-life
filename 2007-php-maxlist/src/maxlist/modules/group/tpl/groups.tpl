{include file="$PATH_TPL/inc/head_view.tpl"}
<h4>{tz}Groups{/tz}</h4>
<div class="ml_panel ml_panel_1">
	{if sizeof($tpl_groups)>0}
	{if $ACTION == "delete"}
	<form id="form_confirm" method="post" action="#">
	<div class="ml_msg">
		<p>{tz}delete_records{/tz}</p>
	</div>

		<div class="ml_container_buttons">
			<div class="ml_buttons_sx">			
				<input type="submit" name="confirm" value="{tz}no{/tz}" class="ml_button" />
			</div>
			<div class="ml_buttons_dx">
				<input type="hidden" name="id" value="{$GET.id}" />
							<input type="hidden" name="do" value="{$DO}" />
							<input type="hidden" name="delete" value="{$ID}" />
				<input type="submit" name="confirm" value="{tz}yes{/tz}" class="ml_button" />
			</div>
		</div>
	</form>
	{/if}
	<table class="ml_col">
		<tr>
			<th scope="col">{tz}Groups{/tz}</th>
			<th scope="col">&nbsp;</th>
		</tr>
		{foreach item=group from=$tpl_groups}
		<tr>
			<td><a href="{$BO}{$CONTROLLER}/edit/{$group.id}">{$group.name}</a></td>
			<td>
			<a href="{$BO}usecase/edit/{$group.id}">{tz}settings{/tz}</a> &nbsp;|&nbsp;
			<a href="{$BO}{$CONTROLLER}/edit/{$group.id}">{tz}edit{/tz}</a> &nbsp;|&nbsp;
			<a href="{$BO}{$CONTROLLER}/delete/{$group.id}">{tz}delete{/tz}</a>
			</td>
		</tr>
		{/foreach}	
	</table>
	{/if}
	<div class="ml_container_buttons">
			<a href="{$BO}{$CONTROLLER}/create" class="ml_button">{tz}add{/tz}</a>
	</div>
</div><!-- panel -->
