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
        Schema::create('product_attribute', function (Blueprint $table) {
            $table->id('product_attribute_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('attribute_id');
            $table->tinyInteger('row_delete')->default(0);
            $table->foreign('product_id')->references('product_id')->on('product');
            $table->foreign('attribute_id')->references('attribute_id')->on('attribute');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_attribute');
    }
};
