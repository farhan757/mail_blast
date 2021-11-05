<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotsentData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notsent_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('master_id');           
            $table->string('account',90);
            $table->string('name',150);
            $table->string('to',200);
            $table->string('cc',200)->default('');
            $table->string('bcc',200)->default('');
            $table->string('subject_mail',200)->default('');
            $table->text('body_mail')->default('');
            $table->string('attachment',200)->default('');
            $table->string('password_attach',50)->default('');
            $table->integer('user_id');
            $table->integer('sent');
            $table->string('msg_error_send');
            $table->datetime('send_at');
            $table->integer('delivered');
            $table->datetime('delivered_at');            
            $table->integer('read');
            $table->datetime('read_at');
            $table->integer('resend')->default(0);
            $table->string('desc',200)->default(''); 
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
        Schema::dropIfExists('notsent_data');
    }
}
