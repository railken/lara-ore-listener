<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;

class CreateListenersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Config::get('ore.listener.table'), function (Blueprint $table) {
            $table->increments('id'); 
            $table->string('name'); 
            $table->string('condition')->default("1");
            $table->text('description')->nullable(); 
            $table->boolean('entities')->default(0); 
            $table->text('event_class'); 
            $table->integer('work_id')->unsigned()->nullable(); 
            $table->foreign('work_id')->references('id')->on('ore_works'); 
            $table->boolean('enabled')->default(true);
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
        Schema::dropIfExists(Config::get('ore.listener.table'));
    }
}