<!-- BEGIN: main -->
<form action="" method="post">
    <div class="form-group">
        <label>Tên phụ kiện <span style="color: red;">*</span></label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Loại phụ kiện <span style="color: red;">*</span></label>
        <select name="type_id" id="type-select" class="form-control">
            <option value="0">-- Chọn loại --</option>
            <!-- BEGIN: specie -->
            <option value="{SPECIE_ID}">{SPECIE_NAME}</option>
            <!-- END: specie -->
        </select>
    </div>
    <div class="form-group">
        <label>Giống thú cưng <span style="color: red;">*</span></label>
        <select name="breed_id" id="breed-select" class="form-control">
            <option value="">-- Chọn giống --</option>
            <!-- BEGIN: breed -->
            <option value="{BREED_ID}" data-specie="{SPECIE_ID}">{BREED_NAME}</option>
            <!-- END: breed -->
        </select>
    </div>
    <div class="form-group">
        <label>Giới tính <span style="color: red;">*</span></label>
        <div>
            <label class="radio-inline">
                <input type="radio" name="gender" value="male" required> Đực
            </label>
            <label class="radio-inline">
                <input type="radio" name="gender" value="female" required> Cái
            </label>
        </div>
    </div>
    <div class="form-group">
        <label>Tuổi thú cưng (tháng) <span style="color: red;">*</span></label>
        <input type="number" name="age" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Màu lông <span style="color: red;">*</span></label>
        <input type="text" name="fur_color" class="form-control">
    </div>
    <div class="form-group">
        <label>Cân nặng (kg) <span style="color: red;">*</span></label>
        <input type="number" name="weight" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Nguồn gốc (trại giống, nhập khẩu, cứu hộ...) <span style="color: red;">*</span></label>
        <input type="text" name="origin" class="form-control">
    </div>
    <div class="form-group">
        <label>Tiêm phòng <span style="color: red;">*</span></label>
        <div>
            <label class="radio-inline">
                <input type="radio" name="is_vaccinated" value="1" required onchange="toggleVaccinationDetails()"> Đã tiêm
            </label>
            <label class="radio-inline">
                <input type="radio" name="is_vaccinated" value="0" required onchange="toggleVaccinationDetails()"> Chưa tiêm
            </label>
        </div>
    </div>
    <div class="form-group">
        <label>Danh sách các mũi tiêm <span style="color: red;">*</span></label>
        <input type="text" name="vaccination_details" id="vaccination_details" class="form-control" disabled>
    </div>
    <div class="form-group">
        <label>Giá thú cưng (Đơn vị: VND) <span style="color: red;">*</span></label>
        <input type="number" name="price" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Giảm giá (%) <span style="color: red;">*</span></label>
        <input type="number" name="discount" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Số lượng trong kho <span style="color: red;">*</span></label>
        <input type="number" name="stock" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Tags <span style="color: red;">*</span></label>
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
        <label>Mô tả thú cưng</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <label>Hình ảnh về thú cưng <span style="color: red;">*</span></label>
        <input type="text" name="image" class="form-control">
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

<script>
    document.getElementById('specie-select').addEventListener('change', function () {
        var specie_id = this.value;
        var breedSelect = document.getElementById('breed-select');
    
        // Hiển thị lại tất cả các giống trước khi lọc
        var options = breedSelect.querySelectorAll('option[data-specie]');
        options.forEach(option => {
            if (specie_id === '' || option.getAttribute('data-specie') === specie_id) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });
    
        // Reset giá trị chọn giống
        breedSelect.value = '';
    });

    function toggleVaccinationDetails() {
    var isVaccinated = document.querySelector('input[name="is_vaccinated"]:checked').value;
    var inputField = document.getElementById('vaccination_details');

    if (isVaccinated === "1") {
        inputField.removeAttribute('disabled');
    } else {
        inputField.setAttribute('disabled', 'disabled');
        inputField.value = ""; // Xóa dữ liệu khi chọn "Chưa tiêm"
    }
}
</script>    
<!-- END: main -->