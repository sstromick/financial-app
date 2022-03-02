<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_types', function (Blueprint $table) {
            $table->id();
            $table->string('income_type')->unique();
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->string('swagger_api_type')->nullable();
            $table->string('swagger_api_detail')->nullable();
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
        Schema::dropIfExists('income_types');
    }
}
