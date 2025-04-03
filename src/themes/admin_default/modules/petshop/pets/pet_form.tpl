<!-- BEGIN: main -->
<form action="" class="container-fluid" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label>Mã thú cưng</label>
                <input type="number" name="id" class="form-control" required>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Loài thú cưng</label>
                <select name="species_id" id="specie-select" class="form-control">
                    <option value="0">-- Chọn loài --</option>
                    <!-- BEGIN: specie -->
                    <option value="{SPECIE_ID}">{SPECIE_NAME}</option>
                    <!-- END: specie -->
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Giống thú cưng</label>
                <select name="breed_id" id="breed-select" class="form-control">
                    <option value="">-- Chọn giống --</option>
                    <!-- BEGIN: breed -->
                    <option value="{BREED_ID}" data-specie="{SPECIE_ID}">{BREED_NAME}</option>
                    <!-- END: breed -->
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Tên thú cưng</label>
                <input type="text" name="name" class="form-control" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label>Giới tính</label>
                <div id="gender-select">
                    <label class="radio-inline">
                        <input type="radio" name="gender" value="male" required> Đực
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="gender" value="female" required> Cái
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
                <label>Màu lông</label>
                <input type="text" name="fur_color" class="form-control" required>
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
        <div class="col-md-7">
            <div class="form-group">
                <label>Nguồn gốc (trại giống, nhập khẩu, cứu hộ,...)</label>
                <input type="text" name="origin" class="form-control" required>
            </div>
        </div>
        <div class="col-md-5">
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
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Tiêm phòng</label>
                <div id="is_vaccinated-select">
                    <label class="radio-inline">
                        <input type="radio" name="is_vaccinated" value="1"> Đã tiêm
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="is_vaccinated" value="0"> Chưa tiêm
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <div class="form-group">
                <label>Chi tiết các mũi tiêm</label>
                <input type="text" name="vaccination_details" class="form-control">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Giá thú cưng</label>
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
        <div class="col-md-3">
            <div class="form-group">
                <label>Số lượng</label>
                <div class="input-group">
                    <input type="number" name="stock" class="form-control">
                    <div class="input-group-addon">bé</div>
                  </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-24">
            <div class="form-group">
                <label>Mô tả</label>
                <input type="textare" name="description" class="form-control">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Hình ảnh minh hoạ</label>
                <input type="file" name="image[]" multiple="multiple" accept="image/*">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Hiển thị</label>
                <div id="status-select">
                    <label class="radio-inline">
                        <input type="radio" name="status" value=1> Hiện
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="status" value=0> Ẩn
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Đánh giá</label>
                <input type="number" name="rating" class="form-control" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Tạo lúc</label>
                <input type="number" name="created_at" class="form-control" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Cập nhật gần nhất</label>
                <input type="number" name="updated_at" class="form-control" required>
            </div>
        </div>
    </div>
    <button type="submit" name="submit-pet" id="btn-submit" class="btn btn-primary">Lưu</button>
    <button type="reset" id="btn-cancel" class="btn btn-primary">Huỷ</button>
</form>

