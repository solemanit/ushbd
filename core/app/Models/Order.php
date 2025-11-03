<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'address',
        'division',
        'district',
        'zip_code',
        'city',
        'country',
        'product_id',
        'quantity',
        'price',
        'total',
        'status',
    ];

    // Relation to Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
