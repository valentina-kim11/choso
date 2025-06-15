<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bank_name',
        'account_number',
        'account_holder',
        'method',
        'is_default',
    ];

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }
}
