<!-- BEGIN: mainrefresh -->
<div class="text-center">
    {DATA.content}
</div>
<meta http-equiv="refresh" content="5;URL={DATA.urlrefresh}" />
<!-- END: mainrefresh -->

<!-- BEGIN: author_info -->
<div class="margin-top margin-bottom">
    <a class="btn btn-primary" href="{BASE_URL}">{LANG.your_content}</a>&nbsp;
    <a class="btn btn-primary" href="{BASE_URL}&amp;contentid=0&checkss={ADD_CONTENT_CHECK_SESSION}">{LANG.add_content}</a>
</div>
<h2 class="text-center">{LANG.author_info}</h2>
<form action="{FORM_ACTION}" method="post" data-toggle="authorEditSubmit">
    <input type="hidden" name="save" value="1" />
    <div class="table-responsive">
        <table id="edit" class="table table-striped table-bordered table-hover">
            <tfoot>
                <tr>
                    <td class="text-center" colspan="2">
                        <input type="hidden" name="fsubmit" value="1" />
                        <input class="btn btn-primary frm-item" type="submit" value="{LANG.author_info_save}" />
                    </td>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <td class="text-right text-nowrap"><strong>{LANG.author_pseudonym}: </strong> <sup class="required">(*)</sup></td>
                    <td>
                        <div class="form-group"><input class="form-control frm-item" name="pseudonym" id="pseudonym" type="text" value="{DATA.pseudonym}" maxlength="100" data-mess="{LANG.author_pseudonym_empty}" /></div>
                    </td>
                </tr>
                <tr>
                    <td class="text-right text-nowrap"><strong>{LANG.author_description}: </strong></td>
                    <td><textarea class="frm-item form-control" id="description" name="description" rows="10">{DATA.description_br2nl}</textarea></td>
                </tr>
            </tbody>
        </table>
    </div>
</form>
<script>
$(function() {
    $('[data-toggle=authorEditSubmit]').on('submit', function(event) {
        event.preventDefault();
        var form = this;
        $(".has-error", form).removeClass("has-error");
        var pseudonym = $("[name=pseudonym]", form).val();
        pseudonym = strip_tags(trim(pseudonym));
        $("[name=pseudonym]", form).val(pseudonym);

        if ("" == pseudonym) {
            alert($("[name=pseudonym]", form).data("mess"));
            $("[name=pseudonym]", form).parent().addClass('has-error');
            $("[name=pseudonym]", form).focus()
        } else {
            var data = $(form).serialize();
            $(".frm-item", form).prop("disabled", true);
            $.ajax({
                type: $(form).prop("method"),
                cache: !1,
                url: $(form).prop("action"),
                data: data,
                dataType: "json",
                success: function(b) {
                    if ("error" == b.status) {
                        $(".frm-item", form).prop("disabled", false);
                        alert(b.mess);
                        if ("" != b.input) {
                            $("[name=" + b.input + "]", form).parent().addClass('has-error');
                            $("[name=" + b.input + "]", form).focus()
                        }
                    } else {
                        window.location.href = b.mess
                    }
                }
            })
        }
    })
})
</script>
<!-- END: author_info -->

<!-- BEGIN: your_articles -->
<div class="margin-top margin-bottom">
    <a class="btn btn-primary" href="{BASE_URL}&amp;contentid=0&checkss={ADD_CONTENT_CHECK_SESSION}">{LANG.add_content}</a>&nbsp;
    <a class="btn btn-primary" href="{BASE_URL}&amp;author_info=1">{LANG.author_info}</a>
</div>
<div>
    <span class="pull-right"><i class="fa fa-arrow-right"></i>&nbsp;<a href="{AUTHOR_PAGE_URL}">{LANG.author_page}</a></span>
    <h2>{LANG.your_content}</h2>
</div>

