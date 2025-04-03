<!-- BEGIN: main -->
<form action="" class="container-fluid" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Mã thú cưng</label>
                <input type="number" name="id" class="form-control">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Loài thú cưng</label>
                <select name="species_id" id="species-select" class="form-control">
                    <option value="0">-- Chọn loài --</option>
                    <!-- BEGIN: species -->
                    <option value="{SPECIES_ID}">{SPECIES_NAME}</option>
                    <!-- END: species -->
                </select>
            </div>
        </div>
        <div class="col-md-7">
            <div class="form-group">
                <label>Giống thú cưng</label>
                <select name="breed_id" id="breed-select" class="form-control">
                    <option value="">-- Chọn giống --</option>
                    <!-- BEGIN: breed -->
                    <option value="{BREED_ID}" data-specie="{SPECIES_ID}">{BREED_NAME}</option>
                    <!-- END: breed -->
                </select>
            </div>
        </div>
        <div class="col-md-9">
            <div class="form-group">
                <label>Tên thú cưng</label>
                <input type="text" name="name" id="petNameInput" class="form-control">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Giới tính</label>
                <div id="gender-select">
                    <label class="radio-inline">
                        <input type="radio" name="gender" class="form-control" value="male"> Đực
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="gender" class="form-control" value="female"> Cái
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Tuổi</label>
                <div class="input-group">
                    <input type="number" name="age" class="form-control">
                    <div class="input-group-addon">tháng</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Cân nặng (kg)</label>
                <div class="input-group">
                    <input type="number" name="weight" class="form-control">
                    <div class="input-group-addon">kg</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Màu lông</label>
                <input type="text" name="fur_color" class="form-control" required>
            </div>
        </div>
        <div class="col-md-9">
            <div class="form-group">
                <label>Nguồn gốc (trại giống, nhập khẩu, cứu hộ,...)</label>
                <input type="text" name="origin" class="form-control" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Giá gốc</label>
                <div class="input-group">
                    <input type="number" name="price" class="form-control">
                    <div class="input-group-addon">VND</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Giảm giá (%)</label>
                <div class="input-group">
                    <input type="number" name="discount" class="form-control">
                    <div class="input-group-addon">%</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Giá bán</label>
                <div class="input-group">
                    <input type="number" name="salePrice" class="form-control">
                    <div class="input-group-addon">VND</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Số lượng</label>
                <div class="input-group">
                    <input type="number" name="stock" class="form-control">
                    <div class="input-group-addon">bé</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Nhãn</label>
                <div id="tags-select">
                    <label class="checkbox-inline">
                        <input type="checkbox" name="tags[]" class="form-control" value="new"> New
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" name="tags[]" class="form-control" value="hot"> Hot
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" name="tags[]" class="form-control" value="best-seller"> Best Seller
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Tiêm phòng</label>
                <div id="is_vaccinated-select">
                    <label class="radio-inline">
                        <input type="radio" name="is_vaccinated" class="form-control" value="1"> Đã tiêm
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="is_vaccinated" class="form-control" value="0"> Chưa tiêm
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-19">
            <div class="form-group">
                <label>Chi tiết các mũi tiêm</label>
                <input type="text" name="vaccination_details" class="form-control">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-23">
            <div class="form-group">
                <label>Mô tả</label>
                <input type="textare" name="description" class="form-control">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-23">
            <div class="form-group">
                <label>Hình ảnh minh hoạ</label>
                <input type="file" name="image[]" multiple="multiple" accept="image/*">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Hiển thị</label>
                <div id="status-select">
                    <label class="radio-inline">
                        <input type="radio" name="status" class="form-control" value=1> Hiện
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="status" class="form-control" value=0> Ẩn
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-3 block-add">
            <div class="form-group">
                <label>Đánh giá</label>
                <div class="input-group">
                    <input type="number" name="rating" class="form-control">
                    <div class="input-group-addon"><i class="fa fa-star" aria-hidden="true"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-8 block-add">
            <div class="form-group">
                <label>Tạo lúc</label>
                <div class="input-group">
                    <input type="datetime" name="created_at" class="form-control">
                    <div class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-8 block-add">
            <div class="form-group">
                <label>Cập nhật gần nhất</label>
                <div class="input-group">
                    <input type="datetime" name="updated_at" class="form-control">
                    <div class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" name="submit-pet" class="btn btn-primary">Lưu</button>
    <button type="submit" name="cancel-pet" id="cancel-btn" class="btn btn-secondary">Huỷ</button>
</form>

