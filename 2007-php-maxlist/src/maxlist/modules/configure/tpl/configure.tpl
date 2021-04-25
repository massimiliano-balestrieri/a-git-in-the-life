{include file="$PATH_TPL/inc/head_view.tpl"}

{foreach item=conf from=$tpl_form_lists_conf}
<h4>{$conf.val1}</h4>

{if $ID == $conf.key}
<div class="ml_panel ml_panel_1" id="ml_{$conf.key}">
{else}
<div class="ml_panel ml_panel_0" id="ml_{$conf.key}">
{/if}<!--TODO : accordion -->
	
		<form method="post" id="form_configure_{$conf.key}" action="#">
		<p>
		{$conf.field}
		<input type="hidden" id="id_{$conf.key}" name="id" value="{$conf.key}" />
		</p>
				<div class="ml_container_buttons">
						<input type="hidden" name="do" value="update" />
						<input type="submit" name="confirm" value="{tz}save{/tz}" class="ml_button" />
				</div>
		</form>
</div><!--panel-->
{/foreach}