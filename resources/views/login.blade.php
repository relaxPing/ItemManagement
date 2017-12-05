<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>西游寄商品仓库</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
<!-- 头部 -->
<div class="jumbotron" style="height: 120px">
    <div class="container form-inline">
        <h2>西游寄商品仓库</h2>
    </div>
</div>
<!--中间区域内容-->
<div class="container" >
    <div class="panel panel-default" style="width: 400px">
        <div class="panel-heading">
            管理员登陆
        </div>
        <div class="panel-body" >
            <form method="post" action="">
                {{csrf_field()}}
                <div class="form-group form-inline" >
                    <label class="control-label" style="width: 15%">用户名</label>
                    <input name="username" class="form-control" style="width: 80%">
                </div>
                <div class="form-group form-inline">
                    <label class="control-label" style="width: 15%">密码</label>
                    <input type="password" name="password" class="form-control" style="width: 80%">
                </div>
                <button type="submit" class="btn btn-info btn-md" style="width: 100px;">登陆</button>
            </form>
        </div>
    </div>

</div>
<!-- 尾部 -->
<div class="jumbotron" style="margin:0;">
    <div class="container">
        <span>  @2017 by Ping Xin</span>
    </div>
</div>

<!-- jQuery 文件 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Bootstrap JavaScript 文件 -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
    function locate(loc){
        location.href = loc ;
    }
</script>
</body>
</html>


<?php
session_start();
if(isset($_POST['username'])){
    $name = $_POST['username'];
    $password = $_POST['password'];
    $user = \App\Administrators::where(['username'=>$name,'password'=>$password])->count();
    if($user>0){
        $_SESSION['login']=39;
        header("Location: dashboard");
        exit;
    }
}
?>