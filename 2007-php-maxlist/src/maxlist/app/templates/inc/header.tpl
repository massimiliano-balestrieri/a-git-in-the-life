{fetch file="$HEAD_ISTANZA"}
<!--header.tpl-->

<title>MaxList : {$page_title}</title>
{$tpl_jscalendar_files}
{if isset($USE_TINYMCE)}
{include file="$PATH_TPL/inc/tinymce.tpl"}
{/if}
<script type="text/javascript" src="/public/include/js/lib/jquery/1.2.1/jquery-1.2.1.min.js"></script>
<script type="text/javascript" src="/public/include/js/lib/jquery/1.2.1/plugins/form/form-2.01.r1.0.js"></script>
<script type="text/javascript" src="/public/include/js/lib/jquery/1.2.1/plugins/moreselectors/moreselectors-1.1.3.1.r1.0.js"></script>
<script type="text/javascript" src="/public/include/js/lib/jquery/1.2.1/plugins/togglepanel/togglepanel-1.0.r1.0.js"></script>
<script type="text/javascript" src="/public/include/js/lib/jquery/1.2.1/maxlist/maxlist-1.0.js"></script>
<script type="text/javascript" src="/public/include/js/functions.js"></script>
<script type="text/javascript" src="/public/include/js/ready.js"></script>
</head>
<body>
<div id="maincontainer">

<div id="topsection">
{fetch file="$TESTATA_ISTANZA"}
	<div id="contbanner">
		<div id="banner"></div>
	</div>
</div>

<div id="contentwrapper">
	<div id="contentcolumn">