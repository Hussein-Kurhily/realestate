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
        Schema::create('sale_realestate_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('CASCADE')->onUpdate('CASCADE');// user id 
            $table->string('phone');
            $table->string('type');//realesate 
            $table->string('city');
            $table->string('region');
            $table->string('desc');
            $table->string('brushes');
            $table->string('preparation');
            $table->string('seller_type');
            $table->string('floor');
            $table->string('price');
            $table->string('area');
            $table->integer('views');
            $table->double('evaluation');
            $table->double('property_type');
            $table->string('bathrooms_number');
            $table->boolean('wifi');
            $table->boolean('elevator');
            $table->boolean('barking');
            $table->boolean('swimming_bool');
            $table->boolean('solar_energy');
            $table->json('images')->nullable(); // prob
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_realestate_table', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
    });
        Schema::dropIfExists('sale_realestate_table');
    }
};
