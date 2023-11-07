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
        Schema::create('product_data', function (Blueprint $table) {
            $table->id('product_data_id');
            $table->unsignedBigInteger('product_id');
            $table->string('URL', 255);
            $table->string('Loai_URL', 50);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->tinyInteger('row_delete')->default(0);
            $table->foreign('product_id')->references('product_id')->on('product');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_data');
    }
};
