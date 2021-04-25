{include file="$PATH_TPL/inc/head_view.tpl"}
{include file="$PATH_TPL/inc/debug.tpl"}
<!-- spagedit.tpl -->

<h4 class="open">Help</h4>

<div class="ml_open">
<p>{$tpl_info}</p>
</div><!--panel-->

<form method="post" action="#">

<h4 class="oneByone" id="spagedit">{$tpl_lbl_messages.title}</h4> 
	
	<div class="ml_panel ml_panel_1" id="ml_spagedit">
	<table class="ml_tbl_row_small">	
		<tr>
			<th scope="row"><label for="title">{$tpl_th.title}</label></th>
			<td><input type="text" name="title"  id="title" class="ml_input_medium" value="{$tpl_data.title}" /></td>
		</tr>		
		<tr>
			<th scope="row"><label for="owner">{$tpl_th.owner}</label></th>
			<td>
			<select name="owner" id="owner" class="ml_input_medium">
			{foreach from=$tpl_admins item="admin" key="id_admin"}
			{if $id_admin == $tpl_data.owner}
			<option value="{$id_admin}" selected="selected">{$admin}</option>
			{else}
			<option value="{$id_admin}">{$admin}</option>			
			{/if}
			{/foreach}
			</select>
			</td>
		</tr>		
	</table>
</div><!--panel-->

<h4 class="oneByone" id="spageditIntro">{$tpl_th.intro}</h4> 
	
	<div class="ml_panel ml_panel_0" id="ml_spageditIntro">
	<table class="ml_tbl_row_small">	
		<tr>
			<th scope="row"><label for="intro">{$tpl_th.intro}</label></th>
			<td>
			<textarea name="intro"  id="intro" cols="55" rows="20">{$tpl_data.intro}</textarea>
			</td>
		</tr>		
	</table>
</div><!--panel-->

<h4 class="oneByone" id="spageditHeader">{$tpl_th.header}</h4> 
	
	<div class="ml_panel ml_panel_0" id="ml_spageditHeader">
	<table class="ml_tbl_row_small">	
		<tr>
			<th scope="row"><label for="header">{$tpl_th.header}</label></th>
			<td>
			<textarea name="header" id="header" cols="55" rows="20">{$tpl_data.header}</textarea>
			</td>
		</tr>		
	</table>
</div><!--panel-->

<h4 class="oneByone" id="spageditFooter">{$tpl_th.footer}</h4> 
	
	<div class="ml_panel ml_panel_0" id="ml_spageditFooter">
	<table class="ml_tbl_row_small">	
		<tr>
			<th scope="row"><label for="footer">{$tpl_th.footer}</label></th>
			<td>
			<textarea name="footer" id="footer" cols="55" rows="20">{$tpl_data.footer}</textarea>
			</td>
		</tr>		
	</table>
</div><!--panel-->

<h4 class="oneByone" id="spageditThankyou">{$tpl_th.thankyou}</h4> 
	
	<div class="ml_panel ml_panel_0" id="ml_spageditThankyou">
	<table class="ml_tbl_row_small">	
		<tr>
			<th scope="row"><label for="thankyoupage">{$tpl_th.thankyou}</label></th>
			<td>
			<textarea name="thankyoupage" id="thankyoupage" cols="55" rows="20">{$tpl_data.thankyoupage}</textarea>
			</td>
		</tr>		
	</table>
</div><!--panel-->

<h4 class="oneByone" id="spageditMisc">{$tpl_lbl_messages.misc}</h4> 
	
	<div class="ml_panel ml_panel_0" id="ml_spageditMisc">
	<table class="ml_tbl_row_small">	
		<tr>
			<th scope="row"><label for="button">{$tpl_th.textbutton}</label></th>
			<td><input type="text" name="button"  id="button" class="ml_input_medium" value="{$tpl_data.button}" /></td>
		</tr>		
		<tr>
			<th scope="row"><label for="destinatariList">{$tpl_th.htmlchoice}</label></th>
			<td>
			<input type="radio" name="htmlchoice" id="textonly" value="textonly" {$tpl_checked.textonly}/>&nbsp;<label for="textonly">{$tpl_th.deftext}</label><br />
			<input type="radio" name="htmlchoice" id="htmlonly" value="htmlonly" {$tpl_checked.htmlonly}/>&nbsp;<label for="htmlonly">{$tpl_th.defhtml}</label><br />
			<input type="radio" name="htmlchoice" id="checkfortext" value="checkfortext" {$tpl_checked.checkfortext}/>&nbsp;<label for="checkfortext">{$tpl_th.offertext}</label><br />
			<input type="radio" name="htmlchoice" id="checkforhtml" value="checkforhtml" {$tpl_checked.radiotext}/>&nbsp;<label for="checkforhtml">{$tpl_th.offerhtml}</label><br />
			<input type="radio" name="htmlchoice" id="radiotext" value="radiotext" {$tpl_checked.radiotext}/>&nbsp;<label for="radiotext">{$tpl_th.radiotext}</label><br />
			<input type="radio" name="htmlchoice" id="radiohtml" value="radiohtml" {$tpl_checked.radiohtml}/>&nbsp;<label for="radiohtml">{$tpl_th.radiohtml}</label><br />
			</td>
		</tr>		
		<tr>
			<th scope="row"><label for="destinatariList">{$tpl_th.dispConf}</label></th>
			<td>
				<input type="radio" name="emaildoubleentry" id="dispconf" value="yes" {$tpl_checked.emaildoubleentryY}/>&nbsp;<label for="dispconf">{$tpl_th.dispconf}</label><br />
				<input type="radio" name="emaildoubleentry" id="nodispconf" value="no" {$tpl_checked.emaildoubleentryN}/>&nbsp;<label for="nodispconf">{$tpl_th.nodispconf}</label><br />
			</td>
		</tr>		
	</table>
