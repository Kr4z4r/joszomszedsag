<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropUnique('users_email_unique');
            $table->string('first_name', 191);
            $table->string('last_name', 191);
            $table->string('display_name', 191)->nullable();
            $table->string('date_birth', 4)->nullable();
            $table->string('phone_number', 32)->nullable();
            $table->string('facebook_profile', 255)->nullable();
            $table->string('facebook_group', 255)->nullable();
            $table->text('description')->nullable();
            $table->integer('home_address_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name', 191);
            $table->unique('email');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('display_name');
            $table->dropColumn('date_birth');
            $table->dropColumn('phone_number');
            $table->dropColumn('facebook_profile');
            $table->dropColumn('facebook_group');
            $table->dropColumn('description');
            $table->dropColumn('home_address_id');
        });
    }
}
