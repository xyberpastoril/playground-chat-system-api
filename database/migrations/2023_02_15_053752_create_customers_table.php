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
        Schema::create('customers', function (Blueprint $table) {
            // Primary Key and Foreign Keys
            $table->id();
            $table->unsignedBigInteger('user_id')
                ->nullable()
                ->unique();

            // Personal Information
            $table->string('first_name');
            $table->string('last_name');

            // Contact Information
            $table->string('contact_number', 11);

            // Identity Information
            $table->longText('proof_attachment')
                ->nullable();

            // Miscellaneous Information
            $table->boolean('is_active')
                ->nullable();
                // null = not yet verified
                // false = verified but inactive
                // true = verified and active
            
            $table->timestamps();

            // Foreign Keys
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
