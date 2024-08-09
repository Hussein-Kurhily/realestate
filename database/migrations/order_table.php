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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('CASCADE')->onUpdate('CASCADE');// user id 
            $table->string('city');
            $table->string('region');
            $table->string('budget');  // price range
            $table->string('phone');
            $table->string('description');
            $table->string('type'); // sale or rent
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
    });
        Schema::dropIfExists('orders');
    }
};
