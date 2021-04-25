{include file="$PATH_TPL/inc/head_view.tpl"}
<!-- processbounces.tpl -->
<h4 id="processbounces">Processa Coda Messaggi</h4>
	
<div class="ml_panel ml_panel_1" id="ml_processbounces">
		{if isset($tpl_POST.confirm)}
		<p>
		{foreach from=$content item=cont}
			{$cont}
		{/foreach}
		</p>
		{else}
		<form id="form_confirm" method="post" action="#">
		<div class="ml_msg">
		<p>{tz}sure_process_bounces{/tz}</p>
		</div>
		<div class="ml_container_buttons">
			<div class="ml_buttons_sx">			
				<input type="submit" name="confirm" value="{tz}no{/tz}" class="ml_button" />
			</div>
			<div class="ml_buttons_dx">
				<input type="hidden" name="do" value="process_bounces" />
				<input type="submit" name="confirm" value="{tz}yes{/tz}" class="ml_button" />
			</div>
		</div>
		</form>
		{/if}
</div><!--/container-->

<div class="wrap_debug">
<h4>Debug</h4> 
<div class="ml_panel ml_panel_1">

	<form id="form_tests" method="post" action="#">
	<div class="ml_container_buttons">
		<div class="ml_buttons_dx">
			<input type="submit" name="post" value="locka2" class="ml_button" />
			<input type="submit" name="post" value="unlock2" class="ml_button" />
			<input type="submit" name="post" value="process_bounces" class="ml_button" />
		</div>
	</div>
	</form>

<div class="debug">

</div>
</div>
</div>