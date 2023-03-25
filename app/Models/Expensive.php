<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expensive extends Model
{
    protected $fillable = ['amount','details','expense_date'];
}
