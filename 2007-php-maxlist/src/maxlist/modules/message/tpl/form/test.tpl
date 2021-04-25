<!-- send_test.tpl -->
<h4>{tz}Test_message{/tz}</h4> 
	<div class="ml_panel ml_panel_0">
	<table class="ml_tbl_row_small">	
		<tr>
			<th scope="row"><label for="msg_testtarget">{tz}toemailaddresses{/tz}</label></th>
			<td><input type="text" name="msg[testtarget]"  id="msg_testtarget" class="ml_input_medium" value="{$tpl_config.WEBMASTER_EMAIL}" /><br />{tz}sendtestexplain{/tz}</td>
		</tr>		
	</table>
	<div class="ml_container_buttons">
		<input type="submit" name="confirm" id="pulsInvia" class="ml_button" value="{tz}sendtestmessage{/tz}" />
	</div>	
</div><!--panel-->