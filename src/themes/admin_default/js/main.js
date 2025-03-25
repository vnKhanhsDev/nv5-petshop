/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

var myTimerPage = '';
var myTimersecField = '';

// Load multiliple js,css files
function getFiles(files, callback) {
    var progress = 0;
    files.forEach(function(fileurl) {
        var dtype = fileurl.substring(fileurl.lastIndexOf('.') + 1) == 'js' ? 'script' : 'text',
            attrs = "undefined" !== typeof site_nonce ? {
                'nonce': site_nonce
            } : {};
        $.ajax({
            url: fileurl,
            cache: true,
            dataType: dtype,
            scriptAttrs: attrs,
            success: function() {
                if (dtype == 'text') {
                    $("<link/>", {
                        rel: "stylesheet",
                        href: fileurl
                    }).appendTo("head")
                }
                if (++progress == files.length) {
                    if ("function" === typeof callback) {
                        callback()
                    }
                }
            }
        })
    })
}

function timeoutsesscancel() {
    clearInterval(myTimersecField);
    $.ajax({
        url: nv_base_siteurl + 'index.php?second=statimg',
        cache: false
    }).done(function() {
        $("#timeoutsess").hide();
        load_notification = 1;
        myTimerPage = setTimeout(function() {
            timeoutsessrun();
        }, nv_check_pass_mstime);
        if (typeof nv_get_notification === "function") {
            nv_get_notification();
        }
    });
}

function timeoutsessrun() {
    clearInterval(myTimerPage);
    var Timeout = 60;
    $('#secField').text(Timeout);
    $("#timeoutsess").show();
    var msBegin = new Date().getTime();
    myTimersecField = setInterval(function() {
        load_notification = 0;
        var msCurrent = new Date().getTime();
        var ms = Timeout - Math.round((msCurrent - msBegin) / 1000);
        if (ms >= 0) {
            $('#secField').text(ms);
        } else {
            clearInterval(myTimersecField);
            $("#timeoutsess").hide();
            $.getJSON(nv_base_siteurl + "index.php", {
                second: "time_login",
                nocache: (new Date).getTime()
            }).done(function(json) {
                if (json.showtimeoutsess == 1) {
                    $.get(nv_base_siteurl + "index.php?second=admin_logout&js=1&system=1&nocache=" + (new Date).getTime(), function() {
                        window.location.reload();
                    });
                } else {
                    myTimerPage = setTimeout(function() {
                        timeoutsessrun();
                    }, json.check_pass_time);
                }
            });
        }
    }, 1000);
}

function locationReplace(url) {
    var uri = window.location.href.substring(window.location.protocol.length + window.location.hostname.length + 2);
    if (url != uri && history.pushState) {
        history.pushState(null, null, url)
    }
}

function formXSSsanitize(form) {
    $(form).find("input, textarea").not(":submit, :reset, :image, :file, :disabled").not('[data-sanitize-ignore]').each(function() {
        $(this).val(DOMPurify.sanitize($(this).val(), {ALLOWED_TAGS: nv_whitelisted_tags, ADD_ATTR: nv_whitelisted_attr}));
    });
}

// checkAll
function checkAll(a, th) {
    th.is(":checked") ? ($("[data-toggle=checkAll], [data-toggle=checkSingle]", a).not(":disabled").each(function() {
        $(this).prop("checked", !0)
    }), $(".checkBtn", a).length && $(".checkBtn", a).prop("disabled", !1)) : ($("[data-toggle=checkAll], [data-toggle=checkSingle]", a).not(":disabled").each(function() {
        $(this).prop("checked", !1)
    }), $(".checkBtn", a).length && $(".checkBtn", a).prop("disabled", !0))
}

// checkSingle
function checkSingle(a) {
    var checked = 0,
        unchecked = 0;
    $("[data-toggle=checkSingle]", a).not(":disabled").each(function() {
        $(this).is(":checked") ? checked++ : unchecked++
    });
    0 != checked && 0 == unchecked ? $("[data-toggle=checkAll]", a).prop("checked", !0) : $("[data-toggle=checkAll]", a).prop("checked", !1);
    $(".checkBtn", a).length && (checked ? $(".checkBtn", a).prop("disabled", !1) : $(".checkBtn", a).prop("disabled", !0))
}

var NV = {
    menuBusy: false,
    menuTimer: null,
    menu: null,
    openMenu: function(menu) {
        this.menuBusy = true;
        this.menu = $(menu);
        this.menuTimer = setTimeout(function() {
            NV.menu.addClass('open');
        }, 300);
    },
    closeMenu: function(menu) {
        clearTimeout(this.menuTimer);
        this.menuBusy = false;
        this.menu = $(menu).removeClass('open');
    },
    fixContentHeight: function() {
        var wrap = $('.nvwrap');
        var vmenu = $('#left-menu');

        if (wrap.length > 0) {
            wrap.css('min-height', '100%');
            if (wrap.height() < vmenu.height() + vmenu.offset().top && vmenu.is(':visible')) {
                wrap.css('min-height', (vmenu.height() + vmenu.offset().top) + 'px')
            }
        }
    }
};

