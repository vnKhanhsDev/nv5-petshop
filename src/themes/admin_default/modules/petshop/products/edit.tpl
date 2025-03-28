<!-- BEGIN: edit -->
<h2>Chỉnh sửa sản phẩm</h2>
<form action="{SAVE_URL}" method="post">
    <div class="form-group">
        <label for="name">Tên sản phẩm</label>
        <input type="text" class="form-control" id="name" name="name" value="{PRODUCT.name}" required>
    </div>
    <div class="form-group">
        <label for="price">Giá</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" value="{PRODUCT.price}" required>
    </div>
    <div class="form-group">
        <label for="quantity">Số lượng tồn kho</label>
        <input type="number" class="form-control" id="quantity" name="quantity" value="{PRODUCT.quantity}" required>
    </div>
    <div class="form-group">
        <label for="status">Trạng thái</label>
        <select class="form-control" id="status" name="status">
            <option value="1" {IF PRODUCT.status == 1}selected{/IF}>Còn hàng</option>
            <option value="0" {IF PRODUCT.status == 0}selected{/IF}>Hết hàng</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
    <a href="javascript:history.back()" class="btn btn-secondary">Hủy</a>
</form>
<!-- END: edit -->