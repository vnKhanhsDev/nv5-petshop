<!-- BEGIN: empty -->
<a href="#" class="btn btn-success">{LANG.add_product}</a>
<div class="alert alert-info">{LANG.empty}</div>
<!-- END: empty -->

<!-- BEGIN: main -->
<a href="{ADD_URL}" class="btn btn-success">{LANG.add_product}</a>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Giá sản phẩm</th>
                <th>Số lượng tồn kho</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td>{ROW.id}</td>
                <td>{ROW.name}</td>
                <td>{ROW.price}</td>
                <td>{ROW.quantity}</td>
                <td>{ROW.status}</td>
                <td>
                    <a href="{ROW.edit_url}" class="btn btn-success">Sửa</a>
                    <a href="{ROW.delete_url}" class="btn btn-warning">Xoá</a>
                </td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>
</div>
<!-- END: main -->