<!-- BEGIN: main -->
<link rel="stylesheet" type="text/css" href="{NV_STATIC_URL}themes/{TEMPLATE}/css/jquery.metisMenu.css" />
<script type="text/javascript" src="{ASSETS_STATIC_URL}/js/jquery/jquery.metisMenu.js"></script>

<div class="clearfix panel">
    <aside class="sidebar">
        <nav class="sidebar-nav">
            <ul id="menu_{MENUID}">
                {HTML_CONTENT}
            </ul>
        </nav>
    </aside>
</div>

<script type="text/javascript">
    $(function() {
    $('#menu_{MENUID}').metisMenu({
    toggle: false
    });
    });
</script>
<!-- END: main -->