<!-- send_attach.tpl -->
{if $tpl_config.ALLOW_ATTACHMENTS && $tpl_config.NUM_ATTACHMENTS > 1}
<h4>{tz}addattachments{/tz}</h4> 

<div class="ml_panel ml_panel_0">
<p>{tz}maxtotaldata{/tz}: <strong>{$tpl_config.POST_MAX_SIZE} (Max filesize: {$tpl_config.UPLOAD_MAX_FILESIZE})</strong></p>


		<table class="ml_tbl_row_small">	
				{section name=loop start=1 loop=$tpl_config.NUM_ATTACHMENTS}
				<tr>
					<th scope="row"><label for="attachment{$smarty.section.loop.index}">{tz}newattachment{/tz}</label></th>
					<td><input type="file" name="attachment{$smarty.section.loop.index}"  id="attachment{$smarty.section.loop.index}" class="ml_input_medium" /></td>
				</tr>		
				<tr>
					<th scope="row"><label for="files_attachment{$smarty.section.loop.index}_description">{tz}attachmentdescription{/tz}</label></th>
					<td><textarea name="files[attachment{$smarty.section.loop.index}_description]" id="files_attachment{$smarty.section.loop.index}_description" cols="50" rows="2"></textarea></td>
				</tr>
				{/section}		
		</table>
		<div class="ml_container_buttons">
				<input type="submit" name="confirm" class="ml_button" value="{tz}uploadandsave{/tz}" />
		</div>
		
		{if is_array($attachments) && sizeof($attachments) > 0}
		<div class="ml_scroll">
		<table class="ml_col" summary="Uploads">
		<tr>
			<th scope="col">&nbsp;</th>
			<th scope="col">{tz}filename{/tz}</th>				
			<th scope="col">{tz}desc{/tz}</th>
			<th scope="col">{tz}size{/tz}</th>
		</tr>
		{foreach item=attach from=$attachments}
		<tr>							
			<td><input type="checkbox" name="deleteattachments[{$attach.id}]" id="deleteattachments_{$attach.id}" value="{$attach.id}" /></td>
			<td><a href="{$BO}fo/attachment/{$attach.id}">{$attach.remotefile}</a></td>
			<td>{$attach.description}</td>
			<td>{$attach.size}</td>
		</tr>
		{/foreach}
		</table>
		</div>
		<div class="ml_container_buttons">
				<input type="submit" name="confirm" class="ml_button" value="{tz}deleteattachments{/tz}" />
		</div>
    	{/if}
</div><!--panel-->
{/if}