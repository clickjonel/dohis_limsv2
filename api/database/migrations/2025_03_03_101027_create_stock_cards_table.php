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
        Schema::connection('lims')->create('lims_stock_cards', function (Blueprint $table) {
            $table->id();
            $table->string('stock_no');
            $table->string('stock_name');
            $table->string('contract_no');//po,ptr,contract
            $table->string('entity_name')->default('DOH-CHD-CAR');
            $table->string('iar_no');
            $table->string('supplier_name');
            $table->string('supplier_address');
            $table->text(column: 'item_description');
            $table->string('dosage_form')->nullable();
            $table->string('dosage_strength')->nullable();
            $table->unsignedBigInteger('measurement_unit');
            $table->decimal('unit_cost');
            $table->integer('procurement_mode');
            $table->integer('fund_cluster')->default(1);
            $table->integer('req_office');
            $table->integer('quantity');
            $table->unsignedBigInteger('warehouse');
            $table->string('batch_no')->nullable();
            $table->date('expiry_date')->nullable();
            $table->integer('category')->nullable();

            $table->foreign('measurement_unit')->references('id')->on('lims_measurements')->onDelete('restrict');
            $table->foreign('warehouse')->references('id')->on('lims_warehouses')->onDelete('restrict');
        });

        Schema::connection('lims')->create('lims_stock_card_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_card_id');
            $table->date('transaction_date');
            $table->bigInteger('received')->nullable();
            $table->bigInteger('issued')->nullable();
            $table->bigInteger('balance');
            $table->decimal('total_cost');
            $table->string('ptr_no')->nullable();
            $table->string('iar_no')->nullable();
            $table->string('recepient')->nullable();
            $table->string('remarks')->nullable();

            $table->foreign('stock_card_id')->references('id')->on('lims_stock_cards')->onDelete('restrict');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lims_stock_cards');
    }
};
