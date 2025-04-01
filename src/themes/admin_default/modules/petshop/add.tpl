<!-- BEGIN: main -->
<h2>Thêm bài viết mới</h2>
<form action="{SAVE_URL}" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Tiêu đề bài viết</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <div class="form-group">
        <label for="description">Mô tả ngắn</label>
        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
    </div>
    <div class="form-group">
        <label for="image">Hình ảnh minh họa</label>
        <input type="file" class="form-control" id="image" name="image">
    </div>
    <div class="form-group">
        <label for="content">Nội dung bài viết</label>
        <textarea class="form-control" id="content" name="content" rows="10" required></textarea>
    </div>
    
    <div class="form-group">
        <label for="tags">Nhãn bài viết</label>
        <input type="text" class="form-control" id="tags" name="tags" placeholder="Ví dụ: health,care">
    </div>
    <div class="form-group">
        <label for="status">Trạng thái</label>
        <select class="form-control" id="status" name="status">
            <option value="1">Hiển thị</option>
            <option value="0">Ẩn</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Thêm bài viết</button>
    <a href="javascript:history.back()" class="btn btn-secondary">Hủy</a>
</form>
<!-- END: main -->
