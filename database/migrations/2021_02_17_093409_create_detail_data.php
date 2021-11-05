<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('master_id');           
            $table->string('account',90);
            $table->string('name',150);
            $table->string('to',200);
            $table->string('cc',200)->default('');
            $table->string('bcc',200)->default('');
            $table->string('attachment',200)->default('');
            $table->string('password_attach',50)->default('');
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
        Schema::dropIfExists('detail_data');
    }
}
