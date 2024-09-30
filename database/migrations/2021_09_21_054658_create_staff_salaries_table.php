<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('salary', 15, 2)->nullable();
            $table->decimal('thp', 15, 2)->nullable();
            $table->decimal('lembur', 15, 2)->nullable();
            $table->decimal('shift', 15, 2)->nullable();
            $table->decimal('tunjangan_keahlian', 15, 2)->nullable();
            $table->decimal('transport', 15, 2)->nullable();
            $table->decimal('kompensasi', 15, 2)->nullable();
            $table->decimal('pajak', 15, 2)->nullable();
            $table->decimal('proporsional', 15, 2)->nullable();
            $table->decimal('potongan_bpjskes', 15, 2)->nullable();
            $table->decimal('potongan_jp', 15, 2)->nullable();
            $table->decimal('potongan_jht', 15, 2)->nullable();
            $table->decimal('benefit_bpjskes', 15, 2)->nullable();
            $table->decimal('benefit_jp', 15, 2)->nullable();
            $table->decimal('benefit_jht', 15, 2)->nullable();
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff_salaries');
    }
}
