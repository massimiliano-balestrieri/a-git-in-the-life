<!-- send_send.tpl -->
<h4>{tz}Save{/tz}</h4> 
	
	<div class="ml_open">
	
	<div class="ml_container_buttons">
		<div class="ml_buttons_sx">
				<a href="{$BO}user" class="ml_button">{tz}back{/tz}</a>
				<input type="reset" name="reset" id="reset" class="ml_button" value="{tz}reset{/tz}" />
		</div>
		<div class="ml_buttons_dx">
				<input type="hidden" name="do" value="{$DO}" />
				<input type="submit" name="confirm" value="{tz}save{/tz}" class="ml_button" />
				<input type="submit" name="confirm" value="{tz}save_and{/tz}" class="ml_button" />
		</div>
	</div>	
</div><!--panel-->