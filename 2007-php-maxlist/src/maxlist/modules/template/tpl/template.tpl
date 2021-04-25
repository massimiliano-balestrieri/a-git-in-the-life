{include file="$PATH_TPL/inc/head_view.tpl"}
<h4>{tz}Edit_Template{/tz}</h4>
<div class="ml_panel ml_panel_1">	
{if $errors}
{include file="$PATH_TPL/inc/error.tpl"}
{/if}
	<form method="post" action="#" enctype="multipart/form-data">
	<table class="ml_tbl_row_small">
		<tr>
			<th><label for="title">{tz}title{/tz}{$errors.title.img}</label></th>
			<td><input type="text" name="template[title]" id="title" value="{$tpl_template.title}" class="ml_input_medium{$errors.title.classname}" /></td>
		</tr>
		<!--<tr>
			<th><label for="file_template">{$tpl_lbl_messages.file}</label></th>
			<td><input type="file" id="file_template" name="template[file_template]" /> <br />{$tpl_lbl_messages.warn1}
			{$tpl_lbl_messages.warn2}</td>
		</tr>-->
		<tr>
			<th><label for="content">{tz}content{/tz}{$errors.content.img}</label></th>
			<td><textarea name="template[content]" id="content" cols="55" rows="20" class="ml_area{$errors.content.classname}">{$tpl_template.content}</textarea></td>
		</tr>
	</table>
	<!--
	<table class="ml_tabCriteria">
	<tr>
		<th><label for="baseurl">{$tpl_lbl_messages.base}</label></th>
		<td><input type="text" id="baseurl" name="template[baseurl]" value="{$tpl_template.baseurl}" /></td>
	</tr>
	<tr>
		<th><label for="checkfulllinks">{$tpl_lbl_messages.links}</label></th>
		<td><input type="checkbox" id="checkfulllinks" name="template[check_full_links]" {$tpl_checked.checkfulllinks}></td>
	</tr>
	<tr>
		<th><label for="checkfullimages">{$tpl_lbl_messages.image}</label></th>
		<td><input type="checkbox" id="checkfullimages" name="template[check_full_images]" {$tpl_checked.checkfullimages}></td>
	</tr>
	<tr>
		<th><label for="checkimagesexist">{$tpl_lbl_messages.exist}</label></th>
		<td><input type="checkbox" id="checkimagesexist" name="template[check_images_exist]" {$tpl_checked.checkimagesexist}></td>
	</tr>
	</table>
	-->
	<div class="ml_container_buttons">
		<div class="ml_buttons_sx">
			<a href="{$BO}template" class="ml_button">{tz}back{/tz}</a>
		</div>
		<div class="ml_buttons_dx">
			<input type="hidden" name="do" value="{$DO}" />
			<input type="submit" name="confirm" id="confirm" class="ml_button" value="{tz}save{/tz}" />
			<input type="submit" name="confirm" id="confirm" class="ml_button" value="{tz}save_and{/tz}" />
		</div>
	</div>
	</form>
</div><!--panel-->