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
        Schema::create('attribute_value', function (Blueprint $table) {
            $table->id('attribute_value_id');
            $table->unsignedBigInteger('attribute_id');
            $table->string('attribute_value_name', 255);
            $table->double('price', 8, 2);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->tinyInteger('row_delete')->default(0);
            $table->foreign('attribute_id')->references('attribute_id')->on('attribute');
        });
    }

    public function down()
    {
        Schema::dropIfExists('attribute_value');
    }
};
