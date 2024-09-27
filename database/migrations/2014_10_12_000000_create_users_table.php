<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('user_id')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('status')->nullable();
            $table->string('avatar')->nullable();
            $table->foreignId('role_id')->constrained('role_type_users');
            $table->foreignId('position_id')->constrained('position_types');
            $table->foreignId('department_id')->constrained('departments');
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
