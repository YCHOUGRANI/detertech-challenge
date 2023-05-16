<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();           
            $table->string('location')->nullable(); 
            $table->string('region')->nullable();
            $table->string('type')->nullable();
            $table->decimal('latitude', 8, 6)->nullable();
            $table->decimal('longitude', 9, 6)->nullable(); 
            $table->timestamps();  
            
            
            /* $table->integer('number_of_plots')->nullable()->default(0);  
            $table->integer('number_of_visits')->nullable()->default(0);            
            $table->decimal('phase_value', 10, 2)->nullable()->default(0.00);
            $table->decimal('proposed_discounted_fee', 10, 2)->nullable()->default(0.00); 
           

            $table->unsignedBigInteger('fee_matrix_id')->nullable();
            $table->foreign('fee_matrix_id')->references('id')->on('fee_matrix');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
    
}
