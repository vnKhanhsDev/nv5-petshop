<!-- BEGIN: empty -->
<div class="d-flex justify-content-between" style="padding-bottom: 15px;">
    <div></div>
    <div class="toolbar d-flex">
        <form action="{SEARCH_URL}" method="get" class="d-flex" style="margin-right: 30px;">
            <input type="text" name="keyword" class="form-control me-2" placeholder="Nhập tên sản phẩm..."
                value="{SEARCH_KEYWORD}">
            <button type="submit" class="btn btn-primary me-2">Tìm kiếm</button>
        </form>
        <a href="{ADD_URL}" class="btn btn-success">{LANG.add_pet}</a>
    </div>
</div>

<div class="alert alert-info" role="alert">
    <strong>Thông báo!</strong>
    {LANG.empty_pet}.
</div>
<!-- END: empty -->

<!-- BEGIN: main -->
<div class="d-flex justify-content-between" style="padding-bottom: 15px;">
    <div></div>
    <div class="toolbar d-flex align-items-center">
        <form action="{SEARCH_URL}" method="GET" class="d-flex" style="margin-right: 30px;">
            <input type="text" name="keyword" class="form-control me-2" placeholder="Nhập tên thú cưng..." value="{SEARCH_KEYWORD}">
            <button type="submit" class="btn btn-primary me-2">Tìm kiếm</button>
        </form>        

        <a href="{ADD_URL}" class="btn btn-success">{LANG.add_pet}</a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên thú cưng</th>
                <th>Loài</th>
                <th>Giống</th>
                <th style="text-align: center;">Giới tính</th>
                <th style="text-align: center;">Tuổi (tháng)</th>
                <th style="text-align: center;">Màu lông</th>
                <th style="text-align: center;">Giá (VND)</th>
                <th style="text-align: center;">Giảm giá (%)</th>
                <th style="text-align: center;">Số lượng</th>
                <th style="text-align: center;">Trạng thái</th>
                <th style="text-align: center;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td style="vertical-align: middle;">{ROW.id}</td>
                <td style="vertical-align: middle;">{ROW.name}</td>
                <td style="vertical-align: middle;">{ROW.specie_name}</td>
                <td style="vertical-align: middle;">{ROW.breed_name}</td>
                <td style="text-align: center; vertical-align: middle;">{ROW.gender}</td>
                <td style="text-align: center; vertical-align: middle;">{ROW.age}</td>
                <td style="text-align: center; vertical-align: middle;">{ROW.fur_color}</td>
                <td style="text-align: center; vertical-align: middle;">{ROW.price}</td>
                <td style="text-align: center; vertical-align: middle;">{ROW.discount}</td>
                <td style="text-align: center; vertical-align: middle;">{ROW.stock}</td>
                <td style="text-align: center; vertical-align: middle;">{ROW.status}</td>
                <td style="text-align: center; vertical-align: middle;">
                    <a href="{ROW.detail_url}" class="btn btn-info"><i class="fa fa-info-circle"
                            aria-hidden="true"></i></a>
                    <a href="{ROW.edit_url}" class="btn btn-warning"><i class="fa fa-pencil-square-o"
                            aria-hidden="true"></i></a>
                    <a href="{ROW.delete_url}" class="btn btn-danger"><i class="fa fa-trash-o"
                            aria-hidden="true"></i></a>
                </td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>
</div>

<!-- Phân trang -->
<div class="text-center">
    {GENERATE_PAGE}
</div>
<!-- END: main -->