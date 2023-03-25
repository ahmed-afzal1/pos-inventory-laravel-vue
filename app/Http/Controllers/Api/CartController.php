<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pos;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addToCart(Request $request,$id){
        $product = Product::findOrFail($id);

        $check = Pos::where('pro_id',$id)->first();

        if($check){
            Pos::where('pro_id',$id)->increment('pro_quantity');
            $pos = Pos::where('pro_id',$id)->first();
            $subTotal = $pos->pro_quantity * $pos->pro_price;
            DB::table('pos')->where('pro_id',$id)->update(['sub_total'=>$subTotal]);
        }else{
            $data = array();
            $data['pro_id'] = $id;
            $data['pro_name'] = $product->name;
            $data['pro_quantity'] = 1;
            $data['pro_price'] = $product->selling_price;
            $data['sub_total'] = $product->selling_price;

            DB::table('pos')->insert($data);
        }
        return response()->json(['success' => 'product added into cart']);
    }

    public function CartProduct(){
        $data = DB::table('pos')
                    ->join('products','pos.pro_id','products.id')
                    ->select('products.quantity','pos.*')
                    ->get();
        return response()->json($data);
    }

    public function removeCart($id){
        $data = Pos::findOrFail($id)->delete();
        return response()->json(['success'=>'Data Deleted Successfully!']);
    }

    public function increment($id){
        Pos::where('id',$id)->increment('pro_quantity');
        $data = Pos::where('id',$id)->first();
        $subTotal = $data->pro_quantity * $data->pro_price;
        DB::table('pos')->where('id',$id)->update(['sub_total'=>$subTotal]);
        return response()->json(['success'=>'Data Updated Successfully!']);
    }

    public function decrement($id){
        Pos::where('id',$id)->decrement('pro_quantity');
        $data = Pos::where('id',$id)->first();
        $subTotal = $data->pro_quantity * $data->pro_price;
        DB::table('pos')->where('id',$id)->update(['sub_total'=>$subTotal]);
        return response()->json(['success'=>'Data Updated Successfully!']);
    }

    public function checkquantity($id){
        $data = Product::find($id);
    }
}
