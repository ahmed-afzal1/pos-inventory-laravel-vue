<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id','supplier_id','unit_id','brand_id','tax_id','name','code','root','buying_price','selling_price','buying_date','photo','quantity'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
}
