{include file="$PATH_TPL/inc/head_view.tpl"}
{if $tpl_config.USE_ADVANCED_BOUNCEHANDLING}
<h4>{tz}PossibleActions{/tz}</h4>
<form method="post" action="#">
<div class="ml_panel ml_panel_1">
		<table class="ml_tabRowMed">
		<tr>
			<th scope="row"><label for="useremail">{$tpl_th_form.ForUser}</label></th>
			<td>
				<input type="text" name="useremail" id="useremail" class="ml_input_medium" value="{$tpl_bounce.guessedemail}" />
			</td>
			</tr>
		<tr>
			<th scope="row"><label for="amount">{$tpl_th_form.IncreaseB}</label></th>
			<td>
				<input type="text" name="amount" id="amount" class="ml_saml" value="1" /><br/>&nbsp;(usa numeri negativi per decrementare)
			</td>
			</tr>
		<tr>
			<th scope="row"><label for="unconfirm">{$tpl_th_form.MarkAsUnconfirmed}</label></th>
			<td>
				<input type="checkbox" name="unconfirm" id="unconfirm" value="1" />&nbsp;(in modo da spedire nuovamente la richiesta di conferma)
			</td>
			</tr>
		<tr>
			<th scope="row"><label for="maketext">{$tpl_th_form.SetReceiveText} </label></th>
			<td>
				<input type="checkbox" name="maketext" id="maketext" value="1" />&nbsp;
			</td>
			</tr>
		<tr>
			<th scope="row"><label for="deleteuser">{$tpl_th_form.DelUser1}</label></th>
			<td>
				<input type="checkbox" name="deleteuser" id="deleteuser" value="1" />&nbsp;
			</td>
			</tr>
		<tr>
			<th scope="row"><label for="deletebounce">{$tpl_th_form.DelAndGo}</label></th>
			<td>
				<input type="checkbox" name="deletebounce" id="deletebounce" value="1" />&nbsp;
			</td>
			</tr>
		</table>
	
		<div class="ml_container_buttons">
			<div class="ml_buttons_dx">
				<input type="hidden" name="view" value="bounce" />
				<input type="hidden" name="id" value="{$tpl_ID}" />
				<input type="submit" name="doit" value="{$tpl_lbl_action.DoAbove}" class="ml_button" />
			</div>
			{if $tpl_config.USE_ADVANCED_BOUNCEHANDLING}
			<div class="ml_buttons_sx">
				<a href="#">{$tpl_lbl_action.newrule}</a>
			</div>
			{/if}
		</div>
</div><!--/panel-->
</form>
{/if}

{if $tpl_config.USE_ADVANCED_BOUNCEHANDLING}
{include file="$PATH_TPL/inc/bouncerule_form.tpl"}
{/if}

<h4>{tz}BounceDetails{/tz}</h4>
<div class="ml_panel ml_panel_1">
	<table class="ml_tbl_row_small">
	<tr>
		<th scope="row">ID</th>
		<td>{$tpl_bounce.id}</td>
	</tr>
	<tr>
		<th scope="row">Email</th>
		<td>{$tpl_bounce.guessedemail}</td>
	</tr>
	<tr>
		<th scope="row">{tz}date{/tz}</th>
		<td>{$tpl_bounce.date}</td>
	</tr>
	<tr>
		<th scope="row">{tz}Status{/tz}</th>
		<td>{$tpl_bounce.status}</td>
	</tr>
	<tr>
		<th scope="row">{tz}Comment{/tz}</th>
		<td>{$tpl_bounce.comment}</td>
	</tr>
	<tr>
		<th scope="row">{tz}Header{/tz}</th>
		<td>{$tpl_bounce.header}</td>
	</tr>
	<tr>
		<th scope="row">{tz}Body{/tz}</th>
		<td>{$tpl_bounce.data}</td>
	</tr>
	</table>
</div><!--/panel -->