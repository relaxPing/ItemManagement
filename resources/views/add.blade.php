<!--
用于增加已建立的商品的数量
-->

@extends('common/layout')
@section('body')
<!--返回首页按钮-->
<button onclick="locate('.')" class="btn btn-basic btn-mid" style="margin: 10px 0px">返回首页</button>

<!--商品录入-->
<div class="panel panel-default" style="width: 800px">
    <div class="panel-heading">商品录入</div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" action="">
            {{ csrf_field() }}
            <div class="form-group">
                <label class="control-label col-sm-2" for="quantity">录入数量：</label>
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
                    <button type="submit" class="btn btn-default">录入</button>
                </div>
            </div>
        </form>
    </div>
    <div class="panel-footer" style="color: red;text-decoration: none">*录入商品前请先<a href="{{ url('create')}}">添加商品</a></div>
</div>

<!--错误信息-->
@include('common/validator')
@stop