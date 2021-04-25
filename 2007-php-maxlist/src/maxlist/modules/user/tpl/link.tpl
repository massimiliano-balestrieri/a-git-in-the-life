		{if $ID>0}
		<div class="ml_container_buttons">
					<a href="{$BO}history/view/{$ID}" class="ml_button">{tz}History{/tz}</a>		
					<a href="{$BO}subscribe/unsubscribe/{$user.uniqid}" class="ml_button">{tz}unsubscribe{/tz}</a>								
		</div>
		{/if}