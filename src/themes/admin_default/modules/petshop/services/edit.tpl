<!-- BEGIN: edit -->
 <form action="{SAVE_URL}" method="post" enctype="multipart/form-data" onsubmit="return confirmSaveChanges()">
     <div class="form-group">
         <label for="name">Tên dịch vụ</label>
         <input type="text" class="form-control" id="name" name="name" value="{SERVICE.name}" required>
     </div>
     <div class="form-group">
         <label for="price">Giá</label>
         <input type="number" step="0.01" class="form-control" id="price" name="price" value="{SERVICE.price}" required>
     </div>
     <div class="form-group">
         <label for="discount">Giảm giá(%)</label>
         <input type="number" class="form-control" id="discount" name="discount" value="{SERVICE.discount}" required>
     </div>
     <div class="form-group">
         <label for="estimated_time">Thời gian thực hiện ước tính (phút)</label>
         <input type="number" class="form-control" id="estimated_time" name="estimated_time" value="{SERVICE.estimated_time}" required>
     </div>
     <div class="form-group">
         <label for="requires_appointment">Có cần đặt lịch hẹn trước không?</label>
         <input type="number" class="form-control" id="requires_appointment" name="requires_appointment" value="{SERVICE.requires_appointment}" required>
     </div>
     <div class="form-group">
         <label for="description">Mô tả dịch vụ</label>
         <input type="text" class="form-control" id="description" name="description" value="{SERVICE.description}" required>
     </div>
     <div class="form-group">
         <label for="is_show">Trạng thái</label>
         <select class="form-control" id="is_show" name="is_show">
             <option value="1" {IF SERVICE.is_show == 1}selected{/IF}>Còn hàng</option>
             <option value="0" {IF SERVICE.is_show == 0}selected{/IF}>Hết hàng</option>
         </select>
     </div>
     <div class="form-group">
        <label for="is_show">Hình ảnh</label>
        <img src="{SERVICE.image}" alt="{SERVICE.title}" width="200" >
        <input style="margin-top: 8px;" type="file" name="image">
    </div>
     <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
     <a href="javascript:history.back()" class="btn btn-secondary">Hủy</a>
 </form>
 <script>
function confirmSaveChanges() {
    // Hiển thị alert xác nhận
    var result = confirm('Bạn có chắc chắn muốn lưu thay đổi?');
    if (result) {
        return true;  // Tiếp tục gửi form nếu người dùng chọn "OK"
    } else {
        return false; // Hủy gửi form nếu người dùng chọn "Cancel"
    }
}
</script>
 <!-- END: edit -->