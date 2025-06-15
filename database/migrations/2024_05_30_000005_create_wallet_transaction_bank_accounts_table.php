<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallet_transaction_bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->uuid('wallet_transaction_id');
            $table->unsignedBigInteger('bank_account_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_transaction_bank_accounts');
    }
};
