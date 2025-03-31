<!-- BEGIN: main -->
<form action="" method="post">
    <div class="form-group">
        <label>Tên phụ kiện <span style="color: red;">*</span></label>
        <input type="text" name="name" class="form-control" required>
    </div>
    
    <div class="form-group">
        <label>Loại phụ kiện <span style="color: red;">*</span></label>
        <select name="type_id" id="type-select" class="form-control" required>
            <option value="">-- Chọn loại --</option>
            <!-- BEGIN: type -->
            <option value="{ID}">{TYPE_NAME}</option>
            <!-- END: type -->
        </select>
    </div>
    
    <div class="form-group">
        <label>Thương hiệu <span style="color: red;">*</span></label>
        <input type="text" name="brand" class="form-control" required>
    </div>
    
    <div class="form-group">
        <label>Xuất xứ <span style="color: red;">*</span></label>
        <input type="text" name="origin" class="form-control" required>
    </div>
    
    <div class="form-group">
        <label>Chất liệu <span style="color: red;">*</span></label>
        <input type="text" name="material" class="form-control" required>
    </div>
    
    <div class="form-group">
        <label>Hạn sử dụng <span style="color: red;">*</span></label>
        <input type="date" name="expiration_date" class="form-control" required>
    </div>
    
    <div class="form-group">
        <label>Màu sắc <span style="color: red;">*</span></label>
        <input type="text" name="color" class="form-control" required>
    </div>
    
    <div class="form-group">
        <label>Kích cỡ <span style="color: red;">*</span></label>
        <input type="text" name="size" class="form-control" required>
    </div>
    
    <div class="form-group">
        <label>Giá phụ kiện (VND) <span style="color: red;">*</span></label>
        <input type="number" name="price" class="form-control" required min="0">
    </div>
    
    <div class="form-group">
        <label>Giảm giá (%) <span style="color: red;">*</span></label>
        <input type="number" name="discount" class="form-control" required min="0" max="100">
    </div>
    
    <div class="form-group">
        <label>Số lượng <span style="color: red;">*</span></label>
        <input type="number" name="stock" class="form-control" required min="0">
    </div>
    
    <div class="form-group">
        <label>Tags</label>
        <div>
            <label class="checkbox-inline">
                <input type="checkbox" name="tags[]" value="new"> New
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" name="tags[]" value="hot"> Hot
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" name="tags[]" value="best-seller"> Best Seller
            </label>
        </div>
    </div>
    
    <div class="form-group">
        <label>Mô tả phụ kiện</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    
    <div class="form-group">
        <label>Hình ảnh phụ kiện</label>
        <input type="text" name="image" class="form-control">
    </div>
    
    <div class="form-group">
        <label>Trạng thái</label>
        <select name="is_show" class="form-control">
            <option value="1">Hiện</option>
            <option value="0">Ẩn</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Lưu</button>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let dateInput = document.querySelector('input[name="expiration_date"]');
        let today = new Date().toISOString().split('T')[0];
        dateInput.value = today;
    });
</script>
<!-- END: main -->
