/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

function nv_admin_logout() {
    confirm(nv_admlogout_confirm[0]) && $.get(nv_base_siteurl + "index.php?second=admin_logout&js=1&nocache=" + (new Date).getTime(), function(b) {
        1 == b && (alert(nv_admlogout_confirm[1]), 1 == nv_area_admin ? (window.location.href = nv_base_siteurl) : (location.reload()))
    });
    return !1
}

$(function() {
    // Admin logout
    $('body').on('click', '[data-toggle=nv_admin_logout]', function(e) {
        e.preventDefault();
        nv_admin_logout()
    });

    // JS của nv_generate_page
    $('body').on('click', '[data-toggle=gen-page-js][data-func][data-href][data-obj]', function(e) {
        e.preventDefault();
        if ('function' === typeof window[$(this).data('func')]) {
            window[$(this).data('func')]($(this).data('href'), $(this).data('obj'))
        }
    });

    if ("undefined" != typeof drag_block && 0 != drag_block) {
        $("a.delblock").click(function(e) {
            e.preventDefault();
            confirm(block_delete_confirm) && $.post(post_url + "blocks_del", "bid=" + $(this).attr("name") + "&checkss=" + $(this).data("checkss"), function(a) {
                alert(a);
                window.location.href = selfurl
            })
        });
        $("a.outgroupblock").click(function(e) {
            e.preventDefault();
            confirm(block_outgroup_confirm) && $.post(post_url + "block_outgroup", "func_id=" + func_id + "&bid=" + $(this).attr("name") + "&checkss=" + $(this).data("checkss"), function(a) {
                alert(a);
                window.location.href = selfurl
            })
        });
        $("a.block_content").click(function(e) {
            e.preventDefault();
            nv_open_browse(post_url + "block_content&selectthemes=" + module_theme + "&tag=" + $(this).attr("id") + "&bid=" + $(this).attr("name") + "&blockredirect=" + blockredirect, "ChangeBlock", 800, 500, "resizable=no,scrollbars=yes,toolbar=no,location=no,status=no")
        });
        $("a.actblock").click(function(e) {
            e.preventDefault();
            $(this).prop("disabled", !0);
            var a = this;
            $.ajax({
                type: "post",
                url: post_url + "block_change_show",
                data: "bid=" + $(this).attr("name") + "&checkss=" + $(this).data("checkss"),
                cache: !1,
                dataType: "json"
            }).done(function(b) {
                $(a).prop("disabled", !1);
                "ok" == b.status && ($(a).attr("title", $(a).attr("data-" + b.act)).attr("alt", $(a).attr("data-" + b.act)).find("em").attr("class", $("em", a).attr("data-" + b.act)), "act" == b.act ? $(a).parent().parent().find(".blockct").removeClass("act0") : $(a).parent().parent().find(".blockct").addClass("act0"))
            });
        });
        var b = !1;
        $(".column").sortable({
            connectWith: ".column",
            opacity: .8,
            cursor: "move",
            receive: function() {
                b = !0;
                $.post(post_url + "sort_order", $(this).sortable("serialize") + "&position=" + $(this).data("id") + "&checkss=" + $(this).data("checkss") + "&func_id=" + func_id, function(a) {
                    a == "OK_" + func_id ? $("div#toolbar>ul.info").html('<li><span style="color:#ff0000;padding-left:150px;font-weight:700;">' + blocks_saved + "</span></li>").fadeIn(1E3) : alert(blocks_saved_error)
                });
            },
            stop: function() {
                0 == b && $.post(post_url + "sort_order", $(this).sortable("serialize") + "&position=" + $(this).data("id") + "&checkss=" + $(this).data("checkss") + "&func_id=" + func_id, function(a) {
                    a == "OK_" + func_id ? $("div#toolbar>ul.info").html('<span style="color:#ff0000;padding-left:150px;font-weight:700;">' + blocks_saved + "</span>").fadeIn(1E3) : alert(blocks_saved_error)
                });
            }
        });
        $(".column").disableSelection();
    }
});
