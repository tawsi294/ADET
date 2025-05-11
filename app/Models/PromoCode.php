<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PromoCode extends Model
{
    use HasFactory;

    protected $table = 'promocodes';

    protected $fillable = [
        'code', 'description', 'discount_type', 'discount_value',
        'start_date', 'expiration_date', 'usage_limit', 'min_purchase',
        'is_active', 'usage_count',
    ];

    protected $casts = [
        'start_date' => 'date',
        'expiration_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function getStatusAttribute()
    {
        $now = Carbon::now();
        if ($this->expiration_date && $this->expiration_date->isPast()) {
            return 'Expired';
        }
        if ($this->start_date && $this->start_date->isFuture()) {
            return 'Scheduled';
        }
        return $this->is_active ? 'Active' : 'Inactive';
    }
}
