<!--if $login.role < 4-->
<!-- format.tpl -->
<h4>Formato</h4> 
<div class="ml_panel ml_panel_0">
<p><input type="hidden" name="htmlformatted" value="auto" /></p>
<p>{tz}sendas{/tz}{$errors.sendformat.img}:
<label for="msg_sendformat_html">{tz}html{/tz}</label>
<input type="radio" id="msg_sendformat_html" name="msg[sendformat]" value="HTML" {$tpl_checked.sendformat_html}/>
<label for="msg_sendformat_text">{tz}text{/tz}</label>
<input type="radio" id="msg_sendformat_text" name="msg[sendformat]" value="text" {$tpl_checked.sendformat_text}/>
<!--if $USE_PDF
<label for="sendformat_pdf">{tz}pdf{/tz}</label>
<input type="radio" id="sendformat_pdf" name="sendformat" value="pdf" {$tpl_checked.sendformat_pdf}/>
/if-->
<label for="msg_sendformat_textandhtml">{tz}textandhtml{/tz}</label>
<input type="radio" id="msg_sendformat_textandhtml" name="msg[sendformat]" value="text and HTML" {$tpl_checked.sendformat_textandhtml}/>
<!--if $USE_PDF
<label for="sendformat_textandpdf">{tz}textandpdf{/tz}</label>
<input type="radio" id="sendformat_textandpdf" name="sendformat" value="text and PDF" {$tpl_checked.sendformat_textandpdf}/>
/if-->
</p>
<p>
{tz}usetemplate{/tz}:
<select name="msg[template]" id="msg_template">
	<option value="0">-- {tz}selectone{/tz}</option>
	{foreach key=templk item=templv from=$templates}
		{if $msg.template == $templk}
		<option value="{$templk}" selected="selected">{$templv}</option>
		{else}
		<option value="{$templk}">{$templv}</option>
		{/if}
	{/foreach} 
</select>
</p>
</div><!--panel-->
<!--/if-->