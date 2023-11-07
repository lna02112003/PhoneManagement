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
        Schema::create('order', function (Blueprint $table) {
            $table->id('order_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('payment_id');
            $table->unsignedBigInteger('shipping_id');
            $table->text('description')->nullable();
            $table->string('status', 255);
            $table->date('delivery_date');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->tinyInteger('row_delete')->default(0);
            $table->foreign('customer_id')->references('customer_id')->on('customer');
            $table->foreign('payment_id')->references('payment_id')->on('payment');
            $table->foreign('shipping_id')->references('shipping_id')->on('shipping');
        });
    }

    public function down()
    {
        Schema::dropIfExists('order');
    }
};
