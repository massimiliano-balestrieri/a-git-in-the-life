{include file="$PATH_TPL/inc/head_view.tpl"}
{include file="$PATH_TPL/inc/debug.tpl"}
<!-- login.tpl -->
<form method="post" action="?view=home" id="form_login"> 
<h4>Login</h4> 

<div class="ml_open" id="ml_login">
{if isset($tpl_login.required)}
<div class="ml_messaggioKo">
	ATTENZIONE! Risultano errati alcuni campi.<br />
	Correggere o completare i dati contrassegnati dal simbolo <img src="/ris/css/generaliV2/im/error.gif" alt="Errore" title="Errore" /> prima di proseguire.<span class="hidden">Gli errori vengono segnalati anche nell'etichetta del campo compilato erroneamente</span>
</div>
{/if}
<p class="ml_note"></p>
<table class="ml_tbl_row_small" summary="dati necessari per la registrazione">

<tr>
	<th scope="row"><label for="username">{$tpl_lbl_messages.name}: * 
	{if $tpl_login.required.login}
	<img src="/ris/css/generaliV2/im/error.gif" alt=" " />
	{/if}
	</label></th>
	<td><input type="text" name="login" id="login" class="ml_input_medium" value="{$tpl_POST.login}" /></td>

</tr>
<tr>
	<th scope="row"><label for="password">{$tpl_lbl_messages.password}: * 
	{if $tpl_login.required.password}
	<img src="/ris/css/generaliV2/im/error.gif" alt=" " />
	{/if}
	</label></th>
	<td><input type="password" name="password" id="password" class="ml_input_medium"  value="{$tpl_POST.password}" /></td>
</tr>
</table>
			<p class="ml_note">I campi contrassegnati con l'asterisco (*) sono obbligatori</p>

<div class="ml_pulsNav">
<div class="ml_pulsNavDx">
<input type="hidden" name="view" id="view" value="home" />
<input type="hidden" name="extlog" value="1" />
<input type="submit" name="process" value="{$tpl_lbl_action.enter}" class="puls" />
</div>
</div>
</div><!--panel-->
<h4>{$tpl_lbl_messages.forgot_password}</h4> 

<div class="ml_open"  id="ml_forget">
<table class="ml_tbl_row_small" summary="dati necessari per la registrazione">

<tr>
	<th scope="row"><label for="forgotpassword">{$tpl_lbl_messages.enter_email}:* 
	{if $tpl_login.required.forgotpassword}
	<img src="/ris/css/generaliV2/im/error.gif" alt=" " />
	{/if}
	</label></th>
	<td><input type="text" name="forgotpassword" id="forgotpassword" class="ml_input_medium" /></td>

</tr>
</table>

<div class="ml_pulsNav">
<div class="ml_pulsNavDx">
<input type="submit" name="process" value="{$tpl_lbl_action.send_password}" class="puls" />
</div>
</div>
</div><!--/contenuti -->

<!--FINE parte da togliere-->


</form>