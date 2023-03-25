<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expensive;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function GetProduct($id){
        $products = DB::table('products')
                        ->where('category_id',$id)
                        ->get();
        return response()->json($products);
    }

    public function OrderDone(Request $request){
        $request->validate([
            'customer_id' => 'required',
            'payby' => 'required'
        ]);

        $data = array();
        $data['customer_id'] = $request->customer_id;
        $data['quantity'] = $request->qty;
        $data['sub_total'] = $request->subtotal;
        $data['vat'] = $request->vat;
        $data['total'] = $request->total;
        $data['pay'] = $request->pay;
        $data['due'] = $request->due;
        $data['payby'] = $request->pay_by;
        $data['order_date'] = date('d/m/Y');
        $data['order_month'] = date('F');
        $data['order_year'] = date('Y');

        $order_id = DB::table('orders')->insertGetId($data);

        $contents = DB::table('pos')->get();
        $odata = array();
        foreach($contents as $content){
            $odata['order_id'] = $order_id;
            $odata['product_id'] = $content->pro_id;
            $odata['quantity'] = $content->pro_quantity;
            $odata['price'] = $content->pro_price;
            $odata['sub_total'] = $content->sub_total;
            DB::table('order_details')->insert($odata);

            DB::table('products')
                ->where('id',$content->pro_id)
                ->update(['quantity' => DB::raw('quantity -'.$content->pro_quantity)]);
        }

        DB::table('pos')->delete();
        
        return response()->json(['success' => 'Successfully data Added.']);
    }

    public function TodaySell(){
        $date = date('d/m/Y');
        $sell = DB::table('orders')->where('order_date',$date)->sum('total');
        return response()->json($sell);
    }

    public function TodayIncome(){
        $date = date('d/m/Y');
        $income = DB::table('orders')->where('order_date',$date)->sum('pay');
        return response()->json($income);
    }

    public function TodayDue(){
        $date = date('d/m/Y');
        $due = DB::table('orders')->where('order_date',$date)->sum('due');
        return response()->json($due);
    }

    public function TodayExpense(){
        $date = date('d/m/Y');
        $expense = DB::table('expensives')->where('expense_date',$date)->sum('amount');
        return response()->json($expense);
    }

    public function Stockout(){
        $product = DB::table('products')->where('quantity','=',0)->get();
        return response()->json($product);
    }

    public function profitLoss(){
        $totalProduct = Product::sum('quantity');
        $totalBuy = Product::sum('buying_price');
        $totalExpense = Expensive::sum('amount');
        $totalSell = Order::sum('total');

        $orderDetails = OrderDetails::all();
        $buy_cost = 0;
        $total_sell = 0;
        foreach($orderDetails as $order){
            $product = Product::findOrFail($order->product_id);
            $buy_cost += $order->quantity * $product->buying_price;
            $total_sell += $order->sub_total;
        }

        $profit = $total_sell - $buy_cost;


        $data = ['total_product'=>$totalProduct,'total_buy'=>$totalBuy,'total_expense'=>$totalExpense,'total_sell'=>$totalSell,'profit'=>$profit];
        return response()->json($data);
    }
}