$(document).ready(function() {
    // Control content height
    NV.fixContentHeight();
    $(window).resize(function() {
        NV.fixContentHeight();
    });

    // Add rel="noopener noreferrer nofollow" to all external links
    $('a[href^="http"]').not('a[href*="' + location.hostname + '"]').not('[rel*=dofollow]').attr({
        target: "_blank",
        rel: "noopener noreferrer nofollow"
    });

    // Show submenu
    $('#menu-horizontal .dropdown, #left-menu .dropdown:not(.active)').hover(function() {
        NV.openMenu(this);
    }, function() {
        NV.closeMenu(this);
    });

    // Left menu handle
    $('#left-menu-toggle').click(function() {
        if ($('#left-menu').is(':visible')) {
            $('#left-menu, #left-menu-bg, #container, #footer').removeClass('open');
        } else {
            $('#left-menu, #left-menu-bg, #container, #footer').addClass('open');
        }
        NV.fixContentHeight();
    });

    // Show admin confirm
    myTimerPage = setTimeout(function() {
        timeoutsessrun();
    }, nv_check_pass_mstime);

    // Show confirm message on leave, reload page
    $('form.confirm-reload').change(function() {
        $(window).bind('beforeunload', function() {
            return nv_msgbeforeunload;
        });
    });

    // Disable confirm message on submit form
    $('form').submit(function() {
        $(window).unbind();
    });

    $('a[href="#"]').on('click', function(e) {
        e.preventDefault();
    });

    $('[data-btn="toggleLang"]').on('click', function(e) {
        e.preventDefault();
        $('.menu-lang').toggleClass('menu-lang-show');
    });

    //Change Localtion
    $("a[data-location]").on("click", function() {
        locationReplace($(this).data("location"))
    });

    // Xử lý ckeditor 4 chung cho các form ajax
    if (typeof CKEDITOR != "undefined") {
        $('body').on('submit', 'form', function() {
            let form = $(this);
            for (var instanceName in CKEDITOR.instances) {
                let ele = $('#' + instanceName, form);
                if (ele.length) {
                    ele.val(CKEDITOR.instances[instanceName].getData());
                }
            }
        });
    }

    // XSSsanitize
    $('body').on('click', '[type=submit]:not([name],.ck-button-save)', function(e) {
        var form = $(this).parents('form');
        if (XSSsanitize && !$('[name=submit]', form).length) {
            // Khi không xử lý XSS thì trình submit mặc định sẽ thực hiện
            e.preventDefault();

            // Đưa CKEditor 5 trình soạn thảo vào textarea trước khi submit
            $(form).find("textarea").each(function() {
                if (this.dataset.editorname && window.nveditor && window.nveditor[this.dataset.editorname]) {
                    $(this).val(window.nveditor[this.dataset.editorname].getData());
                }
            });

            formXSSsanitize(form);
            $(form).submit();
        }
    });

    $(document).on('click', function(e) {
        if (
            $('[data-btn="toggleLang"]').is(':visible') &&
            !$(e.target).closest('.menu-lang').length &&
            !$(e.target).closest('[data-btn="toggleLang"]').length &&
            !$(e.target).closest('.dropdown-backdrop').length
        ) {
            $('.menu-lang').removeClass('menu-lang-show');
        }
    });

    // Bootstrap tooltip
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

    // countdown
    if ($('#countdown').length) {
        var countdown = $('#countdown'),
            distance = parseInt(countdown.data('duration')),
            countdownObj = setInterval(function() {
                distance = distance - 1000;

                var hours = Math.floor(distance / (1000 * 60 * 60)),
                    minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)),
                    seconds = Math.floor((distance % (1000 * 60)) / 1000);
                if (minutes < 10) {
                    minutes = '0' + minutes
                };
                if (seconds < 10) {
                    seconds = '0' + seconds
                };
                countdown.text(hours + ':' + minutes + ':' + seconds)

                if (distance <= 0) {
                    clearInterval(countdownObj);
                    window.location.reload()
                }
            }, 1000);
    };

    // checkAll
    $('body').on('click', '[data-toggle=checkAll]', function() {
        checkAll($(this).parents('form'), $(this))
    });

    // checkSingle
    $('body').on('click', '[data-toggle=checkSingle]', function() {
        checkSingle($(this).parents('form'))
    });

    // Select File
    $('body').delegate('[data-toggle=selectfile]', 'click', function(e) {
        e.preventDefault();
        var area = $(this).data('target'),
            alt = $(this).data('alt'),
            path = $(this).data('path') ? $(this).data('path') : '',
            currentpath = $(this).data('currentpath') ? $(this).data('currentpath') : path,
            type = $(this).data('type') ? $(this).data('type') : 'image',
            currentfile = $('#' + area).val(),
            winname = $(this).data('winname') ? $(this).data('winname') : 'NVImg',
            url = script_name + "?" + nv_lang_variable + "=" + nv_lang_data + "&" + nv_name_variable + "=upload&popup=1";
        if (area) {
            url += "&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath;
            if (currentfile) {
                url += "&currentfile=" + rawurlencode(currentfile)
            }
            if (alt) {
                url += "&alt=" + alt
            }
            nv_open_browse(url, winname, 1200, 675, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
        }
    });

    // Ajax submit
    // Condition: The returned result must be in JSON format with the following elements:
    // status ('OK/error', required), mess (Error content), input (input name),
    // redirect (redirect URL if status is OK), refresh (Reload page if status is OK)
    $('body').on('submit', '.ajax-submit', function(e) {
        e.preventDefault();
        $('.has-error', this).removeClass('has-error');
        if (typeof(CKEDITOR) !== 'undefined') {
            for (let instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
                CKEDITOR.instances[instance].setReadOnly(true)
            }
        }

        var that = $(this),
            data = that.serialize(),
            callback = that.data('callback');
        $('input, textarea, select, button', that).prop('disabled', true);
        $.ajax({
            url: that.attr('action'),
            type: 'POST',
            data: data,
            cache: false,
            dataType: "json"
        }).done(function(a) {
            if (a.status == 'error') {
                $('input, textarea, select, button', that).prop('disabled', false);
                alert(a.mess);
                if (a.input) {
                    if ($('[name^=' + a.input + ']', that).length) {
                        $('[name^=' + a.input + ']', that).parent().addClass('has-error');
                        $('[name^=' + a.input + ']', that).focus()
                    }
                }
            } else if (a.status == 'OK') {
                if ('function' === typeof callback) {
                    callback()
                } else if ('string' == typeof callback && "function" === typeof window[callback]) {
                    window[callback]()
                }
                if (a.redirect) {
                    window.location.href = a.redirect
                } else if (a.refresh) {
                    window.location.reload()
                } else {
                    setTimeout(() => {
                        $('input, textarea, select, button', that).prop('disabled', false);
                        if (typeof(CKEDITOR) !== 'undefined') {
                            for (let instance in CKEDITOR.instances) {
                                CKEDITOR.instances[instance].setReadOnly(false)
                            }
                        }
                    }, 1000)
                }
            }
        })
    });

    // Chỉ cho gõ ký tự dạng số ở input có class number
    $('body').on('input', '.number', function() {
        $(this).val($(this).val().replace(/[^0-9]/gi, ''))
    });

    // Chỉ cho gõ các ký tự [a-zA-Z0-9_] ở input có class alphanumeric
    $('body').on('input', '.alphanumeric', function() {
        $(this).val($(this).val().replace(/[^a-zA-Z0-9\_]/gi, ''))
    });

    // Không cho xuống dòng
    $('body').on('input', '.nonewline', function() {
        var val = $(this).val().replace(/\n$/gi, '');
        $(this).val(val.replace(/\s*\n\s*/gi, ' '))
    });

    // uncheck khi click vào radio nếu radio đang ở trạng thái checked
    $('body').on("click mousedown", 'input[type=radio].uncheckRadio, .uncheckRadio input[type=radio]', function() {
        var c;
        return function(i) {
            c = "click" == i.type ? !c || (this.checked = !1) : this.checked
        }
    }());

    // Cố định header bảng
    function stickyTable() {
        if ($('table.table:not(.table-sticky)').length > 1) {
            return;
        }
        let offset = 0;
        $('table.table').each(function() {
            let ctn = $(this).parent();
            if ((offset++ == 0 && ($(this).closest('form').length == 1 || ctn.is('.table-responsive')) && $('thead', $(this)).length > 0) || $(this).is('.table-sticky')) {
                var allowed;
                if (ctn.is('.table-responsive')) {
                    allowed = !(ctn[0].scrollWidth > ctn[0].clientWidth );
                } else {
                    allowed = true;
                }
                if (allowed) {
                    $(this).stickyTableHeaders({
                        cacheHeaderHeight: true
                    });
                } else {
                    $(this).stickyTableHeaders('destroy');
                }
            }
        });
    }
    stickyTable();
    let timerstickyTable;
    $(window).on('resize', function() {
        clearTimeout(timerstickyTable);
        timerstickyTable = setTimeout(() => {
            stickyTable();
        }, 210);
    });
});
