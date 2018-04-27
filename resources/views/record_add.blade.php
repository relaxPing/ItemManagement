<!--

用于展示进货记录

-->
@extends('common/layout')

@section('javascript')
<link rel="stylesheet" href="//apps.bdimg.com/libs/jqueryui/1.10.4/css/jquery-ui.min.css">
<script src="//apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//apps.bdimg.com/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script>
    $(function() {
        $( "#datepicker" ).datepicker();
    });
</script>
@stop

@section('body')
<!--返回首页按钮-->
@include('common/back')

<!--查询条件-->

<div class="panel panel-default">
    
    <div class="panel-body">
        <div class="form-inline">
            <div class="input-group">
                <form class="form-inline" method="post" action="">
                    {{csrf_field()}}
                    <input class="form-control"  placeholder="通过商品名称查询" style="width: 300px" name="Search[name]">
                    <input class="form-control"  placeholder="通过商品号码查询" style="width: 300px" name="Search[code]">
                    <button type="submit" class="btn btn-default">查询</button>
                </form>
            </div><br>
        </div>
    </div>

</div>

<!--成功失败提示框-->
@include('common/message')

<!--商品列表-->
<div class="panel panel-default">
    <div class="panel-heading">进货记录</div>
    <table class="table table-striped table-hover table-responsive">
        <thead>
        <tr>
            <th>商品名称</th>
            <th>商品号码</th>
            <th>进货数量</th>
            <th>当时库存(包含新进数)</th>
            <th>进货时间</th>
        </tr>
        </thead>
        <tbody>
        @foreach($records as $record)
        <tr>
            <td class="col-sm-2">{{$record->name}}</td>
            <td class="col-sm-2">{{$record->code}}</td>
            <td class="col-sm-2">{{$record->quantity}}</td>
            <td class="col-sm-2">{{$record->quantity_current}}</td>
            <td class="col-sm-2">{{date('Y-m-d H:i:s',strtotime($record->created_at))}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
<!-- 分页  -->
<div>
    <div class="pull-right">
        {{$records -> render()}}
    </div>
</div>
@stop
