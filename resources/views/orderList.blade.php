<!--
用于展示用户订单的页面
-->
<?php
    /*把isopend变成yes*/
    /*foreach ($unopenedOrders as $unopenedOrder){
        $unopenedOrder->isOpened = 1;
        $unopenedOrder->save();
    }*/
?>

@extends('common/layout')
@section('javascript')
<script src="js/edit.js"></script>

<link rel="stylesheet" href="//apps.bdimg.com/libs/jqueryui/1.10.4/css/jquery-ui.min.css">
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
            <div class="input-group" >
                <form class="form-inline" method="post" action="">
                    {{csrf_field()}}
                    <input class="form-control"  placeholder="通过商品名称查询" style="width: 300px" name="UserOrder[itemname]">
                    <button type="submit" class="btn btn-default">查询</button>
                </form>
            </div>
            <div class="input-group" >
                <form class="form-inline" method="post" action="">
                    {{csrf_field()}}
                    <input class="form-control"  placeholder="通过客户id查询" style="width: 300px" name="UserOrder[userid]">
                    <button type="submit" class="btn btn-default">查询</button>
                </form>
            </div>
            <br>
            <div class="input-group" style="margin-top: 10px">
                <form class="form-inline" method="post" action="">
                    {{csrf_field()}}
                    <input class="form-control"  placeholder="通过客人姓名查询" style="width: 300px" name="UserOrder[username]">
                    <input type="text" id="datepicker" class="form-control" placeholder="提货日期" name="UserOrder[date]">
                    <select class="form-control" name="UserOrder[status]">
                        <option value="0">未提货</option>
                        <option value="1">已提货，未付款</option>
                        <option value="2">已付款</option>
                        <option value="3">取消订单</option>
                        <option value="">全部</option>
                    </select>
                    <button type="submit" class="btn btn-default">查询</button>
                </form>
            </div>
            <div class="input-group" style="margin-top: 10px">
                <form class="form-inline" method="post" action="">
                    {{csrf_field()}}
                    <input class="hide" name="all" value="all">
                    <button type="submit" class="btn btn-default">显示全部</button>
                </form>
            </div>
        </div>


    </div>
</div>

<!--成功失败提示框-->
@include('common/message')

<!--商品列表-->
<div class="panel panel-default">
    <div class="panel-heading">订单列表</div>
    <table class="table table-hover table-responsive">
        <thead>
        <tr>
            <th>商品名称</th>
            <th>商品号码</th>
            <th>订购数量</th>
            <th>价格</th>
            <th>客人姓名</th>
            <th>客人id</th>
            <th>订购时间</th>
            <th>状态</th>
        </tr>
        </thead>
        <tbody>

        @foreach($orders as $order)
        @if($order-> status == 0 || $order-> status == 1)
            @if($order-> status == 0)
                <tr id="order{{$order->id}}" style="background-color:#FFDED9">
            @endif
            @if($order-> status == 1)
                <tr id="order{{$order->id}}">
            @endif
            <td class="col-sm-3">{{$order->itemname}}</td>
            <td class="col-sm-2">{{$order->itemcode}}</td>
            <td class="col-sm-1">{{$order->quantity}}</td>
            <td class="col-sm-1">
                @if($order->discount != null)
                {{$order->price}}<br><span class="label label-danger">折扣价:{{$order->finalPrice}}</span>
                @else
                {{$order->price}}
                @endif
            </td>
            <td class="col-sm-1">{{$order->username}}</td>
            <td class="col-sm-1">{{$order->userid}}</td>
            <td class="col-sm-1">{{$order->created_at}}</td>
            <!--<td class="col-sm-2"><button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">修改</button>  {{$order->status($order->status)}}  </td>-->
            <td class="col-sm-2" ><button class="btn btn-default edit" value="{{ $order->id }}">修改</button>    {{$order->status($order->status)}}</td>
        </tr>
        @else
        <tr id="order{{$order->id}}">
            <td class="col-sm-3">{{$order->itemname}}</td>
            <td class="col-sm-2">{{$order->itemcode}}</td>
            <td class="col-sm-1">{{$order->quantity}}</td>
            <td class="col-sm-1">
                @if($order->discount != null)
                {{$order->price}}<br><span class="label label-danger">折扣价:{{$order->finalPrice}}</span>
                @else
                {{$order->price}}
                @endif
            </td>
            <td class="col-sm-1">{{$order->username}}</td>
            <td class="col-sm-1">{{$order->userid}}</td>
            <td class="col-sm-1">{{$order->created_at}}</td>
            <td class="col-sm-2">{{$order->status($order->status)}}</td>
        </tr>
        @endif
        @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">修改</h4>
                </div>
                <form id="status_form" class="form-horizontal" role="form" method="POST" >
                    <!--{{csrf_field()}}-->
                    <div class="modal-body">
                        <div class="form-group">
                            <label  class="col-sm-3 control-label">状态</label>
                            <select class="form-control" style="width: auto" id="status_select">
                                @foreach($orderForStatus->status() as $k => $val)
                                <option value="{{$k}}">{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {!! csrf_field() !!}
                </form>

                <div class="modal-footer">
                    <button type="button" id="tsave" class="btn btn-info" value="update">确认</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <input type="hidden" id="tid" name="tid" value="-1">
                </div>

            </div>

        </div>
    </div>
</div>
<!-- 分页  -->
<div>
    <div class="pull-right">
        {{$orders -> render()}}
    </div>
</div>
@stop