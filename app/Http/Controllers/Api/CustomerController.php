<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Image;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Customer::all();
        return response()->json($data);
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
            'name' => 'required',
            'email' => 'email',
            'phone' => 'required',
            'address' => 'required',
        ]);
        $data = new Customer();
        $input = $request->all();

        if($request->photo){
            $position = strpos($request->photo,';');
            $sub = substr($request->photo,0,$position);
            $ext = explode('/',$sub)[1];
            $name = time().".".$ext;
            $image_path = 'backend/customer/'.$name;
            $img = Image::make($request->photo)->resize(240,200);
            $img->save('backend/customer/'.$name);
            $input['photo'] = $image_path;
        }
        $data->fill($input)->save();

        return response()->json(['success' => 'Successfully data added.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Customer::findOrFail($id);
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
        $request->validate([
            'name' => 'required',
            'email' => 'email',
            'phone' => 'required',
            'address' => 'required',
        ]);
       $data = Customer::findOrFail($id);
        $input = $request->all();

        if($request->new_photo){
            $postion = strpos($request->new_photo,';');
            $sub = substr($request->new_photo,0,$postion);
            $ext = explode('/',$sub);
            $image = time().'.'.$ext[1];
            $image_path = 'backend/customer/'.$image;
            $img = Image::make($request->new_photo)->resize(240,200);
            $img->save('backend/customer/'.$image);
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
        $data = Customer::findOrFail($id);
        @unlink($data->photo);
        $data->delete();

        return response()->json(['success' => 'Successfully data deleted.']);
    }
}