<div class="news_column">
    <!-- BEGIN: news -->
    <div class="panel panel-default">
        <div class="panel-body">
            <!-- BEGIN: status_note -->
            <div class="alert alert-warning">
                {CONTENT.status_note}
            </div>
            <!-- END: status_note -->
            <!-- BEGIN: image -->
            <a href="{CONTENT.link}" title="{CONTENT.title}" {CONTENT.target_blank}><img alt="{HOMEIMGALT1}" src="{HOMEIMG1}" width="{IMGWIDTH1}" class="img-thumbnail pull-left imghome" /></a>
            <!-- END: image -->
            <h3>
                <!-- BEGIN: title_link --><a href="{CONTENT.link}" title="{CONTENT.title}" {CONTENT.target_blank}>{CONTENT.title}</a><!-- END: title_link -->
                <!-- BEGIN: title_text -->{CONTENT.title}<!-- END: title_text -->
            </h3>
            <div class="text-muted">
                <ul class="list-unstyled list-inline">
                    <li><em class="fa fa-clock-o">&nbsp;</em> {CONTENT.publtime}</li>
                    <li><em class="fa fa-eye">&nbsp;</em> {LANG.view}: {CONTENT.hitstotal}</li>
                </ul>
            </div>
            {CONTENT.hometext}
            <!-- BEGIN: adminlink -->
            <p class="text-right">
                <!-- BEGIN: edit --><a class="btn btn-primary btn-xs" href="{EDITLINK}"><em class="fa fa-edit"></em> {LANG_GLOBAL.edit}</a><!-- END: edit -->
                <!-- BEGIN: del --><a class="btn btn-danger btn-xs" href="#" data-toggle="author_del_content" data-href="{DELLINK}"><em class="fa fa-trash-o"></em> {LANG_GLOBAL.delete}</a><!-- END: del -->
            </p>
            <!-- END: adminlink -->
        </div>
    </div>
    <!-- END: news -->
</div>
<!-- BEGIN: generate_page -->
<div class="clearfix"></div>
<div class="text-center">
    {GENERATE_PAGE}
</div>
<!-- END: generate_page -->
<!-- END: your_articles -->

<!-- BEGIN: main -->
<!-- BEGIN: if_user -->
<div class="margin-top margin-bottom">
    <a class="btn btn-primary" href="{BASE_URL}">{LANG.your_content}</a>&nbsp;
    <!-- BEGIN: add_content --><a class="btn btn-primary" href="{BASE_URL}&amp;contentid=0&checkss={ADD_CONTENT_CHECK_SESSION}">{LANG.add_content}</a>&nbsp;
    <!-- END: add_content -->
    <a class="btn btn-primary" href="{BASE_URL}&amp;author_info=1">{LANG.author_info}</a>
