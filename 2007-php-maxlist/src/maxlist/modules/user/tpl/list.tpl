<h4>{tz}lists{/tz}</h4> 
<div class="ml_panel ml_panel_1">
		{if sizeof($POST) && (sizeof($subscribe) == 0 || sizeof($lists)==0 || $user.blacklisted)}
		<div class="ml_msg_ko">
		{if !$subscribe}
		{tz}selectlists{/tz}
		{/if}
		{if sizeof($lists)==0}
		{tz}No_List{/tz}
		{/if}
		{if $user.blacklisted}
		{tz}is_black_list{/tz}
		{/if}
		</div>
		{/if}
		
		{if is_array($lists)}
		{tz}selectlists{/tz} &nbsp; {$errors.subscribe.img}:
		<dl>		
			{foreach from=$lists item=list}
			<dt><input type="checkbox" name="subscribe[{$list.id}]" id="subscribe_{$list.id}" value="{$list.id}" {if array_key_exists($list.id,$subscribe)} checked="checked"{/if}/>&nbsp;
			<label for="subscribe_{$list.id}">
				<span>{$list.name}</span>
			</label></dt>
			<dd>{$list.description}</dd>
			{/foreach}
		</dl>
		

		{/if}
</div><!--/panel-->