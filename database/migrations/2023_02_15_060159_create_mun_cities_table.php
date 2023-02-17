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
        Schema::create('mun_cities', function (Blueprint $table) {
            // Primary Key and Foreign Keys
            $table->id();
            $table->unsignedBigInteger('province_id');

            // Municipality/City Information
            $table->string('district', 10);
            $table->string('code', 9);
            $table->string('description');

            // Foreign Keys
            $table->foreign('province_id')
                ->references('id')
                ->on('provinces')
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
        Schema::dropIfExists('mun_cities');
    }
};
