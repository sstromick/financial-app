<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained();
            $table->string('expense_type');
            $table->decimal('expense_value');
            $table->unsignedBigInteger('expense_type_id');
            $table->timestamps();
            $table->softDeletes('deleted_at');

            $table->foreign('expense_type_id')->references('id')->on('expense_types')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
