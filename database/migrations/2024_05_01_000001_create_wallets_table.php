<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('wallets')) {
            Schema::create('wallets', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->unsignedBigInteger('user_id');
                $table->decimal('balance', 12, 2)->default(0);
                $table->string('type');
                $table->timestamps();
            });
        }

        if (Schema::hasTable('wallet_transactions')) {
            Schema::table('wallet_transactions', function (Blueprint $table) {
                if (Schema::hasColumn('wallet_transactions', 'wallet_id')) {
                    $table->foreign('wallet_id')
                        ->references('id')
                        ->on('wallets')
                        ->onDelete('cascade');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('wallet_transactions')) {
            Schema::table('wallet_transactions', function (Blueprint $table) {
                if (Schema::hasColumn('wallet_transactions', 'wallet_id')) {
                    $table->dropForeign(['wallet_id']);
                }
            });
        }
        Schema::dropIfExists('wallets');
    }
};
