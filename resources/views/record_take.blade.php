<!--

用于展示用户提取记录

-->

@extends('common/layout')
@section('body')
<!--返回首页按钮-->
<button onclick="locate('.')" class="btn btn-basic btn-mid" style="margin: 10px 0px">返回首页</button>

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
                    <input class="form-control"  placeholder="通过顾客名字查询" style="width: 300px" name="Search[customer]">
                    <button type="submit" class="btn btn-default">查询</button>
                </form>
            </div>
        </div>


    </div>
</div>

<!--成功失败提示框-->
@include('common/message')

<!--商品列表-->
<div class="panel panel-default">
    <div class="panel-heading">提取记录</div>
    <table class="table table-striped table-hover table-responsive">
        <thead>
        <tr>
            <th>商品名称</th>
            <th>商品号码</th>
            <th>单价(美元)</th>
            <th>提取数量</th>
            <th>提取客户</th>
            <th>提取时间</th>
            <th>操作员</th>
        </tr>
        </thead>
        <tbody>
        @foreach($records as $record)
        <tr>
            <td>{{$record->name}}</td>
            <td>{{$record->code}}</td>
            <td>{{$record->price}}</td>
            <td>{{$record->quantity}}</td>
            <td>{{$record->customer}}</td>
            <td>{{date('Y-m-d',strtotime($record->created_at))}}</td>
            <td>{{$record->operator}}</td>
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