{if $AUTH.superuser == 1 && DEBUG == true}
<!-- debug.tpl -->

<h4>Get</h4>
<div class="ml_panel ml_panel_0">
<div class="ml_messaggio" style="text-align:left;">
	<pre>&nbsp;{php}print_r($_GET){/php}</pre>
</div>
</div><!--panel-->

<h4>Post parsed</h4>
<div class="ml_panel ml_panel_0">
<div class="ml_messaggio" style="text-align:left;">
	<pre>&nbsp;{$POST_PARSED}</pre>
</div>
</div><!--panel-->

<h4>Post</h4>
<div class="ml_panel ml_panel_0">
<div class="ml_messaggio" style="text-align:left;">
	<pre>&nbsp;{php}print_r($_POST){/php}</pre>
</div>
</div><!--panel-->

<h4>Request</h4>
<div class="ml_panel ml_panel_0">
<div class="ml_messaggio" style="text-align:left;">
	<pre>&nbsp;{php}print_r($_REQUEST){/php}</pre>
</div>
</div><!--panel-->

<h4>Session</h4>
<div class="ml_panel ml_panel_0">
<div class="ml_messaggio" style="text-align:left;">
	<pre>&nbsp;{php}print_r($_SESSION){/php}</pre>
</div>
</div><!--panel-->
{/if}