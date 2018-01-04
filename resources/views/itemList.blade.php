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
<div class="container-fluid" >

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

    <!--成功错误message-->
    @include('common/validator')
    @include('common/message')

    <!--商品列表-->
    <div class="panel panel-default">
        <div class="panel-heading">商品列表</div>
        <table class="table table-striped table-hover table-responsive">
            <thead>
            <tr>
                <th class="col-sm-4">商品名称</th>
                <th class="col-sm-3">商品号码</th>
                <th class="col-sm-1">商品数量</th>
                <th class="col-sm-1">商品重量(磅)</th>
                <th class="col-sm-2">商品单价(美元)</th>
                <th class="col-sm-1">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{$item->name}}
                    @if($item->discount != null)
                    <span class="label label-danger">{{$item->discount}} off</span>
                    @endif
                </td>
                <td>{{$item->code}}</td>
                <td>{{$item->quantity}}</td>
                <td>{{$item->weight}}
                    @if($item->weight != null)
                    <span>磅</span>
                    @endif
                </td>
                <td>${{$item->price}}</br>
                    @if($item->discount != null)
                    <span class="label label-danger">折扣价:${{$item->price - $item->discount}}</span>
                    @endif
                </td>
                <th><button class="btn btn-default" data-toggle="modal" data-target="#myModal{{$item->id}}">购买</button>
                    <!-- Modal -->
                    <div class="modal fade" id="myModal{{$item->id}}" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">商品购买</h4>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal" role="form" method="POST" action="{{url('orderLogic')}}">
                                        {{csrf_field()}}
                                        <input class="hide" name="UserOrder[price]" value="{{$item->price}}">
                                        <input class="hide" name="UserOrder[discount]" value="{{$item->discount}}">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">商品名称</label>
                                            <label class="col-sm-9 control-label " name="UserOrder[itemname]" style="text-align: left">{{$item->name}}</label>
                                            <input class="hide" name="UserOrder[itemname]" value="{{$item->name}}">
                                        </div>
                                        <div class="form-group">
                                            <label  class="col-sm-3 control-label">商品条码</label>
                                            <label class="col-sm-9 control-label " name="UserOrder[itemcode]" style="text-align: left">{{$item->code}}</label>
                                            <input class="hide" name="UserOrder[itemcode]" value="{{$item->code}}">
                                        </div>
                                        <div class="form-group">
                                            <label  class="col-sm-3 control-label">价格</label>
                                            <label class="col-sm-9 control-label "  style="text-align: left">
                                                @if($item->discount > 0)
                                                {{$item->price - $item->discount}} (原价：{{$item->price}})
                                                @else
                                                {{$item->price}}
                                                @endif
                                            </label>
                                        </div>

                                        <div class="form-group">
                                            <label  class="col-sm-3 control-label">用户姓名</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="UserOrder[username]"  id="user_name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">会员号</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="UserOrder[userid]"
                                                       placeholder="选填,如忘记可以留空" style="font-weight: 200">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">数量</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="UserOrder[quantity]">
                                            </div>
                                        </div>

                                    @include('common/validator')
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-info pull-left">确认购买</button>
                                    </form>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </th>
                <!-- Trigger the modal with a button -->
                <!--<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>
-->             <!-- Modal -->
                <!--<div id="myModal{{$item->id}}" class="modal fade" role="dialog">
                    <div class="modal-dialog">


                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">购买商品</h4>
                            </div>
                            <div class="modal-body">
                                <p>
                                <div class="form-group" style="margin: 2px 0px">
                                    <label class="control-label col-sm-3">商品名称：</label>
                                    <label class="control-label col-sm-9">{{$item->name}}</label>
                                </div>
                                </p>
                                <p>
                                <div class="form-group" style="margin: 2px 0px">
                                    <label class="control-label col-sm-3">商品号：</label>
                                    <label class="control-label col-sm-9">{{$item->code}}</label>
                                </div>
                                </p>
                                <p>
                                <div class="form-group" style="margin: 2px 0px">
                                    <label class="control-label col-sm-3" >姓名：</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="Items[name]" value="{{old('Items')['name']}}">
                                    </div>
                                </div>
                                </p>
                                <p>
                                <div class="form-group" style="margin: 2px 0px">
                                    <label class="control-label col-sm-3" >会员号：</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="Items[name]" value="{{old('Items')['name']}}" placeholder="选填，如忘记可留空">
                                    </div>
                                </div>
                                </p>
                                <p>
                                <div class="form-group" style="margin: 2px 0px">
                                    <label class="control-label col-sm-3" >数量：</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="Items[name]" value="{{old('Items')['name']}}" >
                                    </div>
                                </div>
                                </p>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>-->


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

