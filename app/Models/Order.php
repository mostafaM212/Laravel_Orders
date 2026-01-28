<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = ['user_id','total_items' , 'total'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot(['quantity' ,'total']);
    }
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
