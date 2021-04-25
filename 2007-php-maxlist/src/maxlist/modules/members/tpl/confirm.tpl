	{if $ACTION == "delete"}
		<div class="ml_msg">
		<p>Sei sicuro di cancellare l'utente?</p>
		</div>
		
		<div class="ml_container_buttons">
			<div class="ml_buttons_sx">			
				<input type="submit" name="confirm" value="{tz}no{/tz}" class="ml_button" />
			</div>
			<div class="ml_buttons_dx">
				<input type="hidden" name="delete" value="{$tpl_GET.delete}" />
				<input type="submit" name="confirm" value="{tz}yes{/tz}" class="ml_button" />
			</div>
		</div>
	{/if}