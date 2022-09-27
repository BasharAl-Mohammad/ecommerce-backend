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
        Schema::create('product_option_value_variant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_option_value_id')->nullable()->constrained('product_option_values');
            $table->foreignId('product_variant_id')->nullable()->constrained('product_variants');
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
        Schema::dropIfExists('product_option_value_variant');
    }
};
