<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\BaseModel as Model;

class WalletTransaction extends Model
{
    use HasFactory, HasUuids;

    public $fillable = [
        'id',
        'wallet_id',
        'type',
        'credit',
        'debit',
        'status',
        'note',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
