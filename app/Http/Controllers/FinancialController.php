<?php
/**
 * Created by IntelliJ IDEA.
 * User: X.P
 * Date: 1/8/2018
 * Time: 3:56 PM
 */
namespace App\Http\Controllers;

use App\Adds;
use App\Items;
use App\Records;
use App\Statistics;
use Illuminate\Http\Request;

class FinancialController extends Controller{
    public function getStatistics(){
        $startTime = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d'),date('Y')));
        $endTime = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d')+1,date('Y')));
        $todayAdds = Adds::where('created_at','>',$startTime)->where('created_at','<',$endTime)->get();
        $todaySells = Records::where('created_at','>',$startTime)->where('created_at','<',$endTime)->get();
        //总进货额
        $todayIn = 0;
        foreach($todayAdds as $todayAdd){
            $todayIn = $todayIn + ($todayAdd->finalPrice * $todayAdd->quantity);
        }
        //总售出
        $todayOut = 0;
        foreach ($todaySells as $todaySell){
            $todayOut = $todayOut + ($todaySell->finalPrice * $todaySell->quantity);
        }
        //仓库总货量
        $totalPrice = 0;
        $whItems = Items::all();
        foreach ($whItems as $whItem){
            $totalPrice = $totalPrice + $whItem->quantity * $whItem->finalPrice;
        }

        return view('statistics',[
            'todayIn'=>$todayIn,
            'todayOut'=>$todayOut,
            'totalPrice'=>$totalPrice
        ]);
    }
    public function postStatistics(Request $request){
        //第一部分：和上面方法相同 用于传递当日的数据统计
        $startTimeDay = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d'),date('Y')));
        $endTimeDay = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d')+1,date('Y')));
        $todayAdds = Adds::where('created_at','>',$startTimeDay)->where('created_at','<',$endTimeDay)->get();
        $todaySells = Records::where('created_at','>',$startTimeDay)->where('created_at','<',$endTimeDay)->get();
        //总进货额
        $todayIn = 0;
        foreach($todayAdds as $todayAdd){
            $todayIn = $todayIn + ($todayAdd->finalPrice * $todayAdd->quantity);
        }
        //总售出
        $todayOut = 0;
        foreach ($todaySells as $todaySell){
            $todayOut = $todayOut + ($todaySell->finalPrice * $todaySell->quantity);
        }

        //仓库总货量
        $totalPrice = 0;
        $whItems = Items::all();
        foreach ($whItems as $whItem){
            $totalPrice = $totalPrice + $whItem->quantity * $whItem->finalPrice;
        }
        //第二部分：post请求过来的数据 用于查询月统计
        $data = $request->input('Statistics');
        $year = $data['year'];
        $month = $data['month'];
        $balance = 0;
        $sold = 0;
        $cost = 0;
        $increasement = 0;
        $lastBalance = 0;
        /*$startTime = date('Y-m-d H:i:s',mktime(0,0,0,$month,1,$year));
        $endTime = date('Y-m-d H:i:s',mktime(0,0,0,$month+1,1,$year));*/
        //$monthlyAdd就是每个月的花费
        /*$monthlyAdd = Adds::where('created_at','>',$startTime)->where('created_at','<',$endTime)->get();
        $monthlySold = Records::where('created_at','>',$startTime)->where('created_at','<',$endTime)->get();
        $totalBalance = Items::all();*/
        //循环将查询日期之前的月统计数据全部建立
        for($i = 2018;$i<=$year;$i++){
            for($j = 1;$j<=12;$j++){
                //先查看该月记录是否已经存在(取消，否则如果提前查了 就没法更改了)
                /*if(Statistics::where('year',$i)->where('month',$j)->count()){
                    continue;
                }*/

                $start = date('Y-m-d H:i:s',mktime(0,0,0,$j,1,$i));
                $end = date('Y-m-d H:i:s',mktime(0,0,0,$j+1,1,$i));
                //月仓库结余
                $balance = 0;
                $items = Items::all();
                foreach($items as $item){
                    $balance = $balance + $item->quantity * $item->finalPrice;
                }
                //月售出
                $sold = 0;
                $records = Records::where('created_at','>',$start)->where('created_at','<',$end)->get();
                foreach ($records as $record){
                    $sold = $sold + $record -> quantity * $record -> finalPrice;
                }
                //月花费
                $cost = 0;
                $adds = Adds::where('created_at','>',$start)->where('created_at','<',$end)->get();
                foreach ($adds as $add){
                    $cost = $cost + $add -> quantity * $add -> finalPrice;
                }
                //月增量
                   //如果不是一月减月份，如果是一月要减年份
                if($j - 1){
                    //上月的数据一定是已经存在statistics表中的
                    $lastBalance = Statistics::where('year',$i)->where('month',$j-1)->first()->balance;
                }else{
                    $lastBalance = Statistics::where('year',$i-1)->where('month',12)->first()->balance;
                }
                $increasement = $balance - $lastBalance;

                //根据上面的数据在statistic表中存储当月数据
                $statistic['year'] = $i;
                $statistic['month'] = $j;
                $statistic['balance'] = $balance;
                $statistic['sold'] = $sold;
                $statistic['cost'] = $cost;
                $statistic['increasement'] = $increasement;
                //如果已经存在 做修改，如果不存在 创建

                Statistics::create($statistic);


                //这个放在最后 执行完了再判断
                if($i == $year && $j == $month){
                    break;
                }
            }
        }
        /*dd($balance,$sold,$cost,$increasement,$lastBalance);*/
        return view('statistics',[
            'todayIn'=>$todayIn,
            'todayOut'=>$todayOut,
            'totalPrice'=>$totalPrice,
            'balance'=>$balance,
            'sold'=>$sold,
            'cost'=>$cost,
            'increasement'=>$increasement,
            'lastBalance'=>$lastBalance
        ]);
    }
}