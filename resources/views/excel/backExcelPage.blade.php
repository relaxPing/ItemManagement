@extends('common/layout')
@section('body')
@include('common/back')
<!--导出条件-->
<div class="panel panel-default">
    <div class="panel-heading">
        Excel导出
    </div>
    <div class="panel-body">
        <p>*注:只需要填入需要导出的条件</p>
        <form method="post" action="{{url('backExcelLogic')}}">
            {{csrf_field()}}
            <div class="form-inline">
                <input class="form-control"  placeholder="顾客"  name="Record[customer]">
                <input class="form-control"  placeholder="操作员"  name="Record[operator]">
                <select class="form-control" name="Record[isPaid]">
                    <option name="Record[isPaid]" value="0">未付款</option>
                    <option name="Record[isPaid]" value="1">已付款</option>
                    <option name="Record[isPaid]" value="">全部</option>
                </select>
                <button type="submit" class="btn btn-default">导出</button>
            </div>
        </form>
    </div>
</div>
@stop