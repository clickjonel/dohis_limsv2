<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('lims')->create('lims_properties', function (Blueprint $table) {
            $table->id();
            $table->string('property_no')->unique();
            $table->unsignedBigInteger('measurement_unit');
            $table->text('particulars');
            $table->decimal('unit_cost',15,10);
            $table->string('status')->nullable();//active,wasted,stock,repair
            $table->text('remarks')->nullable();

            $table->foreign('measurement_unit')->references('id')->on('lims_measurements')->onDelete('restrict');
        });

        Schema::connection('lims')->create('property_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->integer('user_id');
            $table->date('issuance_date');
           
            $table->foreign('property_id')->references('id')->on('lims_properties')->onDelete('restrict');
        });

        Schema::connection('lims')->create('property_user_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->integer('user_id');
            $table->date('acquisition_date');
            $table->date('return_date')->nullable();
            $table->text('remarks')->nullable();
           
            $table->foreign('property_id')->references('id')->on('lims_properties')->onDelete('restrict');
        });

        Schema::connection('lims')->create('property_parts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->string('part_name');
            $table->string('remarks')->nullable();
           
            $table->foreign('property_id')->references('id')->on('lims_properties')->onDelete('restrict');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
