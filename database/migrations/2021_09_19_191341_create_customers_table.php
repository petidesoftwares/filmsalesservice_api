<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('firstname',50);
            $table->string('middle_name',50)->nullable();
            $table->string('surname',50);
            $table->enum('gender',['Male', 'Female']);
            $table->string('email',50)->unique();
            $table->string('dob',10);
            $table->string('phone',15);
            $table->string('password',150);
            $table->softDeletes();
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
        Schema::dropIfExists('cutomers');
    }
}
