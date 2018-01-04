<!--
用于展示用户订单的页面
-->
<?php
    /*把isopend变成yes*/
    foreach ($unopenedOrders as $unopenedOrder){
        $unopenedOrder->isOpened = 1;
        $unopenedOrder->save();
    }
?>

@extends('common/layout')
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
                    <input class="form-control"  placeholder="通过客人姓名查询" style="width: 300px" name="UserOrder[username]">
                    <button type="submit" class="btn btn-default">查询</button>
                </form>
            </div>
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
            <div class="input-group" >
                <form class="form-inline" method="post" action="">
                    {{csrf_field()}}
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
    <table class="table table-striped table-hover table-responsive">
        <thead>
        <tr>
            <th>商品名称</th>
            <th>商品号码</th>
            <th>订购数量</th>
            <th>价格</th>
            <th>客人姓名</th>
            <th>客人id</th>
            <th>订购时间</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
        <tr>
            <td class="col-sm-4">{{$order->itemname}}</td>
            <td class="col-sm-2">{{$order->itemcode}}</td>
            <td class="col-sm-1">{{$order->quantity}}</td>
            <td class="col-sm-1">
                @if($order->discount != null)
                {{$order->price}}<br><span class="label label-danger">折扣价:{{$order->price - $order->discount}}</span>
                @else
                {{$order->price}}
                @endif
            </td>
            <td class="col-sm-1">{{$order->username}}</td>
            <td class="col-sm-1">{{$order->userid}}</td>
            <td class="col-sm-2">{{$order->created_at}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
<!-- 分页  -->
<div>
    <div class="pull-right">
        {{$orders -> render()}}
    </div>
</div>
@stop