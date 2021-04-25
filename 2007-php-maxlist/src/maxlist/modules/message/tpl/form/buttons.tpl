<!-- send_send.tpl -->
<h4>{tz}Save_message{/tz}</h4> 
	
	<div class="ml_open">
	
	<div class="ml_container_buttons">
		<div class="ml_buttons_sx">
			<input type="submit" name="back" class="ml_button" value="indietro" />
			<input type="submit" name="confirm" class="ml_button" value="{tz}saveasdraft{/tz}" />
		</div>
		<div class="ml_buttons_dx">
		<input type="hidden" id="sendid" name="id" value="{$ID}" />
		<input type="hidden" id="senddo" name="do" value="{$DO}" />
		<input type="hidden" id="sendstatus" name="status" value="{$tpl_POST.status}" />
		<input type="hidden" id="sendexpand" name="expand" value="0" />
		<!--if $login.role < 4-->
		<input type="submit" name="confirm" class="ml_button" value="{tz}sendmessage{/tz}" />
		<!--/if-->
		</div>
	</div>	
</div><!--panel-->