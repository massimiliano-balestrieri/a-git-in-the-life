<!-- login.tpl -->
<form method="post" action="?page=home" id="form_login"> 
<h4>Login</h4> 
<div class="ml_open" id="ml_login">
<p class="ml_note"></p>
<table class="ml_tabRowSmall" summary="dati necessari per la registrazione">

<tr>
	<th scope="row"><label for="username">{$tpl_lbl_messages.name}: * 
	</label></th>
	<td><input type="text" name="username" id="username" class="ml_med" value="{$tpl_POST.username}" /></td>

</tr>
<tr>
	<th scope="row"><label for="password">{$tpl_lbl_messages.password}: * 
	</label></th>
	<td><input type="password" name="password" id="password" class="ml_med"  value="" /></td>
</tr>
</table>
			<p class="ml_note">I campi contrassegnati con l'asterisco (*) sono obbligatori</p>

	<div class="ml_pulsNav">
		<div class="ml_pulsNavDx">
			<input type="hidden" name="act" value="login" />
			<input type="hidden" name="istance" value="{$istance}" />
			<input type="submit" name="process" value="{$tpl_lbl_action.enter}" class="ml_button" />
		</div>
	</div>
</div><!--contenuti-->
</form>