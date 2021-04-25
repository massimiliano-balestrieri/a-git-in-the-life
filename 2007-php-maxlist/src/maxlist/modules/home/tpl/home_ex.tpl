{include file="$PATH_TPL/inc/head_view.tpl"}
<!-- home.tpl -->
{if $tpl_system_functions}
<h4>{tz}System_Functions{/tz}</h4>
<div class="ml_panel ml_panel_1">
	<dl>	
	{if $tpl_eventlog}
	<dt><a href="{$BO}eventlog">{tz}eventlog{/tz}</a></dt>
	<dd>{tz}eventlog_desc{/tz}</dd>
	{/if}
	{if $tpl_admin}
	<dt><a href="{$BO}admin/edit/{$USERID}">{tz}profile{/tz}</a></dt>
	<dd>{tz}admin_desc{/tz}</dd>
	{/if}	
	</dl>
</div><!--panel-->
{/if}

{if $tpl_config_functions}
<h4>{tz}Configuration_functions{/tz}</h4>
<div class="ml_panel ml_panel_1">
	<dl>	
	
	{if $tpl_configure}
	<dt><a href="{$BO}configure">{tz}configure{/tz}</a></dt>
	<dd>{tz}configure{/tz} {$NAME}</dd>
	{/if}
	</dl>
</div><!--panel-->
{/if}

{if $tpl_listsusers_functions}
<h4>{tz}List_and_user_functions{/tz}</h4>
<div class="ml_panel ml_panel_1">
	<dl>	
	
	{if $tpl_lists}
	<dt><a href="{$BO}list">{tz}list{/tz}</a></dt>
	<dd>{tz}list_desc{/tz}</dd>
	{/if}
	{if $tpl_users}
	<dt><a href="{$BO}user">{tz}users{/tz}</a></dt>
	<dd>{tz}users_desc{/tz}</dd>
	{/if}
	{if $tpl_attributes}
	<dt><a href="{$BO}attribute/user">{tz}attributes{/tz}</a></dt>
	<dd>{tz}attributes_desc{/tz}</dd>
	{/if}
	{if $tpl_import}
	<dt><a href="{$BO}import">{tz}import{/tz}</a></dt>
	<dd>{tz}import_desc{/tz}</dd>
	{/if}
	{if $tpl_export}
	<dt><a href="{$BO}export">{tz}export{/tz}</a></dt>
	<dd>{tz}export_desc{/tz}</dd>
	{/if}
	</dl>
</div><!--panel-->
{/if}

{if $tpl_admins_functions}
<h4>{tz}Administrator_functions{/tz}</h4>
<div class="ml_panel ml_panel_1">
	<dl>	
	{if $tpl_admins}
	<dt><a href="{$BO}admin">{tz}admins{/tz}</a></dt>
	<dd>{tz}admins_desc{/tz}</dd>
	{/if}
	</dl>
</div><!--panel-->
{/if}

{if $tpl_msg_functions}
<h4>{tz}Message_functions{/tz}</h4>
<div class="ml_panel ml_panel_1">
	<dl>	
	{if $tpl_send}
	<dt><a href="{$BO}message/create">{tz}send{/tz}</a></dt>
	<dd>{tz}send_desc{/tz}</dd>
	{/if}
	{if $tpl_templates}
	<dt><a href="{$BO}template">{tz}templates{/tz}</a></dt>
	<dd>{tz}templates_desc{/tz}</dd>
	{/if}
	{if $tpl_messages}
	<dt><a href="{$BO}message">{tz}messages{/tz}</a></dt>
	<dd>{tz}messages_desc{/tz}</dd>
	{/if}
	{if $tpl_processqueue}
	<dt><a href="{$BO}process/queue">{tz}process_queue{/tz}</a></dt>
	<dd>{tz}processqueue_desc{/tz}</dd>
	{/if}
	{if $tpl_processbounces}
	<dt><a href="{$BO}process/bounces">{tz}process_bounces{/tz}</a></dt>
	<dd>{tz}processbounces_desc{/tz}</dd>
	{/if}
	{if $tpl_bounces}
	<dt><a href="{$BO}bounces">{tz}bounces{/tz}</a></dt>
	<dd>{tz}view_bounces{/tz}</dd>
	{/if}
	{if $tpl_statistics}
	<dt><a href="{$BO}statistic">{tz}statistics{/tz}</a></dt>
	<dd>{tz}statistics_desc{/tz}</dd>
	{/if}
	</dl>
</div><!--panel-->
{/if}