</div><!--panel-->

<h4 class="oneByone" id="spagedit_msgsubscribe">{$tpl_lbl_messages.msgsubscribe}</h4> 
	
	<div class="ml_panel ml_panel_0" id="ml_spagedit_msgsubscribe">
	<table class="ml_tbl_row_small">	
		<tr>
			<th scope="row"><label for="subscribesubject">{$tpl_th.subject}</label></th>
			<td><input type="text" name="subscribesubject"  id="subscribesubject" class="ml_input_medium" value="{$tpl_data.subscribesubject}" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="subscribemessage">{$tpl_th.message}</label></th>
			<td>
			<textarea name="subscribemessage" id="subscribemessage" cols="55" rows="20">{$tpl_data.subscribemessage}</textarea>
			</td>
		</tr>		
	</table>
</div><!--panel-->

<h4 class="oneByone" id="spagedit_msgconfirm">{$tpl_lbl_messages.msgconfirm}</h4> 
	
	<div class="ml_panel ml_panel_0" id="ml_spagedit_msgconfirm">
	<table class="ml_tbl_row_small">	
		<tr>
			<th scope="row"><label for="confirmationsubject">{$tpl_th.subject}</label></th>
			<td><input type="text" name="confirmationsubject"  id="confirmationsubject" class="ml_input_medium" value="{$tpl_data.confirmationsubject}" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="confirmationmessage">{$tpl_th.message}</label></th>
			<td>
			<textarea name="confirmationmessage" id="confirmationmessage" cols="55" rows="20">{$tpl_data.confirmationmessage}</textarea>
			</td>
		</tr>		
	</table>
</div><!--panel-->

<h4  class="oneByone" id="spagedit_attributes">{$tpl_lbl_messages.selectattribute}</h4> 

<div class="ml_panel ml_panel_0" id="ml_spagedit_attributes">

<table class="ml_col" summary="scelta degli attributi">
<tr>
<td class="radio"></td>
<th>attributo</th>
<th>tipologia</th>
</tr>
		{foreach item=attr from=$tpl_attrs}		
		<tr>
		<td>
		<input type="hidden" name="attr_required[{$attr.id}]" value="{$attr.required}" />
		<input type="hidden" name="attr_listorder[{$attr.id}]" value="{$attr.order}" />
		<input type="hidden" name="attr_default[{$attr.id}]" value="{$attr.default}" />
		<input type="checkbox" name="attr[{$attr.id}]" id="attr_{$attr.id}" {$attr.checked}/>		
		</td>
		<td><label for="attr_{$attr.id}">{$attr.name}</label></td>
		<td>{$attr.strtype}</td>
		</tr>
		{/foreach}
</table>
</div>

<h4  class="oneByone" id="spagedit_lists">{$tpl_lbl_messages.lists}</h4> 

<div class="ml_panel ml_panel_0" id="ml_spagedit_lists">
<table class="ml_tbl_row_small" summary="scelta delle liste">
		<tr>
		<th scope="row"><label for="MailLists_All">{$tpl_lbl_messages.alllists}</label></th>
		<td>
		<input type="checkbox" name="targetlist[all]" id="MailLists_All" {$tpl_checked.alllists}/>&nbsp;
		</td>
		</tr>
		{foreach item=list from=$tpl_lists}		
		<tr>
		<th scope="row"><label for="MailLists_{$list.id}">{$list.name}</label></th>
		<td>
		<input type="checkbox" name="targetlist[{$list.id}]" id="MailLists_{$list.id}" {$list.checked}/>&nbsp;
		<span>
		<a href="#" title="modifica la lista di sviluppo">{$list.desc}</a>
		{if $list.active == 1}
		({$tpl_lbl_messages.listactive})
		{else}
		({$tpl_lbl_messages.listnotactive})		
		{/if}
		</span>
		</td>
		</tr>
		{/foreach}
</table>
</div>

<h4 id="spagedit_save">{$tpl_lbl_action.save}</h4> 

<div class="ml_panel ml_panel_1" id="ml_spagedit_save">
	<div class="ml_container_buttons">
		<input type="hidden" name="view" value="spagedit" />
		<input type="submit" name="save" class="puls" value="{$tpl_lbl_action.save}" />
		<input type="submit" name="test" class="ml_p155" value="{$tpl_lbl_action.saveactive}" onmouseover="javascript:overOutHandler(this, 'ml_p155Hover');" onmouseout="javascript:overOutHandler(this, 'ml_p155');" />
		<input type="submit" name="test" class="ml_p155" value="{$tpl_lbl_action.savedeactive}" onmouseover="javascript:overOutHandler(this, 'ml_p155Hover');" onmouseout="javascript:overOutHandler(this, 'ml_p155');" />
	</div>
</div>

</form>