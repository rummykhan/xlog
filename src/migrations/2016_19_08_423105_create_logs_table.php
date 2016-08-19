<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->string('page');
            $table->string('url');
            $table->string('response_code');
            $table->string('session_id');

            $table->string('ip');
            $table->string('country')->nullable();
            $table->string('city')->nullable();

            $table->string('browser');
            $table->string('browser_version');
            $table->string('os');
            $table->string('os_version');

            $table->string('request_method');
            $table->text('request_params');

            $table->string('user_type')->nullable();
            $table->string('email')->nullable();
            $table->string('user_id')->nullable();

            $table->text('exception')->nullable();
            $table->text('trace')->nullable();
            $table->string('error_main')->nullable();
            $table->string('class')->nullable();
            $table->string('message')->nullable();

            $table->string('controller_action')->nullable();

            $table->boolean('is_redirect')->nullable();
            $table->string('redirected_to')->nullable();

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
        Schema::drop('logs');
    }
}