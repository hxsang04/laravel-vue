<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'message',
        'total_price',
            
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_order', 'order_id', 'product_id')
                    ->withPivot('quantity','unit_price');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
