<!--if $tpl_isWritableList -->
<h4 id="addMembers">{tz}add_new{/tz}</h4>
<form method="post" id="form_addMembers" action="#">
<div class="ml_panel ml_panel_1">
	
	
	{if $POST.do == 'check_user' ||  $POST.do == 'new'}
		{if $user.id > 0}
 		<p>{tz}user_found{/tz}:</p>
 		<ul>
 			<li>{$user.email}</li>
	    </ul>
		<div class="ml_container_buttons">
			<div class="ml_buttons_sx">
			</div>
			<div class="ml_buttons_dx">
				<input type="hidden" name="do" value="subscribe" />
				<input type="hidden" name="user[id]" value="{$user.id}" />
				<input type="submit" name="confirm" value="{tz}add{/tz}" class="ml_button" />
			</div>
		</div>
		{else}
			{include file="$PATH_TPL_MOD/members/tpl/panel.tpl"}
		{/if}
	{else}
	<table class="ml_tbl_row_small" summary="aggiungi un nuovo partecipante alla categoria">
		<tr>
			<th scope="row"><label for="user_email">Email *</label></th>
			<td>
			<input id="user_email" type="text" name="user[email]" size="30" class="ml_input_medium" />
			<input name="confirm" type="submit" value="{tz}add{/tz}" class="ml_button" />
			<input type="hidden" name="do" value="check_user" />
			</td>
		</tr>
	</table>
	{/if}
</div><!--/panel-->
</form>