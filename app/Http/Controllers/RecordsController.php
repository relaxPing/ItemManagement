<?php
/**
 * Created by IntelliJ IDEA.
 * User: X.P
 * Date: 12/11/2017
 * Time: 4:14 PM
 */
namespace App\Http\Controllers;

use App\Items;
use App\Records;
use App\Records_add;
use Illuminate\Http\Request;
use Session;

class RecordsController extends Controller{
    //商品提取记录修改
    public function modifyRecord(Request $request,$id){
        $record = Records::find($id);
        if($request->isMethod('POST')){
            //验证
            $validator = \Validator::make($request->input(),[
                'Records.quantity' => 'required|integer',
                'Records.customer' => 'required',
            ],[
                'required'=>':attribute 为必填项',
                'integer'=>':attribute 必须为数字'
            ],[
                'Records.quantity' =>'提取数量',
                'Records.customer' => '提取客户'
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            //修改数据
            $data = $request->input('Records');
            //查一下之前record的数量
            $prevQuantity = $record ->quantity;
            $record -> quantity = $data['quantity'];
            $record -> isPaid = $data['isPaid'];
            $record -> customer = $data['customer'];
            $record -> comment = $data['comment'];
            $record -> totalPrice = $record -> quantity * $record -> finalPrice;
            if($record->save()){
                //算一下quantity的差别,并在商品里面给改掉
                $diff = $data['quantity'] - $prevQuantity;
                $itemCode = $record -> code;
                $item = Items::where('code',$itemCode) -> first();
                $item -> quantity = $item -> quantity - $diff;
                $item -> save();
                return redirect('record_take')->with('success','修改成功');
            }
        }
        return view('modifyRecord',[
            'record'=>$record
        ]);
    }

    //商品进货记录
    public function record_add(Request $request){
        //如果是没有page参数 说明是第一页 清一下参数
        if(!$request ->get('page')){
            if(Session::has('record_add_name')){
                Session::forget('record_add_name');
            }
            if(Session::has('record_add_code')){
                Session::forget('record_add_code');
            }
        }

        $records = Records_add::orderBy('created_at','desc')->
            where(function($query)use($request){
                if(Session::has('record_add_name')){
                    $name = Session::get('record_add_name');
                    $query -> where('name','like','%'.$name.'%');
                }
                })->
            where(function($query)use($request){
                if(Session::has('record_add_code')){
                    $code = Session::get('record_add_code');
                    $query -> where('code','like','%'.$code.'%');
                }
        })->Paginate(5);
        if($request -> isMethod('post')){
            if(Session::has('record_add_name')){
                Session::forget('record_add_name');
            }
            if(Session::has('record_add_code')){
                Session::forget('record_add_code');
            }

            if(isset($request -> input('Search')['name']) && $request -> input('Search')['name']){
                Session::put('record_add_name',$request -> input('Search')['name']);
            }
            if(isset($request -> input('Search')['code']) && $request -> input('Search')['code']){
                Session::put('record_add_code',$request -> input('Search')['code']);
            }

            $records = Records_add::where(function($query)use($request){
                if(Session::has('record_add_name')){
                    $name = Session::get('record_add_name');
                    $query -> where('name','like','%'.$name.'%');
                }
            })->
            where(function($query)use($request){
                if(Session::has('record_add_code')){
                    $code = Session::get('record_add_code');
                    $query -> where('code','like','%'.$code.'%');
                }
            })->orderBy('created_at','desc')->Paginate(5);
        }

        return view('record_add',[
            'records'=>$records
        ]);
    }
}