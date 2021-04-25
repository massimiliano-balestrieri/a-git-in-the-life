{if $LANG_SWITCH}
<form id="lang_switch" method="post" action="#">
<table class="ml_tbl_row_small1" summary="scelta della lingua">
<tr>
<th scope="row"><label for="select_lang">Lingua</label></th>
<td>
<select name="set_lang" id="select_lang" onchange="submit()">
{$LANG_SWITCH}
</select>
</td>
</tr>
</table>
</form>
{/if}	
{if $ROLE_SWITCH}
<form id="role_switch" method="post" action="#">
<table class="ml_tbl_row_small1" summary="scelta del ruolo">
<tr>
<th scope="row"><label for="select_role">Ruolo</label></th>
<td>
<select name="set_role" id="select_role">
{$ROLE_SWITCH}
</select>
</td>
</tr>
</table>
</form>
{/if}	
{if $USER_SWITCH}
<form id="user_switch" method="post" action="#">
<table class="ml_tbl_row_small1" summary="scelta dell' utente">
<tr>
<th scope="row"><label for="select_user">Utente</label></th>
<td>
<select name="set_user" id="select_user">
{$USER_SWITCH}
</select>
</td>
</tr>
</table>
</form>
{/if}		
{if $DEBUG_SWITCH}
<form id="debug_switch" method="post" action="#">
<table class="ml_tbl_row_small1" summary="scelta del livello di debug">
<tr>
<th scope="row"><label for="select_debug">Debug</label></th>
<td>
<select name="set_debug" id="select_debug">
{$DEBUG_SWITCH}
</select>
</td>
</tr>
</table>
</form>
{/if}	
{if $AJAX_SWITCH}
<form id="ajax_switch" method="post" action="#">
<table class="ml_tbl_row_small1" summary="scelta di ajax">
<tr>
<th scope="row"><label for="select_ajax">Ajax</label></th>
<td>
<select name="set_ajax" id="select_ajax">
{$AJAX_SWITCH}
</select>
</td>
</tr>
</table>
</form>
{/if}			