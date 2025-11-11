<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    /**
     * যেসব ফিল্ড mass assignment এ অনুমোদিত
     */
    protected $fillable = [
        'service_id',
        'brand_id',
        'division_id',
        'district_id',
        'name',
        'description',
        'slug',
        'image',
        'discount',
        'status',
    ];

    /**
     * slug স্বয়ংক্রিয়ভাবে তৈরি হবে name থেকে
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });

        static::updating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }


    /**
     * service সম্পর্ক (belongsTo)
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * দাম বা ছাড় টাকায় (formatted)
     */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0) . ' ৳';
    }

    public function getFormattedDiscountAttribute()
    {
        return number_format($this->discount, 0) . ' ৳';
    }

    public function cards()
    {
        $products = Product::where('status', 1)->latest()->get();
        return view('frontend.pages.cards', compact('products'));
    }
}
