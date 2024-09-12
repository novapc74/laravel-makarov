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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->date('date');
            $table->text('address');
            $table->integer('amount');
            $table->string('status');
            $table->foreignId('order_type_id')->nullable()->constrained('order_types');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('partnership_id')->nullable()->constrained('partnerships');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('order_type_id');
            $table->dropForeign('user_id');
            $table->dropForeign('partnership_id');
        });

        Schema::dropIfExists('orders');
    }
};
