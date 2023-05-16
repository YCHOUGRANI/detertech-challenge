<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlarmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alarms', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();      
            $table->json('params')->nullable();  
            $table->unsignedTinyInteger('severity')->nullable()->default(1);
            $table->string('path')->nullable();
            $table->unsignedBigInteger('device_id')->nullable();
            $table->foreign('device_id')->references('id')->on('devices');
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
        Schema::dropIfExists('alarms');
    }
    
}
