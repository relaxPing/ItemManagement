<!--
用于从已存在商品中提取货物
-->

@extends('common/layout')
@section('body')
<!--返回首页按钮-->
@include('common/back')
<a href="{{url('record_take')}}"><button class="btn btn-basic btn-mid" style="margin: 10px 0px">查看提货记录</button></a>

<!--商品提取-->
<div class="panel panel-default" style="width: 800px">
    <div class="panel-heading">商品提取</div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" action="">
            {{ csrf_field() }}
            <div class="form-group">
                <label class="control-label col-sm-2" for="customer">提取客户：</label>
                <div class="col-sm-10">
                    <input  class="form-control" id="customer" name="Items[customer]" value="{{old('Items')['customer']}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="operator">操作员：</label>
                <div class="col-sm-10">
                    <input  class="form-control" id="operator" name="Items[operator]" value="{{old('Items')['operator']}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="operator">是否付款：</label>
                <div class="col-sm-10">
                    <!--<input  class="form-control" id="operator" name="Items[operator]" value="{{old('Items')['operator']}}">-->
                    <select class="form-control" name="Items[isPaid]" style="width: ">
                        <option value="0" name="Items[isPaid]">未付款</option>
                        <option value="1" name="Items[isPaid]">已付款</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="quantity">备注：</label>
                <div class="col-sm-10">
                    <input  class="form-control" id="comment" name="Items[comment]" value="" placeholder="选填(付款方式+操作员)">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="quantity">提取数量：</label>
                <div class="col-sm-10">
                    <input  class="form-control" id="quantity" name="Items[quantity]" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="code">条码号：</label>
                <div class="col-sm-10">
                    <input  class="form-control" id="code" name="Items[code]" value="">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">提取</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!--错误信息-->
@include('common/validator')
@include('common/message')
@stop