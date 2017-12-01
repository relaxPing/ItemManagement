@extends('common/layout')
@section('body')
    <div style="height: 400px">
        <div style="margin: 30px">
            <button onclick="locate('create')" class="btn btn-default btn-lg">新建商品</button>
        </div>
        <div style="margin: 30px">
            <button onclick="locate('add')" class="btn btn-info btn-lg">进货</button>
            <button onclick="locate('take')" class="btn btn-info btn-lg">提货</button>
        </div>
        <div style="margin: 30px">
            <button onclick="locate('items')" class="btn btn-success btn-lg">商品列表</button>
            <button onclick="locate('record_take')" class="btn btn-success btn-lg">提取记录列表</button>
        </div>
    </div>


@stop

