<?php
/**
 * Created by IntelliJ IDEA.
 * User: X.P
 * Date: 12/11/2017
 * Time: 4:14 PM
 */
namespace App\Http\Controllers;

use App\Records;
use Illuminate\Http\Request;

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
            $record -> quantity = $data['quantity'];
            $record -> isPaid = $data['isPaid'];
            $record -> customer = $data['customer'];
            $record -> comment = $data['comment'];
            $record -> totalPrice = $record -> quantity * $record -> finalPrice;
            if($record->save()){
                return redirect('record_take')->with('success','修改成功');
            }
        }
        return view('modifyRecord',[
            'record'=>$record
        ]);
    }
}