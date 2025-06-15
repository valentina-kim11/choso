<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel as Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\WalletTransaction;

class Wallet extends Model
{
    use HasUuids,HasFactory;
    protected $table = 'wallets';
    public $fillable = [
        'user_id',
        'balance',
        'type',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];


    public static $searchable = [
        'id'=> 'id',
        'user_id'=> 'user_id',
        'type'=> 'type',
    ];

    public function getStatusStrAttribute()
    {
        if($this->status == 1)
        return 'Withdrawal completed!';
        elseif($this->status == 2)
        return 'Reject';
        else
        return 'Pending';
    }

    public function getUser()
    {
        return $this->hasOne(User::class, 'id','user_id');
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }
}