</div>
<!-- END: if_user -->
<h2 class="text-center">{ADD_OR_UPDATE}</h2>
<form action="{CONTENT_URL}" method="post"<!-- BEGIN: captcha --> data-captcha="fcode"<!-- END: captcha --><!-- BEGIN: recaptcha --> data-recaptcha2="1"<!-- END: recaptcha --><!-- BEGIN: recaptcha3 --> data-recaptcha3="1"<!-- END: recaptcha3 --><!-- BEGIN: turnstile --> data-turnstile="1"<!-- END: turnstile -->>
    <div class="form-horizontal">
        <div class="form-group">
            <label class="col-sm-8 control-label text-normal">{LANG.name} <span class="txtrequired">(*)</span>:</label>
            <div class="col-sm-16">
                <input type="text" class="form-control" name="title" id="idtitle" value="{DATA.title}" />
            </div>
        </div>

        <!-- BEGIN: alias -->
        <div class="form-group">
            <label class="col-sm-8 control-label text-normal">{LANG.alias}:</label>
            <div class="col-sm-16">
                <input type="text" class="form-control pull-left" name="alias" id="idalias" value="{DATA.alias}" maxlength="255" style="width: 94%;" />
                <em class="fa fa-refresh pull-right" style="cursor: pointer; vertical-align: middle; margin: 9px 0 0 4px" data-toggle="get_alias" data-op="{OP}"></em>
            </div>
        </div>
        <!-- END: alias -->

        <div class="form-group">
            <label class="col-sm-8 control-label text-normal">{LANG.content_cat} <span class="txtrequired">(*)</span>:</label>
            <div class="col-sm-16">
                <div style="height: 130px; width: 100%; overflow: auto; text-align: left; border: solid 1px #ddd; padding: 11px;">
                    <table>
                        <tbody>
                            <!-- BEGIN: catid -->
                            <tr>
                                <td><input class="news_checkbox" name="catids[]" value="{DATACATID.value}" type="checkbox" {DATACATID.checked}>{DATACATID.title}</td>
                            </tr>
                            <!-- END: catid -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-8 control-label text-normal">{LANG.content_topic}:</label>
            <div class="col-sm-16">
                <select name="topicid" class="form-control">
                    <!-- BEGIN: topic -->
                    <option value="{DATATOPIC.value}" {DATATOPIC.selected}>{DATATOPIC.title}</option>
                    <!-- END: topic -->
                </select>
            </div>
        </div>

        <!-- BEGIN: layout_func -->
        <div class="form-group">
            <label class="col-sm-8 control-label text-normal">{LANG.pick_layout}:</label>
            <div class="col-sm-16">
                <select name="layout_func" class="form-control">
                    <option value="">{LANG.default_layout}</option>
                    <!-- BEGIN: loop -->
                    <option value="{LAYOUT_FUNC.key}" {LAYOUT_FUNC.selected}>{LAYOUT_FUNC.key}</option>
                    <!-- END: loop -->
                </select>
            </div>
        </div>
        <!-- END: layout_func -->

        <div class="form-group">
            <label class="col-sm-8 control-label text-normal">{LANG.content_homeimg}:</label>
            <div class="col-sm-16">
                <input class="form-control" name="homeimgfile" id="homeimg" value="{DATA.homeimgfile}" type="text" />
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-8 control-label text-normal">{LANG.content_homeimgalt}:</label>
            <div class="col-sm-16">
                <input maxlength="255" value="{DATA.homeimgalt}" name="homeimgalt" type="text" class="form-control" />
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-24 text-normal">{LANG.content_hometext}:</label>
            <div class="col-sm-24"><textarea class="form-control" rows="6" cols="60" name="hometext">{DATA.hometext}</textarea></div>
        </div>

        <div class="form-group">
            <label class="col-sm-24 text-normal">{LANG.content_bodytext} <span class="txtrequired">(*)</span>:</label>
            <div class="col-sm-24">{HTMLBODYTEXT}</div>
        </div>

        <div class="form-group">
            <label class="col-sm-8 control-label text-normal">{LANG.source}:</label>
            <div class="col-sm-16">
                <input maxlength="255" value="{DATA.sourcetext}" name="sourcetext" type="text" class="form-control" />
            </div>
        </div>

        <!-- BEGIN: internal_author -->
        <div class="form-group">
            <label class="col-sm-8 control-label text-normal" style="padding-top:0">{LANG.internal_author}:</label>
            <div class="col-sm-16">
                <!-- BEGIN: item -->
                <a class="btn btn-default btn-xs active" href="{ITEM.href}">{ITEM.pseudonym}</a>
                <!-- END: item -->
            </div>
        </div>
        <!-- END: internal_author -->

        <div class="form-group">
            <label class="col-sm-8 control-label text-normal">{LANG_EXTERNAL_AUTHOR}:</label>
            <div class="col-sm-16">
                <input maxlength="255" value="{DATA.author}" name="author" type="text" class="form-control" />
            </div>
        </div>
    </div>

    <!-- BEGIN: confirm -->
    <div class="alert alert-info confirm" style="padding:0 10px">
        <!-- BEGIN: data_sending -->
        <div class="checkbox">
            <label>
                <input type="checkbox" class="form-control" style="margin-top:2px" name="data_permission_confirm" value="1" data-error="{GLANG.data_warning_error}"> <small>{DATA_USAGE_CONFIRM}</small>
            </label>
        </div>
        <!-- END: data_sending -->

        <!-- BEGIN: antispam -->
        <div class="checkbox">
            <label>
                <input type="checkbox" class="form-control" style="margin-top:2px" name="antispam_confirm" value="1" data-error="{GLANG.antispam_warning_error}"> <small>{ANTISPAM_CONFIRM}</small>
            </label>
        </div>
        <!-- END: antispam -->
    </div>
    <!-- END: confirm -->

    <div class="form-inline text-center">
        <div class="form-group">
            <select class="form-control" name="status" style="width: auto">
                <!-- BEGIN: save_status -->
                <option value="{SAVE_STATUS.val}" {SAVE_STATUS.sel}>{SAVE_STATUS.name}</option>
                <!-- END: save_status -->
            </select>
            <input type="hidden" name="save" value="1" />
            <input type="submit" class="btn btn-primary" value="{GLANG.submit}"/>
        </div>
    </div>
    <br />
</form>
<!-- END: main -->
