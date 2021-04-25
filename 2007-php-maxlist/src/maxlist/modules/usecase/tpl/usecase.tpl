{include file="$PATH_TPL/inc/head_view.tpl"}
<!-- list.tpl -->
<h4>{tz}Group_Usecases{/tz}</h4> 
<div class="ml_panel ml_panel_1">
	<table class="ml_tbl_row_med">
	<tr>
		<th scope="row">{tz}groupname{/tz}</th>
		<td>{$tpl_group.name}</td>
	</tr>
	</table>
</div><!--panel-->

<form id="form_list" method="post" action="#">
<h4>{tz}Group_Usecases_Views{/tz}</h4> 
<div class="ml_panel ml_panel_1">
	<table class="ml_tbl_row_med">
	{foreach item=usecase key="key" from=$tpl_usecases}
	<tr>
		<th scope="row"><label>{tz}$key{/tz}</label></th>
		<td><input type="checkbox" name="uc_module[{$key}]" {if $usecase}checked="checked"{/if}/></td>
	</tr>
	{/foreach}
	</table>
</div><!--panel-->

<h4>{tz}eventlog{/tz}</h4> 
<div class="ml_panel ml_panel_0">
	<table class="ml_tbl_row_med">
	<tr>
	<td><ol>
		<li>Filtra</li>
		<li>Elimina eventi</li>
		<li>Elimina tutti gli eventi</li>
		<li>Elimina eventi vecchi</li>
	</ol></td>
	</tr>
	</table>
</div><!--panel-->

<h4>{tz}lists{/tz}</h4> 
<div class="ml_panel ml_panel_0">
	<table class="ml_tbl_row_med">
	<tr>
	<td><ol>
		<li>Ordina</li>
		<li>Attiva</li>
		<li>Proprietario</li>
		<li>Modifica</li>
		<li>Elimina</li>		
		<li>Aggiungi</li>
	</ol></td>
	</tr>
	</table>
</div><!--panel-->

<h4>{tz}users{/tz}</h4> 
<div class="ml_panel ml_panel_0">
	<table class="ml_tbl_row_med">
	<tr>
	<td><ol>
		<li>esporta</li>
		<li>importa</li>
		<li>Modifica</li>
		<li>Elimina</li>		
		<li>Aggiungi</li>
		<li>Iscrivi</li>
		<li>Disiscrivi</li>
	</ol></td>
	</tr>
	</table>
</div><!--panel-->

<h4>{tz}admins{/tz}</h4> 
<div class="ml_panel ml_panel_0">
	<table class="ml_tbl_row_med">
	<tr>
	</tr>
	</table>
</div><!--panel-->

<h4>{tz}attributes{/tz}</h4> 
<div class="ml_panel ml_panel_0">
	<table class="ml_tbl_row_med">
	<tr>
	</tr>
	</table>
</div><!--panel-->

<h4>{tz}members{/tz}</h4> 
<div class="ml_panel ml_panel_0">
	<table class="ml_tbl_row_med">
	<tr>
	</tr>
	</table>
</div><!--panel-->

<h4>{tz}message{/tz}</h4> 
<div class="ml_panel ml_panel_0">
	<table class="ml_tbl_row_med">
	<tr>
	</tr>
	</table>
</div><!--panel-->

<h4>{tz}processes{/tz}</h4> 
<div class="ml_panel ml_panel_0">
	<table class="ml_tbl_row_med">
	<tr>
	</tr>
	</table>
</div><!--panel-->

<h4>{tz}templates{/tz}</h4> 
<div class="ml_panel ml_panel_0">
	<table class="ml_tbl_row_med">
	<tr>
	</tr>
	</table>
</div><!--panel-->

<h4>{tz}bounces{/tz}</h4> 
<div class="ml_panel ml_panel_0">
	<table class="ml_tbl_row_med">
	<tr>
	</tr>
	</table>
</div><!--panel-->

<h4>{tz}statistics{/tz}</h4> 
<div class="ml_panel ml_panel_0">
	<table class="ml_tbl_row_med">
	<tr>
	</tr>
	</table>
</div><!--panel-->

<h5>{tz}save{/tz}</h5> 
	<div class="ml_open">
	<div class="ml_container_buttons">
		<div class="ml_buttons_sx">
		</div>
		<div class="ml_buttons_dx">
		<input type="hidden" name="do" value="{$DO}" />
		<input type="submit" name="confirm" class="ml_button" value="{tz}save{/tz}" />
		</div>
	</div>	
</div><!--panel-->
</form>
