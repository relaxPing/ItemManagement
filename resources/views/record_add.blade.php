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
<!--<div class="panel panel-default">
    
    <div class="panel-body">
        <div class="form-inline">
            <div class="input-group">
                <form class="form-inline" method="post" action="">
                    {{csrf_field()}}
                    <input class="form-control"  placeholder="通过商品名称查询" style="width: 300px" name="Search[name]">
                    <button type="submit" class="btn btn-default">查询</button>
                </form>
            </div>
            <div class="input-group" >
                <form class="form-inline" method="post" action="">
                    {{csrf_field()}}
                    <input class="form-control"  placeholder="通过商品号码查询" style="width: 300px" name="Search[num]">
                    <button type="submit" class="btn btn-default">查询</button>
                </form>
            </div><br>
            <div class="input-group" style="margin-top: 5px">
                <form class="form-inline" method="post" action="">
                    {{csrf_field()}}
                    <input class="form-control"  placeholder="通过顾客名字查询" style="width: 300px" name="Search[customer]">
                    <input type="text" id="datepicker" class="form-control" placeholder="提货日期" name="Search[date]">
                    <select class="form-control" name="Search[isPaid]">
                        <option value="0">未付款</option>
                        <option value="1">已付款</option>
                        <option value="">全部</option>
                    </select>
                    <button type="submit" class="btn btn-default">查询</button>
                </form>
            </div>
        </div>


    </div>
</div>-->

<!--成功失败提示框-->
@include('common/message')

<!--商品列表-->
<!--<div class="panel panel-default">
    <div class="panel-heading">提取记录</div>
    <table class="table table-striped table-hover table-responsive">
        <thead>
        <tr>
            <th>商品名称</th>
            <th>商品号码</th>
            <th>单价(美元)</th>
            <th>提取数量</th>
            <th>合计</th>
            <th>提取客户</th>
            <th>备注</th>
            <th>提取时间</th>
            <th>操作员</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($records as $record)
        <tr>
            <td class="col-sm-3">{{$record->name}}
                @if($record->isPaid == 0)
                <span class="label label-default">未付款</span>
                @endif
            </td>
            <td class="col-sm-1">{{$record->code}}</td>
            <td class="col-sm-1">${{$record->price}}</br>
                @if($record->discount != null)
                <span class="label label-danger">折扣价:{{$record->finalPrice}}</span>
                @endif
            </td>
            <td class="col-sm-1">{{$record->quantity}}</td>
            <td class="col-sm-1">${{$record->totalPrice}}</td>
            <td class="col-sm-1">{{$record->customer}}</td>
            <td class="col-sm-1">{{$record->comment}}</td>
            <td class="col-sm-1">{{date('Y-m-d',strtotime($record->created_at))}}</td>
            <td class="col-sm-1">{{$record->operator}}</td>
            <td class="col-sm-1"><a href="{{ url('modifyRecord',['id'=>$record->id])}}"><button class="btn btn-default">修改</button></a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>-->
<!-- 分页  -->
<div>
    <div class="pull-right">
        {{$records -> render()}}
    </div>
</div>
@stop
