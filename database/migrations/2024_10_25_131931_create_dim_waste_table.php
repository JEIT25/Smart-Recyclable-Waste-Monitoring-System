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
        Schema::create('dim_waste', function (Blueprint $table) {
            $table->id();
            $table->string('waste_name');
            $table->enum("category_name", ['plastic', 'paper', 'glass', 'metal', 'electronics']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dim_waste');
    }
};
