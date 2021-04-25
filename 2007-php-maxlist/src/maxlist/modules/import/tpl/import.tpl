{include file="$PATH_TPL/inc/head_view.tpl"}
<!-- import.tpl -->
<form id="form_importadmin" enctype="multipart/form-data" method="post" action="#">
{if isset($tpl_test)}
<h4>Test</h4>
<div class="ml_panel ml_panel_1">
{$tpl_test}
</div><!--panel-->
{/if}

{if $tpl_test_import}
<div>
	<h4>{$tpl_lbl_messages.testimport}</h4> 
	
	<div class="ml_panel ml_panel_1">
	<p>{$tpl_lbl_messages.reading}</p>
	<p>{$tpl_lbl_messages.lines_read}</p>
	<p>{$tpl_lbl_messages.lines_will}</p>
	<p>{$tpl_test_html}</p>
	<p>{$tpl_lbl_messages.esito}</p>
	
		<div class="ml_container_buttons">
		<div class="ml_buttons_sx">
			<input type="submit" name="confirm" id="inp_save" class="ml_button" value="{$tpl_lbl_action.confirm}" />
		</div>
		</div>
	</div><!--/panel-->
</div><!--/container-->
{/if}

{if $tpl_result_import}
<div>
	<h4>{$tpl_lbl_messages.testimport}</h4> 
	<div class="ml_panel ml_panel_1">
	<p>{$tpl_result_html}</p>
	</div><!--/panel-->
</div><!--/container-->
{/if}

<h4>1. Seleziona il file contenente le email degli utenti da importare</h4> 

<div class="ml_panel ml_panel_1">
	<p>{$tpl_lbl_messages.importintro}</p>
	<p>{$tpl_lbl_messages.infoupload}</p>
	<p>{$tpl_lbl_messages.sendnotification_blurb}</p>
	
	<table class="ml_tabRow">	
		
		<tr>
			<th scope="row"><label for="import_file">{$tpl_lbl_messages.file}:  </label></th>
			<td><input type="file" name="import_file"  id="import_file" class="ml_input_medium" /></td>
		</tr>		

		<tr>
			<th scope="row"><label for="import_field_delimiter">{$tpl_lbl_messages.fieldlimit}:  </label></th>
			<td><input type="text" name="import_field_delimiter"  id="import_field_delimiter" class="ml_small" value="{$tpl_POST.import_field_delimiter}" /> <br />{$tpl_lbl_messages.deftab}</td>
		</tr>		
		<tr>
			<th scope="row"><label for="delimitatoreRecord">{$tpl_lbl_messages.recordlimit}:  </label></th>
			<td><input type="text" name="import_record_delimiter"  id="import_record_delimiter" class="ml_small" value="{$tpl_POST.import_record_delimiter}" /> <br />{$tpl_lbl_messages.deflinebreak}</td>
		</tr>		
		<tr>
			<th scope="row"><label for="show_warnings">{$tpl_lbl_messages.ShowWarnings}:  </label></th>
			<td>
			<input name="show_warnings" type="checkbox"  id="show_warnings" class="ml_check" value="yes" {$tpl_checked.show_warnings}/><br />
			{$tpl_lbl_messages.warnings_blurb}
			</td>
		</tr>		
		<tr>
			<th scope="row"><label for="omit_invalid">{$tpl_lbl_messages.OmitInvalid}:  </label></th>
			<td>
			<input name="omit_invalid" type="checkbox"  id="omit_invalid" class="ml_check" value="yes" {$tpl_checked.omit_invalid}/><br />
			{$tpl_lbl_messages.omitinvalid_blurb}
			</td>
		</tr>		
		<tr>
			<th scope="row"><label for="assign_invalid">{$tpl_lbl_messages.AssignInvalid}:  </label></th>
			<td>
			<input name="assign_invalid" type="checkbox"  id="assign_invalid" class="ml_check" value="yes" {$tpl_checked.assign_invalid}/><br />
			{$tpl_lbl_messages.assigninvalid_blurb}
			</td>
		</tr>		
		<tr>
			<th scope="row"><label for="overwrite">{$tpl_lbl_messages.OverwriteExisting}:  </label></th>
			<td>
			<input name="overwrite" type="checkbox"  id="overwrite" class="ml_check" value="yes" {$tpl_checked.overwrite}/><br />
			{$tpl_lbl_messages.overwriteexisting_blurb}
			</td>
		</tr>		
		<tr>
			<th scope="row"><label for="retainold">{$tpl_lbl_messages.RetainOldUserEmail}:  </label></th>
			<td>
			<input name="retainold" type="checkbox"  id="retainold" class="ml_check" value="yes" {$tpl_checked.retainold}/><br />
			{$tpl_lbl_messages.retainold_blurb}
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="notify">{$tpl_lbl_messages.SendNotificationemail}:  </label></th>
			<td>
			<input name="notify" type="radio"  id="notify_yes" value="yes" {$tpl_checked.notify_yes} />
			</td>
		</tr>		
		<tr>
			<th scope="row"><label for="notify_no">{$tpl_lbl_messages.Makeconfirmedimmediately}:  </label></th>
			<td>
			<input name="notify" type="radio"  id="notify_no" value="no" {$tpl_checked.notify_no} />
			</td>
		</tr>
	</table>
</div><!--panel-->


<div>
	<h4>{$tpl_lbl_messages.selectlist}</h4> 
	<div class="ml_open">
		<dl>
			{foreach from=$tpl_lists item="list"}
			<dt>		
			 <input type="hidden" name="listname[{$list.cnt}]" id="listname_{$list.cnt}" value="{$list.name}" />
			 <input type="checkbox" name="lists[{$list.cnt}]" id="lists_{$list.cnt}" value="{$list.id}" {$list.checked}/>&nbsp;
			 <label for="list_{$list.id}">{$list.name}</label>
			</dt>
			<dd>{$list.desc}</dd>
			{/foreach}
		</dl>
		
		<div class="ml_container_buttons">
			<div class="ml_buttons_sx">
				<input type="reset" name="reset" id="reset" class="ml_button" value="{tz}reset{/tz}" />
			</div>
			<div class="ml_buttons_dx">
				<input type="hidden" name="do" id="do" value="userimport" />
				<input type="submit" name="confirm" id="confirm" class="ml_button" value="{tz}import{/tz}" />
			</div>
		</div>

	</div><!--/panel-->
</div><!--/container-->
</form>