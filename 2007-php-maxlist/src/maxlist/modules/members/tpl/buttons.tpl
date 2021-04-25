	<!--if $login.role == 1 || $login.role == 2 || $login.role == 3 -->
	<div class="ml_container_buttons">
			<a href="{$BO}user/create/{$tpl_idlist}" class="ml_button">aggiungi</a>
	 		<a href="{$BO}import/user/{$tpl_idlist}" class="ml_button">{tz}import{/tz}</a>
			{if sizeof($tpl_list_users)>0}
			<a href="{$BO}export/user/{$tpl_idlist}" class="ml_button">{tz}downcvs{/tz}</a>
			{/if}
			{if sizeof($tpl_list_users)>0}
				<!--if $login.role == 1 || $login.role == 2-->
				<a href="javascript:checkAll();" class="ml_button">{tz}tagall{/tz}</a>
				<a href="javascript:uncheckAll();" class="ml_button">{tz}untagall{/tz}</a>
				<!--/if-->
			{/if}
	</div>
	<!--/if-->