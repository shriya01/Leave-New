<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('user_id',11);
            $table->string('user_first_name', 100)->default('');
            $table->string('user_last_name', 100)->default('');
            $table->string('user_email',150)->unique()->default('');
            $table->string('password',255)->default('');
            $table->tinyInteger('user_role_id')->unsigned();
            $table->rememberToken();  
            $table->timestamp('user_created_at')->useCurrent();
            $table->date('user_updated_at');
            $table->tinyInteger('user_status')->unsigned();
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
