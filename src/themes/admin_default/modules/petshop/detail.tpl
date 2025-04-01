<!-- BEGIN: main -->
<div class="container">
    <h2>Chi tiết bài viết</h2>
    
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td>{POST.id}</td>
        </tr>
        <tr>
            <th>Tiêu đề</th>
            <td>{POST.title}</td>
        </tr>
        <tr>
            <th>Mô tả</th>
            <td>{POST.description}</td>
        </tr>
        <tr>
            <th>Hình ảnh</th>
            <td><img src="{POST.image}" alt="Hình ảnh minh họa" class="img-fluid"></td>
        </tr>
        <tr>
            <th>Nội dung</th>
            <td>{POST.content}</td>
        </tr>
        <tr>
            <th>Lượt xem</th>
            <td>{POST.views}</td>
        </tr>
        <tr>
            <th>Lượt thích</th>
            <td>{POST.likes}</td>
        </tr>
        <tr>
            <th>Nhãn bài viết</th>
            <td>{POST.tags}</td>
        </tr>
        <tr>
            <th>Trạng thái</th>
            <td>
                <span class="badge {if POST.status == 1}badge-success{else}badge-danger{/if}">
                    {POST.status_text}
                </span>
            </td>
        </tr>
        <tr>
            <th>Ngày tạo</th>
            <td>{POST.created_at}</td>
        </tr>
        <tr>
            <th>Cập nhật gần nhất</th>
            <td>{POST.updated_at}</td>
        </tr>
    </table>

    <a href="{BACK_URL}" class="btn btn-primary">Quay lại</a>
</div>
<!-- END: main -->
