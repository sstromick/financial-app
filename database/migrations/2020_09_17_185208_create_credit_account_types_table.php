<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditAccountTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_account_types', function (Blueprint $table) {
            $table->id();
            $table->string('debt_type')->unique();
            $table->string('swagger_api_category')->nullable();
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
        Schema::dropIfExists('credit_account_types');
    }
}
