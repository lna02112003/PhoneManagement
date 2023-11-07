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
        Schema::create('product_category', function (Blueprint $table) {
            $table->id('product_category_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('category_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->tinyInteger('row_delete')->default(0);
            $table->foreign('product_id')->references('product_id')->on('product');
            $table->foreign('category_id')->references('category_id')->on('category');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_category');
    }
};
