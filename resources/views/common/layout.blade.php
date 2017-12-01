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
    <div class="container">
        <h2>西游寄商品仓库</h2>

    </div>
</div>
<!--中间区域内容-->
<div class="container" >
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
