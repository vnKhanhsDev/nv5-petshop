<!-- BEGIN: main -->
<form action="" method="post">
    <div class="form-group">
        <label>Tên sản phẩm</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Mã danh mục sản phẩm</label>
        <input type="number" name="category_id" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Giá sản phẩm (Đơn vị: VND)</label>
        <input type="text" name="price" class="form-control" required pattern="\d+" >
    </div>
    <div class="form-group">
        <label>Số lượng tồn kho</label>
        <input type="number" name="quantity" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Hình ảnh</label>
        <input type="text" name="image" class="form-control">
    </div>
    <div class="form-group">
        <label>Mô tả sản phẩm</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <label>Trạng thái</label>
        <select name="status" class="form-control">
            <option value="1">Hiện</option>
            <option value="0">Ẩn</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Lưu</button>
</form>
<!-- END: main -->
