<!DOCTYPE html>
<html lang="en">
<?php include("element/header.php"); ?>
<script type="text/javascript">
$('#alert').css('visibility', 'visible');
</script>
<body>

    <div id="wrapper">

        <?php include("element/nav_bar.php"); ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Lấy ID tất cả post trên Page</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <form method="post" role="form" id="form_scan">
                         <div class="form-group">
                            <label>UID fanpage</label>
                            <input name="id_page" class="form-control" placeholder="ID fanpage cần quét" >
                         </div>
                        <div class="form-group">
                            <label>Token Full quyền</label>
                            <input name="token_fb" class="form-control" placeholder="Token Full quyền" >
                         </div>
                    <button type="submit" class="btn btn-default">Get ID posts</button>
                    </form>
                    <div class="panel-body" id="alert" style="visibility:hidden">
                        <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5>Đang tiến hành quét, vui lòng chờ trong đôi chút.</h5>
                        </div>
                    </div>
                    
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
        <script src="../vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript">
$(document).ready(function()
{  
    //khai báo nút submit form
    var submit   = $("button[type='submit']");
     
    //khi thực hiện kích vào nút Login
    submit.click(function()
    {
        //khai báo các biến
        var id_page = $("input[name='id_page']").val(); //lấy giá trị input tài khoản
        var token_fb = $("input[name='token_fb']").val(); //lấy giá trị input mật khẩu
         
        //kiem tra xem da nhap tai khoan chua
        if(id_page == ''){
            alert('Vui lòng nhập ID page');
            return false;
        }
         
        //kiem tra xem da nhap mat khau chua
        if(token_fb == ''){
            alert('Vui lòng nhập token Full quyền');
            return false;
        }
         
        //lay tat ca du lieu trong form login
        $('#alert').css('visibility', 'visible');
        var data = $('form#form_scan').serialize();
        //su dung ham $.ajax()
        $.ajax({
        type : 'POST', //kiểu post
        url  : 'scan_post.php', //gửi dữ liệu sang trang submit.php
        data : data,
        success :  function(data)
               {                       
                        $('#alert').html(data);              
               }
        });
        return false;
    });
});
</script>


    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
