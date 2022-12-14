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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained('products');
            // $table->foreignId('product_option_value_id')->nullable()->constrained('product_option_values');
            $table->integer('unit_quantity')->unsigned()->nullable()->index()->default(1);
            $table->string('sku')->nullable()->index();
            $table->string('gtin')->nullable()->index();
            $table->string('mpn')->nullable()->index();
            $table->string('ean')->nullable()->index();
            $table->decimal('length_value')->nullable();
            $table->string('length_unit')->nullable();
            $table->decimal('width_value')->nullable();
            $table->string('width_unit')->nullable();
            $table->decimal('height_value')->nullable();
            $table->string('height_unit')->nullable();
            $table->decimal('weight_value')->nullable();
            $table->string('weight_unit')->nullable();
            $table->decimal('volume_value')->nullable();
            $table->string('volume_unit')->nullable();
            $table->boolean('shippable')->nullable()->default(true)->index();
            $table->integer('stock')->nullable()->default(0)->index();
            $table->integer('backorder')->nullable()->default(0)->index();
            $table->string('purchasable')->nullable()->default('always')->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variants');
    }
};
