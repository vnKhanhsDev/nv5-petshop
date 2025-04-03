<!-- BEGIN: main -->
<div class="table-responsive">
    
    <!-- Nút tạo bài viết -->
    <div class="mb-3">
        <a href="{POST.url_add}" class="btn btn-success">Tạo bài viết</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Lượt xem</th>
                <th>Thích</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td>{POST.id}</td>
                <td>{POST.title}</td>
                <td>{POST.views}</td>
                <td>{POST.likes}</td>
                <td>
                    <span class="badge {if="{POST.status} == 1"}badge-success{else}badge-danger{/if}">
                        {POST.status_text}
                    </span>
                </td>
                <td>{POST.created_at}</td>
                <td>
                    <a href="{POST.url_detail}" class="btn btn-info btn-sm">Xem</a>
                    <a href="{POST.url_edit}" class="btn btn-warning btn-sm">Sửa</a>
                    <a href="{POST.url_delete}" class="btn btn-danger btn-sm" onclick="return confirm('Xóa bài viết này?')">Xóa</a>
                </td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>

    <!-- Hiển thị phân trang -->
    <div class="pagination">
        {PAGINATION}
    </div>
</div>
<!-- END: main -->
