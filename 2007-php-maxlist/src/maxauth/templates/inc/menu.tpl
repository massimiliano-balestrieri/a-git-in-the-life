	</div><!--contentcolumn-->
</div><!--contentwrapper-->

<div id="rightcolumn">
	<ul class="ulmenu">
			{if isset($mymenu)}
			{foreach item=menu from=$mymenu}
			{if $istance == $menu.istance}
			<li class="attivo"><span>{$menu.istance}</span></li>
			{else}
			<li><a href="?istance={$menu.istance}">{$menu.istance}</a></li>
			{/if}
			{/foreach}
			{/if}
	</ul>
</div><!--rightcolumn-->