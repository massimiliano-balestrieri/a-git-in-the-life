<!-- user.tpl -->

<h4>{tz}user_detail{/tz}</h4> 
<div class="ml_panel ml_panel_1">
{if $errors}
{include file="$PATH_TPL/inc/error.tpl"}
{/if}
<table class="ml_tab_row_small">
{include file="$PATH_TPL_MOD/user/tpl/user.tpl"}
{include file="$PATH_TPL_MOD/user/tpl/info.tpl"}
</table>
<p class="ml_note">{tz}field_required{/tz}</p>

{include file="$PATH_TPL_MOD/user/tpl/link.tpl"}
</div><!-- /panel-->