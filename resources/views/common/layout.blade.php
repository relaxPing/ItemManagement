<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>西游寄商品仓库</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        a{
            text-decoration: none;
            color: black;
        }
    </style>

</head>
<body>
<!-- 头部 -->
<div class="jumbotron" style="height: 120px">
    <div class="container-fluid form-inline">
        <h2 style="text-align: center">西游寄商品仓库     <a href="?logout=1" class="btn btn-danger btn-sm" style="margin: 0;100px">登出</a></h2>
    </div>
</div>
<!--中间区域内容-->
<div class="container-fluid">
    <!--<button onclick="{location.href='http://www.qq.com'}">新增商品</button>-->
    @yield('body')

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
@section('javascript')
@show
</body>
</html>

<?php
session_start();

if(isset($_GET['logout'])){
    $logout=$_GET['logout'];
    if($logout ==1)
        $_SESSION['login']=0;
}


if(isset($_SESSION['login'])){
    if($_SESSION['login']!=39)
    {
        header("Location:login");
        exit;
    }
}else{
    header("Location:login");
    exit;
}

?>
