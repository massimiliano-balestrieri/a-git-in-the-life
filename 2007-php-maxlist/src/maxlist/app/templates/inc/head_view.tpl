<!-- head.tpl -->
<div id="container_head">
<h2>MAXLIST {$VERSION} - {$page_title}</h2>
{if $VIEW_APP_UTENTE && $login.role > 0}
<h2>Utente: <strong>{$username}</strong><span id="logout">{$logout}</span></h2>
{/if}
</div>
{include file="$PATH_TPL/inc/debug.tpl"}
{include file="$PATH_TPL/inc/msg.tpl"}
{include file="$PATH_TPL/inc/help.tpl"}