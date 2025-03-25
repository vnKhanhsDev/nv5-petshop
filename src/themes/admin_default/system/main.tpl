<!-- BEGIN: main -->
{FILE "header.tpl"}
<div class="container-fluid nvwrap">
    <div id="left-menu-bg"></div>
    <header id="header" class="row">
        <div class="logo">
            <a title="{NV_SITE_NAME}" href="{NV_BASE_SITEURL}{NV_ADMINDIR}/index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}">
                <img class="logo-md" alt="{NV_SITE_NAME}" src="{NV_BASE_SITEURL}themes/{NV_ADMIN_THEME}/images/logo_small.png" width="189" height="49"/>
                <img class="logo-xs" alt="{NV_SITE_NAME}" src="{NV_BASE_SITEURL}themes/{NV_ADMIN_THEME}/images/logo-xs.png" width="50" height="50"/>
            </a>
        </div>
        <ul class="menu pull-right">
            <!-- BEGIN: lang -->
            <li title="{LANG.langinterface}" class="menu-lang menu-lang-interface">
                <a href="javascript:void(0);" data-toggle="dropdown">Lang Interface: {NV_LANGINTERFACE_CURRENT} <em class="fa fa-caret-down"></em></a>
                <ul class="dropdown-menu" role="menu">
                    <!-- BEGIN: interface -->
                    <li{INTERFACE_DISABLED}><a href="{INTERFACE_LANGOP}">{LANGVALUE}</a></li>
                    <!-- END: interface -->
                </ul>
            </li>
            <li title="{LANG.langdata}" class="menu-lang menu-lang-data">
                <a href="javascript:void(0);" data-toggle="dropdown">Lang Data: {NV_LANGDATA_CURRENT} <em class="fa fa-caret-down"></em></a>
                <ul class="dropdown-menu" role="menu">
                    <!-- BEGIN: data -->
                    <li{DATA_DISABLED}><a href="{DATA_LANGOP}">{LANGVALUE}</a></li>
                    <!-- END: data -->
                </ul>
            </li>
            <!-- END: lang -->
            <li class="tip" data-toggle="tooltip" data-placement="bottom" title="{NV_GO_CLIENTSECTOR}">
                <a href="{NV_GO_CLIENTSECTOR_URL}"> <em class="fa fa-home fa-2x fix"></em></a>
            </li>
            <!-- BEGIN: lang1 -->
            <li class="menu-lang-mobile">
                <a data-btn="toggleLang" href="#"><em class="fa fa-2x fa-magic fix" aria-hidden="true"></em></a>
            </li>
            <!-- END: lang1 -->
            <li class="admin-info">
                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="{ADMIN_PHOTO}" alt="{ADMIN_USERNAME}" width="32" height="32" class="bg-gainsboro"/>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <span><img alt="" src="{NV_BASE_SITEURL}themes/{NV_ADMIN_THEME}/images/admin{ADMIN.level}.png"> {ADMIN.username}</span>
                    </li>
                    <li>
                        <span><i class="fa fa-caret-right fa-fw"></i> {ADMIN.hello_admin2}</span>
                    </li>
                    <!-- BEGIN: admin_login_duration -->
                    <li>
                        <span><i class="fa fa-globe fa-spin fa-fw"></i> {LANG.login_session_expire} <span id="countdown" data-duration="{DURATION}"></span></span>
                    </li>
                    <!-- END: admin_login_duration -->
                    <!-- BEGIN: hello_admin1 -->
                    <li>
                        <span><i class="fa fa-caret-right fa-fw"></i> {ADMIN.hello_admin1}</span>
                    </li>
                    <!-- END: hello_admin1 -->
                    <li>
                        <a href="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}=users">
                        <i class="fa fa-arrow-circle-right fa-fw"></i> {LANG.account_settings}
                        </a>
                    </li>
                    <li>
                        <a href="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}=authors&amp;id={ADMIN.admin_id}">
                        <i class="fa fa-arrow-circle-right fa-fw"></i> {LANG.your_admin_account}
                        </a>
                    </li>
                </ul>
            </li>
            <!-- BEGIN: notification -->
            <li class="dropdown" id="notification-area" data-checksess="{NV_CHECK_SESSION}">
                <span id="notification" style="display: none"></span>
                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"> <em class="fa fa-bell-o fa-2x fix"></em></a>
                <div class="dropdown-menu">
                    <div>
                        <div id="notification_load"></div>
                        <div id="notification_waiting">
                            <div class="text-center">
                                <i class="fa fa-spin fa-spinner"></i>
                            </div>
                        </div>
                        <div id="notification_more">
                            <div class="text-center">
                                <a href="{NV_GO_ALL_NOTIFICATION}">{LANG.view_all}</a>
                                <a href="#" data-toggle="markallnoti">{LANG.mark_read_all}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <!-- END: notification -->
            <li class="tip" data-toggle="tooltip" data-placement="bottom" title="{NV_LOGOUT}">
                <a href="javascript:void(0);" onclick="nv_admin_logout();"> <em class="fa fa-power-off fa-2x fix logout"></em></a>
            </li>
        </ul>
    </header>
    <div class="row">
        <div class="navbar navbar-inverse navbar-static-top" role="navigation" id="menu-site-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu-horizontal">
                        <span class="sr-only"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <button id="left-menu-toggle" type="button" class="navbar-toggle" data-target="#left-menu">
                        <span class="sr-only"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="menu-horizontal">
                    <ul class="nav navbar-nav">
                        <li class="hidden-md hidden-sm hidden-xs">
                            <a title="{LANG.Home}" href="{NV_BASE_SITEURL}{NV_ADMINDIR}/index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}"><em class="fa fa-lg fa-home"></em> {LANG.Home}</a>
                        </li>
                        <!-- BEGIN: top_menu_loop -->
                        <li {TOP_MENU_CLASS}>
                            <a href="{NV_BASE_SITEURL}{NV_ADMINDIR}/index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={TOP_MENU_HREF}">{TOP_MENU_NAME}<!-- BEGIN: has_sub --> <strong class="caret"></strong><!-- END: has_sub --></a>
                            <!-- BEGIN: submenu -->
                            <ul class="dropdown-menu">
                                <!-- BEGIN: submenu_loop --><li><a href="{SUBMENULINK}" title="{SUBMENUTITLE}">{SUBMENUTITLE}</a></li><!-- END: submenu_loop -->
                            </ul>
                            <!-- END: submenu -->
                        </li>
                        <!-- END: top_menu_loop -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <section id="middle" class="row">
        <aside id="left-menu">
            <div id="bg-left-menu">
                <ul class="nav nav-pills nav-stacked text-color">
                    <!-- BEGIN: menu_loop -->
                        <li {MENU_CLASS}>
                            <a href="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MENU_HREF}">{MENU_NAME}</a>
                            <!-- BEGIN: submenu -->
                            <ul class="dropdown-menu">
                                <!-- BEGIN: loop -->
                                <li>
                                    <a href="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MENU_SUB_HREF}&amp;{NV_OP_VARIABLE}={MENU_SUB_OP}">{MENU_SUB_NAME}</a>
                                </li>
                                <!-- END: loop -->
                            </ul>
                            <!-- END: submenu -->
                            <span class="arrow"></span>
                        </li>
                        <!-- BEGIN: current -->
                        <li {MENU_CLASS}>
                            <a class="{MENU_SUB_CURRENT}" href="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MENU_SUB_HREF}&amp;{NV_OP_VARIABLE}={MENU_SUB_OP}">{MENU_SUB_NAME}</a>
                            <!-- BEGIN: submenu -->
                            <ul class="dropdown-menu">
                                <!-- BEGIN: loop -->
                                <li>
                                    <a href="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MENU_SUB_HREF}&amp;{NV_OP_VARIABLE}={CUR_SUB_OP}">{CUR_SUB_NAME}</a>
                                </li>
                                <!-- END: loop -->
                            </ul>
                            <!-- END: submenu -->
                        </li>
                        <!-- END: current -->
                    <!-- END: menu_loop -->
                </ul>
                <div class="clearfix"> </div>
            </div>
        </aside>
        <div id="container" class="clearfix">
            <div id="info_tab" class="clearfix">
                <!-- BEGIN: breadcrumbs -->
                <ol class="breadcrumb">
                    <!-- BEGIN: loop -->
                    <li<!-- BEGIN: active --> class="active"<!-- END: active -->><!-- BEGIN: text -->{BREADCRUMBS.title}<!-- END: text --><!-- BEGIN: linked --><a href="{BREADCRUMBS.link}">{BREADCRUMBS.title}</a><!-- END: linked --></li>
                    <!-- END: loop -->
                </ol>
                <!-- END: breadcrumbs -->

                <ul class="pull-right list-inline btncontrol">
                    <!-- BEGIN: url_instruction -->
                    <li><a target="_blank" href="{NV_URL_INSTRUCTION}" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{NV_INSTRUCTION}"><em class="fa fa-book fa-lg"></em></a></li>
                    <!-- END: url_instruction -->

                    <!-- BEGIN: site_mods -->
                    <li><a target="_blank" href="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{NV_GO_CLIENTMOD}"><em class="fa fa-globe fa-lg"></em></a></li>
                    <!-- END: site_mods -->
                </ul>

                <!-- BEGIN: select_option -->
                <div class="pull-right btn-group">
                    <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown">
                        {PLEASE_SELECT} <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <!-- BEGIN: select_option_loop -->
                        <li><a href="{SELECT_VALUE}">{SELECT_NAME}</a></li>
                        <!-- END: select_option_loop -->
                    </ul>
                </div>
                <!-- END: select_option -->
            </div>
            <div id="contentmod">
                {THEME_ERROR_INFO}
                {MODULE_CONTENT}
            </div>
        </div>
    </section>
    <footer id="footer" class="row">
        <div class="footer-content">
            <div class="copyright">
                <!-- BEGIN: memory_time_usage -->
                [MEMORY_TIME_USAGE]
                <br/>
                <!-- END: memory_time_usage -->
                <strong>{NV_COPYRIGHT}</strong>
            </div>
            <div class="imgstat">
                <a title="NUKEVIET CMS" href="https://nukeviet.vn" target="_blank"><img alt="NUKEVIET CMS" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/images/banner_nukeviet_88x15.jpg" width="88" height="15" class="imgstatnkv"/></a>
                <br/>
            </div>
        </div>
    </footer>
</div>
<div id="timeoutsess" class="chromeframe">
    {LANG.timeoutsess_nouser}, <a onclick="timeoutsesscancel();" href="#">{LANG.timeoutsess_click}</a>. {LANG.timeoutsess_timeout}: <span id="secField"> 60 </span> {LANG.sec}
</div>
{FILE "footer.tpl"}
<!-- END: main -->
