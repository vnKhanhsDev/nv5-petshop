<!-- BEGIN: main -->
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Mã đơn hàng</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: order -->
            <tr>
                <td rowspan="{ORDER.product_count}">{ORDER.id}</td>
                <td rowspan="{ORDER.product_count}">{ORDER.order_code}</td>
                <!-- BEGIN: product -->
                <td>{PRODUCT.name}</td>
                <td>{PRODUCT.price}</td>
                <td>{PRODUCT.quantity}</td>
                <td rowspan="{ORDER.product_count}">{ORDER.status}</td>
                <td rowspan="{ORDER.product_count}">
                    <a href="{ORDER.url_detail}" class="btn btn-info btn-sm">Xem chi tiết</a>
                    <a href="{ORDER.url_delete}" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?');">Xóa</a>
                </td>
            </tr>
            <!-- END: product -->
            <!-- END: order -->
        </tbody>
    </table>
</div>
<!-- END: main -->
