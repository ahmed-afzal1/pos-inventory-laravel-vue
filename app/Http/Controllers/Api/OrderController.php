<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(){
        $data = date('d/m/Y');
        $order = DB::table('orders')
                    ->join('customers','orders.customer_id','customers.id')
                    ->select('customers.name','orders.*')
                    ->where('orders.order_date',$data)->orderBy('orders.id','desc')
                    ->get();
        return response()->json($order);
    }

    public function OrderDetails($id){
        $order = DB::table('orders')
                        ->join('customers','orders.customer_id','customers.id')
                        ->where('orders.id',$id)
                        ->select('customers.name','customers.phone','customers.address','orders.*')
                        ->first();

        return response()->json($order);
        

    }

    public function OrderDetailsAll($id){
        $details = DB::table('order_details')
                    ->join('products','order_details.product_id','products.id')
                    ->where('order_details.order_id',$id)
                    ->select('products.name','products.code','products.photo','order_details.*')
                    ->get();
        return response()->json($details);
    }

    public function SearchOrderDate(Request $request){
        $orderdate = $request->date;
        $newDate = new DateTime($orderdate);
        $done = $newDate->format('d/m/Y');

        $order = DB::table('orders')
                    ->join('customers','orders.customer_id','customers.id')
                    ->select('customers.name','orders.*')
                    ->where('orders.order_date',$done)
                    ->get();
        return response()->json($order);
    }
}
