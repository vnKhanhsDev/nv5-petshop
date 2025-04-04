<!-- BEGIN: main -->
<div class="container">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6 text-center">
                    <img src="{accessories.image}" alt="{accessories.name}" class="img-responsive img-thumbnail" style="max-height: 300px; max-width: 100%;">
                </div>
                <div class="col-md-6">

                    <h3 class="text-dark"><strong>{accessories.name}</strong></h3>
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Loại phụ kiện</th>
                            <td>{TYPE_NAME}</td>
                        </tr>
                        <tr>
                            <th>Thương hiệu</th>
                            <td>{accessories.brand}</td>
                        </tr>
                        <tr>
                            <th>Chất liệu</th>
                            <td>{accessories.material}</td>
                        </tr>
                        <tr>
                            <th>Xuất xứ</th>
                            <td>{accessories.origin}</td>
                        </tr>
                        <tr>
                            <th>Hạn sử dụng</th>
                            <td>{accessories.expiration_date}</td>
                        </tr>
                        <tr>
                            <th>Màu sắc</th>
                            <td>{accessories.color}</td>
                        </tr>
                        <tr>
                            <th>Kích cỡ</th>
                            <td>{accessories.size} kg</td>
                        </tr>
                        <tr>
                            <th>Giá</th>
                            <td class="text-success"><strong>{accessories.price} VND</strong></td>
                        </tr>
                        <tr>
                            <th>Giảm giá</th>
                            <td class="text-danger"><strong>{accessories.discount}%</strong></td>
                        </tr>
                        <tr>
                            <th>Số lượng trong kho</th>
                            <td class="text-info">{accessories.stock}</td>
                        </tr>
                        <tr>
                            <th>Đánh giá</th>
                            <td class="text-warning">{accessories.rating} ⭐</td>
                        </tr>
                        <tr>
                            <th>Nhãn phụ kiện</th>
                            <td>{accessories.tags}</td>
                        </tr>
                    </table>
                    <p><strong>Mô tả:</strong> {accessories.description}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: main -->
