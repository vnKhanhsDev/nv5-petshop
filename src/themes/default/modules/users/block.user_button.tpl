<!-- BEGIN: main -->
<span><a title="{GLANG.signin} - {GLANG.register}" class="pa pointer button" data-toggle="tip" data-target="#guestBlock_{BLOCKID}" data-click="y" data-callback="loginFormLoad"><em class="fa fa-user fa-lg"></em><span class="hidden">{GLANG.signin}</span></a></span>
<!-- START FORFOOTER -->
<div id="guestBlock_{BLOCKID}" class="hidden">
    <div class="log-area" style="margin:-15px"></div>
</div>
<script>
function loginFormLoad() {
    $.ajax({
        type: 'POST',
        url: nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=users&' + nv_fc_variable + '=login',
        cache: !1,
        data: {
            nv_ajax: 1,
            nv_redirect: '{NV_REDIRECT}'
        },
        dataType: "json"
    }).done(function(res) {
        if (res.sso) {
            window.location.href = res.sso;
            return !1;
        }
        if (res.reload) {
            location.reload();
            return !1;
        }
        $("#tip .log-area").html(res.html);
        change_captcha();
    });
}
</script>
<!-- END FORFOOTER -->
<!-- END: main -->

<!-- BEGIN: signed -->
<span><a title="{USER.full_name}" class="pointer button user" data-toggle="tip" data-target="#userBlock_{BLOCKID}" data-click="y" style="background-image:url({AVATA})"><span class="hidden">{USER.full_name}</span></a></span>
<!-- START FORFOOTER -->
<div id="userBlock_{BLOCKID}" class="hidden">
    <div class="nv-info" style="display: none;"></div>
    <div class="userBlock clearfix">
        <div class="h3 margin-bottom"><span class="lev-{LEVEL} text-normal">{WELCOME}:</span> <strong>{USER.full_name}</strong></div>
        <div class="row">
            <div class="col-xs-8 text-center">
                <a title="{LANG.edituser}" href="#" data-toggle="changeAvatar" data-url="{URL_AVATAR}"><img src="{AVATA}" alt="{USER.full_name}" class="img-thumbnail bg-gainsboro" /></a>
            </div>
            <div class="col-xs-16">
                <ul class="nv-list-item sm">
                    <li class="active"><a href="{URL_MODULE}">{LANG.user_info}</a></li>
                    <li><a href="{URL_HREF}editinfo">{LANG.editinfo}</a></li>
                    <!-- BEGIN: allowopenid --><li><a href="{URL_HREF}editinfo/openid">{LANG.openid_administrator}</a></li><!-- END: allowopenid -->
                    <!-- BEGIN: myapis --><li><a href="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}=myapi">{GLANG.myapis}</a></li><!-- END: myapis -->
                </ul>
            </div>
        </div>
        <!-- BEGIN: admintoolbar -->
        <div class="margin-top boder-top padding-top">
            <p class="margin-bottom-sm"><strong>{GLANG.for_admin}</strong></p>
            <ul class="nv-list-item sm">
                <li><em class="fa fa-cog fa-horizon margin-right-sm"></em><a href="{NV_BASE_SITEURL}{NV_ADMINDIR}/index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}" title="{GLANG.admin_page}"><span>{GLANG.admin_page}</span></a></li>
                <!-- BEGIN: is_modadmin -->
                <li><em class="fa fa-key fa-horizon margin-right-sm"></em><a href="{URL_ADMINMODULE}" title="{GLANG.admin_module_sector} {MODULENAME}"><span>{GLANG.admin_module_sector} {MODULENAME}</span></a></li>
                <!-- END: is_modadmin -->
                <!-- BEGIN: is_spadadmin -->
                <li><em class="fa fa-arrows fa-horizon margin-right-sm"></em><a href="{URL_DBLOCK}" title="{LANG_DBLOCK}"><span>{LANG_DBLOCK}</span></a></li>
                <!-- END: is_spadadmin -->
                <li><em class="fa fa-user fa-horizon margin-right-sm"></em><a href="{URL_AUTHOR}" title="{GLANG.admin_view}"><span>{GLANG.admin_view}</span></a></li>
            </ul>
        </div>
        <!-- END: admintoolbar -->
    </div>
    <div class="tip-footer">
        <div class="row">
            <div class="col-xs-16 small">
                <em class="button btn-sm icon-enter" title="{LANG.current_login}"></em>{USER.current_login_txt}
            </div>
            <div class="col-xs-8 text-right">
                <button type="button" class="btn btn-default btn-sm active" data-toggle="{URL_LOGOUT}"><em class="icon-exit"></em>&nbsp;{LANG.logout_title}&nbsp;</button>
            </div>
        </div>
    </div>
</div>
<!-- END FORFOOTER -->
<script src="{NV_STATIC_URL}themes/{BLOCK_JS}/js/users.js"></script>
<!-- END: signed -->

<!-- BEGIN: sso -->
<span><a title="{GLANG.signin}" class="pa pointer button" href="{LINK_LOGIN}" rel="nofollow"><em class="fa fa-user fa-lg"></em><span class="hidden">{GLANG.signin}</span></a></span>
<!-- END: sso -->
