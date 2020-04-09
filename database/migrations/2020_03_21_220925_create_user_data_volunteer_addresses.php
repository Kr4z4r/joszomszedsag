<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDataVolunteerAddresses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_data_volunteer_addresses', function (Blueprint $table) {
            $table->integer('address_id')->unsigned();
            $table->integer('user_data_volunteer_id')->unsigned();
            $table->primary(array('address_id', 'user_data_volunteer_id'), 'user_data_volunteer_addresses_pkey');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_data_volunteer_addresses');
    }
}
