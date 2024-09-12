<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('worker_ex_order_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id')->nullable()->constrained('workers');
            $table->foreignId('order_type_id')->nullable()->constrained('order_types');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('worker_ex_order_types', function (Blueprint $table) {
            $table->dropForeign('worker_id');
            $table->dropForeign('order_type_id');
        });

        Schema::dropIfExists('worker_ex_order_types');
    }
};
