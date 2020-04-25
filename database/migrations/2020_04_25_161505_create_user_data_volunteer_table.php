<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDataVolunteerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_data_volunteer', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('has_car')->default(0);
            $table->string('availability', 128)->nullable();
            $table->longText('helping_groups')->nullable();
            $table->integer('user_id');
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('user_data_volunteer');
    }
}
