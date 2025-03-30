<!-- BEGIN: main -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Chi tiết đơn hàng</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered">
            <tbody>
                <tr>
                    <th>ID</th>
                    <td>{ORDER.id}</td>
                </tr>
                <tr>
                    <th>Mã đơn hàng</th>
                    <td>{ORDER.order_code}</td>
                </tr>
                <tr>
                    <th>Khách hàng</th>
                    <td>{ORDER.customer_name}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{ORDER.customer_email}</td>
                </tr>
                <tr>
                    <th>Số điện thoại</th>
                    <td>{ORDER.customer_phone}</td>
                </tr>
                <tr>
                    <th>Địa chỉ</th>
                    <td>{ORDER.customer_address}</td>
                </tr>
                <tr>
                    <th>Ngày tạo</th>
                    <td>{ORDER.created_at}</td>
                </tr>
                <tr>
                    <th>Trạng thái</th>
                    <td>{ORDER.status}</td>
                </tr>
                <tr>
                    <th>Phương thức thanh toán</th>
                    <td>{ORDER.payment_method}</td>
                </tr>
                <tr>
                    <th>Tổng giá trị</th>
                    <td>{ORDER.total_price}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="panel-heading">
        <h3 class="panel-title">Sản phẩm trong đơn hàng</h3>
    </div>
    <div class="panel-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                </tr>
            </thead>
            <tbody>
              
                <tr>
                <td>{ORDER.product_name}</td>
                <td>{ORDER.quantity}</td>
                </tr>
              
            </tbody>
        </table>
    </div>

    <div class="panel-footer text-right">
        <a href="{ORDER.back_url}" class="btn btn-default">Quay lại danh sách</a>
    </div>
</div>
<!-- END: main -->
