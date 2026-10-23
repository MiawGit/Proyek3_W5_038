<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $primaryKey = 'id_order';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_order',
        'user_id',
        'tanggal_order',
        'total_harga',
        'alamat_pengiriman',
    ];

    protected function casts(): array
    {
        return ['tanggal_order' => 'datetime'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'id_order', 'id_order');
    }
}
