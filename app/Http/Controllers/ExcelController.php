<?php

namespace App\Http\Controllers;

use App\ExcelRecords;
use App\Records;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    //1.导出后台提货的excel的页面
    public function backExcelPage(){
        return view('excel/backExcelPage');
    }
    //2.导出后台提货的excel的逻辑
    public function backExcelLogic(Request $request){
        $data = $request->input('Record');
        $customer = $data['customer'];
        $operator = $data['operator'];
        $isPaid = $data['isPaid'];

        //$records = Records::where('customer',$customer)->where('operator',$operator)->where('isPaid',$isPaid)->get();
        //三个条件七种情况
        if($customer == null && $operator!= null && $isPaid !=null){
            $records = ExcelRecords::where('operator',$operator)->where('isPaid',$isPaid)->select('code','name','finalPrice','quantity','totalPrice','customer','operator','isPaid','created_at')->get();
        }
        if($customer != null && $operator == null && $isPaid !=null){
            $records = ExcelRecords::where('customer',$customer)->where('isPaid',$isPaid)->select('code','name','finalPrice','quantity','totalPrice','customer','operator','isPaid','created_at')->get();
        }
        if($customer != null && $operator != null && $isPaid ==null){
            $records = ExcelRecords::where('customer',$customer)->where('operator',$operator)->select('code','name','finalPrice','quantity','totalPrice','customer','operator','isPaid','created_at')->get();
        }
        if($customer == null && $operator == null && $isPaid !=null){
            $records = ExcelRecords::where('isPaid',$isPaid)->select('code','name','finalPrice','quantity','totalPrice','customer','operator','isPaid','created_at')->get();
        }
        if($customer == null && $operator != null && $isPaid ==null){
            $records = ExcelRecords::where('operator',$operator)->select('code','name','finalPrice','quantity','totalPrice','customer','operator','isPaid','created_at')->get();
        }
        if($customer != null && $operator == null && $isPaid ==null){
            $records = ExcelRecords::where('customer',$customer)->select('code','name','finalPrice','quantity','totalPrice','customer','operator','isPaid','created_at')->get();
        }
        if($customer == null && $operator == null && $isPaid ==null){
            $records = ExcelRecords::select('code','name','finalPrice','quantity','totalPrice','customer','operator','isPaid','created_at')->get();
        }
        foreach ($records as $record){
            if($record->isPaid == 1){
                $record->isPaid = '已付款';
            }
            if($record->isPaid == 0){
                $record->isPaid = '未付款';
            }
        }
        $total = 0;
        foreach ($records as $record){
            $total = $total + $record->totalPrice;
        }
        //dd($records);
        Excel::create($customer.time(), function($excel) use($records,$total) {

            $excel->sheet('Sheet1', function($sheet) use($records,$total) {

                //$sheet->fromArray([['名字','电话1'],$addresses],null,'A1',true,false);
                $sheet->appendRow(array(
                    '条形码','商品名称','销售单价(即折后价)','数量','金额','顾客','提货员','是否付款','提货时间'
                ));
                $sheet->fromArray($records,null,'A2',true,false);
                $sheet->appendRow(array(
                    '','','','','合计：'.$total,'','','',''
                ));
                //$sheet->with($records);
                //$sheet->fromArray($addresses);
                //$sheet->rows($records);
            });

        })->export('xls');

    }
    //3.导出客户下单的excel的页面
    public function orderExcelPage(){

    }
    //4.导出客户下单excel的的逻辑
    public function orderExcelLogic(){

    }
}
