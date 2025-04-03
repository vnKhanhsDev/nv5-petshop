<!-- BEGIN: main -->
<form action="" method="post">
    <div class="form-group">
        <label>Tên phụ kiện <span style="color: red;">*</span></label>
        <input type="text" name="name" class="form-control" value="{name}" required>
    </div>

    <div class="form-group">
        <label>Loại phụ kiện <span style="color: red;">*</span></label>
        <select name="type_id" id="type-select" class="form-control" required>
            <!-- BEGIN: type -->
            <option value="{ID}" {SELECTED}>{TYPE_NAME}</option>
            <!-- END: type -->
        </select>
    </div>
    
    
    <div class="form-group">
        <label>Thương hiệu <span style="color: red;">*</span></label>
        <input type="text" name="brand" class="form-control" value="{brand}" required>
    </div>

    <div class="form-group">
        <label>Xuất xứ <span style="color: red;">*</span></label>
        <input type="text" name="origin" class="form-control" value="{origin}" required>
    </div>

    <div class="form-group">
        <label>Chất liệu <span style="color: red;">*</span></label>
        <input type="text" name="material" class="form-control" value="{material}" required>
    </div>

    <div class="form-group">
        <label>Hạn sử dụng <span style="color: red;">*</span></label>
        <input type="date" name="expiration_date" class="form-control" value="{expiration_date}" required>
    </div>

    <div class="form-group">
        <label>Màu sắc <span style="color: red;">*</span></label>
        <input type="text" name="color" class="form-control" value="{color}" required>
    </div>

    <div class="form-group">
        <label>Kích cỡ <span style="color: red;">*</span></label>
        <input type="text" name="size" class="form-control" value="{size}" required>
    </div>

    <div class="form-group">
        <label>Giá phụ kiện (VND) <span style="color: red;">*</span></label>
        <input type="number" name="price" class="form-control" value="{price}" required min="0">
    </div>

    <div class="form-group">
        <label>Giảm giá (%) <span style="color: red;">*</span></label>
        <input type="number" name="discount" class="form-control" value="{discount}" required min="0" max="100">
    </div>

    <div class="form-group">
        <label>Số lượng <span style="color: red;">*</span></label>
        <input type="number" name="stock" class="form-control" value="{stock}" required min="0">
    </div>

    <div class="form-group">
        <label>Nhãn</label>
        <div id="tags-select">
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
        <textarea name="description" class="form-control">{description}</textarea>
    </div>

    <div class="form-group">
        <label>Hình ảnh phụ kiện</label>
        <input type="text" name="image" class="form-control" value="{image}">
    </div>

    <div class="form-group">
        <label>Trạng thái</label>
        <select name="is_show" class="form-control">
            <option value="1" {is_show == 1 ? 'selected' : ''}>Hiện</option>
            <option value="0" {is_show == 0 ? 'selected' : ''}>Ẩn</option>
        </select>
    </div>
    
    <!-- Nút Hủy quay lại trang trước -->
    <button type="button" class="btn btn-secondary" onclick="history.back();">Hủy</button>
    
    <!-- Nút Cập nhật -->
    <button type="submit" class="btn btn-primary">Cập nhật</button>
</form>
<script>
     let selectedTags = '{ACCESSORY.tags}'.split(',');
        document.querySelectorAll('input[name="tags[]"]').forEach(checkbox => {
            if (selectedTags.includes(checkbox.value)) {
                checkbox.checked = true;
            }
        });
</script>
<!-- END: main -->
 
