<!-- BEGIN: main -->
<link type="text/css" href="{ASSETS_STATIC_URL}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
<script type="text/javascript" src="{ASSETS_STATIC_URL}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{ASSETS_LANG_STATIC_URL}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>

<form action="{FORM_ACTION}" name="fsea" method="get" id="fsea" class="form-horizontal">
    <div class="panel panel-default">
        <div class="panel-body">
            <h3 class="text-center"><em class="fa fa-search">&nbsp;</em>{LANG.info_title}</h3>
            <hr />
            <div class="form-group">
                <label class="col-sm-7 control-label">{LANG.key_title}</label>
                <div class="col-sm-17">
                    <input type="text" name="q" value="{KEY}" class="form-control" id="key" maxlength="{NV_MAX_SEARCH_LENGTH}" data-minlength="{NV_MIN_SEARCH_LENGTH}" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-7 control-label">{LANG.type_title}</label>
                <div class="col-sm-17">
                    <select name="choose" id="choose" class="form-control">
                        <option value="0" {CHECK1}>{LANG.find_all} </option>
                        <option value="1" {CHECK1}>{LANG.find_content} </option>
                        <option value="2" {CHECK2}>{LANG.find_author} </option>
                        <option value="3" {CHECK3}>{LANG.find_resource} </option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-7 control-label">{LANG.search_cat}</label>
                <div class="col-sm-17">
                    <select name="catid" class="form-control">
                        <!-- BEGIN: search_cat -->
                        <option value="{SEARCH_CAT.catid}" {SEARCH_CAT.select}>{SEARCH_CAT.title}</option>
                        <!-- END: search_cat -->
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-7 control-label">{LANG.from_date}</label>
                <div class="col-sm-17">
                    <div class="input-group">
                        <input type="text" class="form-control" name="from_date" id="from_date" value="{FROM_DATE}" maxlength="10" autocomplete="off">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" id="from-btn">
                                <em class="fa fa-calendar fa-fix">&nbsp;</em>
                            </button></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-7 control-label">{LANG.to_date}</label>
                <div class="col-sm-17">
                    <div class="input-group">
                        <input type="text" class="form-control" name="to_date" id="to_date" value="{TO_DATE}" maxlength="10" autocomplete="off">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" id="to-btn">
                                <em class="fa fa-calendar fa-fix">&nbsp;</em>
                            </button></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-7 control-label">&nbsp;</label>
                <div class="col-sm-17">
                    <input type="submit" class="btn btn-primary" value="{LANG.search_title}" />
                    <a href="#" data-href="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}=seek&amp;q=" data-toggle="searchOnSite">{LANG.search_on_site}</a>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(function() {
        $("#from_date, #to_date").datepicker({
            dateFormat: nv_jsdate_get.replace('yyyy', 'yy'),
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            showOn: 'focus'
        });
        $('#to-btn').click(function() {
            $("#to_date").datepicker('show');
        });
        $('#from-btn').click(function() {
            $("#from_date").datepicker('show');
        });

    });
</script>
<!-- END: main -->
<!-- BEGIN: results -->
<div class="panel panel-default">
    <div class="panel-body">
        <h3 class="text-center"><em class="fa fa-filter">&nbsp;</em>{LANG.search_on} {TITLE_MOD}</h3>
        <hr />
        <!-- BEGIN: noneresult -->
        <p>
            <em>{LANG.search_none} : <strong class="label label-info">{KEY}</strong> {LANG.search_in_module} <strong>{INMOD}</strong></em>
        </p>
        <!-- END: noneresult -->

        <!-- BEGIN: result -->
        <div class="clearfix">
            <h3><a href="{LINK}" {TARGET_BLANK}>{TITLEROW}</a></h3>
            <div class="text-justify col-sm-24">
                <p>
                    <!-- BEGIN: result_img -->
                    <img src="{IMG_SRC}" alt="" border="0" width="{IMG_WIDTH}px" class="img-thumbnail pull-left" style="margin: 0 5px 5px 0" />
                    <!-- END: result_img -->
                    {CONTENT}
                </p>
            </div>
            <div class="text-right">
                {AUTHOR}
            </div>
            <div class="text-right">
                <strong>{LANG.source_title}: </strong><span>{SOURCE}</span>
            </div>
        </div>
        <hr />
        <!-- END: result -->
        <!-- BEGIN: pages_result -->
        <div class="text-center">
            {VIEW_PAGES}
        </div>
        <!-- END: pages_result -->

        <div class="alert alert-info">
            <p>
                <em>{LANG.search_sum_title} <strong>{NUMRECORD}</strong> {LANG.result_title}
                    <br />
                    {LANG.info_adv} </em>
            </p>
        </div>

        <h4><strong>{LANG.search_adv_internet} :</strong></h4>
        <div align="center">
            <form method="get" action="http://www.google.com/search" target="_top">
                <input type="hidden" name="domains" value="{MY_DOMAIN}" />

                <div class="form-group">
                    <div class="col-md-8"><img src="http://www.google.com/logos/Logo_25wht.gif" border="0" alt="Google" />
                    </div>
                    <div class="col-md-8"><input type="text" name="q" maxlength="255" value="{KEY}" id="sbi" class="form-control" />
                    </div>
                    <div class="col-md-8"><input type="submit" name="sa" value="{LANG.search_title}" id="sbb" class="btn btn-default">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8"><input type="radio" name="sitesearch" value="" checked id="ss0" /> {LANG.search_on_internet}
                    </div>
                    <div class="col-md-8"><input type="radio" name="sitesearch" value="{MY_DOMAIN}" /> {LANG.search_on_nuke} {MY_DOMAIN}
                    </div>
                    <div class="col-md-8"></div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END: results -->
