{include file="$PATH_TPL/inc/head_view.tpl"}
<!-- users.tpl -->
<h4>{tz}Search{/tz}</h4>
<form id="form_search" method="post" action="#">
{if $REQUEST.search}
<div class="ml_panel ml_panel_1">
{else}
<div class="ml_panel ml_panel_0">
{/if}
<table class="ml_tbl_row_med">
	<tr>
		<th scope="row">
		<label for="find">{tz}finduser{/tz}</label>
		</th>
		<td>
		<input type="text" name="find" id="find" class="ml_input_medium" value="{$POST.find}" />
		</td>
		<td>
		<select class="ml_small" name="findby" id="findby">
		{foreach item=find from=$tpl_select_findby}
		<option>{$find}</option>
		{/foreach} 
		</select>
		</td>
	</tr>
	<tr>
		<th><label for="unconfirmed">{tz}Show_unconfirmed{/tz}</label></th>
		<td><input type="checkbox" name="unconfirmed" id="unconfirmed" value="1" {$tpl_checked.unconfirmed}/></td>
	</tr>
	<tr>
		<th><label for="blacklisted">{tz}Show_blacklisted{/tz}</label></th>
		<td><input type="checkbox" name="blacklisted" id="blacklisted" value="1" {$tpl_checked.blacklisted}/></td>
	</tr>
	<tr>
		<th><label for="sortby">Ordinato per:</label></th>
		<td colspan="2">
			<select name="sortby" id="sortby" class="ml_input_medium">
			<option value="0">--default--</option>
			{foreach item=sortv key=sortk from=$tpl_select_sortby}
			{if $REQUEST.sortby == $sortv}
			<option value="{$sortk}" selected="selected">{$sortv}</option>
			{else}
			<option value="{$sortk}">{$sortv}</option>
			{/if}
			{/foreach} 
			</select>
			<span class="ml_ordina">
			<input type="radio" name="sortorder" value="asc" id="sortby_disc" {$tpl_checked.asc}/>&nbsp;
			<label for="sortby_disc">{tz}asc{/tz}</label>&nbsp;
			<input type="radio" name="sortorder" value="desc" id="sortby_asc" {$tpl_checked.desc}/>&nbsp;
			<label for="sortby_asc">{tz}desc{/tz}</label></span>
		</td>
	</tr>
</table>
	
	<div class="ml_container_buttons">
		<div class="ml_buttons_sx">
			<input type="hidden" name="pg" value="{$POST.pg}" />
			<input type="hidden" name="block" value="{$POST.block}" />
			<input name="reset" type="reset" value="{tz}reset{/tz}" class="ml_button reset" />
		</div>
		<div class="ml_buttons_dx">
			<input name="search" type="submit" value="{tz}go{/tz}" class="ml_button" />
		</div>
	</div>
</div>
</form>


<h4>{tz}users{/tz}</h4>
	
<div class="ml_panel ml_panel_1" id="ml_users">
	{if $ACTION == "delete"}
	<form id="form_confirm" method="post" action="#">
		<div class="ml_msg">
			<p>{tz}sure_delete_user{/tz}</p>
		</div>
	
			<div class="ml_container_buttons">
				<div class="ml_buttons_sx">			
					<input type="submit" name="confirm" value="{tz}no{/tz}" class="ml_button" />
				</div>
				<div class="ml_buttons_dx">
					<input type="hidden" name="delete" value="{$ID}" />
					<input type="hidden" name="do" value="remove" />
					<input type="submit" name="confirm" value="{tz}yes{/tz}" class="ml_button" />
				</div>
			</div>
		
		
	</form>
	{/if}
	{if sizeof($tpl_list_users)>0}
	{include file="$PATH_TPL/inc/paging.tpl"}
	<div class="ml_scroll">
	<table class="ml_col">
		<tr>
			<th scope="col">{tz}users{/tz}</th>
			<th scope="col"><abbr title="{tz}conf{/tz}">{tz}conf{/tz}</abbr></th>
			<th scope="col"><abbr title="{tz}blacklist_col{/tz}">{tz}blacklist_col{/tz}</abbr></th>
			<th scope="col">{tz}lists{/tz}</th>
			<th scope="col">{tz}msgs{/tz}</th>
			<th scope="col">{tz}bncs{/tz}</th>				
			<th scope="col">&nbsp;</th>
		</tr>
		{foreach item=user from=$tpl_list_users}
		<tr>
			<td><a href="{$BO}user/edit/{$user.id}">{$user.email|truncate:30:"..."}</a></td>
			<td><img src="{if $user.confirmed}{$tpl_config.URL_IMG_YES}{else}{$tpl_config.URL_IMG_NO}{/if}" alt="" title=""  /></td>
			<td><img src="{if !$user.blacklist}{$tpl_config.URL_IMG_YES}{else}{$tpl_config.URL_IMG_NO}{/if}" alt="" title=""  /></td>
			<td>{$lists[$user.id]}</td>
			<td>{$nummsg[$user.id]}</td>
			<td>{$user.bouncecount}</td>
			<!--if $user.is_writable -->
   		    <td><a href="{$BO}user/delete/{$user.id}">{tz}delete{/tz}</a></td>
			<!--else 
			<td>&nbsp;</td>-->
			<!-- if-->
         </tr>
		{/foreach}
	</table>
	</div>
	{include file="$PATH_TPL/inc/paging.tpl"}
	{/if}
	<!--if $login>4 -->
   		 <div class="ml_container_buttons">
			<div class="ml_container_buttons">
				<!--$login.role == 1 || $login.role == 2-->
				<a href="{$BO}user/create" class="ml_button">{tz}add{/tz}</a>
   				<!-- if-->
				{if sizeof($tpl_list_users)>0}
				<a href="{$BO}export" class="ml_button">{tz}downloadcvs{/tz}</a>
				{/if}
				<!-- if-->
				<!--$login.role == 1 || $login.role == 2 -->
				<a href="{$BO}import" class="ml_button">{tz}import{/tz}</a>
				<!-- if-->
			</div>
		</div>
	<!-- if-->
</div><!-- /panel -->

