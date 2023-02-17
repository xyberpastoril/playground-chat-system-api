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
        Schema::create('customer_addresses', function (Blueprint $table) {
            // Primary Key and Foreign Keys
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('barangay_id');

            // Optional Fields
            $table->string('house_lot_number')->nullable();
            $table->string('street')->nullable();
            $table->string('village_subdivision')->nullable();
            $table->string('unit_floor')->nullable();
            $table->string('building')->nullable();

            // Miscellaneous Fields
            $table->timestamps();

            // Foreign Keys
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');
            $table->foreign('barangay_id')
                ->references('id')
                ->on('barangays')
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
        Schema::dropIfExists('customer_addresses');
    }
};
