<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangays', function (Blueprint $table) {
            // Primary Key and Foreign Keys
            $table->id();
            $table->unsignedBigInteger('mun_city_id');
            
            // Municipality/City Information
            $table->string('code', 9);
            $table->string('description');

            // Foreign Keys
            $table->foreign('mun_city_id')
                ->references('id')
                ->on('mun_cities')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barangays');
    }
};
