<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDimLocationTable extends Migration
{
    public function up()
    {
        Schema::create('dim_locations', function (Blueprint $table) {
            $table->id(); // Creates 'id' as primary key (BIGINT UNSIGNED by default)
            $table->string('city', 20);
            $table->enum('barangay', [
                'Antonio Luna',
                'Bay-ang',
                'Bayabas',
                'Caasinan',
                'Cabinet',
                'Calamba',
                'Calibunan',
                'Comagascas',
                'Concepcion',
                'Del Pilar',
                'Katugasan',
                'Kauswagan',
                'La Union',
                'Mabini',
                'Poblacion 1',
                'Poblacion 2',
                'Poblacion 3',
                'Poblacion 4',
                'Poblacion 5',
                'Poblacion 6',
                'Poblacion 7',
                'Poblacion 8',
                'Poblacion 9',
                'Poblacion 10',
                'Poblacion 11',
                'Poblacion 12',
                'Puting Bato',
                'Sanghan',
                'Soriano',
                'Tolosa',
                'Mahaba'
            ]);
            $table->enum('purok', [
                '1',
                '2',
                '3',
                '4',
                '5',
                '6',
                '7',
                '8',
                '9',
                '10'
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('dim_location');
    }
}

