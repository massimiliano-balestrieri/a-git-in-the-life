<!-- send_misc.tpl -->
<!--if $login.role < 4-->
<h4>{tz}Misc{/tz}</h4> 

<div class="ml_panel ml_panel_0">
<table class="ml_tbl_row_small">
		<tr>
		<th scope="row"><label for="messagedata_notify_start">{tz}emailtoalert{/tz}</label></th>
		<td><input type="text" name="messagedata[notify_start]"  id="messagedata_notify_start" class="ml_input_medium" value="{$messagedata.notify_start}" /> {tz}comma{/tz}</td>
		</tr>
		<tr>
		<th scope="row"><label for="messagedata_notify_end">{tz}emailfinished{/tz}</label></th>
		<td><input type="text" name="messagedata[notify_end]"  id="messagedata_notify_end" class="ml_input_medium" value="{$messagedata.notify_end}" /> {tz}comma{/tz}</td>
		</tr>
	</table>
</div><!--panel-->
<!--/if-->