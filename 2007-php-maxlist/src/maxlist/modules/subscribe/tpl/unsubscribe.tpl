{include file="$PATH_TPL/inc/head_fo.tpl"}
<!-- unsubscribe.tpl -->
<form id="form_user" method="post" action="#">
<h4>{tz}unsubscribe_title{/tz}</h4> 
<div class="ml_panel ml_panel_1">
		<p>Cancellati dalle nostre Newsletter</p>
		<table>
		<tr>
			<th><label for="unsubscribe_email">Inserisci il tuo indirizzo email:</label></th>
			<td><input type="text" id="unsubscribe_email" name="unsubscribe[email]" value="{$user.email}" size="40" /></td>
		</tr>
		<tr>
			<th><label for="unsubscribe_reason">Motivo della cancellazione</label></th>
			<td><textarea cols="40" rows="10" id="unsubscribe_reason" name="unsubscribe[reason]"></textarea></td>
		</tr>
		</table>
		<div class="ml_container_buttons">
				<div class="ml_buttons_sx">
				</div>
				<div class="ml_buttons_dx">
					<input type="hidden" name="do" value="blacklist" />
					<input type="submit" name="change" value="{tz}save{/tz}" class="ml_button" />
				</div>
		</div>
</div>
</form>		
