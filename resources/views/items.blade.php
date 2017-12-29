<!--
用于展示商品列表
-->

@extends('common/layout')
@section('body')
<!--返回首页按钮-->
@include('common\back')

<!--查询条件-->

<div class="panel panel-default">
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
                <td style="width:200px; white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{$item->name}}</td>
                <td>{{$item->code}}</td>
                <td>{{$item->quantity}}</td>
                <td>{{$item->price}}</td>
                <td>{{$item->priceComment}}</td>
                <td><a href="{{ url('modify',['code'=>$item->code ])}}">修改/查看</a></td>
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