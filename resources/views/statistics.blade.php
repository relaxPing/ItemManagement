<!--
财务统计页面
-->

@extends('common/layout')
@section('body')
<!--返回首页按钮-->
@include('common/back')

<!--本日统计-->
<div class="panel panel-default" style="width: 800px">
    <div class="panel-heading">本日统计</div>
    <div class="panel-body">
        <table class="table">
            <tr>
                <td>仓库总额：</td>
                <td>${{$totalPrice}}</td>
            </tr>
            <tr>
                <td>本日进货：</td>
                <td>${{$todayIn}}</td>
            </tr>
            <tr>
                <td>本日出货：</td>
                <td>${{$todayOut}}</td>
            </tr>
        </table>
    </div>

</div>
<div class="panel panel-default" style="width: 800px">
    <div class="panel-heading">整月统计</div>
    <div class="panel-body">
        <form class="form-inline" method="post" action="">
            {{csrf_field()}}
            <select class="form-control" name="Statistics[year]">
                <option value="2018" name="Statistics[year]">2018年</option>
                <option value="2019" name="Statistics[year]">2019年</option>
                <option value="2020" name="Statistics[year]">2020年</option>
                <option value="2021" name="Statistics[year]">2021年</option>
            </select>
            <select class="form-control" name="Statistics[month]">
                <option value="1" name="Statistics[month]">1月</option>
                <option value="2" name="Statistics[month]">2月</option>
                <option value="3" name="Statistics[month]">3月</option>
                <option value="4" name="Statistics[month]">4月</option>
                <option value="5" name="Statistics[month]">5月</option>
                <option value="6" name="Statistics[month]">6月</option>
                <option value="7" name="Statistics[month]">7月</option>
                <option value="8" name="Statistics[month]">8月</option>
                <option value="9" name="Statistics[month]">9月</option>
                <option value="10" name="Statistics[month]">10月</option>
                <option value="11" name="Statistics[month]">11月</option>
                <option value="12" name="Statistics[month]">12月</option>
            </select>
            <button type="submit" class="btn btn-default">查询</button>
        </form>
        @if(Request::isMethod('post'))
        <div>
            <table class="table">
                <tr>
                    <td>仓库存货额:</td>
                    <td>${{$balance}}  (上月存货额${{$lastBalance}})</td>
                </tr>
                <tr>
                    <td>本月库存增额:</td>
                    @if($increasement>=0)
                    <td>${{$increasement}}</td>
                    @else
                    <td>-${{abs($increasement)}}</td>
                    @endif
                </tr>
                <tr>
                    <td>本月进货额:</td>
                    <td>${{$cost}}</td>
                </tr>
                <tr>
                    <td>本月销售额:</td>
                    <td>${{$sold}}</td>
                </tr>
                <tr>
                    <td style="color: red">本月进货额 = 仓库增额 + 本月销售额<br>   本月库存增额 = 上月存货额 - 本月存货额</td>
                </tr>
            </table>
        </div>

        @endif
    </div>

</div>

<!--错误信息-->
@include('common/validator')
@stop