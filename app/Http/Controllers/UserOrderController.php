<?php
/**
 * Created by IntelliJ IDEA.
 * User: X.P
 * Date: 1/1/2018
 * Time: 12:07 PM
 */
namespace App\Http\Controllers;

use App\Items;
use App\UserOrder;
use App\UserOrderEdit;
use Illuminate\Http\Request;
use Session;


class UserOrderController extends Controller{
    /*public function userOrder($id){
        $item = Items::find($id);
        return view('userOrder',[
            'item' => $item
        ]);
    }*/
    //下单逻辑
    public function orderLogic(Request $request){
        //验证
        $validator = \Validator::make($request->input(),[
            'UserOrder.username'=>'required|max:50',
            'UserOrder.quantity'=>'required|max:5',
            'UserOrder.userid'=>'required|max:10'
        ],[],[
            'UserOrder.username'=>'姓名',
            'UserOrder.userid'=>'用户id',
            'UserOrder.quantity'=>'数量'
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->input('UserOrder');
        //先看看商品数量是否足够，不足返回并错误提示，足够情况下向下进行
        $itemRest = Items::where('code',$data['itemcode'])->first()->quantity;
        if($data['quantity'] > $itemRest){
            return redirect('itemList')->with('error','抱歉，商品数量不足！我们会尽快补货。如有问题请联系西游寄');
        }
        $data['totalPrice'] = $data['quantity'] * $data['finalPrice'];
        $data['status'] = 0;
        if(UserOrder::create($data)){
            $item = Items::where('code',$data['itemcode'])->first();
            $item -> quantity = $item -> quantity - $data['quantity'];
            $item -> save();
            return redirect('itemList')-> with('success','订单创建成功，如有问题请联系西游寄');
        }else{
            return redirect('itemList')-> with('error','下单失败，请重试');
        }

        return 'test';
    }

    //客户订单列表
    public function  orderList(){
        $orders = UserOrder::orderBy('created_at','desc')->paginate(25);
        $unopenedOrders = UserOrder::where('isOpened',0)->get();
        //只用于传状态的模型
        $orderForStatus = new UserOrder();
        return view('orderList',[
            'orders' => $orders,
            'unopenedOrders'=>$unopenedOrders,
            'orderForStatus'=>$orderForStatus
        ]);
    }

    //客户订单列表查询
    public function orderListSearch(Request $request){
        //当输入为空时，返回这个
        $orders = UserOrder::orderBy('created_at','desc')->paginate(25);
        //
        if(Session::has('order_username')){
            $keywords = Session::get('order_username');
            $orders = UserOrder::where('username','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
        }
        if(Session::has('order_itemname')){
            $keywords = Session::get('order_itemname');
            $orders = UserOrder::where('itemname','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
        }
        if(Session::has('order_userid')){
            $keywords = Session::get('order_userid');
            $orders = UserOrder::where('userid','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
        }
        if($request->input('UserOrder')){
            if(array_key_exists('username',$request->input('UserOrder'))){
                $keywords = $request->input('UserOrder')['username'];
                Session::put('username',$keywords);
                if(Session::has('itemname')){
                    Session::forget('itemname');
                }
                if(Session::has('userid')){
                    Session::forget('userid');
                }
                $orders = UserOrder::where('username','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
            }
            if(array_key_exists('itemname',$request->input('UserOrder'))){
                $keywords = $request->input('UserOrder')['itemname'];
                Session::put('itemname',$keywords);
                if(Session::has('username')){
                    Session::forget('username');
                }
                if(Session::has('userid')){
                    Session::forget('userid');
                }
                $orders = UserOrder::where('itemname','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
            }
            if(array_key_exists('userid',$request->input('UserOrder'))){
                $keywords = $request->input('UserOrder')['userid'];
                Session::put('userid',$keywords);
                if(Session::has('username')){
                    Session::forget('username');
                }
                if(Session::has('itemname')){
                    Session::forget('itemname');
                }
                $orders = UserOrder::where('userid','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
            }
        }

        return view('orderList',[
            'orders' => $orders
        ]);
    }


    //modal显示
    public function show($id) {
        $userOrder = UserOrder::find($id);
        return response()->json($userOrder);
    }
    //客户订单修改
    public function update(Request $request, $id) {
        //不用验证,因为是下拉框,一定有值得
        //逻辑
        $userOrder = UserOrderEdit::find($id);
        $userOrder->status = $request->get('status');
        $userOrder->save();
        //渲染(return)
        return response()->json($userOrder);
    }
}