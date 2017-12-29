<!--
用于修改商品
-->

@extends('common/layout')
@section('body')
<!--返回首页按钮-->
@include('common\back')

<!--新建商品-->
<div class="panel panel-default" style="width: 800px">
    <div class="panel-heading">修改商品记录信息</div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" action="">
            {{ csrf_field() }}
            <div class="form-group">
                <label class="control-label col-sm-2" for="number">提取数量：</label>
                <div class="col-sm-10">
                    <input class="form-control" id="number" name="Records[quantity]"
                           value="{{old('Records')['quantity']?old('Records')['quantity'] : $record->quantity}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="customer">提取客户：</label>
                <div class="col-sm-10">
                    <input  class="form-control" id="customer" name="Records[customer]"
                            value="{{old('Records')['customer']?old('Records')['customer'] : $record->customer}}">
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