<script>
    $action = '{ACTION}';

    let id_input = document.querySelector('input[name="id"]');
    id_input.value = '{NEW_PET_ID}' || '{PET_ID}';
    id_input.readOnly = true;
    
    if ($action === 'add') {
        
        processingAddForm();

    } else if ($action === 'detail') {
        
        processingDetailForm();
        
    } else if ($action === 'edit') {
        document.querySelector('input[name="specie_name"]').style.display = 'none';
        document.querySelector('input[name="breed_name"]').style.display = 'none';

        var specieSelect = document.getElementById('specie-select');
        var specieOptions = specieSelect.options;
        for (var i = 0; i < specieOptions.length; i++) {
            if (specieOptions[i].value === '{PET.species_id}') {
                specieOptions[i].selected = true; // Đánh dấu option đã chọn
                break;
            }
        }

        var breedSelect = document.getElementById('breed-select');
        var breedOptions = breedSelect.options;
        console.log(breedOptions);
        for (var i = 0; i < breedOptions.length; i++) {
            if (breedOptions[i].value === '{PET.breed_id}') {
                breedOptions[i].selected = true; // Đánh dấu option đã chọn
                break;
            }
        }

        filterBreedBySpecie();

        fillFormWithPetData();

        document.querySelector('input[name="rating"]').readOnly = true;
        document.querySelector('input[name="created_at"]').readOnly = true;
        document.querySelector('input[name="updated_at"]').readOnly = true;

    } else {
        alert('Warning Error!');
    }

    function processingAddForm() {
        filterBreedBySpecie();

        document.querySelector('input[name="rating"]').value = 0;
        document.querySelector('input[name="rating"]').readOnly = true;
        document.querySelector('input[name="created_at"]').value = 0;
        document.querySelector('input[name="created_at"]').readOnly = true;
        document.querySelector('input[name="updated_at"]').value = 0;
        document.querySelector('input[name="updated_at"]').readOnly = true;
    }

    function processingDetailForm() {
        document.querySelectorAll('input').forEach(input => {
            if (input.type === 'radio' || input.type === 'checkbox') {
                input.disabled = true;
            } else {
                input.readOnly = true;
            }
        });

        let selectedTags = '{PET.tags}'.split(',');
        document.querySelectorAll('input[name="tags[]"]').forEach(checkbox => {
            if (selectedTags.includes(checkbox.value)) {
                checkbox.checked = true;
            }
        });
        
        document.getElementById('breed-select').style.display = 'none';

        fillFormWithPetData();

        $gender = '{PET.gender}' === 'male' ? 'male' : 'female';
        document.querySelector(`input[name="gender"][value="${$gender}"]`).checked = true;

        document.querySelector('input[name="age"]').value = '{PET.age}';

        document.querySelector('input[name="fur_color"]').value = '{PET.fur_color}';

        document.querySelector('input[name="weight"]').value = '{PET.weight}';

        document.querySelector('input[name="origin"]').value = '{PET.origin}';

        document.querySelector('input[name="price"]').value = '{PET.price}';

        document.querySelector('input[name="discount"]').value = '{PET.discount}';

        document.querySelector('input[name="stock"]').value = '{PET.stock}';

        console.log('{PET.tags}');

        $isVaccinated = '{PET.is_vaccinated}' === '1' ? '1' : '0';
        document.querySelector(`input[name="is_vaccinated"][value="${$isVaccinated}"]`).checked = true;

        document.querySelector('input[name="vaccination_details"]').value = '{PET.vaccination_details}';

        document.querySelector('input[name="description"]').value = '{PET.description}';

        document.querySelector('input[name="image"]').value = '{PET.image}';

        $status = '{PET.is_show}' === '1' ? '1' : '0';
        document.querySelector(`input[name="status"][value="${$status}"]`).checked = true;

        document.querySelector('input[name="rating"]').value = '{PET.rating}';

        document.querySelector('input[name="created_at"]').value = '{PET.created_at}';

        document.querySelector('input[name="updated_at"]').value = '{PET.updated_at}';

        document.querySelectorAll('button').forEach(button => {
            button.style.display = 'none';
        });
    }

    function filterBreedBySpecie() {
        var specieSelect = document.getElementById('specie-select');
        var breedSelect = document.getElementById('breed-select');
        var breedOptions = Array.from(breedSelect.querySelectorAll('option[data-specie]'));

        function updateBreedOptions(specie_id) {
            // Ẩn tất cả các tùy chọn
            breedOptions.forEach(option => option.style.display = 'none');

            // Hiển thị các tùy chọn tương ứng với specie_id
            if (specie_id !== '0') {
                breedOptions.forEach(option => {
                    if (option.getAttribute('data-specie') === specie_id) {
                        option.style.display = 'block';
                    }
                });
            }

            // Reset giá trị của select
            breedSelect.value = '';
        }

        // Gán sự kiện onchange
        specieSelect.addEventListener('change', function () {
            updateBreedOptions(this.value);
        });

        // Gọi hàm cập nhật ngay khi trang load
        updateBreedOptions(specieSelect.value);
    }

    function fillFormWithPetData() {
        var specieSelect = document.getElementById('specie-select');
        var specieOptions = specieSelect.options;
        console.log(specieOptions);
        for (var i = 0; i < specieOptions.length; i++) {
            if (specieOptions[i].value === '{PET.species_id}') {
                specieOptions[i].selected = true; // Đánh dấu option đã chọn
                break;
            }
        }
        document.querySelector('input[name="breed_name"]').value = '{PET.breed_name}';

        document.querySelector('input[name="name"]').value = '{PET.name}';

        $gender = '{PET.gender}' === 'male' ? 'male' : 'female';
        document.querySelector(`input[name="gender"][value="${$gender}"]`).checked = true;

        document.querySelector('input[name="age"]').value = '{PET.age}';
        document.querySelector('input[name="fur_color"]').value = '{PET.fur_color}';
        document.querySelector('input[name="weight"]').value = '{PET.weight}';
        document.querySelector('input[name="origin"]').value = '{PET.origin}';
        document.querySelector('input[name="price"]').value = '{PET.price}';
        document.querySelector('input[name="discount"]').value = '{PET.discount}';
        document.querySelector('input[name="stock"]').value = '{PET.stock}';
        document.querySelector('input[name="tags"]').value = '{PET.tags}';

        var isVaccinatedInput = document.querySelector('input[name="is_vaccinated"]');
        isVaccinatedInput.value = '{PET.is_vaccinated}' === '1' ? 'Đã tiêm' : 'Chưa tiêm';

        document.querySelector('input[name="vaccination_details"]').value = '{PET.vaccination_details}';
        document.querySelector('input[name="description"]').value = '{PET.description}';

        document.querySelector('input[name="rating"]').value = '{PET.rating}';
        document.querySelector('input[name="created_at"]').value = '{PET.created_at}';
        document.querySelector('input[name="updated_at"]').value = '{PET.updated_at}';
    }
</script>
<!-- END: main -->