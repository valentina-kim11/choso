<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // If an old wallets table exists, rename it to avoid conflicts
        if (Schema::hasTable('wallets') && !Schema::hasTable('wallet_transactions')) {
            Schema::rename('wallets', 'wallet_transactions');
        }

        if (!Schema::hasTable('wallet_transactions')) {
            Schema::create('wallet_transactions', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('wallet_id');
                $table->decimal('amount', 12, 2);
                $table->string('type');
                $table->string('source')->nullable();
                $table->text('description')->nullable();
                $table->tinyInteger('status')->default(0);
                $table->timestamps();
            });
        } else {
            Schema::table('wallet_transactions', function (Blueprint $table) {
                if (!Schema::hasColumn('wallet_transactions', 'wallet_id')) {
                    $table->uuid('wallet_id')->nullable();
                }
                if (!Schema::hasColumn('wallet_transactions', 'amount')) {
                    $table->decimal('amount', 12, 2)->nullable();
                }
                if (!Schema::hasColumn('wallet_transactions', 'type')) {
                    $table->string('type')->nullable();
                }
                if (!Schema::hasColumn('wallet_transactions', 'source')) {
                    $table->string('source')->nullable();
                }
                if (!Schema::hasColumn('wallet_transactions', 'description')) {
                    $table->text('description')->nullable();
                }
                if (!Schema::hasColumn('wallet_transactions', 'status')) {
                    $table->tinyInteger('status')->default(0);
                }
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
