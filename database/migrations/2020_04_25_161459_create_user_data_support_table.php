<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDataSupportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_data_support', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->longText('help_request');
            $table->tinyInteger('has_coronavirus')->default(0);
            $table->tinyInteger('is_in_quarantine')->default(0);
            $table->tinyInteger('has_chronic_illness')->default(0);
            $table->tinyInteger('is_healthy')->default(0);
            $table->longText('description')->nullable();
            $table->integer('status');
            $table->longText('options')->nullable();
            $table->integer('volunteer_user_id')->nullable();
            $table->integer('address_id')->nullable();
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
        Schema::dropIfExists('user_data_support');
    }
}
