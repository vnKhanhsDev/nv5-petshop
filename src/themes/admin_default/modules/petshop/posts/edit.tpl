<!-- BEGIN: edit -->
<form action="{SAVE_URL}" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Tiêu đề bài viết</label>
        <input type="text" class="form-control" id="title" name="title" value="{POST.title}" required>
    </div>
    
    <div class="form-group">
        <label for="content">Nội dung bài viết</label>
        <textarea class="form-control" id="content" name="content" rows="10" required>{POST.content}</textarea>
    </div>

    <div class="form-group">
        <label for="image">Ảnh đại diện</label>
        <input type="file" class="form-control-file" id="image" name="image">
        <br>
        <img src="{POST.image}" alt="Ảnh bài viết" style="max-width: 200px; margin-top: 10px;">
    </div>

    <div class="form-group">
        <label for="status">Trạng thái</label>
        <select class="form-control" id="status" name="status">
            <option value="1" {IF POST.status == 1}selected{/IF}>Hiển thị</option>
            <option value="0" {IF POST.status == 0}selected{/IF}>Ẩn</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
    <a href="javascript:history.back()" class="btn btn-secondary">Hủy</a>
</form>
<!-- END: edit -->
