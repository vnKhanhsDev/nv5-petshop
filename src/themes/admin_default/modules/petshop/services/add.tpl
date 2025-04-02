<!-- BEGIN: add -->
 <form action="" method="post">
     <div class="form-group">
         <label>Tên dịch vụ</label>
         <input type="text" name="name" class="form-control" required>
     </div>
     <div class="form-group">
         <label>Giá dịch vụ</label>
         <input type="number" name="price" class="form-control" required>
     </div>
     <div class="form-group">
         <label>Giảm giá(%)</label>
         <input type="number" name="discount" class="form-control" required>
     </div>
     <div class="form-group">
         <label>Thời gian thực hiện ước tính (phút)</label>
         <input type="number" name="estimated_time" class="form-control" required>
     </div>
     <div class="form-group">
         <label>Có cần đặt lịch hẹn trước không? (1: Có, 0: Không)</label>
         <input type="number" name="requires_appointment" class="form-control" required>
     </div>
     <div class="form-group">
         <label>Mô tả dịch vụ</label>
         <textarea name="description" class="form-control"></textarea>
     </div>
     <div class="form-group">
         <label>Hình ảnh</label>
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
 <!-- END: add -->