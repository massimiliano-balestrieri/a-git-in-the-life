		{if $ID>0}
		<!-- form info -->
		<tr>
			<th scope="row"><label for="user_disabled">{tz}form_is_disabled{/tz}</label></th>
			<td><input type="checkbox" id="user_disabled" name="user[disabled]" value="1" {$checked.disabled} disabled="disabled" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="user_blacklisted">{tz}form_is_in_blacklist{/tz}</label></th>
			<td><input type="checkbox" id="user_blacklisted" name="user[blacklisted]" value="1" {$checked.blacklisted} disabled="disabled"  /></td>
		</tr>
		<tr>
			<th scope="row">{tz}form_created{/tz}</th>
			<td>{$user.entered}</td>
		</tr>
		<tr>
			<th scope="row">{tz}form_modified{/tz}</th>
			<td>{$user.modified}</td>
		</tr>
		<tr>
			<th scope="row">{tz}form_bounces{/tz}</th>
			<td>{$user.bouncecount}</td>
		</tr>
		{/if}		