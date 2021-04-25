{include file="$PATH_TPL/inc/head_view.tpl"}
{include file="$PATH_TPL/inc/debug.tpl"}
<!-- importadmin.tpl -->
{if isset($tpl_test)}
<h4 id="test">Test</h4>
<span class="ml_h3Bottom">&nbsp;</span>
<div class="ml_panel ml_panel_1" id="ml_test">
{$tpl_test}
</div><!--panel-->
{/if}

<h4 id="importAdminForm">{$page_title}</h4> 

<div class="ml_panel ml_panel_1" id="ml_importAdminForm">
<p>{$tpl_lbl_messages.info}</p>
  <p>{$tpl_lbl_messages.testinfo}</p>
    <form id="form_importadmin" enctype="multipart/form-data" method="post" action="#">
	<table class="ml_tbl_row_small" summary="Aggiunta di pi� amministratori al sistema">	
		<tr>
			<th scope="row"><label for="import_file">{$tpl_lbl_messages.file}:  </label></th>
			<td><input type="file" name="import_file"  id="import_file" class="ml_input_medium" /></td>
		</tr>		
		<tr>
			<th scope="row"><label for="delimitatoreCampo">{$tpl_lbl_messages.fieldlimit}:  </label></th>
			<td><input type="text" name="import_field_delimiter"  id="delimitatoreCampo" class="ml_small" value="{$tpl_POST.import_field_delimiter}" /> <br />{$tpl_lbl_messages.deftab}</td>
		</tr>		
		<tr>
			<th scope="row"><label for="delimitatoreRecord">{$tpl_lbl_messages.recordlimit}:  </label></th>
			<td><input type="text" name="import_record_delimiter"  id="delimitatoreRecord" class="ml_small" value="{$tpl_POST.import_record_delimiter}" /> <br />{$tpl_lbl_messages.deflinebreak}</td>
		</tr>		
		<tr>
			<th scope="row"><label for="TestOutput">{$tpl_lbl_messages.testoutput}:  </label></th>
			<td><input name="import_test" type="checkbox"  id="TestOutput" class="ml_check" value="yes" {$tpl_checked.test}/></td>
		</tr>		
		<tr>
			<th scope="row"><label for="ListaAmministratore">{$tpl_lbl_messages.checklistlbl}:  </label></th>
			<td><input name="createlist" type="checkbox"  id="ListaAmministratore" class="ml_check" value="yes" {$tpl_checked.createlist}/><br /><span><label for="ListaAmministratore">{$tpl_lbl_messages.checklist}</label></span></td>
		</tr>		
	</table>
	
	<div class="ml_pulsNav">
		<div class="ml_pulsNavSx">
			<input type="submit" name="back" id="inp_save" class="puls" value="indietro" />
		</div>
		<div class="ml_pulsNavDx">
			<input type="hidden" name="view" value="importadmin" />
			<input type="submit" name="import" id="inp_save" class="puls" value="{$tpl_lbl_action.doimport}" />
		</div>
	</div>
	</form>
</div><!--panel-->