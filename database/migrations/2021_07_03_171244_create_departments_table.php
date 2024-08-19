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
            ['department' => 'KANTOR PUSAT PERTAMINA'],
            ['department' => 'RS PERTAMINA JAYA'],
            ['department' => 'PERTAMINA HULU ROKAN'],
            ['department' => 'DCU MARINE'],
            ['department' => 'DCU PMTC'],
            ['department' => 'KANTOR PUSAT PERTAMINA-RTC PULOGADUNG'],
            ['department' => 'PATRA NIAGA'],
            ['department' => 'PATRAJASA TOWER'],
            ['department' => 'PERTAMINA AREA SHIPPING'],
            ['department' => 'PERTAMINA SOPODEL'],
            ['department' => 'PERTAMINA TANJUNG SEKONG'],
            ['department' => 'PTK'],
            ['department' => 'SEKONG /CIWANDAN'],
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
