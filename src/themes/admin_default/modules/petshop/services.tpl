<!-- BEGIN: empty -->
 <a href="#" class="btn btn-success">{LANG.add_product}</a>
 <div class="alert alert-info">{LANG.empty}</div>
 <!-- END: empty -->
 
 <!-- BEGIN: main -->
 <div style="margin-bottom: 16px">
    <a href="{ADD_URL}" class="btn btn-success">{LANG.add_service}</a>
 </div>
 

 <div class="table-responsive">
     <table class="table table-bordered">
         <thead>
             <tr>
                 <th>ID</th>
                 <th>Tên dịch vụ</th>
                 <th>Giá dịch vụ</th>
                 <th>Trạng thái</th>
                 <th>Thao tác</th>
             </tr>
         </thead>
         <tbody>
             <!-- BEGIN: loop -->
             <tr>
                 <td>{ROW.id}</td>
                 <td>{ROW.name}</td>
                 <td>{ROW.price} VNĐ</td>
                 <td style="font-weight: bold;">{ROW.status_text}</td>
                 <td>
                     <a href="{ROW.edit_url}" class="btn btn-success">Sửa</a>
                     <a href="{ROW.delete_url}" class="btn btn-warning">Xoá</a>
                 </td>
             </tr>
             <!-- END: loop -->
         </tbody>
     </table>
 </div>
 <!-- END: main -->