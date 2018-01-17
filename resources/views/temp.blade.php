<?php
/**
 * Created by IntelliJ IDEA.
 * User: X.P
 * Date: 1/8/2018
 * Time: 12:19 PM
 */
//修改items表
//$items = \App\Items::all();
//foreach ($items as $item){
//    if($item->discount == null){
//        $item->finalPrice = $item ->price;
//        $item ->save();
//    }else{
//        $item->finalPrice = $item ->price -$item ->discount;
//        $item ->save();
//    }
//}

//修改record表(提取记录)
/*$records = \App\Records::all();
foreach ($records as $record){
    if($record->discount == null){
        $record->finalPrice = $record ->price;
        $record ->save();
    }else{
        $record->finalPrice = $record ->price -$record ->discount;
        $record ->save();
    }
}*/

//修改用户下单表
/*$userOrders = \App\UserOrder::all();
foreach ($userOrders as $userOrder){
    if($userOrder->discount == null){
        $userOrder->finalPrice = $userOrder ->price;
        $userOrder ->save();
    }else{
        $userOrder->finalPrice = $userOrder ->price -$userOrder ->discount;
        $userOrder ->save();
    }
}*/

//插入统计数据中第一个月的数据
/*$balance = 0;
$items = \App\Items::all();
foreach($items as $item){
    $balance = $balance + $item->quantity * $item->finalPrice;
}

$statistic['year'] = 2017;
$statistic['month'] = 12;
$statistic['balance'] = $balance;
$statistic['sold'] = 0;
$statistic['cost'] = 0;
$statistic['increasement'] = 0;
\App\Statistics::create($statistic);*/

//提货列表加总价
$records = \App\Records::all();
foreach ($records as $record){
    $record->totalPrice = $record -> quantity * $record ->finalPrice;
    $record->save();
}
//useroder表加总价
$useroders = \App\UserOrder::all();
foreach ($useroders as $useroder){
    $useroder->totalPrice = $useroder -> quantity * $useroder ->finalPrice;
    $useroder->save();
}