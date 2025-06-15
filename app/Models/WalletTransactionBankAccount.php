<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransactionBankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_transaction_id',
        'bank_account_id',
    ];
}
