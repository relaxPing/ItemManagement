<?php
/**
 * Created by IntelliJ IDEA.
 * User: X.P
 * Date: 11/29/2017
 * Time: 4:19 PM
 */
namespace App\Http\Controllers;
use App\Adds;
use App\Items;
use App\Records;
use App\Records_add;
use Illuminate\Http\Request;
use Session;

class ItemsController extends Controller{
    //新建商品
    public function create(Request $request){
        if($request->isMethod('POST')){

            /*$this->validate($request,[
                'Items.name' => 'required',
                'Items.code' => 'required|integer',
                'Items.quantity' => 'required'
            ],[
                'required'=>':attribute 为必填项',
                'integer'=>':attribude 必须为数字'
            ],[
                'Items.name' =>'商品名称',
                'Items.code' =>'条码号',
                'Items.quantity' => '商品数量'
            ]);*/
            $validator = \Validator::make($request->input(),[
                'Items.name' => 'required',
                'Items.price' => 'required',
                'Items.quantity' => 'required|integer',
                'Items.code' => 'required'
            ],[
                'required'=>':attribute 为必填项',
                'integer'=>':attribute 必须为整数'
            ],[
                'Items.name' =>'商品名称',
                'Items.price' => '价格',
                'Items.code' =>'条码号',
                'Items.quantity' => '商品数量'
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $request->input('Items');
            //finalPrice是折后价 需要补充
            if($data['discount'] == null){
                $data['finalPrice'] = $data['price'];
            }else{
                $data['finalPrice'] = $data['price'] - $data['discount'];
            }
            //如果商品已经存在给出错误提示
            if(Items::where('code',$data['code'])->first()){
                return redirect()->back()->with('error','商品已存在');
            }
            //建立了商品后，记录要存在record_add中
            $record['name'] = $data['name'];
            $record['code'] = $data['code'];
            $record['finalPrice'] = $data['finalPrice'];
            $record['quantity'] = $data['quantity'];
            $record['quantity_current'] = $data['quantity'];
            if(Items::create($data)&& Adds::create($record)){
                return redirect('items')->with('success','成功新建商品');
            }else{
                return redirect('items')->with('error','商品新建失败');
            }
        }
        return view('create');
    }

    //商品列表
    public function items(Request $request){
        /*if($request->isMethod('POST')&& $request->input('Search')){
            if(array_key_exists('name',$request->input('Search'))){
                $keywords = $request->input('Search')['name'];
                $items = Items::where('name','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
            }elseif (array_key_exists('num',$request->input('Search'))){
                $keywords = $request->input('Search')['num'];
                $items = Items::where('code','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
            }
        }else{
            $items = Items::orderBy('created_at','desc')->Paginate(25);
        }*/


        $items = Items::orderBy('updated_at','desc')->Paginate(25);
        if(Session::has('name')){
            $keywords = Session::get('name');
            $items = Items::where('name','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
        }
        if(Session::has('num')){
            $keywords = Session::get('num');
            $items = Items::where('code','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
        }
        if($request->input('Search')){
            if(array_key_exists('name',$request->input('Search'))){
                $keywords = $request->input('Search')['name'];
                Session::put('name',$keywords);
                if(Session::has('num')){
                    Session::forget('num');
                }
                $items = Items::where('name','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
            }
            if(array_key_exists('num',$request->input('Search'))){
                $keywords = $request->input('Search')['num'];
                Session::put('num',$keywords);
                if(Session::has('name')){
                    Session::forget('name');
                }
                $items = Items::where('code','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
            }
        }

        return view('items',[
            'items'=>$items
        ]);
    }

    //商品录入（进货）
    public function add(Request $request){
        if($request->isMethod('POST')){
            $validator = \Validator::make($request->input(),[
                'Items.quantity' => 'required|integer',
                'Items.code' => 'required'
            ],[
                'required'=>':attribute 为必填项',
                'integer'=>':attribute 必须为数字'
            ],[
                'Items.code' =>'条码号',
                'Items.quantity' => '商品数量'
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $request->input('Items');
            $itemCode = $data['code'];
            if(Items::where('code',$itemCode)){
                $Item = Items::where('code',$itemCode)->first();
                $Item -> quantity = $Item -> quantity + $data['quantity'];

                //增加了商品后，记录要存在record_add中
                $record['name'] = $Item->name;
                $record['code'] = $Item->code;
                $record['finalPrice'] = $Item->finalPrice;
                $record['quantity'] = $data['quantity'];
                $record['quantity_current'] = Items::where('code',$Item->code)->first()->quantity + $data['quantity'];
                $add = Adds::create($record);
                if($Item ->save() && $add->save() ){
                    $currentQuantity = Items::where('code',$itemCode) -> first()->quantity;
                    Session::flash('success','商品：'.$Item->name.',成功录入：'.$data['quantity'].'个,现库存:'.$currentQuantity);
                    return redirect()->back();
                }else{
                    return redirect('items')->with('error','商品录入失败');
                }
            }else{
                echo '<script language="javascript">';
                echo 'alert("没有对应条码的商品！请先创建商品！");';
                echo '</script>';
            }

        }
        return view('add');
    }

    //商品提取
    public function take(Request $request){
        if($request->isMethod('POST')){
            $validator = \Validator::make($request->input(),[
                'Items.quantity'=>'required|integer',
                'Items.customer'=>'required',
                'Items.operator'=>'required',
                'Items.code'=>'required'
            ],[
                'required'=>':attribute 为必填项',
                'integer'=>':attribute 必须为数字'
            ],[
                'Items.quantity'=>'商品数量',
                'Items.customer'=>'提取客户',
                'Items.operator'=>'操作员',
                'Items.code'=>'条码号'
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $request->input('Items');
            $code = $data['code'];
            if(Items::where('code',$code)){
                //这些是输入框没有 需要加进去的数据
                $data['name'] = Items::where('code',$code)->first()['name'];
                $data['price'] = Items::where('code',$code)->first()['price'];
                $data['discount'] = Items::where('code',$code)->first()['discount'];
                //finalPrice是折后价 需要补充
                if($data['discount'] == null){
                    $data['finalPrice'] = $data['price'];
                }else{
                    $data['finalPrice'] = $data['price'] - $data['discount'];
                }
                $data['totalPrice'] = $data['finalPrice'] * $data['quantity'];
                //保存记录和商品数量修改之前先看看商品库存足不足
                if(Items::where('code',$code)->first()['quantity']-$data['quantity']<0){
                    return redirect()->back()->with('error','商品数量不足');
                }
                if(Records::create($data) && Items::where('code',$code)){
                    $Item = Items::where('code',$code)->first();
                    $Item -> quantity = $Item -> quantity - $data['quantity'];
                    if($Item ->save()){
                        $tookQuantity = $data['quantity'];
                        $currentQuantity = Items::where('code',$code) ->first()->quantity;
                        $itemName = Items::where('code',$code) ->first() -> name;
                        /*return redirect('record_take')->with('success','商品提取成功');*/
                        Session::flash('success','成功提取:'.$tookQuantity.'个 '.$itemName.' ,该商品剩余'.$currentQuantity);
                        return redirect()->back()->withInput();
                    }else{
                        return redirect('items')->with('error','商品提取失败');
                    }
                }else{
                    return redirect('items')->with('error','商品提取失败');
                }
            }else{
                echo '<script language="javascript">';
                echo 'alert("您要提取的商品不存在，请核对条码号！");';
                echo '</script>';
            }
        }
        return view('take');
    }

    //商品提取记录
    public function record_take(Request $request){
        /*if($request->isMethod('POST')&& $request->input('Search')){
            if(array_key_exists('name',$request->input('Search'))){
                $keywords = $request->input('Search')['name'];
                $records = Records::where('name','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
            }elseif (array_key_exists('num',$request->input('Search'))){
                $keywords = $request->input('Search')['num'];
                $records = Records::where('code','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
            }elseif(array_key_exists('customer',$request->input('Search'))){
                $keywords = $request->input('Search')['customer'];
                $records = Records::where('customer','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
            }
        }else{
            $records = Records::orderBy('created_at','desc')->Paginate(25);
        }*/
        //如果是get进来的或者什么都不输入的
        $records = Records::orderBy('created_at','desc')->Paginate(25);


        if(Session::has('name')){
            $keywords = Session::get('name');
            $records = Records::where('name','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
        }
        if(Session::has('num')){
            $keywords = Session::get('num');
            $records = Records::where('code','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
        }
        /*if(Session::has('customer')){
            $keywords = Session::get('customer');
            $records = Records::where('customer','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
        }*/
        if(Session::has('customer') || Session::has('isPaid') || Session::has('date')){
            $customer = Session::get('customer');
            $isPaid = Session::get('isPaid');
            $date = Session::get('date');

            //把jquery传来的日期字符串转换成真的日期
            if(Session::has('date') != null){
                $dateArray = explode('/',Session::get('date'));
                $month = $dateArray[0];
                $day = $dateArray[1];
                $year = $dateArray[2];

                $start = date('Y-m-d H:i:s',mktime(0,0,0,$month,$day,$year));
                $end = date('Y-m-d H:i:s',mktime(0,0,0,$month,$day + 1,$year));
            }
            //三个条件 七种情况
            if ($customer == null && $isPaid != null && $date != null) {
                $records = Records::where('isPaid', $isPaid)->where('created_at','>',$start)->where('created_at','<',$end)->orderBy('created_at', 'desc')->Paginate(25);
            }
            if ($customer != null && $isPaid == null && $date != null) {
                $records = Records::where('customer','like', '%'.$customer.'%')->where('created_at','>',$start)->where('created_at','<',$end)->orderBy('created_at', 'desc')->Paginate(25);
            }
            if ($customer != null && $isPaid != null && $date == null) {
                $records = Records::where('isPaid', $isPaid)->where('customer','like', '%'.$customer.'%')->orderBy('created_at', 'desc')->Paginate(25);
            }
            if ($customer == null && $isPaid == null && $date != null) {
                $records = Records::where('created_at','>',$start)->where('created_at','<',$end)->orderBy('created_at', 'desc')->Paginate(25);
            }
            if ($customer == null && $isPaid != null && $date == null) {
                $records = Records::where('isPaid', $isPaid)->orderBy('created_at', 'desc')->Paginate(25);
            }
            if ($customer != null && $isPaid == null && $date == null) {
                $records = Records::where('customer','like', '%'.$customer.'%')->orderBy('created_at', 'desc')->Paginate(25);
            }
            if ($customer == null && $isPaid == null && $date == null) {
                $records = Records::orderBy('created_at','desc')->Paginate(25);
            }

        }


        if($request->input('Search')){
            if(array_key_exists('name',$request->input('Search'))){
                $keywords = $request->input('Search')['name'];
                Session::put('name',$keywords);
                if(Session::has('num')){
                    Session::forget('num');
                }
                if(Session::has('customer')){
                    Session::forget('customer');
                }
                if(Session::has('isPaid')){
                    Session::forget('isPaid');
                }
                if(Session::has('date')){
                    Session::forget('date');
                }
                $records = Records::where('name','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
            }
            if(array_key_exists('num',$request->input('Search'))){
                $keywords = $request->input('Search')['num'];
                Session::put('num',$keywords);
                if(Session::has('name')){
                    Session::forget('name');
                }
                if(Session::has('customer')){
                    Session::forget('customer');
                }
                if(Session::has('isPaid')){
                    Session::forget('isPaid');
                }
                if(Session::has('date')){
                    Session::forget('date');
                }
                $records = Records::where('code','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
            }
            /*if(array_key_exists('customer',$request->input('Search'))){
                $keywords = $request->input('Search')['customer'];
                Session::put('customer',$keywords);
                if(Session::has('name')){
                    Session::forget('name');
                }
                if(Session::has('num')){
                    Session::forget('num');
                }
                $records = Records::where('customer','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
            }*/
            //第三种搜索有七种情况
            if(array_key_exists('customer',$request->input('Search')) || array_key_exists('isPaid',$request->input('Search')) || array_key_exists('date',$request->input('Search'))) {
                $customer = $request->input('Search')['customer'];
                $isPaid = $request->input('Search')['isPaid'];
                $date = $request->input('Search')['date'];
                //先把之前的Session删掉
                if (Session::has('name')) {
                    Session::forget('name');
                }
                if (Session::has('num')) {
                    Session::forget('num');
                }
                //把jquery传来的日期字符串转换成真的日期
                if($date != null){
                    $dateArray = explode('/',$date);
                    $month = $dateArray[0];
                    $day = $dateArray[1];
                    $year = $dateArray[2];

                    $start = date('Y-m-d H:i:s',mktime(0,0,0,$month,$day,$year));
                    $end = date('Y-m-d H:i:s',mktime(0,0,0,$month,$day + 1,$year));
                }


                //三个条件 所以有7种情况
                if ($customer == null && $isPaid != null && $date != null) {
                    Session::put('isPaid', $isPaid);
                    Session::put('date', $date);
                    $records = Records::where('isPaid', $isPaid)->where('created_at','>',$start)->where('created_at','<',$end)->orderBy('created_at', 'desc')->Paginate(25);
                }
                if ($customer != null && $isPaid == null && $date != null) {
                    Session::put('customer', $customer);
                    Session::put('date', $date);
                    $records = Records::where('customer','like', '%'.$customer.'%')->where('created_at','>',$start)->where('created_at','<',$end)->orderBy('created_at', 'desc')->Paginate(25);
                }
                if ($customer != null && $isPaid != null && $date == null) {
                    Session::put('customer', $customer);
                    Session::put('isPaid', $isPaid);
                    $records = Records::where('isPaid', $isPaid)->where('customer','like', '%'.$customer.'%')->orderBy('created_at', 'desc')->Paginate(25);
                }
                if ($customer == null && $isPaid == null && $date != null) {
                    Session::put('date', $date);
                    $records = Records::where('created_at','>',$start)->where('created_at','<',$end)->orderBy('created_at', 'desc')->Paginate(25);
                }
                if ($customer == null && $isPaid != null && $date == null) {
                    Session::put('isPaid', $isPaid);
                    $records = Records::where('isPaid', $isPaid)->orderBy('created_at', 'desc')->Paginate(25);
                }
                if ($customer != null && $isPaid == null && $date == null) {
                    Session::put('customer', $customer);
                    $records = Records::where('customer','like', '%'.$customer.'%')->orderBy('created_at', 'desc')->Paginate(25);
                }
                if ($customer == null && $isPaid == null && $date == null) {
                    $records = Records::orderBy('created_at','desc')->Paginate(25);
                }
            }
        }
        return view('record_take',[
            'records'=>$records
        ]);
    }

    //商品进货记录
    public function record_add(Request $request){
        $records = Records_add::orderBy('created_at','desc')->Paginate(25);
        return view('record_add',[
            'records'=>$records
        ]);
    }

    //商品修改
    public function modify(Request $request,$id){
        $item = Items::find($id);
        if($request->isMethod('POST')){
            //验证
            $validator = \Validator::make($request->input(),[
                'Items.name' => 'required',
                'Items.price' => 'required',
                'Items.quantity' => 'required|integer',
                'Items.code' => 'required'
            ],[
                'required'=>':attribute 为必填项',
                'integer'=>':attribute 必须为整数'
            ],[
                'Items.name' =>'商品名称',
                'Items.price' => '价格',
                'Items.code' =>'条码号',
                'Items.quantity' => '商品数量'
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            //修改数据
            $data = $request->input('Items');
            //修改之前的数量
            $item -> code = $data['code'];
            $item -> name = $data['name'];
            $item -> quantity = $data['quantity'];
            $item -> price = $data['price'];
            $item -> weight = $data['weight'];
            $item -> priceComment = $data['priceComment'];
            $item -> discount = $data['discount'];
            //赋值finalPrice之前先判断一下是否有折扣
            if($item->discount == null){
                $item->finalPrice = $item ->price;
            }else{
                $item->finalPrice = $item ->price -$item ->discount;
            }

            if($item->save()){
                /*return redirect('items')->with('success','修改成功');*/
                echo "<script>history.go(-2)</script>";
            }
        }
        return view('modify',[
            'item'=>$item
        ]);
    }

    //商品删除
    public function itemDelete($id){
        $item = Items::find($id);
        if($item->delete()){
            /*return redirect('items')->with('success','成功删除');*/
            echo "<script>history.go(-1)</script>";
        }else{
            return redirect('items')->with('error','删除失败，请返回首页刷新后重试或联系管理员');
        }
    }

    //向用户展示的商品目录
    public function itemList(Request $request){
        /*if($request->isMethod('POST')&& $request->input('Search')){
            if(array_key_exists('name',$request->input('Search'))){
                $keywords = $request->input('Search')['name'];
                $items = Items::where('name','like','%'.$keywords.'%')->Paginate(25);
            }elseif (array_key_exists('num',$request->input('Search'))){
                $keywords = $request->input('Search')['num'];
                $items = Items::where('code','like','%'.$keywords.'%')->Paginate(25);
            }
        }else{
            $items = Items::orderBy('created_at','desc')->Paginate(25);
        }*/
        //如果是什么都没有输入 或者get 显示全部
        $items = Items::orderBy('created_at','desc')->Paginate(25);

        if($request->input('all')){
            Session::forget('itemname');
            Session::forget('userid');
            Session::forget('username');
            Session::forget('status');
            Session::forget('date');
            Session::forget('c_item_name');
            $items = Items::orderBy('created_at','desc')->paginate(25);
        }
        if(Session::has('c_item_name')){
            $keywords = Session::get('c_item_name');
            $items = Items::where('name','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
        }
        /*if(Session::has('c_item_num')){
            $keywords = Session::get('c_item_num');
            $items = Items::where('code','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
        }*/
        if($request->input('Search')){
            if(array_key_exists('name',$request->input('Search'))){
                $keywords = $request->input('Search')['name'];
                Session::put('c_item_name',$keywords);
                if(Session::has('c_item_num')){
                    Session::forget('c_item_num');
                }
                $items = Items::where('name','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
            }
            if(array_key_exists('num',$request->input('Search'))){
                $keywords = $request->input('Search')['num'];
                Session::put('c_item_num',$keywords);
                if(Session::has('c_item_name')){
                    Session::forget('c_item_name');
                }
                $items = Items::where('code','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
            }
        }
        return view('itemList',[
            'items'=>$items
        ]);
    }
}