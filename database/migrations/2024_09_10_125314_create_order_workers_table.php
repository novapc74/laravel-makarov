<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_workers', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');
            $table->foreignId('order_id')->nullable()->constrained('orders');
            $table->foreignId('worker_id')->nullable()->constrained('workers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_workers', function (Blueprint $table) {
            $table->dropForeign('order_id');
            $table->dropForeign('worker_id');
        });

        Schema::dropIfExists('order_workers');
    }
};
