<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('department')->nullable();
            $table->timestamps();
        });
        DB::table('departments')->insert([
            ['department' => 'Kantor Pusat Pertamina'],
            ['department' => 'RS Pertamina Jaya'],
            ['department' => 'Pertamina Hulu Rokan'],
            ['department' => 'DCU MARINE dan PMTC'],
            ['department' => 'Pertamina Trans Kontinental (PTK)'],
            ['department' => 'Patra Niaga'],
            ['department' => 'PIEP'],
            ['department' => 'Tanjung Sekong - Ciwandan'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
    }
}
