{include file="$PATH_TPL/inc/head_view.tpl"}

{if sizeof($tpl_msg_list)>0}
<h4>{tz}messages{/tz} : 
<strong class="ml_oggetto">{$tpl_user.email}</strong></h4> 

<div class="ml_panel ml_panel_1">
<p class="ml_note">{$tpl_num_msg} {tz}nummsg{/tz}</p>
<table class="ml_col">
<tr>
		<th scope="col">{tz}Messages{/tz}</th>
		{if $tpl_config.CLICKTRACK}
		<th scope="col">{tz}clicks{/tz}</th>
		{/if}
		<th scope="col">{tz}sent{/tz} <span class="ml_formato">(data - ora)</span></th>
		{if $tpl_avgresp}
		<th scope="col">{tz}viewed{/tz} <span class="ml_formato">(data - ora)</span></th>
		<th scope="col">{tz}responsetime{/tz}</th>
		{/if}
		<th scope="col">{tz}bounce{/tz}</th>
		</tr>
		{foreach from=$tpl_msg_list item=msg}
		<tr>
		  <td>{$msg.messageid}&nbsp; - &nbsp; <a href="{$BO}message/view/{$msg.id}" title="dettagli messaggio">report</a></td>
		  {if $tpl_config.CLICKTRACK}
		  <td><a href="{$BO}userclicks/{$msg.id}">{$msg.clicks}</a></td>
		  {/if}
		  <td>{$msg.sent}</td>
		  {if $tpl_avgresp}
		  <td>{$msg.viewed}</td>
		  <td>{$msg.responsetime}</td>
		  {/if}
		  <td>{$msg.bounce}</td>
		</tr>
		{/foreach}
		{if $tpl_avgresp}
		<tr>
			 <td colspan="0"><strong>{tz}average{/tz} {tz}responsetime{/tz}: {$tpl_avgresp}</strong></td>
		</tr>
		{/if}
		</table>
</div><!-- /contenuti -->
{/if}

{if sizeof($tpl_bounces_list)>0}
<h4>{tz}Bounces{/tz} : <strong class="ml_oggetto">{$tpl_user.email}</strong></h4> 

<div class="ml_panel ml_panel_1">

<table class="ml_col">
<tr>
<th scope="col">{tz}bounce{/tz}</th>
<th scope="col">{tz}msg{/tz}</th>
<th scope="col">{tz}bouncetime{/tz}</th>
</tr>
{foreach from=$tpl_bounces_list item=bounce}
<tr>
  <td>{$bounce.id}&nbsp; - &nbsp; <a href="?view=bounce&amp;id={$bounce.id}" title="dettagli bounce">{tz}bounce{/tz}</a></td>
  <td>{$bounce.msg}</td>
  <td>{$bounce.time}</td>
</tr>
{/foreach}
</table>
</div><!-- /contenuti -->
{/if}

{if $tpl_bl_flag}
<h4>{tz}blinfo{/tz} : <strong class="ml_oggetto">{$tpl_user.email}</strong></h4>

<div class="ml_panel ml_panel_1">
{if $ACTION == "unblacklist"}
	<form id="form_confirm" method="post" action="#">
		<div class="ml_msg">
			<p>{tz}sure_unblacklist_user{/tz}</p>
		</div>
	
			<div class="ml_container_buttons">
				<div class="ml_buttons_sx">			
					<input type="submit" name="confirm" value="{tz}no{/tz}" class="ml_button" />
				</div>
				<div class="ml_buttons_dx">
					<input type="hidden" name="unblacklist" value="{$ID}" />
					<input type="hidden" name="do" value="do_unblacklist" />
					<input type="submit" name="confirm" value="{tz}yes{/tz}" class="ml_button" />
				</div>
			</div>
		
		
	</form>
{/if}
<p><strong>{tz}userbl{/tz} : {$tpl_bl_info.added}</strong> - <a href="{$BO}history/unblacklist/{$tpl_user.id}">{tz}delbl{/tz}</a></p>
<table class="ml_col" summary="">
<tr>
<th scope="col">{tz}blinfo{/tz}</th>
<th scope="col">{tz}value{/tz}</th>
</tr>
{foreach from=$tpl_bl_list item=blist}
<tr>
	<td>{$I18N[$blist.name]}</td>
	<td>{$blist.data}</td>
</tr>
{/foreach}
</table>
</div>
{/if}

<h4>{tz}user_subhist{/tz} : <strong class="ml_oggetto">{$tpl_user.email}</strong></h4>

<div class="ml_panel ml_panel_0">

<table class="ml_col">

{foreach from=$tpl_sub_list item=sub}
<tr>
<td>&nbsp;</td>
<th scope="col">{tz}subhist{/tz}</th>
<th scope="col">{tz}ip{/tz}</th>
<th scope="col">{tz}date{/tz}</th>
<th scope="col">{tz}summary{/tz}</th>
</tr>
<tr>
  <th scope="row">&nbsp;</th>
  <td>{$sub.id}</td>
  <td>{$sub.ip}</td>
  <td>{$sub.date}</td>
  <td>{$sub.summary}</td>
</tr>
<tr>
		<th scope="row">{tz}detail{/tz}</th>
		<td colspan="4">{$sub.detail|nl2br}</td>
</tr>
<tr>
		<th scope="row">{tz}info{/tz}</th>
		<td colspan="4">{$sub.systeminfo|truncate:250:"---"|nl2br}</td>
</tr>
{/foreach}
</table>
		<div class="ml_container_buttons">
			<div class="ml_buttons_sx">
				<form method="post" action="#">
					<input type="submit" name="back" id="annulla" class="ml_button" value="indietro" />
				</form>
			</div>
		</div>
</div><!-- /panel -->