<script>
    $action = '{ACTION}';

    let id_input = document.querySelector('input[name="id"]');
    id_input.value = '{NEW_PET_ID}' || '{PET_ID}';
    id_input.readOnly = true;

    if ($action === 'add') {

        filterBreedBySpecies();

        document.querySelector('input[name="salePrice"]').readOnly = true;

        document.addEventListener("DOMContentLoaded", function () {
            // Lấy các input cần thiết
            let priceInput = document.querySelector("input[name='price']");
            let discountInput = document.querySelector("input[name='discount']");
            let salePriceInput = document.querySelector("input[name='salePrice']");

            function updateSalePrice() {
                let price = parseInt(priceInput.value) || 0;
                let discount = parseInt(discountInput.value) || 0;

                if (discount >= 100) {
                    salePriceInput.value = 0; // Nếu giảm giá 100% thì giá bán là 0
                } else {
                    salePriceInput.value = Math.round(price * (100 - discount) / 100);
                }
            }

            // Gán sự kiện khi thay đổi giá hoặc giảm giá
            priceInput.addEventListener("input", updateSalePrice);
            discountInput.addEventListener("input", updateSalePrice);

            // Load giá trị ban đầu từ server (nếu có)
            updateSalePrice();
        });

        document.querySelectorAll('.block-add').forEach(div => {
            div.style.display = 'none';
        });

    } else if ($action === 'detail') {

        // Chặn thay đổi thông tin các trường
        document.querySelectorAll('.form-control').forEach(block => {
            block.disabled = true;
        });

        fillFormWithPetData();

        document.querySelectorAll('button').forEach(button => {
            button.style.display = 'none';
        });

    } else if ($action === 'edit') {
        document.querySelector('input[name="salePrice"]').readOnly = true;

        document.querySelector('input[name="rating"]').readOnly = true;
        document.querySelector('input[name="created_at"]').readOnly = true;
        document.querySelector('input[name="updated_at"]').readOnly = true;

        fillFormWithPetData();

    } else {
        alert('Warning Error!');
    }

    function filterBreedBySpecies() {
        var speciesSelect = document.getElementById('species-select');
        var breedSelect = document.getElementById('breed-select');
        var breedOptions = Array.from(breedSelect.querySelectorAll('option[data-specie]'));

        function updateBreedOptions(species_id) {
            // Ẩn tất cả các tùy chọn
            breedOptions.forEach(option => option.style.display = 'none');

            // Hiển thị các tùy chọn tương ứng với specie_id
            if (species_id !== '0') {
                breedOptions.forEach(option => {
                    if (option.getAttribute('data-specie') === species_id) {
                        option.style.display = 'block';
                    }
                });
            }

            // Reset giá trị của select
            breedSelect.value = '';
        }

        // Gán sự kiện onchange
        speciesSelect.addEventListener('change', function () {
            updateBreedOptions(this.value);
        });

        // Gọi hàm cập nhật ngay khi trang load
        updateBreedOptions(speciesSelect.value);
    }

    function fillFormWithPetData() {
        // Truyền giá trị loài (species) và giống (breed)
        function selectOptionByValue(selectId, value) {
            let selectElement = document.getElementById(selectId);
            let options = selectElement.options;
            for (let i = 0; i < options.length; i++) {
                if (options[i].value === value) {
                    options[i].selected = true;
                    break;
                }
            }
        }
        selectOptionByValue('species-select', '{PET.species_id}');
        selectOptionByValue('breed-select', '{PET.breed_id}');

        document.getElementById('petNameInput').value = '{PET.name}';
        document.querySelector(`input[name="gender"][value="{PET.gender}"]`).checked = true;
        document.querySelector('input[name="age"]').value = '{PET.age}';
        document.querySelector('input[name="fur_color"]').value = '{PET.fur_color}';
        document.querySelector('input[name="weight"]').value = '{PET.weight}';
        document.querySelector('input[name="origin"]').value = '{PET.origin}';

        let selectedTags = '{PET.tags}'.split(',');
        document.querySelectorAll('input[name="tags[]"]').forEach(checkbox => {
            if (selectedTags.includes(checkbox.value)) {
                checkbox.checked = true;
            }
        });

        document.querySelector(`input[name="is_vaccinated"][value="{PET.is_vaccinated}"]`).checked = true;
        document.querySelector('input[name="vaccination_details"]').value = '{PET.vaccination_details}';
        document.querySelector('input[name="price"]').value = '{PET.price}';
        document.querySelector('input[name="discount"]').value = '{PET.discount}';
        document.querySelector('input[name="salePrice"]').value = parseInt(parseInt('{PET.price}') * ((100 - parseInt('{PET.discount}')) / 100));
        document.querySelector('input[name="stock"]').value = '{PET.stock}';
        document.querySelector('input[name="description"]').value = '{PET.description}';
        console.log('{PET.images}');
        document.querySelector(`input[name="status"][value="{PET.status}"]`).checked = true;
        document.querySelector('input[name="rating"]').value = '{PET.rating}';
        document.querySelector('input[name="created_at"]').value = '{PET.created_at}';
        document.querySelector('input[name="updated_at"]').value = '{PET.updated_at}';
    }
</script>
<!-- END: main -->