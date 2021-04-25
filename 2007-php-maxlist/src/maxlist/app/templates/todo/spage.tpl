{include file="$PATH_TPL/inc/head_view.tpl"}
{include file="$PATH_TPL/inc/debug.tpl"}
<!-- spage.tpl -->
<h4 id="mainspage">{$tpl_lbl_messages.subscribe_pages}</h4>

<form method="post" action="#" id="spage_form">
<div class="ml_panel ml_panel_1"  id="ml_mainspage">
{$tpl_info}
<table class="ml_col" summary="dati per la creazione di pagine per la sottoscrizione alle liste">
<tr>
<th scope="col">{$tpl_th_spage.default}</th>
<th scope="col">{$tpl_th_spage.title}</th>
<th scope="col">{$tpl_th_spage.owner}</th>
<th scope="col">{$tpl_th_spage.status}</th>
<th scope="col"></th>
</tr>
{foreach from=$tpl_list_spage item=spage}
<tr>
  <td><input onchange="document.getElementById('spage_form').submit()" name="default" type="radio" value="{$spage.id}" id="default_{$spage.id}" class="ml_noBorder" {$spage.default}/>&nbsp;<label for="unoa">{$spage.id}</label></td>
  <td>{$spage.title}</td>
  <td>{$spage.owner}</td>
  <td>{$spage.status}</td>
  <td>
  <a href="{$tpl_subscribeurl}&amp;id={$spage.id}">{$tpl_th_spage.view}</a>&nbsp;|&nbsp;
  <a href="?view=spagedit&amp;id={$spage.id}">{$tpl_th_spage.edit}</a>&nbsp;|&nbsp;
  <a href="javascript:deleteRec('?view=spage&amp;delete={$spage.id}');">{$tpl_th_spage.del}</a>
  </td>
</tr>
{/foreach}
</table>
	<div class="ml_pulsNav">
		<div class="ml_pulsNavSx">
			<input name="action" type="submit" value="{$tpl_lbl_action.add}" class="puls" onMouseOver="javascript:overOutHandler(this, 'ml_p95Hover');" onMouseOut="javascript:overOutHandler(this, 'ml_p95');" />
		</div>
	</div>
</div>
</form>