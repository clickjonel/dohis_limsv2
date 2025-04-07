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
        Schema::connection('lims')->create('lims_deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('hashid');
            $table->string('entity_name');
            $table->integer('fund_source');
            $table->string('source_name');
            $table->string('source_address');
            $table->string('iar_no')->unique();
            $table->date('iar_date');
            $table->string('po_no')->nullable();
            $table->date('po_date')->nullable();
            $table->string('ptr_no')->nullable();
            $table->date('ptr_date')->nullable();
            $table->string('bl_no')->nullable();
            $table->date('bl_date')->nullable();
            $table->string('dnf_no')->nullable();
            $table->date('dnf_date')->nullable();
            $table->integer('req_office');
            $table->integer('end_user');
            $table->integer('payment_term');
            $table->integer('completion');
            $table->string('purpose')->nullable();
            $table->string('darts_id')->nullable();
            $table->string('iar_file_path')->nullable();
            $table->timestamps();
        });

        Schema::connection('lims')->create('lims_delivery_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_id');
            $table->string('invoice_no')->nullable();
            $table->date('invoice_date')->nullable();

            $table->foreign('delivery_id')->references('id')->on('lims_deliveries')->onDelete('restrict');
        });

        Schema::connection('lims')->create('lims_delivery_receipts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_id');
            $table->string('dr_no')->nullable();
            $table->date('dr_date')->nullable();
            $table->string('delivery_place')->nullable();
            $table->date('delivery_date')->nullable();

            $table->foreign('delivery_id')->references('id')->on('lims_deliveries')->onDelete('restrict');
        });

        Schema::connection('lims')->create('lims_delivery_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_id');
            $table->integer('availability');
            $table->string('manufacturer')->nullable();
            $table->date(column: 'manufacturing_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->decimal('unit_cost',15,10);
            $table->integer('quantity');
            $table->string('batch_lot_number')->nullable();
            $table->integer('shelf_life')->nullable();
            $table->unsignedBigInteger('measurement_unit');
            $table->text('description');

            $table->foreign('delivery_id')->references('id')->on('lims_deliveries')->onDelete('restrict');
            $table->foreign('measurement_unit')->references('id')->on('lims_measurements')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('lims')->dropIfExists('lims_delivery_items');
        Schema::connection('lims')->dropIfExists('lims_delivery_receipts');
        Schema::connection('lims')->dropIfExists('lims_delivery_invoices');
        Schema::connection('lims')->dropIfExists('lims_deliveries');
    }
};
