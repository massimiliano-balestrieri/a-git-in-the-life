<!-- send_content.tpl -->
<h4>Contenuto</h4>

<div class="ml_panel ml_panel_1">
{if $errors}
{include file="$PATH_TPL/inc/error.tpl"}
{/if}
<table class="ml_tbl_row_small">
	<tr>
		<th scope="row"><label for="msg_subject">{tz}subject{/tz}{$errors.subject.img}</label> *</th>
		<td><input type="text" name="msg[subject]"  id="msg_subject" class="ml_input_medium{$errors.subject.classname}" value="{$msg.subject}" /></td>
	</tr>
	<!-- $login.role == 1 || $login.role == 2 -->
	<tr>
		<th scope="row"><label for="msg_fromfield">{tz}fromfield{/tz}{$errors.fromfield.img}</label>  *</th>
		<td><input type="text" name="msg[fromfield]"  id="msg_fromfield" class="ml_input_medium{$errors.fromfield.classname}" value="{$msg.fromfield}" /></td>
	</tr>
	<!--else
	<tr>
		<th scope="row">{tz}fromline{/tz}</th>
		<td>{$msg.from}</td>
	</tr>
	/if-->
	
	<tr>
		<th scope="row"><label for="msg_message">{tz}message{/tz}{$errors.message.img}</label> *</th>
		<td><textarea name="msg[message]"  id="msg_message" class="ml_area{$errors.message.classname}" cols="15" rows="10" style="width: 50%">{$msg.message}</textarea></td>
	</tr>	
	{if $tpl_config.USE_MANUAL_TEXT_PART}
	<tr>
		<th scope="row"><label for="msg_textmessage">{tz}plaintextversion{/tz}{$errors.message.img}</label></th>
		<td><textarea name="msg[textmessage]" id="msg_textmessage" class="ml_area{$errors.message.classname}" cols="65" rows="20">{$msg.textmessage}</textarea></td>
	</tr>	
	{/if}
</table>
	<p class="ml_note">{tz}fields_required{/tz}</p>
</div><!--panel-->