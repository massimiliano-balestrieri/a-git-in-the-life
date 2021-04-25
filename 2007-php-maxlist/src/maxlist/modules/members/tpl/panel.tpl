	{if $errors}
	{include file="$PATH_TPL/inc/error.tpl"}
	{/if}
	<table class="ml_tab_row_small">
	{include file="$PATH_TPL_MOD/user/tpl/user.tpl"}
	</table>
	<p class="ml_note">{tz}field_required{/tz}</p>

	
	<div class="ml_container_buttons">
			<div class="ml_buttons_sx">
				<input type="reset" name="reset" id="reset" class="ml_button" value="{tz}reset{/tz}" />
			</div>
			<div class="ml_buttons_dx">
				<input type="hidden" name="do" value="new" />
				<input type="submit" name="confirm" value="{tz}save{/tz}" class="ml_button" />
			</div>
	</div>	
	