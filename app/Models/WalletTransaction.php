<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\BaseModel as Model;

class WalletTransaction extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wallet_transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $fillable = [
        'id',
        'wallet_id',
        'amount',
        'type',
        'source',
        'description',
        'status',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
