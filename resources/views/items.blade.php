<!--
用于展示商品列表
-->

@extends('common/layout')
@section('body')
<!--返回首页按钮-->
@include('common/back')

<!--查询条件-->

<div class="panel panel-default">
    <div class="panel-heading">
        <a href="{{url('create')}}"><button class="btn btn-default">新建商品</button></a>
    </div>
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
    <div class="panel-heading">商品列表</div>
    <table class="table table-striped table-hover table-responsive">
        <thead>
            <tr>
                <th>商品名称</th>
                <th>商品号码</th>
                <th>商品数量</th>
                <th>商品单价(美元)</th>
                <th>价格备注</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td class="col-sm-4">{{$item->name}}
                @if($item->discount != null)
                    <span class="label label-danger">{{$item->discount}} off</span>
                @endif
                </td>
                <td class="col-sm-3">{{$item->code}}</td>
                <td class="col-sm-1">{{$item->quantity}}</td>
                <td class="col-sm-1">{{$item->price}}</br>
                    @if($item->discount != null)
                    <span class="label label-danger">折扣价:{{$item->price - $item->discount}}</span>
                    @endif
                </td>
                <td class="col-sm-1">{{$item->priceComment}}</td>
                <td class="col-sm-2">
                    <a href="{{ url('modify',['id'=>$item->id ])}}"><button class="btn btn-default">修改/查看</button></a>
                    <a href="{{ url('itemDelete',['id'=>$item->id])}}" onclick="if(confirm('确定要执行删除吗？注意：删除操作不可恢复！')== false) return false"><button class="btn btn-danger">删除</button></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- 分页  -->
<div>
    <div class="pull-right">
        {{$items -> render()}}
    </div>
</div>
@stop