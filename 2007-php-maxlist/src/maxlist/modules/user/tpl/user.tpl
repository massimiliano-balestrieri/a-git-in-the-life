		
		<tr>
			<th scope="row"><label for="user_email">Email&nbsp;&nbsp;&nbsp;<span>*</span>{$errors.email.img}</label></th>
			<td><input id="user_email" type="text" name="user[email]" size="30" value="{$user.email}" class="ml_input_medium{$errors.email.classname}" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="user_htmlemail">{tz}form_email_html{/tz}</label></th>
			<td><input type="checkbox" id="user_htmlemail" name="user[htmlemail]" value="1" {$checked.htmlemail} /></td>
		</tr>
		<tr>
			<th scope="row"><label for="user_confirmed">{tz}form_is_confirmed{/tz}</label></th>
			<td><input type="checkbox" id="user_confirmed" name="user[confirmed]" value="1" {$checked.confirmed}  /></td>
		</tr>
		{if is_array($user_attributes)}
		{foreach from="$user_attributes" item="attr"}
		<tr>
			<th scope="row">
			{$attr.label}
			</th>
			<td>
			{$attr.field}
			</td>
		</tr>
		{/foreach}
		{/if}
		
		