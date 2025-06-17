<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBankAccount extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->is_default) {
                static::where('user_id', $model->user_id)
                    ->where('id', '!=', $model->id ?? 0)
                    ->update(['is_default' => false]);
            }
        });
    }

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
