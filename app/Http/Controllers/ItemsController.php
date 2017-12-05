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
                'integer'=>':attribute 必须为数字'
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
        if($request->isMethod('POST')&& $request->input('Search')){
            if(array_key_exists('name',$request->input('Search'))){
                $keywords = $request->input('Search')['name'];
                $items = Items::where('name','like','%'.$keywords.'%')->Paginate(25);
            }elseif (array_key_exists('num',$request->input('Search'))){
                $keywords = $request->input('Search')['num'];
                $items = Items::where('code','like','%'.$keywords.'%')->Paginate(25);
            }
        }else{
            $items = Items::orderBy('created_at','desc')->Paginate(25);
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
            if(Items::find($code)){
                $data['name'] = Items::where('code',$code)->first()['name'];
                $data['price'] = Items::where('code',$code)->first()['price'];
                if(Records::create($data) && Items::find($code)){
                    $Item = Items::find($code);
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
        if($request->isMethod('POST')&& $request->input('Search')){
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
        }
        return view('record_take',[
            'records'=>$records
        ]);
    }
}