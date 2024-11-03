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
        Schema::create('fact_waste_collection', function (Blueprint $table) {
            $table->id(); // Creates 'id' as primary key (BIGINT UNSIGNED by default)

            // Explicitly define the foreign key for user_id
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Explicitly define the foreign key for location_id
            $table->unsignedBigInteger('dim_location_id');
            $table->foreign('dim_location_id')->references('id')->on('dim_location')->onDelete('cascade');

            // Explicitly define the foreign key for waste_category_id
            $table->unsignedBigInteger('dim_waste_id');
            $table->foreign('dim_waste_id')->references('id')->on('dim_waste')->onDelete('cascade');

            // Other columns
            $table->integer('amount_collected');
            $table->date('collection_date');
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fact_waste_collection');
    }
};
