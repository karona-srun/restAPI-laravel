<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('teacher_id');
            $table->bigInteger('classes_id');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('image')->nullable();
            $table->string('gender');
            $table->string('phoneNumber');
            $table->string('email')->nullable();
            $table->date('dob');
            $table->string('pob');
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
        Schema::dropIfExists('students');
    }
}
