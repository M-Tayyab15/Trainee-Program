<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblProfile2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_profile2', function (Blueprint $table) {
            $table->increments('profile_id');
            $table->bigInteger('user_id')->nullable();
            $table->text('address')->nullable();
            $table->integer('phone')->nullable();
            $table->string('city', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('country', 255)->nullable();
            $table->integer('created_on')->nullable();
            $table->integer('modified_on')->nullable();
            $table->string('ip_address', 50)->nullable();
            $table->timestamps(0); // created_at and updated_at with no precision
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_profile2');
    }
}
