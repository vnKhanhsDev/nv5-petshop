<!-- BEGIN: empty -->
<a href="#" class="btn btn-success">{LANG.add_accessories}</a>
<div class="alert alert-info">{LANG.empty}</div>
<!-- END: empty -->
<!-- BEGIN: main -->
<a href="{ADD_URL}" class="btn btn-success">{LANG.add_accessories}</a>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Giá sản phẩm</th>
                <th>Số lượng tồn kho</th>
                <th>Trạng thái</th>
                <th>Màu sắc</th>
                <th>Kích cỡ</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td>{ROW.id}</td>
                <td>{ROW.name}</td>
                <td>{ROW.brand}</td>
                <td>{ROW.origin}</td>
                <td>{ROW.expiration_date}</td>
                <td>{ROW.color}</td>
                <td>{ROW.size}</td>
                <td>{ROW.price}</td>
                <td>{ROW.stock}</td>
                <td>
                    <a href="" class="btn btn-success">Chi tiết</a>
                    <a href="{ROW.edit_url}" class="btn btn-success">Sửa</a>
                    <a href="{ROW.delete_url}" class="btn btn-warning">Xoá</a>
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