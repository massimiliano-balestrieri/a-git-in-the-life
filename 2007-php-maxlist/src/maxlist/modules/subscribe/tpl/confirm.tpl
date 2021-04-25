{include file="$PATH_TPL/inc/head_fo.tpl"}
<h4>{tz}lists{/tz}</h4>
<div class="ml_open">
{if sizeof($list_confirm)>0}
<ul>
{foreach item=list from=$list_confirm}
	<li>{$list}</li>
{/foreach}
</ul>
{/if}
</div>
