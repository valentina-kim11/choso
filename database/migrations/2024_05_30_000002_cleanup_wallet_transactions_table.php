<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $drops = [];
            foreach (['credit','debit','note','user_id'] as $col) {
                if (Schema::hasColumn('wallet_transactions', $col)) {
                    $drops[] = $col;
                }
            }
            if ($drops) {
                $table->dropColumn($drops);
            }
        });
    }

    public function down(): void
    {
        Schema::table('wallet_transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('wallet_transactions', 'credit')) {
                $table->double('credit')->default(0);
            }
            if (!Schema::hasColumn('wallet_transactions', 'debit')) {
                $table->double('debit')->default(0);
            }
            if (!Schema::hasColumn('wallet_transactions', 'note')) {
                $table->text('note')->nullable();
            }
            if (!Schema::hasColumn('wallet_transactions', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable();
            }
        });
    }
};
