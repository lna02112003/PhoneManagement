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
        Schema::create('user', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('firstname', 255);
            $table->string('middlename', 255)->nullable();
            $table->string('lastname', 255);
            $table->string('email', 255)->unique();
            $table->string('img', 255)->nullable();
            $table->string('password', 255);
            $table->tinyInteger('row_delete')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user');
    }
};
