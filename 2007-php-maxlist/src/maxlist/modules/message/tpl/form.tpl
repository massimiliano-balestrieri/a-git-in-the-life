{include file="$PATH_TPL/inc/head_view.tpl"}
{include file="$PATH_TPL_MOD/message/tpl/form/debug.tpl"}
<!-- send.tpl -->
<form method="post" action="#"{$tpl_config.ENC_TYPE}>
{include file="$PATH_TPL_MOD/message/tpl/form/content.tpl"}

{include file="$PATH_TPL_MOD/message/tpl/form/lists.tpl"}

{include file="$PATH_TPL_MOD/message/tpl/form/attachments.tpl"}

{include file="$PATH_TPL_MOD/message/tpl/form/format.tpl"}

{include file="$PATH_TPL_MOD/message/tpl/form/footer.tpl"}

{include file="$PATH_TPL_MOD/message/tpl/form/scheduling.tpl"}

{include file="$PATH_TPL_MOD/message/tpl/form/misc.tpl"}

{include file="$PATH_TPL_MOD/message/tpl/form/test.tpl"}


{include file="$PATH_TPL_MOD/message/tpl/form/buttons.tpl"}
</form>
