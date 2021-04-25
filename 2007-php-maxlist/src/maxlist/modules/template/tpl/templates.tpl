{include file="$PATH_TPL/inc/head_view.tpl"}
<!-- templates.tpl -->
<h4>{tz}templates{/tz}</h4>

<div class="ml_panel ml_panel_1">
	{if $ACTION == "delete"}
	<form id="form_confirm" method="post" action="#">
	<div class="ml_msg">
		<p>{tz}sure_delete{/tz}</p>
	</div>
		<div class="ml_container_buttons">
			<div class="ml_buttons_sx">
				<input type="submit" name="confirm" value="{tz}no{/tz}" class="ml_button" />
			</div>
			<div class="ml_buttons_dx">
				<input type="hidden" name="delete" value="{$ID}" />
				<input type="hidden" name="do" value="{$DO}" />				
				<input type="submit" name="confirm" value="{tz}yes{/tz}" class="ml_button" />
			</div>
		</div>
	</form>
	{/if}
	<form method="post" action="#">
	{if sizeof($tpl_templates)>0}
	<table class="ml_col">
	<tr>
		<th scope="col">&nbsp;</th>			
		<th scope="col">ID</th>
		<th scope="col" style="width:400px;">{tz}title{/tz}</th>
		<th scope="col" style="width:50px;">{tz}default{/tz}</th>
	</tr>
	{foreach from=$tpl_templates item="template"}
	<tr>
	  <td><input name="template[id]" type="radio" id="id_{$template.id}" class="ml_noBorder" value="{$template.id}" />&nbsp;</td>
	  <td><a href="#">{$template.id}</a></td>
	  <td>{$template.title}</td>
	  <td>{if $tpl_default == $template.id}<img src="{$tpl_config.URL_IMG_YES}" alt="" />{else}<img src="{$tpl_config.URL_IMG_NO}" alt="" />{/if}</td>
	</tr>
	{/foreach}
	</table>

	<div class="ml_container_buttons">
		<input name="do" type="submit" value="default" class="ml_button" />
		<input name="do" type="submit" value="{tz}new{/tz}" class="ml_button" />
		<input name="do" type="submit" value="{tz}edit{/tz}" class="ml_button" />
		<input name="do" type="submit" value="{tz}delete{/tz}" class="ml_button" />
	</div>
{else}
	<p>{$tpl_lbl_messages.notpl}</p>
	<div class="ml_container_buttons">
		<input name="do" type="submit" value="{tz}create{/tz}" class="ml_button" />
	</div>
{/if}	

	<div class="ml_container_buttons">
		<div class="ml_buttons_dx">
		</div>
	</div>
    </form>
</div><!--/contenuti-->