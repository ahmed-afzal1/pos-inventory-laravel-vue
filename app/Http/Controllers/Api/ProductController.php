<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $datas = DB::table('products')
        //             ->join('categories','products.category_id','categories.id')
        //             ->join('suppliers','products.supplier_id','suppliers.id')
        //             ->select('categories.name as category_name','suppliers.name as supplier_name','products.*')
        //             ->orderBy('products.id','DESC')
        //             ->get();
        $datas = Product::with('category:id,name')->orderBy('id','desc')->get();
        return response()->json($datas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'code'=>'required',
            'category_id'=>'required',
            'supplier_id'=>'required',
            'root'=>'required',
            'buying_price'=>'required',
            'selling_price'=>'required',
            'buying_date'=>'required',
            'quantity'=>'required',
            
        ]);
        $data = new Product();
        $input = $request->all();

        if($request->photo){
            $position = strpos($request->photo,';');
            $sub = substr($request->photo,0,$position);
            $ext = explode('/',$sub)[1];
            $name = time().".".$ext;
            $image_path = 'backend/product/'.$name;
            $img = Image::make($request->photo)->resize(240,200);
            $img->save('backend/product/'.$name);
            $input['photo'] = $image_path;
        }
        $data->fill($input)->save();

        return response()->json(['success' => 'Successfully data Updated.']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Product::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $data = Product::findOrFail($id);
         $input = $request->all();
         
         if($request->new_photo){
             $postion = strpos($request->new_photo,';');
             $sub = substr($request->new_photo,0,$postion);
             $ext = explode('/',$sub);
             $image = time().'.'.$ext[1];
             $image_path = 'backend/product/'.$image;
             $img = Image::make($request->new_photo)->resize(240,200);
             $img->save('backend/product/'.$image);
             @unlink($data->photo);
             $input['photo'] = $image_path;
         }
        $data->update($input);

        return response()->json(['success' => 'Successfully data Updated.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Product::findOrFail($id);
        @unlink($data->photo);
        $data->delete();

        return response()->json(['success' => 'Successfully data deleted.']);
    }
}
