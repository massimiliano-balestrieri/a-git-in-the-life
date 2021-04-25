	</div><!--contentcolumn-->
</div><!--contentwrapper-->

<div id="rightcolumn">
	{if isset($MENU)}
	<ul class="ulmenu">
		{foreach item=li from=$MENU}
		{$li}
		{/foreach}
	</ul>
	{/if}
	<!--temp-->
	{include file="$PATH_TPL/inc/switcher.tpl"}
	<!--temp-->
	
</div><!--rightcolumn-->


