<!-- BEGIN: main -->
<div class="container-fluid mt-4">
    <h2 class="mb-3 text-center">Quản lý đơn hàng</h2>
    
    <!-- Search Bar -->
    <div class="search-container mb-3">
        <form method="GET" action="{SEARCH_URL}" class="form-inline justify-content-center">
            <input type="text" name="search" class="form-control mr-2" placeholder="Tìm kiếm đơn hàng..." value="{SEARCH_QUERY}" style="width: 300px;">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center" style="width: 100%;">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Mã đơn hàng</th>
                    <th>Khách hàng</th>
                    <th>Ngày tạo</th>
                    <th>Trạng thái</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng sản phẩm</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <!-- BEGIN: order -->
                <tr>
                    <td>{ORDER.id}</td>
                    <td>{ORDER.order_code}</td>
                    <td>{ORDER.customer_name}</td>
                    <td>{ORDER.created_at}</td>
                    <td>{ORDER.status}</td>
                    <td>{ORDER.product_name}</td>
                    <td>{ORDER.quantity}</td>
                    <td>
                        <a href="{ORDER.url_detail}" class="btn btn-info btn-sm">Xem</a>
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editOrderModal" onclick="loadOrderData('{ORDER.id}', '{ORDER.status}')">Sửa</button>
                        <a href="{ORDER.url_delete}" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?');">Xóa</a>
                    </td>
                </tr>
                <!-- END: order -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal chỉnh sửa đơn hàng -->
<div class="modal fade" id="editOrderModal" tabindex="-1" role="dialog" aria-labelledby="editOrderLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOrderLabel">Cập nhật trạng thái đơn hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="update_status.php" method="POST">
                    <input type="hidden" name="id" id="order_id">
                    <div class="form-group">
                        <label for="status">Chọn trạng thái:</label>
                        <select name="status" id="status" class="form-control">
                            <option value="Đang xử lý">Đang xử lý</option>
                            <option value="Đang giao hàng">Đang giao hàng</option>
                            <option value="Đã hủy">Đã hủy</option>
                            <option value="Đã giao thành công">Đã giao thành công</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function loadOrderData(id, status) {
        document.getElementById('order_id').value = id;
        document.getElementById('status').value = status;
    }
</script>
<!-- END: main -->
