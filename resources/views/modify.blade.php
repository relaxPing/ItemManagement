<!--
用于修改商品
-->

@extends('common/layout')
@section('body')
<!--返回首页按钮-->
@include('common/back')

<!--新建商品-->
<div class="panel panel-default" style="width: 800px">
    <div class="panel-heading">修改商品信息</div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" action="">
            {{ csrf_field() }}
            <div class="form-group">
                <label class="control-label col-sm-2" for="name1">商品名称：</label>
                <div class="col-sm-10">
                    <input class="form-control" id="name1" name="Items[name]"
                           value="{{old('Items')['name']?old('Items')['name'] : $item->name}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="price">单价(美元)：</label>
                <div class="col-sm-10">
                    <input  class="form-control" id="price" name="Items[price]"
                            value="{{old('Items')['price']?old('Items')['price'] : $item->price}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="price">重量(磅)：</label>
                <div class="col-sm-10">
                    <input  class="form-control" id="price" name="Items[weight]"
                            value="{{old('Items')['weight']?old('Items')['weight'] : $item->weight}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="price">备注(选填)</label>
                <div class="col-sm-10">
                    <input  class="form-control" id="price" name="Items[priceComment]"
                            value="{{old('Items')['priceComment']?old('Items')['priceComment']:$item->priceComment}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="discount">折扣(选填)</label>
                <div class="col-sm-10">
                    <input  class="form-control" id="discount" name="Items[discount]"
                            value="{{old('Items')['discount']?old('Items')['discount']:$item->discount}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="quantity">数量：</label>
                <div class="col-sm-10">
                    <input  class="form-control" id="quantity" name="Items[quantity]"
                            value="{{old('Items')['quantity']?old('Items')['quantity'] : $item->quantity}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="code">条码号：</label>
                <div class="col-sm-10">
                    <input  class="form-control" id="code" name="Items[code]"
                            value="{{old('Items')['code']?old('Items')['code'] : $item->code}}">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">修改</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!--验证信息-->
@include('common/validator')
@stop