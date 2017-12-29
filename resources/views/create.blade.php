<!--
用于建立新的商品
-->

@extends('common/layout')
@section('body')
<!--返回首页按钮-->
@include('common/back')

<!--新建商品-->
<div class="panel panel-default" style="width: 800px" >
    <div class="panel-heading">新建商品</div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" action="">
            {{ csrf_field() }}
            <div class="form-group">
                <label class="control-label col-sm-2" for="name1">商品名称：</label>
                <div class="col-sm-10">
                    <input class="form-control" id="name1" name="Items[name]" value="{{old('Items')['name']}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="price">单价(美元)：</label>
                <div class="col-sm-10">
                    <input  class="form-control" id="price" name="Items[price]" value="{{old('Items')['price']}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="price">备注(选填)</label>
                <div class="col-sm-10">
                    <input  class="form-control" id="price" name="Items[priceComment]" value="{{old('Items')['priceComment']}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="quantity">数量：</label>
                <div class="col-sm-10">
                    <input  class="form-control" id="quantity" name="Items[quantity]" value="{{old('Items')['quantity']}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="code">条码号：</label>
                <div class="col-sm-10">
                    <input  class="form-control" id="code" name="Items[code]" value="{{old('Items')['code']}}">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">新增</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!--验证信息-->
@include('common/validator')
@stop