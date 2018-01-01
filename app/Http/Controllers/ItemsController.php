<?php
/**
 * Created by IntelliJ IDEA.
 * User: X.P
 * Date: 11/29/2017
 * Time: 4:19 PM
 */
namespace App\Http\Controllers;
use App\Items;
use App\Records;
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
            if(Items::create($data)){
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


        $items = Items::orderBy('created_at','desc')->Paginate(25);
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

    //商品录入
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
            if(Items::find($itemCode)){
                $Item = Items::find($itemCode);
                $Item -> quantity = $Item -> quantity + $data['quantity'];
                if($Item ->save()){
                    return redirect('items')->with('success','商品录入成功');
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
                $data['name'] = Items::where('code',$code)->first()['name'];
                $data['price'] = Items::where('code',$code)->first()['price'];
                $data['discount'] = Items::where('code',$code)->first()['discount'];
                //保存记录和商品数量修改之前先看看商品库存足不足
                if(Items::where('code',$code)->first()['quantity']-$data['quantity']<0){
                    return redirect()->back()->with('error','商品数量不足');
                }
                if(Records::create($data) && Items::where('code',$code)){
                    $Item = Items::where('code',$code)->first();
                    $Item -> quantity = $Item -> quantity - $data['quantity'];
                    if($Item ->save()){
                        return redirect('record_take')->with('success','商品提取成功');
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
        $records = Records::orderBy('created_at','desc')->Paginate(25);
        if(Session::has('name')){
            $keywords = Session::get('name');
            $records = Records::where('name','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
        }
        if(Session::has('num')){
            $keywords = Session::get('num');
            $records = Records::where('code','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
        }
        if(Session::has('customer')){
            $keywords = Session::get('customer');
            $records = Records::where('customer','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
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
                $records = Records::where('code','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
            }
            if(array_key_exists('customer',$request->input('Search'))){
                $keywords = $request->input('Search')['customer'];
                Session::put('customer',$keywords);
                if(Session::has('name')){
                    Session::forget('name');
                }
                if(Session::has('num')){
                    Session::forget('num');
                }
                $records = Records::where('customer','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(25);
            }
        }
        return view('record_take',[
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
            $item -> code = $data['code'];
            $item -> name = $data['name'];
            $item -> quantity = $data['quantity'];
            $item -> price = $data['price'];
            $item -> priceComment = $data['priceComment'];
            $item -> discount = $data['discount'];
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
        $items = Items::orderBy('created_at','desc')->Paginate(25);
        if(Session::has('c_item_name')){
            $keywords = Session::get('c_item_name');
            $items = Items::where('name','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(2);
        }
        if(Session::has('c_item_num')){
            $keywords = Session::get('c_item_num');
            $items = Items::where('code','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(2);
        }
        if($request->input('Search')){
            if(array_key_exists('name',$request->input('Search'))){
                $keywords = $request->input('Search')['name'];
                Session::put('c_item_name',$keywords);
                if(Session::has('c_item_num')){
                    Session::forget('c_item_num');
                }
                $items = Items::where('name','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(2);
            }
            if(array_key_exists('num',$request->input('Search'))){
                $keywords = $request->input('Search')['num'];
                Session::put('c_item_num',$keywords);
                if(Session::has('c_item_name')){
                    Session::forget('c_item_name');
                }
                $items = Items::where('code','like','%'.$keywords.'%')->orderBy('created_at','desc')->Paginate(2);
            }
        }
        return view('itemList',[
            'items'=>$items
        ]);
    }
}