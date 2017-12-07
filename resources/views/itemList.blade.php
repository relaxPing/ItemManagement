<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>西游寄商品仓库</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style type="text/css">
        #pull_right{
            text-align:center;
        }
        .pull-right {
            /*float: left!important;*/
        }
        .pagination {
            display: inline-block;
            padding-left: 0;
            margin: 20px 0;
            border-radius: 4px;
        }
        .pagination > li {
            display: inline;
        }
        .pagination > li > a,
        .pagination > li > span {
            position: relative;
            float: left;
            padding: 6px 12px;
            margin-left: -1px;
            line-height: 1.42857143;
            color: #ee0000;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #ddd;
        }
        .pagination > li:first-child > a,
        .pagination > li:first-child > span {
            margin-left: 0;
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }
        .pagination > li:last-child > a,
        .pagination > li:last-child > span {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }
        .pagination > li > a:hover,
        .pagination > li > span:hover,
        .pagination > li > a:focus,
        .pagination > li > span:focus {
            color: #ff0000;
            background-color: #eee;
            border-color: #ddd;
        }
        .pagination > .active > a,
        .pagination > .active > span,
        .pagination > .active > a:hover,
        .pagination > .active > span:hover,
        .pagination > .active > a:focus,
        .pagination > .active > span:focus {
            z-index: 2;
            color: #fff;
            cursor: default;
            background-color: #ee0000;
            border-color: #ee0000;
        }
        .pagination > .disabled > span,
        .pagination > .disabled > span:hover,
        .pagination > .disabled > span:focus,
        .pagination > .disabled > a,
        .pagination > .disabled > a:hover,
        .pagination > .disabled > a:focus {
            color: #777;
            cursor: not-allowed;
            background-color: #fff;
            border-color: #ddd;
        }
        .clear{
            clear: both;
        }
    </style>

</head>
<body>
<!-- 头部 -->
<!--<div class="top" style="width: auto;height: 200px;background-image: url(../public/logo-header.jpg);background-repeat:no-repeat;">
    <img src="../public/logo-header.jpg">
</div>-->
<div class="container">
    <img src="../public/logo-header.jpg" style="width:100%;height: auto;">
</div>

<!--中间区域内容-->
<div class="container" >

    <!--查询条件-->
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-inline">
                <div class="input-group">
                    <form class="form-inline" method="post" action="">
                        {{csrf_field()}}
                        <input class="form-control"  placeholder="通过商品名称查询" style="width: 240px" name="Search[name]">
                        <button type="submit" class="btn btn-default">查询</button>
                    </form>
                </div>
                <div class="input-group" >
                    <form class="form-inline" method="post" action="">
                        {{csrf_field()}}
                        <input class="form-control"  placeholder="通过商品号码查询" style="width: 240px" name="Search[num]">
                        <button type="submit" class="btn btn-default">查询</button>
                    </form>
                </div>
                <div class="input-group" >
                    <form class="form-inline" method="post" action="">
                        {{csrf_field()}}
                        <button type="submit" class="btn btn-default">显示全部</button>
                    </form>
                </div>
            </div>


        </div>
    </div>
    <!--商品列表-->
    <div class="panel panel-default">
        <div class="panel-heading">商品列表</div>
        <table class="table table-striped table-hover table-responsive">
            <thead>
            <tr>
                <th>商品名称</th>
                <th>商品号码</th>
                <th>商品数量</th>
                <th>商品单价(美元)</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{$item->name}}</td>
                <td>{{$item->code}}</td>
                <td>{{$item->quantity}}</td>
                <td>{{$item->price}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- 分页  -->
    <div>
        <div class="pull-right">
            {{$items -> render() }}
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

